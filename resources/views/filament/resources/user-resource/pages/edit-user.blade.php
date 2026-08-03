<x-filament-panels::page>
    <div class="premium-user-edit-layout">
        <!-- User Header Card -->
        <div class="user-header-card">
            <div class="user-header-content">
                <div class="user-avatar">
                    @if($this->record->staffProfile?->profile_photo)
                        <img src="{{ asset('storage/' . $this->record->staffProfile->profile_photo) }}" alt="{{ $this->record->name }}" />
                    @else
                        <div class="avatar-placeholder">
                            {{ strtoupper(substr($this->record->name, 0, 2)) }}
                        </div>
                    @endif
                </div>
                <div class="user-info">
                    <h1 class="user-name">{{ $this->record->name }}</h1>
                    <div class="user-meta">
                        <span class="meta-item">
                            <svg class="meta-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ $this->record->email }}
                        </span>
                        <span class="meta-item">
                            <svg class="meta-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                            {{ ucfirst($this->record->role) }}
                        </span>
                        @if($this->record->staffProfile?->designation)
                            <span class="meta-item">
                                <svg class="meta-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                                {{ $this->record->staffProfile->designation }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Default Filament Content (includes form and relation managers) -->
        {{ $this->content }}
    </div>

    <style>
        .premium-user-edit-layout {
            max-width: 1400px;
            margin: 0 auto;
        }

        /* User Header Card */
        .user-header-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 16px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow: 0 10px 40px rgba(102, 126, 234, 0.2);
        }

        .user-header-content {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .user-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            overflow: hidden;
            border: 4px solid rgba(255, 255, 255, 0.3);
            flex-shrink: 0;
        }

        .user-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .avatar-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            font-size: 1.75rem;
            font-weight: 700;
        }

        .user-info {
            flex: 1;
        }

        .user-name {
            font-size: 1.75rem;
            font-weight: 700;
            color: white;
            margin: 0 0 0.75rem 0;
        }

        .user-meta {
            display: flex;
            gap: 1.5rem;
            flex-wrap: wrap;
        }

        .meta-item {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.875rem;
        }

        .meta-icon {
            width: 1.125rem;
            height: 1.125rem;
        }

        /* Responsive */
        @media (max-width: 640px) {
            .user-header-card {
                padding: 1.5rem;
            }

            .user-header-content {
                flex-direction: column;
                text-align: center;
            }

            .user-name {
                font-size: 1.5rem;
            }

            .user-meta {
                justify-content: center;
            }
        }
    </style>
</x-filament-panels::page>
