@extends('layouts.mainLayout')

@section('title', 'Top-up Successful - TOSHOP')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg border-0">
                <div class="card-body text-center p-5">
                    <div class="mb-4">
                        <i class="fas fa-check-circle text-success" style="font-size: 4rem;"></i>
                    </div>
                    
                    <h2 class="text-success mb-3">Saldo Top-up Successful!</h2>
                    <p class="lead mb-4">Your TOSHOP saldo has been successfully topped up. You can now use it for purchases.</p>
                    
                    <div class="card bg-light mb-4">
                        <div class="card-body">
                            <h5 class="mb-3">Top-up Details</h5>
                            <div class="row text-start">
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <strong>Order ID:</strong><br>
                                        <span class="text-primary">{{ $transaksi->midtrans_order_id }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <strong>Payment Method:</strong><br>
                                        {{ $transaksi->metodePembayaran->name ?? 'N/A' }}
                                    </div>
                                    <div class="mb-2">
                                        <strong>Status:</strong><br>
                                        @if($transaksi->paid_at)
                                            <span class="badge bg-success">Completed</span>
                                        @else
                                            <span class="badge bg-warning">Pending Payment</span>
                                        @endif
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="mb-2">
                                        <strong>Saldo Added:</strong><br>
                                        <span class="text-success fw-bold fs-5">Rp {{ number_format($transaksi->items->first()->price) }}</span>
                                    </div>
                                    <div class="mb-2">
                                        <strong>Current Saldo:</strong><br>
                                        <span class="text-warning fw-bold fs-5">Rp {{ number_format(auth()->user()->getSaldoAmount()) }}</span>
                                    </div>
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
                            <i class="fas fa-home me-2"></i>Start Shopping
                        </a>
                        <a href="{{ route('profile.saldo-topup') }}" class="btn btn-outline-warning btn-lg px-4">
                            <i class="fas fa-wallet me-2"></i>Top Up Again
                        </a>
                        <a href="{{ route('profile.history') }}" class="btn btn-outline-primary btn-lg px-4">
                            <i class="fas fa-history me-2"></i>View History
                        </a>
                    </div>
                    
                    <div class="mt-4">
                        <small class="text-muted">
                            <i class="fas fa-info-circle me-1"></i>
                            Your saldo has been updated and is ready to use. Check your profile for current balance.
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(!$transaksi->paid_at)
<script>
    // If payment is not confirmed, auto-check status
    document.addEventListener('DOMContentLoaded', function() {
        let checkAttempts = 0;
        const maxAttempts = 6; // Check for 30 seconds (6 x 5 seconds)
        
        function checkPaymentStatus() {
            if (checkAttempts >= maxAttempts) {
                console.log('Max check attempts reached');
                return;
            }
            
            checkAttempts++;
            
            fetch('{{ route("saldo.check-status", $transaksi->id) }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success && data.paid_at) {
                    // Payment confirmed, reload page to show updated status
                    console.log('Payment confirmed, reloading page');
                    window.location.reload();
                } else {
                    // Schedule next check
                    setTimeout(checkPaymentStatus, 5000);
                }
            })
            .catch(error => {
                console.error('Error checking payment:', error);
                // Continue checking even if there's an error
                setTimeout(checkPaymentStatus, 5000);
            });
        }
        
        // Start checking after 2 seconds
        setTimeout(checkPaymentStatus, 2000);
    });
</script>
@endif

@endsection