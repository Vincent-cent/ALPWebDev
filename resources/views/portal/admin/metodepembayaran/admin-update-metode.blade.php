@extends('layouts.admin_mainLayout')

@section('title', 'Edit Payment Method')

@section('content')
    @include('layouts.components.admin._admin_navigation')
    
    <main class="admin-main-content">
        <div class="container-fluid py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Edit Payment Method: {{ $metodePembayaran->name }}</h1>
                <a href="{{ route('admin.metode-pembayarans.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.metode-pembayarans.update', $metodePembayaran) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Payment Method Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name', $metodePembayaran->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="type" class="form-label">Type</label>
                                    <select class="form-select @error('type') is-invalid @enderror" id="type" name="type" required>
                                        <option value="">Select Type</option>
                                        <option value="bank_transfer" {{ old('type', $metodePembayaran->type) === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="qris" {{ old('type', $metodePembayaran->type) === 'qris' ? 'selected' : '' }}>QRIS</option>
                                        <option value="saldo" {{ old('type', $metodePembayaran->type) === 'saldo' ? 'selected' : '' }}>Saldo</option>
                                        <option value="ewallet" {{ old('type', $metodePembayaran->type) === 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="fee" class="form-label">Admin Fee</label>
                            <input type="number" class="form-control @error('fee') is-invalid @enderror" 
                                   id="fee" name="fee" value="{{ old('fee', $metodePembayaran->fee) }}" 
                                   step="0.01" min="0" required>
                            @error('fee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Enter admin fee amount in Rupiah</small>
                        </div>
                        
                        @if($metodePembayaran->logo)
                        <div class="mb-3">
                            <label class="form-label">Current Logo</label>
                            <div class="mb-2">
                                <img src="{{ asset('storage/payment-methods/' . $metodePembayaran->logo) }}" 
                                     alt="{{ $metodePembayaran->name }}" 
                                     style="max-width: 100px; max-height: 100px; object-fit: contain; border-radius: 4px;">
                            </div>
                            <small class="text-muted">{{ $metodePembayaran->logo }}</small>
                        </div>
                        @endif
                        
                        <div class="mb-3">
                            <label for="logo" class="form-label">Update Logo</label>
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                                   id="logo" name="logo" accept="image/*">
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Max size: 2MB. Leave empty to keep current logo</small>
                        </div>
                        
                        @if(!empty($existingLogos))
                        <div class="mb-3">
                            <label for="existing_logo" class="form-label">Or Select Existing Logo</label>
                            <select class="form-select @error('existing_logo') is-invalid @enderror" 
                                    id="existing_logo" name="existing_logo">
                                <option value="">Choose existing logo...</option>
                                @foreach($existingLogos as $existingLogo)
                                <option value="{{ $existingLogo }}" 
                                        {{ old('existing_logo', $metodePembayaran->logo) === $existingLogo ? 'selected' : '' }}>
                                    {{ $existingLogo }}
                                </option>
                                @endforeach
                            </select>
                            @error('existing_logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        @endif
                        
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" 
                                       id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', $metodePembayaran->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.metode-pembayarans.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Payment Method</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection