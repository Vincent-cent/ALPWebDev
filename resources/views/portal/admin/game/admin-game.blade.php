@extends('layouts.admin_mainLayout')

@section('title', 'Game Management')

@section('content')
    @include('layouts.components.admin._admin_navigation')
    
    <main class="admin-main-content">
        <div class="container-fluid py-4">
            <!-- Tipe Item Section -->
            <div class="row mb-5">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2><i class="fas fa-tag me-2"></i>Item Types Management</h2>
                        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addTipeItemModal">
                            <i class="fas fa-plus me-2"></i>Add New Item Type
                        </button>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            {{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($tipeItems ?? [] as $tipeItem)
                                        <tr>
                                            <td>
                                                @if($tipeItem->image)
                                                    <img src="{{ asset($tipeItem->image) }}" 
                                                         alt="{{ $tipeItem->name }}" 
                                                         style="width: 50px; height: 50px; object-fit: contain; border-radius: 4px;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 50px; border-radius: 4px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td><strong>{{ $tipeItem->name }}</strong></td>
                                            <td>{{ Str::limit($tipeItem->description ?? '', 50) }}</td>
                                            <td>{{ $tipeItem->created_at ? $tipeItem->created_at->format('d M Y') : 'N/A' }}</td>
                                            <td>
                                                <button class="btn btn-sm btn-warning edit-tipe-btn" data-bs-toggle="modal" data-bs-target="#editTipeItemModal" 
                                                        data-id="{{ $tipeItem->id }}"
                                                        data-name="{{ $tipeItem->name }}"
                                                        data-description="{{ $tipeItem->description }}"
                                                        data-image="{{ $tipeItem->image }}">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <form action="{{ route('admin.tipe-items.destroy', $tipeItem) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No item types found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Games Section -->
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2><i class="fas fa-gamepad me-2"></i>Games Management</h2>
                        <a href="{{ route('admin.games.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Add New Game
                        </a>
                    </div>

                    <div class="card">
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px;"></th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Type</th>
                                            <th>Description</th>
                                            <th>Items</th>
                                            <th>Status</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($games ?? [] as $game)
                                        <tr>
                                            <td>
                                                <button class="btn btn-sm btn-outline-secondary" type="button" data-bs-toggle="collapse" 
                                                        data-bs-target="#items-{{ $game->id }}" aria-expanded="false">
                                                    <i class="fas fa-chevron-down"></i>
                                                </button>
                                            </td>
                                            <td>
                                                @if($game->image)
                                                    <img src="{{ asset('storage/' . $game->image) }}" 
                                                         alt="{{ $game->name }}" 
                                                         style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                                @else
                                                    <div class="bg-light d-flex align-items-center justify-content-center" 
                                                         style="width: 50px; height: 50px; border-radius: 4px;">
                                                        <i class="fas fa-image text-muted"></i>
                                                    </div>
                                                @endif
                                            </td>
                                            <td><strong>{{ $game->name }}</strong></td>
                                            <td>
                                                <span class="badge bg-{{ $game->tipe === 'game' ? 'primary' : 'warning' }}">
                                                    {{ ucfirst($game->tipe) }}
                                                </span>
                                            </td>
                                            <td>{{ Str::limit($game->description ?? '', 50) }}</td>
                                            <td>
                                                <span class="badge bg-info">{{ $game->items->count() ?? 0 }}</span>
                                            </td>
                                            <td>
                                                <span class="badge bg-{{ $game->is_active ? 'success' : 'secondary' }}">
                                                    {{ $game->is_active ? 'Active' : 'Inactive' }}
                                                </span>
                                            </td>
                                            <td>{{ $game->created_at ? $game->created_at->format('d M Y') : 'N/A' }}</td>
                                            <td>
                                                <a href="{{ route('admin.games.edit', $game) }}" class="btn btn-sm btn-warning">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.games.destroy', $game) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        <!-- Items Collapse Row -->
                                        <tr class="collapse" id="items-{{ $game->id }}">
                                            <td colspan="9" class="p-0">
                                                <div class="p-4 bg-light">
                                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                                        <h6 class="mb-0"><strong>Items for {{ $game->name }}</strong></h6>
                                                        <button class="btn btn-sm btn-success" type="button" data-bs-toggle="modal" data-bs-target="#addItemToGameModal" 
                                                                onclick="prepareAddItemModal({{ $game->id }}, '{{ $game->name }}')">
                                                            <i class="fas fa-plus me-1"></i>Add Item
                                                        </button>
                                                    </div>

                                                    <div class="table-responsive">
                                                        <table class="table table-sm table-bordered mb-0">
                                                            <thead class="table-light">
                                                                <tr>
                                                                    <th>Item Name</th>
                                                                    <th>Item Code</th>
                                                                    <th>Type</th>
                                                                    <th>Price</th>
                                                                    <th style="width: 120px;">Actions</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody>
                                                                @forelse($game->items ?? [] as $item)
                                                                <tr>
                                                                    <td><strong>{{ $item->nama }}</strong></td>
                                                                    <td>{{ $item->item_id ?? '-' }}</td>
                                                                    <td>{{ $item->tipeItem->name ?? 'N/A' }}</td>
                                                                    <td>Rp {{ number_format($item->harga) }}</td>
                                                                    <td>
                                                                        <button class="btn btn-xs btn-warning btn-sm" type="button" data-bs-toggle="modal" data-bs-target="#editItemModal"
                                                                                onclick="prepareEditItemModal({{ $game->id }}, {{ $item->id }}, '{{ addslashes($item->nama) }}', '{{ addslashes($item->item_id ?? '') }}', {{ $item->tipe_item_id }}, {{ $item->harga }}, {{ $item->harga_coret ?? 0 }}, {{ $item->discount_percent ?? 0 }})">
                                                                            <i class="fas fa-edit"></i>
                                                                        </button>
                                                                        <form action="{{ route('admin.games.removeItem', [$game, $item]) }}" method="POST" class="d-inline">
                                                                            @csrf
                                                                            @method('DELETE')
                                                                            <button type="submit" class="btn btn-xs btn-danger btn-sm" onclick="return confirm('Remove this item?')">
                                                                                <i class="fas fa-trash"></i>
                                                                            </button>
                                                                        </form>
                                                                    </td>
                                                                </tr>
                                                                @empty
                                                                <tr>
                                                                    <td colspan="5" class="text-center text-muted py-3">No items added</td>
                                                                </tr>
                                                                @endforelse
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="9" class="text-center">No games found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal Add Tipe Item -->
    <div class="modal fade" id="addTipeItemModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Item Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.tipe-items.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="tipeItemName" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror" 
                                   id="tipeItemName" name="name" required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tipeItemDesc" class="form-label">Description</label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="tipeItemDesc" name="description" rows="3"></textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="mb-3">
                            <label for="tipeItemImage" class="form-label">Image/Icon</label>
                            <input type="file" class="form-control @error('image') is-invalid @enderror" 
                                   id="tipeItemImage" name="image" accept="image/*">
                            <small class="text-muted">Upload gambar atau icon untuk tipe item (JPG, PNG, GIF)</small>
                            @error('image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-success">Add Item Type</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Tipe Item -->
    <div class="modal fade" id="editTipeItemModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Item Type</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editTipeItemForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="editTipeItemName" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="editTipeItemName" name="name" required>
                        </div>
                        <div class="mb-3">
                            <label for="editTipeItemDesc" class="form-label">Description</label>
                            <textarea class="form-control" id="editTipeItemDesc" name="description" rows="3"></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="editTipeItemImage" class="form-label">Image/Icon</label>
                            <div id="editTipeItemImagePreview" class="mb-2"></div>
                            <input type="file" class="form-control" id="editTipeItemImage" name="image" accept="image/*">
                            <small class="text-muted">Biarkan kosong jika tidak ingin mengubah gambar</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">Update Item Type</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Add Item to Game -->
    <div class="modal fade" id="addItemToGameModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Item to Game: <span id="gameNameDisplay"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="addItemForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="gameId" name="game_id">
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="itemName" class="form-label">Item Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="itemName" name="nama" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="itemCode" class="form-label">Item Code/ID</label>
                                    <input type="text" class="form-control" id="itemCode" name="item_id">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="tipeItemId" class="form-label">Item Type <span class="text-danger">*</span></label>
                                    <select class="form-control" id="tipeItemId" name="tipe_item_id" required>
                                        <option value="">-- Select Type --</option>
                                        @php
                                            $tipeItems = \App\Models\TipeItem::all();
                                        @endphp
                                        @foreach($tipeItems as $tipe)
                                            <option value="{{ $tipe->id }}">{{ $tipe->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="itemHarga" class="form-label">Price <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="itemHarga" name="harga" step="0.01" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="itemHargaCoret" class="form-label">Strikethrough Price</label>
                                    <input type="number" class="form-control" id="itemHargaCoret" name="harga_coret" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="itemDiscount" class="form-label">Discount %</label>
                                    <input type="number" class="form-control" id="itemDiscount" name="discount_percent" value="0" min="0" max="100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Item -->
    <div class="modal fade" id="editItemModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Item: <span id="editItemNameDisplay"></span></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="editItemForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editItemName" class="form-label">Item Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" id="editItemName" name="nama" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editItemCode" class="form-label">Item Code/ID</label>
                                    <input type="text" class="form-control" id="editItemCode" name="item_id">
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editTipeItemId" class="form-label">Item Type <span class="text-danger">*</span></label>
                                    <select class="form-control" id="editTipeItemId" name="tipe_item_id" required>
                                        <option value="">-- Select Type --</option>
                                        @foreach($tipeItems as $tipe)
                                            <option value="{{ $tipe->id }}">{{ $tipe->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editItemHarga" class="form-label">Price <span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" id="editItemHarga" name="harga" step="0.01" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editItemHargaCoret" class="form-label">Strikethrough Price</label>
                                    <input type="number" class="form-control" id="editItemHargaCoret" name="harga_coret" step="0.01">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="editItemDiscount" class="form-label">Discount %</label>
                                    <input type="number" class="form-control" id="editItemDiscount" name="discount_percent" value="0" min="0" max="100">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-warning">Update Item</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        // Handle edit tipe item button clicks
        document.querySelectorAll('.edit-tipe-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.dataset.id;
                const name = this.dataset.name;
                const description = this.dataset.description;
                const image = this.dataset.image;
                
                const form = document.getElementById('editTipeItemForm');
                form.action = '/admin/tipe-items/' + id;
                document.getElementById('editTipeItemName').value = name;
                document.getElementById('editTipeItemDesc').value = description;
                
                const previewDiv = document.getElementById('editTipeItemImagePreview');
                if (image && image.trim() !== '') {
                    previewDiv.innerHTML = '<img src="/public/' + image + '" style="max-width: 100px; max-height: 100px; border-radius: 4px;">';
                } else {
                    previewDiv.innerHTML = '';
                }
            });
        });

        function prepareEditItemModal(gameId, itemId, nama, itemCode, tipeItemId, harga, hargaCoret, discountPercent) {
            const form = document.getElementById('editItemForm');
            form.action = '/admin/games/' + gameId + '/items/' + itemId;
            
            document.getElementById('editItemNameDisplay').textContent = nama;
            document.getElementById('editItemName').value = nama;
            document.getElementById('editItemCode').value = itemCode;
            document.getElementById('editTipeItemId').value = tipeItemId;
            document.getElementById('editItemHarga').value = harga;
            document.getElementById('editItemHargaCoret').value = hargaCoret;
            document.getElementById('editItemDiscount').value = discountPercent;
        }

    </script>

@endsection