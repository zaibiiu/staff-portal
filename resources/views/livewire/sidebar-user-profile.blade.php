<div style="padding: 2rem 1.5rem; border-bottom: 1px solid rgba(255, 255, 255, 0.08); background: rgba(0, 0, 0, 0.15);">
    {{-- User Avatar --}}
    <div style="display: flex; justify-content: center; margin-bottom: 1.25rem;">
        <div style="width: 5rem; height: 5rem; border-radius: 50%; overflow: hidden; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem; font-weight: 700; box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);">
            @if(auth()->user()->staffProfile?->profile_photo)
                <img src="{{ Storage::url(auth()->user()->staffProfile->profile_photo) }}" alt="{{ auth()->user()->name }}" style="width: 100%; height: 100%; object-fit: cover;">
            @else
                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}
            @endif
        </div>
    </div>

    {{-- User Name --}}
    <div style="color: #ffffff; font-weight: 700; font-size: 1.125rem; line-height: 1.3; margin-bottom: 0.5rem; text-align: center;">
        {{ auth()->user()->name }}
    </div>

    {{-- User Email --}}
    <div style="color: rgba(255, 255, 255, 0.6); font-size: 0.8125rem; line-height: 1.4; margin-bottom: 1.25rem; text-align: center; word-break: break-all;">
        {{ auth()->user()->email }}
    </div>

    {{-- New Member Badge (or role badge) --}}
    <div style="display: flex; justify-content: center;">
        <div style="display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.5rem 1rem; background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); border-radius: 0.5rem; color: white; font-size: 0.8125rem; font-weight: 600; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3);">
            <svg style="width: 1rem; height: 1rem;" fill="currentColor" viewBox="0 0 20 20">
                <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/>
            </svg>
            @if(auth()->user()->staffProfile?->designation)
                {{ auth()->user()->staffProfile->designation }}
            @else
                {{ auth()->user()->isAdmin() ? 'Administrator' : 'New Member' }}
            @endif
        </div>
    </div>
</div>
