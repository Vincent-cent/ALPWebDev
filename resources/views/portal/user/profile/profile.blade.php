@extends('layouts.mainLayout')

@section('title', 'Profile - TOSHOP')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #2c3e50, #34495e); padding-top: 2rem; padding-bottom: 2rem;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Profile Header -->
                <div class="d-flex align-items-center mb-4">
                    <i class="fas fa-user fa-2x text-white me-3"></i>
                    <h2 class="text-white fw-bold mb-0">PROFIL</h2>
                </div>

                <!-- Main Profile Card -->
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-lg h-100" style="background: rgba(52, 73, 94, 0.9); border-radius: 20px;">
                            <div class="card-body p-4">
                                <!-- User Info Section -->
                                <div class="d-flex align-items-center mb-4">
                                    <div class="position-relative me-4">
                                        <div class="rounded-circle overflow-hidden" style="width: 100px; height: 100px; border: 3px solid #FFE292;">
                                            @if(auth()->user()->avatar)
                                                <img src="{{ asset('storage/' . auth()->user()->avatar) }}" 
                                                     alt="Profile" class="w-100 h-100 object-fit-cover">
                                            @else
                                                <div class="w-100 h-100 bg-secondary d-flex align-items-center justify-content-center">
                                                    <i class="fas fa-user fa-2x text-white"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <span class="position-absolute bottom-0 end-0 bg-success rounded-circle" 
                                              style="width: 20px; height: 20px; border: 2px solid white;"></span>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex align-items-center mb-2">
                                            <h3 class="text-white fw-bold mb-0 me-3">{{ auth()->user()->name }}</h3>
                                            <button class="btn btn-sm rounded-pill" style="background-color: #3498db; color: white;">
                                                <i class="fas fa-edit me-1"></i>Edit
                                            </button>
                                        </div>
                                        <p class="text-white-50 mb-1">
                                            <i class="fas fa-phone me-2"></i>{{ auth()->user()->phone ?? '628xxxxxxxxx' }}
                                        </p>
                                        <p class="text-white-50 mb-1">
                                            <i class="fas fa-envelope me-2"></i>{{ auth()->user()->email }}
                                        </p>
                                        <p class="text-white-50 mb-1">
                                            <i class="fas fa-crown me-2"></i>MEMBER
                                        </p>
                                        <p class="text-white-50 mb-0">
                                            <i class="fas fa-arrow-down me-2"></i>0 Downline
                                        </p>
                                    </div>
                                </div>

                                <!-- Referral Code Section -->
                                <div class="card border-0 mb-4" style="background: rgba(44, 62, 80, 0.8); border-radius: 15px;">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center justify-content-between mb-3">
                                            <span class="text-white fw-semibold">Kode Referral Anda:</span>
                                            <span class="badge rounded-pill px-3 py-2" style="background-color: #FFE292; color: #222847; font-size: 0.9rem;">
                                                {{ auth()->user()->referral_code ?? 'QWESQN53' }}
                                                <i class="fas fa-copy ms-2 cursor-pointer" onclick="copyReferralCode()"></i>
                                            </span>
                                        </div>
                                        <p class="text-white-50 small mb-2">
                                            Ajak teman, keluarga, kolega, atau publik secara lebih luas untuk mendaftar sebagai Member Dituai, dan Anda akan mendapatkan komisi dari setiap transaksi yang berhasil melalui Kode Referral Dituai yang berlaku.
                                        </p>
                                        <p class="text-warning small fw-semibold mb-0">
                                            <i class="fas fa-gift me-2"></i>Ayok, Bagikan Kode Referralmu Sekarang!
                                        </p>
                                    </div>
                                </div>

                                <!-- Balance Section -->
                                <div class="card border-0 mb-4" style="background: rgba(44, 62, 80, 0.8); border-radius: 15px;">
                                    <div class="card-body p-4">
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <i class="fas fa-wallet fa-2x me-3" style="color: #FFE292;"></i>
                                                <div>
                                                    <p class="text-white-50 small mb-1">Sisa Saldo</p>
                                                    <h4 class="text-white fw-bold mb-0">Rp. {{ number_format(auth()->user()->balance ?? 87060, 0, ',', '.') }}</h4>
                                                </div>
                                            </div>
                                            <a href="{{ route('profile.saldo-topup') }}" 
                                               class="btn rounded-pill px-4 py-2 fw-semibold" 
                                               style="background-color: #3498db; color: white;">
                                                <i class="fas fa-plus me-2"></i>Top Up
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <!-- Order Stats Section -->
                                <div class="card border-0" style="background: rgba(44, 62, 80, 0.8); border-radius: 15px;">
                                    <div class="card-body p-4">
                                        <h5 class="text-white fw-bold mb-4">
                                            <i class="fas fa-chart-bar me-2"></i>PESANAN SAYA
                                        </h5>
                                        <div class="row text-center">
                                            <div class="col-3">
                                                <div class="mb-2">
                                                    <h2 class="text-white fw-bold mb-0">71</h2>
                                                    <small class="text-white-50">Sukses</small>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="mb-2">
                                                    <h2 class="text-white fw-bold mb-0">0</h2>
                                                    <small class="text-white-50">Proses</small>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="mb-2">
                                                    <h2 class="text-white fw-bold mb-0">0</h2>
                                                    <small class="text-white-50">Belum Dibayar</small>
                                                </div>
                                            </div>
                                            <div class="col-3">
                                                <div class="mb-2">
                                                    <h2 class="text-white fw-bold mb-0">2</h2>
                                                    <small class="text-white-50">Gagal/Refund</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- User ID Section -->
                                <div class="card border-0 mt-4" style="background: rgba(44, 62, 80, 0.8); border-radius: 15px;">
                                    <div class="card-body p-4">
                                        <h5 class="text-white fw-bold mb-4">
                                            <i class="fas fa-id-card me-2"></i>User ID Saya
                                        </h5>
                                        <div class="d-flex align-items-center justify-content-between p-3 rounded-3" 
                                             style="background: rgba(52, 73, 94, 0.8);">
                                            <div class="d-flex align-items-center">
                                                <span class="text-white fw-semibold me-3">Honkai Star Rail</span>
                                                <span class="text-white-50">800533280</span>
                                            </div>
                                            <div class="d-flex align-items-center gap-2">
                                                <button class="btn btn-sm btn-outline-primary rounded-circle" style="width: 35px; height: 35px;">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <button class="btn btn-sm btn-outline-danger rounded-circle" style="width: 35px; height: 35px;">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div class="text-center mt-3">
                                            <button class="btn rounded-pill px-4 py-2" style="background-color: #3498db; color: white;">
                                                <i class="fas fa-plus me-2"></i>Tambah Game ID
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Profile Navbar -->
@include('layouts.components.profile._profile_navbar')

<script>
function copyReferralCode() {
    const referralCode = '{{ auth()->user()->referral_code ?? "QWESQN53" }}';
    navigator.clipboard.writeText(referralCode).then(function() {
        // Show Bootstrap toast notification
        const toastHtml = `
            <div class="toast align-items-center text-white border-0 position-fixed top-0 end-0 m-3" 
                 style="background-color: #28a745; z-index: 9999;" role="alert">
                <div class="d-flex">
                    <div class="toast-body">
                        <i class="fas fa-check me-2"></i>Referral code copied to clipboard!
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
                </div>
            </div>
        `;
        document.body.insertAdjacentHTML('beforeend', toastHtml);
        const toast = new bootstrap.Toast(document.querySelector('.toast:last-child'));
        toast.show();
    });
}
</script>
@endsection