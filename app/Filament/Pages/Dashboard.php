<?php

namespace App\Filament\Pages;

use App\Models\Attendance;
use App\Models\Department;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Filament\Pages\Dashboard as BaseDashboard;

class Dashboard extends BaseDashboard
{
    protected string $view = 'filament.pages.dashboard';

    public function getViewData(): array
    {
        $user = auth()->user();

        if ($user->isAdmin()) {
            return [
                'totalStaff' => User::where('role', 'staff')->count(),
                'activeStaff' => User::where('role', 'staff')->where('is_active', true)->count(),
                'totalDepartments' => Department::where('is_active', true)->count(),
                'activeProjects' => Project::where('status', 'active')->count(),
                'pendingTasks' => Task::where('status', 'pending')->count(),
                'inProgressTasks' => Task::where('status', 'in_progress')->count(),
                'completedTasks' => Task::where('status', 'completed')->count(),
                'todayAttendance' => Attendance::where('date', today())->where('status', 'present')->count(),
                'monthlySalaryCost' => User::where('role', 'staff')
                    ->with('currentSalary')
                    ->get()
                    ->sum(fn($user) => $user->currentSalary?->amount ?? 0),
                'recentProjects' => Project::with('users')->latest()->limit(5)->get(),
                'recentTasks' => Task::with(['user', 'project'])->latest()->limit(8)->get(),
                'recentActivity' => $this->getRecentActivity(),
                'projectsByStatus' => Project::selectRaw('status, COUNT(*) as count')->groupBy('status')->get(),
                'tasksByStatus' => Task::selectRaw('status, COUNT(*) as count')->groupBy('status')->get(),
                'attendanceStats' => $this->getAttendanceStats(),
            ];
        }

        return [
            'myProjects' => $user->projects()->count(),
            'myPendingTasks' => Task::where('user_id', $user->id)->where('status', 'pending')->count(),
            'myInProgressTasks' => Task::where('user_id', $user->id)->where('status', 'in_progress')->count(),
            'myCompletedTasks' => Task::where('user_id', $user->id)->where('status', 'completed')->count(),
            'currentSalary' => $user->currentSalary?->amount ?? 0,
            'myTasks' => Task::where('user_id', $user->id)->with('project')->latest()->limit(6)->get(),
            'myRecentActivity' => $this->getStaffRecentActivity($user->id),
        ];
    }

    protected function getRecentActivity(): array
    {
        $activities = [];

        // Recent tasks created
        Task::latest()->limit(5)->get()->each(function ($task) use (&$activities) {
            $activities[] = [
                'type' => 'task',
                'title' => "New task assigned: {$task->title}",
                'subtitle' => "Assigned to {$task->user->name}",
                'time' => $task->created_at->diffForHumans(),
                'icon' => 'clipboard-document-check',
                'color' => 'blue',
            ];
        });

        // Recent attendances
        Attendance::where('date', today())->latest()->limit(3)->get()->each(function ($attendance) use (&$activities) {
            $activities[] = [
                'type' => 'attendance',
                'title' => "{$attendance->user->name} marked {$attendance->status}",
                'subtitle' => $attendance->check_in ? "Check-in: {$attendance->check_in}" : '',
                'time' => $attendance->created_at->diffForHumans(),
                'icon' => 'user-circle',
                'color' => $attendance->status === 'present' ? 'green' : 'red',
            ];
        });

        return collect($activities)->sortByDesc('time')->take(6)->values()->all();
    }

    protected function getStaffRecentActivity(int $userId): array
    {
        $activities = [];

        Task::where('user_id', $userId)->latest()->limit(5)->get()->each(function ($task) use (&$activities) {
            $activities[] = [
                'title' => "Task: {$task->title}",
                'subtitle' => "Status: {$task->status}",
                'time' => $task->updated_at->diffForHumans(),
                'icon' => 'clipboard-document-list',
                'color' => 'purple',
            ];
        });

        return $activities;
    }

    protected function getAttendanceStats(): array
    {
        $stats = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $stats[] = [
                'date' => $date->format('D'),
                'present' => Attendance::where('date', $date)->where('status', 'present')->count(),
                'absent' => Attendance::where('date', $date)->where('status', 'absent')->count(),
            ];
        }
        return $stats;
    }
}
