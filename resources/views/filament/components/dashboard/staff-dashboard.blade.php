{{-- Staff Dashboard Component --}}
<div class="space-y-6">
    {{-- Staff Stats Grid --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @include('filament.components.dashboard.stat-card', [
            'color' => 'blue',
            'title' => 'My Projects',
            'value' => $myProjects,
            'icon' => '<path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>'
        ])

        @include('filament.components.dashboard.stat-card', [
            'color' => 'orange',
            'title' => 'Pending Tasks',
            'value' => $myPendingTasks,
            'icon' => '<path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>'
        ])

        @include('filament.components.dashboard.stat-card', [
            'color' => 'green',
            'title' => 'Completed',
            'value' => $myCompletedTasks,
            'icon' => '<path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>'
        ])
    </div>

    {{-- My Tasks List --}}
    <div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-base font-semibold text-gray-900">My Tasks</h3>
        </div>
        <div class="divide-y divide-gray-100">
            @forelse($myTasks as $task)
                <div class="px-6 py-4 hover:bg-gray-50 transition flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-medium text-gray-900">{{ $task->title }}</h4>
                        <p class="text-xs text-gray-500 mt-1">{{ $task->project?->name ?? 'No Project' }}</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <span class="px-2.5 py-1 rounded text-xs font-medium {{ $task->status === 'pending' ? 'bg-orange-600 text-white' : ($task->status === 'in_progress' ? 'bg-blue-600 text-white' : 'bg-green-600 text-white') }}">
                            {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                        </span>
                        <span class="text-xs text-gray-500">
                            {{ $task->due_date?->format('M d') ?? 'No date' }}
                        </span>
                    </div>
                </div>
            @empty
                <div class="px-6 py-12 text-center">
                    <p class="text-sm text-gray-500">No tasks assigned yet</p>
                </div>
            @endforelse
        </div>
    </div>
</div>
