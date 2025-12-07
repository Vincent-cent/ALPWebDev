    @extends('layouts.mainLayout')

@section('title', 'Forgot Password - TOSHOP')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #2c3e50, #34495e);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0" style="background-color: rgba(52, 73, 94, 0.9); border-radius: 20px;">
                    <div class="card-body p-5">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <h2 class="text-white fw-bold mb-3">Reset Password</h2>
                            <p class="text-white-50 small">
                                Forgot your password? No problem. Just let us know your email address and we will email you a password reset link.
                            </p>
                        </div>

                        @if (session('status'))
                            <div class="alert alert-success rounded-pill mb-4" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif

                        <!-- Reset Form -->
                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf
                            
                            <!-- Email Address -->
                            <div class="mb-4">
                                <input type="email" class="form-control rounded-pill py-3 ps-4" 
                                       name="email" value="{{ old('email') }}" 
                                       placeholder="Email Address" required autofocus>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn rounded-pill py-3 fw-semibold" 
                                        style="background-color: #FFE292; color: #222847;">
                                    Email Password Reset Link
                                </button>
                            </div>
                        </form>

                        <!-- Back to Login -->
                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-warning text-decoration-none fw-semibold">
                                <i class="fas fa-arrow-left me-2"></i>Back to Login
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
