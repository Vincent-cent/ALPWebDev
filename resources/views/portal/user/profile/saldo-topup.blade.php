@extends('layouts.mainLayout')

@section('title', 'Top Up Saldo - TOSHOP')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #2c3e50, #34495e); padding-top: 2rem; padding-bottom: 2rem;">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <!-- Header -->
                <div class="d-flex align-items-center mb-4">
                    <i class="fas fa-credit-card fa-2x" style="color: #FFE292;"></i>
                    <h2 class="text-white fw-bold mb-0 ms-3">TOP UP</h2>
                </div>

                <!-- Main Content -->
                <div class="row g-4">
                    <div class="col-lg-8">
                        <form method="POST" action="{{ route('saldo.topup') }}">
                            @csrf
                            <div class="card border-0 shadow-lg" style="background: rgba(52, 73, 94, 0.9); border-radius: 20px;">
                            <div class="card-body p-4">
                                <!-- Nominal Input Section -->
                                <div class="mb-5">
                                    <h4 class="text-white fw-bold mb-3">NOMINAL</h4>
                                    <div class="input-group">
                                        <span class="input-group-text bg-transparent border-0 text-white fw-semibold" 
                                              style="background-color: rgba(44, 62, 80, 0.8) !important;">Rp.</span>
                                        <input type="number" name="amount" class="form-control border-0 py-3" 
                                               placeholder="Nominal" value="{{ old('amount') }}" min="100000" required
                                               style="background-color: rgba(44, 62, 80, 0.8); color: white; border-radius: 0 10px 10px 0 !important;">
                                        <button class="btn text-white" style="background-color: rgba(44, 62, 80, 0.8);" type="button">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                    <small class="text-warning fw-semibold mt-2 d-block">
                                        <i class="fas fa-info-circle me-1"></i>Minimal Top-Up Harus Lebih Dari Rp. 100.000 !
                                    </small>
                                </div>

                                <!-- Virtual Account Section -->
                                <div class="mb-5">
                                    <h4 class="text-white fw-bold mb-4">
                                        <i class="fas fa-university me-2"></i>VIRTUAL ACCOUNT
                                    </h4>
                                    <div class="row g-3">
                                        <!-- BCA -->
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card border-0 h-100 payment-method" 
                                                 style="background: rgba(44, 62, 80, 0.8); border-radius: 15px; cursor: pointer; transition: all 0.3s ease;">
                                                <div class="card-body p-3 text-center">
                                                    <div class="bg-primary rounded mb-2 d-flex align-items-center justify-content-center" style="height: 40px;">
                                                        <span class="text-white fw-bold">BCA</span>
                                                    </div>
                                                    <h6 class="text-white fw-semibold mb-1">BCA</h6>
                                                    <small class="text-white-50">4.500</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- BRI -->
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card border-0 h-100 payment-method" 
                                                 style="background: rgba(44, 62, 80, 0.8); border-radius: 15px; cursor: pointer; transition: all 0.3s ease;">
                                                <div class="card-body p-3 text-center">
                                                    <div class="bg-info rounded mb-2 d-flex align-items-center justify-content-center" style="height: 40px;">
                                                        <span class="text-white fw-bold">BRIVA</span>
                                                    </div>
                                                    <h6 class="text-white fw-semibold mb-1">BRI</h6>
                                                    <small class="text-white-50">4.500</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- BNI -->
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card border-0 h-100 payment-method" 
                                                 style="background: rgba(44, 62, 80, 0.8); border-radius: 15px; cursor: pointer; transition: all 0.3s ease;">
                                                <div class="card-body p-3 text-center">
                                                    <div class="bg-warning rounded mb-2 d-flex align-items-center justify-content-center" style="height: 40px;">
                                                        <span class="text-dark fw-bold">BNI</span>
                                                    </div>
                                                    <h6 class="text-white fw-semibold mb-1">BNI</h6>
                                                    <small class="text-white-50">4.500</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- MANDIRI -->
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card border-0 h-100 payment-method" 
                                                 style="background: rgba(44, 62, 80, 0.8); border-radius: 15px; cursor: pointer; transition: all 0.3s ease;">
                                                <div class="card-body p-3 text-center">
                                                    <div class="bg-warning rounded mb-2 d-flex align-items-center justify-content-center" style="height: 40px;">
                                                        <span class="text-dark fw-bold">mandiri</span>
                                                    </div>
                                                    <h6 class="text-white fw-semibold mb-1">MANDIRI</h6>
                                                    <small class="text-white-50">4.500</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- PERMATA -->
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card border-0 h-100 payment-method" 
                                                 style="background: rgba(44, 62, 80, 0.8); border-radius: 15px; cursor: pointer; transition: all 0.3s ease;">
                                                <div class="card-body p-3 text-center">
                                                    <div class="bg-success rounded mb-2 d-flex align-items-center justify-content-center" style="height: 40px;">
                                                        <span class="text-white fw-bold">PermataBank</span>
                                                    </div>
                                                    <h6 class="text-white fw-semibold mb-1">PERMATA</h6>
                                                    <small class="text-white-50">4.500</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- BNC -->
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card border-0 h-100 payment-method" 
                                                 style="background: rgba(44, 62, 80, 0.8); border-radius: 15px; cursor: pointer; transition: all 0.3s ease;">
                                                <div class="card-body p-3 text-center">
                                                    <div class="bg-warning rounded mb-2 d-flex align-items-center justify-content-center" style="height: 40px;">
                                                        <span class="text-dark fw-bold">b</span>
                                                    </div>
                                                    <h6 class="text-white fw-semibold mb-1">BNC</h6>
                                                    <small class="text-white-50">4.500</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- DANAMON -->
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card border-0 h-100 payment-method" 
                                                 style="background: rgba(44, 62, 80, 0.8); border-radius: 15px; cursor: pointer; transition: all 0.3s ease;">
                                                <div class="card-body p-3 text-center">
                                                    <div class="bg-primary rounded mb-2 d-flex align-items-center justify-content-center" style="height: 40px;">
                                                        <span class="text-white fw-bold">Bank Danamon</span>
                                                    </div>
                                                    <h6 class="text-white fw-semibold mb-1">DANAMON</h6>
                                                    <small class="text-white-50">4.500</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- CIMB -->
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card border-0 h-100 payment-method" 
                                                 style="background: rgba(44, 62, 80, 0.8); border-radius: 15px; cursor: pointer; transition: all 0.3s ease;">
                                                <div class="card-body p-3 text-center">
                                                    <div class="bg-danger rounded mb-2 d-flex align-items-center justify-content-center" style="height: 40px;">
                                                        <span class="text-white fw-bold">CIMB NIAGA</span>
                                                    </div>
                                                    <h6 class="text-white fw-semibold mb-1">CIMB</h6>
                                                    <small class="text-white-50">4.500</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- BSI -->
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card border-0 h-100 payment-method" 
                                                 style="background: rgba(44, 62, 80, 0.8); border-radius: 15px; cursor: pointer; transition: all 0.3s ease;">
                                                <div class="card-body p-3 text-center">
                                                    <div class="bg-success rounded mb-2 d-flex align-items-center justify-content-center" style="height: 40px;">
                                                        <span class="text-white fw-bold">BSI Syariah</span>
                                                    </div>
                                                    <h6 class="text-white fw-semibold mb-1">BSI</h6>
                                                    <small class="text-white-50">4.500</small>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- BTN -->
                                        <div class="col-md-4 col-sm-6">
                                            <div class="card border-0 h-100 payment-method" 
                                                 style="background: rgba(44, 62, 80, 0.8); border-radius: 15px; cursor: pointer; transition: all 0.3s ease;">
                                                <div class="card-body p-3 text-center">
                                                    <div class="bg-primary rounded mb-2 d-flex align-items-center justify-content-center" style="height: 40px;">
                                                        <span class="text-white fw-bold">btn</span>
                                                    </div>
                                                    <h6 class="text-white fw-semibold mb-1">BTN</h6>
                                                    <small class="text-white-50">4.500</small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- QRIS Section -->
                                <div class="mb-4">
                                    <h4 class="text-white fw-bold mb-4">
                                        <i class="fas fa-qrcode me-2"></i>QRIS
                                    </h4>
                                    <div class="col-md-4">
                                        <div class="card border-0 payment-method" 
                                             style="background: rgba(44, 62, 80, 0.8); border-radius: 15px; cursor: pointer; transition: all 0.3s ease;">
                                            <div class="card-body p-3 text-center">
                                                <div class="bg-info rounded mb-2 d-flex align-items-center justify-content-center" style="height: 40px;">
                                                    <span class="text-white fw-bold">QRIS</span>
                                                </div>
                                                <h6 class="text-white fw-semibold mb-1">QRIS</h6>
                                                <small class="text-white-50">Biaya Admin: 0.7%</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Phone Number Section -->
                                <div class="mb-4">
                                    <h4 class="text-white fw-bold mb-3">
                                        <i class="fas fa-phone me-2"></i>PHONE NUMBER
                                    </h4>
                                    <input type="tel" name="phone" class="form-control py-3" 
                                           placeholder="Enter your phone number" value="{{ old('phone') }}" required
                                           style="background-color: rgba(44, 62, 80, 0.8); color: white; border: 1px solid rgba(255, 255, 255, 0.1); border-radius: 10px;">
                                </div>

                                <!-- Top Up Button -->
                                <div class="text-center">
                                    <button type="submit" class="btn btn-lg rounded-pill px-5 py-3 fw-bold" 
                                            style="background-color: #3498db; color: white; border: none;">
                                        <i class="fas fa-arrow-up me-2"></i>Top Up Sekarang
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Include Profile Navbar -->
@include('layouts.components.profile._profile_navbar')

<style>
.payment-method:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3) !important;
    background: rgba(255, 226, 146, 0.1) !important;
}

.payment-method.selected {
    border: 2px solid #FFE292 !important;
    background: rgba(255, 226, 146, 0.2) !important;
}

.form-control:focus {
    background-color: rgba(44, 62, 80, 0.9) !important;
    border-color: #FFE292 !important;
    box-shadow: 0 0 0 0.2rem rgba(255, 226, 146, 0.25) !important;
    color: white !important;
}

.form-control::placeholder {
    color: rgba(255, 255, 255, 0.6) !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const paymentMethods = document.querySelectorAll('.payment-method');
    
    paymentMethods.forEach(method => {
        method.addEventListener('click', function() {
            // Remove selected class from all methods
            paymentMethods.forEach(m => m.classList.remove('selected'));
            // Add selected class to clicked method
            this.classList.add('selected');
        });
    });
});
</script>
@endsection