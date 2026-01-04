@extends('layouts.admin_mainLayout')

@section('content')
<div class="container py-5">
    <div class="row mb-4">
        <div class="col-md-6">
            <h1>Tambah Item</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('admin.items.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label for="game_id" class="form-label">Game <span class="text-danger">*</span></label>
                            <select class="form-select @error('game_id') is-invalid @enderror" 
                                    id="game_id" name="game_id" required>
                                <option value="">-- Pilih Game --</option>
                                @foreach($games as $game)
                                    <option value="{{ $game->id }}" 
                                        {{ old('game_id', request('game_id')) == $game->id ? 'selected' : '' }}>
                                        {{ $game->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('game_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Item <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                   id="nama" name="nama" value="{{ old('nama') }}" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="item_id" class="form-label">Item ID</label>
                            <input type="text" class="form-control @error('item_id') is-invalid @enderror" 
                                   id="item_id" name="item_id" value="{{ old('item_id') }}" placeholder="e.g., DIAMOND_100">
                            <small class="text-muted">Identitas unik untuk item ini (e.g., DIAMOND_100, COIN_500)</small>
                            @error('item_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="harga" class="form-label">Harga <span class="text-danger">*</span></label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" class="form-control @error('harga') is-invalid @enderror" 
                                       id="harga" name="harga" value="{{ old('harga') }}" min="0" required>
                            </div>
                            @error('harga')
                                <div class="invalid-feedback d-block">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label for="tipe_item_id" class="form-label">Tipe Item</label>
                            <select class="form-select @error('tipe_item_id') is-invalid @enderror" 
                                    id="tipe_item_id" name="tipe_item_id">
                                <option value="">-- Pilih Tipe Item --</option>
                                @foreach($tipoItems as $tipe)
                                    <option value="{{ $tipe->id }}" {{ old('tipe_item_id') == $tipe->id ? 'selected' : '' }}>
                                        {{ $tipe->nama }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipe_item_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Simpan
                            </button>
                            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle"></i> Batal
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
