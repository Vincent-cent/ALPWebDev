@extends('layouts.admin_mainLayout')

@section('title', 'Edit Promo Code')

@section('content')
    @include('layouts.components.admin._admin_navigation')
    
    <main class="admin-main-content">
        <div class="container-fluid py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Edit Promo Code: {{ $promoCode->code }}</h1>
                <a href="{{ route('admin.promo-codes.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.promo-codes.update', $promoCode) }}" method="POST">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="code" class="form-label">Promo Code</label>
                                    <input type="text" class="form-control @error('code') is-invalid @enderror" 
                                           id="code" name="code" value="{{ old('code', $promoCode->code) }}" required>
                                    @error('code')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="kuota" class="form-label">Quota (Uses)</label>
                                    <input type="number" class="form-control @error('kuota') is-invalid @enderror" 
                                           id="kuota" name="kuota" value="{{ old('kuota', $promoCode->kuota) }}" 
                                           min="1" required>
                                    @error('kuota')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="discount_type" class="form-label">Discount Type</label>
                                    <select class="form-select @error('discount_type') is-invalid @enderror" id="discount_type" name="discount_type" required>
                                        <option value="">Select Discount Type</option>
                                        <option value="amount" {{ old('discount_type', $promoCode->discount_amount ? 'amount' : '') === 'amount' ? 'selected' : '' }}>Fixed Amount</option>
                                        <option value="percent" {{ old('discount_type', $promoCode->discount_percent ? 'percent' : '') === 'percent' ? 'selected' : '' }}>Percentage</option>
                                    </select>
                                    @error('discount_type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="discount_amount" class="form-label">Discount Amount (Rp)</label>
                                    <input type="number" class="form-control @error('discount_amount') is-invalid @enderror" 
                                           id="discount_amount" name="discount_amount" value="{{ old('discount_amount', $promoCode->discount_amount) }}" 
                                           step="0.01" min="0">
                                    @error('discount_amount')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">For fixed amount discount</small>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="discount_percent" class="form-label">Discount Percentage (%)</label>
                                    <input type="number" class="form-control @error('discount_percent') is-invalid @enderror" 
                                           id="discount_percent" name="discount_percent" value="{{ old('discount_percent', $promoCode->discount_percent) }}" 
                                           step="0.01" min="0" max="100">
                                    @error('discount_percent')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">For percentage discount</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="start_at" class="form-label">Valid From</label>
                                    <input type="datetime-local" class="form-control @error('start_at') is-invalid @enderror" 
                                           id="start_at" name="start_at" 
                                           value="{{ old('start_at', $promoCode->start_at ? $promoCode->start_at->format('Y-m-d\TH:i') : '') }}" required>
                                    @error('start_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="end_at" class="form-label">Valid Until</label>
                                    <input type="datetime-local" class="form-control @error('end_at') is-invalid @enderror" 
                                           id="end_at" name="end_at" 
                                           value="{{ old('end_at', $promoCode->end_at ? $promoCode->end_at->format('Y-m-d\TH:i') : '') }}" required>
                                    @error('end_at')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tipe_item_id" class="form-label">Item Type (Optional)</label>
                                    <select class="form-select @error('tipe_item_id') is-invalid @enderror" id="tipe_item_id" name="tipe_item_id">
                                        <option value="">All Item Types</option>
                                        @foreach($tipeItems ?? [] as $tipeItem)
                                        <option value="{{ $tipeItem->id }}" {{ old('tipe_item_id', $promoCode->tipe_item_id) == $tipeItem->id ? 'selected' : '' }}>
                                            {{ $tipeItem->name }}
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('tipe_item_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        
                        <!-- Usage Statistics -->
                        <div class="alert alert-info">
                            <strong>Usage Statistics:</strong><br>
                            Quota: {{ $promoCode->kuota }} uses<br>
                            Valid: {{ $promoCode->start_at ? $promoCode->start_at->format('d M Y H:i') : 'N/A' }} to {{ $promoCode->end_at ? $promoCode->end_at->format('d M Y H:i') : 'N/A' }}
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <a href="{{ route('admin.promo-codes.index') }}" class="btn btn-secondary me-2">Cancel</a>
                            <button type="submit" class="btn btn-primary">Update Promo Code</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
@endsection

@section('scripts')
@vite('resources/js/admin/promocode-form.js')
@endsection