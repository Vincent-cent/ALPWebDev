@extends('layouts.admin_mainLayout')

@section('title', 'My Profile')

@section('content')
    @include('layouts.components.admin._admin_navigation')
    
    <main class="admin-main-content">
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2><i class="fas fa-user me-2"></i>My Profile</h2>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="row">
                <!-- Profile Card -->
                <div class="col-md-6 mb-4">
                    <div class="card">
                        <div class="card-header bg-primary text-white">
                            <h5 class="mb-0"><i class="fas fa-info-circle me-2"></i>Profile Information</h5>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <label class="form-label text-muted">Full Name</label>
                                <p class="h5">{{ $user->name }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Email</label>
                                <p class="h5">{{ $user->email }}</p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Role</label>
                                <p>
                                    <span class="badge bg-{{ $user->role === 'admin' ? 'danger' : 'info' }}">
                                        {{ ucfirst($user->role) }}
                                    </span>
                                </p>
                            </div>
                            <div class="mb-3">
                                <label class="form-label text-muted">Member Since</label>
                                <p>{{ $user->created_at->format('d M Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

            <!-- Quick Links -->
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 col-lg-3 mb-3">
                                    <a href="{{ route('profile.admin.admin-editprofile') }}" class="btn btn-outline-primary w-100">
                                        <i class="fas fa-user-edit me-2"></i>Edit Profile
                                    </a>
                                </div>
                                <div class="col-md-6 col-lg-3 mb-3">
                                    <form action="{{ route('logout') }}" method="POST" class="w-100">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-warning w-100">
                                            <i class="fas fa-sign-out-alt me-2"></i>Logout
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
