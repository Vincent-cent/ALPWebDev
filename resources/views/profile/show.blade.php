@extends('layouts.mainLayout')

@section('title', 'Profile - TOSHOP')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-lg border-0">
                <div class="card-body p-5">
                    <h2 class="mb-4">Profil Pengguna</h2>
                    
                    <div class="mb-3">
                        <label class="form-label"><strong>Nama:</strong></label>
                        <p class="form-control-plaintext">{{ $user->name }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Email:</strong></label>
                        <p class="form-control-plaintext">{{ $user->email }}</p>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><strong>Bergabung sejak:</strong></label>
                        <p class="form-control-plaintext">{{ $user->created_at->format('d M Y') }}</p>
                    </div>

                    <hr>

                    <div class="d-flex gap-2">
                        <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profil</a>
                        <a href="{{ route('beranda') }}" class="btn btn-secondary">Kembali</a>
                        
                        <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                            @csrf
                            <button type="submit" class="btn btn-danger">
                                <i class="fas fa-sign-out-alt me-2"></i>Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection