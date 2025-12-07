@extends('layouts.mainLayout')

@section('title', 'Transaction History - TOSHOP')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #2c3e50, #34495e); padding-top: 2rem; padding-bottom: 2rem;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Header -->
                <div class="d-flex align-items-center mb-4">
                    <i class="fas fa-receipt fa-2x text-white me-3"></i>
                    <h2 class="text-white fw-bold mb-0">TRANSACTION HISTORY</h2>
                </div>

                <!-- Filter Section -->
                <div class="card border-0 shadow-lg mb-4" style="background: rgba(52, 73, 94, 0.9); border-radius: 20px;">
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <select class="form-select rounded-pill" style="background-color: rgba(44, 62, 80, 0.8); border: none; color: white;">
                                    <option>All Transactions</option>
                                    <option>Success</option>
                                    <option>Pending</option>
                                    <option>Failed</option>
                                </select>
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control rounded-pill" 
                                       style="background-color: rgba(44, 62, 80, 0.8); border: none; color: white;">
                            </div>
                            <div class="col-md-3">
                                <input type="date" class="form-control rounded-pill" 
                                       style="background-color: rgba(44, 62, 80, 0.8); border: none; color: white;">
                            </div>
                            <div class="col-md-3">
                                <button class="btn btn-primary rounded-pill w-100" style="background-color: #3498db;">
                                    <i class="fas fa-search me-2"></i>Filter
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Transaction List -->
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-lg" style="background: rgba(52, 73, 94, 0.9); border-radius: 20px;">
                            <div class="card-body p-4">
                                <!-- Transaction Items -->
                                @forelse(range(1, 5) as $i)
                                    <div class="card border-0 mb-3" style="background: rgba(44, 62, 80, 0.8); border-radius: 15px;">
                                        <div class="card-body p-4">
                                            <div class="row align-items-center">
                                                <div class="col-md-2">
                                                    <div class="rounded-3 p-3 text-center" 
                                                         style="background: rgba(52, 152, 219, 0.2); color: #3498db;">
                                                        <i class="fas fa-gamepad fa-2x"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="text-white fw-bold mb-1">Mobile Legends Diamond</h6>
                                                    <p class="text-white-50 small mb-1">
                                                        <i class="fas fa-calendar me-2"></i>{{ now()->subDays($i)->format('d M Y, H:i') }}
                                                    </p>
                                                    <p class="text-white-50 small mb-1">
                                                        <i class="fas fa-hashtag me-2"></i>TRX{{ str_pad($i * 12345, 8, '0', STR_PAD_LEFT) }}
                                                    </p>
                                                    <p class="text-white-50 small mb-0">
                                                        <i class="fas fa-user me-2"></i>User ID: 12345678{{ $i }}
                                                    </p>
                                                </div>
                                                <div class="col-md-2 text-center">
                                                    <h5 class="text-white fw-bold mb-1">Rp {{ number_format(rand(50000, 500000), 0, ',', '.') }}</h5>
                                                    <small class="text-white-50">Amount</small>
                                                </div>
                                                <div class="col-md-2 text-center">
                                                    @php
                                                        $statuses = ['success', 'pending', 'failed'];
                                                        $status = $statuses[array_rand($statuses)];
                                                        $colors = [
                                                            'success' => 'success',
                                                            'pending' => 'warning', 
                                                            'failed' => 'danger'
                                                        ];
                                                        $icons = [
                                                            'success' => 'check-circle',
                                                            'pending' => 'clock',
                                                            'failed' => 'times-circle'
                                                        ];
                                                    @endphp
                                                    <span class="badge bg-{{ $colors[$status] }} rounded-pill px-3 py-2">
                                                        <i class="fas fa-{{ $icons[$status] }} me-1"></i>
                                                        {{ ucfirst($status) }}
                                                    </span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="text-center py-5">
                                        <i class="fas fa-receipt fa-4x text-white-50 mb-3"></i>
                                        <h5 class="text-white-50">No transactions found</h5>
                                        <p class="text-white-50 small">Your transaction history will appear here</p>
                                    </div>
                                @endforelse

                                <!-- Pagination -->
                                <nav aria-label="Transaction pagination">
                                    <ul class="pagination justify-content-center mb-0">
                                        <li class="page-item">
                                            <a class="page-link rounded-pill me-2" href="#" style="background-color: rgba(44, 62, 80, 0.8); border: none; color: white;">
                                                <i class="fas fa-chevron-left"></i>
                                            </a>
                                        </li>
                                        <li class="page-item active">
                                            <a class="page-link rounded-pill me-2" href="#" style="background-color: #3498db; border: none;">1</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link rounded-pill me-2" href="#" style="background-color: rgba(44, 62, 80, 0.8); border: none; color: white;">2</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link rounded-pill me-2" href="#" style="background-color: rgba(44, 62, 80, 0.8); border: none; color: white;">3</a>
                                        </li>
                                        <li class="page-item">
                                            <a class="page-link rounded-pill" href="#" style="background-color: rgba(44, 62, 80, 0.8); border: none; color: white;">
                                                <i class="fas fa-chevron-right"></i>
                                            </a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>

                    <!-- Summary Stats -->
                    <div class="col-lg-4">
                        <div class="card border-0 shadow-lg" style="background: rgba(52, 73, 94, 0.9); border-radius: 20px;">
                            <div class="card-body p-4">
                                <h5 class="text-white fw-bold mb-4">
                                    <i class="fas fa-chart-pie me-2"></i>Transaction Summary
                                </h5>
                                
                                <div class="mb-4">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-white-50">Total Transactions:</span>
                                        <span class="text-white fw-bold">73</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-success">Successful:</span>
                                        <span class="text-success fw-bold">71</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-warning">Pending:</span>
                                        <span class="text-warning fw-bold">0</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-danger">Failed:</span>
                                        <span class="text-danger fw-bold">2</span>
                                    </div>
                                </div>

                                <hr class="border-secondary">

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-white-50">Total Spent:</span>
                                        <span class="text-white fw-bold">Rp 2.450.000</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-white-50">Avg per Transaction:</span>
                                        <span class="text-white fw-bold">Rp 33.562</span>
                                    </div>
                                </div>

                                <div class="text-center mt-4">
                                    <button class="btn btn-outline-light rounded-pill px-4">
                                        <i class="fas fa-download me-2"></i>Export History
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

<!-- Include Profile Navbar -->
@include('layouts.components.profile._profile_navbar')

<style>
.form-select:focus, .form-control:focus {
    background-color: rgba(44, 62, 80, 0.9) !important;
    border-color: #FFE292 !important;
    box-shadow: 0 0 0 0.2rem rgba(255, 226, 146, 0.25) !important;
    color: white !important;
}

.form-control::placeholder {
    color: rgba(255, 255, 255, 0.6) !important;
}

.page-link:hover {
    background-color: #FFE292 !important;
    color: #222847 !important;
}
</style>
@endsection