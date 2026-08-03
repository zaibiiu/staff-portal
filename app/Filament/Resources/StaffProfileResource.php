<?php

namespace App\Filament\Resources;

use App\Filament\Resources\StaffProfileResource\Pages;
use App\Models\StaffProfile;
use App\Models\User;
use BackedEnum;
use Filament\Actions\DeleteAction;
use Filament\Actions\EditAction;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use UnitEnum;
use Filament\Schemas\Components\Section;

class StaffProfileResource extends Resource
{
    protected static ?string $model = StaffProfile::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-identification';

    protected static ?string $navigationLabel = 'Staff Profiles';

    protected static string|UnitEnum|null $navigationGroup = 'Staff';

    protected static ?int $navigationSort = 1;

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
                            ->disabled(fn ($livewire) => $livewire instanceof Pages\CreateStaffProfile && request()->has('user'))
                            ->default(fn () => request()->get('user')),
                            
                        Forms\Components\TextInput::make('employee_id')
                            ->label('Employee ID')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(50)
                            ->alphaDash()
                            ->helperText('Alphanumeric characters, dashes and underscores only'),
                            
                        Forms\Components\FileUpload::make('profile_photo')
                            ->label('Profile Photo')
                            ->image()
                            ->disk('public')
                            ->directory('profile-photos')
                            ->visibility('public')
                            ->imageEditor()
                            ->circleCropper()
                            ->uploadingMessage('Uploading photo...')
                            ->imagePreviewHeight('100')
                            ->maxSize(2048)
                            ->acceptedFileTypes(['image/jpeg', 'image/png', 'image/jpg'])
                            ->helperText('Maximum 2MB. Accepted formats: JPG, PNG'),
                            
                        Forms\Components\TextInput::make('phone')
                            ->label('Phone')
                            ->tel()
                            ->required()
                            ->regex('/^[0-9+\-\s()]+$/')
                            ->minLength(10)
                            ->maxLength(20)
                            ->helperText('Format: +92-XXX-XXXXXXX or 03XXXXXXXXX'),
                            
                        Forms\Components\Textarea::make('address')
                            ->label('Address')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull(),
                            
                        Forms\Components\TextInput::make('cnic')
                            ->label('CNIC')
                            ->required()
                            ->regex('/^\d{5}-\d{7}-\d{1}$/')
                            ->placeholder('XXXXX-XXXXXXX-X')
                            ->helperText('Format: XXXXX-XXXXXXX-X (13 digits with dashes)')
                            ->maxLength(15),
                            
                        Forms\Components\DatePicker::make('date_of_birth')
                            ->label('Date of Birth')
                            ->required()
                            ->maxDate(now())
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->helperText('Select date of birth'),
                            
                        Forms\Components\TextInput::make('emergency_contact_name')
                            ->label('Emergency Contact Name')
                            ->required()
                            ->maxLength(255)
                            ->regex('/^[a-zA-Z\s]+$/')
                            ->helperText('Letters and spaces only'),
                            
                        Forms\Components\TextInput::make('emergency_contact')
                            ->label('Emergency Contact Phone')
                            ->tel()
                            ->required()
                            ->regex('/^[0-9+\-\s()]+$/')
                            ->minLength(10)
                            ->maxLength(20)
                            ->helperText('Valid phone number'),
                            
                        Forms\Components\Select::make('department_id')
                            ->label('Department')
                            ->relationship('department', 'name')
                            ->required()
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\TextInput::make('name')
                                    ->required()
                                    ->unique()
                                    ->maxLength(255),
                                Forms\Components\Textarea::make('description')
                                    ->rows(3)
                                    ->maxLength(500),
                            ]),
                            
                        Forms\Components\TextInput::make('designation')
                            ->label('Designation')
                            ->required()
                            ->maxLength(255)
                            ->helperText('Job title/position'),
                            
                        Forms\Components\DatePicker::make('joining_date')
                            ->label('Joining Date')
                            ->required()
                            ->maxDate(now())
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->default(now()),
                            
                        Forms\Components\Select::make('employment_status')
                            ->label('Employment Status')
                            ->options([
                                'active' => 'Active',
                                'inactive' => 'Inactive',
                                'on_leave' => 'On Leave',
                                'terminated' => 'Terminated',
                            ])
                            ->default('active')
                            ->required()
                            ->native(false),
                            
                        Forms\Components\Textarea::make('notes')
                            ->label('Notes')
                            ->rows(3)
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ])
                    ->columns(2),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('profile_photo')
                    ->circular()
                    ->disk('public'),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('Staff Member')
                    ->searchable()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: request()->has('user')),
                Tables\Columns\TextColumn::make('employee_id')
                    ->label('Employee ID')
                    ->searchable(),
                Tables\Columns\TextColumn::make('department.name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('designation')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone'),
                Tables\Columns\TextColumn::make('employment_status')
                    ->badge()
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'active' => 'Active',
                        'on_leave' => 'On Leave',
                        'inactive' => 'Inactive',
                        'terminated' => 'Terminated',
                        default => ucfirst($state),
                    })
                    ->color(fn (string $state): string => match ($state) {
                        'active' => 'success',
                        'on_leave' => 'warning',
                        'inactive' => 'danger',
                        'terminated' => 'danger',
                        default => 'gray',
                    }),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('employment_status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                        'on_leave' => 'On Leave',
                        'terminated' => 'Terminated',
                    ]),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
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
            'index' => Pages\ListStaffProfiles::route('/'),
            'create' => Pages\CreateStaffProfile::route('/create'),
            'edit' => Pages\EditStaffProfile::route('/{record}/edit'),
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
