@extends('admin.layouts.app')

@section('title', 'Kelola Pengajuan Surat')

@section('content')
<div class="container-fluid px-4 py-4">

    {{-- HEADER & SEARCH --}}
    <div class="row align-items-center mb-4 g-3">
        <div class="col-md-6">
            <h1 class="h3 fw-bold mb-1">Pengajuan Surat</h1>
            <p class="text-muted mb-0">Kelola data pengajuan surat mahasiswa</p>
        </div>
        <div class="col-md-6">
            <form action="{{ route('admin.letter-submissions.index') }}" method="GET">
                @if(request('status')) <input type="hidden" name="status" value="{{ request('status') }}"> @endif
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0 text-muted">
                        <i class="fas fa-search"></i>
                    </span>
                    <input type="text" name="search" class="form-control border-start-0 ps-0" 
                           value="{{ request('search') }}" 
                           placeholder="Cari Nama / NIM / Prodi...">
                    <button class="btn btn-primary px-4" type="submit">Cari</button>
                </div>
            </form>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="row g-3 mb-4">
        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-primary bg-opacity-10 text-primary rounded p-3">
                        <i class="fas fa-folder fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0 fw-bold text-uppercase">Total</p>
                        <h4 class="mb-0 fw-bold">{{ $stats['total'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-warning bg-opacity-10 text-warning rounded p-3">
                        <i class="fas fa-clock fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0 fw-bold text-uppercase">Menunggu</p>
                        <h4 class="mb-0 fw-bold">{{ $stats['pending'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-success bg-opacity-10 text-success rounded p-3">
                        <i class="fas fa-check-circle fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0 fw-bold text-uppercase">Disetujui</p>
                        <h4 class="mb-0 fw-bold">{{ $stats['approved'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-6 col-xl-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="bg-danger bg-opacity-10 text-danger rounded p-3">
                        <i class="fas fa-times-circle fa-lg"></i>
                    </div>
                    <div>
                        <p class="text-muted small mb-0 fw-bold text-uppercase">Ditolak</p>
                        <h4 class="mb-0 fw-bold">{{ $stats['rejected'] }}</h4>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- TABEL UTAMA --}}
    <div class="card border-0 shadow-sm">
        {{-- TAB NAVIGASI --}}
        <div class="card-header bg-white pt-3 px-3 pb-0 border-bottom">
            <ul class="nav nav-tabs card-header-tabs border-bottom-0">
                <li class="nav-item">
                    <a class="nav-link {{ !request('status') ? 'active fw-bold' : 'text-muted' }}" 
                       href="{{ route('admin.letter-submissions.index') }}">Semua</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === 'pending' ? 'active fw-bold text-warning' : 'text-muted' }}" 
                       href="{{ route('admin.letter-submissions.index', ['status' => 'pending']) }}">
                        Menunggu <span class="badge bg-warning text-dark ms-1 rounded-pill">{{ $stats['pending'] }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === 'approved' ? 'active fw-bold text-success' : 'text-muted' }}" 
                       href="{{ route('admin.letter-submissions.index', ['status' => 'approved']) }}">Disetujui</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ request('status') === 'rejected' ? 'active fw-bold text-danger' : 'text-muted' }}" 
                       href="{{ route('admin.letter-submissions.index', ['status' => 'rejected']) }}">Ditolak</a>
                </li>
            </ul>
        </div>

        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="px-4 py-3 border-bottom-0">Pemohon</th>
                            <th class="px-4 py-3 border-bottom-0">Program Studi</th>
                            <th class="px-4 py-3 border-bottom-0">Jenis Surat</th>
                            <th class="px-4 py-3 border-bottom-0 text-center">Status</th>
                            <th class="px-4 py-3 border-bottom-0 text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($submissions as $submission)
                        
                        {{-- LOGIKA PENCARIAN DATA (Sama persis dengan halaman SHOW) --}}
                        @php
                            // 1. Cari Nama & Initial
                            $nama = $submission->nama_mahasiswa ?? ($submission->user->name ?? 'User');
                            $initial = strtoupper(substr($nama, 0, 1));
                            $colors = ['primary', 'success', 'danger', 'warning', 'info', 'dark'];
                            $randomColor = $colors[rand(0, 5)]; 

                            // 2. Cari Program Studi (Jurusan)
                            $prodi = '-';
                            if (!empty($submission->jurusan)) {
                                $prodi = $submission->jurusan;
                            } elseif (!empty($submission->prodi)) {
                                $prodi = $submission->prodi;
                            } elseif ($submission->user && !empty($submission->user->jurusan)) {
                                $prodi = $submission->user->jurusan;
                            } elseif ($submission->user && $submission->user->student && !empty($submission->user->student->prodi)) {
                                $prodi = $submission->user->student->prodi;
                            }

                            // 3. Cari/Hitung Semester
                            $semester = '-';
                            if (!empty($submission->semester)) {
                                $semester = $submission->semester;
                            } elseif ($submission->user && !empty($submission->user->semester)) {
                                $semester = $submission->user->semester;
                            } elseif ($submission->user && $submission->user->student && $submission->user->student->tanggal_masuk) {
                                try {
                                    $tanggalMasuk = \Carbon\Carbon::parse($submission->user->student->tanggal_masuk);
                                    $selisihBulan = $tanggalMasuk->diffInMonths(now());
                                    $hitungSemester = ceil(($selisihBulan + 1) / 6);
                                    $semester = max(1, $hitungSemester);
                                } catch (\Exception $e) { $semester = '?'; }
                            }
                        @endphp

                        <tr>
                            {{-- KOLOM PEMOHON --}}
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-{{ $randomColor }} bg-opacity-10 text-{{ $randomColor }} d-flex justify-content-center align-items-center fw-bold me-3" 
                                         style="width: 40px; height: 40px; font-size: 16px;">
                                        {{ $initial }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $nama }}</div>
                                        <div class="small text-muted">{{ $submission->nim ?? ($submission->user->nim ?? '-') }}</div>
                                    </div>
                                </div>
                            </td>

                            {{-- KOLOM PRODI & SEMESTER --}}
                            <td class="px-4 py-3">
                                <div class="fw-bold text-dark mb-1">{{ $prodi }}</div>
                                @if($semester != '-' && $semester != '?')
                                    <span class="badge bg-info bg-opacity-10 text-info border border-info rounded-pill">
                                        Semester {{ $semester }}
                                    </span>
                                @else
                                    <small class="text-muted">Semester -</small>
                                @endif
                            </td>

                            {{-- KOLOM JENIS SURAT --}}
                            <td class="px-4 py-3">
                                <div class="fw-semibold text-dark">{{ $submission->template->title ?? '-' }}</div>
                                <div class="small text-muted">
                                    <i class="far fa-clock me-1"></i>{{ $submission->created_at->format('d/m/Y H:i') }}
                                </div>
                            </td>

                            {{-- KOLOM STATUS --}}
                            <td class="px-4 py-3 text-center">
                                @if($submission->status === 'pending')
                                    <span class="badge rounded-pill bg-warning text-dark px-3">Menunggu</span>
                                @elseif($submission->status === 'approved')
                                    <span class="badge rounded-pill bg-success px-3">Disetujui</span>
                                @elseif($submission->status === 'rejected')
                                    <span class="badge rounded-pill bg-danger px-3">Ditolak</span>
                                @else
                                    <span class="badge rounded-pill bg-secondary">{{ $submission->status }}</span>
                                @endif
                            </td>

                            {{-- KOLOM AKSI (REVISI: HANYA LINK KE SHOW) --}}
                            <td class="px-4 py-3 text-end">
                                @if($submission->status === 'pending')
                                    {{-- JIKA PENDING: Tombol Menonjol (Perlu Tindakan) --}}
                                    <a href="{{ route('admin.letter-submissions.show', $submission) }}" 
                                       class="btn btn-sm btn-primary shadow-sm px-3 fw-semibold">
                                        <i class="fas fa-file-contract me-2"></i>Tinjau
                                    </a>
                                @else
                                    {{-- JIKA SUDAH SELESAI: Tombol Biasa (Hanya Lihat) --}}
                                    <a href="{{ route('admin.letter-submissions.show', $submission) }}" 
                                       class="btn btn-sm btn-outline-secondary px-3">
                                        <i class="fas fa-eye me-2"></i>Detail
                                    </a>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <div class="text-muted">
                                    <i class="fas fa-inbox fa-3x mb-3 opacity-50"></i>
                                    <p class="mb-0">Belum ada data pengajuan surat.</p>
                                </div>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- PAGINATION --}}
            @if($submissions->hasPages())
            <div class="card-footer bg-white py-3">
                {{ $submissions->withQueryString()->links() }}
            </div>
            @endif
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Hanya inisialisasi Tooltip, JS Modal sudah dihapus
    var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
    var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
        return new bootstrap.Tooltip(tooltipTriggerEl)
    })
</script>
@endpush