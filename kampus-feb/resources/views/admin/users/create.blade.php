@extends('admin.layouts.app')

@section('title', 'Tambah User')

@section('content')
<div class="px-3 py-3">
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Tambah User Baru</h1>
            <p class="text-muted small mb-0">Lengkapi form untuk menambahkan user baru.</p>
        </div>
        <a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        {{-- KOLOM KIRI: FORM --}}
        <div class="col-lg-8">
            <form action="{{ route('admin.users.store') }}" method="POST" id="userForm">
                @csrf

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
                                   value="{{ old('name') }}" 
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
                                       value="{{ old('email') }}" 
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
                                       value="{{ old('phone') }}" 
                                       placeholder="08xx xxxx xxxx">
                                @error('phone')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>
                    </div>
                </div>

                {{-- 2. PASSWORD --}}
                <div class="card shadow-sm mb-3">
                    <div class="card-header py-3 bg-white">
                        <h6 class="m-0 fw-bold text-primary"><i class="fas fa-lock me-2"></i>Password</h6>
                    </div>
                    <div class="card-body">
                        {{-- Password --}}
                        <div class="mb-3">
                            <label for="password" class="form-label fw-bold small">
                                Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       class="form-control @error('password') is-invalid @enderror" 
                                       placeholder="Minimal 8 karakter" 
                                       required>
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
                            <label for="password_confirmation" class="form-label fw-bold small">
                                Konfirmasi Password <span class="text-danger">*</span>
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-key"></i></span>
                                <input type="password" 
                                       id="password_confirmation" 
                                       name="password_confirmation" 
                                       class="form-control" 
                                       placeholder="Ulangi password" 
                                       required>
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
                            <select id="role" name="role" class="form-select @error('role') is-invalid @enderror" required>
                                <option value="">Pilih Role</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                                @if(auth()->user()->isSuperAdmin())
                                    <option value="super_admin" {{ old('role') == 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                                @endif
                            </select>
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
                                           {{ old('is_active', '1') == '1' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="active">Aktif</label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="is_active" id="inactive" value="0" 
                                           {{ old('is_active') == '0' ? 'checked' : '' }}>
                                    <label class="form-check-label" for="inactive">Nonaktif</label>
                                </div>
                            </div>
                            @error('is_active')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- BUTTONS --}}
                <div class="d-flex justify-content-end gap-2">
                    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary btn-sm">
                        <i class="fas fa-times me-1"></i> Batal
                    </a>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-save me-1"></i> Simpan User
                    </button>
                </div>
            </form>
        </div>

        {{-- KOLOM KANAN: PETUNJUK --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-left-primary" style="position: sticky; top: 100px;">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="m-0 fw-bold"><i class="fas fa-info-circle me-2"></i>Petunjuk</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info border-0 bg-info-subtle text-info-emphasis mb-3" role="alert">
                        <small><strong>Tips:</strong> Field bertanda <span class="text-danger">*</span> wajib diisi.</small>
                    </div>

                    <div class="space-y-3">
                        {{-- Guide 1 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-primary fw-bold mb-2 small">
                                <i class="fas fa-user text-primary me-2"></i> Informasi Dasar
                            </h6>
                            <p class="text-muted small mb-0">
                                • Nama lengkap user<br>
                                • Email untuk login<br>
                                • Nomor telepon (optional)<br>
                                • Email harus unik
                            </p>
                        </div>

                        {{-- Guide 2 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-success fw-bold mb-2 small">
                                <i class="fas fa-lock text-success me-2"></i> Password
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Keamanan:</strong><br>
                                • Minimal 8 karakter<br>
                                • Kombinasi huruf & angka<br>
                                • Konfirmasi harus sama<br>
                                • Gunakan password kuat
                            </p>
                        </div>

                        {{-- Guide 3 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-warning fw-bold mb-2 small">
                                <i class="fas fa-user-shield text-warning me-2"></i> Role & Akses
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Admin:</strong> Kelola konten<br>
                                <strong>Super Admin:</strong> Full akses<br>
                                <br>
                                Status menentukan apakah user dapat login.
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
.border-left-primary { border-left: 4px solid #0d6efd !important; }
</style>
@endsection