{{-- ============================================================
     PREMIUM ADMIN DASHBOARD — Staff Portal
     Design: Navy sidebar | Blue/Amber accent | White cards
     ============================================================ --}}
<div class="space-y-6" style="font-family: 'Inter', ui-sans-serif, sans-serif;">

    {{-- ══════════════════════════════════════════════════════════
         HERO WELCOME BANNER
         ══════════════════════════════════════════════════════════ --}}
    <div style="
        background: linear-gradient(135deg, #1e2d5a 0%, #2d4a8a 55%, #3b6fd4 100%);
        border-radius: 1rem;
        padding: 2.25rem 2.5rem;
        position: relative;
        overflow: hidden;
        box-shadow: 0 10px 32px rgba(30, 45, 90, 0.28);
    ">
        {{-- decorative circles --}}
        <div style="position:absolute;top:-60px;right:-40px;width:220px;height:220px;background:rgba(255,255,255,0.06);border-radius:50%;pointer-events:none;"></div>
        <div style="position:absolute;bottom:-50px;left:120px;width:160px;height:160px;background:rgba(255,255,255,0.04);border-radius:50%;pointer-events:none;"></div>
        <div style="position:absolute;top:20px;right:200px;width:80px;height:80px;background:rgba(245,158,11,0.12);border-radius:50%;pointer-events:none;"></div>

        <div style="position:relative;z-index:2;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1.5rem;">
            <div>
                <p style="color:rgba(255,255,255,0.65);font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.5rem;">
                    📊 Admin Dashboard
                </p>
                <h1 style="color:#ffffff;font-size:1.875rem;font-weight:800;letter-spacing:-0.02em;margin-bottom:0.5rem;line-height:1.2;">
                    Welcome Back, {{ auth()->user()->name }}! 👋
                </h1>
                <p style="color:rgba(255,255,255,0.72);font-size:1rem;font-weight:400;">
                    Track your team, projects, and resources from here.
                </p>
            </div>
            <a href="{{ route('filament.admin.resources.users.index') }}"
               style="
                   display:inline-flex;align-items:center;gap:0.625rem;
                   background:linear-gradient(135deg,#f59e0b 0%,#d97706 100%);
                   color:#ffffff;padding:0.875rem 1.625rem;border-radius:0.75rem;
                   font-weight:700;font-size:0.9375rem;text-decoration:none;
                   box-shadow:0 4px 14px rgba(245,158,11,0.42);
                   transition:all 0.2s ease;
               "
               onmouseover="this.style.transform='translateY(-2px)';this.style.boxShadow='0 8px 20px rgba(245,158,11,0.5)';"
               onmouseout="this.style.transform='';this.style.boxShadow='0 4px 14px rgba(245,158,11,0.42)';">
                <svg style="width:1.25rem;height:1.25rem;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                Manage Staff
            </a>
        </div>
    </div>

    {{-- ══════════════════════════════════════════════════════════
         PRIMARY KPI CARDS — 4 columns
         ══════════════════════════════════════════════════════════ --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.25rem;">

        {{-- Total Staff --}}
        @php $cardBase = "background:#fff;border-radius:1rem;padding:1.625rem;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(15,23,42,.07);transition:all 0.25s ease;"; @endphp

        <div style="{{ $cardBase }}"
             onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(15,23,42,.10)';"
             onmouseout="this.style.transform='';this.style.boxShadow='0 1px 3px rgba(15,23,42,.07)';">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1.25rem;">
                <div style="width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#3b82f6,#2563eb);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(59,130,246,0.28);">
                    <svg style="width:1.75rem;height:1.75rem;color:#fff;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
                <span style="background:#dbeafe;color:#1e40af;font-size:0.75rem;font-weight:700;padding:0.25rem 0.625rem;border-radius:9999px;">Staff</span>
            </div>
            <p style="color:#64748b;font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.375rem;">Total Staff</p>
            <h3 style="color:#0f172a;font-size:2.25rem;font-weight:800;letter-spacing:-0.03em;line-height:1;">{{ $totalStaff }}</h3>
            <p style="color:#10b981;font-size:0.8125rem;font-weight:600;margin-top:0.75rem;display:flex;align-items:center;gap:0.25rem;">
                <svg style="width:1rem;height:1rem;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                {{ $activeStaff ?? $totalStaff }} Active
            </p>
        </div>

        {{-- Departments --}}
        <div style="{{ $cardBase }}"
             onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(15,23,42,.10)';"
             onmouseout="this.style.transform='';this.style.boxShadow='0 1px 3px rgba(15,23,42,.07)';">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1.25rem;">
                <div style="width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#10b981,#059669);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(16,185,129,0.28);">
                    <svg style="width:1.75rem;height:1.75rem;color:#fff;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
                <span style="background:#d1fae5;color:#064e3b;font-size:0.75rem;font-weight:700;padding:0.25rem 0.625rem;border-radius:9999px;">Dept</span>
            </div>
            <p style="color:#64748b;font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.375rem;">Departments</p>
            <h3 style="color:#0f172a;font-size:2.25rem;font-weight:800;letter-spacing:-0.03em;line-height:1;">{{ $totalDepartments }}</h3>
            <p style="color:#6b7280;font-size:0.8125rem;font-weight:600;margin-top:0.75rem;">All Divisions Active</p>
        </div>

        {{-- Active Projects --}}
        <div style="{{ $cardBase }}"
             onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(15,23,42,.10)';"
             onmouseout="this.style.transform='';this.style.boxShadow='0 1px 3px rgba(15,23,42,.07)';">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1.25rem;">
                <div style="width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(245,158,11,0.28);">
                    <svg style="width:1.75rem;height:1.75rem;color:#fff;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <span style="background:#fef3c7;color:#78350f;font-size:0.75rem;font-weight:700;padding:0.25rem 0.625rem;border-radius:9999px;">Live</span>
            </div>
            <p style="color:#64748b;font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.375rem;">Active Projects</p>
            <h3 style="color:#0f172a;font-size:2.25rem;font-weight:800;letter-spacing:-0.03em;line-height:1;">{{ $activeProjects }}</h3>
            <p style="color:#f59e0b;font-size:0.8125rem;font-weight:600;margin-top:0.75rem;display:flex;align-items:center;gap:0.25rem;">
                <span style="width:0.5rem;height:0.5rem;background:#f59e0b;border-radius:50%;display:inline-block;"></span>
                In Progress
            </p>
        </div>

        {{-- Pending Tasks --}}
        <div style="{{ $cardBase }}"
             onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(15,23,42,.10)';"
             onmouseout="this.style.transform='';this.style.boxShadow='0 1px 3px rgba(15,23,42,.07)';">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:1.25rem;">
                <div style="width:3.25rem;height:3.25rem;background:linear-gradient(135deg,#8b5cf6,#7c3aed);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(139,92,246,0.28);">
                    <svg style="width:1.75rem;height:1.75rem;color:#fff;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
                <span style="background:#ede9fe;color:#5b21b6;font-size:0.75rem;font-weight:700;padding:0.25rem 0.625rem;border-radius:9999px;">Tasks</span>
            </div>
            <p style="color:#64748b;font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.375rem;">Pending Tasks</p>
            <h3 style="color:#0f172a;font-size:2.25rem;font-weight:800;letter-spacing:-0.03em;line-height:1;">{{ $pendingTasks }}</h3>
            <p style="color:#8b5cf6;font-size:0.8125rem;font-weight:600;margin-top:0.75rem;display:flex;align-items:center;gap:0.25rem;">
                ⏳ Awaiting Action
            </p>
        </div>

    </div>

    {{-- ══════════════════════════════════════════════════════════
         SECONDARY STATS ROW
         ══════════════════════════════════════════════════════════ --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1.25rem;">

        {{-- Today's Attendance --}}
        @php $secCard = "background:#fff;border:1px solid #e2e8f0;border-radius:0.875rem;padding:1.375rem 1.5rem;display:flex;align-items:center;gap:1rem;box-shadow:0 1px 3px rgba(15,23,42,.06);"; @endphp

        <div style="{{ $secCard }}">
            <div style="padding:0.875rem;background:linear-gradient(135deg,#dbeafe,#bfdbfe);border-radius:0.75rem;flex-shrink:0;">
                <svg style="width:1.75rem;height:1.75rem;color:#3b82f6;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p style="color:#64748b;font-size:0.8125rem;font-weight:500;margin-bottom:0.25rem;">Today's Present</p>
                <p style="color:#0f172a;font-size:1.75rem;font-weight:800;letter-spacing:-0.02em;line-height:1;">{{ $todayAttendance }}</p>
            </div>
        </div>

        {{-- In Progress Tasks --}}
        <div style="{{ $secCard }}">
            <div style="padding:0.875rem;background:linear-gradient(135deg,#ede9fe,#ddd6fe);border-radius:0.75rem;flex-shrink:0;">
                <svg style="width:1.75rem;height:1.75rem;color:#8b5cf6;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div>
                <p style="color:#64748b;font-size:0.8125rem;font-weight:500;margin-bottom:0.25rem;">In-Progress Tasks</p>
                <p style="color:#0f172a;font-size:1.75rem;font-weight:800;letter-spacing:-0.02em;line-height:1;">{{ $inProgressTasks }}</p>
            </div>
        </div>

        {{-- Monthly Salary Cost --}}
        <div style="{{ $secCard }}">
            <div style="padding:0.875rem;background:linear-gradient(135deg,#d1fae5,#a7f3d0);border-radius:0.75rem;flex-shrink:0;">
                <svg style="width:1.75rem;height:1.75rem;color:#10b981;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p style="color:#64748b;font-size:0.8125rem;font-weight:500;margin-bottom:0.25rem;">Monthly Cost</p>
                <p style="color:#0f172a;font-size:1.375rem;font-weight:800;letter-spacing:-0.02em;line-height:1.2;">PKR {{ number_format($monthlySalaryCost, 0) }}</p>
            </div>
        </div>

        {{-- Completed Tasks --}}
        <div style="{{ $secCard }}">
            <div style="padding:0.875rem;background:linear-gradient(135deg,#fef3c7,#fde68a);border-radius:0.75rem;flex-shrink:0;">
                <svg style="width:1.75rem;height:1.75rem;color:#d97706;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p style="color:#64748b;font-size:0.8125rem;font-weight:500;margin-bottom:0.25rem;">Completed Tasks</p>
                <p style="color:#0f172a;font-size:1.75rem;font-weight:800;letter-spacing:-0.02em;line-height:1;">{{ $completedTasks }}</p>
            </div>
        </div>

    </div>

    {{-- ══════════════════════════════════════════════════════════
         RECENT TASKS TABLE
         ══════════════════════════════════════════════════════════ --}}
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:1rem;overflow:hidden;box-shadow:0 1px 3px rgba(15,23,42,.07);">

        {{-- Table header --}}
        <div style="padding:1.375rem 1.75rem;border-bottom:1px solid #f1f5f9;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:0.75rem;">
            <div>
                <h3 style="color:#0f172a;font-size:1.0625rem;font-weight:700;letter-spacing:-0.01em;margin-bottom:0.25rem;">Recent Tasks</h3>
                <p style="color:#64748b;font-size:0.875rem;">Latest task activity across your projects</p>
            </div>
            <a href="{{ route('filament.admin.resources.tasks.index') }}"
               style="color:#3b82f6;font-size:0.875rem;font-weight:600;text-decoration:none;display:flex;align-items:center;gap:0.25rem;"
               onmouseover="this.style.color='#2563eb';" onmouseout="this.style.color='#3b82f6';">
                View All
                <svg style="width:0.875rem;height:0.875rem;" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/>
                </svg>
            </a>
        </div>

        {{-- Table --}}
        <div style="overflow-x:auto;">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="background:#f8fafc;">
                        <th style="padding:0.9375rem 1.5rem;text-align:left;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.07em;white-space:nowrap;">Task</th>
                        <th style="padding:0.9375rem 1.5rem;text-align:left;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.07em;white-space:nowrap;">Assigned To</th>
                        <th style="padding:0.9375rem 1.5rem;text-align:left;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.07em;white-space:nowrap;">Project</th>
                        <th style="padding:0.9375rem 1.5rem;text-align:left;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.07em;white-space:nowrap;">Status</th>
                        <th style="padding:0.9375rem 1.5rem;text-align:left;font-size:0.75rem;font-weight:700;color:#64748b;text-transform:uppercase;letter-spacing:0.07em;white-space:nowrap;">Due Date</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentTasks as $task)
                    @php
                        $statusMap = [
                            'pending'     => ['bg' => '#fef3c7', 'color' => '#78350f', 'label' => 'Pending'],
                            'in_progress' => ['bg' => '#dbeafe', 'color' => '#1e40af', 'label' => 'In Progress'],
                            'completed'   => ['bg' => '#d1fae5', 'color' => '#064e3b', 'label' => 'Completed'],
                            'on_hold'     => ['bg' => '#f1f5f9', 'color' => '#475569', 'label' => 'On Hold'],
                        ];
                        $s = $statusMap[$task->status] ?? ['bg' => '#f1f5f9', 'color' => '#475569', 'label' => ucfirst($task->status)];
                    @endphp
                    <tr style="border-top:1px solid #f1f5f9;transition:background 0.15s ease;"
                        onmouseover="this.style.background='#f8fafc';"
                        onmouseout="this.style.background='';">
                        <td style="padding:1rem 1.5rem;">
                            <div style="font-weight:600;color:#0f172a;font-size:0.9375rem;">{{ Str::limit($task->title, 40) }}</div>
                            <div style="color:#94a3b8;font-size:0.8125rem;margin-top:0.2rem;">{{ $task->created_at->diffForHumans() }}</div>
                        </td>
                        <td style="padding:1rem 1.5rem;">
                            <div style="display:flex;align-items:center;gap:0.625rem;">
                                <div style="width:2rem;height:2rem;border-radius:50%;background:linear-gradient(135deg,#3b82f6,#2563eb);display:flex;align-items:center;justify-content:center;flex-shrink:0;font-size:0.75rem;font-weight:700;color:#fff;">
                                    {{ strtoupper(substr($task->user->name ?? 'U', 0, 1)) }}
                                </div>
                                <span style="color:#334155;font-size:0.9375rem;font-weight:500;">{{ $task->user->name ?? 'Unassigned' }}</span>
                            </div>
                        </td>
                        <td style="padding:1rem 1.5rem;color:#64748b;font-size:0.9375rem;">{{ $task->project->name ?? '—' }}</td>
                        <td style="padding:1rem 1.5rem;">
                            <span style="background:{{ $s['bg'] }};color:{{ $s['color'] }};font-size:0.8125rem;font-weight:600;padding:0.3125rem 0.75rem;border-radius:9999px;white-space:nowrap;">
                                {{ $s['label'] }}
                            </span>
                        </td>
                        <td style="padding:1rem 1.5rem;color:#64748b;font-size:0.9375rem;white-space:nowrap;">
                            {{ $task->due_date ? $task->due_date->format('M d, Y') : '—' }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="padding:3.5rem 1.5rem;text-align:center;">
                            <div style="display:inline-flex;padding:1.25rem;background:#f8fafc;border-radius:50%;margin-bottom:1rem;">
                                <svg style="width:2rem;height:2rem;color:#cbd5e1;" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                            </div>
                            <p style="color:#64748b;font-weight:600;font-size:1rem;margin-bottom:0.25rem;">No tasks yet</p>
                            <p style="color:#94a3b8;font-size:0.875rem;">Create a project and assign tasks to your team.</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>
