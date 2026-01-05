@extends('admin.layouts.app')

@section('title', 'Data Mahasiswa')

@push('styles')
<style>
    .student-card {
        transition: all 0.2s;
    }
    
    .student-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    }
</style>
@endpush

@section('content')
<div class="px-3 py-3">
    {{-- HEADER --}}
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center gap-3 mb-3">
        <div>
            <h1 class="h4 fw-bold mb-1">Data Mahasiswa</h1>
            <p class="text-muted small mb-0">Kelola data mahasiswa yang terdaftar</p>
        </div>
        <div class="d-flex gap-2">
            <a href="{{ route('admin.students.import-form') }}" class="btn btn-success btn-sm">
                <i class="fas fa-file-excel me-2"></i>Import Excel
            </a>
            <a href="{{ route('admin.students.create') }}" class="btn btn-primary btn-sm">
                <i class="fas fa-plus me-2"></i>Tambah Manual
            </a>
        </div>
    </div>

    {{-- SUCCESS/ERROR MESSAGES --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-3" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert">
            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    {{-- FILTER & SEARCH --}}
    <div class="card shadow-sm mb-3">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.students.index') }}" class="row g-3">
                {{-- Search --}}
                <div class="col-md-4">
                    <input type="text" name="search" class="form-control form-control-sm" 
                           placeholder="Cari NIM, Nama, NIK..." value="{{ request('search') }}">
                </div>

                {{-- Filter Program Studi --}}
                <div class="col-md-3">
                    <select name="prodi" class="form-select form-select-sm">
                        <option value="">Semua Program Studi</option>
                        @foreach($prodis as $prodi)
                            <option value="{{ $prodi }}" {{ request('prodi') == $prodi ? 'selected' : '' }}>
                                {{ $prodi }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Filter Status --}}
                <div class="col-md-3">
                    <select name="status" class="form-select form-select-sm">
                        <option value="">Semua Status</option>
                        <option value="AKTIF" {{ request('status') == 'AKTIF' ? 'selected' : '' }}>Aktif</option>
                        <option value="CUTI" {{ request('status') == 'CUTI' ? 'selected' : '' }}>Cuti</option>
                        <option value="LULUS" {{ request('status') == 'LULUS' ? 'selected' : '' }}>Lulus</option>
                        <option value="KELUAR" {{ request('status') == 'KELUAR' ? 'selected' : '' }}>Keluar</option>
                    </select>
                </div>

                {{-- Buttons --}}
                <div class="col-md-2">
                    <div class="d-flex gap-1">
                        <button type="submit" class="btn btn-primary btn-sm flex-fill">
                            <i class="fas fa-search"></i>
                        </button>
                        <a href="{{ route('admin.students.index') }}" class="btn btn-secondary btn-sm">
                            <i class="fas fa-redo"></i>
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- STATS CARDS --}}
    <div class="row g-2 g-md-3 mb-3">
        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Total</p>
                            <h3 class="h5 fw-bold mb-0">{{ $students->total() }}</h3>
                        </div>
                        <div class="bg-primary bg-opacity-10 p-2 rounded">
                            <i class="fas fa-users text-primary" style="font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Aktif</p>
                            <h3 class="h5 fw-bold mb-0 text-success">{{ $students->where('status', 'AKTIF')->count() }}</h3>
                        </div>
                        <div class="bg-success bg-opacity-10 p-2 rounded">
                            <i class="fas fa-check-circle text-success" style="font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Cuti</p>
                            <h3 class="h5 fw-bold mb-0 text-warning">{{ $students->where('status', 'CUTI')->count() }}</h3>
                        </div>
                        <div class="bg-warning bg-opacity-10 p-2 rounded">
                            <i class="fas fa-pause-circle text-warning" style="font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-6 col-md-3">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-2 p-md-3">
                    <div class="d-flex align-items-center justify-content-between">
                        <div>
                            <p class="text-muted mb-1 fw-medium" style="font-size: 0.7rem;">Lulus</p>
                            <h3 class="h5 fw-bold mb-0 text-info">{{ $students->where('status', 'LULUS')->count() }}</h3>
                        </div>
                        <div class="bg-info bg-opacity-10 p-2 rounded">
                            <i class="fas fa-graduation-cap text-info" style="font-size: 1.25rem;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- STUDENTS TABLE --}}
    <div class="card shadow-sm">
        <div class="card-header py-3 bg-white">
            <h6 class="m-0 fw-bold text-primary">
                <i class="fas fa-table me-2"></i>Daftar Mahasiswa
                <span class="badge bg-primary ms-2">{{ $students->total() }}</span>
            </h6>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th class="py-3 px-3" style="width: 5%;">No</th>
                            <th class="py-3">NIM</th>
                            <th class="py-3">Nama</th>
                            <th class="py-3">Program Studi</th>
                            <th class="py-3">Status</th>
                            <th class="py-3">Tanggal Masuk</th>
                            <th class="py-3 text-center" style="width: 10%;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($students as $index => $student)
                            <tr>
                                <td class="px-3">{{ $students->firstItem() + $index }}</td>
                                <td>
                                    <span class="badge bg-light text-dark font-monospace">{{ $student->nim }}</span>
                                </td>
                                <td>
                                    <div class="fw-semibold">{{ $student->nama }}</div>
                                    <small class="text-muted">{{ $student->jenis_kelamin == 'P' ? 'Perempuan' : 'Laki-laki' }}</small>
                                </td>
                                <td>{{ $student->program_studi }}</td>
                                <td>{!! $student->status_badge !!}</td>
                                <td>
                                    <small>{{ $student->tanggal_masuk->format('d M Y') }}</small>
                                </td>
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                        <a href="{{ route('admin.students.show', $student) }}" 
                                           class="btn btn-sm btn-outline-info"
                                           title="Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.students.edit', $student) }}" 
                                           class="btn btn-sm btn-outline-warning"
                                           title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('admin.students.destroy', $student) }}" 
                                              method="POST" 
                                              class="d-inline"
                                              onsubmit="return confirm('Yakin ingin menghapus mahasiswa {{ $student->nama }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" 
                                                    class="btn btn-sm btn-outline-danger"
                                                    title="Hapus">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-5">
                                    <i class="fas fa-users text-muted mb-3" style="font-size: 3rem;"></i>
                                    <p class="text-muted mb-2">Belum ada data mahasiswa</p>
                                    <a href="{{ route('admin.students.import-form') }}" class="btn btn-primary btn-sm">
                                        <i class="fas fa-file-excel me-1"></i>Import Excel
                                    </a>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- PAGINATION --}}
    @if($students->hasPages())
        <div class="mt-4">
            {{ $students->links() }}
        </div>
    @endif
</div>
@endsection