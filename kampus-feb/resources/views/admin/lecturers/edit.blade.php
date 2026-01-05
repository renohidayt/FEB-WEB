@extends('admin.layouts.app')

@section('title', 'Edit Dosen')

@section('content')
<div class="container-fluid px-4">
    
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-4 mt-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Edit Data Dosen</h1>
            <p class="text-muted small mb-0">Update informasi dosen: <strong>{{ $lecturer->name }}</strong></p>
        </div>
        <a href="{{ route('admin.lecturers.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    {{-- Alert Profile Completeness --}}
    @if($lecturer->profile_completeness < 100)
    <div class="alert alert-warning alert-dismissible fade show" role="alert">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>Profil belum lengkap!</strong> Kelengkapan profil: <strong>{{ $lecturer->profile_completeness }}%</strong>. 
        Lengkapi data untuk meningkatkan visibilitas profil.
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
    @endif

    <div class="row">
        {{-- KOLOM KIRI: FORM EDIT --}}
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user-edit me-2"></i>Formulir Edit Data Dosen
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.lecturers.update', $lecturer) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        {{-- 1. BIODATA UTAMA --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs font-weight-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-id-card me-2"></i>Biodata Utama
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Nama Lengkap --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Nama Lengkap <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="name" 
                                           class="form-control @error('name') is-invalid @enderror" 
                                           value="{{ old('name', $lecturer->name) }}" 
                                           placeholder="Contoh: Dr. John Doe, M.Kom"
                                           required>
                                    @error('name')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- NIDN --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">NIDN <span class="text-danger">*</span></label>
                                    <input type="text" 
                                           name="nidn" 
                                           class="form-control @error('nidn') is-invalid @enderror" 
                                           value="{{ old('nidn', $lecturer->nidn) }}" 
                                           placeholder="10 digit angka"
                                           maxlength="10"
                                           pattern="[0-9]{10}"
                                           required>
                                    @error('nidn')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Gelar Akademik --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Gelar Akademik</label>
                                    <select name="academic_degree" class="form-select @error('academic_degree') is-invalid @enderror">
                                        <option value="">-- Pilih Gelar --</option>
                                        @foreach(\App\Models\Lecturer::academicDegrees() as $key => $label)
                                            <option value="{{ $key }}" {{ old('academic_degree', $lecturer->academic_degree) == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('academic_degree')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Jabatan Fungsional --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Jabatan Fungsional</label>
                                    <input type="text" 
                                           name="position" 
                                           class="form-control @error('position') is-invalid @enderror" 
                                           value="{{ old('position', $lecturer->position) }}"
                                           placeholder="Contoh: Lektor, Asisten Ahli, Guru Besar">
                                    @error('position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Status Dosen --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Status Dosen <span class="text-danger">*</span></label>
                                    <select name="employment_status" class="form-select @error('employment_status') is-invalid @enderror" required>
                                        <option value="">-- Pilih Status --</option>
                                        @foreach(\App\Models\Lecturer::employmentStatuses() as $key => $label)
                                            <option value="{{ $key }}" {{ old('employment_status', $lecturer->employment_status) == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('employment_status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Program Studi --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Program Studi / Fakultas</label>
                                    <select name="study_program" class="form-select @error('study_program') is-invalid @enderror">
                                        <option value="">-- Pilih Prodi --</option>
                                        <option value="Manajemen" {{ old('study_program', $lecturer->study_program) == 'Manajemen' ? 'selected' : '' }}>Manajemen</option>
                                        <option value="Akutansi" {{ old('study_program', $lecturer->study_program) == 'Akutansi' ? 'selected' : '' }}>Akutansi</option>
                                        <option value="Magister Manajemen" {{ old('study_program', $lecturer->study_program) == 'Magister Manajemen' ? 'selected' : '' }}>Magister Manajemen</option>
                                    </select>
                                    @error('study_program')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Foto Profil --}}
                                <div class="col-12 mt-3">
                                    <label class="form-label fw-bold small">Foto Resmi Dosen</label>
                                    
                                    {{-- Current Photo Display --}}
                                    @if($lecturer->photo)
                                    <div class="mb-3">
                                        <p class="small text-muted mb-2">Foto saat ini:</p>
                                        <div class="position-relative d-inline-block">
                                            <img src="{{ $lecturer->photo_url }}" 
                                                 alt="{{ $lecturer->name }}" 
                                                 class="img-thumbnail"
                                                 style="max-width: 200px; max-height: 200px;">
                                            <span class="badge bg-success position-absolute top-0 start-100 translate-middle">
                                                <i class="fas fa-check"></i>
                                            </span>
                                        </div>
                                    </div>
                                    @endif

                                    <input type="file" 
                                           name="photo" 
                                           class="form-control @error('photo') is-invalid @enderror"
                                           id="photoInput"
                                           accept="image/*"
                                           onchange="previewPhoto(this)">
                                    <div class="form-text text-muted small">
                                        Format: JPG, PNG. Maksimal 2MB. Minimal 200x200px.
                                        @if($lecturer->photo)
                                        <strong class="text-warning">Upload foto baru akan mengganti foto lama.</strong>
                                        @endif
                                    </div>
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    {{-- Preview Container for New Photo --}}
                                    <div id="previewContainer" class="d-none mt-3 p-3 bg-light rounded border text-center" style="max-width: 300px;">
                                        <p class="small text-success fw-bold mb-2">Preview Foto Baru:</p>
                                        <img id="photoPreview" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                                        <button type="button" class="btn btn-sm btn-outline-danger mt-2 d-block mx-auto" onclick="resetPhoto()">
                                            <i class="fas fa-times me-1"></i> Batal Upload
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- 2. RIWAYAT PENDIDIKAN --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs font-weight-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-graduation-cap me-2"></i>Riwayat Pendidikan
                            </h6>
                            
                            <div class="row g-3">
                                {{-- S1 --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Pendidikan S1</label>
                                    <input type="text" 
                                           name="education_s1" 
                                           class="form-control @error('education_s1') is-invalid @enderror" 
                                           value="{{ old('education_s1', $lecturer->education_s1) }}"
                                           placeholder="Contoh: Universitas Indonesia, Akuntansi, 2010">
                                    @error('education_s1')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- S2 --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Pendidikan S2</label>
                                    <input type="text" 
                                           name="education_s2" 
                                           class="form-control @error('education_s2') is-invalid @enderror" 
                                           value="{{ old('education_s2', $lecturer->education_s2) }}"
                                           placeholder="Contoh: Institut Teknologi Bandung, Manajemen Keuangan, 2015">
                                    @error('education_s2')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- S3 --}}
                                <div class="col-md-12">
                                    <label class="form-label fw-bold small">Pendidikan S3 (jika ada)</label>
                                    <input type="text" 
                                           name="education_s3" 
                                           class="form-control @error('education_s3') is-invalid @enderror" 
                                           value="{{ old('education_s3', $lecturer->education_s3) }}"
                                           placeholder="Contoh: Universitas Gadjah Mada, Ilmu Manajemen, 2020">
                                    @error('education_s3')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Riwayat Pendidikan Detail --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Detail Riwayat Pendidikan (Opsional)</label>
                                    <textarea name="education_history" 
                                              rows="3" 
                                              class="form-control @error('education_history') is-invalid @enderror" 
                                              placeholder="Detail tambahan tentang riwayat pendidikan">{{ old('education_history', $lecturer->education_history) }}</textarea>
                                    @error('education_history')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 3. BIDANG KEAHLIAN --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs font-weight-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-lightbulb me-2"></i>Bidang Keahlian & Minat Riset
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Bidang Keahlian --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Bidang Keahlian / Kompetensi Utama</label>
                                    <textarea name="expertise" 
                                              rows="3" 
                                              class="form-control @error('expertise') is-invalid @enderror" 
                                              placeholder="Contoh: Manajemen Pemasaran, Akuntansi Publik, Perpajakan">{{ old('expertise', $lecturer->expertise) }}</textarea>
                                    @error('expertise')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Minat Riset --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Minat Riset</label>
                                    <textarea name="research_interests" 
                                              rows="3" 
                                              class="form-control @error('research_interests') is-invalid @enderror" 
                                              placeholder="Contoh: Digital Marketing, Financial Technology, Sustainability Accounting">{{ old('research_interests', $lecturer->research_interests) }}</textarea>
                                    @error('research_interests')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 4. PENGALAMAN AKADEMIK --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs font-weight-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-chalkboard-teacher me-2"></i>Pengalaman Akademik
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Mata Kuliah yang Diampu --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Mata Kuliah yang Diampu</label>
                                    <textarea name="courses_taught" 
                                              rows="3" 
                                              class="form-control @error('courses_taught') is-invalid @enderror" 
                                              placeholder="Pisahkan dengan koma jika lebih dari satu. Contoh: Akuntansi Dasar, Perpajakan 1, Audit">{{ old('courses_taught', $lecturer->courses_taught) }}</textarea>
                                    @error('courses_taught')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Pengalaman Mengajar --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Pengalaman Mengajar</label>
                                    <textarea name="teaching_experience" 
                                              rows="3" 
                                              class="form-control @error('teaching_experience') is-invalid @enderror" 
                                              placeholder="Contoh: Dosen di Universitas X (2010-2015), Dosen di Universitas Y (2015-sekarang)">{{ old('teaching_experience', $lecturer->teaching_experience) }}</textarea>
                                    @error('teaching_experience')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Jabatan Struktural --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Jabatan Struktural (jika ada)</label>
                                    <input type="text" 
                                           name="structural_position" 
                                           class="form-control @error('structural_position') is-invalid @enderror" 
                                           value="{{ old('structural_position', $lecturer->structural_position) }}"
                                           placeholder="Contoh: Ketua Program Studi, Wakil Dekan Bidang Akademik">
                                    @error('structural_position')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 5. PUBLIKASI & PENELITIAN --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs font-weight-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-book me-2"></i>Publikasi & Penelitian
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Jurnal Nasional/Internasional --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Publikasi Jurnal (Nasional/Internasional)</label>
                                    <textarea name="publications" 
                                              rows="4" 
                                              class="form-control @error('publications') is-invalid @enderror" 
                                              placeholder="Masukkan judul artikel, nama jurnal, volume, tahun. Pisahkan dengan enter untuk setiap publikasi.">{{ old('publications', $lecturer->publications) }}</textarea>
                                    @error('publications')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Prosiding Seminar --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Prosiding Seminar / Konferensi</label>
                                    <textarea name="conference_papers" 
                                              rows="4" 
                                              class="form-control @error('conference_papers') is-invalid @enderror" 
                                              placeholder="Masukkan judul paper, nama konferensi, tahun.">{{ old('conference_papers', $lecturer->conference_papers) }}</textarea>
                                    @error('conference_papers')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Buku / HKI --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Buku / HKI (Hak Kekayaan Intelektual)</label>
                                    <textarea name="books_hki" 
                                              rows="3" 
                                              class="form-control @error('books_hki') is-invalid @enderror" 
                                              placeholder="Masukkan judul buku, penerbit, tahun atau nomor HKI">{{ old('books_hki', $lecturer->books_hki) }}</textarea>
                                    @error('books_hki')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 6. PENGABDIAN MASYARAKAT --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs font-weight-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-hands-helping me-2"></i>Pengabdian Masyarakat
                            </h6>
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Kegiatan Pengabdian Masyarakat</label>
                                    <textarea name="community_service" 
                                              rows="4" 
                                              class="form-control @error('community_service') is-invalid @enderror" 
                                              placeholder="Masukkan judul kegiatan, lokasi, dan tahun pelaksanaan. Pisahkan dengan enter untuk setiap kegiatan.">{{ old('community_service', $lecturer->community_service) }}</textarea>
                                    @error('community_service')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 7. SERTIFIKASI & PENGHARGAAN --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs font-weight-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-award me-2"></i>Sertifikasi & Penghargaan
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Sertifikasi --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Sertifikasi Profesional / Pendidik</label>
                                    <textarea name="certifications" 
                                              rows="3" 
                                              class="form-control @error('certifications') is-invalid @enderror" 
                                              placeholder="Contoh: Sertifikat Pendidik Profesional, Sertifikasi CPA, dll">{{ old('certifications', $lecturer->certifications) }}</textarea>
                                    @error('certifications')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Penghargaan --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Penghargaan Akademik</label>
                                    <textarea name="awards" 
                                              rows="3" 
                                              class="form-control @error('awards') is-invalid @enderror" 
                                              placeholder="Masukkan nama penghargaan dan tahun">{{ old('awards', $lecturer->awards) }}</textarea>
                                    @error('awards')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 8. KONTAK & IDENTITAS DIGITAL --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs font-weight-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-globe me-2"></i>Kontak & Identitas Digital
                            </h6>
                            
                            <div class="row g-3">
                                {{-- Email --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Email Institusi</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-envelope"></i></span>
                                        <input type="email" 
                                               name="email" 
                                               class="form-control @error('email') is-invalid @enderror" 
                                               value="{{ old('email', $lecturer->email) }}" 
                                               placeholder="email@kampus.ac.id">
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Phone --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">No. Telepon / WhatsApp</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-phone"></i></span>
                                        <input type="text" 
                                               name="phone" 
                                               class="form-control @error('phone') is-invalid @enderror" 
                                               value="{{ old('phone', $lecturer->phone) }}" 
                                               placeholder="08xxxxxxxxxx">
                                    </div>
                                    @error('phone')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Google Scholar --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Google Scholar URL</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fab fa-google"></i></span>
                                        <input type="url" 
                                               name="google_scholar_url" 
                                               class="form-control @error('google_scholar_url') is-invalid @enderror" 
                                               value="{{ old('google_scholar_url', $lecturer->google_scholar_url) }}" 
                                               placeholder="https://scholar.google.com/citations?user=...">
                                    </div>
                                    @error('google_scholar_url')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- SINTA ID --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">SINTA ID</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-id-badge"></i></span>
                                        <input type="text" 
                                               name="sinta_id" 
                                               class="form-control @error('sinta_id') is-invalid @enderror" 
                                               value="{{ old('sinta_id', $lecturer->sinta_id) }}" 
                                               placeholder="Contoh: 6012345">
                                    </div>
                                    @error('sinta_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Scopus ID --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">Scopus ID</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fas fa-graduation-cap"></i></span>
                                        <input type="text" 
                                               name="scopus_id" 
                                               class="form-control @error('scopus_id') is-invalid @enderror" 
                                               value="{{ old('scopus_id', $lecturer->scopus_id) }}" 
                                               placeholder="Contoh: 57012345678">
                                    </div>
                                    @error('scopus_id')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- ORCID --}}
                                <div class="col-md-6">
                                    <label class="form-label fw-bold small">ORCID</label>
                                    <div class="input-group">
                                        <span class="input-group-text bg-light"><i class="fab fa-orcid"></i></span>
                                        <input type="text" 
                                               name="orcid" 
                                               class="form-control @error('orcid') is-invalid @enderror" 
                                               value="{{ old('orcid', $lecturer->orcid) }}" 
                                               placeholder="0000-0001-2345-6789"
                                               pattern="[0-9]{4}-[0-9]{4}-[0-9]{4}-[0-9]{3}[0-9X]">
                                    </div>
                                    <small class="text-muted">Format: 0000-0001-2345-6789</small>
                                    @error('orcid')
                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        {{-- 9. STATUS --}}
                        <div class="mb-4">
                            <h6 class="text-uppercase text-xs font-weight-bolder opacity-7 mb-3 border-bottom pb-2">
                                <i class="fas fa-cog me-2"></i>Pengaturan Status
                            </h6>
                            <div class="card bg-light border-0">
                                <div class="card-body">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       id="isVisible" 
                                                       name="is_visible" 
                                                       value="1" 
                                                       {{ old('is_visible', $lecturer->is_visible) ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="isVisible">Tampilkan di Website</label>
                                                <small class="d-block text-muted">Jika dimatikan, profil tidak akan muncul di halaman publik.</small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       id="isActive" 
                                                       name="is_active" 
                                                       value="1" 
                                                       {{ old('is_active', $lecturer->is_active) ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="isActive">Status Aktif Mengajar</label>
                                                <small class="d-block text-muted">Menandakan dosen masih aktif di kampus.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <div>
                                <a href="{{ route('admin.lecturers.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-1"></i> Batal
                                </a>
                            </div>
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-1"></i> Update Data Dosen
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: INFO & STATISTIK --}}
        <div class="col-lg-4">
            {{-- Profile Info Card --}}
            <div class="card shadow-sm mb-3" style="position: sticky; top: 100px; z-index: 10;">
                <div class="card-header bg-info text-white py-3">
                    <h6 class="m-0 fw-bold"><i class="fas fa-chart-pie me-2"></i>Informasi Profil</h6>
                </div>
                <div class="card-body">
                    {{-- Profile Completeness --}}
                    <div class="mb-3">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="small fw-bold">Kelengkapan Profil</span>
                            <span class="badge {{ $lecturer->profile_completeness >= 80 ? 'bg-success' : ($lecturer->profile_completeness >= 50 ? 'bg-warning' : 'bg-danger') }}">
                                {{ $lecturer->profile_completeness }}%
                            </span>
                        </div>
                        <div class="progress" style="height: 10px;">
                            <div class="progress-bar {{ $lecturer->profile_completeness >= 80 ? 'bg-success' : ($lecturer->profile_completeness >= 50 ? 'bg-warning' : 'bg-danger') }}" 
                                 role="progressbar" 
                                 style="width: {{ $lecturer->profile_completeness }}%">
                            </div>
                        </div>
                        <small class="text-muted">
                            @if($lecturer->profile_completeness >= 80)
                                <i class="fas fa-check-circle text-success me-1"></i>Profil sangat lengkap!
                            @elseif($lecturer->profile_completeness >= 50)
                                <i class="fas fa-exclamation-circle text-warning me-1"></i>Profil cukup lengkap
                            @else
                                <i class="fas fa-times-circle text-danger me-1"></i>Profil perlu dilengkapi
                            @endif
                        </small>
                    </div>

                    <hr>

                    {{-- Quick Stats --}}
                    <div class="row g-2 text-center small">
                        <div class="col-6">
                            <div class="p-2 bg-light rounded">
                                <i class="fas fa-eye text-primary mb-1"></i>
                                <div class="fw-bold">{{ $lecturer->profile_views ?? 0 }}</div>
                                <small class="text-muted">Views</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-2 bg-light rounded">
                                <i class="fas fa-calendar text-success mb-1"></i>
                                <div class="fw-bold">{{ $lecturer->created_at->format('Y') }}</div>
                                <small class="text-muted">Dibuat</small>
                            </div>
                        </div>
                    </div>

                    <hr>

                    {{-- Status Badges --}}
                    <div class="mb-2">
                        <span class="badge {{ $lecturer->employment_badge_color }} me-1">
                            {{ $lecturer->employment_status }}
                        </span>
                        <span class="badge {{ $lecturer->is_visible ? 'bg-success' : 'bg-secondary' }}">
                            {{ $lecturer->is_visible ? 'Visible' : 'Hidden' }}
                        </span>
                        <span class="badge {{ $lecturer->is_active ? 'bg-info' : 'bg-secondary' }}">
                            {{ $lecturer->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Tips Card --}}
            <div class="card shadow-sm border-left-primary">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="m-0 fw-bold"><i class="fas fa-lightbulb me-2"></i>Tips Pengisian</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-light border-0 small mb-3">
                        <i class="fas fa-info-circle me-1"></i>
                        <strong>Perhatian:</strong> Pastikan data yang diubah sudah benar sebelum menyimpan.
                    </div>

                    <div class="space-y-3">
                        {{-- Tip 1 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-primary fw-bold mb-2 small">
                                <i class="fas fa-camera text-primary me-2"></i> Mengganti Foto
                            </h6>
                            <p class="text-muted small mb-0">
                                Upload foto baru akan otomatis menghapus foto lama. Pastikan foto yang di-upload sesuai dengan ketentuan.
                            </p>
                        </div>

                        {{-- Tip 2 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-success fw-bold mb-2 small">
                                <i class="fas fa-chart-line text-success me-2"></i> Kelengkapan Data
                            </h6>
                            <p class="text-muted small mb-0">
                                Semakin lengkap data yang diisi, semakin tinggi persentase kelengkapan profil. Target minimal 80%.
                            </p>
                        </div>

                        {{-- Tip 3 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-info fw-bold mb-2 small">
                                <i class="fas fa-link text-info me-2"></i> Link Identitas Digital
                            </h6>
                            <p class="text-muted small mb-0">
                                Pastikan URL yang dimasukkan valid dan dapat diakses. Terutama untuk Google Scholar dan SINTA.
                            </p>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="text-center">
                        <small class="text-muted">
                            Terakhir diupdate: <strong>{{ $lecturer->updated_at->diffForHumans() }}</strong>
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT UNTUK PREVIEW FOTO --}}
<script>
    function previewPhoto(input) {
        const preview = document.getElementById('photoPreview');
        const container = document.getElementById('previewContainer');
        
        if (input.files && input.files[0]) {
            // Validasi ukuran (2MB)
            if (input.files[0].size > 2048 * 1024) {
                alert('Ukuran file terlalu besar! Maksimal 2MB');
                input.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                preview.src = e.target.result;
                container.classList.remove('d-none');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function resetPhoto() {
        const input = document.getElementById('photoInput');
        const container = document.getElementById('previewContainer');
        const preview = document.getElementById('photoPreview');

        input.value = '';
        preview.src = '';
        container.classList.add('d-none');
    }
</script>
@endsection