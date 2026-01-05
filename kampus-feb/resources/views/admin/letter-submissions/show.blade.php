@extends('admin.layouts.app')

@section('title', 'Detail Pengajuan Surat')

@section('content')
<div class="container-fluid px-4 py-4">
    <!-- Header -->
    <div class="d-flex align-items-center gap-3 mb-4">
        <a href="{{ route('admin.letter-submissions.index') }}" class="btn btn-light">
            <i class="fas fa-arrow-left"></i>
        </a>
        <div>
            <h1 class="h3 fw-bold mb-1">Detail Pengajuan Surat</h1>
            <p class="text-muted mb-0">Informasi lengkap pengajuan</p>
        </div>
    </div>

    <div class="row g-4">
        <!-- Info Pengajuan -->
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-info-circle text-primary me-2"></i>Informasi Pengajuan
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="row g-4">
                        <div class="col-md-6">
                            <label class="small text-muted fw-semibold mb-1">Jenis Surat</label>
                            <p class="mb-0 fw-semibold">{{ $submission->template->title ?? '-' }}</p>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="small text-muted fw-semibold mb-1">Status</label>
                            <div>
                                @if($submission->status === 'pending')
                                    <span class="badge bg-warning px-3 py-2">
                                        <i class="fas fa-clock me-1"></i>Menunggu
                                    </span>
                                @elseif($submission->status === 'approved')
                                    <span class="badge bg-success px-3 py-2">
                                        <i class="fas fa-check-circle me-1"></i>Disetujui
                                    </span>
                                @elseif($submission->status === 'processing')
                                    <span class="badge bg-info px-3 py-2">
                                        <i class="fas fa-spinner me-1"></i>Diproses
                                    </span>
                                @else
                                    <span class="badge bg-danger px-3 py-2">
                                        <i class="fas fa-times-circle me-1"></i>Ditolak
                                    </span>
                                @endif
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="small text-muted fw-semibold mb-1">Pemohon</label>
                            @if($submission->user)
                                <p class="mb-0 fw-semibold">{{ $submission->user->name }}</p>
                                <p class="mb-0 small text-muted">{{ $submission->user->email }}</p>
                            @else
                                <p class="mb-0 fw-semibold">{{ $submission->nama_mahasiswa ?? '-' }}</p>
                                <p class="mb-0 small text-muted">{{ $submission->email ?? '-' }}</p>
                            @endif
                        </div>
                        
                        <div class="col-md-6">
                            <label class="small text-muted fw-semibold mb-1">NIM</label>
                            <p class="mb-0">{{ $submission->nim ?? '-' }}</p>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="small text-muted fw-semibold mb-1">Program Studi</label>
                            <p class="mb-0">{{ $submission->prodi ?? '-' }}</p>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="small text-muted fw-semibold mb-1">No. HP</label>
                            <p class="mb-0">{{ $submission->no_hp ?? '-' }}</p>
                        </div>
                        
                        <div class="col-md-6">
                            <label class="small text-muted fw-semibold mb-1">Tanggal Pengajuan</label>
                            <p class="mb-0">
                                @if($submission->submitted_at)
                                    {{ $submission->submitted_at->format('d F Y, H:i') }}
                                @elseif($submission->created_at)
                                    {{ $submission->created_at->format('d F Y, H:i') }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                        
                        @if($submission->processed_at)
                        <div class="col-md-6">
                            <label class="small text-muted fw-semibold mb-1">Tanggal Diproses</label>
                            <p class="mb-0">{{ $submission->processed_at->format('d F Y, H:i') }}</p>
                        </div>
                        @endif
                        
                        @if($submission->processed_by)
                        <div class="col-md-6">
                            <label class="small text-muted fw-semibold mb-1">Diproses Oleh</label>
                            <p class="mb-0">{{ $submission->processedBy->name ?? 'Admin' }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Data Form - SAMA SEPERTI FRONTEND! ⭐ -->
            @if($submission->template && is_array($submission->template->form_fields))
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-primary text-white border-bottom-0">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-question-circle me-2"></i>Rincian Pertanyaan & Jawaban
                    </h5>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @foreach($submission->template->form_fields as $index => $field)
                            @php
                                // Cari key name (biasanya field_0, field_1 dst jika tidak diisi manual)
                                $fieldName = $field['name'] ?? 'field_' . $index;
                                // Ambil jawaban dari form_data berdasarkan name tadi
                                $answer = $submission->form_data[$fieldName] ?? '-';
                            @endphp
                            
                            <div class="list-group-item border-start-0 border-end-0 py-4 hover-bg-light">
                                <div class="row align-items-start">
                                    <!-- KOLOM KIRI: PERTANYAAN (Label dari Template) -->
                                    <div class="col-md-4 mb-3 mb-md-0">
                                        <span class="badge bg-secondary bg-opacity-10 text-secondary mb-2">
                                            <i class="fas fa-question-circle me-1"></i>Pertanyaan
                                        </span>
                                        <p class="mb-0 fw-bold text-dark">
                                            {{ $field['label'] ?? 'Pertanyaan ' . ($index + 1) }}
                                        </p>
                                        @if(!empty($field['placeholder']))
                                            <small class="text-muted d-block mt-1">
                                                <i class="fas fa-info-circle me-1"></i>{{ $field['placeholder'] }}
                                            </small>
                                        @endif
                                    </div>
                                    
                                    <!-- KOLOM KANAN: JAWABAN (Value dari form_data) -->
                                    <div class="col-md-8">
                                        <span class="badge bg-success bg-opacity-10 text-success mb-2">
                                            <i class="fas fa-check-circle me-1"></i>Jawaban
                                        </span>
                                        <div class="answer-box">
                                            @if(is_array($answer))
                                                <!-- Array (checkbox/multiple choice) -->
                                                <div class="d-flex flex-wrap gap-2">
                                                    @foreach($answer as $item)
                                                        <span class="badge bg-primary">{{ $item }}</span>
                                                    @endforeach
                                                </div>
                                            @elseif(filter_var($answer, FILTER_VALIDATE_URL) && Str::contains($answer, ['http://', 'https://']))
                                                <!-- URL (file upload) -->
                                                <a href="{{ $answer }}" target="_blank" class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-download me-1"></i>Download File
                                                </a>
                                            @elseif(strlen($answer) > 100)
                                                <!-- Long text (textarea) -->
                                                <div class="bg-light p-3 rounded border">
                                                    <p class="mb-0 text-dark" style="white-space: pre-wrap;">{{ $answer }}</p>
                                                </div>
                                            @else
                                                <!-- Normal text -->
                                                <p class="mb-0 fw-semibold text-dark">
                                                    {{ $answer }}
                                                </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @else
            <!-- FALLBACK: Jika template tidak ada atau form_fields kosong -->
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>Data Form (Fallback)
                    </h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-warning mb-3">
                        <i class="fas fa-info-circle me-2"></i>
                        Template tidak tersedia. Menampilkan data mentah:
                    </div>
                    @if($submission->form_data && count($submission->form_data) > 0)
                        <div class="table-responsive">
                            <table class="table table-sm table-bordered">
                                <thead>
                                    <tr>
                                        <th width="40%">Key</th>
                                        <th width="60%">Value</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($submission->form_data as $key => $value)
                                    <tr>
                                        <td class="fw-bold">{{ $key }}</td>
                                        <td>
                                            @if(is_array($value))
                                                {{ implode(', ', $value) }}
                                            @else
                                                {{ $value }}
                                            @endif
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <p class="text-center text-muted mb-0">Tidak ada data form</p>
                    @endif
                </div>
            </div>
            @endif
            
            <!-- Catatan Admin -->
            @if($submission->admin_notes)
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-sticky-note text-primary me-2"></i>Catatan Admin
                    </h5>
                </div>
                <div class="card-body p-4">
                    <div class="alert alert-{{ $submission->status === 'rejected' ? 'danger' : 'info' }} mb-0">
                        {{ $submission->admin_notes }}
                    </div>
                </div>
            </div>
            @endif
            
            <!-- Download Letter -->
            @if($submission->generated_letter_path)
            <div class="card border-0 shadow-sm mt-4">
                <div class="card-body p-4">
                    <a href="{{ asset('storage/'.$submission->generated_letter_path) }}" 
                       target="_blank"
                       class="btn btn-success w-100">
                        <i class="fas fa-download me-2"></i>Download Surat
                    </a>
                </div>
            </div>
            @endif
        </div>
        
        <!-- Action Panel -->
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm sticky-top" style="top:1rem">
                <div class="card-header bg-white border-bottom">
                    <h5 class="mb-0 fw-bold">
                        <i class="fas fa-bolt text-primary me-2"></i>Aksi
                    </h5>
                </div>
                <div class="card-body p-4">
                    @if($submission->status === 'pending')
                    <div class="mb-3">
                        <!-- Form Approve -->
                        <form action="{{ route('admin.letter-submissions.approve', $submission) }}" method="POST">
                            @csrf
                            <input type="hidden" name="status" value="approved">
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">Catatan (opsional)</label>
                                <textarea name="admin_notes" rows="3" class="form-control" 
                                          placeholder="Tambahkan catatan jika perlu..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-success w-100 mb-2">
                                <i class="fas fa-check me-2"></i>Setujui
                            </button>
                        </form>
                        
                        <hr class="my-3">
                        
                        <!-- Form Reject -->
                        <form action="{{ route('admin.letter-submissions.approve', $submission) }}" 
                              method="POST" 
                              onsubmit="return confirm('Yakin ingin menolak pengajuan ini?')">
                            @csrf
                            <input type="hidden" name="status" value="rejected">
                            <div class="mb-3">
                                <label class="form-label small fw-semibold">
                                    Alasan Penolakan <span class="text-danger">*</span>
                                </label>
                                <textarea name="admin_notes" rows="3" class="form-control" required
                                          placeholder="Berikan alasan penolakan..."></textarea>
                            </div>
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-times me-2"></i>Tolak
                            </button>
                        </form>
                    </div>
                    @else
                    <div class="alert alert-{{ $submission->status === 'approved' ? 'success' : 'danger' }} mb-3">
                        <div class="text-center">
                            <i class="fas fa-{{ $submission->status === 'approved' ? 'check-circle' : 'times-circle' }} fs-3 mb-2"></i>
                            <p class="mb-0 small">
                                Pengajuan ini sudah <strong>{{ $submission->status === 'approved' ? 'disetujui' : 'ditolak' }}</strong>
                            </p>
                            @if($submission->processed_at)
                            <p class="mb-0 small mt-1">
                                pada {{ $submission->processed_at->format('d M Y, H:i') }}
                            </p>
                            @endif
                        </div>
                    </div>
                    @endif
                    
                    <!-- Delete -->
                    <div class="pt-3 border-top">
                        <form action="{{ route('admin.letter-submissions.destroy', $submission) }}" 
                              method="POST" 
                              onsubmit="return confirm('⚠️ Yakin ingin menghapus pengajuan ini?\n\nTindakan ini tidak dapat dibatalkan!')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger w-100">
                                <i class="fas fa-trash me-2"></i>Hapus Pengajuan
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
.card { 
    transition: transform 0.2s; 
}

/* Hover effect untuk list item */
.hover-bg-light:hover {
    background-color: #f8f9fa !important;
}

/* Answer box styling */
.answer-box {
    min-height: 40px;
    display: flex;
    align-items: center;
}

/* Badge styling for Q&A */
.badge.bg-opacity-10 {
    font-weight: 600;
    padding: 4px 10px;
    font-size: 10px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}
</style>
@endsection