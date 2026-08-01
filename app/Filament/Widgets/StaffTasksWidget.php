<?php

namespace App\Filament\Widgets;

use App\Models\Task;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Tables;
use Filament\Tables\Table;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Support\Facades\Auth;

class StaffTasksWidget extends BaseWidget
{
    protected int | string | array $columnSpan = 'full';

    protected static ?int $sort = 2;

    public function table(Table $table): Table
    {
        return $table
            ->query(
                Task::query()
                    ->where('user_id', Auth::id())
                    ->with('project')
                    ->latest()
                    ->limit(10)
            )
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->limit(40),
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
                    ->date()
                    ->sortable(),
            ])
            ->actions([
                Action::make('update_status')
                    ->label('Update Status')
                    ->icon('heroicon-o-pencil-square')
                    ->form([
                        Select::make('status')
                            ->options([
                                'pending' => 'Pending',
                                'in_progress' => 'In Progress',
                                'completed' => 'Completed',
                            ])
                            ->required(),
                    ])
                    ->action(function (Task $record, array $data): void {
                        $record->update(['status' => $data['status']]);
                    }),
            ]);
    }
}
