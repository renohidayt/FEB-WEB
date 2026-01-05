@extends('layouts.app')

@section('title', 'Riwayat Akreditasi - STIE Sebelas April')

@section('content')

<!-- Hero Section dengan Icon Gesture -->
<div class="relative bg-slate-900 text-white pt-6 pb-20 overflow-hidden border-b border-white/5">
    {{-- Background Decorations --}}
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] z-0"></div>
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-orange-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob z-0"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-blue-700 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000 z-0"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        {{-- Breadcrumb --}}
        <nav class="w-full flex items-center text-sm font-medium mb-12">
            <a href="{{ url('/') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 group">
                <i class="fas fa-home text-orange-500/80 group-hover:text-orange-500 transition-colors"></i> 
                <span>Beranda</span>
            </a>
            <span class="mx-3 text-slate-600">/</span>
            <a href="{{ route('profile.accreditation.index') }}" class="text-slate-400 hover:text-white transition-colors">Akreditasi</a>
            <span class="mx-3 text-slate-600">/</span>
            <span class="text-orange-500 font-semibold cursor-default uppercase tracking-wider text-xs">Riwayat</span>
        </nav>

        <div class="grid lg:grid-cols-2 gap-12 items-center">
            {{-- Text Content --}}
            <div class="animate-fade-in-left">

                
                <h1 class="text-5xl md:text-7xl font-extrabold mb-6 tracking-tight leading-tight uppercase">
                    Riwayat <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Akreditasi</span>
                </h1>
                
                <div class="w-20 h-1.5 bg-orange-500 mb-8 rounded-full"></div>
                
                <p class="text-lg text-slate-300 font-light leading-relaxed max-w-xl">
                    Jejak historis pencapaian mutu akademik dan standar kualitas pendidikan di Fakultas Ekonomi dan Bisnis UNSAP dari masa ke masa.
                </p>
            </div>

            {{-- Illustration Area --}}
            <div class="hidden lg:flex justify-center relative">
                {{-- Glow Effect --}}
                <div class="absolute w-64 h-64 bg-orange-500/10 rounded-full blur-[80px]"></div>

                {{-- Main Icon Logic (Glassmorphism) --}}
                <div class="relative w-72 h-72 bg-white/5 backdrop-blur-xl border border-white/10 rounded-[3rem] shadow-2xl flex items-center justify-center transform -rotate-3 hover:rotate-0 transition-all duration-700 group">
                    {{-- Clock/History Icon --}}
                    <i class="fas fa-history text-8xl text-slate-700 group-hover:text-orange-500 transition-all duration-500 transform group-hover:scale-110"></i>

                    {{-- Small Floating Badge --}}
                    <div class="absolute -top-6 -right-6 bg-slate-800 border border-orange-500/50 p-5 rounded-2xl shadow-xl animate-bounce" style="animation-duration: 4s;">
                        <i class="fas fa-medal text-orange-500 text-3xl"></i>
                    </div>

                    {{-- Small Floating Badge 2 --}}
                    <div class="absolute -bottom-6 -left-6 bg-slate-800 border border-blue-500/30 p-4 rounded-2xl shadow-xl animate-pulse">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400 text-xs">
                                <i class="fas fa-check-double"></i>
                            </div>
                            <span class="text-[10px] font-bold text-white uppercase tracking-tighter">Verified Data</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes blob {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
    }
    .animate-blob { animation: blob 7s infinite; }
    .animation-delay-2000 { animation-delay: 2s; }
    .animate-fade-in-left {
        animation: fadeInLeft 0.8s ease-out;
    }
    @keyframes fadeInLeft {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
</style>

  

<!-- Main Content -->
<div class="py-12 bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4">
        <div class="max-w-7xl mx-auto">

            @if($groupedByProgram->count() > 0)
                
                <!-- Stats Cards -->
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <div class="text-gray-500 text-sm mb-1">Total Arsip</div>
                        <div class="text-3xl font-bold text-gray-800">{{ $stats['total_records'] }}</div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <div class="text-gray-500 text-sm mb-1">Program Studi</div>
                        <div class="text-3xl font-bold text-gray-800">{{ $stats['programs_count'] }}</div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <div class="text-gray-500 text-sm mb-1">Tahun Awal</div>
                        <div class="text-3xl font-bold text-gray-800">{{ $stats['oldest_year'] }}</div>
                    </div>
                    <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100">
                        <div class="text-gray-500 text-sm mb-1">Tahun Terakhir</div>
                        <div class="text-3xl font-bold text-gray-800">{{ $stats['latest_year'] }}</div>
                    </div>
                </div>

                <!-- View Toggle & Filter -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 mb-6">
                    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                        <div class="flex items-center gap-2">
                            <button onclick="toggleView('folder')" id="btn-folder" 
                                    class="view-toggle active px-4 py-2 rounded-lg font-medium transition-all">
                                <i class="fas fa-folder mr-2"></i>Folder View
                            </button>
                            <button onclick="toggleView('table')" id="btn-table" 
                                    class="view-toggle px-4 py-2 rounded-lg font-medium transition-all">
                                <i class="fas fa-table mr-2"></i>Table View
                            </button>
                        </div>
                        
                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <i class="fas fa-search absolute left-3 top-1/2 -translate-y-1/2 text-gray-400"></i>
                                <input type="text" id="searchInput" placeholder="Cari program studi..." 
                                       class="pl-10 pr-4 py-2 border border-gray-200 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent">
                            </div>
                        </div>
                    </div>
                </div>

               <!-- FOLDER VIEW -->
<div id="folder-view" class="view-content">
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($groupedByProgram as $programName => $records)
        @php
            $isPT = str_contains($programName, 'Perguruan Tinggi');
            $iconBg = $isPT ? 'from-blue-500 to-indigo-600' : 'from-yellow-400 to-amber-500';
            $icon = $isPT ? 'fa-university' : 'fa-folder';
        @endphp
        
        <div class="folder-card group cursor-pointer" 
             onclick="openFolder('{{ Str::slug($programName) }}')" 
             data-program="{{ strtolower($programName) }}">
            <div class="bg-white rounded-2xl p-6 shadow-sm border border-gray-100 hover:shadow-xl hover:border-orange-300 transition-all duration-300">
                <div class="flex items-start gap-4 mb-4">
                    <div class="w-14 h-14 bg-gradient-to-br {{ $iconBg }} rounded-xl flex items-center justify-center shadow-lg group-hover:scale-110 transition-transform">
                        <i class="fas {{ $icon }} text-white text-2xl"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <h3 class="font-bold text-gray-800 text-lg mb-1 truncate group-hover:text-orange-600 transition-colors">
                            {{ $programName }}
                        </h3>
                        <p class="text-sm text-gray-500">{{ $records->count() }} file</p>
                    </div>
                </div>

                <div class="space-y-2 mb-4">
                    @foreach($records->take(3) as $record)
                    <div class="flex items-center gap-2 text-xs text-gray-600">
                        <i class="fas fa-file-pdf text-red-500"></i>
                        <span class="truncate">
                            {{ $record->grade }} - {{ $record->valid_from ? $record->valid_from->format('Y') : 'N/A' }} s/d {{ $record->valid_until->format('Y') }}
                        </span>
                    </div>
                    @endforeach
                    @if($records->count() > 3)
                    <div class="text-xs text-gray-400 pl-5">+{{ $records->count() - 3 }} lainnya</div>
                    @endif
                </div>

                <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                    <div class="flex items-center gap-4 text-xs text-gray-500">
                        <div>
                            <i class="fas fa-calendar mr-1"></i>
                            {{ $records->min('valid_from') ? $records->min('valid_from')->format('Y') : 'N/A' }} - {{ $records->max('valid_until')->format('Y') }}
                        </div>
                    </div>
                    <i class="fas fa-chevron-right text-gray-400 group-hover:text-orange-600 group-hover:translate-x-1 transition-all"></i>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

               <!-- TABLE VIEW -->
<div id="table-view" class="view-content hidden">
    @foreach($groupedByProgram as $programName => $records)
    @php
        $isPT = str_contains($programName, 'Perguruan Tinggi');
        $iconBg = $isPT ? 'from-blue-500 to-indigo-600' : 'from-yellow-400 to-amber-500';
        $icon = $isPT ? 'fa-university' : 'fa-folder';
    @endphp
    
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 mb-6 overflow-hidden table-section" 
         data-program="{{ strtolower($programName) }}">
        
        <div class="bg-gradient-to-r from-orange-50 to-red-50 p-6 border-b border-gray-200">
            <div class="flex items-center justify-between">
                <div class="flex items-center gap-4">
                    <div class="w-12 h-12 bg-gradient-to-br {{ $iconBg }} rounded-xl flex items-center justify-center shadow">
                        <i class="fas {{ $icon }} text-white text-xl"></i>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">{{ $programName }}</h3>
                        <p class="text-sm text-gray-600">{{ $records->count() }} riwayat akreditasi</p>
                    </div>
                </div>
                <button onclick="toggleTable('{{ Str::slug($programName) }}')" 
                        class="text-gray-500 hover:text-gray-700 transition">
                    <i class="fas fa-chevron-down text-xl toggle-icon-{{ Str::slug($programName) }}"></i>
                </button>
            </div>
        </div>

        <div id="table-{{ Str::slug($programName) }}" class="table-content">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-file-pdf mr-2 text-red-500"></i>Akreditasi
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-award mr-2 text-yellow-500"></i>Peringkat
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-calendar mr-2 text-blue-500"></i>Periode
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-shield-alt mr-2 text-orange-500"></i>Lembaga
                            </th>
                            <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-hashtag mr-2 text-gray-500"></i>No. Sertifikat
                            </th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase tracking-wider">
                                <i class="fas fa-download mr-2 text-green-500"></i>Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach($records->sortByDesc('valid_until') as $accreditation)
                        <tr class="hover:bg-orange-50/50 transition-colors">
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-red-100 rounded-lg flex items-center justify-center">
                                        <i class="fas fa-file-pdf text-red-600"></i>
                                    </div>
                                    <div>
                                        <div class="font-semibold text-gray-800">Akreditasi {{ $accreditation->grade }}</div>
                                        <div class="text-xs text-gray-500">{{ $accreditation->valid_until->format('d M Y') }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold {{
                                    in_array($accreditation->grade, ['A', 'Unggul']) ? 'bg-emerald-100 text-emerald-800' : 
                                    (in_array($accreditation->grade, ['B', 'Baik Sekali']) ? 'bg-blue-100 text-blue-800' : 'bg-amber-100 text-amber-800')
                                }}">
                                    <i class="fas fa-star mr-1"></i>
                                    {{ $accreditation->grade }}
                                </span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm">
                                    <div class="font-semibold text-gray-800">
                                        {{ $accreditation->valid_from ? $accreditation->valid_from->format('Y') : 'N/A' }} - {{ $accreditation->valid_until->format('Y') }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $accreditation->valid_until->format('d F Y') }}
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm text-gray-800">{{ $accreditation->accreditation_body }}</div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="text-sm font-mono text-gray-600">
                                    {{ $accreditation->certificate_number ?? '-' }}
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center justify-center gap-2">
                                    @if($accreditation->certificate_file)
                                    <a href="{{ route('profile.accreditation.download', $accreditation->slug) }}" 
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-gradient-to-r from-orange-600 to-red-600 text-white rounded-lg hover:from-orange-700 hover:to-red-700 transition-all shadow-sm hover:shadow-md transform hover:-translate-y-0.5 text-sm font-semibold">
                                        <i class="fas fa-download"></i>
                                        Unduh
                                    </a>
                                    @else
                                    <span class="text-xs text-gray-400">
                                        <i class="fas fa-times-circle mr-1"></i>
                                        Tidak tersedia
                                    </span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endforeach
</div>

            @else
                <!-- Empty State -->
                <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-20 text-center">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-inbox text-gray-400 text-5xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-3">Belum Ada Riwayat</h3>
                    <p class="text-gray-600 max-w-md mx-auto">
                        Saat ini belum ada data riwayat akreditasi yang tersimpan dalam sistem.
                    </p>
                </div>
            @endif

        </div>
    </div>
</div>

<!-- Folder Detail Modal -->
<div id="folderModal" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-50 hidden items-center justify-center p-4">
    <div class="bg-white rounded-3xl shadow-2xl max-w-5xl w-full max-h-[90vh] overflow-hidden">
        <div class="bg-gradient-to-r from-orange-600 to-red-600 text-white p-6 flex items-center justify-between">
            <div class="flex items-center gap-4">
                <div class="w-12 h-12 bg-white/20 backdrop-blur rounded-xl flex items-center justify-center">
                    <i class="fas fa-folder-open text-2xl"></i>
                </div>
                <div>
                    <h3 id="modalProgramName" class="text-2xl font-bold"></h3>
                    <p id="modalFileCount" class="text-orange-100 text-sm"></p>
                </div>
            </div>
            <button onclick="closeFolder()" class="text-white/80 hover:text-white transition">
                <i class="fas fa-times text-2xl"></i>
            </button>
        </div>

        <div id="modalContent" class="p-6 overflow-y-auto max-h-[calc(90vh-120px)]">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>

<style>
.view-toggle {
    background: transparent;
    color: #6B7280;
}

.view-toggle.active {
    background: linear-gradient(135deg, #EA580C 0%, #DC2626 100%);
    color: white;
    box-shadow: 0 4px 6px -1px rgba(234, 88, 12, 0.3);
}

.view-toggle:hover:not(.active) {
    background: #F3F4F6;
}

.folder-card {
    animation: fadeInUp 0.5s ease-out;
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.table-content {
    max-height: 1000px;
    transition: max-height 0.3s ease-out;
    overflow: hidden;
}

.table-content.collapsed {
    max-height: 0;
}
</style>

<script>
function toggleView(view) {
    const folderView = document.getElementById('folder-view');
    const tableView = document.getElementById('table-view');
    const btnFolder = document.getElementById('btn-folder');
    const btnTable = document.getElementById('btn-table');

    if (view === 'folder') {
        folderView.classList.remove('hidden');
        tableView.classList.add('hidden');
        btnFolder.classList.add('active');
        btnTable.classList.remove('active');
    } else {
        folderView.classList.add('hidden');
        tableView.classList.remove('hidden');
        btnFolder.classList.remove('active');
        btnTable.classList.add('active');
    }
}

function toggleTable(slug) {
    const content = document.getElementById('table-' + slug);
    const icon = document.querySelector('.toggle-icon-' + slug);
    
    content.classList.toggle('collapsed');
    icon.classList.toggle('fa-chevron-down');
    icon.classList.toggle('fa-chevron-up');
}

document.getElementById('searchInput').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    
    document.querySelectorAll('.folder-card').forEach(card => {
        const program = card.dataset.program;
        card.style.display = program.includes(searchTerm) ? 'block' : 'none';
    });
    
    document.querySelectorAll('.table-section').forEach(section => {
        const program = section.dataset.program;
        section.style.display = program.includes(searchTerm) ? 'block' : 'none';
    });
});

const folderData = @json($groupedByProgram);

function openFolder(slug) {
    const modal = document.getElementById('folderModal');
    const programName = slug.split('-').map(word => 
        word.charAt(0).toUpperCase() + word.slice(1)
    ).join(' ');
    
    let records = [];
    Object.keys(folderData).forEach(key => {
        if (key.toLowerCase().replace(/\s+/g, '-') === slug) {
            records = folderData[key];
        }
    });
    
    document.getElementById('modalProgramName').textContent = programName;
    document.getElementById('modalFileCount').textContent = records.length + ' file arsip';
    
    let content = '<div class="grid gap-4">';
    records.forEach((record) => {
        const gradeColor = ['A', 'Unggul'].includes(record.grade) ? 'emerald' : 
                          (['B', 'Baik Sekali'].includes(record.grade) ? 'blue' : 'amber');
        
        content += `
            <div class="bg-gradient-to-br from-gray-50 to-orange-50 rounded-2xl p-6 border-l-4 border-${gradeColor}-500 hover:shadow-lg transition-all">
                <div class="flex items-start gap-4">
                    <div class="w-14 h-14 bg-gradient-to-br from-${gradeColor}-500 to-${gradeColor}-600 rounded-xl flex items-center justify-center shadow-lg flex-shrink-0">
                        <span class="text-2xl font-bold text-white">${record.grade}</span>
                    </div>
                    <div class="flex-1">
                        <h4 class="font-bold text-gray-800 text-lg mb-1">Akreditasi ${record.grade}</h4>
                        <p class="text-sm text-gray-600 mb-3">
                            <i class="fas fa-calendar mr-2"></i>
                            ${record.valid_from_formatted || 'N/A'} - ${record.valid_until_formatted}
                        </p>
                        <div class="grid md:grid-cols-2 gap-4 mb-4">
                            <div>
                                <div class="text-xs text-gray-500 mb-1">Lembaga Akreditasi</div>
                                <div class="font-semibold text-gray-800">${record.accreditation_body}</div>
                            </div>
                            <div>
                                <div class="text-xs text-gray-500 mb-1">Nomor Sertifikat</div>
                                <div class="font-mono text-sm text-gray-800">${record.certificate_number || '-'}</div>
                            </div>
                        </div>
                        ${record.description ? `
                        <div class="bg-white/50 rounded-lg p-3 mb-4">
                            <p class="text-sm text-gray-600">${record.description}</p>
                        </div>
                        ` : ''}
                        ${record.certificate_file ? `
                        <a href="/profil/akreditasi/download/${record.slug}" 
                           class="inline-flex items-center gap-2 px-6 py-3 bg-gradient-to-r from-orange-600 to-red-600 text-white rounded-xl font-semibold hover:from-orange-700 hover:to-red-700 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <i class="fas fa-download"></i>
                            Download Sertifikat
                        </a>
                        ` : '<span class="text-sm text-gray-400"><i class="fas fa-file-times mr-2"></i>File tidak tersedia</span>'}
                    </div>
                </div>
            </div>
        `;
    });
    content += '</div>';
    
    document.getElementById('modalContent').innerHTML = content;
    modal.classList.remove('hidden');
    modal.classList.add('flex');
}

function closeFolder() {
    const modal = document.getElementById('folderModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}

document.getElementById('folderModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closeFolder();
    }
});

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        closeFolder();
    }
});
</script>
@endsection