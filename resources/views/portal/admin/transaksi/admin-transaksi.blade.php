@extends('layouts.admin_mainLayout')

@section('title', 'Transactions Management')

@section('content')
    @include('layouts.components.admin._admin_navigation')
    
    <main class="admin-main-content">
        <div class="container-fluid py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Transactions Management</h1>
                <div class="d-flex gap-2">
                    <!-- Filter Form -->
                    <form method="GET" class="d-flex gap-2">
                        <select name="status" class="form-select form-select-sm">
                            <option value="">All Status</option>
                            <option value="paid" {{ request('status') === 'paid' ? 'selected' : '' }}>Paid</option>
                            <option value="unpaid" {{ request('status') === 'unpaid' ? 'selected' : '' }}>Unpaid</option>
                            <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                        <button type="submit" class="btn btn-outline-primary btn-sm">Filter</button>
                        <a href="{{ route('admin.transaksi.index') }}" class="btn btn-outline-secondary btn-sm">Reset</a>
                    </form>
                </div>
            </div>
            
            <div class="row mt-4">
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body text-center">
                            <h4>{{ $summary['total_paid'] ?? 0 }}</h4>
                            <p class="mb-0">Paid Transactions</p>
                            <small>Rp {{ number_format($summary['revenue'] ?? 0) }}</small>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body text-center">
                            <h4>{{ $summary['total_unpaid'] ?? 0 }}</h4>
                            <p class="mb-0">Unpaid Transactions</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body text-center">
                            <h4>{{ $summary['total_today'] ?? 0 }}</h4>
                            <p class="mb-0">Today's Transactions</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body text-center">
                            <h4>Rp {{ number_format($summary['avg_order_value'] ?? 0) }}</h4>
                            <p class="mb-0">Avg Order Value</p>
                        </div>
                    </div>
                </div>
            </div>
            <br></br>
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
                                    <th>Order ID</th>
                                    <th>User</th>
                                    <th>Game</th>
                                    <th>Payment Method</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($transaksi ?? [] as $transaction)
                                <tr>
                                    <td><strong>{{ $transaction->order_id }}</strong></td>
                                    <td>
                                        {{ $transaction->user->name ?? 'N/A' }}<br>
                                        <small class="text-muted">{{ $transaction->user->email ?? 'N/A' }}</small>
                                    </td>
                                    <td>
                                        @if($transaction->items && $transaction->items->isNotEmpty())
                                            @foreach($transaction->items as $item)
                                                @if($item->item && $item->item->game)
                                                    <div class="d-flex align-items-center mb-1">
                                                        {{ $item->item->game->name ?? $item->item->nama ?? 'Unknown Item' }}
                                                        <small class="text-muted ms-2">({{ $item->quantity }}x)</small>
                                                    </div>
                                                @elseif($item->tipeItem)
                                                    <div class="d-flex align-items-center mb-1">
                                                        {{ $item->tipeItem->name }}
                                                        <small class="text-muted ms-2">({{ $item->quantity }}x)</small>
                                                    </div>
                                                @else
                                                    <div class="text-muted mb-1">Unknown Item</div>
                                                @endif
                                            @endforeach
                                        @else
                                            <span class="text-muted">No items</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($transaction->metodePembayaran)
                                            <div class="d-flex align-items-center">
                                                @if($transaction->metodePembayaran->logo)
                                                    <img src="{{ asset('storage/payment-methods/' . $transaction->metodePembayaran->logo) }}" 
                                                         alt="{{ $transaction->metodePembayaran->name }}" 
                                                         style="width: 24px; height: 24px; object-fit: contain; margin-right: 6px;">
                                                @endif
                                                {{ $transaction->metodePembayaran->name }}
                                            </div>
                                        @else
                                            <span class="text-muted">Unknown</span>
                                        @endif
                                    </td>
                                    <td><strong>Rp {{ number_format($transaction->total_harga ?? 0) }}</strong></td>
                                    <td>
                                        @if($transaction->status === 'paid')
                                            <span class="badge bg-success">Paid</span>
                                        @elseif($transaction->status === 'unpaid')
                                            <span class="badge bg-warning">Unpaid</span>
                                        @else
                                            <span class="badge bg-secondary">{{ ucfirst($transaction->status ?? 'pending') }}</span>
                                        @endif
                                    </td>
                                    <td>
                                        {{ $transaction->created_at ? $transaction->created_at->format('d M Y') : 'N/A' }}<br>
                                        <small class="text-muted">{{ $transaction->created_at ? $transaction->created_at->format('H:i') : '' }}</small>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.transaksi.show', $transaction) }}" class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        @if($transaction->status === 'unpaid')
                                        <form action="{{ route('admin.transaksi.update', $transaction) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <input type="hidden" name="status" value="paid">
                                            <button type="submit" class="btn btn-sm btn-success" 
                                                    onclick="return confirm('Mark this transaction as paid?')">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="8" class="text-center">No transactions found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            
            <!-- Transaction Summary -->
            
        </div>
    </main>
@endsection