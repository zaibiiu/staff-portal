<x-filament-panels::page>
    @if(auth()->user()->isAdmin())
        @include('filament.components.dashboard.admin-dashboard', [
            'totalStaff'         => $totalStaff,
            'activeStaff'        => $activeStaff,
            'totalDepartments'   => $totalDepartments,
            'activeProjects'     => $activeProjects,
            'pendingTasks'       => $pendingTasks,
            'completedTasks'     => $completedTasks,
            'todayAttendance'    => $todayAttendance,
            'inProgressTasks'    => $inProgressTasks,
            'monthlySalaryCost'  => $monthlySalaryCost,
            'recentTasks'        => $recentTasks
        ])
    @else
        @include('filament.components.dashboard.staff-dashboard', [
            'myProjects'         => $myProjects,
            'myPendingTasks'     => $myPendingTasks,
            'myCompletedTasks'   => $myCompletedTasks,
            'currentSalary'      => $currentSalary,
            'myTasks'            => $myTasks
        ])
    @endif
</x-filament-panels::page>
