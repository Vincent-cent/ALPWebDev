@extends('layouts.mainLayout')

@section('content')
<div class="container-fluid bg-dark text-white min-vh-100 py-4">
    <div class="container mb-3">
        <a href="{{ route('beranda') }}" class="btn btn-outline-light">
            <i class="fas fa-arrow-left me-2"></i> Kembali ke Beranda
        </a>
    </div>
    <div class="row">
        <div class="col-lg-3 col-md-4 mb-4">
            <div class="card bg-transparent border-0">
                @php
                    $imagePath = $game->image && file_exists(storage_path('app/public/' . $game->image)) 
                        ? asset('storage/' . $game->image) 
                        : asset('/placeholder.jpg');
                @endphp
                <img src="{{ $imagePath }}" class="card-img-top rounded" alt="{{ $game->name }}" style="width: 150px; height: 150px; object-fit: cover;">
                <div class="card-body px-0">
                    <h3 class="card-title text-white fw-bold">{{ $game->name }}</h3>
                    <p class="card-text small text-white-50" style="line-height: 1.6;">
                        {{ $game->description }}
                    </p>
                </div>
            </div>
        </div>

        <div class="col-lg-9 col-md-8">
            <form id="purchaseForm" method="POST" action="{{ route('transaksi.store') }}">
                @csrf
                <input type="hidden" name="game_id" value="{{ $game->id }}">
                
                <!-- Step 1: User ID -->
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <strong>1</strong>
                            </div>
                            <h5 class="mb-0 text-dark fw-bold">Masukkan User ID</h5>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" name="user_id" placeholder="User ID" required>
                            </div>
                            <div class="col-md-6 mb-2">
                                <input type="text" class="form-control" name="server_id" placeholder="Server ID">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <strong>2</strong>
                            </div>
                            <h5 class="mb-0 text-dark fw-bold">Pilih Produk</h5>
                        </div>

                        <ul class="nav nav-pills mb-3" id="productTypeTabs" role="tablist">
                            @foreach($game->items->groupBy('tipe_item_id') as $tipeId => $groupedItems)
                                @php $tipeItem = $groupedItems->first()->tipeItem; @endphp
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link {{ $loop->first ? 'active' : '' }}" id="tab-{{ $tipeId }}" data-bs-toggle="pill" data-bs-target="#content-{{ $tipeId }}" type="button">
                                        {{ $tipeItem->icon }} {{ $tipeItem->name }}
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
                                                <label class="btn btn-outline-primary w-100 text-start p-3 h-100" for="item-{{ $item->id }}" style="border: 2px solid #dee2e6; border-radius: 15px;">
                                                    <div class="d-flex flex-column align-items-center">
                                                        @php
                                                            $itemImage = $item->image && file_exists(storage_path('app/public/' . $item->image))
                                                                ? asset('storage/' . $item->image)
                                                                : asset('images/placeholder.png');
                                                        @endphp
                                                        <div class="bg-dark rounded mb-2 d-flex align-items-center justify-content-center" style="width: 100%; height: 80px; overflow: hidden;">
                                                            <img src="{{ $itemImage }}" alt="{{ $item->nama }}" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                        </div>
                                                        <h6 class="mb-2 text-dark fw-bold">{{ $item->nama }}</h6>
                                                        <p class="text-primary fw-bold mb-1">Rp. {{ number_format($item->harga, 0, ',', '.') }}</p>
                                                        <div class="d-flex gap-1">
                                                            <span class="badge bg-success">{{ $item->discount_percent }}%</span>
                                                            <span class="badge bg-secondary text-decoration-line-through">Rp. {{ number_format($item->harga_coret, 0, ',', '.') }}</span>
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

                <!-- Step 3: Promo Code -->
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <strong>3</strong>
                            </div>
                            <h5 class="mb-0 text-dark fw-bold">Masukkan Kode Promo</h5>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-md-9 mb-2">
                                <input type="text" class="form-control" name="promo_code" id="promoCodeInput" placeholder="O5rG0W6CtxCUb8v8">
                            </div>
                            <div class="col-md-3 mb-2">
                                <button type="button" class="btn btn-primary w-100" id="checkPromoBtn">Cek Kode →</button>
                            </div>
                        </div>
                        <div id="promoMessage" class="mt-2"></div>
                    </div>
                </div>

                <!-- Step 4: Payment Method -->
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <strong>4</strong>
                            </div>
                            <h5 class="mb-0 text-dark fw-bold">Cara Pembayaran</h5>
                        </div>
                        <div class="row">
                            @foreach($metodePembayaran as $metode)
                                <div class="col-lg-6 mb-3">
                                    <input type="radio" class="btn-check" name="metode_pembayaran_id" id="payment-{{ $metode->id }}" value="{{ $metode->id }}" data-fee="{{ $metode->fee }}" required>
                                    <label class="btn btn-outline-primary w-100 p-3" for="payment-{{ $metode->id }}" style="border: 2px solid #dee2e6; border-radius: 15px;">
                                        <div class="d-flex flex-column align-items-center">
                                            @php
                                                $paymentLogo = $metode->logo && file_exists(storage_path('app/public/' . $metode->logo))
                                                    ? asset('storage/' . $metode->logo)
                                                    : asset('images/placeholder.png');
                                            @endphp
                                            <img src="{{ $paymentLogo }}" alt="{{ $metode->name }}" class="mb-2" style="height: 40px; object-fit: contain;">
                                            <h6 class="mb-1 text-dark fw-bold">{{ $metode->name }}</h6>
                                            <small class="text-muted">Biaya Admin: Rp {{ number_format($metode->fee, 0, ',', '.') }}</small>
                                            <p class="text-primary fw-bold mb-0 mt-2">Total Harga: <span class="total-price">Rp. 0</span></p>
                                        </div>
                                    </label>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Step 5: Phone Number -->
                <div class="card bg-light mb-3">
                    <div class="card-body">
                        <div class="d-flex align-items-center mb-3">
                            <div class="rounded-circle bg-primary text-white d-flex align-items-center justify-content-center me-3" style="width: 40px; height: 40px;">
                                <strong>5</strong>
                            </div>
                            <h5 class="mb-0 text-dark fw-bold">Nomor Telepon</h5>
                        </div>
                        <input type="tel" class="form-control" name="phone" placeholder="Masukkan Nomor Telepon Anda" required>
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="card bg-light">
                    <div class="card-body text-center">
                        <button type="submit" class="btn btn-light btn-lg px-5" style="border-radius: 10px;">
                            🛒 <strong>Beli Sekarang</strong>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
    .btn-check:checked + .btn-outline-primary {
        background-color: #0d6efd !important;
        border-color: #0d6efd !important;
        color: white !important;
    }
    
    .btn-check:checked + .btn-outline-primary h6,
    .btn-check:checked + .btn-outline-primary p,
    .btn-check:checked + .btn-outline-primary small {
        color: white !important;
    }
    
    .nav-pills .nav-link {
        color: #495057;
        border-radius: 20px;
    }
    
    .nav-pills .nav-link.active {
        background-color: #0d6efd;
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function calculateTotal() {
        const itemRadio = document.querySelector('input[name="item_id"]:checked');
        const paymentRadio = document.querySelector('input[name="metode_pembayaran_id"]:checked');
        
        if (itemRadio && paymentRadio) {
            const itemPrice = parseFloat(itemRadio.dataset.price);
            const paymentFee = parseFloat(paymentRadio.dataset.fee);
            const total = itemPrice + paymentFee;
            
            document.querySelectorAll('.total-price').forEach(el => {
                el.textContent = 'Rp. ' + total.toLocaleString('id-ID');
            });
        }
    }
    
    document.querySelectorAll('input[name="item_id"], input[name="metode_pembayaran_id"]').forEach(radio => {
        radio.addEventListener('change', calculateTotal);
    });
    
    // Check promo code
    document.getElementById('checkPromoBtn').addEventListener('click', function() {
        const promoCode = document.getElementById('promoCodeInput').value;
        const messageDiv = document.getElementById('promoMessage');
        
        if (!promoCode) {
            messageDiv.innerHTML = '<small class="text-danger">Masukkan kode promo terlebih dahulu</small>';
            return;
        }
        
        // AJAX call to verify promo code
        fetch('{{ route("promo.verify") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            body: JSON.stringify({ code: promoCode })
        })
        .then(response => response.json())
        .then(data => {
            if (data.valid) {
                messageDiv.innerHTML = `<small class="text-success">Kode Promo Valid! Selamat anda mendapatkan potongan sebesar ${data.discount}% (Maksimal Rp.${data.max_discount.toLocaleString('id-ID')}) dalam pembelian ini!</small>`;
            } else {
                messageDiv.innerHTML = '<small class="text-danger">Kode promo tidak valid atau sudah kadaluarsa</small>';
            }
        });
    });
});
</script>
@endsection