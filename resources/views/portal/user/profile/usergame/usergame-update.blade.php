@extends('layouts.mainLayout')

@section('title', 'Edit Game ID - TOSHOP')

@section('content')
<div class="min-vh-100" style="background: linear-gradient(135deg, #2c3e50, #34495e); padding-top: 2rem; padding-bottom: 2rem;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <!-- Header -->
                <div class="d-flex align-items-center mb-4">
                    <a href="{{ route('profile.show') }}" class="btn btn-outline-light me-3 rounded-circle" style="width: 45px; height: 45px;">
                        <i class="fas fa-arrow-left"></i>
                    </a>
                    <div>
                        <h2 class="text-white fw-bold mb-0">EDIT GAME ID</h2>
                        <p class="text-white-50 mb-0">Perbarui informasi ID game Anda</p>
                    </div>
                </div>

                <!-- Form Card -->
                <div class="card border-0 shadow-lg" style="background: rgba(52, 73, 94, 0.9); border-radius: 20px;">
                    <div class="card-body p-4">
                        <form action="{{ route('usergame.update', $userGame->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <!-- Game Selection -->
                            <div class="mb-4">
                                <label for="game_id" class="form-label text-white fw-semibold">
                                    <i class="fas fa-gamepad me-2"></i>Pilih Game
                                </label>
                                <select class="form-select rounded-pill @error('game_id') is-invalid @enderror" 
                                        id="game_id" name="game_id" required
                                        style="background-color: rgba(44, 62, 80, 0.8); border: none; color: white;">
                                    <option value="">-- Pilih Game --</option>
                                    @foreach($games as $game)
                                        <option value="{{ $game->id }}" 
                                                {{ (old('game_id', $userGame->game_id) == $game->id) ? 'selected' : '' }}>
                                            {{ $game->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('game_id')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- User Game UID -->
                            <div class="mb-4">
                                <label for="user_game_uid" class="form-label text-white fw-semibold">
                                    <i class="fas fa-hashtag me-2"></i>User ID Game
                                </label>
                                <input type="text" 
                                       class="form-control rounded-pill @error('user_game_uid') is-invalid @enderror" 
                                       id="user_game_uid" 
                                       name="user_game_uid" 
                                       value="{{ old('user_game_uid', $userGame->user_game_uid) }}"
                                       placeholder="Masukkan User ID game Anda"
                                       style="background-color: rgba(44, 62, 80, 0.8); border: none; color: white;" 
                                       required>
                                @error('user_game_uid')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Nickname -->
                            <div class="mb-4">
                                <label for="nickname" class="form-label text-white fw-semibold">
                                    <i class="fas fa-user me-2"></i>Nickname (Opsional)
                                </label>
                                <input type="text" 
                                       class="form-control rounded-pill @error('nickname') is-invalid @enderror" 
                                       id="nickname" 
                                       name="nickname" 
                                       value="{{ old('nickname', $userGame->nickname) }}"
                                       placeholder="Nickname atau nama karakter"
                                       style="background-color: rgba(44, 62, 80, 0.8); border: none; color: white;">
                                @error('nickname')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Submit Button -->
                            <div class="d-flex gap-3">
                                <button type="submit" class="btn rounded-pill px-4 py-2 flex-fill fw-semibold" 
                                        style="background-color: #3498db; color: white;">
                                    <i class="fas fa-save me-2"></i>Perbarui Game ID
                                </button>
                                <a href="{{ route('profile.show') }}" 
                                   class="btn btn-outline-light rounded-pill px-4 py-2">
                                    <i class="fas fa-times me-2"></i>Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.form-select:focus, .form-control:focus {
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
