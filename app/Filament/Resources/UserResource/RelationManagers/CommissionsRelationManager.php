<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\CreateAction;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;

class CommissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'commissions';

    protected static ?string $title = 'Commissions';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
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
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('amount')
                    ->money('PKR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('commission_month')
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('commission_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('description')
                    ->limit(30)
                    ->toggleable(),
            ])
            ->defaultSort('commission_date', 'desc')
            ->filters([
                //
            ])
            ->headerActions([
                CreateAction::make(),
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
}
