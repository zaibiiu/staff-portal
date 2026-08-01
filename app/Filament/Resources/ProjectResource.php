<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProjectResource\Pages;
use App\Filament\Resources\ProjectResource\RelationManagers;
use App\Models\Project;
use BackedEnum;
use Filament\Forms;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Tables;
use Filament\Tables\Table;
use UnitEnum;

class ProjectResource extends Resource
{
    protected static ?string $model = Project::class;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-briefcase';

    protected static string|UnitEnum|null $navigationGroup = 'Project Management';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\Section::make('Project Details')
                    ->schema([
                        Forms\Components\TextInput::make('name')
                            ->required()
                            ->maxLength(255)
                            ->columnSpanFull(),
                        Forms\Components\Textarea::make('description')
                            ->rows(4)
                            ->columnSpanFull(),
                        Forms\Components\DatePicker::make('start_date')
                            ->default(now()),
                        Forms\Components\DatePicker::make('deadline'),
                        Forms\Components\Select::make('stage')
                            ->options([
                                'pending' => 'Pending',
                                'planning' => 'Planning',
                                'in_progress' => 'In Progress',
                                'review' => 'Review',
                                'completed' => 'Completed',
                            ])
                            ->default('pending')
                            ->required(),
                        Forms\Components\Select::make('status')
                            ->options([
                                'active' => 'Active',
                                'on_hold' => 'On Hold',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                            ])
                            ->default('active')
                            ->required(),
                    ])->columns(2),

                Forms\Components\Section::make('Team Members')
                    ->schema([
                        Forms\Components\Select::make('users')
                            ->relationship('users', 'name')
                            ->multiple()
                            ->searchable()
                            ->preload()
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->limit(30),
                Tables\Columns\BadgeColumn::make('stage')
                    ->colors([
                        'secondary' => 'pending',
                        'info' => 'planning',
                        'primary' => 'in_progress',
                        'warning' => 'review',
                        'success' => 'completed',
                    ]),
                Tables\Columns\BadgeColumn::make('status')
                    ->colors([
                        'success' => 'active',
                        'warning' => 'on_hold',
                        'primary' => 'completed',
                        'danger' => 'cancelled',
                    ]),
                Tables\Columns\TextColumn::make('users_count')
                    ->label('Team Size')
                    ->counts('users')
                    ->sortable(),
                Tables\Columns\TextColumn::make('tasks_count')
                    ->label('Tasks')
                    ->counts('tasks')
                    ->sortable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable()
                    ->toggleable(),
                Tables\Columns\TextColumn::make('deadline')
                    ->date()
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('stage')
                    ->options([
                        'pending' => 'Pending',
                        'planning' => 'Planning',
                        'in_progress' => 'In Progress',
                        'review' => 'Review',
                        'completed' => 'Completed',
                    ]),
                Tables\Filters\SelectFilter::make('status')
                    ->options([
                        'active' => 'Active',
                        'on_hold' => 'On Hold',
                        'completed' => 'Completed',
                        'cancelled' => 'Cancelled',
                    ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\TasksRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProjects::route('/'),
            'create' => Pages\CreateProject::route('/create'),
            'edit' => Pages\EditProject::route('/{record}/edit'),
        ];
    }
}
