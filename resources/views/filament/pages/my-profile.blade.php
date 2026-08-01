<x-filament-panels::page>
    <div class="space-y-6">
        {{-- Profile Header Card --}}
        <div style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%); border-radius: 1rem; padding: 2.5rem; position: relative; overflow: hidden; box-shadow: 0 10px 25px rgba(59, 130, 246, 0.25);">
            <div style="position: absolute; top: -50px; right: -50px; width: 200px; height: 200px; background: rgba(255, 255, 255, 0.1); border-radius: 50%;"></div>
            <div style="position: relative; z-index: 10; display: flex; align-items: center; gap: 2rem; flex-wrap: wrap;">
                <div style="width: 100px; height: 100px; border-radius: 50%; border: 4px solid white; overflow: hidden; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 2.5rem; font-weight: 700; flex-shrink: 0;">
                    @if(auth()->user()->staffProfile?->profile_photo)
                        <img src="{{ Storage::url(auth()->user()->staffProfile->profile_photo) }}" alt="Profile" style="width: 100%; height: 100%; object-fit: cover;">
                    @else
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    @endif
                </div>
                <div style="flex: 1;">
                    <h1 style="color: white; font-size: 2rem; font-weight: 700; margin-bottom: 0.5rem;">
                        {{ auth()->user()->name }}
                    </h1>
                    <p style="color: rgba(255, 255, 255, 0.9); font-size: 1.125rem; margin-bottom: 0.5rem;">
                        @if(auth()->user()->staffProfile?->designation)
                            {{ auth()->user()->staffProfile->designation }}
                        @else
                            Staff Member
                        @endif
                    </p>
                    <div style="display: flex; gap: 1.5rem; flex-wrap: wrap; margin-top: 1rem;">
                        <div style="display: flex; align-items: center; gap: 0.5rem; color: rgba(255, 255, 255, 0.9);">
                            <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                            {{ auth()->user()->email }}
                        </div>
                        @if(auth()->user()->staffProfile?->phone)
                            <div style="display: flex; align-items: center; gap: 0.5rem; color: rgba(255, 255, 255, 0.9);">
                                <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                                </svg>
                                {{ auth()->user()->staffProfile->phone }}
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Profile Form --}}
        <form wire:submit="save">
            {{ $this->form }}
            
            <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end;">
                <button type="submit" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); color: white; padding: 0.875rem 2rem; border-radius: 0.625rem; font-weight: 600; font-size: 1rem; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.4); transition: all 0.2s ease;">
                    <span style="display: flex; align-items: center; gap: 0.5rem;">
                        <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Save Profile Changes
                    </span>
                </button>
            </div>
        </form>

        {{-- Password Change Form --}}
        <form wire:submit="updatePassword">
            {{ $this->passwordForm }}
            
            <div style="margin-top: 1.5rem; display: flex; justify-content: flex-end;">
                <button type="submit" style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); color: white; padding: 0.875rem 2rem; border-radius: 0.625rem; font-weight: 600; font-size: 1rem; border: none; cursor: pointer; box-shadow: 0 4px 12px rgba(59, 130, 246, 0.4); transition: all 0.2s ease;">
                    <span style="display: flex; align-items: center; gap: 0.5rem;">
                        <svg style="width: 1.25rem; height: 1.25rem;" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"/>
                        </svg>
                        Change Password
                    </span>
                </button>
            </div>
        </form>
    </div>
</x-filament-panels::page>
