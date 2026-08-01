<?php

namespace App\Filament\Widgets;

use App\Models\Commission;
use App\Models\Task;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Support\Facades\Auth;

class StaffStatsWidget extends BaseWidget
{
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
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('primary'),

            Stat::make('Pending Tasks', $myPendingTasks)
                ->description('In Progress: ' . $myInProgressTasks)
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('warning'),

            Stat::make('Completed Tasks', $myCompletedTasks)
                ->description('Total completed')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),

            Stat::make('Current Salary', 'PKR ' . number_format($currentSalary, 2))
                ->description('Monthly salary')
                ->descriptionIcon('heroicon-m-currency-dollar')
                ->color('info'),

            Stat::make('Total Commission', 'PKR ' . number_format($totalCommission, 2))
                ->description('All time commission')
                ->descriptionIcon('heroicon-m-banknotes')
                ->color('success'),
        ];
    }
}
