@extends('admin.layouts.app')

@section('title', 'Edit User')

@section('content')
<div class="px-3 py-3">
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Edit User</h1>
            <p class="text-muted small mb-0">Update: <strong>{{ $user->name }}</strong></p>
        </div>
        <div class="d-flex gap-2">
            @if($user->role === 'super_admin')
                <span class="badge bg-warning"><i class="fas fa-crown me-1"></i>Super Admin</span>
            @elseif($user->role === 'admin')
                <span class="badge bg-purple"><i class="fas fa-user-shield me-1"></i>Admin</span>
            @else
                <span class="badge bg-secondary"><i class="fas fa-user me-1"></i>User</span>
            @endif
            <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        {{-- KOLOM KIRI: FORM --}}
        <div class="col-lg-8">
            <form action="{{ route('admin.users.update', $user) }}" method="POST" id="userForm">
                @csrf
                @method('PUT')

                {{-- 1. INFORMASI DASAR --}}
                <div class="card shadow-sm mb-3">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-user me-2"></i>Informasi Dasar</h6>
                    </div>
                    <div class="card-body">
                        {{-- Nama --}}
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold small">
                                Nama Lengkap <span class="text-danger">*</span>
                            </label>
                            <input type="text" 
                                   id="name" 
                                   name="name" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name', $user->name) }}" 
                                   placeholder="Masukkan nama lengkap" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-3">
                            <label for="email" class="form-label fw-bold small">
                                Email <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       class="form-control @error('email') is-invalid @enderror" 
                                       value="{{ old('email', $user->email) }}" 
                                       placeholder="user@example.com" 
                                       required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Phone --}}
                        <div class="mb-0">
                            <label for="phone" class="form-label fw-bold small">Nomor Telepon</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                <input type="tel" 
                                       id="phone" 
                                       name="phone" 
                                       class="form-control @error('phone') is-invalid @enderror" 
                                       value="{{ old('phone', $user->phone) }}" 
                                       placeholder="08xx xxxx xxxx">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. PASSWORD (OPTIONAL) --}}
                <div class="card shadow-sm mb-3">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-lock me-2"></i>Ubah Password (Opsional)</h6>
                    </div>
                    <div class="card-body">
                        <div class="alert alert-info border-0 bg-info-subtle mb-3" role="alert">
                            <small><i class="fas fa-info-circle me-1"></i>Kosongkan jika tidak ingin mengubah password</small>
                        </div>

                        {{-- New Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold small">Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="Minimal 8 karakter">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password')">
                                    <i class="fas fa-eye" id="password-icon"></i>
                                </button>
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        {{-- Password Confirmation --}}
                        <div class="mb-0">
                            <label for="password_confirmation" class="form-label fw-bold small">Konfirmasi Password Baru</label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                <input type="password" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       class="form-control" 
                                       placeholder="Ulangi password baru">
                                <button class="btn btn-outline-secondary" type="button" onclick="togglePassword('password_confirmation')">
                                    <i class="fas fa-eye" id="password_confirmation-icon"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 3. ROLE & STATUS --}}
                <div class="card shadow-sm mb-3">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-user-shield me-2"></i>Role & Status</h6>
                    </div>
                    <div class="card-body">
                        {{-- Role --}}
                        <div class="mb-3">
                            <label for="role" class="form-label fw-bold small">
                                Role <span class="text-danger">*</span>
                            </label>
                            <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" 
                                    {{ ($user->id === auth()->id() || (!auth()->user()->isSuperAdmin() && $user->isAdmin())) ? 'disabled' : '' }} required>
                                <option value="">Pilih Role</option>
                                <option value="user" {{ old('role', $user->role) == 'user' ? 'selected' : '' }}>User</option>
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin</option>
                                @if(auth()->user()->isSuperAdmin())
                                    <option value="super_admin" {{ old('role', $user->role) == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                @endif
                            </select>
                            @if($user->id === auth()->id())
                                <small class="text-muted"><i class="fas fa-lock me-1"></i>Anda tidak dapat mengubah role sendiri</small>
                            @elseif(!auth()->user()->isSuperAdmin() && $user->isAdmin())
                                <small class="text-muted"><i class="fas fa-lock me-1"></i>Hanya Super Admin yang dapat mengubah role Admin</small>
                            @endif
                            @error('role')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Status --}}
                        <div class="mb-0">
                            <label class="form-label fw-bold small">
                                Status <span class="text-danger">*</span>
                            </label>
                            <div class="d-flex gap-3">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_active" id="active" value="1" 
                                           {{ old('is_active', $user->is_active) == '1' ? 'checked' : '' }}
                                           {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                    <label class="form-check-label" for="active">Aktif</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_active" id="inactive" value="0" 
                                           {{ old('is_active', $user->is_active) == '0' ? 'checked' : '' }}
                                           {{ $user->id === auth()->id() ? 'disabled' : '' }}>
                                    <label class="form-check-label" for="inactive">Nonaktif</label>
                                </div>
                            </div>
                            @if($user->id === auth()->id())
                                <small class="text-muted"><i class="fas fa-lock me-1"></i>Anda tidak dapat menonaktifkan akun sendiri</small>
                            @endif
                            @error('is_active')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Last Login Info --}}
                @if($user->last_login_at)
                <div class="alert alert-info border-0" role="alert">
                    <h6 class="alert-heading fw-bold small">
                        <i class="fas fa-clock me-2"></i>Informasi Login Terakhir
                    </h6>
                    <p class="mb-1 small">
                        <strong>Waktu:</strong> {{ $user->last_login_at->format('d M Y, H:i') }} 
                        ({{ $user->last_login_at->diffForHumans() }})
                    </p>
                    @if($user->last_login_ip)
                        <p class="mb-0 small"><strong>IP:</strong> {{ $user->last_login_ip }}</p>
                    @endif
                </div>
                @endif

                {{-- BUTTONS --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-save me-1"></i> Update User
                    </button>
                </div>
            </form>
        </div>

        {{-- KOLOM KANAN: INFORMASI --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-left-primary" style="position: sticky; top: 100px;">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="m-0 fw-bold"><i class="fas fa-info-circle me-2"></i>Informasi</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning border-0 bg-warning-subtle text-warning-emphasis mb-3" role="alert">
                        <small><strong>Perhatian:</strong> Pastikan data sudah benar.</small>
                    </div>

                    <div class="space-y-3">
                        {{-- Stats --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-info fw-bold mb-2 small">
                                <i class="fas fa-chart-line text-info me-2"></i> Data User
                            </h6>
                            <p class="text-muted small mb-1">
                                <strong>User ID:</strong> #{{ $user->id }}
                            </p>
                            <p class="text-muted small mb-1">
                                <strong>Bergabung:</strong> {{ $user->created_at->format('d M Y') }}
                            </p>
                            <p class="text-muted small mb-0">
                                <strong>Update:</strong> {{ $user->updated_at->diffForHumans() }}
                            </p>
                        </div>

                        {{-- Guide 1 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-primary fw-bold mb-2 small">
                                <i class="fas fa-edit text-primary me-2"></i> Edit Data
                            </h6>
                            <p class="text-muted small mb-0">
                                Anda dapat mengubah:<br>
                                • Nama lengkap<br>
                                • Email<br>
                                • Nomor telepon<br>
                                • Password (optional)<br>
                                • Role & status
                            </p>
                        </div>

                        {{-- Guide 2 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-success fw-bold mb-2 small">
                                <i class="fas fa-lock text-success me-2"></i> Password
                            </h6>
                            <p class="text-muted small mb-0">
                                • Kosongkan = tidak berubah<br>
                                • Isi = ganti password baru<br>
                                • Minimal 8 karakter<br>
                                • Konfirmasi harus sama
                            </p>
                        </div>

                        {{-- Guide 3 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-danger fw-bold mb-2 small">
                                <i class="fas fa-exclamation-triangle text-danger me-2"></i> Penting!
                            </h6>
                            <p class="text-muted small mb-0">
                                • Tidak bisa ubah role sendiri<br>
                                • Tidak bisa nonaktifkan diri<br>
                                • Admin tidak bisa ubah Super Admin<br>
                                • Email harus unik
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT --}}
<script>
function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    const icon = document.getElementById(fieldId + '-icon');
    
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>

<style>
.bg-purple { background-color: #6f42c1 !important; }
.border-left-primary { border-left: 4px solid #0d6efd !important; }
</style>
@endsection