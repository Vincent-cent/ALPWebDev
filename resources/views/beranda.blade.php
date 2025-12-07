@extends('layouts.mainLayout')

@section('title', 'Beranda - TOSHOP')

@push('styles')
    @vite('resources/css/beranda.css')
    <style>
        /* Override any conflicting Livewire styles */
        .container-fluid, .container {
            padding-left: var(--bs-gutter-x, 0.75rem) !important;
            padding-right: var(--bs-gutter-x, 0.75rem) !important;
        }
        
        body {
            line-height: 1.5 !important;
        }
    </style>
@endpush

@push('scripts')
    @vite('resources/js/beranda.js')
@endpush

@section('content')
<div class="container-fluid px-0 beranda-page">
    <!-- Hero Section with Banners -->
    <section class="hero-section py-5">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    @if(isset($banners) && $banners->count() > 0)
                        <div id="bannerCarousel" class="carousel slide shadow rounded-3" data-bs-ride="carousel">
                            <div class="carousel-indicators">
                                @foreach($banners as $index => $banner)
                                    <button type="button" data-bs-target="#bannerCarousel" 
                                            data-bs-slide-to="{{ $index }}" 
                                            class="{{ $index == 0 ? 'active' : '' }}" 
                                            aria-current="{{ $index == 0 ? 'true' : 'false' }}"
                                            aria-label="Slide {{ $index + 1 }}"></button>
                                @endforeach
                            </div>
                            <div class="carousel-inner rounded-3">
                                @foreach($banners as $index => $banner)
                                    <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                        <img src="{{ $banner->image_url }}" class="d-block w-100 object-fit-cover" 
                                             alt="{{ $banner->title }}" height="300">
                                        <div class="carousel-caption d-none d-md-block">
                                            <h5 class="fw-bold">{{ $banner->title }}</h5>
                                            <p class="mb-0">{{ $banner->description }}</p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#bannerCarousel" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#bannerCarousel" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                    @else
                        <!-- Default hero content if no banners -->
                        <div class="bg-primary bg-gradient text-center py-5 rounded-3 text-white shadow">
                            <div class="container">
                                <h1 class="display-4 fw-bold mb-3">Selamat Datang di TOSHOP</h1>
                                <p class="lead fs-5 mb-4 text-white-50">Platform terpercaya untuk top up game dan produk digital</p>
                                <a href="#games-section" class="btn btn-primary-custom btn-lg px-5 btn-cta-games">
                                    <i class="fas fa-gamepad me-2"></i>Mulai Top Up
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- Popular Games Section -->
    <section id="games-section" class="py-5 bg-light">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center text-md-start">
                    <h2 class="display-6 fw-bold mb-3">
                        <i class="fas fa-fire text-warning me-2"></i>Game Populer
                    </h2>
                    <p class="lead text-muted mb-0">Top up game favorit kamu dengan mudah dan cepat</p>
                </div>
            </div>
            <div class="row g-4">
                @if(isset($popularGames) && $popularGames->count() > 0)
                    @foreach($popularGames as $game)
                        <div class="col-xxl-2 col-lg-3 col-md-4 col-sm-6 col-6">
                            <div class="card game-card h-100 border-0 shadow-sm">
                                <div class="card-img-top d-flex align-items-center justify-content-center game-icon-placeholder">
                                    @if($game->icon)
                                        <img src="{{ $game->icon }}" alt="{{ $game->name }}" 
                                             class="img-fluid" style="max-height: 80px; max-width: 80px; object-fit: contain;">
                                    @else
                                        <i class="fas fa-gamepad fa-3x text-muted"></i>
                                    @endif
                                </div>
                                <div class="card-body text-center p-3">
                                    <h6 class="card-title fw-bold mb-2 text-truncate" title="{{ $game->name }}">{{ $game->name }}</h6>
                                    <small class="text-muted">
                                        <i class="fas fa-cube me-1"></i>{{ $game->items->count() ?? 0 }} item
                                    </small>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-gamepad fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted mb-2">Belum ada game tersedia</h5>
                            <p class="text-muted small">Game akan segera ditambahkan</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <!-- Voucher Section -->
    <section class="py-5">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center text-md-start">
                    <h2 class="display-6 fw-bold mb-3">
                        <i class="fas fa-ticket-alt text-primary me-2"></i>Voucher Digital
                    </h2>
                    <p class="lead text-muted mb-0">Berbagai voucher digital untuk kebutuhan sehari-hari</p>
                </div>
            </div>
            <div class="row g-4">
                @if(isset($vouchers) && $vouchers->count() > 0)
                    @foreach($vouchers->take(8) as $voucher)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="card voucher-card h-100 border-0 shadow-sm">
                                <div class="card-body p-4">
                                    <div class="d-flex align-items-center mb-3">
                                        <div class="voucher-icon me-3 flex-shrink-0">
                                            <i class="fas fa-gift fa-lg text-primary"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="card-title mb-1 fw-bold text-truncate" title="{{ $voucher->name }}">{{ $voucher->name }}</h6>
                                            <small class="text-muted">{{ $voucher->description ?? 'Voucher Digital' }}</small>
                                        </div>
                                    </div>
                                    @if(isset($voucher->tipeItems) && $voucher->tipeItems->count() > 0)
                                        <div class="mt-auto">
                                            <small class="text-muted d-block">Mulai dari</small>
                                            <div class="h6 fw-bold text-success mb-0">
                                                <i class="fas fa-tag me-1"></i>Rp {{ number_format($voucher->tipeItems->min('price'), 0, ',', '.') }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-ticket-alt fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted mb-2">Belum ada voucher tersedia</h5>
                            <p class="text-muted small">Voucher akan segera ditambahkan</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <div class="row mb-4">
                <div class="col-12 text-center text-md-start">
                    <h2 class="display-6 fw-bold mb-3">
                        <i class="fas fa-star text-warning me-2"></i>Rekomendasi
                    </h2>
                    <p class="lead text-muted mb-0">Item dengan harga terbaik untuk kamu</p>
                </div>
            </div>
            <div class="row g-4">
                @if(isset($recommended) && $recommended->count() > 0)
                    @foreach($recommended as $item)
                        <div class="col-xxl-2 col-lg-3 col-md-4 col-sm-6">
                            <div class="card recommended-card h-100 border-0 shadow-sm">
                                <div class="card-body text-center p-3 d-flex flex-column">
                                    <div class="item-icon mb-3">
                                        <i class="fas fa-coins fa-2x"></i>
                                    </div>
                                    <h6 class="card-title fw-bold mb-2 text-truncate" title="{{ $item->name }}">{{ $item->name }}</h6>
                                    <div class="price h6 fw-bold text-success mb-3">
                                        <i class="fas fa-rupiah-sign me-1"></i>Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </div>
                                    <button class="btn btn-sm btn-outline-primary mt-auto w-100 btn-buy-item">
                                        <i class="fas fa-shopping-cart me-1"></i>Beli Sekarang
                                    </button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="col-12">
                        <div class="text-center py-5">
                            <i class="fas fa-star fa-4x text-muted mb-3"></i>
                            <h5 class="text-muted mb-2">Belum ada rekomendasi tersedia</h5>
                            <p class="text-muted small">Rekomendasi akan segera ditambahkan</p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
</div>
@endsection