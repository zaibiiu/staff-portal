<x-filament-panels::page>
<div class="space-y-6" style="font-family:'Inter',ui-sans-serif,sans-serif;">

    @php
        $user = auth()->user();
        $pendingCount    = \App\Models\Task::where('user_id',$user->id)->where('status','pending')->count();
        $inProgressCount = \App\Models\Task::where('user_id',$user->id)->where('status','in_progress')->count();
        $completedCount  = \App\Models\Task::where('user_id',$user->id)->where('status','completed')->count();
    @endphp

    {{-- Quick stats --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:1rem;">
        <div style="background:#fff;border-radius:0.875rem;padding:1.25rem;border:1px solid #fde68a;box-shadow:0 1px 3px rgba(15,23,42,.06);display:flex;align-items:center;gap:0.875rem;">
            <div style="width:2.5rem;height:2.5rem;background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:0.625rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:1.25rem;height:1.25rem;color:#fff;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p style="color:#64748b;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;">Pending</p>
                <p style="color:#0f172a;font-size:1.5rem;font-weight:800;line-height:1.1;">{{ $pendingCount }}</p>
            </div>
        </div>
        <div style="background:#fff;border-radius:0.875rem;padding:1.25rem;border:1px solid #bfdbfe;box-shadow:0 1px 3px rgba(15,23,42,.06);display:flex;align-items:center;gap:0.875rem;">
            <div style="width:2.5rem;height:2.5rem;background:linear-gradient(135deg,#3b82f6,#2563eb);border-radius:0.625rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:1.25rem;height:1.25rem;color:#fff;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div>
                <p style="color:#64748b;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;">In Progress</p>
                <p style="color:#0f172a;font-size:1.5rem;font-weight:800;line-height:1.1;">{{ $inProgressCount }}</p>
            </div>
        </div>
        <div style="background:#fff;border-radius:0.875rem;padding:1.25rem;border:1px solid #a7f3d0;box-shadow:0 1px 3px rgba(15,23,42,.06);display:flex;align-items:center;gap:0.875rem;">
            <div style="width:2.5rem;height:2.5rem;background:linear-gradient(135deg,#10b981,#059669);border-radius:0.625rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:1.25rem;height:1.25rem;color:#fff;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p style="color:#64748b;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;">Completed</p>
                <p style="color:#0f172a;font-size:1.5rem;font-weight:800;line-height:1.1;">{{ $completedCount }}</p>
            </div>
        </div>
    </div>

    {{-- Tasks Table --}}
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:1rem;overflow:hidden;box-shadow:0 1px 3px rgba(15,23,42,.07);">
        <div style="padding:1.375rem 1.75rem;border-bottom:1px solid #f1f5f9;">
            <h3 style="color:#0f172a;font-size:1.0625rem;font-weight:700;letter-spacing:-0.01em;margin-bottom:0.25rem;">My Tasks</h3>
            <p style="color:#64748b;font-size:0.875rem;">All tasks assigned to you</p>
        </div>
        <div style="padding:1.25rem 1.75rem;">
            {{ $this->table }}
        </div>
    </div>

</div>
</x-filament-panels::page>
