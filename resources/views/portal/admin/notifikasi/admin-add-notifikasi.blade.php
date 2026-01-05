@extends('layouts.admin_mainLayout')

@section('title', 'Add Promo Notification')

@section('content')
    @include('layouts.components.admin._admin_navigation')
    
    <main class="admin-main-content">
        <div class="container-fluid py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Add New Notification</h1>
                <a href="{{ route('admin.promo-notifikasi.index') }}" class="btn btn-secondary">
                    <i class="fas fa-arrow-left me-2"></i>Back to List
                </a>
            </div>
            
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.promo-notifikasi.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="mb-3">
                            <label for="title" class="form-label">Title</label>
                            <input type="text" class="form-control @error('title') is-invalid @enderror" 
                                   id="title" name="title" value="{{ old('title') }}" required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="description" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" name="description" rows="5" required>{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="content" class="form-label">Content</label>
                            <textarea class="form-control @error('content') is-invalid @enderror" 
                                      id="content" name="content" rows="3">{{ old('content') }}</textarea>
                            @error('content')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="mb-3">
                            <label for="promo_code_id" class="form-label">Related Promo Code</label>
                            <select class="form-select @error('promo_code_id') is-invalid @enderror" 
                                    id="promo_code_id" name="promo_code_id" required>
                                <option value="">Select Promo Code</option>
                                @foreach($promoCodes as $promo)
                                    <option value="{{ $promo->id }}" {{ old('promo_code_id') == $promo->id ? 'selected' : '' }}>
                                        {{ $promo->code }} ({{ $promo->tipeItem?->name ?? 'All Items' }})
                                    </option>
                                @endforeach
                            </select>
                            @error('promo_code_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="priority" class="form-label">Priority</label>
                                <select class="form-select @error('priority') is-invalid @enderror" 
                                        id="priority" name="priority">
                                    <option value="low" {{ old('priority', 'medium') === 'low' ? 'selected' : '' }}>Low</option>
                                    <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Medium</option>
                                    <option value="high" {{ old('priority', 'medium') === 'high' ? 'selected' : '' }}>High</option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6">
                                <label for="type" class="form-label">Type</label>
                                <select class="form-select @error('type') is-invalid @enderror" 
                                        id="type" name="type">
                                    <option value="general" {{ old('type', 'general') === 'general' ? 'selected' : '' }}>General</option>
                                    <option value="promo" {{ old('type', 'general') === 'promo' ? 'selected' : '' }}>Promo</option>
                                    <option value="alert" {{ old('type', 'general') === 'alert' ? 'selected' : '' }}>Alert</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active" value="1" 
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    Active
                                </label>
                            </div>
                        </div>
                        
                        <div class="mb-3">
                            <label for="image" class="form-label">Notification Image</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="image" name="image" accept="image/*">
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Max size: 2MB. Recommended: 300x200 pixels</small>
                            
                            <!-- Image Preview -->
                            <div id="image-preview" class="mt-3" style="display: none;">
                                <img id="preview-img" src="" alt="Preview" 
                                     style="max-width: 200px; max-height: 200px; object-fit: contain; border-radius: 4px;">
                            </div>
                        </div>
                        
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Create Notification
                            </button>
                            <a href="{{ route('admin.promo-notifikasi.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-2"></i>Cancel
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    
    <script>
        // Image preview
        document.getElementById('image').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(event) {
                    document.getElementById('preview-img').src = event.target.result;
                    document.getElementById('image-preview').style.display = 'block';
                };
                reader.readAsDataURL(file);
            }
        });
    </script>
@endsection
