@extends('admin.layouts.app')

@section('title', 'Tambah Hero Slider')

@section('content')
<div class="px-3 py-3">
    
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Tambah Hero Slider Baru</h1>
            <p class="text-muted small mb-0">Buat slider banner baru untuk homepage.</p>
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
                    <h6 class="m-0 fw-bold text-primary"><i class="fas fa-image me-2"></i>Formulir Hero Slider</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.hero-sliders.store') }}" method="POST" enctype="multipart/form-data" id="sliderForm">
                        @csrf

                        {{-- INFO ALERT --}}
                        <div class="alert alert-success border-0 mb-4" role="alert">
                            <div class="d-flex align-items-start">
                                <i class="fas fa-check-circle me-2 mt-1"></i>
                                <div>
                                    <strong>Mode Tambah:</strong> Background dapat berupa gambar atau video embed dari YouTube/Vimeo/Wistia.
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
                                           value="{{ old('title') }}"
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
                                              placeholder="FAKULTAS EKONOMI DAN BISNIS">{{ old('subtitle') }}</textarea>
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
                                           value="{{ old('tagline') }}"
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
                                           value="{{ old('button_text') }}"
                                           class="form-control"
                                           placeholder="Contoh: Selengkapnya, Daftar Sekarang">
                                    <small class="text-muted">Kosongkan jika tidak ingin menampilkan tombol</small>
                                </div>

                                {{-- Button Link --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Link Tombol</label>
                                    <input type="text" 
                                           name="button_link" 
                                           value="{{ old('button_link') }}"
                                           class="form-control"
                                           placeholder="https://usa.ac.id/pendaftaran">
                                    <small class="text-muted">URL lengkap atau gunakan # untuk link dummy</small>
                                </div>
                            </div>
                        </div>

                        {{-- 3. BACKGROUND MEDIA --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs fw-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-photo-video me-2"></i>Background Media
                            </h6>
                            
                            {{-- Media Type Selection --}}
                            <div class="mb-3">
                                <label class="form-label fw-bold small">Pilih Tipe Background <span class="text-danger">*</span></label>
                                <div class="d-flex gap-4">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="media_type" id="typeImage" value="image" 
                                               {{ old('media_type', 'image') === 'image' ? 'checked' : '' }}
                                               onchange="toggleMediaInput()">
                                        <label class="form-check-label" for="typeImage">
                                            <i class="fas fa-image text-primary me-1"></i> Gambar Background
                                        </label>
                                    </div>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="media_type" id="typeVideo" value="video" 
                                               {{ old('media_type') === 'video' ? 'checked' : '' }}
                                               onchange="toggleMediaInput()">
                                        <label class="form-check-label" for="typeVideo">
                                            <i class="fas fa-video text-danger me-1"></i> Video Background (Embed)
                                        </label>
                                    </div>
                                </div>
                                <small class="text-muted">Pilih gambar untuk background statis atau video embed untuk background bergerak</small>
                            </div>

                            {{-- IMAGE UPLOAD --}}
                            <div id="imageUpload" style="display: {{ old('media_type', 'image') === 'image' ? 'block' : 'none' }};">
                                <label class="form-label fw-bold small">Upload Gambar <span class="text-danger">*</span></label>
                                <input type="file" 
                                       name="media_path" 
                                       id="imageFile"
                                       accept="image/jpeg,image/jpg,image/png"
                                       class="form-control @error('media_path') is-invalid @enderror"
                                       onchange="previewImage(this)">
                                @error('media_path')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                
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
                                    <p class="fw-bold small mb-2">Preview Gambar:</p>
                                    <img id="preview" class="img-fluid rounded border" style="max-width: 100%; max-height: 300px;">
                                </div>
                            </div>

                            {{-- VIDEO EMBED --}}
                            <div id="videoEmbed" style="display: {{ old('media_type') === 'video' ? 'block' : 'none' }};">
                                <div class="alert alert-primary mb-3" role="alert">
                                    <div class="d-flex align-items-start">
                                        <i class="fas fa-video me-2 mt-1"></i>
                                        <div>
                                            <strong>🎥 Video Background dari Platform Eksternal</strong>
                                            <p class="small mb-0 mt-1">Gunakan video dari YouTube, Vimeo, atau Wistia untuk background yang dinamis.</p>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold small">Platform Video <span class="text-danger">*</span></label>
                                    <select name="video_platform" class="form-select @error('video_platform') is-invalid @enderror">
                                        <option value="">-- Pilih Platform --</option>
                                        <option value="youtube" {{ old('video_platform') === 'youtube' ? 'selected' : '' }}>🎬 YouTube (Recommended)</option>
                                        <option value="vimeo" {{ old('video_platform') === 'vimeo' ? 'selected' : '' }}>📹 Vimeo</option>
                                        <option value="wistia" {{ old('video_platform') === 'wistia' ? 'selected' : '' }}>🎞️ Wistia</option>
                                        <option value="custom" {{ old('video_platform') === 'custom' ? 'selected' : '' }}>🔗 Custom URL</option>
                                    </select>
                                    @error('video_platform')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                                
                                <div class="mb-3">
                                    <label class="form-label fw-bold small">URL Video <span class="text-danger">*</span></label>
                                    <input type="url" 
                                           name="video_embed" 
                                           value="{{ old('video_embed') }}"
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
                                            <strong>⚠️ Catatan Penting:</strong>
                                            <ul class="mb-0 mt-1">
                                                <li>YouTube, Vimeo, dan Wistia adalah pilihan terbaik</li>
                                                <li>Instagram dan TikTok <strong>tidak mendukung</strong> autoplay embed</li>
                                                <li>Video akan otomatis diputar tanpa suara (muted)</li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 4. PENGATURAN --}}
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
                                           value="{{ old('order', 0) }}"
                                           min="0"
                                           class="form-control">
                                    <small class="text-muted">💡 Angka 0 = paling awal. Bisa diatur dengan drag & drop di daftar slider.</small>
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
                                                       {{ old('is_active', true) ? 'checked' : '' }}>
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
                                <i class="fas fa-save me-1"></i> Simpan Slider
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
                                <i class="fas fa-heading text-primary me-2"></i> Judul & Teks
                            </h6>
                            <p class="text-muted small mb-0">
                                • <strong>Judul:</strong> GUNAKAN HURUF KAPITAL<br>
                                • <strong>Subtitle:</strong> Keterangan di bawah judul<br>
                                • <strong>Tagline:</strong> Deskripsi singkat<br>
                                • Buat menarik & profesional<br>
                                • Hindari teks terlalu panjang
                            </p>
                        </div>

                        {{-- Guide 2 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-success fw-bold mb-2 small">
                                <i class="fas fa-mouse-pointer text-success me-2"></i> Tombol CTA
                            </h6>
                            <p class="text-muted small mb-0">
                                Tombol Call-to-Action (Opsional):<br>
                                • "Daftar Sekarang" → Pendaftaran<br>
                                • "Selengkapnya" → Info lengkap<br>
                                • "Lihat Program" → Program studi<br>
                                • Kosongkan jika tidak perlu
                            </p>
                        </div>

                        {{-- Guide 3 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-warning fw-bold mb-2 small">
                                <i class="fas fa-image text-warning me-2"></i> Background Image
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Specs:</strong><br>
                                • Format: JPG, PNG<br>
                                • Resolusi: 1920x1080px<br>
                                • Ukuran: Max 5MB<br>
                                • Rasio: 16:9 (landscape)<br>
                                • Gunakan gambar berkualitas tinggi
                            </p>
                        </div>

                        {{-- Guide 4 --}}
                        <div class="bg-light p-3 rounded border mb-3">
                            <h6 class="text-danger fw-bold mb-2 small">
                                <i class="fas fa-video text-danger me-2"></i> Video Background
                            </h6>
                            <p class="text-muted small mb-0">
                                <strong>Platform Support:</strong><br>
                                • ✅ YouTube (Recommended)<br>
                                • ✅ Vimeo<br>
                                • ✅ Wistia<br>
                                • ❌ Instagram (tidak support)<br>
                                • ❌ TikTok (tidak support)<br>
                                • Video akan auto-play & muted
                            </p>
                        </div>

                        {{-- Guide 5 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-info fw-bold mb-2 small">
                                <i class="fas fa-lightbulb text-info me-2"></i> Tips Umum
                            </h6>
                            <p class="text-muted small mb-0">
                                • Gunakan gambar dengan kontras baik<br>
                                • Text harus mudah dibaca<br>
                                • Video jangan terlalu ramai<br>
                                • Test di berbagai device<br>
                                • Urutan bisa diatur drag & drop
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
</style>
@endsection