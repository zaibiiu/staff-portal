<?php

namespace App\Filament\Pages;

use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    public function getWidgets(): array
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return [
                \App\Filament\Widgets\StatsOverview::class,
                \App\Filament\Widgets\RecentTasksWidget::class,
            ];
        }

        // Staff Dashboard Widgets
        return [
            \App\Filament\Widgets\StaffStatsWidget::class,
            \App\Filament\Widgets\StaffTasksWidget::class,
        ];
    }
}
