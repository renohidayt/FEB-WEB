@extends('admin.layouts.app')

@section('title', 'Tambah Fasilitas')

@section('content')
<div class="px-3 py-3">
    
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Tambah Fasilitas Baru</h1>
            <p class="text-muted small mb-0">Lengkapi data fasilitas kampus.</p>
        </div>
        <a href="{{ route('admin.facilities.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        {{-- KOLOM KIRI: FORM --}}
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-building me-2"></i>Formulir Data Fasilitas</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.facilities.store') }}" method="POST" enctype="multipart/form-data" id="facilityForm">
                        @csrf

                        {{-- 1. INFORMASI DASAR --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-info-circle me-2"></i>Informasi Dasar
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Nama Fasilitas --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Nama Fasilitas <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="name" 
                                           value="{{ old('name') }}"
                                           class="form-control @error('name') is-invalid @enderror"
                                           placeholder="Contoh: Lab Komputer 1"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Kategori --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Kategori <span class="text-danger">*</span></label>
                                    <select name="category" class="form-select @error('category') is-invalid @enderror" required>
                                        <option value="">Pilih Kategori</option>
                                        @foreach(App\Models\Facility::categories() as $key => $label)
                                            <option value="{{ $key }}" {{ old('category') == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('category')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Kapasitas --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Kapasitas</label>
                                    <input type="text" 
                                           name="capacity" 
                                           value="{{ old('capacity') }}"
                                           class="form-control @error('capacity') is-invalid @enderror"
                                           placeholder="Contoh: 40 orang">
                                    @error('capacity')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Deskripsi --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Deskripsi</label>
                                    <textarea name="description" 
                                              rows="4" 
                                              class="form-control @error('description') is-invalid @enderror"
                                              placeholder="Deskripsi lengkap fasilitas...">{{ old('description') }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 2. UPLOAD FOTO --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-images me-2"></i>Foto Fasilitas
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Upload Foto (Multiple)</label>
                                    <div class="border border-2 border-dashed rounded p-4 text-center bg-light">
                                        <input type="file" name="photos[]" id="photoInput" accept="image/*" multiple class="d-none">
                                        <label for="photoInput" class="cursor-pointer mb-0" style="cursor: pointer;">
                                            <i class="fas fa-cloud-upload-alt text-primary mb-2" style="font-size: 2.5rem;"></i>
                                            <p class="mb-1">
                                                <span class="text-primary fw-semibold">Klik untuk upload</span>
                                                <span class="text-muted"> atau drag & drop</span>
                                            </p>
                                            <p class="small text-muted mb-2">JPG, PNG (Max: 20MB per file)</p>
                                            <p class="small text-info mb-0">
                                                <i class="fas fa-info-circle me-1"></i>
                                                Bisa pilih banyak foto sekaligus (Ctrl/Cmd + klik)
                                            </p>
                                        </label>
                                    </div>
                                    <p id="fileCount" class="text-success fw-semibold mt-2 d-none mb-0"></p>
                                    
                                    {{-- Preview Grid --}}
                                    <div id="imagePreview" class="row row-cols-2 row-cols-md-3 g-2 mt-2"></div>
                                </div>
                            </div>
                        </div>

                        {{-- 3. STATUS --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-cog me-2"></i>Pengaturan Status
                            </h6>
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" 
                                               type="checkbox" 
                                               id="is_active" 
                                               name="is_active" 
                                               value="1"
                                               {{ old('is_active', true) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="is_active">Aktifkan fasilitas ini</label>
                                        <small class="d-block text-muted">Fasilitas yang aktif akan ditampilkan di website.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.facilities.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-save me-1"></i> Simpan Fasilitas
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: PETUNJUK --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-left-primary" style="position: sticky; top: 100px;">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="m-0 fw-bold"><i class="fas fa-info-circle me-2"></i>Petunjuk Pengisian</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info border-0 bg-info-subtle text-info-emphasis mb-3" role="alert">
                        <small><strong>Tips:</strong> Field yang bertanda <span class="text-danger">*</span> wajib diisi.</small>
                    </div>

                    <div class="space-y-3">
                        {{-- Guide 1 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-primary fw-bold mb-2 small">
                                <i class="fas fa-tag text-primary me-2"></i> Kategori Fasilitas
                            </h6>
                            <p class="text-muted small mb-0">
                                Pilih kategori yang sesuai:<br>
                                • <strong>Ruang Kelas:</strong> Ruang perkuliahan<br>
                                • <strong>Laboratorium:</strong> Lab komputer, bahasa, dll<br>
                                • <strong>Perpustakaan:</strong> Fasilitas membaca<br>
                                • <strong>Olahraga:</strong> Lapangan, gym<br>
                                • <strong>Lainnya:</strong> Fasilitas umum
                            </p>
                        </div>

                        {{-- Guide 2 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-success fw-bold mb-2 small">
                                <i class="fas fa-users text-success me-2"></i> Kapasitas
                            </h6>
                            <p class="text-muted small mb-0">
                                Tuliskan kapasitas fasilitas. Contoh:<br>
                                • "40 orang" untuk ruang kelas<br>
                                • "30 komputer" untuk lab<br>
                                • "50 kursi" untuk perpustakaan<br>
                                Kosongkan jika tidak relevan
                            </p>
                        </div>

                        {{-- Guide 3 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-warning fw-bold mb-2 small">
                                <i class="fas fa-images text-warning me-2"></i> Upload Foto
                            </h6>
                            <p class="text-muted small mb-0">
                                • Format: JPG atau PNG<br>
                                • Ukuran: Max 20MB per file<br>
                                • <strong>Multiple upload:</strong> Pilih banyak foto sekaligus<br>
                                • Foto pertama akan jadi thumbnail<br>
                                • Bisa hapus foto sebelum upload
                            </p>
                        </div>

                        {{-- Guide 4 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-info fw-bold mb-2 small">
                                <i class="fas fa-lightbulb text-info me-2"></i> Tips Foto
                            </h6>
                            <p class="text-muted small mb-0">
                                • Ambil dari berbagai sudut<br>
                                • Pastikan pencahayaan baik<br>
                                • Tampilkan fitur utama<br>
                                • Foto landscape lebih baik<br>
                                • Min 3 foto recommended
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT UNTUK MULTIPLE PHOTO UPLOAD --}}
<script>
let selectedFiles = [];

document.getElementById('photoInput').addEventListener('change', function(e) {
    Array.from(e.target.files).forEach(file => {
        // Check duplicate
        const isDuplicate = selectedFiles.some(f => f.name === file.name && f.size === file.size);
        if (!isDuplicate) {
            // Check file size (20MB max)
            if (file.size > 20 * 1024 * 1024) {
                alert(`File ${file.name} terlalu besar! Maksimal 20MB per file`);
                return;
            }
            selectedFiles.push(file);
        }
    });
    
    updatePreview();
    e.target.value = ''; // Reset input untuk bisa pilih file lagi
});

function updatePreview() {
    const preview = document.getElementById('imagePreview');
    const counter = document.getElementById('fileCount');
    
    preview.innerHTML = '';
    
    if (selectedFiles.length > 0) {
        counter.textContent = `✓ ${selectedFiles.length} foto dipilih`;
        counter.classList.remove('d-none');
    } else {
        counter.classList.add('d-none');
    }
    
    selectedFiles.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const div = document.createElement('div');
            div.className = 'col';
            div.innerHTML = `
                <div class="position-relative">
                    <img src="${e.target.result}" class="w-100 rounded border" style="height: 100px; object-fit: cover;">
                    <span class="position-absolute top-0 start-0 m-1 badge bg-primary" style="font-size: 0.65rem;">${index + 1}</span>
                    <button type="button" onclick="removePhoto(${index})" 
                            class="position-absolute top-0 end-0 m-1 btn btn-sm btn-danger rounded-circle p-0"
                            style="width: 24px; height: 24px; font-size: 0.7rem;">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="small text-muted mt-1" style="font-size: 0.7rem;">${(file.size/1024/1024).toFixed(2)} MB</div>
                </div>
            `;
            preview.appendChild(div);
        };
        reader.readAsDataURL(file);
    });
}

function removePhoto(index) {
    selectedFiles.splice(index, 1);
    updatePreview();
}

// Submit form with selected files
document.getElementById('facilityForm').addEventListener('submit', function(e) {
    const oldInput = document.getElementById('photoInput');
    if (oldInput) oldInput.remove();
    
    // Add each file as separate input
    selectedFiles.forEach(file => {
        const dt = new DataTransfer();
        dt.items.add(file);
        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'photos[]';
        input.files = dt.files;
        input.style.display = 'none';
        this.appendChild(input);
    });
});
</script>
@endsection