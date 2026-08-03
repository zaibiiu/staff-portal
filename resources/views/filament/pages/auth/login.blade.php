<x-filament-panels::page.simple>
    <div class="premium-auth-content">
        <div class="auth-brand">
            <img src="{{ asset('logo.svg') }}" alt="Staff Portal" class="auth-brand-logo">
            <p class="auth-subtitle">Welcome back! Please login to your account</p>
        </div>

        <form wire:submit="authenticate">
            {{ $this->form }}

            <x-filament::button type="submit" class="w-full">
                {{ __('Login') }}
            </x-filament::button>
        </form>

        <div class="auth-footer">
            <p>&copy; {{ date('Y') }} Staff Portal. All rights reserved.</p>
        </div>
    </div>

    <div class="auth-image-side-overlay"></div>
</x-filament-panels::page.simple>
