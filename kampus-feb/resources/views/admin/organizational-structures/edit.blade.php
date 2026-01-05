@extends('admin.layouts.app')

@section('title', 'Edit Struktur Organisasi')

@push('styles')
<style>
    .preview-photo {
        width: 150px;
        height: 150px;
        object-fit: cover;
    }
    
    .current-photo {
        width: 120px;
        height: 120px;
        object-fit: cover;
    }
    
    .help-card {
        border-left: 4px solid #0d6efd;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }
    
    .hierarchy-badge {
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
    }
</style>
@endpush

@section('content')
<div class="container-fluid px-4 py-4">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <!-- Header -->
            <div class="d-flex align-items-center gap-3 mb-4">
                <a href="{{ route('admin.organizational-structures.index') }}" class="btn btn-light">
                    <i class="fas fa-arrow-left"></i>
                </a>
                <div>
                    <h1 class="h3 fw-bold mb-1">Edit Struktur Organisasi</h1>
                    <p class="text-muted mb-0">Perbarui informasi anggota struktur organisasi</p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Form Section -->
                <div class="col-lg-8">
                    <form action="{{ route('admin.organizational-structures.update', $organizationalStructure) }}" 
                          method="POST" 
                          enctype="multipart/form-data"
                          id="orgForm">
                        @csrf
                        @method('PUT')
                        
                        <!-- Informasi Dasar -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4">
                                    <i class="fas fa-user text-primary me-2"></i>Informasi Dasar
                                </h5>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        Nama Lengkap <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="name" required
                                           class="form-control @error('name') is-invalid @enderror"
                                           value="{{ old('name', $organizationalStructure->name) }}"
                                           placeholder="Contoh: Dr. Ahmad Budiman, M.T.">
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        Jabatan <span class="text-danger">*</span>
                                    </label>
                                    <input type="text" name="position" required
                                           class="form-control @error('position') is-invalid @enderror"
                                           value="{{ old('position', $organizationalStructure->position) }}"
                                           placeholder="Contoh: Dekan, Wakil Dekan I, Ketua Prodi">
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">NIP / NIDN</label>
                                    <input type="text" name="nip"
                                           class="form-control @error('nip') is-invalid @enderror"
                                           value="{{ old('nip', $organizationalStructure->nip) }}"
                                           placeholder="Contoh: 198501012010121001">
                                    @error('nip')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Hierarki -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4">
                                    <i class="fas fa-sitemap text-primary me-2"></i>Hierarki Organisasi
                                </h5>

                                <!-- Current Hierarchy -->
                                <div class="alert alert-info border-0 mb-4">
                                    <div class="d-flex align-items-center gap-2 mb-2">
                                        <i class="fas fa-info-circle"></i>
                                        <strong>Hierarki Saat Ini:</strong>
                                    </div>
                                    <div class="hierarchy-badge text-white px-3 py-2 rounded d-inline-block">
                                        {{ $organizationalStructure->getHierarchyPath() }}
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Atasan Langsung</label>
                                    <select name="parent_id" 
                                            class="form-select @error('parent_id') is-invalid @enderror">
                                        <option value="">-- Tidak Ada (Posisi Tertinggi/Root) --</option>
                                        @foreach($parentOptions as $option)
                                        <option value="{{ $option->id }}" 
                                                {{ old('parent_id', $organizationalStructure->parent_id) == $option->id ? 'selected' : '' }}>
                                            {{ str_repeat('— ', $option->getLevel()) }} 
                                            {{ $option->position }} ({{ $option->name }})
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="fas fa-exclamation-triangle me-1"></i>
                                        Hati-hati mengubah atasan, ini akan mempengaruhi struktur hierarki
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        Tipe <span class="text-danger">*</span>
                                    </label>
                                    <select name="type" required
                                            class="form-select @error('type') is-invalid @enderror">
                                        <option value="structural" {{ old('type', $organizationalStructure->type) == 'structural' ? 'selected' : '' }}>
                                            🏢 Struktural (Dekan, Wakil Dekan, dll)
                                        </option>
                                        <option value="academic" {{ old('type', $organizationalStructure->type) == 'academic' ? 'selected' : '' }}>
                                            🎓 Akademik (Ketua Prodi, Dosen, dll)
                                        </option>
                                        <option value="administrative" {{ old('type', $organizationalStructure->type) == 'administrative' ? 'selected' : '' }}>
                                            📋 Administratif (Kepala Bagian, Staff, dll)
                                        </option>
                                    </select>
                                    @error('type')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label class="form-label fw-semibold">Urutan Tampilan</label>
                                    <input type="number" name="order" min="0"
                                           class="form-control"
                                           value="{{ old('order', $organizationalStructure->order) }}"
                                           placeholder="0">
                                    <div class="form-text">
                                        Angka lebih kecil = muncul lebih dulu
                                    </div>
                                </div>

                                <!-- Children Warning -->
                                @if($organizationalStructure->children->count() > 0)
                                <div class="alert alert-warning border-0 mt-4 mb-0">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="fas fa-users"></i>
                                        <strong>Perhatian:</strong>
                                    </div>
                                    <p class="mb-0 mt-2 small">
                                        Struktur ini memiliki <strong>{{ $organizationalStructure->children->count() }} bawahan langsung</strong>. 
                                        Jika Anda menghapus atau mengubah hierarki, bawahan akan terpengaruh.
                                    </p>
                                </div>
                                @endif
                            </div>
                        </div>

                        <!-- Kontak -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4">
                                    <i class="fas fa-envelope text-primary me-2"></i>Informasi Kontak
                                </h5>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-envelope"></i>
                                        </span>
                                        <input type="email" name="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               value="{{ old('email', $organizationalStructure->email) }}"
                                               placeholder="email@domain.ac.id">
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div>
                                    <label class="form-label fw-semibold">Telepon</label>
                                    <div class="input-group">
                                        <span class="input-group-text">
                                            <i class="fas fa-phone"></i>
                                        </span>
                                        <input type="text" name="phone"
                                               class="form-control @error('phone') is-invalid @enderror"
                                               value="{{ old('phone', $organizationalStructure->phone) }}"
                                               placeholder="08xxxxxxxxxx">
                                    </div>
                                    @error('phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Foto -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4">
                                    <i class="fas fa-image text-primary me-2"></i>Foto Profil
                                </h5>

                                @if($organizationalStructure->photo)
                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Foto Saat Ini</label>
                                    <div>
                                        <img src="{{ Storage::url($organizationalStructure->photo) }}" 
                                             class="rounded-circle current-photo border border-3 border-success"
                                             alt="{{ $organizationalStructure->name }}">
                                    </div>
                                </div>
                                @endif

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">
                                        {{ $organizationalStructure->photo ? 'Ganti Foto' : 'Upload Foto' }}
                                    </label>
                                    <input type="file" name="photo" accept="image/*"
                                           class="form-control @error('photo') is-invalid @enderror"
                                           id="photoInput">
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        Format: JPG, PNG, WebP | Maksimal: 2MB | Rekomendasi: 500x500px
                                    </div>
                                </div>

                                <!-- Preview -->
                                <div id="photoPreview" class="d-none mt-3">
                                    <p class="fw-semibold mb-2">Preview Foto Baru:</p>
                                    <div class="position-relative d-inline-block">
                                        <img id="preview" src="" alt="Preview" 
                                             class="rounded-circle preview-photo border border-3 border-primary">
                                        <button type="button" id="removePhoto" 
                                                class="btn btn-danger btn-sm position-absolute top-0 end-0 rounded-circle"
                                                style="width: 32px; height: 32px;">
                                            <i class="fas fa-times"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div class="card border-0 shadow-sm mb-4">
                            <div class="card-body p-4">
                                <h5 class="fw-bold mb-4">
                                    <i class="fas fa-align-left text-primary me-2"></i>Deskripsi
                                </h5>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Deskripsi / Bio Singkat</label>
                                    <textarea name="description" rows="4"
                                              class="form-control @error('description') is-invalid @enderror"
                                              placeholder="Tulis deskripsi singkat atau bio...">{{ old('description', $organizationalStructure->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-check">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" 
                                           {{ old('is_active', $organizationalStructure->is_active) ? 'checked' : '' }}
                                           class="form-check-input">
                                    <label for="is_active" class="form-check-label">
                                        <strong>Aktif</strong>
                                        <small class="d-block text-muted">Tampilkan dalam struktur organisasi</small>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="d-flex gap-3 justify-content-end">
                            <a href="{{ route('admin.organizational-structures.index') }}" 
                               class="btn btn-outline-secondary px-4">
                                <i class="fas fa-times me-2"></i>Batal
                            </a>
                            <button type="submit" class="btn btn-primary px-4">
                                <i class="fas fa-check me-2"></i>Update
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Help Sidebar -->
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 1rem;">
                        <!-- Info Card -->
                        <div class="card border-0 shadow-sm help-card mb-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-info-circle text-primary me-2"></i>
                                    Informasi Perubahan
                                </h6>
                                
                                <div class="small">
                                    <p class="mb-2">
                                        <i class="fas fa-check text-success me-2"></i>
                                        Perubahan akan disimpan setelah klik tombol <strong>Update</strong>
                                    </p>
                                    <p class="mb-2">
                                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                                        Hati-hati mengubah hierarki jika ada bawahan
                                    </p>
                                    <p class="mb-0">
                                        <i class="fas fa-image text-info me-2"></i>
                                        Upload foto baru untuk mengganti foto lama
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Statistics -->
                        <div class="card border-0 shadow-sm bg-light">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-chart-bar text-primary me-2"></i>
                                    Statistik
                                </h6>
                                
                                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                    <span class="small text-muted">Jumlah Bawahan:</span>
                                    <span class="badge bg-primary">{{ $organizationalStructure->children->count() }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center mb-2 pb-2 border-bottom">
                                    <span class="small text-muted">Level Hierarki:</span>
                                    <span class="badge bg-info">Level {{ $organizationalStructure->getLevel() }}</span>
                                </div>
                                
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="small text-muted">Status:</span>
                                    @if($organizationalStructure->is_active)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-secondary">Nonaktif</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
// Photo Preview
const photoInput = document.getElementById('photoInput');
const photoPreview = document.getElementById('photoPreview');
const preview = document.getElementById('preview');
const removeBtn = document.getElementById('removePhoto');

photoInput.addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            preview.src = e.target.result;
            photoPreview.classList.remove('d-none');
        };
        reader.readAsDataURL(file);
    }
});

removeBtn.addEventListener('click', function() {
    photoInput.value = '';
    photoPreview.classList.add('d-none');
    preview.src = '';
});

// Form Validation
document.getElementById('orgForm').addEventListener('submit', function(e) {
    const name = document.querySelector('input[name="name"]').value.trim();
    const position = document.querySelector('input[name="position"]').value.trim();
    
    if (!name || !position) {
        e.preventDefault();
        alert('⚠️ Nama dan Jabatan wajib diisi!');
        return false;
    }
});
</script>
@endpush
@endsection