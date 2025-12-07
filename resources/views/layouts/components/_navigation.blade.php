<nav class="navbar navbar-expand-lg navbar-dark fixed-top navbar-custom">
    <div class="container-fluid px-4">
        <!-- Logo -->
        <a class="navbar-brand navbar-brand-custom" href="{{ route('beranda') }}">
            <img src="{{ asset('images/logo/toshop-Logo.png') }}" alt="TOSHOP" height="45" class="logo-image">
        </a>

        <!-- Search Bar -->
        <div class="d-flex flex-grow-1 justify-content-center mx-4">
            <div class="position-relative" style="width: 100%; max-width: 500px;">
                <input type="text" class="form-control rounded-pill ps-4 pe-5 search-input" 
                       placeholder="Search...">
                <button class="btn position-absolute top-50 end-0 translate-middle-y me-2 search-btn">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        <!-- Navigation Icons -->
        <div class="d-flex align-items-center gap-3">
            <!-- Home Icon -->
            <div class="nav-icon-container position-relative">
                <a href="{{ route('beranda') }}" class="nav-icon {{ request()->routeIs('beranda') ? 'active' : '' }}">
                    <i class="fas fa-home"></i>
                </a>
                <div class="nav-tooltip">Beranda</div>
            </div>

            <!-- Track Order Icon -->
            <div class="nav-icon-container position-relative">
                <a href="{{ route('about') }}" class="nav-icon {{ request()->routeIs('about') ? 'active' : '' }}">
                    <i class="fas fa-search-location" title="Track Order"></i>
                </a>
                <div class="nav-tooltip">Lacak Pesanan</div>
            </div>

            @auth
                <!-- Profile Icon for authenticated users -->
                <div class="nav-icon-container position-relative">
                    <a href="{{ route('profile.show') }}" class="nav-icon {{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        <i class="fas fa-user-circle"></i>
                    </a>
                    <div class="nav-tooltip">Profile</div>
                </div>
            @else
                <!-- Login Button for guests -->
                <a href="{{ route('login') }}" class="btn btn-outline-light rounded-pill px-4 me-2">
                    <i class="fas fa-sign-in-alt me-1"></i>Login
                </a>
                <a href="{{ route('register') }}" class="btn rounded-pill px-4" style="background-color: #FFE292; color: #222847; font-weight: 600; border: none;">
                    <i class="fas fa-user-plus me-1"></i>Sign up
                </a>
            @endauth
        </div>
    </div>
</nav>
