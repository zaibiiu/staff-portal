<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentTasksWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Task::query()
                    ->with(['user', 'project'])
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->limit(30),
                TextColumn::make('user.name')
                    ->label('Assigned To'),
                TextColumn::make('project.name')
                    ->default('N/A'),
                BadgeColumn::make('priority')
                    ->colors([
                        'success' => 'low',
                        'primary' => 'medium',
                        'warning' => 'high',
                        'danger' => 'urgent',
                    ]),
                BadgeColumn::make('status')
                    ->colors([
                        'warning' => 'pending',
                        'primary' => 'in_progress',
                        'success' => 'completed',
                    ]),
                TextColumn::make('due_date')
                    ->date(),
            ]);
    }
}
