@extends('layouts.admin_mainLayout')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container-fluid px-0"
        style="background: linear-gradient(135deg, #1a1f3a 0%, #2d3561 100%); min-height: 100vh;">
        
        <!-- Banners Section -->
        <section class="py-5" id="banners">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-inline-block px-5 py-3 rounded-pill" 
                         style="background: linear-gradient(90deg, #2C3356 0%, #424A70 100%); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);">
                        <h2 class="fw-bold text-white text-uppercase mb-0" 
                            style="letter-spacing: 2px; font-size: 1.2rem;">
                            Banners Management
                        </h2>
                    </div>
                    <a href="{{ route('admin.banners.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Add Banner
                    </a>
                </div>
                
                <div class="row g-3">
                    @if (isset($banners) && $banners->count() > 0)
                        @foreach ($banners as $banner)
                            <div class="col-lg-3 col-md-4 col-6">
                                <div class="card border-0 shadow-sm h-100" style="background: #2a3150; border-radius: 15px; overflow: hidden; position: relative;">
                                    <div class="position-relative" style="height: 200px; overflow: hidden;">
                                        @php
                                            $bannerImage = $banner->image && file_exists(public_path($banner->image))
                                                ? asset($banner->image)
                                                : asset('placeholder.jpg');
                                        @endphp
                                        <img src="{{ $bannerImage }}" alt="{{ $banner->name }}" 
                                             class="w-100 h-100" style="object-fit: cover;">
                                    </div>
                                    <div class="card-body p-3">
                                        <h6 class="card-title text-white fw-bold mb-3">{{ $banner->name }}</h6>
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('admin.banners.edit', $banner->id) }}" class="btn btn-sm btn-warning flex-grow-1">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <button class="btn btn-sm btn-danger flex-grow-1" data-bs-toggle="modal" data-bs-target="#deleteBannerModal{{ $banner->id }}">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Banner Modal -->
                            <div class="modal fade" id="deleteBannerModal{{ $banner->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="background: #2a3150; border: none;">
                                        <div class="modal-header" style="border-bottom: 1px solid #424A70;">
                                            <h5 class="modal-title text-white">Confirm Delete</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-white">
                                            Are you sure you want to delete this banner?
                                        </div>
                                        <div class="modal-footer" style="border-top: 1px solid #424A70;">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('admin.banners.destroy', $banner->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="alert alert-info text-white">No banners found. <a href="{{ route('admin.banners.create') }}" class="alert-link">Create one</a></div>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Games Section -->
        <section class="py-5" id="games">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-inline-block px-5 py-3 rounded-pill" 
                         style="background: linear-gradient(90deg, #2C3356 0%, #424A70 100%); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);">
                        <h2 class="fw-bold text-white text-uppercase mb-0" 
                            style="letter-spacing: 2px; font-size: 1.2rem;">
                            Games Management
                        </h2>
                    </div>
                    <a href="{{ route('admin.games.create') }}" class="btn btn-success">
                        <i class="fas fa-plus me-2"></i>Add Game
                    </a>
                </div>
                
                <div class="row g-3">
                    @if (isset($games) && $games->count() > 0)
                        @foreach ($games as $game)
                            <div class="col-lg-2 col-md-3 col-4">
                                <div class="card border-0 shadow-sm h-100" style="background: #2a3150; border-radius: 15px; overflow: hidden;">
                                    <div class="position-relative" style="height: 150px; overflow: hidden;">
                                        @php
                                            $gameImage = $game->image && file_exists(public_path($game->image))
                                                ? asset($game->image)
                                                : asset('placeholder.jpg');
                                        @endphp
                                        <img src="{{ $gameImage }}" alt="{{ $game->name }}" 
                                             class="w-100 h-100" style="object-fit: cover;">
                                    </div>
                                    <div class="card-body p-2">
                                        <h6 class="card-title text-white fw-bold mb-2" style="font-size: 0.85rem;">{{ $game->name }}</h6>
                                        <div class="d-flex gap-1 flex-column">
                                            <button class="btn btn-sm btn-info w-100" data-bs-toggle="modal" data-bs-target="#gameItemsModal{{ $game->id }}">
                                                <i class="fas fa-list me-1"></i>Items ({{ $game->items->count() }})
                                            </button>
                                            <div class="d-flex gap-1">
                                                <a href="{{ route('admin.games.edit', $game->id) }}" class="btn btn-sm btn-warning flex-grow-1">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <button class="btn btn-sm btn-danger flex-grow-1" data-bs-toggle="modal" data-bs-target="#deleteGameModal{{ $game->id }}">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Game Modal -->
                            <div class="modal fade" id="deleteGameModal{{ $game->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content" style="background: #2a3150; border: none;">
                                        <div class="modal-header" style="border-bottom: 1px solid #424A70;">
                                            <h5 class="modal-title text-white">Confirm Delete</h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-white">
                                            Are you sure you want to delete {{ $game->name }}?
                                        </div>
                                        <div class="modal-footer" style="border-top: 1px solid #424A70;">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                            <form action="{{ route('admin.games.destroy', $game->id) }}" method="POST" style="display: inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Game Items Modal -->
                            <div class="modal fade" id="gameItemsModal{{ $game->id }}" tabindex="-1" style="z-index: 1100;">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content" style="background: #2a3150; border: none;">
                                        <div class="modal-header" style="border-bottom: 1px solid #424A70;">
                                            <h5 class="modal-title text-white">
                                                <i class="fas fa-gamepad me-2"></i>{{ $game->name }} - Items
                                            </h5>
                                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body" style="max-height: 400px; overflow-y: auto;">
                                            @if($game->items->count() > 0)
                                                <div class="row g-2">
                                                    @foreach($game->items as $item)
                                                        <div class="col-md-6">
                                                            <div class="card border-0" style="background: #1a1f3a;">
                                                                <div class="card-body p-3">
                                                                    <h6 class="card-title text-white fw-bold">{{ $item->nama }}</h6>
                                                                    <p class="text-warning mb-2">
                                                                        <strong>Rp {{ number_format($item->harga, 0, ',', '.') }}</strong>
                                                                    </p>
                                                                    <div class="d-flex gap-2">
                                                                        <a href="{{ route('admin.items.edit', $item->id) }}" class="btn btn-sm btn-warning flex-grow-1">
                                                                            <i class="fas fa-edit"></i> Edit
                                                                        </a>
                                                                        <button class="btn btn-sm btn-danger" data-bs-toggle="modal" data-bs-target="#deleteItemModal{{ $item->id }}">
                                                                            <i class="fas fa-trash"></i>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                </div>
                                            @else
                                                <div class="alert alert-info text-white mb-0">
                                                    Tidak ada item untuk game ini. 
                                                    <a href="{{ route('admin.items.create') }}?game_id={{ $game->id }}" class="alert-link">Tambah item</a>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="modal-footer" style="border-top: 1px solid #424A70;">
                                            <a href="{{ route('admin.items.create') }}?game_id={{ $game->id }}" class="btn btn-success">
                                                <i class="fas fa-plus me-2"></i>Tambah Item
                                            </a>
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Delete Item Modal inside Game Items -->
                            @foreach($game->items as $item)
                                <div class="modal fade" id="deleteItemModal{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content" style="background: #2a3150; border: none;">
                                            <div class="modal-header" style="border-bottom: 1px solid #424A70;">
                                                <h5 class="modal-title text-white">Confirm Delete</h5>
                                                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                                            </div>
                                            <div class="modal-body text-white">
                                                Are you sure you want to delete {{ $item->nama }}?
                                            </div>
                                            <div class="modal-footer" style="border-top: 1px solid #424A70;">
                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                                <form action="{{ route('admin.items.destroy', $item->id) }}" method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">Delete</button>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endforeach
                    @else
                        <div class="col-12">
                            <div class="alert alert-info text-white">No games found. <a href="{{ route('admin.games.create') }}" class="alert-link">Create one</a></div>
                        </div>
                    @endif
                </div>
            </div>
        </section>

        <!-- Tipe Items Management Section -->
        <section class="py-5" id="tipeItems">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-inline-block px-5 py-3 rounded-pill" 
                         style="background: linear-gradient(90deg, #2C3356 0%, #424A70 100%); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);">
                        <h2 class="fw-bold text-white text-uppercase mb-0" 
                            style="letter-spacing: 2px; font-size: 1.2rem;">
                            Tipe Item Management
                        </h2>
                    </div>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTipeItemModal">
                        <i class="fas fa-plus me-2"></i>Tambah Tipe Item
                    </button>
                </div>

                <div class="card border-0" style="background: #1a1f3a; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="background: #2a3150;">
                            <thead>
                                <tr style="background: #424A70;">
                                    <th class="text-white fw-bold py-3">No</th>
                                    <th class="text-white fw-bold py-3">Nama</th>
                                    <th class="text-white fw-bold py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $tipeItems = \App\Models\TipeItem::all();
                                @endphp
                                @forelse($tipeItems as $tipe)
                                    <tr style="background: #2a3150; border-bottom: 1px solid #424A70;">
                                        <td class="text-white py-3">{{ $loop->iteration }}</td>
                                        <td class="text-white py-3 fw-semibold">{{ $tipe->nama ?? '-' }}</td>
                                        <td class="py-3">
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editTipeItemModal{{ $tipe->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <form action="{{ route('admin.tipe-items.destroy', $tipe->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr style="background: #2a3150;">
                                        <td colspan="3" class="text-center text-white py-4">
                                            Tidak ada tipe item
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- Add Tipe Item Modal -->
        <div class="modal fade" id="addTipeItemModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" style="background: #2a3150; border: none;">
                    <div class="modal-header" style="border-bottom: 1px solid #424A70;">
                        <h5 class="modal-title text-white">Tambah Tipe Item Baru</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.tipe-items.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="nama" class="form-label text-white fw-semibold">Nama Tipe Item</label>
                                <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                       id="nama" name="nama" required style="background: #1a1f3a; color: #fff; border-color: #424A70;">
                                @error('nama')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                        <div class="modal-footer" style="border-top: 1px solid #424A70;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Tipe Item Modals -->
        @php
            $tipeItems = \App\Models\TipeItem::all();
        @endphp
        @foreach($tipeItems as $tipe)
            <div class="modal fade" id="editTipeItemModal{{ $tipe->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content" style="background: #2a3150; border: none;">
                        <div class="modal-header" style="border-bottom: 1px solid #424A70;">
                            <h5 class="modal-title text-white">Edit Tipe Item</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('admin.tipe-items.update', $tipe->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="nama" class="form-label text-white fw-semibold">Nama Tipe Item</label>
                                    <input type="text" class="form-control @error('nama') is-invalid @enderror" 
                                           id="nama" name="nama" value="{{ $tipe->nama }}" required style="background: #1a1f3a; color: #fff; border-color: #424A70;">
                                    @error('nama')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top: 1px solid #424A70;">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Perbarui</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach

        <!-- Metode Pembayaran Management Section -->
        <section class="py-5" id="metodePembayaran">
            <div class="container">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="d-inline-block px-5 py-3 rounded-pill" 
                         style="background: linear-gradient(90deg, #2C3356 0%, #424A70 100%); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);">
                        <h2 class="fw-bold text-white text-uppercase mb-0" 
                            style="letter-spacing: 2px; font-size: 1.2rem;">
                            Metode Pembayaran Management
                        </h2>
                    </div>
                    <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addMetodePembayaranModal">
                        <i class="fas fa-plus me-2"></i>Tambah Metode Pembayaran
                    </button>
                </div>

                <div class="card border-0" style="background: #1a1f3a; box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0" style="background: #2a3150;">
                            <thead>
                                <tr style="background: #424A70;">
                                    <th class="text-white fw-bold py-3">No</th>
                                    <th class="text-white fw-bold py-3">Nama</th>
                                    <th class="text-white fw-bold py-3">Fee</th>
                                    <th class="text-white fw-bold py-3">Type</th>
                                    <th class="text-white fw-bold py-3">Status</th>
                                    <th class="text-white fw-bold py-3">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    $metodePembayarans = \App\Models\MetodePembayaran::all();
                                @endphp
                                @forelse($metodePembayarans as $metode)
                                    <tr style="background: #2a3150; border-bottom: 1px solid #424A70;">
                                        <td class="text-white py-3">{{ $loop->iteration }}</td>
                                        <td class="text-white py-3 fw-semibold">{{ $metode->name ?? '-' }}</td>
                                        <td class="text-warning py-3 fw-bold">Rp {{ number_format($metode->fee ?? 0, 0, ',', '.') }}</td>
                                        <td class="text-white py-3">{{ $metode->type ?? '-' }}</td>
                                        <td class="py-3">
                                            @if($metode->is_active)
                                                <span class="badge bg-success">Aktif</span>
                                            @else
                                                <span class="badge bg-secondary">Tidak Aktif</span>
                                            @endif
                                        </td>
                                        <td>
                                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal" data-bs-target="#editMetodeModal{{ $metode->id }}">
                                                <i class="fas fa-edit"></i> Edit
                                            </button>
                                            <form action="{{ route('admin.metode-pembayarans.destroy', $metode->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Yakin ingin menghapus?')">
                                                    <i class="fas fa-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr style="background: #2a3150;">
                                        <td colspan="6" class="text-center text-white py-4">
                                            Tidak ada metode pembayaran
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <!-- Add Metode Pembayaran Modal -->
        <div class="modal fade" id="addMetodePembayaranModal" tabindex="-1">
            <div class="modal-dialog">
                <div class="modal-content" style="background: #2a3150; border: none;">
                    <div class="modal-header" style="border-bottom: 1px solid #424A70;">
                        <h5 class="modal-title text-white">Tambah Metode Pembayaran Baru</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <form action="{{ route('admin.metode-pembayarans.store') }}" method="POST">
                        @csrf
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="name" class="form-label text-white fw-semibold">Nama Metode</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                       id="name" name="name" required style="background: #1a1f3a; color: #fff; border-color: #424A70;">
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="fee" class="form-label text-white fw-semibold">Fee (Rp)</label>
                                <input type="number" class="form-control @error('fee') is-invalid @enderror" 
                                       id="fee" name="fee" value="0" min="0" required style="background: #1a1f3a; color: #fff; border-color: #424A70;">
                                @error('fee')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <label for="type" class="form-label text-white fw-semibold">Type</label>
                                <input type="text" class="form-control @error('type') is-invalid @enderror" 
                                       id="type" name="type" placeholder="e.g., Bank Transfer, E-Wallet" required style="background: #1a1f3a; color: #fff; border-color: #424A70;">
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="mb-3">
                                <div class="form-check form-switch">
                                    <input type="hidden" name="is_active" value="0">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                           value="1" checked>
                                    <label class="form-check-label text-white" for="is_active">
                                        Aktif
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer" style="border-top: 1px solid #424A70;">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Tambah</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Edit Metode Pembayaran Modals -->
        @php
            $metodePembayarans = \App\Models\MetodePembayaran::all();
        @endphp
        @foreach($metodePembayarans as $metode)
            <div class="modal fade" id="editMetodeModal{{ $metode->id }}" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content" style="background: #2a3150; border: none;">
                        <div class="modal-header" style="border-bottom: 1px solid #424A70;">
                            <h5 class="modal-title text-white">Edit Metode Pembayaran</h5>
                            <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                        </div>
                        <form action="{{ route('admin.metode-pembayarans.update', $metode->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="name" class="form-label text-white fw-semibold">Nama Metode</label>
                                    <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                           id="name" name="name" value="{{ $metode->name }}" required style="background: #1a1f3a; color: #fff; border-color: #424A70;">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="fee" class="form-label text-white fw-semibold">Fee (Rp)</label>
                                    <input type="number" class="form-control @error('fee') is-invalid @enderror" 
                                           id="fee" name="fee" value="{{ $metode->fee }}" min="0" required style="background: #1a1f3a; color: #fff; border-color: #424A70;">
                                    @error('fee')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="type" class="form-label text-white fw-semibold">Type</label>
                                    <input type="text" class="form-control @error('type') is-invalid @enderror" 
                                           id="type" name="type" value="{{ $metode->type }}" required style="background: #1a1f3a; color: #fff; border-color: #424A70;">
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <div class="form-check form-switch">
                                        <input type="hidden" name="is_active" value="0">
                                        <input class="form-check-input" type="checkbox" id="is_active" name="is_active" 
                                               value="1" {{ $metode->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label text-white" for="is_active">
                                            Aktif
                                        </label>
                                    </div>
                                </div>
                            </div>
                            <div class="modal-footer" style="border-top: 1px solid #424A70;">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Perbarui</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection
