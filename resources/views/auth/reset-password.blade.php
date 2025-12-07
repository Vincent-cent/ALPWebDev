
    @extends('layouts.mainLayout')

@section('title', 'Reset Password - TOSHOP')

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
                        </div>

                        <!-- Reset Form -->
                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">
                            
                            <!-- Email Address -->
                            <div class="mb-3">
                                <input type="email" class="form-control rounded-pill py-3 ps-4" 
                                       name="email" value="{{ old('email', $request->email) }}" 
                                       placeholder="Email Address" required autofocus readonly>
                                @error('email')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- New Password -->
                            <div class="mb-3">
                                <input type="password" class="form-control rounded-pill py-3 ps-4" 
                                       name="password" placeholder="New Password" required>
                                @error('password')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-4">
                                <input type="password" class="form-control rounded-pill py-3 ps-4" 
                                       name="password_confirmation" placeholder="Confirm New Password" required>
                                @error('password_confirmation')
                                    <div class="text-danger small mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">
                                <button type="submit" class="btn rounded-pill py-3 fw-semibold" 
                                        style="background-color: #FFE292; color: #222847;">
                                    Reset Password
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

