@extends('layouts.admin_mainLayout')

@section('title', 'Admin Dashboard')

@section('content')
    @include('layouts.components.admin._admin_navigation')
    
    <main class="admin-main-content">
        <div class="container-fluid py-4">
            <h1 class="mb-4">Dashboard</h1>
            
            <!-- Statistics Cards -->
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card bg-primary text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4>{{ $stats['total_promo_codes'] ?? 0 }}</h4>
                                    <p class="mb-0">Promo Codes</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-tags fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-success text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4>{{ $stats['total_banners'] ?? 0 }}</h4>
                                    <p class="mb-0">Banners</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-image fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-warning text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4>{{ $stats['total_notifications'] ?? 0 }}</h4>
                                    <p class="mb-0">Notifications</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-bell fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card bg-info text-white">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <div>
                                    <h4>{{ $stats['total_transactions'] ?? 0 }}</h4>
                                    <p class="mb-0">Transactions</p>
                                </div>
                                <div class="align-self-center">
                                    <i class="fas fa-receipt fa-2x"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Recent Transactions -->
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">Recent Transactions</h5>
                            <a href="{{ route('admin.transaksi.index') }}" class="btn btn-primary btn-sm">View All</a>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Order ID</th>
                                            <th>User</th>
                                            <th>Amount</th>
                                            <th>Status</th>
                                            <th>Date</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($recent_transactions ?? [] as $transaction)
                                        <tr>
                                            <td>{{ $transaction->order_id }}</td>
                                            <td>{{ $transaction->user->name ?? 'N/A' }}</td>
                                            <td>Rp {{ number_format($transaction->total ?? 0) }}</td>
                                            <td>
                                                @if($transaction->status === 'paid')
                                                    <span class="badge bg-success">Paid</span>
                                                @elseif($transaction->status === 'unpaid')
                                                    <span class="badge bg-warning text-dark">Unpaid</span>
                                                @elseif($transaction->status === 'cancelled')
                                                    <span class="badge bg-danger">Cancelled</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ ucfirst($transaction->status ?? 'pending') }}</span>
                                                @endif
                                            </td>
                                            <td>{{ $transaction->created_at ? $transaction->created_at->format('d M Y') : 'N/A' }}</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="5" class="text-center">No transactions found</td>
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
@endsection
