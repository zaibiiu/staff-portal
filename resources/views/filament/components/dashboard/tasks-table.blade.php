@props(['tasks'])

<div class="bg-white border border-gray-200 rounded-lg overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-200 flex items-center justify-between">
        <h3 class="text-base font-semibold text-gray-900">Recent Tasks</h3>
        <div class="flex gap-2">
            <button class="px-3 py-1.5 text-sm bg-gray-100 hover:bg-gray-200 rounded text-gray-700">
                Filters
            </button>
            <a href="/admin/tasks" class="px-3 py-1.5 text-sm bg-blue-600 hover:bg-blue-700 rounded text-white">
                + Create
            </a>
        </div>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-200">
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Task</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Assigned To</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Priority</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Status</th>
                    <th class="px-6 py-3 text-left text-xs font-semibold text-gray-600 uppercase">Created At</th>
                    <th class="px-6 py-3 text-center text-xs font-semibold text-gray-600 uppercase">Operations</th>
                </tr>
            </thead>
            <tbody class="bg-white">
                @forelse($tasks as $task)
                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                        <td class="px-6 py-4 text-sm font-medium text-gray-500">{{ $task->id }}</td>
                        <td class="px-6 py-4">
                            <p class="text-sm font-medium text-gray-900">{{ Str::limit($task->title, 40) }}</p>
                            <p class="text-xs text-gray-500">{{ $task->project?->name ?? 'No Project' }}</p>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-700">{{ $task->user->name }}</td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded text-xs font-medium {{ $task->priority === 'low' ? 'bg-green-600 text-white' : ($task->priority === 'medium' ? 'bg-blue-600 text-white' : ($task->priority === 'high' ? 'bg-orange-600 text-white' : 'bg-red-600 text-white')) }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="px-2.5 py-1 rounded text-xs font-medium {{ $task->status === 'pending' ? 'bg-orange-600 text-white' : ($task->status === 'in_progress' ? 'bg-blue-600 text-white' : 'bg-green-600 text-white') }}">
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-sm text-gray-600">{{ $task->created_at->format('Y-m-d') }}</td>
                        <td class="px-6 py-4">
                            <div class="flex items-center justify-center gap-2">
                                <button class="w-8 h-8 flex items-center justify-center bg-blue-600 hover:bg-blue-700 rounded border border-blue-700 text-white">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </button>
                                <button class="w-8 h-8 flex items-center justify-center bg-red-600 hover:bg-red-700 rounded border border-red-700 text-white">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-6 py-12 text-center text-sm text-gray-500">No tasks available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
