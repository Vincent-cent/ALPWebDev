@extends('layouts.mainLayout')

@section('head')
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Authentication Status -->
    <script>
        window.isAuthenticated = {{ auth()->check() ? 'true' : 'false' }};
    </script>
@endsection

@section('content')
<div class="container-fluid text-white min-vh-100 py-4" style="background-color: #1a1a2e;">
    <div class="container" style="max-width: 1400px;">
        <div class="mb-3">
            <a href="{{ route('beranda') }}" class="btn btn-outline-light" style="float: left;">
                <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
            </a>
            <div style="clear: both;"></div>
        </div>
    </div>
    
    <!-- Display Success/Error Messages -->
    @if(session('success'))
        <div class="container" style="max-width: 1400px;">
            <div class="mb-3">
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
    @endif
    
    @if(session('error'))
        <div class="container" style="max-width: 1400px;">
            <div class="mb-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
    @endif
    
    @if($errors->any())
        <div class="container" style="max-width: 1400px;">
            <div class="mb-3">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-triangle me-2"></i>
                    <strong>Terjadi kesalahan:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            </div>
        </div>
    @endif
    
    <div class="container" style="max-width: 1400px;">
        <div class="row">
            <div class="col-lg-3 col-md-4 mb-4">
                <div class="p-3">
                    @php
                        $imagePath = $game->image && file_exists(public_path($game->image)) 
                            ? asset($game->image) 
                            : asset('/placeholder.jpg');
                    @endphp
                    <div class="mb-3">
                        <img src="{{ $imagePath }}" class="rounded" alt="{{ $game->name }}" style="width: 100px; height: 100px; object-fit: cover;">
                    </div>
                    <h5 class="card-title text-white fw-bold mb-3 fs-4">{{ $game->name }}</h5>
                    <p class="card-text small" style="line-height: 1.6; color: #c0c0c0; font-size: 0.85rem;">
                        {{ $game->description }}
                    </p>
                </div>
            </div>

            <div class="col-lg-9 col-md-8">
                <form id="purchaseForm" method="POST" action="{{ route('transaksi.store') }}">
                    @csrf
                    <input type="hidden" name="game_id" value="{{ $game->id }}">
                    
                    <div class="card mb-3" style="background-color: #e1e3e8; border: none; border-radius: 20px;">
                        <div class="card-body" style="padding: 20px 25px;">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; background-color: #7e57c2; font-size: 18px; font-weight: bold;">
                                    <strong>1</strong>
                                </div>
                                <h5 class="mb-0 text-dark fw-bold">Masukkan User ID</h5>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-2">
                                    <input type="text" class="form-control" name="user_id" placeholder="User ID" required style="background-color: #f0f2f5; border: none; border-radius: 10px; padding: 12px 15px; color: #666; font-size: 14px;">
                                </div>
                                <div class="col-md-6 mb-2">
                                    <input type="text" class="form-control" name="server_id" placeholder="Server ID" style="background-color: #f0f2f5; border: none; border-radius: 10px; padding: 12px 15px; color: #666; font-size: 14px;">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3" style="background-color: #e1e3e8; border: none; border-radius: 20px;">
                        <div class="card-body" style="padding: 20px 25px;">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; background-color: #7e57c2; font-size: 18px; font-weight: bold;">
                                    <strong>2</strong>
                                </div>
                                <h5 class="mb-0 text-dark fw-bold">Pilih Produk</h5>
                            </div>

                            <!-- Inner dark container -->
                            <div style="background-color: #2d2d44; border-radius: 15px; padding: 20px;">
                                <ul class="nav nav-pills mb-3" id="productTypeTabs" role="tablist">
                                    @foreach($game->items->groupBy('tipe_item_id') as $tipeId => $groupedItems)
                                        @php $tipeItem = $groupedItems->first()->tipeItem; @endphp
                                        <li class="nav-item me-2" role="presentation">
                                            <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $tipeId }}" data-bs-toggle="pill" data-bs-target="#content-{{ $tipeId }}" type="button" style="border-radius: 8px; padding: 6px 16px; font-size: 14px;">
                                                {{ $tipeItem->name }}
                                            </button>
                                        </li>
                                    @endforeach
                                </ul>

                                <div class="tab-content" id="productTypeContent">
                                    @foreach($game->items->groupBy('tipe_item_id') as $tipeId => $groupedItems)
                                        <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="content-{{ $tipeId }}">
                                            <div class="row">
                                                @foreach($groupedItems as $item)
                                                    <div class="col-lg-4 col-md-6 mb-3">
                                                        <input type="radio" class="btn-check" name="item_id" id="item-{{ $item->id }}" value="{{ $item->id }}" data-price="{{ $item->harga }}" required>
                                                        <label class="btn btn-outline-primary w-100 text-start p-3 h-100" for="item-{{ $item->id }}" style="background-color: #e1e3e8; border: 2px solid #e1e3e8; border-radius: 12px;">
                                                            <div class="d-flex flex-column align-items-center text-center">
                                                                @php
                                                                    $itemImage = $item->tipeItem && $item->tipeItem->image
                                                                        ? asset($item->tipeItem->image)
                                                                        : asset('images/placeholder.png');
                                                                @endphp
                                                                <div class="rounded mb-2 d-flex align-items-center justify-content-center" style="background-color: #2d2d44; width: 100%; height: 120px; overflow: hidden;">
                                                                    <img src="{{ $itemImage }}" alt="{{ $item->nama }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                                </div>
                                                                <h6 class="mb-1 text-dark fw-bold" style="font-size: 14px;">{{ $item->nama }}</h6>
                                                                <p class="fw-bold mb-1" style="color: #3b82f6; font-size: 14px;">Rp. {{ number_format($item->harga, 0, ',', '.') }}</p>
                                                                <div class="d-flex gap-1 justify-content-center">
                                                                    <span class="badge" style="background-color: #4caf50; font-size: 10px;">{{ $item->discount_percent }}%</span>
                                                                    <span class="badge bg-secondary text-decoration-line-through" style="font-size: 10px;">Rp. {{ number_format($item->harga_coret, 0, ',', '.') }}</span>
                                                                </div>
                                                            </div>
                                                        </label>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3" style="background-color: #e1e3e8; border: none; border-radius: 20px;">
                        <div class="card-body" style="padding: 20px 25px;">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; background-color: #7e57c2; font-size: 18px; font-weight: bold;">
                                    <strong>3</strong>
                                </div>
                                <h5 class="mb-0 text-dark fw-bold">Masukkan Kode Promo</h5>
                            </div>
                            <div class="row align-items-center">
                                <div class="col-md-9 mb-2">
                                    <input type="text" class="form-control" name="promo_code" id="promoCodeInput" placeholder="O5rG0W6CtxCUb8v8" style="background-color: #f0f2f5; border: none; border-radius: 10px; padding: 12px 15px; color: #666; font-size: 14px;">
                                </div>
                                <div class="col-md-3 mb-2">
                                    <button type="button" class="btn w-100" id="checkPromoBtn" style="background-color: #7e57c2; color: white; border: none; border-radius: 10px; padding: 12px; font-weight: bold; font-size: 14px;">Cek Kode →</button>
                                </div>
                            </div>
                            <div id="promoMessage" class="mt-2"></div>
                        </div>
                    </div>

                    <div class="card mb-3" style="background-color: #e1e3e8; border: none; border-radius: 20px;">
                        <div class="card-body" style="padding: 20px 25px;">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; background-color: #7e57c2; font-size: 18px; font-weight: bold;">
                                    <strong>4</strong>
                                </div>
                                <h5 class="mb-0 text-dark fw-bold">Cara Pembayaran</h5>
                            </div>
                            <div class="row">
                                @foreach($metodePembayaran as $metode)
                                    <div class="col-lg-6 mb-3">
                                        <input type="radio" class="btn-check" name="metode_pembayaran_id" id="payment-{{ $metode->id }}" value="{{ $metode->id }}" data-fee="{{ $metode->fee }}" required>
                                        <label class="btn btn-outline-primary w-100 p-3" for="payment-{{ $metode->id }}" style="background-color: #f0f2f5; border: 2px solid #f0f2f5; border-radius: 12px;">
                                            <div class="d-flex flex-column align-items-center text-center">
                                                @php
                                                    $paymentLogo = $metode->logo && file_exists(public_path($metode->logo))
                                                        ? asset($metode->logo)
                                                        : asset('images/placeholder.png');
                                                @endphp
                                                <img src="{{ $paymentLogo }}" alt="{{ $metode->name }}" class="mb-2" style="height: 60px; object-fit: contain;">
                                                <h6 class="mb-1 text-dark fw-bold" style="font-size: 14px;">{{ $metode->name }}</h6>
                                                <small class="text-muted" style="font-size: 12px;">Biaya Admin: Rp {{ number_format($metode->fee, 0, ',', '.') }}</small>
                                                <p class="fw-bold mb-0 mt-2" style="color: #3b82f6; font-size: 14px;">Total Harga: <span class="total-price">Rp. 0</span></p>
                                            </div>
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="card mb-3" style="background-color: #e1e3e8; border: none; border-radius: 20px;">
                        <div class="card-body" style="padding: 20px 25px;">
                            <div class="d-flex align-items-center mb-3">
                                <div class="rounded-circle text-white d-flex align-items-center justify-content-center me-3" style="width: 45px; height: 45px; background-color: #7e57c2; font-size: 18px; font-weight: bold;">
                                    <strong>5</strong>
                                </div>
                                <h5 class="mb-0 text-dark fw-bold">Nomor Telepon</h5>
                            </div>
                            <input type="tel" class="form-control" name="phone" placeholder="Masukkan Nomor Telepon Anda" required style="background-color: #f0f2f5; border: none; border-radius: 10px; padding: 12px 15px; color: #666; font-size: 14px;">
                        </div>
                    </div>

                    <div class="card" style="background-color: #e1e3e8; border: none; border-radius: 20px;">
                        <div class="card-body text-center" style="padding: 20px 25px;">
                            @guest
                                <p class="mb-3" style="color: #666; font-size: 13px;">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <small>Anda berbelanja sebagai Guest. Transaksi tidak akan tersimpan dalam riwayat akun.</small>
                                </p>
                            @else
                                <p class="text-success mb-3" style="font-size: 13px;">
                                    <i class="fas fa-user-check me-2"></i>
                                    <small>Logged in as {{ auth()->user()->name }}. Transaksi akan tersimpan dalam riwayat akun Anda.</small>
                                </p>
                            @endguest
                            
                            <button type="submit" class="btn btn-lg px-5" style="background-color: #f0f2f5; color: #333; border: none; border-radius: 12px; padding: 12px 35px; font-weight: bold; font-size: 15px;">
                                🛒 <strong>Beli Sekarang</strong>
                            </button>
                            
                            @guest
                                <div class="mt-3">
                                    <small style="color: #666; font-size: 12px;">
                                        Ingin menyimpan riwayat pembelian? 
                                        <a href="{{ route('login') }}" class="text-decoration-none" style="color: #3b82f6; font-weight: bold;">Login</a> atau 
                                        <a href="{{ route('register') }}" class="text-decoration-none" style="color: #3b82f6; font-weight: bold;">Daftar</a>
                                    </small>
                                </div>
                            @endguest
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
    .btn-check:checked + .btn-outline-primary {
        background-color: #e1e3e8 !important;
        border-color: #3b82f6 !important;
        border-width: 3px !important;
        color: #333 !important;
    }
    
    .btn-check:checked + .btn-outline-primary h6,
    .btn-check:checked + .btn-outline-primary p,
    .btn-check:checked + .btn-outline-primary small {
        color: #333 !important;
    }
    
    .nav-pills .nav-link {
        color: #fff;
        background-color: #2d2d44;
        border-radius: 10px;
        transition: all 0.3s;
        border: 1px solid #2d2d44;
    }
    
    .nav-pills .nav-link.active {
        background-color: #4a4a6a;
        color: white;
        border: 1px solid #4a4a6a;
    }
    
    .nav-pills .nav-link:hover {
        background-color: #3a3a5a;
    }
</style>

@endsection

@section('scripts')

    <script src="{{ asset('js/game-detail.js') }}?v={{ time() }}"></script>
@endsection