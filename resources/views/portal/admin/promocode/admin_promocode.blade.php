@extends('layouts.admin_mainLayout')

@section('title', 'Promo Codes Management')

@section('content')
    @include('layouts.components.admin._admin_navigation')
    
    <main class="admin-main-content">
        <div class="container-fluid py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Promo Codes</h1>
                <a href="{{ route('admin.promo-codes.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Promo Code
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
                                    <th>Code</th>
                                    <th>Item Type</th>
                                    <th>Quota</th>
                                    <th>Discount</th>
                                    <th>Valid From</th>
                                    <th>Valid Until</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($promoCodes ?? [] as $promo)
                                <tr>
                                    <td><strong>{{ $promo->code }}</strong></td>
                                    <td>{{ $promo->tipeItem ? $promo->tipeItem->name : 'All Items' }}</td>
                                    <td><span class="badge bg-info">{{ $promo->kuota }}</span></td>
                                    <td>
                                        @if($promo->discount_percent)
                                            {{ $promo->discount_percent }}%
                                        @elseif($promo->discount_amount)
                                            Rp {{ number_format($promo->discount_amount) }}
                                        @else
                                            No Discount
                                        @endif
                                    </td>
                                    <td>{{ $promo->start_at ? $promo->start_at->format('d M Y') : 'N/A' }}</td>
                                    <td>{{ $promo->end_at ? $promo->end_at->format('d M Y') : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('admin.promo-codes.edit', $promo) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.promo-codes.destroy', $promo) }}" method="POST" class="d-inline">
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
                                    <td colspan="7" class="text-center">No promo codes found</td>
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