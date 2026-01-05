@extends('admin.layouts.app')

@section('title', 'Detail Mahasiswa')

@section('content')
<div class="px-3 py-3">
    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Detail Mahasiswa</h1>
            <p class="text-muted small mb-0">Informasi lengkap mahasiswa</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit me-1"></i> Edit
            </a>
            <a href="{{ route('admin.students.index') }}" class="btn btn-outline-secondary btn-sm">
                <i class="fas fa-arrow-left me-1"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row g-3">
        {{-- LEFT: MAIN INFO --}}
        <div class="col-lg-8">
            {{-- PERSONAL INFO --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 fw-bold text-primary">
                        <i class="fas fa-user me-2"></i>Informasi Pribadi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="text-muted small">NIM</label>
                            <p class="fw-bold mb-0">
                                <span class="badge bg-primary font-monospace">{{ $student->nim }}</span>
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">NIK</label>
                            <p class="fw-bold mb-0">{{ $student->nik ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Nama Lengkap</label>
                            <p class="fw-bold mb-0">{{ $student->nama }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Jenis Kelamin</label>
                            <p class="fw-bold mb-0">
                                @if($student->jenis_kelamin == 'L')
                                    <i class="fas fa-mars text-primary me-1"></i> Laki-laki
                                @else
                                    <i class="fas fa-venus text-danger me-1"></i> Perempuan
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Tanggal Lahir</label>
                            <p class="fw-bold mb-0">
                                {{ $student->tempat_tanggal_lahir ? $student->tempat_tanggal_lahir->format('d F Y') : '-' }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Agama</label>
                            <p class="fw-bold mb-0">{{ $student->agama ?? '-' }}</p>
                        </div>
                        <div class="col-12">
                            <label class="text-muted small">Alamat</label>
                            <p class="fw-bold mb-0">{{ $student->alamat ?? '-' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ACADEMIC INFO --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 fw-bold text-success">
                        <i class="fas fa-graduation-cap me-2"></i>Informasi Akademik
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Program Studi</label>
                            <p class="fw-bold mb-0">{{ $student->program_studi }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Tanggal Masuk</label>
                            <p class="fw-bold mb-0">
                                {{ $student->tanggal_masuk->format('d F Y') }}
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Status</label>
                            <p class="mb-0">{!! $student->status_badge !!}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Jenis Peserta</label>
                            <p class="fw-bold mb-0">{{ $student->jenis ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Biaya Masuk</label>
                            <p class="fw-bold mb-0">
                                @if($student->biaya_masuk)
                                    Rp {{ number_format($student->biaya_masuk, 0, ',', '.') }}
                                @else
                                    -
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Status Sync</label>
                            <p class="mb-0">
                                @if($student->status_sync == 'Sudah Sync')
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Sudah Sync
                                    </span>
                                @else
                                    <span class="badge bg-warning">
                                        <i class="fas fa-clock me-1"></i>Belum Sync
                                    </span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- ACCOUNT INFO --}}
            <div class="card shadow-sm">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 fw-bold text-info">
                        <i class="fas fa-user-circle me-2"></i>Informasi Akun
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label class="text-muted small">Status Akun</label>
                            <p class="mb-0">
                                @if($student->user->is_active)
                                    <span class="badge bg-success">
                                        <i class="fas fa-check-circle me-1"></i>Aktif
                                    </span>
                                @else
                                    <span class="badge bg-danger">
                                        <i class="fas fa-times-circle me-1"></i>Nonaktif
                                    </span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Last Login</label>
                            <p class="fw-bold mb-0">
                                @if($student->user->last_login_at)
                                    {{ $student->user->last_login_at->diffForHumans() }}
                                    <br>
                                    <small class="text-muted">{{ $student->user->last_login_at->format('d M Y, H:i') }}</small>
                                @else
                                    <span class="text-muted">Belum pernah login</span>
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="text-muted small">Terdaftar Sejak</label>
                            <p class="fw-bold mb-0">
                                {{ $student->created_at->format('d F Y') }}
                                <br>
                                <small class="text-muted">{{ $student->created_at->diffForHumans() }}</small>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- RIGHT: ACTIONS & INFO --}}
        <div class="col-lg-4">
            {{-- QUICK ACTIONS --}}
            <div class="card shadow-sm mb-3">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 fw-bold">Aksi Cepat</h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.students.edit', $student) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit me-2"></i>Edit Data
                        </a>
                        
                        @if($student->user->is_active)
                            <button class="btn btn-outline-secondary btn-sm" disabled>
                                <i class="fas fa-ban me-2"></i>Nonaktifkan Akun
                            </button>
                        @else
                            <button class="btn btn-outline-success btn-sm" disabled>
                                <i class="fas fa-check me-2"></i>Aktifkan Akun
                            </button>
                        @endif

                        <hr class="my-2">

                        <form action="{{ route('admin.students.destroy', $student) }}" 
                              method="POST"
                              onsubmit="return confirm('PERINGATAN!\n\nMenghapus mahasiswa akan menghapus:\n- Data mahasiswa\n- Akun user\n- Riwayat login\n\nYakin ingin melanjutkan?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm w-100">
                                <i class="fas fa-trash me-2"></i>Hapus Mahasiswa
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- LOGIN CREDENTIALS --}}
            <div class="card shadow-sm border-warning mb-3">
                <div class="card-header py-3 bg-warning bg-opacity-10">
                    <h6 class="m-0 fw-bold text-warning">
                        <i class="fas fa-key me-2"></i>Kredensial Login
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Username</label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control font-monospace" value="{{ $student->nim }}" readonly>
                            <button class="btn btn-outline-secondary" type="button" onclick="copyToClipboard('{{ $student->nim }}')">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                    </div>
                    <div class="mb-0">
                        <label class="text-muted small">Password Default</label>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control font-monospace" 
                                   value="{{ $student->tempat_tanggal_lahir ? $student->tempat_tanggal_lahir->format('dmY') : '-' }}" 
                                   readonly>
                            <button class="btn btn-outline-secondary" type="button" 
                                    onclick="copyToClipboard('{{ $student->tempat_tanggal_lahir ? $student->tempat_tanggal_lahir->format('dmY') : '' }}')">
                                <i class="fas fa-copy"></i>
                            </button>
                        </div>
                        <small class="text-muted">Format: DDMMYYYY dari tanggal lahir</small>
                    </div>
                </div>
            </div>

            {{-- TIMELINE --}}
            <div class="card shadow-sm">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 fw-bold">Timeline</h6>
                </div>
                <div class="card-body">
                    <div class="timeline">
                        <div class="timeline-item mb-3">
                            <div class="d-flex">
                                <div class="timeline-marker bg-success"></div>
                                <div class="ms-3 flex-fill">
                                    <p class="small text-muted mb-1">Terdaftar</p>
                                    <p class="small fw-bold mb-0">{{ $student->created_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        </div>

                        @if($student->user->last_login_at)
                        <div class="timeline-item mb-3">
                            <div class="d-flex">
                                <div class="timeline-marker bg-primary"></div>
                                <div class="ms-3 flex-fill">
                                    <p class="small text-muted mb-1">Last Login</p>
                                    <p class="small fw-bold mb-0">{{ $student->user->last_login_at->format('d M Y, H:i') }}</p>
                                </div>
                            </div>
                        </div>
                        @endif

                        <div class="timeline-item">
                            <div class="d-flex">
                                <div class="timeline-marker bg-info"></div>
                                <div class="ms-3 flex-fill">
                                    <p class="small text-muted mb-1">Last Update</p>
                                    <p class="small fw-bold mb-0">{{ $student->updated_at->format('d M Y, H:i') }}</p>
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
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show toast or alert
        alert('Disalin ke clipboard: ' + text);
    });
}
</script>
@endpush

<style>
.timeline-marker {
    width: 12px;
    height: 12px;
    border-radius: 50%;
    flex-shrink: 0;
    margin-top: 4px;
}
</style>
@endsection