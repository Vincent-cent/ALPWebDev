<nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-custom">
    <div class="container-fluid px-4">
        <!-- Logo -->
        <a class="navbar-brand navbar-brand-custom" href="{{ route('admin.dashboard') }}">
            <img src="{{ asset('images/logo/toshop-Logo.png') }}" alt="TOSHOP" height="45" class="logo-image">
            <span class="ms-2" style="font-weight: 600;">Admin Panel</span>
        </a>

        <!-- Navigation Menu -->
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav" aria-controls="adminNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="adminNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                        <i class="fas fa-chart-line me-2"></i>Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.banners.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}#banners">
                        <i class="fas fa-image me-2"></i>Banners
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.games.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}#games">
                        <i class="fas fa-gamepad me-2"></i>Games
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request()->routeIs('admin.items.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}#items">
                        <i class="fas fa-box me-2"></i>Items
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="adminProfile" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-user-circle me-2"></i>{{ Auth::user()->name }}
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="adminProfile">
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.show') }}">
                                <i class="fas fa-user me-2"></i>Profile
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                                @csrf
                                <button type="submit" class="dropdown-item">
                                    <i class="fas fa-sign-out-alt me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
    .navbar-custom {
        background: linear-gradient(90deg, #2C3356 0%, #424A70 100%);
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        padding: 1rem 0;
    }

    .navbar-brand-custom {
        font-weight: 700;
        font-size: 1.5rem;
        color: #fff !important;
        display: flex;
        align-items: center;
    }

    .nav-link {
        color: rgba(255, 255, 255, 0.8) !important;
        transition: all 0.3s ease;
        margin: 0 0.5rem;
    }

    .nav-link:hover {
        color: #FFE292 !important;
    }

    .nav-link.active {
        color: #FFE292 !important;
        font-weight: 600;
        border-bottom: 2px solid #FFE292;
        padding-bottom: 0.5rem !important;
    }

    .dropdown-menu {
        background: #2C3356;
        border: none;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);
    }

    .dropdown-item {
        color: rgba(255, 255, 255, 0.8);
    }

    .dropdown-item:hover {
        background: #424A70;
        color: #FFE292;
    }

    .dropdown-divider {
        border-color: #424A70;
    }
</style>
