@extends('layouts.mainLayout')

@section('title', 'Saldo Top-up Payment - TOSHOP')

@section('head')
    <!-- Midtrans Client Key -->
    <script>
        window.midtransClientKey = '{{ config('midtrans.client_key') }}';
    </script>
    
    <!-- Meta tags for JavaScript -->
    <meta name="snap-token" content="{{ $transaksi->midtrans_transaction_id }}">
    <meta name="success-url" content="{{ route('saldo.success', $transaksi->id) }}">
    <meta name="transaction-id" content="{{ $transaksi->id }}">
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg">
                <div class="card-header bg-warning text-dark">
                    <h4 class="mb-0">
                        <i class="fas fa-wallet me-2"></i>TOSHOP Saldo Top-up Payment
                    </h4>
                </div>
                <div class="card-body p-4">
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <h5>Transaction Details</h5>
                            <div class="list-group list-group-flush">
                                <div class="list-group-item d-flex justify-content-between">
                                    <span>Order ID:</span>
                                    <strong>{{ $transaksi->midtrans_order_id }}</strong>
                                </div>
                                <div class="list-group-item d-flex justify-content-between">
                                    <span>Customer:</span>
                                    <span>{{ $transaksi->user->name }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between">
                                    <span>Payment Method:</span>
                                    <span>{{ $transaksi->metodePembayaran->name ?? 'N/A' }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between">
                                    <span>Status:</span>
                                    <span class="badge bg-warning">Pending Payment</span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Top-up Summary</h5>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Saldo Top-up Amount:</span>
                                <span>Rp {{ number_format($transaksi->items->first()->price) }}</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span>Admin Fee:</span>
                                <span>Rp {{ number_format($transaksi->total - $transaksi->items->first()->price) }}</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between fs-5 fw-bold">
                                <span>Total Payment:</span>
                                <span>Rp {{ number_format($transaksi->total) }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        <button id="pay-button" class="btn btn-warning btn-lg px-5">
                            <i class="fas fa-lock me-2"></i>Pay Now - Rp {{ number_format($transaksi->total) }}
                        </button>
                        <p class="text-muted mt-2 mb-0">
                            <small>
                                <i class="fas fa-shield-alt me-1"></i>
                                Your payment is secured by Midtrans
                            </small>
                        </p>
                    </div>
                </div>
            </div>
            
            <div class="card mt-4">
                <div class="card-body">
                    <h6>Payment Instructions:</h6>
                    <ol class="mb-0">
                        <li>Click "Pay Now" button above</li>
                        <li>Choose your preferred payment method</li>
                        <li>Complete the payment process</li>
                        <li>Your TOSHOP saldo will be automatically topped up</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <!-- Transaction Payment JavaScript -->
    <script src="{{ asset('js/transaction-payment.js') }}"></script>
@endsection