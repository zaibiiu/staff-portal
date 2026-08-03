<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CommissionResource\Pages;
use App\Models\Commission;
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

class CommissionResource extends Resource
{
    protected static ?string $model = Commission::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-currency-dollar';

    protected static ?string $navigationLabel = 'Commissions';

    protected static string|UnitEnum|null $navigationGroup = 'Staff';

    protected static ?int $navigationSort = 5;

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
                            ->disabled(fn ($livewire) => $livewire instanceof Pages\CreateCommission && request()->has('user'))
                            ->default(fn () => request()->get('user')),
                            
                        Forms\Components\TextInput::make('amount')
                            ->label('Commission Amount')
                            ->required()
                            ->numeric()
                            ->prefix('PKR')
                            ->minValue(0)
                            ->maxValue(9999999999.99)
                            ->step(0.01)
                            ->helperText('Enter commission amount in PKR'),
                            
                        Forms\Components\DatePicker::make('commission_date')
                            ->label('Commission Date')
                            ->required()
                            ->maxDate(now())
                            ->native(false)
                            ->displayFormat('d/m/Y')
                            ->default(now())
                            ->helperText('Date when commission was earned'),
                            
                        Forms\Components\TextInput::make('commission_month')
                            ->label('Commission Month')
                            ->required()
                            ->placeholder('e.g., January 2024')
                            ->maxLength(50)
                            ->regex('/^[A-Za-z]+\s\d{4}$/')
                            ->helperText('Format: Month YYYY (e.g., January 2024)'),
                            
                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->rows(3)
                            ->maxLength(500)
                            ->columnSpanFull()
                            ->helperText('Optional: Details about this commission'),
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
                Tables\Columns\TextColumn::make('amount')
                    ->money('PKR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('commission_month')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('commission_date')
                    ->date('d M Y')
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(30)
                    ->toggleable(),
            ])
            ->defaultSort('commission_date', 'desc')
            ->filters([
                //
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
            'index' => Pages\ListCommissions::route('/'),
            'create' => Pages\CreateCommission::route('/create'),
            'edit' => Pages\EditCommission::route('/{record}/edit'),
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
