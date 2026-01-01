@extends('layouts.app')

@section('content')
<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 style="color: #222847; font-weight: 700;">
                    <i class="fas fa-bell me-2" style="color: #667eea;"></i>Semua Notifikasi
                </h1>
            </div>

            @if($notifikasi->count() > 0)
                <div class="row">
                    @foreach($notifikasi as $item)
                        <div class="col-12 mb-3">
                            <a href="{{ route('notifikasi.show', $item->id) }}" class="card notification-card h-100" style="border: none; box-shadow: 0 2px 8px rgba(0,0,0,0.1); transition: all 0.3s; text-decoration: none; color: inherit;">
                                <div class="card-body p-4">
                                    <div class="row align-items-center">
                                        @if($item->image)
                                            <div class="col-auto">
                                                <img src="{{ asset('storage/' . $item->image) }}" alt="Promo" style="width: 80px; height: 80px; border-radius: 8px; object-fit: cover;">
                                            </div>
                                        @endif
                                        <div class="@if($item->image)col-md@else col-12@endif">
                                            <h5 style="color: #222847; font-weight: 600; margin-bottom: 8px;">{{ $item->title }}</h5>
                                            <p style="color: #666; margin-bottom: 8px;">{{ $item->description }}</p>
                                            @if($item->promoCode)
                                                <div style="display: inline-block; background-color: #FFE292; padding: 4px 12px; border-radius: 20px; font-weight: 600; color: #222847; font-size: 12px;">
                                                    Kode: {{ $item->promoCode->code }}
                                                </div>
                                            @endif
                                            <div style="color: #999; font-size: 12px; margin-top: 8px;">
                                                {{ $item->created_at->translatedFormat('d M Y, H:i') }}
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination -->
                @if($notifikasi->hasPages())
                    <nav class="mt-4">
                        {{ $notifikasi->links('pagination::bootstrap-5') }}
                    </nav>
                @endif
            @else
                <div class="text-center py-5">
                    <i class="fas fa-inbox" style="font-size: 64px; color: #ddd; margin-bottom: 20px;"></i>
                    <h5 style="color: #999;">Tidak ada notifikasi</h5>
                    <p style="color: #bbb;">Notifikasi akan muncul di sini ketika ada update terbaru</p>
                </div>
            @endif
        </div>
    </div>
</div>

<style>
    .notification-card {
        border-radius: 8px;
    }

    .notification-card:hover {
        box-shadow: 0 6px 16px rgba(0,0,0,0.12) !important;
        transform: translateY(-2px);
    }
</style>
@endsection
