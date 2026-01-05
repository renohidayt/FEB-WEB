@extends('layouts.app')

@section('title', 'Fasilitas - Fakultas Ekonomi dan Bisnis')

@section('content')
<!-- Hero Section -->
<div class="relative bg-gradient-to-r from-indigo-600 to-indigo-800 text-white py-20">
    <div class="absolute inset-0 bg-black opacity-20"></div>
    <div class="container mx-auto px-4 relative z-10">
        <div class="max-w-4xl mx-auto text-center">
            <div class="mb-4">
                <i class="fas fa-building text-6xl opacity-80"></i>
            </div>
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Fasilitas</h1>
            <p class="text-lg md:text-xl text-indigo-100">Fasilitas lengkap untuk mendukung kegiatan akademik dan non-akademik</p>
        </div>
    </div>
</div>

<!-- Filter Section -->
<div class="bg-white shadow-md sticky top-0 z-40">
    <div class="container mx-auto px-4 py-4">
        <form method="GET" action="{{ route('facilities.index') }}" class="flex flex-wrap gap-3 items-center">
            <!-- Category Filter -->
            <select name="category" 
                    class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent"
                    onchange="this.form.submit()">
                <option value="">Semua Kategori</option>
                @foreach(\App\Models\Facility::categories() as $key => $label)
                    <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                        {{ $label }}
                    </option>
                @endforeach
            </select>

            @if(request('category'))
                <a href="{{ route('facilities.index') }}" 
                   class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 transition-colors text-sm">
                    <i class="fas fa-redo mr-2"></i>Reset
                </a>
            @endif

            <div class="ml-auto text-sm text-gray-600">
                <i class="fas fa-building mr-2"></i>
                <span class="font-semibold">{{ $facilities->total() }}</span> Fasilitas
            </div>
        </form>
    </div>
</div>

<!-- Category Tabs (Alternative - bisa dipilih salah satu dengan filter dropdown) -->
<div class="bg-gray-50 border-b border-gray-200">
    <div class="container mx-auto px-4">
        <div class="flex overflow-x-auto hide-scrollbar py-4 gap-2">
            <a href="{{ route('facilities.index') }}" 
               class="px-6 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-colors {{ !request('category') ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-indigo-50' }}">
                <i class="fas fa-th mr-2"></i>Semua
            </a>
            @foreach(\App\Models\Facility::categories() as $key => $label)
                <a href="{{ route('facilities.index', ['category' => $key]) }}" 
                   class="px-6 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-colors {{ request('category') == $key ? 'bg-indigo-600 text-white' : 'bg-white text-gray-700 hover:bg-indigo-50' }}">
                    {{ $label }}
                </a>
            @endforeach
        </div>
    </div>
</div>

<!-- Facilities Grid -->
<div class="py-16 bg-gray-50">
    <div class="container mx-auto px-4">
        @if($facilities->count() > 0)
            <!-- Grid Layout -->
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6 max-w-7xl mx-auto">
                @foreach($facilities as $facility)
                <div class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300 group">
                    <!-- Photo Gallery -->
                    <div class="relative h-64 overflow-hidden bg-gray-200">
                        @if($facility->photos->count() > 0)
                            <!-- Main Photo -->
                            <img src="{{ asset('storage/' . $facility->photos->first()->photo) }}" 
                                 alt="{{ $facility->name }}"
                                 class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            
                            <!-- Photo Counter Badge -->
                            @if($facility->photos->count() > 1)
                                <div class="absolute bottom-3 right-3 bg-black bg-opacity-70 text-white px-3 py-1 rounded-full text-sm flex items-center">
                                    <i class="fas fa-images mr-2"></i>
                                    {{ $facility->photos->count() }} Foto
                                </div>
                            @endif

                            <!-- Category Badge -->
                            <div class="absolute top-3 left-3">
                                <span class="bg-indigo-600 text-white px-3 py-1 rounded-full text-xs font-semibold">
                                    {{ $facility->category }}
                                </span>
                            </div>
                        @else
                            <!-- Placeholder -->
                            <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-200 to-gray-300">
                                <div class="text-center text-gray-400">
                                    <i class="fas fa-building text-6xl mb-3"></i>
                                    <p class="text-sm">Tidak ada foto</p>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Content -->
                    <div class="p-6">
                        <!-- Title -->
                        <h3 class="text-xl font-bold text-gray-800 mb-2 group-hover:text-indigo-600 transition-colors">
                            {{ $facility->name }}
                        </h3>

                        <!-- Capacity -->
                        @if($facility->capacity)
                            <div class="flex items-center text-gray-600 text-sm mb-3">
                                <i class="fas fa-users mr-2 text-indigo-600"></i>
                                <span>Kapasitas: {{ $facility->capacity }}</span>
                            </div>
                        @endif

                        <!-- Description -->
                        @if($facility->description)
                            <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                                {{ $facility->description }}
                            </p>
                        @endif

                        <!-- View Button -->
                        <button onclick="openModal({{ $facility->id }})" 
                                class="w-full bg-indigo-600 text-white py-2 rounded-lg hover:bg-indigo-700 transition-colors font-semibold text-sm">
                            <i class="fas fa-eye mr-2"></i>Lihat Detail
                        </button>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="mt-8">
                {{ $facilities->links() }}
            </div>

        @else
            <!-- Empty State -->
            <div class="text-center py-16 max-w-md mx-auto">
                <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                    <i class="fas fa-building text-gray-400 text-4xl"></i>
                </div>
                <h3 class="text-2xl font-bold text-gray-800 mb-2">Tidak Ada Fasilitas</h3>
                <p class="text-gray-600">
                    @if(request('category'))
                        Tidak ada fasilitas dalam kategori ini.
                        <a href="{{ route('facilities.index') }}" class="text-indigo-600 hover:text-indigo-700 font-semibold">
                            Lihat semua
                        </a>
                    @else
                        Data fasilitas belum tersedia.
                    @endif
                </p>
            </div>
        @endif
    </div>
