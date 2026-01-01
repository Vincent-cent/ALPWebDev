@extends('layouts.admin_mainLayout')

@section('title', 'Payment Methods Management')

@section('content')
    @include('layouts.components.admin._admin_navigation')
    
    <main class="admin-main-content">
        <div class="container-fluid py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Payment Methods</h1>
                <a href="{{ route('admin.metode-pembayarans.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Payment Method
                </a>
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
                                    <th>Logo</th>
                                    <th>Name</th>
                                    <th>Type</th>
                                    <th>Fee</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($metodePembayarans ?? [] as $metode)
                                <tr>
                                    <td>
                                        @if($metode->logo)
                                            <img src="{{ asset('storage/payment-methods/' . $metode->logo) }}" 
                                                 alt="{{ $metode->name }}" 
                                                 style="width: 40px; height: 40px; object-fit: contain; border-radius: 4px;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 40px; height: 40px; border-radius: 4px;">
                                                <i class="fas fa-credit-card text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td><strong>{{ $metode->name }}</strong></td>
                                    <td>
                                        <span class="badge bg-info">{{ ucfirst(str_replace('_', ' ', $metode->type ?? 'bank_transfer')) }}</span>
                                    </td>
                                    <td>Rp {{ number_format($metode->fee ?? 0) }}</td>
                                    <td>
                                        <span class="badge bg-{{ $metode->is_active ? 'success' : 'secondary' }}">
                                            {{ $metode->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $metode->created_at ? $metode->created_at->format('d M Y') : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('admin.metode-pembayarans.edit', $metode) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.metode-pembayarans.destroy', $metode) }}" method="POST" class="d-inline">
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
                                    <td colspan="7" class="text-center">No payment methods found</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection