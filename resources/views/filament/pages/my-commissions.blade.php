<x-filament-panels::page>
<div class="space-y-6" style="font-family:'Inter',ui-sans-serif,sans-serif;">

    @php
        $totalCommission = auth()->user()->commissions()->sum('amount');
        $commissionCount = auth()->user()->commissions()->count();
        $avgCommission = $commissionCount > 0 ? $totalCommission / $commissionCount : 0;
    @endphp

    {{-- Commission Stats --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1.25rem;">

        {{-- Total Earned --}}
        <div style="background:linear-gradient(135deg,#1e2d5a,#2d4a8a);border-radius:1rem;padding:1.75rem;box-shadow:0 8px 24px rgba(30,45,90,0.25);">
            <div style="width:3rem;height:3rem;background:rgba(255,255,255,0.12);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;">
                <svg style="width:1.5rem;height:1.5rem;color:#f59e0b;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p style="color:rgba(255,255,255,0.65);font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.375rem;">Total Earned</p>
            <h3 style="color:#ffffff;font-size:1.875rem;font-weight:800;letter-spacing:-0.03em;line-height:1.1;">PKR {{ number_format($totalCommission, 0) }}</h3>
            <p style="color:rgba(255,255,255,0.55);font-size:0.8125rem;margin-top:0.625rem;">{{ $commissionCount }} commissions</p>
        </div>

        {{-- Commission Count --}}
        <div style="background:#fff;border-radius:1rem;padding:1.75rem;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(15,23,42,.07);transition:all 0.25s;"
             onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(15,23,42,.10)';"
             onmouseout="this.style.transform='';this.style.boxShadow='0 1px 3px rgba(15,23,42,.07)';">
            <div style="width:3rem;height:3rem;background:linear-gradient(135deg,#10b981,#059669);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;box-shadow:0 4px 10px rgba(16,185,129,0.28);">
                <svg style="width:1.5rem;height:1.5rem;color:#fff;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <p style="color:#64748b;font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.375rem;">Total Commissions</p>
            <h3 style="color:#0f172a;font-size:1.875rem;font-weight:800;letter-spacing:-0.03em;line-height:1.1;">{{ $commissionCount }}</h3>
            <p style="color:#10b981;font-size:0.8125rem;font-weight:600;margin-top:0.625rem;">✓ Records</p>
        </div>

        {{-- Average --}}
        <div style="background:#fff;border-radius:1rem;padding:1.75rem;border:1px solid #e2e8f0;box-shadow:0 1px 3px rgba(15,23,42,.07);transition:all 0.25s;"
             onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 24px rgba(15,23,42,.10)';"
             onmouseout="this.style.transform='';this.style.boxShadow='0 1px 3px rgba(15,23,42,.07)';">
            <div style="width:3rem;height:3rem;background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;margin-bottom:1rem;box-shadow:0 4px 10px rgba(245,158,11,0.28);">
                <svg style="width:1.5rem;height:1.5rem;color:#fff;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 12l3-3 3 3 4-4M8 21l4-4 4 4M3 4h18M4 4h16v12a1 1 0 01-1 1H5a1 1 0 01-1-1V4z"/>
                </svg>
            </div>
            <p style="color:#64748b;font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.375rem;">Average</p>
            <h3 style="color:#0f172a;font-size:1.875rem;font-weight:800;letter-spacing:-0.03em;line-height:1.1;">PKR {{ number_format($avgCommission, 0) }}</h3>
            <p style="color:#f59e0b;font-size:0.8125rem;font-weight:600;margin-top:0.625rem;">⊷ Per Commission</p>
        </div>

    </div>

    {{-- Commission History --}}
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:1rem;overflow:hidden;box-shadow:0 1px 3px rgba(15,23,42,.07);">
        <div style="padding:1.375rem 1.75rem;border-bottom:1px solid #f1f5f9;">
            <h3 style="color:#0f172a;font-size:1.0625rem;font-weight:700;letter-spacing:-0.01em;margin-bottom:0.25rem;">Commission History</h3>
            <p style="color:#64748b;font-size:0.875rem;">All your commission records</p>
        </div>
        <div style="padding:1.25rem 1.75rem;">
            {{ $this->table }}
        </div>
    </div>

</div>
</x-filament-panels::page>
