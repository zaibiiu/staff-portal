<?php

namespace App\Filament\Widgets;

use App\Models\Commission;
use App\Models\Task;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StaffStatsWidget extends BaseWidget
{
    protected static ?int $sort = 1;
    
    protected function getStats(): array
    {
        $user = Auth::user();

        $myPendingTasks = Task::where('user_id', $user->id)
            ->where('status', 'pending')
            ->count();

        $myInProgressTasks = Task::where('user_id', $user->id)
            ->where('status', 'in_progress')
            ->count();

        $myCompletedTasks = Task::where('user_id', $user->id)
            ->where('status', 'completed')
            ->count();

        $currentSalary = $user->currentSalary?->amount ?? 0;

        $totalCommission = Commission::where('user_id', $user->id)
            ->sum('amount');

        $myProjects = $user->projects()->count();

        return [
            Stat::make('My Projects', $myProjects)
                ->description('Active projects')
                ->descriptionIcon('heroicon-m-briefcase', IconPosition::Before)
                ->color('primary')
                ->extraAttributes([
                    'class' => 'transition hover:scale-105',
                ]),

            Stat::make('Pending Tasks', $myPendingTasks)
                ->description("{$myInProgressTasks} in progress")
                ->descriptionIcon('heroicon-m-clock', IconPosition::Before)
                ->color('warning')
                ->extraAttributes([
                    'class' => 'transition hover:scale-105',
                ]),

            Stat::make('Completed', $myCompletedTasks)
                ->description('Total completed')
                ->descriptionIcon('heroicon-m-check-circle', IconPosition::Before)
                ->color('success')
                ->extraAttributes([
                    'class' => 'transition hover:scale-105',
                ]),

            Stat::make('Monthly Salary', 'PKR ' . number_format($currentSalary, 0))
                ->description('Current salary')
                ->descriptionIcon('heroicon-m-currency-dollar', IconPosition::Before)
                ->color('info')
                ->extraAttributes([
                    'class' => 'transition hover:scale-105',
                ]),

            Stat::make('Commissions', 'PKR ' . number_format($totalCommission, 0))
                ->description('Total earned')
                ->descriptionIcon('heroicon-m-banknotes', IconPosition::Before)
                ->color('success')
                ->extraAttributes([
                    'class' => 'transition hover:scale-105',
                ]),
        ];
    }
}
