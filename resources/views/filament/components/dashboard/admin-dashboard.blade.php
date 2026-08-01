{{-- Premium Admin Dashboard --}}
<div class="space-y-6">
    {{-- Welcome Hero Banner --}}
    <div style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border-radius: 1rem; padding: 2.5rem; position: relative; overflow: hidden; box-shadow: 0 10px 25px rgba(59, 130, 246, 0.25);">
        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255, 255, 255, 0.1); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; background: rgba(255, 255, 255, 0.08); border-radius: 50%;"></div>
        <div style="position: relative; z-index: 10; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem;">
            <div>
                <h1 style="color: white; font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">
                    Welcome Back, {{ auth()->user()->name }}! 👋
                </h1>
                <p style="color: rgba(255, 255, 255, 0.9); font-size: 1rem;">
                    Track your staff, projects, and resources from here.
                </p>
            </div>
            <button style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 0.875rem 1.75rem; border-radius: 0.625rem; font-weight: 600; font-size: 1rem; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4); transition: all 0.2s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(245, 158, 11, 0.5)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(245, 158, 11, 0.4)';">
                📊 View Reports
            </button>
        </div>
    </div>
    {{-- Welcome Hero Banner --}}
    <div style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border-radius: 1rem; padding: 2.5rem; position: relative; overflow: hidden; box-shadow: 0 10px 25px rgba(59, 130, 246, 0.25);">
        <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255, 255, 255, 0.1); border-radius: 50%;"></div>
        <div style="position: absolute; bottom: -30px; left: -30px; width: 150px; height: 150px; background: rgba(255, 255, 255, 0.08); border-radius: 50%;"></div>
        <div style="position: relative; z-index: 10; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1.5rem;">
            <div>
                <h1 style="color: white; font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">
                    Welcome Back, {{ auth()->user()->name }}! 👋
                </h1>
                <p style="color: rgba(255, 255, 255, 0.9); font-size: 1rem;">
                    Track your staff, projects, and resources from here.
                </p>
            </div>
            <button style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 0.875rem 1.75rem; border-radius: 0.625rem; font-weight: 600; font-size: 1rem; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4); transition: all 0.2s ease;" onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 16px rgba(245, 158, 11, 0.5)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 12px rgba(245, 158, 11, 0.4)';">
                📊 View Reports
            </button>
        </div>
    </div>

    {{-- Premium Stat Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        {{-- Card 1: Total Staff - Blue --}}
        <div style="background: white; border-radius: 0.875rem; padding: 1.75rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08); border: 1px solid #e5e7eb; transition: all 0.2s ease;" onmouseover="this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.1)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.08)'; this.style.transform='translateY(0)';">
            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 1.25rem;">
                <div style="width: 3.5rem; height: 3.5rem; background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.25);">
                    <svg style="width: 2rem; height: 2rem; color: white;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                </div>
            </div>
            <div>
                <p style="color: #6b7280; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem;">Total Staff</p>
                <h3 style="color: #0f172a; font-size: 2.25rem; font-weight: 700; line-height: 1;">{{ $totalStaff }}</h3>
                <p style="color: #10b981; font-size: 0.8125rem; font-weight: 600; margin-top: 0.75rem;">
                    <span style="margin-right: 0.25rem;">↑</span> Active
                </p>
            </div>
        </div>

        {{-- Card 2: Departments - Green --}}
        <div style="background: white; border-radius: 0.875rem; padding: 1.75rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08); border: 1px solid #e5e7eb; transition: all 0.2s ease;" onmouseover="this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.1)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.08)'; this.style.transform='translateY(0)';">
            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 1.25rem;">
                <div style="width: 3.5rem; height: 3.5rem; background: linear-gradient(135deg, #10b981 0%, #059669 100%); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);">
                    <svg style="width: 2rem; height: 2rem; color: white;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                </div>
            </div>
            <div>
                <p style="color: #6b7280; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem;">Departments</p>
                <h3 style="color: #0f172a; font-size: 2.25rem; font-weight: 700; line-height: 1;">{{ $totalDepartments }}</h3>
                <p style="color: #6b7280; font-size: 0.8125rem; font-weight: 600; margin-top: 0.75rem;">
                    All Divisions
                </p>
            </div>
        </div>

        {{-- Card 3: Active Projects - Orange --}}
        <div style="background: white; border-radius: 0.875rem; padding: 1.75rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08); border: 1px solid #e5e7eb; transition: all 0.2s ease;" onmouseover="this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.1)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.08)'; this.style.transform='translateY(0)';">
            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 1.25rem;">
                <div style="width: 3.5rem; height: 3.5rem; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.25);">
                    <svg style="width: 2rem; height: 2rem; color: white;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
            </div>
            <div>
                <p style="color: #6b7280; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem;">Active Projects</p>
                <h3 style="color: #0f172a; font-size: 2.25rem; font-weight: 700; line-height: 1;">{{ $activeProjects }}</h3>
                <p style="color: #f59e0b; font-size: 0.8125rem; font-weight: 600; margin-top: 0.75rem;">
                    <span style="margin-right: 0.25rem;">●</span> In Progress
                </p>
            </div>
        </div>

        {{-- Card 4: Pending Tasks - Purple --}}
        <div style="background: white; border-radius: 0.875rem; padding: 1.75rem; box-shadow: 0 1px 3px rgba(0, 0, 0, 0.08); border: 1px solid #e5e7eb; transition: all 0.2s ease;" onmouseover="this.style.boxShadow='0 4px 12px rgba(0, 0, 0, 0.1)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 1px 3px rgba(0, 0, 0, 0.08)'; this.style.transform='translateY(0)';">
            <div style="display: flex; align-items: flex-start; justify-content: space-between; margin-bottom: 1.25rem;">
                <div style="width: 3.5rem; height: 3.5rem; background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); border-radius: 0.75rem; display: flex; align-items: center; justify-content: center; box-shadow: 0 4px 12px rgba(139, 92, 246, 0.25);">
                    <svg style="width: 2rem; height: 2rem; color: white;" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/>
                    </svg>
                </div>
            </div>
            <div>
                <p style="color: #6b7280; font-size: 0.875rem; font-weight: 500; margin-bottom: 0.5rem;">Pending Tasks</p>
                <h3 style="color: #0f172a; font-size: 2.25rem; font-weight: 700; line-height: 1;">{{ $pendingTasks }}</h3>
                <p style="color: #8b5cf6; font-size: 0.8125rem; font-weight: 600; margin-top: 0.75rem;">
                    <span style="margin-right: 0.25rem;">⏳</span> Awaiting
                </p>
            </div>
        </div>
    </div>

    {{-- Secondary Stats - White Cards with Icon Boxes --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div style="background: white; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.75rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="padding: 0.875rem; background: linear-gradient(135deg, #dbeafe 0%, #bfdbfe 100%); border-radius: 0.75rem; flex-shrink: 0;">
                    <svg style="width: 2rem; height: 2rem; color: #3b82f6;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div style="flex: 1;">
                    <p style="color: #64748b; font-size: 0.875rem; margin-bottom: 0.25rem; font-weight: 500;">Today's Attendance</p>
                    <p style="color: #0f172a; font-size: 1.875rem; font-weight: 700; line-height: 1;">{{ $todayAttendance }}</p>
                </div>
            </div>
        </div>

        <div style="background: white; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.75rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="padding: 0.875rem; background: linear-gradient(135deg, #e9d5ff 0%, #d8b4fe 100%); border-radius: 0.75rem; flex-shrink: 0;">
                    <svg style="width: 2rem; height: 2rem; color: #a855f7;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <div style="flex: 1;">
                    <p style="color: #64748b; font-size: 0.875rem; margin-bottom: 0.25rem; font-weight: 500;">In Progress</p>
                    <p style="color: #0f172a; font-size: 1.875rem; font-weight: 700; line-height: 1;">{{ $inProgressTasks }}</p>
                </div>
            </div>
        </div>

        <div style="background: white; border: 1px solid #e5e7eb; border-radius: 0.75rem; padding: 1.75rem; box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.1);">
            <div style="display: flex; align-items: center; gap: 1rem;">
                <div style="padding: 0.875rem; background: linear-gradient(135deg, #d1fae5 0%, #a7f3d0 100%); border-radius: 0.75rem; flex-shrink: 0;">
                    <svg style="width: 2rem; height: 2rem; color: #10b981;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div style="flex: 1;">
                    <p style="color: #64748b; font-size: 0.875rem; margin-bottom: 0.25rem; font-weight: 500;">Monthly Cost</p>
                    <p style="color: #0f172a; font-size: 1.875rem; font-weight: 700; line-height: 1;">PKR {{ number_format($monthlySalaryCost, 0) }}</p>
                </div>
            </div>
        </div>
    </div>

    {{-- Recent Tasks Table --}}
    @include('filament.components.dashboard.tasks-table', ['tasks' => $recentTasks])
</div>
