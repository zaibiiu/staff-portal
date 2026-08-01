<x-filament-panels::page>
<div class="space-y-6" style="font-family:'Inter',ui-sans-serif,sans-serif;">

    @php
        $currentSalary = auth()->user()->currentSalary;
        $totalEarned   = auth()->user()->salaries()->sum('amount');
    @endphp

    {{-- Salary Hero Card --}}
    <div style="background:linear-gradient(135deg,#1e2d5a 0%,#2d4a8a 55%,#3b6fd4 100%);border-radius:1rem;padding:2.25rem 2.5rem;position:relative;overflow:hidden;box-shadow:0 10px 32px rgba(30,45,90,0.28);">
        <div style="position:absolute;top:-60px;right:-40px;width:220px;height:220px;background:rgba(255,255,255,0.06);border-radius:50%;pointer-events:none;"></div>
        <div style="position:absolute;bottom:-50px;left:120px;width:160px;height:160px;background:rgba(255,255,255,0.04);border-radius:50%;pointer-events:none;"></div>
        <div style="position:relative;z-index:2;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:1.5rem;">
            <div>
                <p style="color:rgba(255,255,255,0.65);font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.08em;margin-bottom:0.5rem;">💰 Current Package</p>
                @if($currentSalary)
                    <h1 style="color:#ffffff;font-size:2.5rem;font-weight:800;letter-spacing:-0.03em;line-height:1;margin-bottom:0.5rem;">
                        PKR {{ number_format($currentSalary->amount, 0) }}
                    </h1>
                    <p style="color:rgba(255,255,255,0.72);font-size:1rem;">
                        Effective from {{ $currentSalary->effective_date->format('M d, Y') }}
                    </p>
                @else
                    <h1 style="color:#ffffff;font-size:2rem;font-weight:700;margin-bottom:0.5rem;">Not Set</h1>
                    <p style="color:rgba(255,255,255,0.72);font-size:1rem;">Contact HR to set up your salary.</p>
                @endif
            </div>
            <div style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.15);border-radius:0.875rem;padding:1.25rem 1.75rem;text-align:center;backdrop-filter:blur(4px);">
                <p style="color:rgba(255,255,255,0.65);font-size:0.8125rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;margin-bottom:0.375rem;">Total Earned</p>
                <p style="color:#f59e0b;font-size:1.625rem;font-weight:800;letter-spacing:-0.02em;">PKR {{ number_format($totalEarned, 0) }}</p>
            </div>
        </div>
    </div>

    {{-- Salary History Table --}}
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:1rem;overflow:hidden;box-shadow:0 1px 3px rgba(15,23,42,.07);">
        <div style="padding:1.375rem 1.75rem;border-bottom:1px solid #f1f5f9;">
            <h3 style="color:#0f172a;font-size:1.0625rem;font-weight:700;letter-spacing:-0.01em;margin-bottom:0.25rem;">Salary History</h3>
            <p style="color:#64748b;font-size:0.875rem;">Complete salary revision record</p>
        </div>
        <div style="padding:1.25rem 1.75rem;">
            {{ $this->table }}
        </div>
    </div>

</div>
</x-filament-panels::page>
