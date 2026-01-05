@extends('admin.layouts.app')

@section('title', 'Manajemen User')
@section('page-title', 'Manajemen User')

@section('content')
<div class="container-fluid">
    <!-- Statistics Cards -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-lg">
            <div class="card border-start border-primary border-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small mb-1">Total User</p>
                            <h3 class="fw-bold mb-0">{{ $stats['total'] ?? 0 }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-users text-primary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg">
            <div class="card border-start border-purple border-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small mb-1">Admin</p>
                            <h3 class="fw-bold mb-0">{{ $stats['admins'] ?? 0 }}</h3>
                        </div>
                        <div class="bg-purple bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-user-shield text-purple fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg">
            <div class="card border-start border-secondary border-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small mb-1">Regular User</p>
                            <h3 class="fw-bold mb-0">{{ $stats['users'] ?? 0 }}</h3>
                        </div>
                        <div class="bg-secondary bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-user text-secondary fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg">
            <div class="card border-start border-success border-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small mb-1">Aktif</p>
                            <h3 class="fw-bold mb-0">{{ $stats['active'] ?? 0 }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-check-circle text-success fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-lg">
            <div class="card border-start border-danger border-4 h-100">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <p class="text-muted small mb-1">Nonaktif</p>
                            <h3 class="fw-bold mb-0">{{ $stats['inactive'] ?? 0 }}</h3>
                        </div>
                        <div class="bg-danger bg-opacity-10 rounded-circle p-3">
                            <i class="fas fa-times-circle text-danger fs-4"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters & Actions -->
    <div class="card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.users.index') }}">
                <div class="row g-3">
                    <div class="col-md-6">
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-search"></i></span>
                            <input type="text" name="search" class="form-control" placeholder="Cari nama, email, telepon..." value="{{ request('search') }}">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <select name="role" class="form-select">
                            <option value="">Semua Role</option>
                            <option value="super_admin" {{ request('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                            <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>User</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <select name="status" class="form-select">
                            <option value="">Semua Status</option>
                            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Aktif</option>
                            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Nonaktif</option>
                        </select>
                    </div>
                    <div class="col-md-2">
                        <div class="d-flex gap-2">
                            <button type="submit" class="btn btn-primary flex-fill">
                                <i class="fas fa-filter me-1"></i>Filter
                            </button>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-redo"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </form>

            @if(auth()->user()->isSuperAdmin())
            <div class="mt-3 pt-3 border-top">
                <a href="{{ route('admin.users.create') }}" class="btn btn-success">
                    <i class="fas fa-user-plus me-2"></i>Tambah User
                </a>
            </div>
            @endif
        </div>
    </div>

    <!-- Table (Desktop) -->
    <div class="card d-none d-lg-block">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>User</th>
                        <th>Kontak</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>Last Login</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center gap-2">
                                <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" 
                                     alt="{{ $user->name }}"
                                     class="rounded-circle" style="width: 40px; height: 40px; object-fit: cover;">
                                <div>
                                    <div class="fw-semibold">{{ $user->name }}</div>
                                </div>
                            </div>
                        </td>
                        <td>
                            <div>{{ $user->email }}</div>
                            @if($user->phone)
                                <small class="text-muted">{{ $user->phone }}</small>
                            @endif
                        </td>
                        <td>
                            @if($user->role === 'super_admin')
                                <span class="badge bg-warning">
                                    <i class="fas fa-crown me-1"></i>Super Admin
                                </span>
                            @elseif($user->role === 'admin')
                                <span class="badge bg-purple">
                                    <i class="fas fa-user-shield me-1"></i>Admin
                                </span>
                            @else
                                <span class="badge bg-secondary">
                                    <i class="fas fa-user me-1"></i>User
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($user->is_active)
                                <span class="badge bg-success">
                                    <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>Aktif
                                </span>
                            @else
                                <span class="badge bg-danger">
                                    <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>Nonaktif
                                </span>
                            @endif
                        </td>
                        <td>
                            @if($user->last_login_at)
                                <div>{{ $user->last_login_at->diffForHumans() }}</div>
                            @else
                                <small class="text-muted">Belum pernah</small>
                            @endif
                        </td>
                        <td>
                            <div class="d-flex justify-content-center gap-1">
                                @include('admin.users.partials.action-buttons', ['user' => $user])
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">
                            <i class="fas fa-users text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3 mb-2 fw-semibold">Tidak ada data user</p>
                            <p class="text-muted small">Coba ubah filter atau tambahkan user baru</p>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Cards (Mobile) -->
    <div class="d-lg-none">
        @forelse($users as $user)
        <div class="card mb-3">
            <div class="card-body">
                <div class="d-flex gap-3 mb-3">
                    <img src="{{ $user->avatar ?? 'https://ui-avatars.com/api/?name=' . urlencode($user->name) }}" 
                         alt="{{ $user->name }}"
                         class="rounded-circle" style="width: 50px; height: 50px; object-fit: cover;">
                    <div class="flex-grow-1">
                        <h6 class="fw-semibold mb-1">{{ $user->name }}</h6>
                        <p class="text-muted small mb-2">{{ $user->email }}</p>
                        @if($user->phone)
                            <p class="text-muted small mb-2">{{ $user->phone }}</p>
                        @endif
                        
                        <div class="d-flex flex-wrap gap-2 mb-2">
                            @if($user->role === 'super_admin')
                                <span class="badge bg-warning"><i class="fas fa-crown me-1"></i>Super Admin</span>
                            @elseif($user->role === 'admin')
                                <span class="badge bg-purple"><i class="fas fa-user-shield me-1"></i>Admin</span>
                            @else
                                <span class="badge bg-secondary"><i class="fas fa-user me-1"></i>User</span>
                            @endif
                            
                            @if($user->is_active)
                                <span class="badge bg-success"><i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>Aktif</span>
                            @else
                                <span class="badge bg-danger"><i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i>Nonaktif</span>
                            @endif
                        </div>

                        <p class="text-muted small mb-0">
                            <i class="fas fa-clock me-1"></i>
                            @if($user->last_login_at)
                                Login {{ $user->last_login_at->diffForHumans() }}
                            @else
                                Belum pernah login
                            @endif
                        </p>
                    </div>
                </div>

                <div class="d-flex gap-1 justify-content-end pt-2 border-top">
                    @include('admin.users.partials.action-buttons', ['user' => $user])
                </div>
            </div>
        </div>
        @empty
        <div class="card">
            <div class="card-body text-center py-5">
                <i class="fas fa-users text-muted" style="font-size: 3rem;"></i>
                <p class="text-muted mt-3 mb-2 fw-semibold">Tidak ada data user</p>
                <p class="text-muted small">Coba ubah filter atau tambahkan user baru</p>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($users->hasPages())
    <div class="d-flex justify-content-center mt-4">
        {{ $users->links() }}
    </div>
    @endif
</div>

<!-- Toast Container -->
<div class="position-fixed top-0 end-0 p-3" style="z-index: 11">
    <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-check-circle me-2"></i>
                <span id="successMessage"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>

    <div id="errorToast" class="toast align-items-center text-white bg-danger border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-exclamation-circle me-2"></i>
                <span id="errorMessage"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>

    <div id="infoToast" class="toast align-items-center text-white bg-info border-0" role="alert">
        <div class="d-flex">
            <div class="toast-body">
                <i class="fas fa-info-circle me-2"></i>
                <span id="infoMessage"></span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
        </div>
    </div>
</div>

@push('scripts')
<script>
@if(session('success'))
    showToast('success', '{{ session('success') }}');
@endif

@if(session('error'))
    showToast('error', '{{ session('error') }}');
@endif

@if(session('info'))
    showToast('info', '{{ session('info') }}');
@endif

function showToast(type, message) {
    const toastElement = document.getElementById(type + 'Toast');
    const messageElement = document.getElementById(type + 'Message');
    
    messageElement.textContent = message;
    const toast = new bootstrap.Toast(toastElement, {
        autohide: true,
        delay: 5000
    });
    toast.show();
}
</script>
@endpush

<style>
.border-purple { border-color: #6f42c1 !important; }
.bg-purple { background-color: #6f42c1 !important; }
.text-purple { color: #6f42c1 !important; }
</style>
@endsection