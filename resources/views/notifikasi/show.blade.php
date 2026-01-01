@extends('layouts.app')

@section('content')
<div class="container mt-5 pt-5">
    <div class="row">
        <div class="col-md-8 mx-auto">
            <a href="{{ route('notifikasi.index') }}" style="color: #667eea; text-decoration: none; margin-bottom: 20px; display: inline-block;">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>

            <div class="card" style="border: none; box-shadow: 0 4px 12px rgba(0,0,0,0.1); border-radius: 12px;">
                <div class="card-body p-5">
                    @if($notifikasi->image)
                        <img src="{{ asset('storage/' . $notifikasi->image) }}" alt="Notifikasi" class="img-fluid mb-4" style="border-radius: 8px; max-height: 400px; object-fit: cover; width: 100%;">
                    @endif

                    <h1 style="color: #222847; font-weight: 700; margin-bottom: 16px;">{{ $notifikasi->title }}</h1>
                    
                    <p style="color: #666; font-size: 16px; line-height: 1.6; margin-bottom: 20px;">{{ $notifikasi->description }}</p>

                    @if($notifikasi->promoCode)
                        <div class="alert" style="background-color: #fff3cd; border: 1px solid #ffc107; border-radius: 8px; padding: 16px;">
                            <h5 style="color: #856404; margin-bottom: 12px;">
                                <i class="fas fa-tag me-2"></i>Kode Promo Tersedia
                            </h5>
                            <div style="display: inline-block; background-color: #FFE292; padding: 12px 24px; border-radius: 6px; font-weight: 700; color: #222847; font-size: 18px;">
                                {{ $notifikasi->promoCode->code }}
                            </div>
                            @if($notifikasi->promoCode->discount_percentage)
                                <p style="color: #856404; margin-top: 12px; margin-bottom: 0;">
                                    <strong>Diskon:</strong> {{ $notifikasi->promoCode->discount_percentage }}%
                                </p>
                            @endif
                            @if($notifikasi->promoCode->discount_amount)
                                <p style="color: #856404; margin-bottom: 0;">
                                    <strong>Potongan:</strong> Rp{{ number_format($notifikasi->promoCode->discount_amount, 0, ',', '.') }}
                                </p>
                            @endif
                        </div>
                    @endif

                    <div style="color: #999; font-size: 14px; margin-top: 24px; padding-top: 16px; border-top: 1px solid #eee;">
                        <i class="fas fa-clock me-2"></i>{{ $notifikasi->created_at->translatedFormat('d M Y, H:i') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
