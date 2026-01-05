@extends('admin.layouts.app')

@section('title', 'Detail Beasiswa')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.scholarships.index') }}" class="text-blue-600 hover:underline mb-2 inline-block">
        ← Kembali
    </a>
    <div class="flex justify-between items-start">
        <h1 class="text-2xl font-bold">Detail Beasiswa</h1>
        <div class="flex gap-2">
            <a href="{{ route('admin.scholarships.edit', $scholarship) }}" 
               class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 inline-flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                Edit
            </a>
            <form action="{{ route('admin.scholarships.destroy', $scholarship) }}" 
                  method="POST" 
                  onsubmit="return confirm('Yakin ingin menghapus beasiswa ini?')">
                @csrf
                @method('DELETE')
                <button type="submit" 
                        class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600 inline-flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                    </svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <!-- Main Content -->
    <div class="lg:col-span-2 space-y-6">
        <!-- Header Info -->
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <!-- Poster -->
            @if($scholarship->poster)
                <div class="relative h-80 bg-gradient-to-br from-blue-500 to-purple-600">
                    <img src="{{ asset('storage/' . $scholarship->poster) }}" 
                         class="w-full h-full object-contain"
                         alt="{{ $scholarship->name }}">
                    
                    <!-- Badges Overlay -->
                    <div class="absolute top-4 right-4">
                        {!! $scholarship->getStatusBadge() !!}
                    </div>
                    
                    @if($scholarship->is_featured)
                        <div class="absolute top-4 left-4">
                            <span class="px-3 py-1 bg-yellow-400 text-yellow-900 text-sm font-bold rounded">⭐ Featured</span>
                        </div>
                    @endif
                </div>
            @else
                <div class="h-80 bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center">
                    <svg class="w-32 h-32 text-white opacity-50" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
            @endif

            <div class="p-6">
                <div class="flex items-center gap-2 mb-4">
                    <span class="px-3 py-1 text-sm font-semibold rounded {{ $scholarship->getCategoryBadgeColor() }}">
                        {{ \App\Models\Scholarship::categories()[$scholarship->category] }}
                    </span>
                    <span class="px-3 py-1 text-sm font-semibold bg-purple-100 text-purple-800 rounded">
                        {{ \App\Models\Scholarship::types()[$scholarship->type] }}
                    </span>
                </div>

                <h2 class="text-3xl font-bold text-gray-900 mb-4">{{ $scholarship->name }}</h2>

                @if($scholarship->provider)
                    <div class="flex items-center text-gray-600 mb-2">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                        <span class="font-medium">{{ $scholarship->provider }}</span>
                    </div>
                @endif

                <div class="flex items-center text-2xl font-bold text-green-600 mb-4">
                    <svg class="w-8 h-8 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    {{ $scholarship->getFormattedAmount() }}
                </div>

                <!-- Stats -->
                <div class="grid grid-cols-3 gap-4 mb-6">
                    @if($scholarship->quota)
                        <div class="text-center p-4 bg-blue-50 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600">{{ $scholarship->quota }}</div>
                            <div class="text-sm text-gray-600">Kuota</div>
                        </div>
                    @endif
                    
                    <div class="text-center p-4 bg-purple-50 rounded-lg">
                        <div class="text-2xl font-bold text-purple-600">{{ $scholarship->views }}</div>
                        <div class="text-sm text-gray-600">Views</div>
                    </div>

                    @if($scholarship->getRemainingDays())
                        <div class="text-center p-4 bg-red-50 rounded-lg">
                            <div class="text-2xl font-bold text-red-600">{{ $scholarship->getRemainingDays() }}</div>
                            <div class="text-sm text-gray-600">Hari Tersisa</div>
                        </div>
                    @endif
                </div>

                <!-- Deskripsi -->
                <div class="mb-6">
                    <h3 class="font-bold text-lg mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Deskripsi
                    </h3>
                    <div class="prose max-w-none text-gray-700">
                        {!! nl2br(e($scholarship->description)) !!}
                    </div>
                </div>

                <!-- Persyaratan -->
                <div class="mb-6">
                    <h3 class="font-bold text-lg mb-3 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        Persyaratan
                    </h3>
                    <div class="bg-gray-50 rounded-lg p-4">
                        <div class="prose max-w-none text-gray-700">
                            {!! nl2br(e($scholarship->requirements)) !!}
                        </div>
                    </div>
                </div>

                <!-- Link Website -->
                @if($scholarship->website_url)
                    <div class="mt-6">
                        <a href="{{ $scholarship->website_url }}" 
                           target="_blank"
                           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-medium">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path>
                            </svg>
                            Kunjungi Website / Daftar
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="space-y-6">
        <!-- Timeline -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-bold text-lg mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Timeline
            </h3>
            <div class="space-y-4">
                @if($scholarship->registration_start)
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                            <span class="text-blue-600 font-bold">📅</span>
                        </div>
                        <div class="ml-3">
                            <div class="text-sm font-medium text-gray-900">Buka Pendaftaran</div>
                            <div class="text-sm text-gray-500">{{ $scholarship->registration_start->format('d M Y') }}</div>
                        </div>
                    </div>
                @endif

                @if($scholarship->registration_end)
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                            <span class="text-red-600 font-bold">⏰</span>
                        </div>
                        <div class="ml-3">
                            <div class="text-sm font-medium text-gray-900">Tutup Pendaftaran</div>
                            <div class="text-sm text-gray-500">{{ $scholarship->registration_end->format('d M Y') }}</div>
                        </div>
                    </div>
                @endif

                @if($scholarship->announcement_date)
                    <div class="flex items-start">
                        <div class="flex-shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                            <span class="text-green-600 font-bold">📢</span>
                        </div>
                        <div class="ml-3">
                            <div class="text-sm font-medium text-gray-900">Pengumuman</div>
                            <div class="text-sm text-gray-500">{{ $scholarship->announcement_date->format('d M Y') }}</div>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Kontak -->
        @if($scholarship->contact_person || $scholarship->contact_phone || $scholarship->contact_email)
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-bold text-lg mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
                Kontak
            </h3>
            <div class="space-y-3">
                @if($scholarship->contact_person)
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-3 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <div>
                            <div class="text-xs text-gray-500">Contact Person</div>
                            <div class="text-sm font-medium">{{ $scholarship->contact_person }}</div>
                        </div>
                    </div>
                @endif

                @if($scholarship->contact_phone)
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-3 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path>
                        </svg>
                        <div>
                            <div class="text-xs text-gray-500">WhatsApp</div>
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $scholarship->contact_phone) }}" 
                               target="_blank"
                               class="text-sm font-medium text-green-600 hover:underline">
                                {{ $scholarship->contact_phone }}
                            </a>
                        </div>
                    </div>
                @endif

                @if($scholarship->contact_email)
                    <div class="flex items-start">
                        <svg class="w-5 h-5 mr-3 text-gray-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                        <div>
                            <div class="text-xs text-gray-500">Email</div>
                            <a href="mailto:{{ $scholarship->contact_email }}" 
                               class="text-sm font-medium text-blue-600 hover:underline break-all">
                                {{ $scholarship->contact_email }}
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
        @endif

        <!-- Status -->
        <div class="bg-white rounded-lg shadow p-6">
            <h3 class="font-bold text-lg mb-4">Status</h3>
            <div class="space-y-3">
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Publikasi</span>
                    @if($scholarship->is_active)
                        <span class="px-3 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Aktif</span>
                    @else
                        <span class="px-3 py-1 text-xs font-semibold text-gray-800 bg-gray-100 rounded-full">Nonaktif</span>
                    @endif
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Featured</span>
                    @if($scholarship->is_featured)
                        <span class="px-3 py-1 text-xs font-semibold text-yellow-800 bg-yellow-100 rounded-full">Ya</span>
                    @else
                        <span class="px-3 py-1 text-xs font-semibold text-gray-800 bg-gray-100 rounded-full">Tidak</span>
                    @endif
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Dibuat</span>
                    <span class="text-sm text-gray-900">{{ $scholarship->created_at->format('d M Y') }}</span>
                </div>
                <div class="flex items-center justify-between">
                    <span class="text-sm text-gray-600">Update Terakhir</span>
                    <span class="text-sm text-gray-900">{{ $scholarship->updated_at->format('d M Y') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection