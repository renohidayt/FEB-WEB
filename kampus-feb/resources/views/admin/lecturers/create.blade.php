@extends('admin.layouts.app')

@section('title', 'Tambah Dosen')

@section('content')
<div class="container-fluid px-4">
    
    {{-- HEADER --}}
    <div class="d-flex align-items-center justify-content-between mb-4 mt-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800 fw-bold">Tambah Dosen Baru</h1>
            <p class="text-muted small mb-0">Lengkapi formulir di bawah untuk menambahkan data dosen baru.</p>
        </div>
        <a href="{{ route('admin.lecturers.index') }}" class="btn btn-outline-secondary btn-sm">
            <i class="fas fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="row">
        {{-- KOLOM KIRI: FORM TAMBAH --}}
        <div class="col-lg-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary"><i class="fas fa-user-plus me-2"></i>Formulir Data Dosen</h6>
                </div>
                <div class="card-body tips-scroll">

                    <form action="{{ route('admin.lecturers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

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
                                           value="{{ old('name') }}" 
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
                                           value="{{ old('nidn') }}" 
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
                                            <option value="{{ $key }}" {{ old('academic_degree') == $key ? 'selected' : '' }}>
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
                                           value="{{ old('position') }}"
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
                                            <option value="{{ $key }}" {{ old('employment_status') == $key ? 'selected' : '' }}>
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
                                        <option value="Manajemen" {{ old('study_program') == 'Manajemen' ? 'selected' : '' }}>Manajemen</option>
                                        <option value="Akutansi" {{ old('study_program') == 'Akutansi' ? 'selected' : '' }}>Akutansi</option>
                                        <option value="Magister Manajemen" {{ old('study_program') == 'Magister Manajemen' ? 'selected' : '' }}>Magister Manajemen</option>
                                    </select>
                                    @error('study_program')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Foto Profil --}}
                                <div class="col-12 mt-3">
                                    <label class="form-label fw-bold small">Foto Resmi Dosen</label>
                                    <input type="file" 
                                           name="photo" 
                                           class="form-control @error('photo') is-invalid @enderror"
                                           id="photoInput"
                                           accept="image/*"
                                           onchange="previewPhoto(this)">
                                    <div class="form-text text-muted small">Format: JPG, PNG. Maksimal 2MB. Minimal 200x200px.</div>
                                    @error('photo')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror

                                    {{-- Preview Container --}}
                                    <div id="previewContainer" class="d-none mt-3 p-3 bg-light rounded border text-center" style="max-width: 300px;">
                                        <p class="small text-success fw-bold mb-2">Preview Foto:</p>
                                        <img id="photoPreview" class="img-fluid rounded shadow-sm" style="max-height: 200px;">
                                        <button type="button" class="btn btn-sm btn-outline-danger mt-2 d-block mx-auto" onclick="resetPhoto()">
                                            <i class="fas fa-times me-1"></i> Hapus Foto
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
                                           value="{{ old('education_s1') }}"
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
                                           value="{{ old('education_s2') }}"
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
                                           value="{{ old('education_s3') }}"
                                           placeholder="Contoh: Universitas Gadjah Mada, Ilmu Manajemen, 2020">
                                    @error('education_s3')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                {{-- Riwayat Pendidikan Detail (Opsional) --}}
                                <div class="col-12">
                                    <label class="form-label fw-bold small">Detail Riwayat Pendidikan (Opsional)</label>
                                    <textarea name="education_history" 
                                              rows="3" 
                                              class="form-control @error('education_history') is-invalid @enderror" 
                                              placeholder="Detail tambahan tentang riwayat pendidikan">{{ old('education_history') }}</textarea>
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
                                              placeholder="Contoh: Manajemen Pemasaran, Akuntansi Publik, Perpajakan">{{ old('expertise') }}</textarea>
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
                                              placeholder="Contoh: Digital Marketing, Financial Technology, Sustainability Accounting">{{ old('research_interests') }}</textarea>
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
                                              placeholder="Pisahkan dengan koma jika lebih dari satu. Contoh: Akuntansi Dasar, Perpajakan 1, Audit">{{ old('courses_taught') }}</textarea>
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
                                              placeholder="Contoh: Dosen di Universitas X (2010-2015), Dosen di Universitas Y (2015-sekarang)">{{ old('teaching_experience') }}</textarea>
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
                                           value="{{ old('structural_position') }}"
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
                                              placeholder="Masukkan judul artikel, nama jurnal, volume, tahun. Pisahkan dengan enter untuk setiap publikasi.">{{ old('publications') }}</textarea>
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
                                              placeholder="Masukkan judul paper, nama konferensi, tahun.">{{ old('conference_papers') }}</textarea>
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
                                              placeholder="Masukkan judul buku, penerbit, tahun atau nomor HKI">{{ old('books_hki') }}</textarea>
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
                                              placeholder="Masukkan judul kegiatan, lokasi, dan tahun pelaksanaan. Pisahkan dengan enter untuk setiap kegiatan.">{{ old('community_service') }}</textarea>
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
                                              placeholder="Contoh: Sertifikat Pendidik Profesional, Sertifikasi CPA, dll">{{ old('certifications') }}</textarea>
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
                                              placeholder="Masukkan nama penghargaan dan tahun">{{ old('awards') }}</textarea>
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
                                               value="{{ old('email') }}" 
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
                                               value="{{ old('phone') }}" 
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
                                               value="{{ old('google_scholar_url') }}" 
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
                                               value="{{ old('sinta_id') }}" 
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
                                               value="{{ old('scopus_id') }}" 
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
                                               value="{{ old('orcid') }}" 
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
                                                       {{ old('is_visible', true) ? 'checked' : '' }}>
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
                                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                                <label class="form-check-label fw-bold" for="isActive">Status Aktif Mengajar</label>
                                                <small class="d-block text-muted">Menandakan dosen masih aktif di kampus.</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- BUTTONS --}}
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <a href="{{ route('admin.lecturers.index') }}" class="btn btn-secondary">
                                <i class="fas fa-times me-1"></i> Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Simpan Data Dosen
                            </button>
                        </div>

                    </form>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: PETUNJUK PENGISIAN --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-left-primary" style="position: sticky; top: 100px; z-index: 10;">
                <div class="card-header bg-primary text-white py-3">
                    <h6 class="m-0 fw-bold"><i class="fas fa-info-circle me-2"></i>Petunjuk Pengisian</h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info border-0 bg-info-subtle text-info-emphasis mb-3" role="alert">
                        <small><strong>Tips:</strong> Field yang bertanda <span class="text-danger">*</span> wajib diisi. Field lainnya opsional tetapi disarankan untuk kelengkapan profil.</small>
                    </div>

                    <div class="space-y-3">
                        {{-- Guide 1 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-primary fw-bold mb-2 small">
                                <i class="fas fa-id-card text-primary me-2"></i> Biodata Utama
                            </h6>
                            <ul class="mb-0 ps-3 small text-muted">
                                <li><strong>NIDN:</strong> 10 digit angka</li>
                                <li><strong>Status Dosen:</strong> Tetap/Tidak Tetap wajib dipilih</li>
                                <li><strong>Foto:</strong> Minimal 200x200px, maks 2MB</li>
                            </ul>
                        </div>

                        {{-- Guide 2 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-success fw-bold mb-2 small">
                                <i class="fas fa-graduation-cap text-success me-2"></i> Riwayat Pendidikan
                            </h6>
                            <p class="text-muted small mb-0">
                                Format: <code>Universitas, Jurusan, Tahun</code><br>
                                Contoh: <em>Universitas Indonesia, Akuntansi, 2010</em>
                            </p>
                        </div>

                        {{-- Guide 3 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-warning fw-bold mb-2 small">
                                <i class="fas fa-book text-warning me-2"></i> Publikasi
                            </h6>
                            <p class="text-muted small mb-2">
                                Pisahkan setiap publikasi dengan <strong>enter</strong>. Masukkan:
                            </p>
                            <ul class="mb-0 ps-3 small text-muted">
                                <li>Judul artikel/paper</li>
                                <li>Nama jurnal/konferensi</li>
                                <li>Volume, nomor (jika ada)</li>
                                <li>Tahun publikasi</li>
                            </ul>
                        </div>

                        {{-- Guide 4 --}}
                        <div class="bg-light p-3 rounded border">
                            <h6 class="text-info fw-bold mb-2 small">
                                <i class="fas fa-globe text-info me-2"></i> Identitas Digital
                            </h6>
                            <ul class="mb-0 ps-3 small text-muted">
                                <li><strong>Google Scholar:</strong> URL profil lengkap</li>
                                <li><strong>SINTA:</strong> ID numerik saja</li>
                                <li><strong>Scopus:</strong> ID numerik</li>
                                <li><strong>ORCID:</strong> Format 0000-0001-2345-6789</li>
                            </ul>
                        </div>
                    </div>

                    <hr class="my-3">

                    <div class="text-center">
                        <small class="text-muted">
                            <i class="fas fa-question-circle me-1"></i>
                            Butuh bantuan? Hubungi admin sistem
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

.tips-scroll {
    max-height: calc(100vh - 180px); /* tinggi layar dikurangi header */
    overflow-y: auto;
    padding-right: 8px;
}

/* Scrollbar lebih halus (opsional) */
.tips-scroll::-webkit-scrollbar {
    width: 6px;
}

.tips-scroll::-webkit-scrollbar-thumb {
    background-color: rgba(0,0,0,0.2);
    border-radius: 4px;
}

.tips-scroll::-webkit-scrollbar-track {
    background: transparent;
}

@endsection