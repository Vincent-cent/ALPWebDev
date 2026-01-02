@extends('layouts.admin_mainLayout')

@section('title', 'Edit Game')

@section('content')
    @include('layouts.components.admin._admin_navigation')
    
    <main class="admin-main-content">
        <div class="container-fluid py-4">
            <div class="row mb-4">
                <div class="col-12">
                    <a href="{{ route('admin.games.index') }}" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>Back to Games
                    </a>
                </div>
            </div>

            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card">
                        <div class="card-header bg-warning text-dark">
                            <h4 class="mb-0"><i class="fas fa-edit me-2"></i>Edit Game</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('admin.games.update', $game) }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Game Name -->
                                <div class="mb-3">
                                    <label for="gameName" class="form-label">Game Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="gameName" name="name" value="{{ old('name', $game->name) }}" required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Description -->
                                <div class="mb-3">
                                    <label for="gameDescription" class="form-label">Description</label>
                                    <textarea class="form-control @error('description') is-invalid @enderror" 
                                              id="gameDescription" name="description" rows="4">{{ old('description', $game->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Game Type -->
                                <div class="mb-3">
                                    <label for="gameType" class="form-label">Game Type <span class="text-danger">*</span></label>
                                    <select class="form-control @error('tipe') is-invalid @enderror" 
                                            id="gameType" name="tipe" required>
                                        <option value="">-- Select Type --</option>
                                        <option value="game" {{ old('tipe', $game->tipe) === 'game' ? 'selected' : '' }}>Game</option>
                                        <option value="voucher" {{ old('tipe', $game->tipe) === 'voucher' ? 'selected' : '' }}>Voucher</option>
                                    </select>
                                    @error('tipe')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Game Image -->
                                <div class="mb-3">
                                    <label for="gameImage" class="form-label">Game Image</label>
                                    <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                           id="gameImage" name="image" accept="image/*">
                                    <small class="form-text text-muted">Max file size: 2MB. Allowed formats: JPG, PNG, GIF</small>
                                    @error('image')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    <div class="mt-3">
                                        @if($game->image)
                                            <div id="imagePreview">
                                                <p class="mb-2"><strong>Current Image:</strong></p>
                                                <img id="previewImg" src="{{ asset('storage/' . $game->image) }}" alt="Preview" 
                                                     style="max-width: 200px; max-height: 200px; border-radius: 4px;">
                                            </div>
                                        @else
                                            <div id="imagePreview" style="display: none;">
                                                <p class="mb-2"><strong>New Image Preview:</strong></p>
                                                <img id="previewImg" src="" alt="Preview" 
                                                     style="max-width: 200px; max-height: 200px; border-radius: 4px;">
                                            </div>
                                        @endif
                                    </div>
                                </div>

                                <!-- Status -->
                                <div class="mb-3">
                                    <label for="gameStatus" class="form-label">Status</label>
                                    <select class="form-control @error('is_active') is-invalid @enderror" 
                                            id="gameStatus" name="is_active">
                                        <option value="1" {{ old('is_active', $game->is_active) == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ old('is_active', $game->is_active) == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                    @error('is_active')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Submit Buttons -->
                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-warning">
                                        <i class="fas fa-save me-2"></i>Update Game
                                    </button>
                                    <a href="{{ route('admin.games.index') }}" class="btn btn-secondary">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection
