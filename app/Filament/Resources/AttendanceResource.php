<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AttendanceResource\Pages;
use App\Models\Attendance;
use Filament\Actions\Action;
use BackedEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Schemas\Components\Section;
use Filament\Tables\Columns\ImageColumn;

class AttendanceResource extends Resource
{
    protected static ?string $model = Attendance::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationLabel = 'Attendance';

    protected static string|UnitEnum|null $navigationGroup = 'Staff';

    protected static ?int $navigationSort = 6;

    protected static bool $shouldRegisterNavigation = false; // Hidden from main nav

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Section::make()
                    ->schema([
                        Forms\Components\Select::make('user_id')
                            ->label('Staff Member')
                            ->relationship('user', 'name', fn (Builder $query) => $query->where('role', 'staff'))
                            ->searchable()
                            ->preload()
                            ->required()
                            ->disabled(fn ($livewire) => $livewire instanceof Pages\CreateAttendance && request()->has('user'))
                            ->default(fn () => request()->get('user')),
                            
                        Forms\Components\DatePicker::make('date')
                            ->label('Attendance Date')
                            ->required()
                            ->maxDate(now())
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->default(now())
                            ->unique(ignoreRecord: true)
                            ->helperText('Date of attendance record'),
                            
                        Forms\Components\Select::make('status')
                            ->label('Attendance Status')
                            ->options([
                                'present' => 'Present',
                                'absent' => 'Absent',
                                'leave' => 'Leave',
                                'late' => 'Late',
                            ])
                            ->default('present')
                            ->required()
                            ->native(false),
                            
                        Forms\Components\TimePicker::make('check_in')
                            ->label('Check In Time')
                            ->seconds(false)
                            ->native(false)
                            ->helperText('Format: HH:MM'),
                            
                        Forms\Components\TimePicker::make('check_out')
                            ->label('Check Out Time')
                            ->seconds(false)
                            ->native(false)
                            ->after('check_in')
                            ->helperText('Must be after check-in time'),
                            
                        Forms\Components\Textarea::make('remarks')
                            ->label('Remarks')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull()
                            ->helperText('Optional notes about this attendance'),
                        
                        Section::make('Location & Selfie')
                            ->schema([
                                Forms\Components\TextInput::make('attendance_source')
                                    ->label('Attendance Source')
                                    ->disabled()
                                    ->formatStateUsing(fn ($state) => $state === 'self' ? 'Staff Self-Attendance' : 'Admin Created'),
                                Forms\Components\TextInput::make('latitude')
                                    ->label('Latitude')
                                    ->disabled()
                                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 8) : 'N/A'),
                                Forms\Components\TextInput::make('longitude')
                                    ->label('Longitude')
                                    ->disabled()
                                    ->formatStateUsing(fn ($state) => $state ? number_format($state, 8) : 'N/A')
                                    ->suffixAction(
                                        Action::make('openMaps')
                                            ->icon('heroicon-o-map')
                                            ->url(fn ($record) => $record->latitude && $record->longitude 
                                                ? "https://maps.google.com/?q={$record->latitude},{$record->longitude}" 
                                                : null)
                                            ->openUrlInNewTab()
                                            ->disabled(fn ($record) => !$record->latitude || !$record->longitude)
                                    ),
                                Forms\Components\FileUpload::make('selfie')
                                    ->label('Selfie')
                                    ->image()
                                    ->disabled()
                                    ->directory('attendance-selfies')
                                    ->visibility('public')
                                    ->downloadable(),
                            ])
                            ->columns(2),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Staff Member')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: request()->has('user')),
                Tables\Columns\TextColumn::make('date')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'present' => 'Present',
                        'absent' => 'Absent',
                        'leave' => 'Leave',
                        'late' => 'Late',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'present' => 'success',
                        'absent' => 'danger',
                        'leave' => 'warning',
                        'late' => 'primary',
                        default => 'gray',
                    }),
                Tables\Columns\TextColumn::make('check_in')
                    ->formatStateUsing(fn ($state) => $state ? \Carbon\Carbon::parse($state)->format('H:i') : 'N/A'),
                Tables\Columns\TextColumn::make('check_out')
                    ->formatStateUsing(fn ($state) => $state ? \Carbon\Carbon::parse($state)->format('H:i') : 'N/A'),
                Tables\Columns\ImageColumn::make('selfie')
                    ->label('Selfie')
                    ->circular()
                    ->size(40)
                    ->toggleable(),
                Tables\Columns\TextColumn::make('latitude')
                    ->label('GPS Location')
                    ->formatStateUsing(fn ($state, $record) => $state && $record->longitude 
                        ? sprintf('%.6f, %.6f', $state, $record->longitude) 
                        : 'N/A')
                    ->url(fn ($record) => $record->latitude && $record->longitude 
                        ? "https://maps.google.com/?q={$record->latitude},{$record->longitude}" 
                        : null)
                    ->openUrlInNewTab()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('attendance_source')
                    ->label('Source')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'self' => 'Self',
                        'admin' => 'Admin',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'self' => 'success',
                        'admin' => 'info',
                        default => 'gray',
                    })
                    ->toggleable(),
                Tables\Columns\TextColumn::make('remarks')
                    ->limit(30)
                    ->toggleable(),
            ])
            ->defaultSort('date', 'desc')
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'present' => 'Present',
                        'absent' => 'Absent',
                        'leave' => 'Leave',
                        'late' => 'Late',
                    ]),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->headerActions([
                Action::make('cleanupSelfies')
                    ->label('Cleanup Old Selfies')
                    ->icon('heroicon-o-trash')
                    ->color('warning')
                    ->requiresConfirmation()
                    ->modalHeading('Cleanup Old Attendance Selfies')
                    ->modalDescription('This will delete all attendance selfie images older than 14 days. Attendance records will be kept. This action cannot be undone.')
                    ->modalSubmitActionLabel('Yes, Delete Old Selfies')
                    ->action(function () {
                        $cleanupService = new \App\Services\AttendanceSelfieCleanupService();
                        $result = $cleanupService->cleanupOldSelfies(14);
                        
                        \Filament\Notifications\Notification::make()
                            ->title('Selfie Cleanup Completed')
                            ->body("Deleted: {$result['deleted_count']} selfies, Failed: {$result['failed_count']}")
                            ->success()
                            ->send();
                    }),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListAttendances::route('/'),
            'create' => Pages\CreateAttendance::route('/create'),
            'edit' => Pages\EditAttendance::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        
        // Scope to specific user if provided
        if (request()->has('user')) {
            $query->where('user_id', request()->get('user'));
        }
        
        return $query;
    }
}
