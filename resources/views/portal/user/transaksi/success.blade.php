@extends('layouts.mainLayout')

@section('title', 'Payment Success - TOSHOP')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h2 class="text-success mb-3">Payment Successful!</h2>
                    <p class="lead mb-4">Thank you for your purchase. Your transaction has been completed successfully.</p>
                    
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h5 class="mb-3">Transaction Details</h5>
                            <div class="row text-start">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <strong>Order ID:</strong><br>
                                        <span class="text-primary">{{ $transaksi->midtrans_order_id }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <strong>Customer:</strong><br>
                                        {{ $transaksi->user ? $transaksi->user->name : 'Guest User' }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Payment Method:</strong><br>
                                        {{ $transaksi->metodePembayaran->name ?? 'N/A' }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Status:</strong><br>
                                        <span class="badge bg-success">Paid</span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <strong>Items Purchased:</strong>
                                    </div>
                                    @foreach($transaksi->items as $item)
                                        <div class="mb-1">
                                            {{ $item->tipeItem->name ?? 'Item' }} x{{ $item->quantity }}
                                            <span class="float-end">Rp {{ number_format($item->price) }}</span>
                                        </div>
                                    @endforeach
                                    <hr>
                                    <div class="fw-bold">
                                        Total Paid: 
                                        <span class="float-end">Rp {{ number_format($transaksi->total) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                        <a href="{{ route('beranda') }}" class="btn btn-primary btn-lg px-4">
                            <i class="fas fa-home me-2"></i>Back to Home
                        </a>
                        @auth
                            <a href="{{ route('profile.history') }}" class="btn btn-outline-primary btn-lg px-4">
                                <i class="fas fa-history me-2"></i>View History
                            </a>
                        @else
                            <a href="{{ route('lacak-pesanan') }}" class="btn btn-outline-info btn-lg px-4">
                                <i class="fas fa-search me-2"></i>Track Orders
                            </a>
                            <a href="{{ route('login') }}" class="btn btn-outline-success btn-lg px-4">
                                <i class="fas fa-user me-2"></i>Login to Track Orders
                            </a>
                        @endauth
                    </div>
                    
                    <div class="mt-4">
                        @auth
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Your purchase will be processed within 5-10 minutes. You can track this order in your purchase history.
                            </small>
                        @else
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Your purchase will be processed within 5-10 minutes. Please save this Order ID ({{ $transaksi->midtrans_order_id }}) for your records. You can use this ID to track your order anytime.
                            </small>
                        @endauth
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection