@extends('layouts.admin_mainLayout')

@section('title', 'Notifications Management')

@section('content')
    @include('layouts.components.admin._admin_navigation')
    
    <main class="admin-main-content">
        <div class="container-fluid py-4">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1>Notifications Management</h1>
                <a href="{{ route('admin.promo-notifikasi.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>Add New Notification
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
                                    <th>Title</th>
                                    <th>Content</th>
                                    <th>Type</th>
                                    <th>Priority</th>
                                    <th>Status</th>
                                    <th>Created</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($promoNotifikasi ?? [] as $notification)
                                <tr>
                                    <td>
                                        @if($notification->image_url)
                                            <img src="{{ asset('storage/notifications/' . $notification->image_url) }}" 
                                                 alt="{{ $notification->title }}" 
                                                 style="width: 60px; height: 60px; object-fit: cover; border-radius: 4px;">
                                        @else
                                            <div class="bg-light d-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 60px; border-radius: 4px;">
                                                <i class="fas fa-bell text-muted"></i>
                                            </div>
                                        @endif
                                    </td>
                                    <td><strong>{{ $notification->title }}</strong></td>
                                    <td>{{ Str::limit($notification->content ?? '', 50) }}</td>
                                    <td><span class="badge bg-info">{{ ucfirst($notification->type ?? 'general') }}</span></td>
                                    <td>
                                        @if($notification->priority === 'high')
                                            <span class="badge bg-danger">High</span>
                                        @elseif($notification->priority === 'medium')
                                            <span class="badge bg-warning">Medium</span>
                                        @else
                                            <span class="badge bg-secondary">Low</span>
                                        @endif
                                    </td>
                                    <td>
                                        <span class="badge bg-{{ $notification->is_active ? 'success' : 'secondary' }}">
                                            {{ $notification->is_active ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td>{{ $notification->created_at ? $notification->created_at->format('d M Y') : 'N/A' }}</td>
                                    <td>
                                        <a href="{{ route('admin.promo-notifikasi.edit', $notification) }}" class="btn btn-sm btn-warning">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.promo-notifikasi.destroy', $notification) }}" method="POST" class="d-inline">
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
                                    <td colspan="8" class="text-center">No notifications found</td>
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