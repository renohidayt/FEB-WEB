@extends('admin.layouts.app')

@section('title', 'Edit Template Surat')

@section('content')
<div class="container-fluid px-4 py-4">
    
    {{-- HEADER PAGE --}}
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 fw-bold text-dark mb-1">Edit Template Surat</h1>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 small">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}" class="text-decoration-none">Dashboard</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.letter-templates.index') }}" class="text-decoration-none">Template Surat</a></li>
                    <li class="breadcrumb-item active" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.letter-templates.index') }}" class="btn btn-white border shadow-sm text-dark">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
            <button type="button" onclick="submitForm()" class="btn btn-primary shadow-sm px-4">
                <i class="fas fa-save me-1"></i> Simpan Perubahan
            </button>
        </div>
    </div>

    <form action="{{ route('admin.letter-templates.update', $letterTemplate) }}" method="POST" id="templateForm">
        @csrf
        @method('PUT')
        
        <div class="row g-4">
            
            {{-- KOLOM KIRI: Form Builder --}}
            <div class="col-lg-8">
                
                {{-- 1. HEADER INFO --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold text-dark">Judul Template <span class="text-danger">*</span></label>
                            <input type="text" 
                                   name="title" 
                                   value="{{ old('title', $letterTemplate->title) }}" 
                                   class="form-control form-control-lg bg-light border-0 text-dark fw-bold" 
                                   placeholder="Misal: Surat Keterangan Aktif Kuliah" 
                                   required>
                            @error('title')
                                <div class="text-danger small mt-1">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div>
                            <label class="form-label fw-bold text-dark small">Deskripsi Singkat</label>
                            <textarea name="description" 
                                      rows="2" 
                                      class="form-control bg-light border-0"
                                      placeholder="Jelaskan fungsi surat ini...">{{ old('description', $letterTemplate->description) }}</textarea>
                        </div>
                    </div>
                </div>

                {{-- 2. FORM BUILDER AREA --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center border-bottom">
                        <h6 class="m-0 fw-bold text-dark">
                            <i class="fas fa-list-alt me-2 text-primary"></i>Kustomisasi Pertanyaan
                        </h6>
                        <span class="badge bg-light text-dark border" id="fieldCount">0 Item</span>
                    </div>
                    
                    <div class="card-body bg-light">
                        {{-- Container Fields --}}
                        <div id="formFields" class="d-flex flex-column gap-3 mb-4"></div>

                        {{-- REVISI: TOMBOL TAMBAH MANUAL (Bukan Dropdown Bootstrap) --}}
                        <div class="mt-3">
                            <button type="button" 
                                    onclick="toggleAddMenu()" 
                                    class="btn btn-outline-primary w-100 py-2 border-dashed fw-bold bg-white" 
                                    style="border-style: dashed !important; border-width: 2px;">
                                <i class="fas fa-plus-circle me-1"></i> Tambah Kolom Isian Baru
                            </button>

                            {{-- Menu Pilihan Tipe Input --}}
                            <div id="addMenuContainer" class="d-none mt-3 p-3 bg-white border rounded shadow-sm">
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <h6 class="small fw-bold text-muted m-0">PILIH TIPE PERTANYAAN:</h6>
                                    <button type="button" onclick="toggleAddMenu()" class="btn btn-sm btn-link text-muted text-decoration-none"><i class="fas fa-times"></i> Tutup</button>
                                </div>
                                <div class="row g-2">
                                    @php
                                        $menuItems = [
                                            ['text', 'fas fa-font', 'Teks Singkat', 'Nama, Tempat Lahir, dll'],
                                            ['textarea', 'fas fa-align-left', 'Paragraf', 'Alamat, Alasan, dll'],
                                            ['number', 'fas fa-hashtag', 'Angka', 'Nomor HP, Tahun, dll'],
                                            ['date', 'fas fa-calendar', 'Tanggal', 'Tanggal Lahir, Acara'],
                                            ['select', 'fas fa-chevron-circle-down', 'Dropdown', 'Pilihan menu ke bawah'],
                                            ['radio', 'fas fa-dot-circle', 'Radio Button', 'Pilihan (Hanya satu)'],
                                            ['checkbox', 'fas fa-check-square', 'Checkbox', 'Pilihan (Bisa banyak)'],
                                            ['file', 'fas fa-upload', 'Upload File', 'PDF, Gambar, Scan'],
                                        ];
                                    @endphp
                                    @foreach($menuItems as $item)
                                    <div class="col-6 col-md-3">
                                        <button type="button" onclick="addField('{{ $item[0] }}')" class="btn btn-light border w-100 text-start p-2 hover-bg-primary h-100">
                                            <div class="d-flex align-items-center gap-2 mb-1">
                                                <i class="{{ $item[1] }} text-primary"></i>
                                                <span class="fw-bold small">{{ $item[2] }}</span>
                                            </div>
                                            <div class="small text-muted" style="font-size: 0.7rem; line-height: 1.2;">{{ $item[3] }}</div>
                                        </button>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- KOLOM KANAN: Settings --}}
            <div class="col-lg-4">
                
                {{-- STATUS --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-body">
                        <h6 class="fw-bold text-dark mb-3">Status Template</h6>
                        <div class="form-check form-switch p-0 ps-5">
                            <input type="checkbox" name="is_active" value="1" 
                                   {{ old('is_active', $letterTemplate->is_active) ? 'checked' : '' }} 
                                   class="form-check-input ms-n5" style="width: 2.5em; height: 1.3em;" id="isActive">
                            <label class="form-check-label fw-bold pt-1" for="isActive">Publikasikan (Aktif)</label>
                        </div>
                    </div>
                </div>

                {{-- INFO DATA --}}
                <div class="card shadow-sm border-0 mb-4 bg-info bg-opacity-10">
                    <div class="card-body">
                        <div class="d-flex gap-2 mb-2 text-primary">
                            <i class="fas fa-robot fs-5"></i>
                            <h6 class="fw-bold m-0">Data Otomatis</h6>
                        </div>
                        <p class="small text-dark mb-2">Sistem otomatis mengisi data ini (Tidak perlu dibuatkan kolom):</p>
                        <div class="d-flex flex-wrap gap-1">
                            @foreach(['Nama', 'NIM', 'Prodi', 'Semester'] as $dt)
                                <span class="badge bg-white text-dark border px-2 py-1">{{ $dt }}</span>
                            @endforeach
                        </div>
                    </div>
                </div>

                {{-- TANDA TANGAN --}}
                <div class="card shadow-sm border-0 mb-4">
                    <div class="card-header bg-white py-3 border-bottom">
                        <h6 class="m-0 fw-bold text-dark">Pengaturan Tanda Tangan</h6>
                    </div>
                    <div class="card-body">
                        <div class="form-check form-switch mb-3 p-0 ps-5">
                            <input type="checkbox" name="requires_approval_signature" value="1" 
                                   {{ old('requires_approval_signature', $letterTemplate->requires_approval_signature) ? 'checked' : '' }}
                                   class="form-check-input ms-n5" style="width: 2.5em; height: 1.3em;" id="requiresApproval"
                                   onchange="toggleApprovalFields()">
                            <label class="form-check-label fw-bold pt-1" for="requiresApproval">Perlu TTD Pejabat?</label>
                        </div>

                        <div id="approvalFields" style="display: none;" class="bg-light p-3 rounded">
                            <div class="mb-2">
                                <label class="form-label small fw-bold">Jabatan</label>
                                <input type="text" name="approval_title" value="{{ $letterTemplate->approval_title }}" class="form-control form-control-sm" placeholder="Contoh: Dekan">
                            </div>
                            <div class="mb-2">
                                <label class="form-label small fw-bold">Nama Pejabat</label>
                                <input type="text" name="approval_name" value="{{ $letterTemplate->approval_name }}" class="form-control form-control-sm">
                            </div>
                            <div class="mb-0">
                                <label class="form-label small fw-bold">NIP/NIDN</label>
                                <input type="text" name="approval_nip" value="{{ $letterTemplate->approval_nip }}" class="form-control form-control-sm">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <input type="hidden" name="form_fields" id="formFieldsJson">
    </form>
</div>

{{-- JAVASCRIPT LOGIC --}}
<script>
// Initial Data
let fields = @json($letterTemplate->form_fields ?? []);
let fieldIdCounter = fields.length > 0 ? Math.max(...fields.map(f => f.id)) + 1 : 1;

document.addEventListener('DOMContentLoaded', function() {
    toggleApprovalFields();
    renderFields();
});

// 1. Toggle Menu Tambah (Manual JS, tanpa Bootstrap Toggle)
function toggleAddMenu() {
    const menu = document.getElementById('addMenuContainer');
    if (menu.classList.contains('d-none')) {
        menu.classList.remove('d-none');
    } else {
        menu.classList.add('d-none');
    }
}

// 2. Tambah Field Baru
function addField(type) {
    fields.push({
        id: fieldIdCounter++,
        type: type,
        label: 'Pertanyaan Baru',
        required: false,
        placeholder: '',
        options: ['select', 'radio', 'checkbox'].includes(type) ? ['Pilihan 1'] : []
    });
    
    // Tutup menu setelah memilih
    toggleAddMenu();
    renderFields();
    
    // Scroll ke bawah
    setTimeout(() => {
        window.scrollTo(0, document.body.scrollHeight);
    }, 100);
}

// 3. Hapus Field
function deleteField(id) {
    if (confirm('Hapus pertanyaan ini?')) {
        fields = fields.filter(f => f.id !== id);
        renderFields();
    }
}

// 4. Update Field Properties
function updateField(id, key, value) {
    const field = fields.find(f => f.id === id);
    if (field) {
        field[key] = value;
        updateFormFieldsJson();
    }
}

// 5. Render Tampilan
function renderFields() {
    const container = document.getElementById('formFields');
    document.getElementById('fieldCount').innerText = `${fields.length} Item`;
    
    if (fields.length === 0) {
        container.innerHTML = `
            <div class="text-center py-5 border rounded bg-white">
                <i class="fas fa-clipboard-list text-muted fs-1 mb-3"></i>
                <h6 class="text-dark fw-bold">Belum ada pertanyaan</h6>
                <p class="text-muted small">Klik tombol "Tambah Kolom" di bawah.</p>
            </div>`;
        updateFormFieldsJson();
        return;
    }

    container.innerHTML = fields.map((field, index) => `
        <div class="card border shadow-sm field-item animate-fade">
            <div class="card-body p-3">
                <div class="d-flex align-items-start gap-3">
                    <div class="d-flex flex-column align-items-center">
                        <span class="badge bg-dark rounded-circle d-flex align-items-center justify-content-center" style="width:24px; height:24px;">${index + 1}</span>
                    </div>

                    <div class="flex-grow-1">
                        <div class="d-flex justify-content-between mb-2">
                            <input type="text" 
                                   value="${field.label}" 
                                   onchange="updateField(${field.id}, 'label', this.value)" 
                                   class="form-control fw-bold border-0 bg-transparent p-0 shadow-none text-dark" 
                                   style="font-size: 1.05rem;"
                                   placeholder="Tulis Judul Pertanyaan...">
                            <span class="badge bg-primary bg-opacity-10 text-primary border border-primary border-opacity-10 text-uppercase align-self-center">
                                ${field.type}
                            </span>
                        </div>

                        <div class="mb-2">
                             <input type="text" 
                                   value="${field.placeholder || ''}" 
                                   onchange="updateField(${field.id}, 'placeholder', this.value)" 
                                   class="form-control form-control-sm bg-light text-secondary border-0" 
                                   placeholder="Contoh jawaban / placeholder...">
                        </div>

                        ${renderOptionsSection(field)}
                    </div>

                    <div class="d-flex flex-column gap-2 border-start ps-2">
                        <div class="form-check form-switch" title="Wajib Diisi">
                            <input type="checkbox" ${field.required ? 'checked' : ''} 
                                   onchange="updateField(${field.id}, 'required', this.checked)" 
                                   class="form-check-input" id="req${field.id}">
                        </div>
                        <button type="button" onclick="deleteField(${field.id})" class="btn btn-sm text-danger hover-danger p-0">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    `).join('');
    updateFormFieldsJson();
}

function renderOptionsSection(field) {
    if (!['select', 'radio', 'checkbox'].includes(field.type)) return '';
    
    return `
        <div class="bg-light p-2 rounded border mt-2">
            <label class="small fw-bold text-muted mb-1 d-block">Opsi Jawaban:</label>
            ${field.options.map((opt, i) => `
                <div class="d-flex gap-2 mb-1">
                    <input type="text" value="${opt}" onchange="updateOption(${field.id}, ${i}, this.value)" class="form-control form-control-sm bg-white">
                    <button type="button" onclick="deleteOption(${field.id}, ${i})" class="btn btn-sm text-danger"><i class="fas fa-times"></i></button>
                </div>
            `).join('')}
            <button type="button" onclick="addOption(${field.id})" class="btn btn-sm btn-link text-decoration-none p-0 mt-1" style="font-size:0.8rem">
                + Tambah Opsi
            </button>
        </div>
    `;
}

// Option Utilities
function addOption(id) {
    const f = fields.find(x => x.id === id);
    f.options.push(`Pilihan Baru`);
    renderFields();
}
function updateOption(id, idx, val) {
    fields.find(x => x.id === id).options[idx] = val;
    updateFormFieldsJson();
}
function deleteOption(id, idx) {
    const f = fields.find(x => x.id === id);
    if(f.options.length > 1) { 
        f.options.splice(idx, 1); 
        renderFields(); 
    } else {
        alert('Minimal harus tersisa satu opsi.');
    }
}

// Approval Toggle
function toggleApprovalFields() {
    const box = document.getElementById('requiresApproval');
    document.getElementById('approvalFields').style.display = box.checked ? 'block' : 'none';
}

// Submit Helper
function submitForm() {
    document.getElementById('templateForm').submit();
}

function updateFormFieldsJson() {
    document.getElementById('formFieldsJson').value = JSON.stringify(fields);
}
</script>

<style>
/* CSS Tambahan agar UI rapi */
.hover-bg-primary:hover { background-color: #f0f9ff !important; border-color: #b9e1ff !important; }
.btn-white { background: white; color: #333; }
.btn-white:hover { background: #f8f9fa; }
.field-item { transition: all 0.2s; }
.field-item:hover { border-color: #0d6efd !important; }
.form-control:focus { box-shadow: none; border-color: #0d6efd; }
.animate-fade { animation: fadeIn 0.3s ease-in; }
@keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>
@endsection