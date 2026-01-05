@extends('admin.layouts.app')

@section('title', 'Tambah Struktur Organisasi')

@push('styles')
<style>
    .preview-photo {
        width: 150px;
        height: 150px;
        object-fit: cover;
    }
    
    .help-card {
        border-left: 4px solid #0d6efd;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    }
    
    .step-number {
        width: 32px;
        height: 32px;
        background: linear-gradient(135deg, #0d6efd, #0a58ca);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        font-size: 0.875rem;
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
                    <h1 class="h3 fw-bold mb-1">Tambah Struktur Organisasi</h1>
                    <p class="text-muted mb-0">Tambahkan anggota baru ke struktur organisasi</p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Form Section -->
                <div class="col-lg-8">
                    <form action="{{ route('admin.organizational-structures.store') }}" 
                          method="POST" 
                          enctype="multipart/form-data"
                          id="orgForm">
                        @csrf
                        
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
                                           value="{{ old('name') }}"
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
                                           value="{{ old('position') }}"
                                           placeholder="Contoh: Dekan, Wakil Dekan I, Ketua Prodi">
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="fas fa-info-circle me-1"></i>
                                        Tulis jabatan secara lengkap dan jelas
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">NIP / NIDN</label>
                                    <input type="text" name="nip"
                                           class="form-control @error('nip') is-invalid @enderror"
                                           value="{{ old('nip') }}"
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

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">Atasan Langsung</label>
                                    <select name="parent_id" 
                                            class="form-select @error('parent_id') is-invalid @enderror">
                                        <option value="">-- Tidak Ada (Posisi Tertinggi/Root) --</option>
                                        @foreach($parentOptions as $option)
                                        <option value="{{ $option->id }}" 
                                                {{ old('parent_id') == $option->id ? 'selected' : '' }}>
                                            {{ str_repeat('— ', $option->getLevel()) }} 
                                            {{ $option->position }} ({{ $option->name }})
                                        </option>
                                        @endforeach
                                    </select>
                                    @error('parent_id')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <div class="form-text">
                                        <i class="fas fa-lightbulb me-1"></i>
                                        Pilih atasan langsung dalam struktur. Kosongkan jika ini adalah posisi tertinggi (Dekan)
                                    </div>
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        Tipe <span class="text-danger">*</span>
                                    </label>
                                    <select name="type" required
                                            class="form-select @error('type') is-invalid @enderror">
                                        <option value="structural" {{ old('type') == 'structural' ? 'selected' : '' }}>
                                            🏢 Struktural (Dekan, Wakil Dekan, dll)
                                        </option>
                                        <option value="academic" {{ old('type') == 'academic' ? 'selected' : '' }}>
                                            🎓 Akademik (Ketua Prodi, Dosen, dll)
                                        </option>
                                        <option value="administrative" {{ old('type') == 'administrative' ? 'selected' : '' }}>
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
                                           value="{{ old('order', 0) }}"
                                           placeholder="0">
                                    <div class="form-text">
                                        Angka lebih kecil = muncul lebih dulu. Kosongkan untuk otomatis
                                    </div>
                                </div>
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
                                               value="{{ old('email') }}"
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
                                               value="{{ old('phone') }}"
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

                                <div class="mb-3">
                                    <label class="form-label fw-semibold">Upload Foto</label>
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
                                    <p class="fw-semibold mb-2">Preview:</p>
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
                                              placeholder="Tulis deskripsi singkat atau bio...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="form-check">
                                    <input type="checkbox" name="is_active" id="is_active" value="1" 
                                           {{ old('is_active', true) ? 'checked' : '' }}
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
                                <i class="fas fa-check me-2"></i>Simpan
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Help Sidebar -->
                <div class="col-lg-4">
                    <div class="sticky-top" style="top: 1rem;">
                        <!-- Panduan -->
                        <div class="card border-0 shadow-sm help-card mb-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3">
                                    <i class="fas fa-question-circle text-primary me-2"></i>
                                    Panduan Pengisian
                                </h6>
                                
                                <div class="d-flex gap-3 mb-3">
                                    <div class="step-number">1</div>
                                    <div class="flex-grow-1">
                                        <p class="fw-semibold mb-1 small">Isi Informasi Dasar</p>
                                        <p class="text-muted small mb-0">Nama lengkap, jabatan, dan NIP/NIDN</p>
                                    </div>
                                </div>

                                <div class="d-flex gap-3 mb-3">
                                    <div class="step-number">2</div>
                                    <div class="flex-grow-1">
                                        <p class="fw-semibold mb-1 small">Pilih Hierarki</p>
                                        <p class="text-muted small mb-0">Tentukan atasan langsung dan tipe jabatan</p>
                                    </div>
                                </div>

                                <div class="d-flex gap-3 mb-3">
                                    <div class="step-number">3</div>
                                    <div class="flex-grow-1">
                                        <p class="fw-semibold mb-1 small">Tambah Kontak</p>
                                        <p class="text-muted small mb-0">Email dan nomor telepon (opsional)</p>
                                    </div>
                                </div>

                                <div class="d-flex gap-3 mb-3">
                                    <div class="step-number">4</div>
                                    <div class="flex-grow-1">
                                        <p class="fw-semibold mb-1 small">Upload Foto</p>
                                        <p class="text-muted small mb-0">Foto profil untuk ditampilkan</p>
                                    </div>
                                </div>

                                <div class="d-flex gap-3">
                                    <div class="step-number">5</div>
                                    <div class="flex-grow-1">
                                        <p class="fw-semibold mb-1 small">Simpan Data</p>
                                        <p class="text-muted small mb-0">Klik tombol Simpan untuk menyimpan</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Tips -->
                        <div class="card border-0 shadow-sm bg-info bg-opacity-10 border-start border-info border-4">
                            <div class="card-body p-4">
                                <h6 class="fw-bold mb-3 text-info">
                                    <i class="fas fa-lightbulb me-2"></i>Tips
                                </h6>
                                <ul class="small mb-0 ps-3">
                                    <li class="mb-2">Gunakan foto dengan latar belakang polos</li>
                                    <li class="mb-2">Pastikan hierarki sudah benar sebelum menyimpan</li>
                                    <li class="mb-2">Field bertanda (*) wajib diisi</li>
                                    <li class="mb-0">Email bisa digunakan untuk login sistem</li>
                                </ul>
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