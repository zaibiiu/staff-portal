<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Widgets\TableWidget as BaseWidget;

class RecentTasksWidget extends BaseWidget
{
    protected static ?int $sort = 2;
    
    protected int | string | array $columnSpan = 'full';

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Task::query()
                    ->with(['user', 'project'])
                    ->latest()
                    ->limit(10)
            )
            ->heading('Recent Tasks')
            ->description('Latest task assignments across all projects')
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->limit(30),
                TextColumn::make('user.name')
                    ->label('Assigned To'),
                TextColumn::make('project.name')
                    ->default('N/A'),
                TextColumn::make('priority')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'low' => 'success',
                        'medium' => 'primary',
                        'high' => 'warning',
                        'urgent' => 'danger',
                        default => 'gray',
                    }),
                TextColumn::make('status')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'pending' => 'warning',
                        'in_progress' => 'primary',
                        'completed' => 'success',
                        default => 'gray',
                    }),
                TextColumn::make('due_date')
                    ->date(),
            ]);
    }
}
