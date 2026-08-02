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

class SalariesRelationManager extends RelationManager
{
    protected static string $relationship = 'salaries';

    protected static ?string $title = 'Salary History';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('amount')
                    ->required()
                    ->numeric()
                    ->prefix('PKR')
                    ->maxValue(9999999999.99),
                Forms\Components\DatePicker::make('effective_date')
                    ->required()
                    ->default(now()),
                Forms\Components\DatePicker::make('end_date')
                    ->after('effective_date'),
                Forms\Components\Toggle::make('is_current')
                    ->label('Current Salary')
                    ->default(true),
                Forms\Components\Textarea::make('remarks')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('amount')
                    ->money('PKR')
                    ->sortable(),
                Tables\Columns\TextColumn::make('effective_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
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
