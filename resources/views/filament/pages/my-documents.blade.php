<x-filament-panels::page>
<div class="space-y-6" style="font-family:'Inter',ui-sans-serif,sans-serif;">

    @php
        $docCount = auth()->user()->documents()->count();
    @endphp

    {{-- Documents info banner --}}
    <div style="background:linear-gradient(135deg,#eff6ff 0%,#dbeafe 100%);border:1px solid #bfdbfe;border-radius:1rem;padding:1.375rem 1.75rem;display:flex;align-items:center;gap:1rem;">
        <div style="width:2.75rem;height:2.75rem;background:linear-gradient(135deg,#3b82f6,#2563eb);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 4px 10px rgba(59,130,246,0.28);">
            <svg style="width:1.375rem;height:1.375rem;color:#fff;" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <div style="flex:1;">
            <p style="color:#1e40af;font-weight:700;font-size:0.9375rem;margin-bottom:0.125rem;">{{ $docCount }} Document{{ $docCount !== 1 ? 's' : '' }} Uploaded</p>
            <p style="color:#3b82f6;font-size:0.875rem;">Upload your documents to share them with the team securely.</p>
        </div>
    </div>

    {{-- Documents Table --}}
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:1rem;overflow:hidden;box-shadow:0 1px 3px rgba(15,23,42,.07);">
        <div style="padding:1.375rem 1.75rem;border-bottom:1px solid #f1f5f9;">
            <h3 style="color:#0f172a;font-size:1.0625rem;font-weight:700;letter-spacing:-0.01em;margin-bottom:0.25rem;">My Documents</h3>
            <p style="color:#64748b;font-size:0.875rem;">All your uploaded documents</p>
        </div>
        <div style="padding:1.25rem 1.75rem;">
            {{ $this->table }}
        </div>
    </div>

</div>
</x-filament-panels::page>
