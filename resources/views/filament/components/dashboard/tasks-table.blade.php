@props(['tasks'])

<div style="background: white; border: 1px solid #e5e7eb; border-radius: 0.75rem; overflow: hidden; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
    <div style="padding: 1.5rem; border-bottom: 1px solid #e5e7eb;">
        <h3 style="font-size: 1.125rem; font-weight: 700; color: #0f172a;">Recent Tasks</h3>
        <p style="font-size: 0.875rem; color: #64748b; margin-top: 0.25rem;">Latest task assignments across all projects</p>
    </div>
    <div style="overflow-x: auto;">
        <table style="width: 100%;">
            <thead>
                <tr style="background-color: #f8fafc; border-bottom: 1px solid #e5e7eb;">
                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">ID</th>
                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Task</th>
                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Assigned To</th>
                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Priority</th>
                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Status</th>
                    <th style="padding: 1rem 1.5rem; text-align: left; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Created At</th>
                    <th style="padding: 1rem 1.5rem; text-align: center; font-size: 0.75rem; font-weight: 700; color: #64748b; text-transform: uppercase; letter-spacing: 0.05em;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tasks as $task)
                    <tr style="border-bottom: 1px solid #f1f5f9; transition: background-color 0.15s ease;" onmouseover="this.style.backgroundColor='#f8fafc'" onmouseout="this.style.backgroundColor='white'">
                        <td style="padding: 1rem 1.5rem; font-size: 0.875rem; font-weight: 500; color: #64748b;">{{ $task->id }}</td>
                        <td style="padding: 1rem 1.5rem;">
                            <p style="font-size: 0.875rem; font-weight: 600; color: #0f172a; margin-bottom: 0.25rem;">{{ Str::limit($task->title, 40) }}</p>
                            <p style="font-size: 0.75rem; color: #64748b;">{{ $task->project?->name ?? 'No Project' }}</p>
                        </td>
                        <td style="padding: 1rem 1.5rem; font-size: 0.875rem; color: #334155;">{{ $task->user->name }}</td>
                        <td style="padding: 1rem 1.5rem;">
                            <span style="padding: 0.375rem 0.75rem; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; {{ $task->priority === 'low' ? 'background-color: #dcfce7; color: #166534;' : ($task->priority === 'medium' ? 'background-color: #dbeafe; color: #1e40af;' : ($task->priority === 'high' ? 'background-color: #fed7aa; color: #92400e;' : 'background-color: #fee2e2; color: #991b1b;')) }}">
                                {{ ucfirst($task->priority) }}
                            </span>
                        </td>
                        <td style="padding: 1rem 1.5rem;">
                            <span style="padding: 0.375rem 0.75rem; border-radius: 0.375rem; font-size: 0.75rem; font-weight: 600; display: inline-flex; align-items: center; {{ $task->status === 'pending' ? 'background-color: #fef3c7; color: #92400e;' : ($task->status === 'in_progress' ? 'background-color: #dbeafe; color: #1e40af;' : 'background-color: #dcfce7; color: #166534;') }}">
                                {{ ucfirst(str_replace('_', ' ', $task->status)) }}
                            </span>
                        </td>
                        <td style="padding: 1rem 1.5rem; font-size: 0.875rem; color: #64748b;">{{ $task->created_at->format('Y-m-d') }}</td>
                        <td style="padding: 1rem 1.5rem;">
                            <div style="display: flex; align-items: center; justify-content: center; gap: 0.5rem;">
                                <button style="width: 2rem; height: 2rem; display: inline-flex; align-items: center; justify-content: center; background-color: #3b82f6; border: 1px solid #3b82f6; border-radius: 0.375rem; color: white; cursor: pointer; transition: all 0.15s ease;" onmouseover="this.style.backgroundColor='#2563eb'" onmouseout="this.style.backgroundColor='#3b82f6'">
                                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                    </svg>
                                </button>
                                <button style="width: 2rem; height: 2rem; display: inline-flex; align-items: center; justify-content: center; background-color: #ef4444; border: 1px solid #ef4444; border-radius: 0.375rem; color: white; cursor: pointer; transition: all 0.15s ease;" onmouseover="this.style.backgroundColor='#dc2626'" onmouseout="this.style.backgroundColor='#ef4444'">
                                    <svg style="width: 1rem; height: 1rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="padding: 3rem 1.5rem; text-align: center; font-size: 0.875rem; color: #64748b;">No tasks available</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
