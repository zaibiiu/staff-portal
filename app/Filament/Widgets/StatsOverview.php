<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected function getStats(): array
    {
        $totalStaff = User::where('role', 'staff')->count();
        $activeStaff = User::where('role', 'staff')->where('is_active', true)->count();
        $totalProjects = Project::count();
        $activeProjects = Project::where('status', 'active')->count();
        $pendingTasks = Task::where('status', 'pending')->count();
        $completedTasks = Task::where('status', 'completed')->count();
        $todayPresent = Attendance::where('date', today())
            ->where('status', 'present')
            ->count();

        return [
            Stat::make('Total Staff', $totalStaff)
                ->description('Active: ' . $activeStaff)
                ->descriptionIcon('heroicon-m-users')
                ->color('success')
                ->chart([7, 12, 18, 22, 28, 35, $totalStaff]),
            
            Stat::make('Total Projects', $totalProjects)
                ->description('Active: ' . $activeProjects)
                ->descriptionIcon('heroicon-m-briefcase')
                ->color('primary')
                ->chart([2, 5, 8, 12, 15, 18, $totalProjects]),
            
            Stat::make('Pending Tasks', $pendingTasks)
                ->description('Completed: ' . $completedTasks)
                ->descriptionIcon('heroicon-m-clipboard-document-list')
                ->color('warning')
                ->chart([15, 12, 18, 10, 15, 12, $pendingTasks]),
            
            Stat::make('Today\'s Attendance', $todayPresent)
                ->description('Present today')
                ->descriptionIcon('heroicon-m-check-circle')
                ->color('success'),
        ];
    }
}
