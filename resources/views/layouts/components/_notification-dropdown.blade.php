<!-- Notification Dropdown -->
<div class="nav-icon-container position-relative">
    <button class="nav-icon" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false" style="border: none; background: none; cursor: pointer;">
        <i class="fas fa-bell"></i>
        @if(isset($unreadNotifications) && $unreadNotifications->count() > 0)
            <span class="notification-badge" style="position: absolute; top: -5px; right: -5px; background-color: #FF6B6B; color: white; border-radius: 50%; width: 20px; height: 20px; display: flex; align-items: center; justify-content: center; font-size: 12px; font-weight: bold;">
                {{ $unreadNotifications->count() > 9 ? '9+' : $unreadNotifications->count() }}
            </span>
        @endif
    </button>
    <div class="nav-tooltip">Notifikasi</div>
    
    <!-- Dropdown Menu -->
    <div class="dropdown-menu dropdown-menu-end notification-dropdown" style="min-width: 350px; max-width: 400px; max-height: 500px; overflow-y: auto; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); border: none;">
        <div class="dropdown-header" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 12px 12px 0 0;">
            <h6 class="mb-0">Notifikasi</h6>
        </div>

        @if(isset($unreadNotifications) && $unreadNotifications->count() > 0)
            @foreach($unreadNotifications->take(5) as $notification)
                <a href="#" class="dropdown-item notification-item" style="border-bottom: 1px solid #f0f0f0; padding: 12px; transition: background-color 0.3s;">
                    @if($notification->image)
                        <div class="d-flex gap-3">
                            <img src="{{ asset('storage/' . $notification->image) }}" alt="Promo" style="width: 40px; height: 40px; border-radius: 6px; object-fit: cover;">
                            <div class="flex-grow-1">
                                <h6 class="mb-1" style="color: #222847; font-weight: 600;">{{ $notification->title }}</h6>
                                <p class="mb-0" style="color: #999; font-size: 13px;">{{ Str::limit($notification->description, 50) }}</p>
                                <small style="color: #bbb;">{{ $notification->created_at->diffForHumans() }}</small>
                            </div>
                        </div>
                    @else
                        <h6 class="mb-1" style="color: #222847; font-weight: 600;">{{ $notification->title }}</h6>
                        <p class="mb-0" style="color: #999; font-size: 13px;">{{ Str::limit($notification->description, 50) }}</p>
                        <small style="color: #bbb;">{{ $notification->created_at->diffForHumans() }}</small>
                    @endif
                </a>
            @endforeach
        @else
            <div class="dropdown-item text-center py-4">
                <i class="fas fa-inbox" style="font-size: 32px; color: #ddd; margin-bottom: 10px;"></i>
                <p class="mb-0" style="color: #999;">Tidak ada notifikasi</p>
            </div>
        @endif

        @if(isset($unreadNotifications) && $unreadNotifications->count() > 0)
            <div class="dropdown-divider"></div>
            <a href="{{ route('notifikasi.index') }}" class="dropdown-item text-center py-3" style="color: #667eea; font-weight: 600; background-color: #f9f9f9; border-radius: 0 0 12px 12px;">
                <i class="fas fa-arrow-right me-2"></i>Tampilkan Semua Notifikasi
            </a>
        @endif
    </div>
</div>

<style>
    .notification-item {
        color: #333;
        text-decoration: none;
    }

    .notification-item:hover {
        background-color: #f5f5f5;
        color: #333;
    }

    .notification-dropdown {
        animation: slideDown 0.3s ease-out;
    }

    @keyframes slideDown {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
</style>
