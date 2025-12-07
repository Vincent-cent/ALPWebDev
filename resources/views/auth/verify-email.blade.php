
    @extends('layouts.mainLayout')

@section('title', 'Verify Email - TOSHOP')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #2c3e50, #34495e);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0" style="background-color: rgba(52, 73, 94, 0.9); border-radius: 20px;">
                    <div class="card-body p-5">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <i class="fas fa-envelope fa-3x text-warning mb-3"></i>
                            <h2 class="text-white fw-bold mb-3">Verify Your Email</h2>
                            <p class="text-white-50 small">
                                Thanks for signing up! Before getting started, please verify your email address by clicking on the link we just emailed to you.
                            </p>
                        </div>

                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success rounded-pill mb-4" role="alert">
                                <i class="fas fa-check-circle me-2"></i>
                                A new verification link has been sent to your email address.
                            </div>
                        @endif

                        <!-- Action Buttons -->
                        <div class="d-flex flex-column gap-3">
                            <form method="POST" action="{{ route('verification.send') }}">
                                @csrf
                                <div class="d-grid">
                                    <button type="submit" class="btn rounded-pill py-3 fw-semibold" 
                                            style="background-color: #FFE292; color: #222847;">
                                        <i class="fas fa-paper-plane me-2"></i>Resend Verification Email
                                    </button>
                                </div>
                            </form>

                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-outline-light rounded-pill py-3 fw-semibold">
                                        <i class="fas fa-sign-out-alt me-2"></i>Log Out
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

