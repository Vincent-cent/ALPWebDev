@extends('layouts.mainLayout')

@section('title', 'Payment - TOSHOP')

@section('head')
    <!-- Midtrans Client Key -->
    <script>
        window.midtransClientKey = '{{ config('midtrans.client_key') }}';
    </script>
    
    <!-- Meta tags for JavaScript -->
    <meta name="snap-token" content="{{ $transaksi->midtrans_transaction_id }}">
    <meta name="success-url" content="{{ route('transaksi.success', $transaksi->id) }}">
    <meta name="transaction-id" content="{{ $transaksi->id }}">
@endsection

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <div class="card shadow-lg">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">
                        <i class="fas fa-credit-card me-2"></i>Complete Payment
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
                                    <span>{{ $transaksi->user ? $transaksi->user->name : 'Guest User' }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between">
                                    <span>Payment Method:</span>
                                    <span>{{ $transaksi->metodePembayaran->name ?? 'N/A' }}</span>
                                </div>
                                <div class="list-group-item d-flex justify-content-between">
                                    <span>Status:</span>
                                    <span class="badge {{ $transaksi->paid_at ? 'bg-success' : 'bg-warning' }}">
                                        {{ $transaksi->paid_at ? 'Paid' : 'Pending Payment' }}
                                        @if($transaksi->midtrans_status)
                                            ({{ ucfirst($transaksi->midtrans_status) }})
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <h5>Order Summary</h5>
                            @foreach($transaksi->items as $item)
                            <div class="d-flex justify-content-between mb-2">
                                <span>{{ $item->tipeItem->name ?? 'Item' }} x{{ $item->quantity }}</span>
                                <span>Rp {{ number_format($item->price) }}</span>
                            </div>
                            @endforeach
                            <hr>
                            <div class="d-flex justify-content-between fs-5 fw-bold">
                                <span>Total:</span>
                                <span>Rp {{ number_format($transaksi->total) }}</span>
                            </div>
                        </div>
                    </div>
                    
                    <div class="text-center">
                        @if($transaksi->paid_at)
                            <div class="alert alert-success">
                                <i class="fas fa-check-circle me-2"></i>
                                Payment Completed! 
                                <a href="{{ route('transaksi.success', $transaksi->id) }}" class="btn btn-success ms-2">
                                    View Receipt
                                </a>
                            </div>
                        @elseif($transaksi->midtrans_transaction_id)
                            <button id="pay-button" class="btn btn-primary btn-lg px-5">
                                <i class="fas fa-lock me-2"></i>Pay Now - Rp {{ number_format($transaksi->total) }}
                            </button>
                            <p class="text-muted mt-2 mb-0">
                                <small>
                                    <i class="fas fa-shield-alt me-1"></i>
                                    Your payment is secured by Midtrans
                                </small>
                            </p>
                        @else
                            <div class="alert alert-warning">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Payment system is initializing. Please refresh the page in a moment.
                            </div>
                        @endif
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
                        <li>You will be redirected back here upon completion</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        console.log('Inline script starting...');
        console.log('Client Key:', window.midtransClientKey);
        
        // Initialize when DOM is loaded
        document.addEventListener('DOMContentLoaded', function() {
            console.log('DOM loaded, initializing payment...');
            
            // Check if we're on a payment page
            const snapToken = document.querySelector('meta[name="snap-token"]')?.getAttribute('content');
            const successUrl = document.querySelector('meta[name="success-url"]')?.getAttribute('content');
            const transactionId = document.querySelector('meta[name="transaction-id"]')?.getAttribute('content');

            console.log('Payment data:', {
                snapToken: snapToken,
                successUrl: successUrl,
                transactionId: transactionId,
                clientKey: window.midtransClientKey
            });

            if (snapToken && successUrl && transactionId) {
                initializePayment(snapToken, successUrl, transactionId);
            } else {
                console.error('Missing payment data', {
                    snapToken: !!snapToken,
                    successUrl: !!successUrl,
                    transactionId: !!transactionId
                });
            }
        });
        
        function initializePayment(snapToken, successUrl, transactionId) {
            console.log('Initializing payment with token:', snapToken);
            
            // Load Midtrans script
            const script = document.createElement('script');
            script.src = 'https://app.sandbox.midtrans.com/snap/snap.js';
            script.setAttribute('data-client-key', window.midtransClientKey);
            
            script.onload = function() {
                console.log('Midtrans script loaded successfully');
                setupPayButton(snapToken, successUrl);
            };
            
            script.onerror = function() {
                console.error('Failed to load Midtrans script');
                alert('Failed to load payment system. Please refresh and try again.');
            };
            
            document.head.appendChild(script);
        }
        
        function setupPayButton(snapToken, successUrl) {
            const payButton = document.getElementById('pay-button');
            console.log('Setting up pay button:', payButton);
            
            if (payButton) {
                payButton.onclick = function(e) {
                    e.preventDefault();
                    console.log('Pay button clicked, opening Midtrans...');
                    
                    if (typeof window.snap === 'undefined') {
                        console.error('Midtrans snap not available');
                        alert('Payment system not ready. Please refresh and try again.');
                        return;
                    }
                    
                    window.snap.pay(snapToken, {
                        onSuccess: function(result) {
                            console.log('Payment success:', result);
                            alert('Payment successful!');
                            window.location.href = successUrl;
                        },
                        onPending: function(result) {
                            console.log('Payment pending:', result);
                            alert('Payment is being processed. Please wait for confirmation.');
                        },
                        onError: function(result) {
                            console.log('Payment error:', result);
                            alert('Payment failed. Please try again.');
                        },
                        onClose: function() {
                            console.log('Payment popup closed');
                        }
                    });
                };
            } else {
                console.error('Pay button not found');
            }
        }
    </script>
@endsection