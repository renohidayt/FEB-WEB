@extends('admin.layouts.app')

@section('title', 'Edit Fasilitas')

@section('content')
<div class="px-3 py-3">
    
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Edit Fasilitas</h1>
            <p class="text-muted small mb-0">Update data fasilitas: <strong>{{ $facility->name }}</strong></p>
        </div>
        <a href="{{ route('admin.facilities.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row">
        {{-- KOLOM KIRI: FORM --}}
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-building me-2"></i>Formulir Edit Fasilitas</h6>
                </div>
                <div class="card-body">
                    
                    {{-- 
                       PERBAIKAN: Form Utama dimulai di sini.
                       Tidak ada tag <form> lain di dalam area ini sampai tag penutup </form> di bawah.
                    --}}
                    <form action="{{ route('admin.facilities.update', $facility) }}" method="POST" enctype="multipart/form-data" id="facilityForm">
                        @csrf
                        @method('PUT')

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
                                           value="{{ old('name', $facility->name) }}"
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
                                            <option value="{{ $key }}" {{ old('category', $facility->category) == $key ? 'selected' : '' }}>
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
                                           value="{{ old('capacity', $facility->capacity) }}"
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
                                              placeholder="Deskripsi lengkap fasilitas...">{{ old('description', $facility->description) }}</textarea>
                                    @error('description')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 2. FOTO SAAT INI --}}
                        @if($facility->photos->count() > 0)
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-images me-2"></i>Foto Saat Ini ({{ $facility->photos->count() }})
                            </h6>
                            
                            <div class="row row-cols-2 row-cols-md-3 g-2">
                                @foreach($facility->photos as $photo)
                                <div class="col">
                                    <div class="position-relative">
                                        <img src="{{ asset('storage/' . $photo->photo) }}" 
                                             class="w-100 rounded border" 
                                             style="height: 100px; object-fit: cover;">
                                        
                                        {{-- 
                                            PERBAIKAN: Tombol Hapus ini BUKAN FORM.
                                            Hanya tombol biasa yang memanggil Javascript 'deletePhoto'.
                                        --}}
                                        <button type="button" 
                                                onclick="deletePhoto('{{ $photo->id }}')"
                                                class="position-absolute top-0 end-0 m-1 btn btn-sm btn-danger rounded-circle p-0"
                                                style="width: 24px; height: 24px; font-size: 0.7rem;"
                                                title="Hapus foto ini">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif

                        {{-- 3. TAMBAH FOTO BARU --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-plus-circle me-2"></i>Tambah Foto Baru
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Upload Foto Tambahan (Multiple)</label>
                                    <div class="border border-2 border-dashed rounded p-3 text-center bg-light">
                                        <input type="file" name="photos[]" id="photoInput" accept="image/*" multiple class="d-none">
                                        <label for="photoInput" class="cursor-pointer mb-0" style="cursor: pointer;">
                                            <i class="fas fa-cloud-upload-alt text-primary mb-2" style="font-size: 2rem;"></i>
                                            <p class="mb-1 small">
                                                <span class="text-primary fw-semibold">Klik untuk upload</span>
                                            </p>
                                            <p class="small text-muted mb-0">JPG, PNG (Max: 20MB per file)</p>
                                        </label>
                                    </div>
                                    <p id="fileCount" class="text-success fw-semibold mt-2 d-none mb-0 small"></p>
                                    
                                    {{-- Preview Grid --}}
                                    <div id="imagePreview" class="row row-cols-2 row-cols-md-3 g-2 mt-2"></div>
                                </div>
                            </div>
                        </div>

                        {{-- 4. STATUS --}}
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
                                               {{ old('is_active', $facility->is_active) ? 'checked' : '' }}>
                                        <label class="form-check-label fw-bold" for="is_active">Aktifkan fasilitas ini</label>
                                        <small class="d-block text-muted">Fasilitas yang aktif akan ditampilkan di website.</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- BUTTONS (Sekarang aman karena berada di dalam form utama) --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.facilities.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-save me-1"></i> Update Fasilitas
                            </button>
                        </div>

                    </form> {{-- END FORM UTAMA --}}
                </div>
            </div>
        </div>

               {{-- KOLOM KANAN: PETUNJUK --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-left-primary" style="position: sticky; top: 100px;">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="m-0 fw-bold"><i class="fas fa-info-circle me-2"></i>Petunjuk Edit</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning border-0 bg-warning-subtle text-warning-emphasis mb-3" role="alert">
                        <small><strong>Perhatian:</strong> Pastikan data yang diubah sudah benar sebelum menyimpan.</small>
                    </div>

                    <div class="space-y-3">
                        {{-- Info Current Data --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-info fw-bold mb-2 small">
                                <i class="fas fa-info-circle text-info me-2"></i> Data Saat Ini
                            </h6>
                            <p class="text-muted small mb-1">
                                <strong>Kategori:</strong> {{ $facility->category ?? '-' }}
                            </p>
                            <p class="text-muted small mb-1">
                                <strong>Kapasitas:</strong> {{ $facility->capacity ?? '-' }}
                            </p>
                            <p class="text-muted small mb-1">
                                <strong>Total Foto:</strong> {{ $facility->photos->count() }} foto
                            </p>
                            <p class="text-muted small mb-0">
                                <strong>Status:</strong> 
                                <span class="badge {{ $facility->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $facility->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </p>
                        </div>

                        {{-- Guide 1 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-primary fw-bold mb-2 small">
                                <i class="fas fa-edit text-primary me-2"></i> Edit Data
                            </h6>
                            <p class="text-muted small mb-0">
                                Ubah nama, kategori, kapasitas, atau deskripsi sesuai kebutuhan. Pastikan data akurat.
                            </p>
                        </div>

                        {{-- Guide 2 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-success fw-bold mb-2 small">
                                <i class="fas fa-trash text-success me-2"></i> Hapus Foto Lama
                            </h6>
                            <p class="text-muted small mb-0">
                                Klik tombol <i class="fas fa-trash small"></i> di foto yang ingin dihapus. Foto akan langsung terhapus.
                            </p>
                        </div>

                        {{-- Guide 3 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-warning fw-bold mb-2 small">
                                <i class="fas fa-plus-circle text-warning me-2"></i> Tambah Foto Baru
                            </h6>
                            <p class="text-muted small mb-0">
                                Upload foto tambahan tanpa menghapus foto lama. Foto baru akan ditambahkan ke koleksi existing.
                            </p>
                        </div>

                        {{-- Guide 4 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-danger fw-bold mb-2 small">
                                <i class="fas fa-exclamation-triangle text-danger me-2"></i> Penting
                            </h6>
                            <p class="text-muted small mb-0">
                                • Foto lama tetap tersimpan<br>
                                • Foto baru ditambahkan, bukan replace<br>
                                • Hapus foto lama secara manual jika perlu<br>
                                • Status aktif untuk tampil di website
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- 
   BAGIAN PENTING: FORM HAPUS TERSEMBUNYI 
   Ini diletakkan DI LUAR form utama, jadi tidak akan bentrok.
--}}
@foreach($facility->photos as $photo)
    <form id="delete-form-{{ $photo->id }}" 
          action="{{ route('admin.facilities.photos.delete', $photo) }}" 
          method="POST" 
          class="d-none">
        @csrf
        @method('DELETE')
    </form>
@endforeach

{{-- SCRIPT JAVASCRIPT --}}
<script>
    // 1. Fungsi untuk Hapus Foto Lama
    function deletePhoto(id) {
        if (confirm('Apakah Anda yakin ingin menghapus foto ini secara permanen?')) {
            // Cari form tersembunyi berdasarkan ID dan submit
            document.getElementById('delete-form-' + id).submit();
        }
    }

    // 2. Logic Upload Multiple Foto (Sama seperti kode Anda sebelumnya)
    let selectedFiles = [];

    document.getElementById('photoInput').addEventListener('change', function(e) {
        Array.from(e.target.files).forEach(file => {
            const isDuplicate = selectedFiles.some(f => f.name === file.name && f.size === file.size);
            if (!isDuplicate) {
                if (file.size > 20 * 1024 * 1024) {
                    alert(`File ${file.name} terlalu besar! Maksimal 20MB per file`);
                    return;
                }
                selectedFiles.push(file);
            }
        });
        
        updatePreview();
        e.target.value = '';
    });

    function updatePreview() {
        const preview = document.getElementById('imagePreview');
        const counter = document.getElementById('fileCount');
        
        preview.innerHTML = '';
        
        if (selectedFiles.length > 0) {
            counter.textContent = `✓ ${selectedFiles.length} foto baru akan ditambahkan`;
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
                        <img src="${e.target.result}" class="w-100 rounded border border-2 border-success" 
                             style="height: 100px; object-fit: cover;">
                        <span class="position-absolute top-0 start-0 m-1 badge bg-success" style="font-size: 0.65rem;">Baru ${index + 1}</span>
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

    document.getElementById('facilityForm').addEventListener('submit', function(e) {
        // Hapus input file asli agar tidak bentrok dengan DataTransfer yang kita buat
        const oldInput = document.getElementById('photoInput');
        if (oldInput) oldInput.remove();
        
        // Masukkan file dari array selectedFiles ke dalam form
        const dt = new DataTransfer();
        selectedFiles.forEach(file => dt.items.add(file));
        
        const input = document.createElement('input');
        input.type = 'file';
        input.name = 'photos[]';
        input.multiple = true;
        input.files = dt.files;
        input.style.display = 'none';
        this.appendChild(input);
    });
</script>
@endsection