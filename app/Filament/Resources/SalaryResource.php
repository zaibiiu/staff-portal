<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SalaryResource\Pages;
use App\Models\Salary;
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

class SalaryResource extends Resource
{
    protected static ?string $model = Salary::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-banknotes';

    protected static ?string $navigationLabel = 'Salary Management';

    protected static string|UnitEnum|null $navigationGroup = 'Staff';

    protected static ?int $navigationSort = 2;

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
                            ->disabled(fn ($livewire) => $livewire instanceof Pages\CreateSalary && request()->has('user'))
                            ->default(fn () => request()->get('user')),
                            
                        Forms\Components\TextInput::make('amount')
                            ->label('Salary Amount')
                            ->required()
                            ->numeric()
                            ->prefix('PKR')
                            ->minValue(0)
                            ->maxValue(9999999999.99)
                            ->step(0.01)
                            ->helperText('Enter salary amount in PKR'),
                            
                        Forms\Components\DatePicker::make('effective_date')
                            ->label('Effective Date')
                            ->required()
                            ->maxDate(now()->addYear())
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->default(now())
                            ->helperText('Date when this salary becomes effective'),
                            
                        Forms\Components\DatePicker::make('end_date')
                            ->label('End Date')
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->after('effective_date')
                            ->helperText('Optional: Date when this salary ends'),
                            
                        Forms\Components\Toggle::make('is_current')
                            ->label('Current Salary')
                            ->default(true)
                            ->helperText('Mark as current active salary'),
                            
                        Forms\Components\Textarea::make('remarks')
                            ->label('Remarks')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull()
                            ->helperText('Optional notes about this salary entry'),
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
                    ->sortable(),
                Tables\Columns\TextColumn::make('amount')
                    ->money('PKR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('effective_date')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date('d M Y')
                    ->sortable()
                    ->placeholder('N/A'),
                Tables\Columns\IconColumn::make('is_current')
                    ->label('Current')
                    ->boolean()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('effective_date', 'desc')
            ->filters([
                Tables\Filters\TernaryFilter::make('is_current')
                    ->label('Current Salary'),
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
            'index' => Pages\ListSalaries::route('/'),
            'create' => Pages\CreateSalary::route('/create'),
            'edit' => Pages\EditSalary::route('/{record}/edit'),
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
