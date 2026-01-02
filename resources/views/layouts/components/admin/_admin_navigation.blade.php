<div class="admin-sidebar">
    <!-- Logo Section -->
    <div class="admin-sidebar-header">
        <img src="{{ asset('images/logo/toshop-Logo.png') }}" alt="TOSHOP" class="admin-logo">
    </div>

    <!-- Menu Label -->
    <div class="admin-menu-label">
        MENU
    </div>

    <!-- Navigation Menu -->
    <nav class="admin-nav">
        <ul class="admin-nav-list">
            <li class="admin-nav-item">
                <a href="{{ route('admin.dashboard') }}" 
                   class="admin-nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li class="admin-nav-item">
                <a href="{{ route('admin.transaksi.index') }}" 
                   class="admin-nav-link {{ request()->routeIs('admin.transaksi.*') ? 'active' : '' }}">
                    <i class="fas fa-receipt"></i>
                    <span>Transaksi</span>
                </a>
            </li>

            <li class="admin-nav-item">
                <a href="{{ route('admin.promo-notifikasi.index') }}" 
                   class="admin-nav-link {{ request()->routeIs('admin.promo-notifikasi.*') ? 'active' : '' }}">
                    <i class="fas fa-bell"></i>
                    <span>Notifikasi</span>
                </a>
            </li>

            <li class="admin-nav-item">
                <a href="{{ route('admin.banner-promos.index') }}" 
                   class="admin-nav-link {{ request()->routeIs('admin.banner-promos.*') ? 'active' : '' }}">
                    <i class="fas fa-image"></i>
                    <span>Banner</span>
                </a>
            </li>

            <li class="admin-nav-item">
                <a href="{{ route('admin.promo-codes.index') }}" 
                   class="admin-nav-link {{ request()->routeIs('admin.promo-codes.*') ? 'active' : '' }}">
                    <i class="fas fa-percent"></i>
                    <span>PromoCode</span>
                </a>
            </li>

            <li class="admin-nav-item">
                <a href="{{ route('admin.games.index') }}" 
                   class="admin-nav-link {{ request()->routeIs('admin.games.*') ? 'active' : '' }}">
                    <i class="fas fa-gamepad"></i>
                    <span>Game</span>
                </a>
            </li>

            <li class="admin-nav-item">
                <a href="{{ route('admin.metode-pembayarans.index') }}" 
                   class="admin-nav-link {{ request()->routeIs('admin.metode-pembayarans.*') ? 'active' : '' }}">
                    <i class="fas fa-credit-card"></i>
                    <span>Metode Pembayaran</span>
                </a>
            </li>

            <li class="admin-nav-item">
                <a href="/" class="admin-nav-link">
                    <i class="fas fa-arrow-up"></i>
                    <span>Top-up Page</span>
                </a>
            </li>
        </ul>
    </nav>
</div>