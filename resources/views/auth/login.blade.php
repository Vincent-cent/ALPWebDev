    @extends('layouts.mainLayout')

@section('title', 'Login - TOSHOP')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #2c3e50, #34495e);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0" style="background-color: rgba(52, 73, 94, 0.9); border-radius: 20px;">
                    <div class="card-body p-5">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <h3 class="text-white fw-bold mb-3">Masuk dan nikmati banyak kemudahan dan info diskon!</h3>
                        </div>

                        <!-- Social Login Buttons -->
                        <div class="d-grid gap-3 mb-4">
                            <button class="btn btn-light rounded-pill py-3 fw-semibold" type="button">
                                <i class="fab fa-facebook me-2 text-primary"></i>Lanjut dengan Facebook
                            </button>
                            <button class="btn btn-light rounded-pill py-3 fw-semibold" type="button">
                                <i class="fab fa-google me-2 text-danger"></i>Lanjut dengan Google
                            </button>
                        </div>

                        <!-- Login Form -->
                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            <div class="d-grid mb-4">
                                <button type="button" class="btn btn-outline-light rounded-pill py-3 fw-semibold" data-bs-toggle="collapse" data-bs-target="#loginForm">
                                    Lanjut Dengan Toshop Account
                                </button>
                            </div>

                            <div class="collapse" id="loginForm">
                                <!-- Email -->
                                <div class="mb-3">
                                    <input type="email" class="form-control rounded-pill py-3 ps-4" 
                                           name="email" value="{{ old('email') }}" 
                                           placeholder="Email Address" required autofocus>
                                    @error('email')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Password -->
                                <div class="mb-4">
                                    <input type="password" class="form-control rounded-pill py-3 ps-4" 
                                           name="password" placeholder="Password" required>
                                    @error('password')
                                        <div class="text-danger small mt-1">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Login Button -->
                                <div class="d-grid mb-3">
                                    <button type="submit" class="btn rounded-pill py-3 fw-semibold" 
                                            style="background-color: #FFE292; color: #222847;">
                                        Masuk
                                    </button>
                                </div>

                                <!-- Remember Me -->
                                <div class="form-check mb-3">
                                    <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                    <label class="form-check-label text-white-50 small" for="remember_me">
                                        Remember me
                                    </label>
                                </div>

                                <!-- Forgot Password -->
                                @if (Route::has('password.request'))
                                    <div class="text-center">
                                        <a href="{{ route('password.request') }}" class="text-warning text-decoration-none small">
                                            Forgot your password?
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </form>

                        <!-- Footer -->
                        <div class="text-center mt-4">
                            <p class="text-white-50 small mb-2">
                                Dengan mendaftar, anda setuju dengan 
                                <a href="#" class="text-warning text-decoration-none">Pernyataan Layanan</a> dan 
                                <a href="#" class="text-warning text-decoration-none">Kebijakan Privasi</a>.
                            </p>
                            <p class="text-white-50 small mb-0">
                                Belum punya akun Toshop? 
                                <a href="{{ route('register') }}" class="text-warning text-decoration-none fw-semibold">Daftar Sekarang</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
