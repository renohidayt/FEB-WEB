@extends('admin.layouts.app')

@section('title', 'Edit Hero Slider')

@section('content')
<div class="px-3 py-3">
    
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Edit Hero Slider</h1>
            <p class="text-muted small mb-0">Update slider banner: <strong>{{ $heroSlider->title }}</strong></p>
        </div>
        <a href="{{ route('admin.hero-sliders.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        {{-- KOLOM KIRI: FORM --}}
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-edit me-2"></i>Formulir Edit Slider</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.hero-sliders.update', $heroSlider) }}" method="POST" enctype="multipart/form-data" id="sliderForm">
                        @csrf
                        @method('PUT')

                        {{-- INFO ALERT --}}
                        <div class="alert alert-info border-0 mb-4" role="alert">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-info-circle me-2 mt-1"></i>
                                <div>
                                    <strong>Mode Edit:</strong> Upload media baru hanya jika ingin mengganti background yang ada.
                                </div>
                            </div>
                        </div>

                        {{-- 1. INFORMASI SLIDER --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-heading me-2"></i>Informasi Slider
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Judul Utama --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Judul Utama <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="title" 
                                           value="{{ old('title', $heroSlider->title) }}"
                                           class="form-control @error('title') is-invalid @enderror"
                                           placeholder="UNIVERSITAS SEBELAS APRIL"
                                           required>
                                    @error('title')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">💡 Gunakan huruf kapital untuk tampilan yang lebih bold</small>
                                </div>

                                {{-- Subtitle --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Subtitle <span class="text-muted">(Opsional)</span></label>
                                    <textarea name="subtitle" 
                                              rows="2"
                                              class="form-control @error('subtitle') is-invalid @enderror"
                                              placeholder="FAKULTAS EKONOMI DAN BISNIS">{{ old('subtitle', $heroSlider->subtitle) }}</textarea>
                                    @error('subtitle')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Subtitle akan muncul di bawah judul utama</small>
                                </div>

                                {{-- Tagline --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Tagline <span class="text-muted">(Opsional)</span></label>
                                    <input type="text" 
                                           name="tagline" 
                                           value="{{ old('tagline', $heroSlider->tagline) }}"
                                           class="form-control @error('tagline') is-invalid @enderror"
                                           placeholder="Shaping Future Leaders in Business & Economics">
                                    @error('tagline')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    <small class="text-muted">Tagline muncul di bawah subtitle dengan font lebih kecil</small>
                                </div>
                            </div>
                        </div>

                        {{-- 2. TOMBOL CTA --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-mouse-pointer me-2"></i>Tombol Call-to-Action (Opsional)
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Button Text --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Teks Tombol</label>
                                    <input type="text" 
                                           name="button_text" 
                                           value="{{ old('button_text', $heroSlider->button_text) }}"
                                           class="form-control"
                                           placeholder="Contoh: Selengkapnya, Daftar Sekarang">
                                    <small class="text-muted">Kosongkan jika tidak ingin menampilkan tombol</small>
                                </div>

                                {{-- Button Link --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Link Tombol</label>
                                    <input type="text" 
                                           name="button_link" 
                                           value="{{ old('button_link', $heroSlider->button_link) }}"
                                           class="form-control"
                                           placeholder="https://usa.ac.id/pendaftaran">
                                    <small class="text-muted">URL lengkap atau gunakan # untuk link dummy</small>
                                </div>
                            </div>
                        </div>

                        {{-- 3. BACKGROUND SAAT INI --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-photo-video me-2"></i>Background Saat Ini
                            </h6>
                            
                            @if($heroSlider->media_type === 'image' && $heroSlider->media_path)
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <img src="{{ asset('storage/' . $heroSlider->media_path) }}" 
                                                     alt="Current background" 
                                                     class="rounded shadow"
                                                     style="width: 200px; height: 120px; object-fit: cover;">
                                            </div>
                                            <div class="col">
                                                <span class="badge bg-primary mb-2">Gambar</span>
                                                <p class="small text-muted mb-0">Upload gambar baru di bawah untuk mengganti background ini</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @elseif($heroSlider->media_type === 'video')
                                <div class="card bg-light border-0">
                                    <div class="card-body">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <div class="bg-gradient-danger rounded shadow d-flex align-items-center justify-content-center"
                                                     style="width: 200px; height: 120px;">
                                                    <div class="text-center">
                                                        <i class="fas fa-video text-white mb-2" style="font-size: 2.5rem;"></i>
                                                        <p class="text-white fw-bold small mb-0">Video Embed</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col">
                                                <span class="badge bg-danger mb-2">{{ ucfirst($heroSlider->video_platform ?? 'custom') }} Embed</span>
                                                <p class="small text-muted mb-0 text-break">{{ $heroSlider->video_embed }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>

                        {{-- 4. GANTI BACKGROUND --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-sync me-2"></i>Ganti Background (Opsional)
                            </h6>
                            
                            {{-- Media Type Selection --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Ganti Tipe Background</label>
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="media_type" id="typeImage" value="image" 
                                               {{ old('media_type', $heroSlider->media_type) === 'image' ? 'checked' : '' }}
                                               onchange="toggleMediaInput()">
                                        <label class="form-check-label" for="typeImage">
                                            <i class="fas fa-image text-primary me-1"></i> Gambar Background
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="media_type" id="typeVideo" value="video" 
                                               {{ old('media_type', $heroSlider->media_type) === 'video' ? 'checked' : '' }}
                                               onchange="toggleMediaInput()">
                                        <label class="form-check-label" for="typeVideo">
                                            <i class="fas fa-video text-danger me-1"></i> Video Background (Embed)
                                        </label>
                                    </div>
                                </div>
                                <small class="text-muted">💡 Upload file baru hanya jika ingin mengganti. Kosongkan untuk tetap pakai yang ada.</small>
                            </div>

                            {{-- IMAGE UPLOAD --}}
                            <div id="imageUpload" style="display: {{ old('media_type', $heroSlider->media_type) === 'image' ? 'block' : 'none' }};">
                                <label class="form-label fw-bold small">Upload Gambar Baru <span class="text-muted">(Opsional)</span></label>
                                <input type="file" 
                                       name="media_path" 
                                       id="imageFile"
                                       accept="image/jpeg,image/jpg,image/png"
                                       class="form-control @error('media_path') is-invalid @enderror"
                                       onchange="previewImage(this)">
                                @error('media_path')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Kosongkan jika tidak ingin mengganti gambar</small>
                                
                                <div class="alert alert-info mt-2 mb-0" role="alert">
                                    <p class="small mb-1"><strong>📋 Spesifikasi Gambar:</strong></p>
                                    <ul class="small mb-0">
                                        <li><strong>Format:</strong> JPG, PNG</li>
                                        <li><strong>Resolusi Optimal:</strong> 1920x1080px (Full HD)</li>
                                        <li><strong>Ukuran Maksimal:</strong> 5MB</li>
                                        <li><strong>Rasio Aspek:</strong> 16:9 untuk tampilan terbaik</li>
                                    </ul>
                                </div>
                                
                                <div id="imagePreview" class="mt-3 d-none">
                                    <p class="fw-bold small mb-2">Preview Gambar Baru:</p>
                                    <img id="preview" class="img-fluid rounded border border-success border-2" style="max-width: 100%; max-height: 300px;">
                                </div>
                            </div>

                            {{-- VIDEO EMBED --}}
                            <div id="videoEmbed" style="display: {{ old('media_type', $heroSlider->media_type) === 'video' ? 'block' : 'none' }};">
                                <div class="alert alert-info mb-3" role="alert">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-info-circle me-2 mt-1"></i>
                                        <div>
                                            <strong>💡 Update Video Embed (Opsional)</strong>
                                            <p class="small mb-0 mt-1">Kosongkan field di bawah jika ingin tetap menggunakan video embed yang sudah ada.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Platform Video</label>
                                    <select name="video_platform" class="form-select @error('video_platform') is-invalid @enderror">
                                        <option value="youtube" {{ old('video_platform', $heroSlider->video_platform) === 'youtube' ? 'selected' : '' }}>🎬 YouTube (Recommended)</option>
                                        <option value="vimeo" {{ old('video_platform', $heroSlider->video_platform) === 'vimeo' ? 'selected' : '' }}>📹 Vimeo</option>
                                        <option value="wistia" {{ old('video_platform', $heroSlider->video_platform) === 'wistia' ? 'selected' : '' }}>🎞️ Wistia</option>
                                        <option value="custom" {{ old('video_platform', $heroSlider->video_platform) === 'custom' ? 'selected' : '' }}>🔗 Custom URL</option>
                                    </select>
                                    @error('video_platform')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">URL Video</label>
                                    <input type="url" 
                                           name="video_embed" 
                                           value="{{ old('video_embed', $heroSlider->video_embed) }}"
                                           class="form-control @error('video_embed') is-invalid @enderror"
                                           placeholder="https://www.youtube.com/watch?v=VIDEO_ID">
                                    @error('video_embed')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                    
                                    <div class="alert alert-light mt-2 mb-0" role="alert">
                                        <p class="small mb-1"><strong>📝 Cara Mendapatkan URL:</strong></p>
                                        <ul class="small mb-0" style="font-size: 0.75rem;">
                                            <li><strong>YouTube:</strong> Salin URL dari address bar<br>
                                                <span class="text-muted">Contoh: https://www.youtube.com/watch?v=dQw4w9WgXcQ</span>
                                            </li>
                                            <li><strong>Vimeo:</strong> Salin URL dari address bar<br>
                                                <span class="text-muted">Contoh: https://vimeo.com/123456789</span>
                                            </li>
                                            <li><strong>Wistia:</strong> Salin URL atau video ID<br>
                                                <span class="text-muted">Contoh: https://home.wistia.com/medias/abc123xyz</span>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="alert alert-warning mb-0" role="alert">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-exclamation-triangle me-2 mt-1"></i>
                                        <div class="small">
                                            <strong>⚠️ Catatan:</strong> Gunakan YouTube, Vimeo, atau Wistia untuk hasil terbaik. Instagram dan TikTok tidak mendukung autoplay embed.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 5. PENGATURAN --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-cog me-2"></i>Pengaturan Tampilan
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Order --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Urutan Tampil</label>
                                    <input type="number" 
                                           name="order" 
                                           value="{{ old('order', $heroSlider->order) }}"
                                           min="0"
                                           class="form-control">
                                    <small class="text-muted">💡 Angka 0 = paling awal. Bisa diatur dengan drag & drop.</small>
                                </div>

                                {{-- Status --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Status Publikasi</label>
                                    <div class="card bg-light border-0 mt-2">
                                        <div class="card-body p-3">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       id="is_active" 
                                                       name="is_active" 
                                                       value="1"
                                                       {{ old('is_active', $heroSlider->is_active) ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="is_active">Aktif</label>
                                                <small class="d-block text-muted">Tampilkan slider ini di homepage</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                            <a href="{{ route('admin.hero-sliders.index') }}" class="btn btn-secondary btn-sm">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-save me-1"></i> Update Slider
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: INFORMASI --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-left-primary" style="position: sticky; top: 100px;">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="m-0 fw-bold"><i class="fas fa-info-circle me-2"></i>Informasi Slider</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning border-0 bg-warning-subtle text-warning-emphasis mb-3" role="alert">
                        <small><strong>Perhatian:</strong> Pastikan data yang diubah sudah benar.</small>
                    </div>

                    <div class="space-y-3">
                        {{-- Current Info --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-info fw-bold mb-2 small">
                                <i class="fas fa-database text-info me-2"></i> Data Saat Ini
                            </h6>
                            <p class="text-muted small mb-1">
                                <strong>Tipe Media:</strong> 
                                <span class="badge {{ $heroSlider->media_type === 'image' ? 'bg-primary' : 'bg-danger' }}">
                                    {{ $heroSlider->media_type === 'image' ? 'Gambar' : 'Video' }}
                                </span>
                            </p>
                            <p class="text-muted small mb-1">
                                <strong>Status:</strong> 
                                <span class="badge {{ $heroSlider->is_active ? 'bg-success' : 'bg-secondary' }}">
                                    {{ $heroSlider->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                            </p>
                            <p class="text-muted small mb-1">
                                <strong>Urutan:</strong> {{ $heroSlider->order }}
                            </p>
                            <p class="text-muted small mb-0">
                                <strong>Update:</strong> {{ $heroSlider->updated_at->diffForHumans() }}
                            </p>
                        </div>

                        {{-- Guide 1 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-primary fw-bold mb-2 small">
                                <i class="fas fa-edit text-primary me-2"></i> Edit Informasi
                            </h6>
                            <p class="text-muted small mb-0">
                                Anda dapat mengubah:<br>
                                • Judul, subtitle, tagline<br>
                                • Tombol CTA<br>
                                • Background media (optional)<br>
                                • Urutan & status
                            </p>
                        </div>

                        {{-- Guide 2 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-success fw-bold mb-2 small">
                                <i class="fas fa-photo-video text-success me-2"></i> Ganti Media
                            </h6>
                            <p class="text-muted small mb-0">
                                • Kosongkan jika tidak ingin ganti<br>
                                • Upload baru = replace otomatis<br>
                                • Bisa ganti tipe (image ↔ video)<br>
                                • Media lama akan terhapus
                            </p>
                        </div>

                        {{-- Guide 3 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-danger fw-bold mb-2 small">
                                <i class="fas fa-exclamation-triangle text-danger me-2"></i> Penting!
                            </h6>
                            <p class="text-muted small mb-0">
                                • File baru replace yang lama<br>
                                • Video embed bisa diupdate<br>
                                • Urutan bisa drag & drop<br>
                                • Perubahan langsung tersimpan<br>
                                • Test setelah update
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
function toggleMediaInput() {
    const mediaType = document.querySelector('input[name="media_type"]:checked').value;
    const imageUpload = document.getElementById('imageUpload');
    const videoEmbed = document.getElementById('videoEmbed');
    
    if (mediaType === 'image') {
        imageUpload.style.display = 'block';
        videoEmbed.style.display = 'none';
    } else {
        imageUpload.style.display = 'none';
        videoEmbed.style.display = 'block';
    }
}

function previewImage(input) {
    if (input.files && input.files[0]) {
        const file = input.files[0];
        
        // Validate size (5MB)
        if (file.size > 5 * 1024 * 1024) {
            alert('Ukuran file terlalu besar! Maksimal 5MB.');
            input.value = '';
            return;
        }
        
        // Validate type
        if (!file.type.startsWith('image/')) {
            alert('File harus berupa gambar (JPG, PNG)');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('d-none');
        }
        reader.readAsDataURL(file);
    }
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', function() {
    toggleMediaInput();
});
</script>

<style>
.border-left-primary { border-left: 4px solid #0d6efd !important; }
.bg-gradient-danger {
    background: linear-gradient(135deg, #dc3545 0%, #fd7e14 100%);
}
</style>
@endsection