<x-filament-panels::page>
<div class="space-y-6" style="font-family:'Inter',ui-sans-serif,sans-serif;">

    @php
        $user = auth()->user();
        $activeProjects    = $user->projects()->where('status','active')->count();
        $completedProjects = $user->projects()->where('status','completed')->count();
        $totalProjects     = $user->projects()->count();
    @endphp

    {{-- Quick stats --}}
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(140px,1fr));gap:1rem;">
        <div style="background:#fff;border-radius:0.875rem;padding:1.25rem;border:1px solid #bfdbfe;box-shadow:0 1px 3px rgba(15,23,42,.06);display:flex;align-items:center;gap:0.875rem;">
            <div style="width:2.5rem;height:2.5rem;background:linear-gradient(135deg,#3b82f6,#2563eb);border-radius:0.625rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:1.25rem;height:1.25rem;color:#fff;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p style="color:#64748b;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;">Total</p>
                <p style="color:#0f172a;font-size:1.5rem;font-weight:800;line-height:1.1;">{{ $totalProjects }}</p>
            </div>
        </div>
        <div style="background:#fff;border-radius:0.875rem;padding:1.25rem;border:1px solid #fde68a;box-shadow:0 1px 3px rgba(15,23,42,.06);display:flex;align-items:center;gap:0.875rem;">
            <div style="width:2.5rem;height:2.5rem;background:linear-gradient(135deg,#f59e0b,#d97706);border-radius:0.625rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                <svg style="width:1.25rem;height:1.25rem;color:#fff;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
            </div>
            <div>
                <p style="color:#64748b;font-size:0.75rem;font-weight:600;text-transform:uppercase;letter-spacing:0.06em;">Active</p>
                <p style="color:#0f172a;font-size:1.5rem;font-weight:800;line-height:1.1;">{{ $activeProjects }}</p>
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
                <p style="color:#0f172a;font-size:1.5rem;font-weight:800;line-height:1.1;">{{ $completedProjects }}</p>
            </div>
        </div>
    </div>

    {{-- Projects Table --}}
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:1rem;overflow:hidden;box-shadow:0 1px 3px rgba(15,23,42,.07);">
        <div style="padding:1.375rem 1.75rem;border-bottom:1px solid #f1f5f9;">
            <h3 style="color:#0f172a;font-size:1.0625rem;font-weight:700;letter-spacing:-0.01em;margin-bottom:0.25rem;">My Projects</h3>
            <p style="color:#64748b;font-size:0.875rem;">Projects you are a member of</p>
        </div>
        <div style="padding:1.25rem 1.75rem;">
            {{ $this->table }}
        </div>
    </div>

</div>
</x-filament-panels::page>
