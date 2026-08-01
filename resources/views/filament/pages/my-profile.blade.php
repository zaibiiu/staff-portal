<x-filament-panels::page>
<div class="space-y-6" style="font-family:'Inter',ui-sans-serif,sans-serif;">

    @php $user = auth()->user(); @endphp

    {{-- Profile Header Card --}}
    <div style="background:linear-gradient(135deg,#1e2d5a 0%,#2d4a8a 55%,#3b6fd4 100%);border-radius:1rem;padding:2.25rem 2.5rem;position:relative;overflow:hidden;box-shadow:0 10px 32px rgba(30,45,90,0.28);">
        <div style="position:absolute;top:-60px;right:-40px;width:220px;height:220px;background:rgba(255,255,255,0.06);border-radius:50%;pointer-events:none;"></div>
        <div style="position:relative;z-index:2;display:flex;align-items:center;gap:1.5rem;flex-wrap:wrap;">
            @php $profile = $user->staffProfile; @endphp
            @if($profile && $profile->profile_photo)
                <img src="{{ Storage::url($profile->profile_photo) }}"
                     alt="{{ $user->name }}"
                     style="width:5rem;height:5rem;border-radius:50%;object-fit:cover;border:3px solid rgba(255,255,255,0.25);box-shadow:0 4px 16px rgba(0,0,0,0.2);flex-shrink:0;">
            @else
                <div style="width:5rem;height:5rem;border-radius:50%;background:linear-gradient(135deg,#f59e0b,#d97706);display:flex;align-items:center;justify-content:center;font-size:1.75rem;font-weight:800;color:#ffffff;border:3px solid rgba(255,255,255,0.25);box-shadow:0 4px 16px rgba(0,0,0,0.2);flex-shrink:0;">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
            @endif
            <div>
                <h1 style="color:#ffffff;font-size:1.625rem;font-weight:800;letter-spacing:-0.02em;margin-bottom:0.25rem;">{{ $user->name }}</h1>
                <p style="color:rgba(255,255,255,0.72);font-size:0.9375rem;margin-bottom:0.5rem;">{{ $user->email }}</p>
                <span style="background:linear-gradient(135deg,#f59e0b,#d97706);color:#ffffff;font-size:0.75rem;font-weight:700;padding:0.25rem 0.875rem;border-radius:9999px;text-transform:uppercase;letter-spacing:0.06em;">
                    {{ ucfirst($user->role) }}
                </span>
                @if($profile?->employee_id)
                    <span style="background:rgba(255,255,255,0.12);color:rgba(255,255,255,0.85);font-size:0.75rem;font-weight:600;padding:0.25rem 0.875rem;border-radius:9999px;margin-left:0.5rem;">
                        {{ $profile->employee_id }}
                    </span>
                @endif
            </div>
        </div>
    </div>

    {{-- Profile Form Card --}}
    <div style="background:#fff;border:1px solid #e2e8f0;border-radius:1rem;overflow:hidden;box-shadow:0 1px 3px rgba(15,23,42,.07);">
        <div style="padding:1.375rem 1.75rem;border-bottom:1px solid #f1f5f9;">
            <h3 style="color:#0f172a;font-size:1.0625rem;font-weight:700;letter-spacing:-0.01em;margin-bottom:0.25rem;">Edit Profile</h3>
            <p style="color:#64748b;font-size:0.875rem;">Update your personal information and emergency contact</p>
        </div>
        <div style="padding:1.75rem;">
            <form wire:submit="save">
                {{ $this->form }}
                <div style="margin-top:1.75rem;padding-top:1.25rem;border-top:1px solid #f1f5f9;display:flex;justify-content:flex-end;">
                    <x-filament::button type="submit" color="primary" size="lg">
                        💾 Save Changes
                    </x-filament::button>
                </div>
            </form>
        </div>
    </div>

</div>
</x-filament-panels::page>
