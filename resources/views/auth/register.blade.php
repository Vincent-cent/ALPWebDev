    @extends('layouts.mainLayout')

@section('title', 'Register - TOSHOP')

@section('content')
<div class="min-vh-100 d-flex align-items-center justify-content-center" style="background: linear-gradient(135deg, #2c3e50, #34495e);">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="card shadow-lg border-0" style="background-color: rgba(52, 73, 94, 0.9); border-radius: 20px;">
                    <div class="card-body p-5">
                        <!-- Header -->
                        <div class="text-center mb-4">
                            <h2 class="text-white fw-bold mb-4">TOSHOP Register</h2>
                        </div>

                        <!-- Register Form -->
                        <form method="POST" action="{{ route('register') }}">
                            @csrf
                            
                            <!-- Username -->
                            <div class="mb-3">
                                <label class="form-label text-white fw-semibold">Username</label>
                                <input type="text" class="form-control rounded-pill py-3 ps-4" 
                                       name="name" value="{{ old('name') }}" 
                                       style="background-color: rgba(44, 62, 80, 0.8); border: 2px solid rgba(255, 255, 255, 0.2); color: white;" 
                                       required autofocus>
                                @error('name')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Email Address -->
                            <div class="mb-3">
                                <label class="form-label text-white fw-semibold">Email Address</label>
                                <input type="email" class="form-control rounded-pill py-3 ps-4" 
                                       name="email" value="{{ old('email') }}" 
                                       style="background-color: rgba(44, 62, 80, 0.8); border: 2px solid rgba(255, 255, 255, 0.2); color: white;" 
                                       required>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label text-white fw-semibold">Password</label>
                                <input type="password" class="form-control rounded-pill py-3 ps-4" 
                                       name="password" 
                                       style="background-color: rgba(44, 62, 80, 0.8); border: 2px solid rgba(255, 255, 255, 0.2); color: white;" 
                                       required>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <label class="form-label text-white fw-semibold">Masukkan Ulang Password</label>
                                <input type="password" class="form-control rounded-pill py-3 ps-4" 
                                       name="password_confirmation" 
                                       style="background-color: rgba(44, 62, 80, 0.8); border: 2px solid rgba(255, 255, 255, 0.2); color: white;" 
                                       required>
                                @error('password_confirmation')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Register Button -->
                            <div class="d-grid mb-4">
                                <button type="submit" class="btn rounded-pill py-3 fw-semibold" 
                                        style="background-color: #FFE292; color: #222847; border: none;">
                                    Register
                                </button>
                            </div>
                        </form>

                        <!-- Footer -->
                        <div class="text-center">
                            <p class="text-white-50 small mb-0">
                                Already have an account? 
                                <a href="{{ route('login') }}" class="text-warning text-decoration-none fw-semibold">Login</a>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
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
@endsection

