<x-filament-panels::page.simple>
    {{-- Custom wrapper for premium auth design --}}
    <div class="premium-auth-content">
        {{-- Logo & Branding --}}
        <div class="auth-brand">
            <img src="{{ asset('logo.svg') }}" alt="Staff Portal" class="auth-brand-logo">
            <p class="auth-subtitle">Welcome back! Please login to your account</p>
        </div>

        {{-- Login Form (rendered by Filament using Schema) --}}
        {{ $this->content }}

        {{-- Footer Text --}}
        <div class="auth-footer">
            <p>&copy; {{ date('Y') }} Staff Portal. All rights reserved.</p>
        </div>
    </div>

    {{-- Background Image Side (no text, no overlay) --}}
    <div class="auth-image-side-overlay"></div>
</x-filament-panels::page.simple>
