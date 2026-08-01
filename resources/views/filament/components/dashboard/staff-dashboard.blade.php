{{-- ============================================================
     PREMIUM STAFF DASHBOARD — Staff Portal
     ============================================================ --}}
<div class="space-y-6" style="font-family:'Inter',ui-sans-serif,sans-serif;">

    {{-- ══════════════════════════════════════════════════════════
         HERO WELCOME BANNER (Staff)
         ══════════════════════════════════════════════════════════ --}}
    <div style="
        background:linear-gradient(135deg,#1e2d5a 0%,#2d4a8a 55%,#3b6fd4 100%);
        border-radius:1rem;padding:2.25rem 2.5rem;position:relative;
        overflow:hidden;box-shadow:0 10px 32px rgba(30,45,90,0.28);
    ">
        <div style="position:absolute;top:-60px;right:-40px;width:220px;height:220px;background:rgba(255,255,255,0.06);border-radius:50%;pointer-events:none;"></div>
        <div style="position:absolute;bottom:-50px;left:120px;width:160px;height:160px;background:rgba(255,255,255,0.04);border-radius:50%;pointer-events:none;"></div>

        <div style="position:relative;z-index:2;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1.5rem;">
            <div>
                <p style="color:rgba(255,255,255,0.65);font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.5rem;">
                    🏠 My Dashboard
                </p>
                <h1 style="color:#ffffff;font-size:1.875rem;font-weight:800;letter-spacing:-0.02em;margin-bottom:0.5rem;line-height:1.2;">
                    Welcome Back, {{ auth()->user()->name }}! 👋
                </h1>
                <p style="color:rgba(255,255,255,0.72);font-size:1rem;">
                    Track your tasks, projects, and attendance from here.
                </p>
            </div>
            <a href="{{ route('filament.admin.pages.my-profile') }}"
               style="display:inline-flex;align-items:center;gap:0.625rem;background:linear-gradient(135deg,#f59e0b 0%,#d97706 100%);color:#ffffff;padding:0.875rem 1.625rem;border-radius:0.75rem;font-weight:700;font-size:0.9375rem;text-decoration:none;box-shadow:0 4px 14px rgba(245,158,11,0.42);transition:all 0.2s ease;"
               onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 20px rgba(245,158,11,0.5)';"
               onmouseout="this.style.transform='';this.style.boxShadow='0 4px 14px rgba(245,158,11,0.42)';">
                <svg style="width:1.25rem;height:1.25rem;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                My Profile
            </a>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         STAFF KPI CARDS
         ══════════════════════════════════════════════════════════ --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:1.25rem;">

        @php $cardBase = "background:#fff;border-radius:1rem;padding:1.625rem;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(15,23,42,.07);transition:all 0.25s ease;"; @endphp

        {{-- My Projects --}}
        <div style="{{ $cardBase }}"
             onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(15,23,42,.10)';"
             onmouseout="this.style.transform='';this.style.boxShadow='0 1px 3px rgba(15,23,42,.07)';">
            <div style="width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#3b82f6,#2563eb);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(59,130,246,0.28);margin-bottom:1.25rem;">
                <svg style="width:1.75rem;height:1.75rem;color:#fff;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <p style="color:#64748b;font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.375rem;">My Projects</p>
            <h3 style="color:#0f172a;font-size:2.25rem;font-weight:800;letter-spacing:-0.03em;line-height:1;">{{ $myProjects }}</h3>
            <p style="color:#3b82f6;font-size:0.8125rem;font-weight:600;margin-top:0.75rem;">In Progress</p>
        </div>

        {{-- Pending Tasks --}}
        <div style="{{ $cardBase }}"
             onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(15,23,42,.10)';"
             onmouseout="this.style.transform='';this.style.boxShadow='0 1px 3px rgba(15,23,42,.07)';">
            <div style="width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(245,158,11,0.28);margin-bottom:1.25rem;">
                <svg style="width:1.75rem;height:1.75rem;color:#fff;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p style="color:#64748b;font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.375rem;">Pending Tasks</p>
            <h3 style="color:#0f172a;font-size:2.25rem;font-weight:800;letter-spacing:-0.03em;line-height:1;">{{ $myPendingTasks }}</h3>
            <p style="color:#f59e0b;font-size:0.8125rem;font-weight:600;margin-top:0.75rem;">⏳ Awaiting</p>
        </div>

        {{-- Completed Tasks --}}
        <div style="{{ $cardBase }}"
             onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(15,23,42,.10)';"
             onmouseout="this.style.transform='';this.style.boxShadow='0 1px 3px rgba(15,23,42,.07)';">
            <div style="width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#10b981,#059669);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(16,185,129,0.28);margin-bottom:1.25rem;">
                <svg style="width:1.75rem;height:1.75rem;color:#fff;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p style="color:#64748b;font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.375rem;">Completed</p>
            <h3 style="color:#0f172a;font-size:2.25rem;font-weight:800;letter-spacing:-0.03em;line-height:1;">{{ $myCompletedTasks }}</h3>
            <p style="color:#10b981;font-size:0.8125rem;font-weight:600;margin-top:0.75rem;">✓ Done</p>
        </div>

        {{-- My Salary --}}
        <div style="{{ $cardBase }}"
             onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(15,23,42,.10)';"
             onmouseout="this.style.transform='';this.style.boxShadow='0 1px 3px rgba(15,23,42,.07)';">
            <div style="width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#8b5cf6,#7c3aed);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(139,92,246,0.28);margin-bottom:1.25rem;">
                <svg style="width:1.75rem;height:1.75rem;color:#fff;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p style="color:#64748b;font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.375rem;">My Salary</p>
            <h3 style="color:#0f172a;font-size:1.5rem;font-weight:800;letter-spacing:-0.02em;line-height:1.2;">PKR {{ number_format($currentSalary, 0) }}</h3>
            <p style="color:#8b5cf6;font-size:0.8125rem;font-weight:600;margin-top:0.75rem;">💰 Current</p>
        </div>

    </div>

    {{-- ══════════════════════════════════════════════════════════
         MY TASKS TABLE
         ══════════════════════════════════════════════════════════ --}}
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:1rem;overflow:hidden;box-shadow:0 1px 3px rgba(15,23,42,.07);">
        <div style="padding:1.375rem 1.75rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.75rem;">
            <div>
                <h3 style="color:#0f172a;font-size:1.0625rem;font-weight:700;letter-spacing:-0.01em;margin-bottom:0.25rem;">My Tasks</h3>
                <p style="color:#64748b;font-size:0.875rem;">Your assigned task list</p>
            </div>
            <a href="{{ route('filament.admin.pages.my-tasks') }}"
               style="color:#3b82f6;font-size:0.875rem;font-weight:600;text-decoration:none;display:flex;align-items:center;gap:0.25rem;"
               onmouseover="this.style.color='#2563eb';" onmouseout="this.style.color='#3b82f6';">
                View All
                <svg style="width:0.875rem;height:0.875rem;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        <div>
            @forelse($myTasks as $task)
            @php
                $statusMap = [
                    'pending'     => ['bg' => '#fef3c7', 'color' => '#78350f', 'label' => 'Pending'],
                    'in_progress' => ['bg' => '#dbeafe', 'color' => '#1e40af', 'label' => 'In Progress'],
                    'completed'   => ['bg' => '#d1fae5', 'color' => '#064e3b', 'label' => 'Completed'],
                    'on_hold'     => ['bg' => '#f1f5f9', 'color' => '#475569', 'label' => 'On Hold'],
                ];
                $s = $statusMap[$task->status] ?? ['bg' => '#f1f5f9', 'color' => '#475569', 'label' => ucfirst($task->status)];
            @endphp
            <div style="display:flex;align-items:center;justify-content:space-between;padding:1rem 1.75rem;border-bottom:1px solid #f1f5f9;transition:background 0.15s ease;flex-wrap:wrap;gap:0.75rem;"
                 onmouseover="this.style.background='#f8fafc';"
                 onmouseout="this.style.background='';">
                <div style="display:flex;align-items:center;gap:0.875rem;min-width:0;">
                    <div style="width:2.25rem;height:2.25rem;border-radius:0.5rem;flex-shrink:0;display:flex;align-items:center;justify-content:center;background:linear-gradient(135deg,#ede9fe,#ddd6fe);">
                        <svg style="width:1.125rem;height:1.125rem;color:#8b5cf6;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                    </div>
                    <div style="min-width:0;">
                        <p style="color:#0f172a;font-weight:600;font-size:0.9375rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">{{ Str::limit($task->title, 45) }}</p>
                        <p style="color:#94a3b8;font-size:0.8125rem;margin-top:0.125rem;">{{ $task->project?->name ?? 'No Project' }}</p>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:1rem;flex-shrink:0;">
                    <span style="background:{{ $s['bg'] }};color:{{ $s['color'] }};font-size:0.8125rem;font-weight:600;padding:0.3125rem 0.75rem;border-radius:9999px;white-space:nowrap;">
                        {{ $s['label'] }}
                    </span>
                    <span style="color:#94a3b8;font-size:0.8125rem;white-space:nowrap;">
                        {{ $task->due_date ? $task->due_date->format('M d') : 'No date' }}
                    </span>
                </div>
            </div>
            @empty
            <div style="padding:3.5rem 1.5rem;text-align:center;">
                <div style="display:inline-flex;padding:1.25rem;background:#f8fafc;border-radius:50%;margin-bottom:1rem;">
                    <svg style="width:2rem;height:2rem;color:#cbd5e1;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2"/>
                    </svg>
                </div>
                <p style="color:#64748b;font-weight:600;font-size:1rem;margin-bottom:0.25rem;">No tasks assigned yet</p>
                <p style="color:#94a3b8;font-size:0.875rem;">Your manager will assign tasks to you soon.</p>
            </div>
            @endforelse
        </div>
    </div>

</div>
