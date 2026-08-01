<?php

namespace App\Filament\Widgets;

use App\Models\Attendance;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class StatsOverview extends BaseWidget
{
    protected static ?int $sort = 1;
    
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
                ->description("{$activeStaff} active staff members")
                ->descriptionIcon('heroicon-m-arrow-trending-up', IconPosition::Before)
                ->chart([7, 12, 18, 22, 28, 35, $totalStaff])
                ->color('success')
                ->extraAttributes([
                    'class' => 'cursor-pointer transition hover:scale-105',
                ]),
            
            Stat::make('Projects', $totalProjects)
                ->description("{$activeProjects} active projects")
                ->descriptionIcon('heroicon-m-arrow-trending-up', IconPosition::Before)
                ->chart([2, 5, 8, 12, 15, 18, $totalProjects])
                ->color('primary')
                ->extraAttributes([
                    'class' => 'cursor-pointer transition hover:scale-105',
                ]),
            
            Stat::make('Pending Tasks', $pendingTasks)
                ->description("{$completedTasks} completed")
                ->descriptionIcon('heroicon-m-check-circle', IconPosition::Before)
                ->chart([15, 12, 18, 10, 15, 12, $pendingTasks])
                ->color('warning')
                ->extraAttributes([
                    'class' => 'cursor-pointer transition hover:scale-105',
                ]),
            
            Stat::make('Today\'s Attendance', $todayPresent)
                ->description('Present today')
                ->descriptionIcon('heroicon-m-user-group', IconPosition::Before)
                ->color('info')
                ->extraAttributes([
                    'class' => 'cursor-pointer transition hover:scale-105',
                ]),
        ];
    }
}
