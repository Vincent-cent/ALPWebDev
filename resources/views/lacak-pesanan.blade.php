@extends('layouts.mainLayout')

@section('title', 'Track Order - TOSHOP')

@section('content')
<div class="min-vh-100 d-flex align-items-center" style="background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #00b4db 100%); position: relative; overflow: hidden;">
    <!-- Background Decorations -->
    <div class="position-absolute" style="top: 10%; left: 10%; opacity: 0.1;">
        <i class="fas fa-star" style="font-size: 2rem; color: white; transform: rotate(15deg);"></i>
    </div>
    <div class="position-absolute" style="top: 20%; right: 15%; opacity: 0.1;">
        <i class="fas fa-star" style="font-size: 1.5rem; color: white; transform: rotate(-15deg);"></i>
    </div>
    <div class="position-absolute" style="bottom: 20%; left: 20%; opacity: 0.1;">
        <i class="fas fa-star" style="font-size: 1rem; color: white;"></i>
    </div>
    <div class="position-absolute" style="top: 30%; right: 30%; opacity: 0.1;">
        <i class="fas fa-circle" style="font-size: 0.5rem; color: white;"></i>
    </div>
    <div class="position-absolute" style="bottom: 40%; right: 10%; opacity: 0.1;">
        <i class="fas fa-circle" style="font-size: 0.8rem; color: white;"></i>
    </div>
    
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8">
                <div class="card shadow-lg border-0" style="border-radius: 20px; overflow: hidden;">
                    <div class="card-body p-5">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <div class="mb-3">
                                <i class="fas fa-search-dollar text-primary" style="font-size: 3rem;"></i>
                            </div>
                            <h2 class="fw-bold text-dark mb-2">LACAK PESANAN</h2>
                            <h3 class="fw-bold mb-0">
                                ANDA <span class="text-warning">SEKARANG!</span>
                            </h3>
                            <hr class="mx-auto" style="width: 100px; height: 3px; background: linear-gradient(90deg, #ffc107, #fd7e14); border: none; border-radius: 2px;">
                        </div>

                        <!-- Error Message -->
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 15px; border: none; background: linear-gradient(135deg, #ff6b6b, #ff8e8e); color: white;">
                                <div class="d-flex align-items-center">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    <span>{{ session('error') }}</span>
                                </div>
                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Track Order Form -->
                        <form action="{{ route('lacak-pesanan.track') }}" method="POST">
                            @csrf
                            <div class="mb-4">
                                <div class="position-relative">
                                    <input type="text" 
                                           class="form-control form-control-lg @error('invoice_id') is-invalid @enderror" 
                                           id="invoice_id" 
                                           name="invoice_id" 
                                           placeholder="Masukkan Nomor Invoice Anda"
                                           value="{{ old('invoice_id') }}"
                                           style="border-radius: 15px; padding: 15px 20px; border: 2px solid #e9ecef; font-size: 1.1rem;"
                                           required>
                                    <div class="position-absolute top-50 end-0 translate-middle-y me-3">
                                        <i class="fas fa-receipt text-muted"></i>
                                    </div>
                                </div>
                                @error('invoice_id')
                                    <div class="text-danger mt-2">
                                        <small><i class="fas fa-exclamation-circle me-1"></i>{{ $message }}</small>
                                    </div>
                                @enderror
                                <div class="form-text mt-2">
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Contoh: TRX-123456, D2C-20251230391900390, atau 12345
                                    </small>
                                </div>
                            </div>

                            <div class="d-grid">
                                <button type="submit" 
                                        class="btn btn-lg fw-bold text-white" 
                                        style="background: linear-gradient(135deg, #ff6b35, #f7931e); border: none; border-radius: 15px; padding: 15px; font-size: 1.1rem; box-shadow: 0 4px 15px rgba(255, 107, 53, 0.4); transition: all 0.3s ease;"
                                        onmouseover="this.style.transform='translateY(-2px)'; this.style.boxShadow='0 6px 20px rgba(255, 107, 53, 0.6)';"
                                        onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 15px rgba(255, 107, 53, 0.4)';">
                                    <i class="fas fa-search me-2"></i>
                                    LACAK PESANAN
                                </button>
                            </div>
                        </form>

                        <!-- Help Section -->
                        <div class="mt-4 pt-4 border-top">
                            <h6 class="text-dark mb-3">
                                <i class="fas fa-question-circle text-primary me-2"></i>
                                Butuh Bantuan?
                            </h6>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="bg-primary bg-opacity-10 rounded-circle p-2">
                                                <i class="fas fa-clock text-primary"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <small class="text-muted d-block">Pemrosesan</small>
                                            <small class="fw-semibold">5-10 Menit</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <div class="bg-success bg-opacity-10 rounded-circle p-2">
                                                <i class="fas fa-headset text-success"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <small class="text-muted d-block">Support</small>
                                            <small class="fw-semibold">24/7 Online</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Additional Info Card -->
                <div class="text-center mt-4">
                    <div class="card bg-white bg-opacity-10 border-0 text-white" style="border-radius: 15px; backdrop-filter: blur(10px);">
                        <div class="card-body py-3">
                            <small>
                                <i class="fas fa-shield-alt me-1"></i>
                                Transaksi Aman & Terpercaya | 
                                <i class="fas fa-clock me-1"></i>
                                Pemrosesan Otomatis | 
                                <i class="fas fa-users me-1"></i>
                                1000+ Pelanggan Puas
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

