<div class="fi-resource-relation-manager" x-data="{ loading: false }" x-init="
    Livewire.hook('request', ({ url, options, payload, respond }) => {
        loading = true;
    });
    Livewire.hook('response', ({ url, options, payload, respond }) => {
        setTimeout(() => { loading = false; }, 100);
    });
">
    <!-- Loading Overlay -->
    <div x-show="loading" x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="transition ease-in duration-150" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0" style="position: absolute; top: 0; left: 0; right: 0; bottom: 0; background: rgba(255, 255, 255, 0.95); z-index: 50; display: none; border-radius: 12px;" x-cloak>
        <div style="position: absolute; top: 50%; left: 50%; transform: translate(-50%, -50%); text-align: center;">
            <div style="width: 60px; height: 60px; margin: 0 auto 1rem; border: 4px solid #e5e7eb; border-top-color: #667eea; border-radius: 50%; animation: spin 0.8s linear infinite;"></div>
            <div style="color: #6b7280; font-size: 0.875rem; font-weight: 600;">Loading data...</div>
        </div>
    </div>

    <!-- Content -->
    <div style="position: relative;">
        {{ $this->content }}
    </div>

    <x-filament-panels::unsaved-action-changes-alert />
</div>

<style>
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    [x-cloak] { display: none !important; }
</style>
