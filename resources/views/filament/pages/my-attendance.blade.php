<x-filament-panels::page>
<div class="space-y-6" style="font-family:'Inter',ui-sans-serif,sans-serif;">

    {{-- Premium Stats Cards --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(160px,1fr));gap:1.25rem;">
        @php
            $userId = auth()->id();
            $present = \App\Models\Attendance::where('user_id', $userId)
                ->whereYear('date', now()->year)->whereMonth('date', now()->month)
                ->where('status', 'present')->count();
            $absent = \App\Models\Attendance::where('user_id', $userId)
                ->whereYear('date', now()->year)->whereMonth('date', now()->month)
                ->where('status', 'absent')->count();
            $leave = \App\Models\Attendance::where('user_id', $userId)
                ->whereYear('date', now()->year)->whereMonth('date', now()->month)
                ->where('status', 'leave')->count();
            $late = \App\Models\Attendance::where('user_id', $userId)
                ->whereYear('date', now()->year)->whereMonth('date', now()->month)
                ->where('status', 'late')->count();
            $total = $present + $absent + $leave + $late;
            $rate  = $total > 0 ? round(($present / $total) * 100) : 0;
        @endphp

        {{-- Present --}}
        <div style="background:#fff;border-radius:1rem;padding:1.5rem;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(15,23,42,.07);transition:all 0.25s ease;"
             onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(15,23,42,.1)';"
             onmouseout="this.style.transform='';this.style.boxShadow='0 1px 3px rgba(15,23,42,.07)';">
            <div style="width:3rem;height:3rem;background:linear-gradient(135deg,#10b981,#059669);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;box-shadow:0 4px 10px rgba(16,185,129,0.28);">
                <svg style="width:1.5rem;height:1.5rem;color:#fff;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p style="color:#64748b;font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.375rem;">Present</p>
            <h3 style="color:#0f172a;font-size:2rem;font-weight:800;letter-spacing:-0.03em;line-height:1;">{{ $present }}</h3>
            <p style="color:#10b981;font-size:0.8125rem;font-weight:600;margin-top:0.625rem;">This Month</p>
        </div>

        {{-- Absent --}}
        <div style="background:#fff;border-radius:1rem;padding:1.5rem;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(15,23,42,.07);transition:all 0.25s ease;"
             onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(15,23,42,.1)';"
             onmouseout="this.style.transform='';this.style.boxShadow='0 1px 3px rgba(15,23,42,.07)';">
            <div style="width:3rem;height:3rem;background:linear-gradient(135deg,#ef4444,#dc2626);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;box-shadow:0 4px 10px rgba(239,68,68,0.28);">
                <svg style="width:1.5rem;height:1.5rem;color:#fff;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p style="color:#64748b;font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.375rem;">Absent</p>
            <h3 style="color:#0f172a;font-size:2rem;font-weight:800;letter-spacing:-0.03em;line-height:1;">{{ $absent }}</h3>
            <p style="color:#ef4444;font-size:0.8125rem;font-weight:600;margin-top:0.625rem;">This Month</p>
        </div>

        {{-- Leave --}}
        <div style="background:#fff;border-radius:1rem;padding:1.5rem;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(15,23,42,.07);transition:all 0.25s ease;"
             onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(15,23,42,.1)';"
             onmouseout="this.style.transform='';this.style.boxShadow='0 1px 3px rgba(15,23,42,.07)';">
            <div style="width:3rem;height:3rem;background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;box-shadow:0 4px 10px rgba(245,158,11,0.28);">
                <svg style="width:1.5rem;height:1.5rem;color:#fff;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <p style="color:#64748b;font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.375rem;">Leave</p>
            <h3 style="color:#0f172a;font-size:2rem;font-weight:800;letter-spacing:-0.03em;line-height:1;">{{ $leave }}</h3>
            <p style="color:#f59e0b;font-size:0.8125rem;font-weight:600;margin-top:0.625rem;">This Month</p>
        </div>

        {{-- Late --}}
        <div style="background:#fff;border-radius:1rem;padding:1.5rem;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(15,23,42,.07);transition:all 0.25s ease;"
             onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(15,23,42,.1)';"
             onmouseout="this.style.transform='';this.style.boxShadow='0 1px 3px rgba(15,23,42,.07)';">
            <div style="width:3rem;height:3rem;background:linear-gradient(135deg,#8b5cf6,#7c3aed);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;box-shadow:0 4px 10px rgba(139,92,246,0.28);">
                <svg style="width:1.5rem;height:1.5rem;color:#fff;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p style="color:#64748b;font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.375rem;">Late</p>
            <h3 style="color:#0f172a;font-size:2rem;font-weight:800;letter-spacing:-0.03em;line-height:1;">{{ $late }}</h3>
            <p style="color:#8b5cf6;font-size:0.8125rem;font-weight:600;margin-top:0.625rem;">This Month</p>
        </div>

        {{-- Attendance Rate --}}
        <div style="background:linear-gradient(135deg,#1e2d5a,#2d4a8a);border-radius:1rem;padding:1.5rem;border:1px solid #2d4a8a;box-shadow:0 4px 14px rgba(30,45,90,0.25);">
            <div style="width:3rem;height:3rem;background:rgba(255,255,255,0.12);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                <svg style="width:1.5rem;height:1.5rem;color:#ffffff;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                </svg>
            </div>
            <p style="color:rgba(255,255,255,0.65);font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.375rem;">Attendance Rate</p>
            <h3 style="color:#ffffff;font-size:2rem;font-weight:800;letter-spacing:-0.03em;line-height:1;">{{ $rate }}%</h3>
            <p style="color:rgba(255,255,255,0.65);font-size:0.8125rem;font-weight:600;margin-top:0.625rem;">Monthly Score</p>
        </div>

    </div>

    {{-- Attendance History Table --}}
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:1rem;overflow:hidden;box-shadow:0 1px 3px rgba(15,23,42,.07);">
        <div style="padding:1.375rem 1.75rem;border-bottom:1px solid #f1f5f9;">
            <h3 style="color:#0f172a;font-size:1.0625rem;font-weight:700;letter-spacing:-0.01em;margin-bottom:0.25rem;">Attendance History</h3>
            <p style="color:#64748b;font-size:0.875rem;">Your complete monthly attendance log</p>
        </div>
        <div style="padding:1.25rem 1.75rem;">
            {{ $this->table }}
        </div>
    </div>

</div>
</x-filament-panels::page>
