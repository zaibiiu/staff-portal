<?php

namespace App\Filament\Pages;

use App\Models\Task;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Pages\Page;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\BadgeColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use UnitEnum;

class MyTasks extends Page implements HasTable
{
    use InteractsWithTable;

    protected static string|BackedEnum|null $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static string|View|null $view = 'filament.pages.my-tasks';

    protected static string|UnitEnum|null $navigationGroup = 'My Portal';

    public function table(Table $table): Table
    {
        return $table
            ->query(Task::query()->where('user_id', Auth::id()))
            ->columns([
                TextColumn::make('title')
                    ->searchable()
                    ->limit(40)
                    ->sortable(),
                TextColumn::make('project.name')
                    ->default('N/A')
                    ->searchable(),
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
            ->defaultSort('created_at', 'desc')
            ->filters([
                SelectFilter::make('status')
                    ->options([
                        'pending' => 'Pending',
                        'in_progress' => 'In Progress',
                        'completed' => 'Completed',
                    ]),
                SelectFilter::make('priority')
                    ->options([
                        'low' => 'Low',
                        'medium' => 'Medium',
                        'high' => 'High',
                        'urgent' => 'Urgent',
                    ]),
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
                        Notification::make()
                            ->success()
                            ->title('Task status updated')
                            ->send();
                    }),
            ]);
    }

    public static function shouldRegisterNavigation(): bool
    {
        return Auth::user()->isStaff();
    }
}