</div>

<!-- Modal Detail (Hidden by default) -->
<div id="facilityModal" class="fixed inset-0 bg-black bg-opacity-50 z-50 hidden overflow-y-auto">
    <div class="min-h-screen px-4 py-8 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-2xl max-w-4xl w-full mx-auto relative overflow-hidden">
            <!-- Close Button -->
            <button onclick="closeModal()" 
                    class="absolute top-4 right-4 z-10 w-10 h-10 bg-white rounded-full shadow-lg flex items-center justify-center hover:bg-gray-100 transition-colors">
                <i class="fas fa-times text-gray-600"></i>
            </button>

            <!-- Modal Content (will be filled by JavaScript) -->
            <div id="modalContent" class="p-8">
                <!-- Loading -->
                <div class="text-center py-12">
                    <i class="fas fa-spinner fa-spin text-4xl text-indigo-600 mb-4"></i>
                    <p class="text-gray-600">Memuat data...</p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Info Section -->
<div class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="max-w-4xl mx-auto">
            <div class="bg-indigo-50 rounded-lg p-8 border-l-4 border-indigo-600">
                <h3 class="text-2xl font-bold text-gray-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle text-indigo-600 mr-3"></i>
                    Tentang Fasilitas
                </h3>
                <div class="prose prose-lg text-gray-700 space-y-3">
                    <p>
                        Fakultas Ekonomi dan Bisnis menyediakan berbagai fasilitas modern untuk mendukung 
                        proses pembelajaran, penelitian, dan pengembangan mahasiswa.
                    </p>
                    <p>
                        Semua fasilitas dirancang dengan standar kualitas tinggi dan terawat dengan baik 
                        untuk memberikan kenyamanan maksimal bagi civitas akademika.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }

    .hide-scrollbar {
        -ms-overflow-style: none;
        scrollbar-width: none;
    }

    .hide-scrollbar::-webkit-scrollbar {
        display: none;
    }
</style>

<script>
// Facility data for modal (passed from backend)
const facilities = @json($facilities->items());

function openModal(facilityId) {
    const facility = facilities.find(f => f.id === facilityId);
    if (!facility) return;

    const modal = document.getElementById('facilityModal');
    const content = document.getElementById('modalContent');

    // Build photo gallery HTML
    let photosHtml = '';
    if (facility.photos && facility.photos.length > 0) {
        photosHtml = `
            <div class="mb-6">
                <div class="relative h-96 bg-gray-200 rounded-lg overflow-hidden mb-4">
                    <img src="/storage/${facility.photos[0].photo}" 
                         alt="${facility.name}"
                         id="mainPhoto"
                         class="w-full h-full object-cover">
                </div>
                ${facility.photos.length > 1 ? `
                    <div class="grid grid-cols-4 md:grid-cols-6 gap-2">
                        ${facility.photos.map((photo, index) => `
                            <div class="relative h-20 bg-gray-200 rounded overflow-hidden cursor-pointer hover:opacity-75 transition-opacity"
                                 onclick="changeMainPhoto('/storage/${photo.photo}')">
                                <img src="/storage/${photo.photo}" 
                                     alt="Photo ${index + 1}"
                                     class="w-full h-full object-cover">
                            </div>
                        `).join('')}
                    </div>
                ` : ''}
            </div>
        `;
    }

    // Build modal content
    content.innerHTML = `
        ${photosHtml}
        
        <div class="space-y-4">
            <div>
                <span class="inline-block bg-indigo-100 text-indigo-800 px-3 py-1 rounded-full text-sm font-semibold mb-3">
                    ${facility.category}
                </span>
                <h2 class="text-3xl font-bold text-gray-800">${facility.name}</h2>
            </div>

            ${facility.capacity ? `
                <div class="flex items-center text-gray-700">
                    <i class="fas fa-users mr-3 text-indigo-600"></i>
                    <span class="font-semibold">Kapasitas: ${facility.capacity}</span>
                </div>
            ` : ''}

            ${facility.description ? `
                <div class="border-t border-gray-200 pt-4">
                    <h3 class="font-bold text-gray-800 mb-2">Deskripsi</h3>
                    <p class="text-gray-700 leading-relaxed">${facility.description}</p>
                </div>
            ` : ''}

            ${facility.photos && facility.photos.length > 0 ? `
                <div class="border-t border-gray-200 pt-4">
                    <p class="text-sm text-gray-600">
                        <i class="fas fa-images mr-2"></i>
                        ${facility.photos.length} foto tersedia
                    </p>
                </div>
            ` : ''}
        </div>
    `;

    modal.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}

function closeModal() {
    const modal = document.getElementById('facilityModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
}

function changeMainPhoto(photoUrl) {
    const mainPhoto = document.getElementById('mainPhoto');
    if (mainPhoto) {
        mainPhoto.src = photoUrl;
    }
}

// Close modal when clicking outside
document.getElementById('facilityModal')?.addEventListener('click', function(e) {
    if (e.target === this) {
        closeModal();
    }
});

// Close modal with ESC key
document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeModal();
    }
});
</script>
@endsection