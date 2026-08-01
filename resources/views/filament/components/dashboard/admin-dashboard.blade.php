{{-- Admin Dashboard Component --}}
<div class="space-y-6">
    {{-- Colorful Stats Grid - INLINE STYLES --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Pink Card --}}
        <div style="position: relative; background: linear-gradient(135deg, #ec4899 0%, #db2777 100%); border-radius: 0.5rem; padding: 2rem; overflow: hidden; min-height: 140px;">
            <div style="position: absolute; top: 1.5rem; right: 1.5rem; opacity: 0.2;">
                <svg style="width: 6rem; height: 6rem; color: white;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                </svg>
            </div>
            <div style="position: relative;">
                <h3 style="color: white; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem;">Total Staff</h3>
                <p style="color: white; font-size: 3rem; font-weight: 700; line-height: 1;">{{ $totalStaff }}</p>
            </div>
        </div>

        {{-- Blue Card --}}
        <div style="position: relative; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 0.5rem; padding: 2rem; overflow: hidden; min-height: 140px;">
            <div style="position: absolute; top: 1.5rem; right: 1.5rem; opacity: 0.2;">
                <svg style="width: 6rem; height: 6rem; color: white;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
            <div style="position: relative;">
                <h3 style="color: white; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem;">Departments</h3>
                <p style="color: white; font-size: 3rem; font-weight: 700; line-height: 1;">{{ $totalDepartments }}</p>
            </div>
        </div>

        {{-- Green Card --}}
        <div style="position: relative; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 0.5rem; padding: 2rem; overflow: hidden; min-height: 140px;">
            <div style="position: absolute; top: 1.5rem; right: 1.5rem; opacity: 0.2;">
                <svg style="width: 6rem; height: 6rem; color: white;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div style="position: relative;">
                <h3 style="color: white; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem;">Active Projects</h3>
                <p style="color: white; font-size: 3rem; font-weight: 700; line-height: 1;">{{ $activeProjects }}</p>
            </div>
        </div>

        {{-- Orange Card --}}
        <div style="position: relative; background: linear-gradient(135deg, #f97316 0%, #ea580c 100%); border-radius: 0.5rem; padding: 2rem; overflow: hidden; min-height: 140px;">
            <div style="position: absolute; top: 1.5rem; right: 1.5rem; opacity: 0.2;">
                <svg style="width: 6rem; height: 6rem; color: white;" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                </svg>
            </div>
            <div style="position: relative;">
                <h3 style="color: white; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem;">Pending Tasks</h3>
                <p style="color: white; font-size: 3rem; font-weight: 700; line-height: 1;">{{ $pendingTasks }}</p>
            </div>
        </div>
    </div>

    {{-- Better White Secondary Stats --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
        <div style="background: white; border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="padding: 0.75rem; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 0.75rem;">
                    <svg style="width: 1.75rem; height: 1.75rem; color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div>
                    <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Today's Attendance</p>
                    <p style="color: #111827; font-size: 1.5rem; font-weight: 700; line-height: 1;">{{ $todayAttendance }}</p>
                </div>
            </div>
        </div>

        <div style="background: white; border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="padding: 0.75rem; background: linear-gradient(135deg, #e9d5ff 0%, #d8b4fe 100%); border-radius: 0.75rem;">
                    <svg style="width: 1.75rem; height: 1.75rem; color: #a855f7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div>
                    <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">In Progress</p>
                    <p style="color: #111827; font-size: 1.5rem; font-weight: 700; line-height: 1;">{{ $inProgressTasks }}</p>
                </div>
            </div>
        </div>

        <div style="background: white; border: 1px solid #e5e7eb; border-radius: 0.5rem; padding: 1.5rem;">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="padding: 0.75rem; background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); border-radius: 0.75rem;">
                    <svg style="width: 1.75rem; height: 1.75rem; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div>
                    <p style="color: #6b7280; font-size: 0.875rem; margin-bottom: 0.25rem;">Monthly Cost</p>
                    <p style="color: #111827; font-size: 1.5rem; font-weight: 700; line-height: 1;">PKR {{ number_format($monthlySalaryCost, 0) }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Tasks Table --}}
    @include('filament.components.dashboard.tasks-table', ['tasks' => $recentTasks])
</div>
