<!-- Profile Navigation Sidebar -->
<div class="profile-sidebar position-fixed" style="right: 2rem; top: 50%; transform: translateY(-50%); z-index: 1000;">
    <div class="card border-0 shadow-lg" style="background: rgba(52, 73, 94, 0.95); border-radius: 20px; width: 80px;">
        <div class="card-body p-3">
            <div class="d-flex flex-column gap-3">
                <!-- Profile Icon -->
                <div class="profile-nav-item position-relative" data-tooltip="Profile">
                    <a href="{{ route('profile.show') }}" 
                       class="btn btn-link text-decoration-none d-flex align-items-center justify-content-center rounded-circle {{ request()->routeIs('profile.show') ? 'active' : '' }}"
                       style="width: 50px; height: 50px; transition: all 0.3s ease;">
                        <i class="fas fa-home fa-lg" style="color: {{ request()->routeIs('profile.show') ? '#FFE292' : 'white' }};"></i>
                    </a>
                    <div class="profile-tooltip position-absolute end-100 top-50 translate-middle-y me-3 bg-dark text-white px-3 py-2 rounded-pill small fw-semibold" 
                         style="white-space: nowrap; opacity: 0; visibility: hidden; transition: all 0.3s ease;">
                        Profile
                    </div>
                </div>

                <!-- History Icon -->
                <div class="profile-nav-item position-relative" data-tooltip="History">
                    <a href="{{ route('profile.history') }}" 
                       class="btn btn-link text-decoration-none d-flex align-items-center justify-content-center rounded-circle {{ request()->routeIs('profile.history') ? 'active' : '' }}"
                       style="width: 50px; height: 50px; transition: all 0.3s ease;">
                        <i class="fas fa-receipt fa-lg" style="color: {{ request()->routeIs('profile.history') ? '#FFE292' : 'white' }};"></i>
                    </a>
                    <div class="profile-tooltip position-absolute end-100 top-50 translate-middle-y me-3 bg-dark text-white px-3 py-2 rounded-pill small fw-semibold" 
                         style="white-space: nowrap; opacity: 0; visibility: hidden; transition: all 0.3s ease;">
                        History
                    </div>
                </div>

                <!-- Top-up Icon -->
                <div class="profile-nav-item position-relative" data-tooltip="Top-up">
                    <a href="{{ route('profile.saldo-topup') }}" 
                       class="btn btn-link text-decoration-none d-flex align-items-center justify-content-center rounded-circle {{ request()->routeIs('profile.saldo-topup') ? 'active' : '' }}"
                       style="width: 50px; height: 50px; transition: all 0.3s ease;">
                        <i class="fas fa-credit-card fa-lg" style="color: {{ request()->routeIs('profile.saldo-topup') ? '#FFE292' : 'white' }};"></i>
                    </a>
                    <div class="profile-tooltip position-absolute end-100 top-50 translate-middle-y me-3 bg-dark text-white px-3 py-2 rounded-pill small fw-semibold" 
                         style="white-space: nowrap; opacity: 0; visibility: hidden; transition: all 0.3s ease;">
                        Top-up
                    </div>
                </div>

                <!-- Logout Icon -->
                <div class="profile-nav-item position-relative" data-tooltip="Logout">
                    <button type="button" 
                            class="btn btn-link text-decoration-none d-flex align-items-center justify-content-center rounded-circle"
                            style="width: 50px; height: 50px; transition: all 0.3s ease;"
                            data-bs-toggle="modal" data-bs-target="#logoutModal">
                        <i class="fas fa-sign-out-alt fa-lg text-white"></i>
                    </button>
                    <div class="profile-tooltip position-absolute end-100 top-50 translate-middle-y me-3 bg-dark text-white px-3 py-2 rounded-pill small fw-semibold" 
                         style="white-space: nowrap; opacity: 0; visibility: hidden; transition: all 0.3s ease;">
                        Logout
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Logout Confirmation Modal -->
<div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg" style="background: rgba(52, 73, 94, 0.95); border-radius: 20px;">
            <div class="modal-body text-center p-5">
                <i class="fas fa-sign-out-alt fa-3x text-warning mb-3"></i>
                <h4 class="text-white fw-bold mb-3">Are you sure to logout?</h4>
                <p class="text-white-50 mb-4">You will be redirected to the homepage after logout.</p>
                
                <div class="d-flex gap-3 justify-content-center">
                    <button type="button" class="btn btn-outline-light rounded-pill px-4 py-2 fw-semibold" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Cancel
                    </button>
                    <form method="POST" action="{{ route('logout') }}" class="d-inline">
                        @csrf
                        <button type="submit" class="btn rounded-pill px-4 py-2 fw-semibold" 
                                style="background-color: #FFE292; color: #222847; border: none;">
                            <i class="fas fa-check me-2"></i>Continue
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.profile-nav-item:hover .profile-tooltip {
    opacity: 1 !important;
    visibility: visible !important;
}

.profile-nav-item .btn:hover {
    background-color: rgba(255, 226, 146, 0.1) !important;
    transform: scale(1.1);
}

.profile-nav-item .btn.active {
    background-color: rgba(255, 226, 146, 0.2) !important;
}

.profile-nav-item .btn:hover i {
    color: #FFE292 !important;
}
</style>