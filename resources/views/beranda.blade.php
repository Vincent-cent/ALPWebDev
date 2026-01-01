@extends('layouts.mainLayout')

@section('title', 'Beranda - TOSHOP')

@section('content')
    <div class="container-fluid px-0 beranda-page"
        style="background: linear-gradient(135deg, #1a1f3a 0%, #2d3561 100%); min-height: 100vh;">
        <section class="hero-section py-4">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @if (isset($banners) && $banners->count() > 0)
                            <div class="banner-carousel-wrapper position-relative" style="height: 400px; overflow: hidden;">
                                <div class="d-flex align-items-center justify-content-center position-relative h-100">
                                    @foreach ($banners as $index => $banner)
                                        @php
                                            $bannerImage = $banner->image && file_exists(storage_path('app/public/' . $banner->image))
                                                ? asset('storage/' . $banner->image)
                                                : asset('/placeholder.jpg');
                                        @endphp
                                        <div class="banner-slide position-absolute {{ $index == 0 ? 'active center' : ($index == 1 ? 'right' : 'hidden') }}" 
                                             data-index="{{ $index }}"
                                             style="transition: all 0.6s cubic-bezier(0.4, 0, 0.2, 1);">
                                            <img src="{{ $bannerImage }}" class="d-block w-100 rounded-4 shadow-lg"
                                                alt="{{ $banner->name }}" style="object-fit: cover;">
                                        </div>
                                    @endforeach
                                </div>
                                
                                <button class="carousel-control-prev position-absolute start-0 top-50 translate-middle-y" 
                                        type="button" onclick="previousSlide()"
                                        style="width: auto; opacity: 1; z-index: 10; background: none; border: none;">
                                    <span class="carousel-control-prev-icon" aria-hidden="true" 
                                          style="background-color: rgba(255, 255, 255, 0.3); padding: 15px; border-radius: 50%; backdrop-filter: blur(10px);"></span>
                                    <span class="visually-hidden">Previous</span>
                                </button>
                                <button class="carousel-control-next position-absolute end-0 top-50 translate-middle-y" 
                                        type="button" onclick="nextSlide()"
                                        style="width: auto; opacity: 1; z-index: 10; background: none; border: none;">
                                    <span class="carousel-control-next-icon" aria-hidden="true"
                                          style="background-color: rgba(255, 255, 255, 0.3); padding: 15px; border-radius: 50%; backdrop-filter: blur(10px);"></span>
                                    <span class="visually-hidden">Next</span>
                                </button>
                                
                                <div class="carousel-indicators position-absolute bottom-0 start-50 translate-middle-x mb-3" style="z-index: 10;">
                                    @foreach ($banners as $index => $banner)
                                        <button type="button" class="indicator-dot {{ $index == 0 ? 'active' : '' }}" 
                                                data-slide="{{ $index }}"
                                                onclick="goToSlide({{ $index }})"
                                                style="width: 10px; height: 10px; border-radius: 50%; margin: 0 5px; border: none; padding: 0;"></button>
                                    @endforeach
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </section>

        <section class="py-4">
            <div class="container">
                <div class="text-center mb-4">
                    <div class="d-inline-block px-5 py-3 rounded-pill" 
                         style="background: linear-gradient(90deg, #2C3356 0%, #424A70 100%); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3); width: 100%; margin: 0 auto;">
                        <h2 class="fw-bold text-white text-uppercase mb-0" 
                            style="letter-spacing: 2px; font-size: 1.2rem;">
                            Popular Choice
                        </h2>
                    </div>
                </div>
                <div class="row g-3">
                    @if (isset($popularGames) && $popularGames->count() > 0)
                        @foreach ($popularGames->take(10) as $game)
                            <div class="col-lg-2 col-md-3 col-4">
                                <a href="{{ route('game.detail', $game->id) }}" class="text-decoration-none">
                                    <div class="card game-card h-100 border-0 shadow-sm"
                                        style="background: #2a3150; border-radius: 15px; transition: transform 0.3s;">
                                        <div class="card-body p-3 text-center">
                                            <div class="position-relative mb-2">
                                                @php
                                                    $imagePath = $game->image && file_exists(storage_path('app/public/' . $game->image))
                                                        ? asset('storage/' . $game->image)
                                                        : asset('/placeholder.jpg');
                                                @endphp
                                                <img src="{{ $imagePath }}" alt="{{ $game->name }}"
                                                    class="img-fluid rounded-3"
                                                    style="width: 100%; aspect-ratio: 1; object-fit: cover;">
                                                @if ($game->items->where('discount_percent', '>', 0)->count() > 0)
                                                    <span
                                                        class="position-absolute top-0 end-0 badge bg-warning text-dark m-1"
                                                        style="font-size: 0.7rem;">
                                                        <i class="fas fa-bolt"></i>
                                                    </span>
                                                @endif
                                            </div>
                                            <h6 class="card-title text-white fw-bold mb-0" style="font-size: 0.85rem;">
                                                {{ $game->name }}</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>

        <section class="py-4">
           <div class="container">
                <div class="text-center mb-4">
                    <div class="d-inline-block px-5 py-3 rounded-pill" 
                         style="background: linear-gradient(90deg, #2C3356 0%, #424A70 100%); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3); width: 100%; margin: 0 auto;">
                        <h2 class="fw-bold text-white text-uppercase mb-0" 
                            style="letter-spacing: 2px; font-size: 1.2rem;">
                            Voucher
                        </h2>
                    </div>
                </div>
                <div class="row g-3">
                    @if (isset($vouchers) && $vouchers->count() > 0)
                        @foreach ($vouchers->take(4) as $voucher)
                            <div class="col-lg-3 col-md-4 col-6">
                                <a href="{{ route('game.detail', $voucher->id) }}" class="text-decoration-none">
                                    <div class="card voucher-card h-100 border-0 shadow-sm"
                                        style="background: #2a3150; border-radius: 15px;">
                                        <div class="card-body p-3 text-center">
                                            @php
                                                $voucherImage = $voucher->image && file_exists(storage_path("app/public/{$voucher->image}"))
                                                    ? asset("storage/{$voucher->image}")
                                                    : asset('/placeholder.jpg');
                                            @endphp
                                            <img src="{{ $voucherImage }}"
                                                alt="{{ $voucher->name }}" class="img-fluid rounded-3 mb-2"
                                                style="width: 100%; aspect-ratio: 1; object-fit: cover;">
                                            <h6 class="card-title text-white fw-bold mb-0" style="font-size: 0.85rem;">
                                                {{ $voucher->name }}</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                        @for ($i = $vouchers->count(); $i < 4; $i++)
                            <div class="col-lg-3 col-md-4 col-6">
                                <div style="visibility: hidden;">
                                    <div class="card h-100 border-0" style="background: transparent;">
                                        <div class="card-body p-3"></div>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    @endif
                </div>
            </div>
        </section>

        <section class="py-4">
            <div class="container">
                <div class="container">
                <div class="text-center mb-4">
                    <div class="d-inline-block px-5 py-3 rounded-pill" 
                         style="background: linear-gradient(90deg, #2C3356 0%, #424A70 100%); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3); width: 100%; margin: 0 auto;">
                        <h2 class="fw-bold text-white text-uppercase mb-0" 
                            style="letter-spacing: 2px; font-size: 1.2rem;">
                            Games
                        </h2>
                    </div>
                </div>
                <div class="row g-3">
                    @if (isset($allGames) && $allGames->count() > 0)
                        @foreach ($allGames as $game)
                            <div class="col-lg-2 col-md-3 col-4">
                                <a href="{{ route('game.detail', $game->id) }}" class="text-decoration-none">
                                    <div class="card game-card h-100 border-0 shadow-sm"
                                        style="background: #2a3150; border-radius: 15px;">
                                        <div class="card-body p-3 text-center">
                                            <div class="position-relative mb-2">
                                                @php
                                                    $gameImage = $game->image && file_exists(storage_path('app/public/' . $game->image))
                                                        ? asset('storage/' . $game->image)
                                                        : asset('/placeholder.jpg');
                                                @endphp
                                                <img src="{{ $gameImage }}"
                                                    alt="{{ $game->name }}" class="img-fluid rounded-3"
                                                    style="width: 100%; aspect-ratio: 1; object-fit: cover;">
                                            </div>
                                            <h6 class="card-title text-white fw-bold mb-0" style="font-size: 0.85rem;">
                                                {{ $game->name }}</h6>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="text-center mt-4">
                    <button class="btn btn-warning text-dark fw-bold px-5 py-2"
                        style="border-radius: 20px; text-transform: uppercase; letter-spacing: 1px;">
                        Tampilkan Semua
                    </button>
                </div>
            </div>
        </section>

        <section class="py-4 mb-5">
            <div class="container">
                <div class="text-center mb-4">
                    <div class="d-inline-block px-5 py-3 rounded-pill" 
                         style="background: linear-gradient(90deg, #2C3356 0%, #424A70 100%); box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3); width: 100%; margin: 0 auto;">
                        <h2 class="fw-bold text-white text-uppercase mb-0" 
                            style="letter-spacing: 2px; font-size: 1.2rem;">
                            News And Update
                        </h2>
                    </div>
                </div>
                <div class="row g-3">
                    @if (isset($banners) && $banners->count() > 0)
                        @foreach ($banners->take(2) as $banner)
                            <div class="col-lg-6 col-md-6">
                                <div class="card border-0 shadow-sm"
                                    style="background: #2a3150; border-radius: 15px; overflow: hidden;">
                                    @php
                                        $newsImage = $banner->image && file_exists(storage_path('app/public/' . $banner->image))
                                            ? asset('storage/' . $banner->image)
                                            : asset('/placeholder.jpg');
                                    @endphp
                                    <img src="{{ $newsImage }}" class="card-img-top"
                                        alt="{{ $banner->name }}" style="height: 200px; object-fit: cover;">
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </section>
    </div>

    <style>
        .game-card:hover {
            transform: translateY(-5px);
        }

        .banner-slide {
            width: 700px;
            height: 350px;
            transform-origin: center;
        }

        .banner-slide.center {
            transform: translateX(0) scale(1);
            opacity: 1;
            z-index: 3;
            left: 50%;
            margin-left: -350px;
        }

        .banner-slide.left {
            transform: translateX(-450px) scale(0.7);
            opacity: 0.5;
            z-index: 1;
            left: 50%;
            margin-left: -350px;
        }

        .banner-slide.right {
            transform: translateX(450px) scale(0.7);
            opacity: 0.5;
            z-index: 1;
            left: 50%;
            margin-left: -350px;
        }

        .banner-slide.hidden {
            transform: translateX(0) scale(0.7);
            opacity: 0;
            z-index: 0;
            pointer-events: none;
        }

        .banner-slide img {
            width: 100%;
            height: 100%;
        }

        .indicator-dot {
            background-color: rgba(255, 255, 255, 0.5);
            transition: all 0.3s ease;
        }

        .indicator-dot.active {
            background-color: white;
            transform: scale(1.3);
        }

        @media (max-width: 768px) {
            .banner-slide {
                width: 90%;
                max-width: 400px;
            }
            
            .banner-slide.center {
                margin-left: -45%;
            }
            
            .banner-slide.left,
            .banner-slide.right {
                display: none;
            }
        }
    </style>

    <script>
        let currentSlide = 0;
        const totalSlides = {{ $banners->count() }};
        let isTransitioning = false;

        function updateSlidePositions() {
            const slides = document.querySelectorAll('.banner-slide');
            const indicators = document.querySelectorAll('.indicator-dot');
            
            slides.forEach((slide, index) => {
                slide.classList.remove('center', 'left', 'right', 'hidden', 'active');
                indicators[index].classList.remove('active');
                
                if (index === currentSlide) {
                    slide.classList.add('center', 'active');
                    indicators[index].classList.add('active');
                } else if (index === (currentSlide - 1 + totalSlides) % totalSlides) {
                    slide.classList.add('left');
                } else if (index === (currentSlide + 1) % totalSlides) {
                    slide.classList.add('right');
                } else {
                    slide.classList.add('hidden');
                }
            });
        }

        function nextSlide() {
            if (isTransitioning) return;
            isTransitioning = true;
            
            currentSlide = (currentSlide + 1) % totalSlides;
            updateSlidePositions();
            
            setTimeout(() => {
                isTransitioning = false;
            }, 600);
        }

        function previousSlide() {
            if (isTransitioning) return;
            isTransitioning = true;
            
            currentSlide = (currentSlide - 1 + totalSlides) % totalSlides;
            updateSlidePositions();
            
            setTimeout(() => {
                isTransitioning = false;
            }, 600);
        }

        function goToSlide(index) {
            if (isTransitioning || index === currentSlide) return;
            isTransitioning = true;
            
            currentSlide = index;
            updateSlidePositions();
            
            setTimeout(() => {
                isTransitioning = false;
            }, 600);
        }

        let autoplayInterval = setInterval(nextSlide, 5000);

        document.querySelector('.banner-carousel-wrapper')?.addEventListener('mouseenter', () => {
            clearInterval(autoplayInterval);
        });

        document.querySelector('.banner-carousel-wrapper')?.addEventListener('mouseleave', () => {
            autoplayInterval = setInterval(nextSlide, 5000);
        });

        updateSlidePositions();
    </script>
@endsection