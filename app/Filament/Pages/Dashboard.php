<?php

namespace App\Filament\Pages;

use App\Filament\Widgets\StaffStatsWidget;
use App\Filament\Widgets\StaffTasksWidget;
use App\Filament\Widgets\StatsOverview;
use App\Filament\Widgets\RecentTasksWidget;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return [
                StatsOverview::class,
                RecentTasksWidget::class,
            ];
        }

        return [
            StaffStatsWidget::class,
            StaffTasksWidget::class,
        ];
    }
    
    public function getColumns(): int | array
    {
        return 2;
    }
}
