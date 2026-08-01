<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;

class AttendancesRelationManager extends RelationManager
{
    protected static string $relationship = 'attendances';

    protected static ?string $title = 'Attendance';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\DatePicker::make('date')
                    ->required()
                    ->default(now())
                    ->unique(ignoreRecord: true),
                Forms\Components\Select::make('status')
                    ->options([
                        'present' => 'Present',
                        'absent' => 'Absent',
                        'leave' => 'Leave',
                        'late' => 'Late',
                    ])
                    ->default('present')
                    ->required(),
                Forms\Components\TimePicker::make('check_in')
                    ->seconds(false),
                Forms\Components\TimePicker::make('check_out')
                    ->seconds(false),
                Forms\Components\Textarea::make('remarks')
                    ->rows(3)
                    ->columnSpanFull(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('date')
                    ->date()
                    ->sortable(),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'present',
                        'danger' => 'absent',
                        'warning' => 'leave',
                        'primary' => 'late',
                    ]),
                Tables\Columns\TextColumn::make('check_in')
                    ->time()
                    ->default('N/A'),
                Tables\Columns\TextColumn::make('check_out')
                    ->time()
                    ->default('N/A'),
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
