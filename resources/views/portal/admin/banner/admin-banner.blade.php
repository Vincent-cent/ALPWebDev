@extends('layouts.admin_mainLayout')

@section('title', 'Banner Management')

@section('content')
    @include('layouts.components.admin._admin_navigation')
    
    <main class="admin-main-content">
        <div class="container-fluid py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Banner Management</h1>
                <a href="{{ route('admin.banner-promos.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Banner
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
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Game</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($bannerPromos ?? [] as $banner)
                                <tr>
                                    <td>
                                        @if($banner->image)
                                            <img src="{{ asset($banner->image) }}" 
                                                 alt="{{ $banner->name }}" 
                                                 style="width: 80px; height: 50px; object-fit: cover; border-radius: 4px;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 80px; height: 50px; border-radius: 4px;">
                                                <i class="fas fa-image text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td><strong>{{ $banner->name }}</strong></td>
                                    <td>{{ $banner->game ? $banner->game->name : 'No Game' }}</td>
                                    <td><span class="badge bg-secondary">{{ $banner->order ?? 0 }}</span></td>
                                    <td>
                                        <span class="badge bg-{{ $banner->is_active ? 'success' : 'secondary' }}">
                                            {{ $banner->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $banner->created_at ? $banner->created_at->format('d M Y') : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('admin.banner-promos.edit', $banner) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.banner-promos.destroy', $banner) }}" method="POST" class="d-inline">
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
                                    <td colspan="7" class="text-center">No banners found</td>
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