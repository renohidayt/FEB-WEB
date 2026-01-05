@extends('layouts.app')

@section('title', 'Akreditasi Perguruan Tinggi - STIE Sebelas April')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-br from-blue-600 via-indigo-600 to-blue-800 text-white py-20">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute top-0 left-0 w-96 h-96 bg-white rounded-full blur-3xl"></div>
    </div>
    
    <div class="container mx-auto px-4 relative z-10">
        <!-- Breadcrumb -->
        <div class="mb-8">
            <nav class="flex items-center gap-2 text-blue-100">
                <a href="{{ route('profile.accreditation.index') }}" class="hover:text-white transition">Akreditasi</a>
                <i class="fas fa-chevron-right text-xs"></i>
                <span class="text-white font-semibold">Perguruan Tinggi</span>
            </nav>
        </div>
        
        <div class="max-w-4xl mx-auto text-center">
            <div class="inline-flex items-center justify-center w-20 h-20 bg-white/10 backdrop-blur-sm rounded-2xl mb-6">
                <i class="fas fa-university text-5xl"></i>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Akreditasi Perguruan Tinggi</h1>
            <p class="text-xl text-blue-100">
                Status akreditasi institusi STIE Sebelas April Sumedang
            </p>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">

            @if($currentAccreditation)
            <!-- Current Accreditation Card -->
            <div class="bg-gradient-to-br from-white to-blue-50 rounded-3xl shadow-2xl p-10 mb-12 border-t-4 border-blue-600">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-16 h-16 bg-blue-600 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-star text-white text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">Akreditasi Saat Ini</h2>
                        <p class="text-gray-600">Status akreditasi institusi terkini</p>
                    </div>
                </div>

                <div class="grid md:grid-cols-2 gap-8">
                    <!-- Left Column -->
                    <div class="space-y-6">
                        <!-- Institution Name -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg">
                            <div class="flex items-center gap-4 mb-4">
                                <div class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center">
                                    <i class="fas fa-university text-blue-600 text-xl"></i>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Institusi</p>
                                    <h3 class="text-xl font-bold text-gray-800">{{ $currentAccreditation->study_program }}</h3>
                                </div>
                            </div>
                        </div>

                        <!-- Grade Badge -->
                        <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-2xl p-8 text-white shadow-lg">
                            <div class="text-center">
                                <p class="text-emerald-100 mb-3 text-lg">Peringkat Akreditasi</p>
                                <div class="w-24 h-24 bg-white rounded-2xl flex items-center justify-center mx-auto mb-4 shadow-xl">
                                    <span class="text-6xl font-bold text-emerald-600">{{ $currentAccreditation->grade }}</span>
                                </div>
                                <p class="text-2xl font-bold">{{ $currentAccreditation->grade == 'Baik' ? 'Baik' : ($currentAccreditation->grade == 'Baik Sekali' ? 'Baik Sekali' : 'Unggul') }}</p>
                            </div>
                        </div>
                    </div>

                    <!-- Right Column -->
                    <div class="space-y-4">
                        <!-- Accreditation Body -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-blue-500">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-600">Lembaga Akreditasi</span>
                                <i class="fas fa-shield-alt text-blue-600"></i>
                            </div>
                            <p class="text-xl font-bold text-gray-800">{{ $currentAccreditation->accreditation_body }}</p>
                        </div>

                        <!-- Certificate Number -->
                        @if($currentAccreditation->certificate_number)
                        <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-indigo-500">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-600">Nomor Sertifikat</span>
                                <i class="fas fa-file-certificate text-indigo-600"></i>
                            </div>
                            <p class="text-lg font-mono text-gray-800">{{ $currentAccreditation->certificate_number }}</p>
                        </div>
                        @endif

                        <!-- Valid Period -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg border-l-4 border-green-500">
                            <div class="flex items-center justify-between mb-2">
                                <span class="text-gray-600">Masa Berlaku</span>
                                <i class="fas fa-calendar-check text-green-600"></i>
                            </div>
                            @if($currentAccreditation->valid_from)
                            <p class="text-sm text-gray-600 mb-1">
                                <i class="fas fa-arrow-right text-xs mr-2"></i>
                                {{ $currentAccreditation->valid_from->format('d F Y') }}
                            </p>
                            @endif
                            <p class="text-lg font-bold text-gray-800">
                                Sampai {{ $currentAccreditation->valid_until->format('d F Y') }}
                            </p>
                            @if(!$currentAccreditation->isExpired())
                            <p class="text-sm text-green-600 mt-2">
                                <i class="fas fa-check-circle mr-1"></i>
                                Masih berlaku ({{ $currentAccreditation->remaining_days }} hari lagi)
                            </p>
                            @endif
                        </div>

                        <!-- Download Button -->
                        @if($currentAccreditation->certificate_file)
                        <a href="{{ route('profile.accreditation.download', $currentAccreditation->slug) }}" 
                           class="block bg-gradient-to-r from-blue-600 to-indigo-600 text-white text-center py-4 rounded-2xl font-semibold hover:from-blue-700 hover:to-indigo-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <i class="fas fa-download mr-2"></i>
                            Unduh Sertifikat (PDF)
                        </a>
                        @endif
                    </div>
                </div>

                <!-- Description -->
                @if($currentAccreditation->description)
                <div class="mt-8 bg-white rounded-2xl p-6 shadow-lg">
                    <h4 class="font-bold text-gray-800 mb-3 flex items-center gap-2">
                        <i class="fas fa-info-circle text-blue-600"></i>
                        Keterangan
                    </h4>
                    <p class="text-gray-700 leading-relaxed">{{ $currentAccreditation->description }}</p>
                </div>
                @endif
            </div>
            @else
            <!-- No Current Accreditation -->
            <div class="bg-yellow-50 border-l-4 border-yellow-500 rounded-2xl p-8 mb-12">
                <div class="flex items-center gap-4">
                    <i class="fas fa-exclamation-triangle text-yellow-600 text-4xl"></i>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Belum Ada Data Akreditasi Aktif</h3>
                        <p class="text-gray-600">Saat ini belum ada data akreditasi perguruan tinggi yang aktif.</p>
                    </div>
                </div>
            </div>
            @endif

            <!-- Historical Accreditations -->
            @if($oldAccreditations->count() > 0)
            <div class="bg-white rounded-3xl shadow-xl p-10">
                <div class="flex items-center gap-4 mb-8">
                    <div class="w-16 h-16 bg-purple-100 rounded-2xl flex items-center justify-center">
                        <i class="fas fa-history text-purple-600 text-3xl"></i>
                    </div>
                    <div>
                        <h2 class="text-3xl font-bold text-gray-800">Riwayat Akreditasi Terdahulu</h2>
                        <p class="text-gray-600">Dokumentasi akreditasi institusi periode sebelumnya</p>
                    </div>
                </div>

                <div class="space-y-6">
                    @foreach($oldAccreditations as $accreditation)
                    <div class="bg-gradient-to-r from-gray-50 to-purple-50 rounded-2xl p-6 hover:shadow-lg transition-shadow border-l-4 border-purple-400">
                        <div class="flex flex-col md:flex-row md:items-center gap-6">
                            <!-- Grade Badge -->
                            <div class="flex-shrink-0">
                                <div class="w-20 h-20 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center shadow-lg">
                                    <span class="text-3xl font-bold text-white">{{ $accreditation->grade }}</span>
                                </div>
                            </div>

                            <!-- Details -->
                            <div class="flex-1 space-y-3">
                                <h4 class="text-xl font-bold text-gray-800">{{ $accreditation->study_program }}</h4>
                                
                                <div class="grid md:grid-cols-3 gap-4 text-sm">
                                    <div>
                                        <p class="text-gray-500">Lembaga</p>
                                        <p class="font-semibold text-gray-800">{{ $accreditation->accreditation_body }}</p>
                                    </div>
                                    @if($accreditation->certificate_number)
                                    <div>
                                        <p class="text-gray-500">No. Sertifikat</p>
                                        <p class="font-mono text-sm text-gray-800">{{ $accreditation->certificate_number }}</p>
                                    </div>
                                    @endif
                                    <div>
                                        <p class="text-gray-500">Berlaku</p>
                                        <p class="font-semibold text-gray-800">
                                            {{ $accreditation->valid_from ? $accreditation->valid_from->format('Y') : 'N/A' }} - 
                                            {{ $accreditation->valid_until->format('Y') }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Download Button -->
                            @if($accreditation->certificate_file)
                            <div class="flex-shrink-0">
                                <a href="{{ route('profile.accreditation.download', $accreditation->slug) }}" 
                                   class="inline-flex items-center gap-2 bg-purple-600 text-white px-6 py-3 rounded-xl font-semibold hover:bg-purple-700 transition-colors shadow-lg">
                                    <i class="fas fa-download"></i>
                                    <span class="hidden md:inline">Unduh</span>
                                </a>
                            </div>
                            @endif
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </div>
</div>

<!-- Back Button -->
<div class="py-8 bg-white border-t">
    <div class="container mx-auto px-4">
        <div class="max-w-6xl mx-auto">
            <a href="{{ route('profile.accreditation.index') }}" 
               class="inline-flex items-center gap-2 text-gray-600 hover:text-blue-600 transition-colors font-semibold">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Halaman Akreditasi
            </a>
        </div>
    </div>
</div>
@endsection