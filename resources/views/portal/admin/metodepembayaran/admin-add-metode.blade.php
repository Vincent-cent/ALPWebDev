@extends('layouts.admin_mainLayout')

@section('title', 'Add Payment Method')

@section('content')
    @include('layouts.components.admin._admin_navigation')
    
    <main class="admin-main-content">
        <div class="container-fluid py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Add New Payment Method</h1>
                <a href="{{ route('admin.metode-pembayarans.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.metode-pembayarans.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="name" class="form-label">Payment Method Name</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ old('name') }}" required>
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
                                        <option value="bank_transfer" {{ old('type') === 'bank_transfer' ? 'selected' : '' }}>Bank Transfer</option>
                                        <option value="qris" {{ old('type') === 'qris' ? 'selected' : '' }}>QRIS</option>
                                        <option value="saldo" {{ old('type') === 'saldo' ? 'selected' : '' }}>Saldo</option>
                                        <option value="ewallet" {{ old('type') === 'ewallet' ? 'selected' : '' }}>E-Wallet</option>
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
                                   id="fee" name="fee" value="{{ old('fee', 0) }}" 
                                   step="0.01" min="0" required>
                            @error('fee')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Enter admin fee amount in Rupiah</small>
                        </div>
                        
                        <div class="mb-3">
                            <label for="logo" class="form-label">Logo</label>
                            <input type="file" class="form-control @error('logo') is-invalid @enderror" 
                                   id="logo" name="logo" accept="image/*">
                            @error('logo')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Max size: 2MB. Recommended: 100x100 pixels</small>
                            
                            <!-- Image Preview -->
                            <div id="logo-preview" class="mt-3" style="display: none;">
                                <img id="preview-img" src="" alt="Preview" 
                                     style="max-width: 100px; max-height: 100px; object-fit: contain; border-radius: 4px;">
                            </div>
                        </div>
                        
                        @if(!empty($existingLogos))
                        <div class="mb-3">
                            <label for="existing_logo" class="form-label">Or Select Existing Logo</label>
                            <select class="form-select @error('existing_logo') is-invalid @enderror" 
                                    id="existing_logo" name="existing_logo">
                                <option value="">Choose existing logo...</option>
                                @foreach($existingLogos as $existingLogo)
                                <option value="{{ $existingLogo }}" {{ old('existing_logo') === $existingLogo ? 'selected' : '' }}>
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
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">Active</label>
                            </div>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.metode-pembayarans.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Create Payment Method</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
    @vite('resources/js/admin/payment-method-form.js')
@endsection