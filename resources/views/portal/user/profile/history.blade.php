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
                        <form method="GET" action="{{ route('profile.history') }}" id="filter_form">
                            <div class="row g-3">
                                <div class="col-md-3">
                                    <select class="form-select rounded-pill" 
                                            id="status_filter" 
                                            name="status"
                                            style="background-color: rgba(44, 62, 80, 0.8); border: none; color: white;">
                                        <option value="">All Transactions</option>
                                        <option value="success" {{ request('status') === 'success' ? 'selected' : '' }}>Success</option>
                                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                                        <option value="failed" {{ request('status') === 'failed' ? 'selected' : '' }}>Failed</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <input type="date" 
                                           class="form-control rounded-pill" 
                                           id="date_from"
                                           name="date_from"
                                           value="{{ request('date_from') }}"
                                           placeholder="From Date"
                                           style="background-color: rgba(44, 62, 80, 0.8); border: none; color: white;">
                                </div>
                                <div class="col-md-3">
                                    <input type="date" 
                                           class="form-control rounded-pill"
                                           id="date_to" 
                                           name="date_to"
                                           value="{{ request('date_to') }}"
                                           placeholder="To Date"
                                           style="background-color: rgba(44, 62, 80, 0.8); border: none; color: white;">
                                </div>
                                <div class="col-md-3">
                                    <div class="d-flex gap-2">
                                        <button type="submit" 
                                                class="btn btn-primary rounded-pill flex-fill" 
                                                id="filter_button"
                                                style="background-color: #3498db;">
                                            <i class="fas fa-search me-2"></i>Filter
                                        </button>
                                        @if(request()->hasAny(['status', 'date_from', 'date_to']))
                                            <a href="{{ route('profile.history') }}" 
                                               class="btn btn-outline-light rounded-pill"
                                               id="reset_button">
                                                <i class="fas fa-times"></i>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>

                <!-- Transaction List -->
                <div class="row g-4">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-lg" style="background: rgba(52, 73, 94, 0.9); border-radius: 20px;">
                            <div class="card-body p-4">
                                <!-- Transaction Items -->
                                @forelse($transactions as $transaction)
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
                                                    <h6 class="text-white fw-bold mb-1">
                                                        @if($transaction->transaksiItems && $transaction->transaksiItems->isNotEmpty())
                                                            {{ $transaction->transaksiItems->first()->item->name ?? 'Unknown Item' }}
                                                        @else
                                                            Transaction
                                                        @endif
                                                    </h6>
                                                    <p class="text-white-50 small mb-1">
                                                        <i class="fas fa-calendar me-2"></i>{{ $transaction->created_at->format('d M Y, H:i') }}
                                                    </p>
                                                    <p class="text-white-50 small mb-1">
                                                        <i class="fas fa-hashtag me-2"></i>{{ $transaction->order_id ?? 'TRX-' . str_pad($transaction->id, 6, '0', STR_PAD_LEFT) }}
                                                    </p>
                                                    @if($transaction->user_game_id)
                                                        <p class="text-white-50 small mb-0">
                                                            <i class="fas fa-user me-2"></i>Game ID: {{ $transaction->user_game_id }}
                                                        </p>
                                                    @endif
                                                </div>
                                                <div class="col-md-2 text-center">
                                                    <h5 class="text-white fw-bold mb-1">Rp {{ number_format($transaction->total_harga, 0, ',', '.') }}</h5>
                                                    <small class="text-white-50">Amount</small>
                                                </div>
                                                <div class="col-md-2 text-center">
                                                    @php
                                                        $statusColors = [
                                                            'success' => 'success',
                                                            'pending' => 'warning', 
                                                            'failed' => 'danger',
                                                            'paid' => 'success',
                                                            'unpaid' => 'warning',
                                                            'cancelled' => 'danger'
                                                        ];
                                                        $statusIcons = [
                                                            'success' => 'check-circle',
                                                            'pending' => 'clock',
                                                            'failed' => 'times-circle',
                                                            'paid' => 'check-circle',
                                                            'unpaid' => 'clock',
                                                            'cancelled' => 'times-circle'
                                                        ];
                                                        
                                                        // Determine status
                                                        if ($transaction->paid_at) {
                                                            $status = 'success';
                                                            $displayStatus = 'Success';
                                                        } elseif ($transaction->midtrans_status === 'cancelled') {
                                                            $status = 'failed';
                                                            $displayStatus = 'Failed';
                                                        } else {
                                                            $status = 'pending';
                                                            $displayStatus = 'Pending';
                                                        }
                                                    @endphp
                                                    <span class="badge bg-{{ $statusColors[$status] ?? 'secondary' }} rounded-pill px-3 py-2">
                                                        <i class="fas fa-{{ $statusIcons[$status] ?? 'question' }} me-1"></i>
                                                        {{ $displayStatus }}
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
                                @if($transactions->hasPages())
                                    <div class="mt-4">
                                        {{ $transactions->appends(request()->query())->links('pagination.custom') }}
                                    </div>
                                @endif
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
                                        <span class="text-white fw-bold">{{ $summary['total'] }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-success">Successful:</span>
                                        <span class="text-success fw-bold">{{ $summary['successful'] }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-warning">Pending:</span>
                                        <span class="text-warning fw-bold">{{ $summary['pending'] }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-danger">Failed:</span>
                                        <span class="text-danger fw-bold">{{ $summary['failed'] }}</span>
                                    </div>
                                </div>

                                <hr class="border-secondary">

                                <div class="mb-3">
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <span class="text-white-50">Total Spent:</span>
                                        <span class="text-white fw-bold">Rp {{ number_format($summary['total_spent'] ?? 0, 0, ',', '.') }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="text-white-50">Avg per Transaction:</span>
                                        <span class="text-white fw-bold">Rp {{ number_format($summary['avg_transaction'] ?? 0, 0, ',', '.') }}</span>
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

<!-- Include the transaction history JavaScript -->
@vite('resources/js/user/transaction-history.js')

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