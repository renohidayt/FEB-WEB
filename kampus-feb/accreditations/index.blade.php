@extends('admin.layouts.app')

@section('title', 'Kelola Akreditasi')

@section('content')
<div class="mb-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
    <h1 class="text-2xl font-bold">Kelola Akreditasi</h1>
    <a href="{{ route('admin.accreditations.create') }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 inline-flex items-center">
        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Tambah Akreditasi
    </a>
</div>

@if(session('success'))
    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
        {{ session('success') }}
    </div>
@endif

<!-- Stats Cards -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-sm text-gray-600 mb-1">Total Akreditasi</div>
        <div class="text-2xl font-bold text-gray-900">{{ $stats['total'] }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-sm text-gray-600 mb-1">Aktif</div>
        <div class="text-2xl font-bold text-green-600">{{ $stats['active'] }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-sm text-gray-600 mb-1">Akan Expired</div>
        <div class="text-2xl font-bold text-yellow-600">{{ $stats['expiring'] }}</div>
    </div>
    <div class="bg-white rounded-lg shadow p-6">
        <div class="text-sm text-gray-600 mb-1">Expired</div>
        <div class="text-2xl font-bold text-red-600">{{ $stats['expired'] }}</div>
    </div>
</div>

<!-- Filter -->
<div class="mb-4 flex flex-wrap gap-2">
    <a href="{{ route('admin.accreditations.index') }}" 
       class="px-4 py-2 rounded-lg text-sm font-medium {{ !request('status') && !request('grade') ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
        Semua
    </a>
    <a href="{{ route('admin.accreditations.index', ['status' => 'active']) }}" 
       class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'active' ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
        Aktif
    </a>
    <a href="{{ route('admin.accreditations.index', ['status' => 'expiring']) }}" 
       class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'expiring' ? 'bg-yellow-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
        Akan Expired
    </a>
    <a href="{{ route('admin.accreditations.index', ['status' => 'expired']) }}" 
       class="px-4 py-2 rounded-lg text-sm font-medium {{ request('status') === 'expired' ? 'bg-red-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
        Expired
    </a>
    
    <div class="border-l pl-2"></div>
    
    <a href="{{ route('admin.accreditations.index', ['grade' => 'A']) }}" 
       class="px-4 py-2 rounded-lg text-sm font-medium {{ request('grade') === 'A' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
        Grade A
    </a>
    <a href="{{ route('admin.accreditations.index', ['grade' => 'Unggul']) }}" 
       class="px-4 py-2 rounded-lg text-sm font-medium {{ request('grade') === 'Unggul' ? 'bg-blue-500 text-white' : 'bg-gray-200 text-gray-700 hover:bg-gray-300' }}">
        Unggul
    </a>
</div>

<!-- Table -->
<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
            <tr>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Program Studi</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Grade</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Lembaga</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Berlaku Sampai</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Status</th>
                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase">Aksi</th>
            </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-200">
            @forelse($accreditations as $item)
            <tr class="{{ $item->isExpired() ? 'bg-red-50' : '' }}">
                <td class="px-6 py-4">
                    <div class="font-medium text-gray-900">{{ $item->study_program }}</div>
                    @if($item->certificate_number)
                        <div class="text-sm text-gray-500">No: {{ $item->certificate_number }}</div>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <span class="px-3 py-1 text-sm font-semibold rounded-full {{ $item->getGradeBadgeColor() }}">
                        {{ $item->grade }}
                    </span>
                </td>
                <td class="px-6 py-4 text-sm text-gray-500">
                    {{ $item->accreditation_body }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">
                    {{ $item->valid_until->format('d M Y') }}
                    @if($item->isExpiringSoon() && !$item->isExpired())
                        <span class="block text-xs text-yellow-600">⚠️ Akan expired</span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($item->isExpired())
                        <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Expired</span>
                    @else
                        <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Aktif</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm">
                    <div class="flex items-center gap-2">
                        <a href="{{ asset('storage/' . $item->certificate_file) }}" 
                           target="_blank"
                           class="text-blue-600 hover:underline">
                            Lihat
                        </a>
                        <a href="{{ route('admin.accreditations.edit', $item) }}" 
                           class="text-yellow-600 hover:underline">
                            Edit
                        </a>
                        <form action="{{ route('admin.accreditations.destroy', $item) }}" 
                              method="POST" 
                              class="inline"
                              onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:underline">
                                Hapus
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-6 py-8 text-center text-gray-500">
                    <svg class="w-16 h-16 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <p>Belum ada data akreditasi</p>
                    <a href="{{ route('admin.accreditations.create') }}" class="text-blue-600 hover:underline mt-2 inline-block">
                        Tambah akreditasi pertama
                    </a>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $accreditations->links() }}
</div>
@endsection