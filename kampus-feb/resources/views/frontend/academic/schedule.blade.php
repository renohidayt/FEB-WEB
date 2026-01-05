@extends('layouts.app')

@section('content')
<div class="relative bg-slate-900 text-white pt-6 pb-16 overflow-hidden border-b border-white/5">
    
    {{-- Background Decorations --}}
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] z-0"></div>
    {{-- Orange Blob (Top Right) --}}
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-orange-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob z-0"></div>
    {{-- Blue Blob (Bottom Left) --}}
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-blue-700 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000 z-0"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        
        {{-- Navigation / Breadcrumb --}}
        <nav class="w-full flex items-center text-sm font-medium mb-10">
            <a href="{{ url('/') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 group">
                <i class="fas fa-home text-orange-500/80 group-hover:text-orange-500 transition-colors"></i> 
                <span class="group-hover:underline decoration-orange-500 decoration-2 underline-offset-4">Beranda</span>
            </a>
            <span class="mx-3 text-slate-600">/</span>
            <span class="text-orange-500 font-semibold cursor-default">Jadwal Perkuliahan</span>
        </nav>

        {{-- Grid Content --}}
        <div class="grid md:grid-cols-2 gap-8 items-center">
            
            {{-- Text Content --}}
            <div class="text-left"> 
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 tracking-tight leading-tight uppercase">
                    Jadwal <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Perkuliahan</span>
                </h1>
                <p class="text-lg text-slate-300 font-light leading-relaxed max-w-lg">
                    Akses dan unduh jadwal perkuliahan terbaru untuk memastikan kelancaran kegiatan belajar mengajar Anda di setiap semester secara efisien.
                </p>
                <div class="mt-6 flex items-center gap-4">
                </div>
            </div>

            {{-- 3D Visual Mockup --}}
            <div class="hidden md:block relative h-[280px] flex items-center justify-center perspective-1000">
                
                {{-- Orange Glow --}}
                <div class="absolute w-56 h-56 bg-orange-500/10 rounded-full blur-[60px]"></div>

                {{-- Browser/Window Mockup --}}
                <div class="relative w-72 bg-slate-800/40 backdrop-blur-xl border border-white/10 p-5 rounded-2xl shadow-2xl transform rotate-y-6 hover:rotate-y-0 transition-transform duration-700">
                    <div class="flex items-center gap-1.5 mb-4 opacity-50">
                        <div class="w-2.5 h-2.5 rounded-full bg-red-500"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-yellow-500"></div>
                        <div class="w-2.5 h-2.5 rounded-full bg-green-500"></div>
                    </div>
                    
                    <div class="bg-gradient-to-br from-slate-700/50 to-slate-800/50 h-24 rounded-lg mb-4 flex items-center justify-center border border-white/5 group">
                        <i class="fas fa-clock text-4xl text-slate-600 group-hover:text-orange-500 transition-colors duration-500"></i>
                    </div>

                    <div class="space-y-2">
                        <div class="h-2 bg-slate-600/30 rounded-full w-3/4"></div>
                        <div class="h-2 bg-slate-600/30 rounded-full w-1/2"></div>
                    </div>
                </div>

                {{-- Floating Badge 1 --}}
                <div class="absolute top-4 right-8 bg-slate-800/80 backdrop-blur-md border border-orange-500/30 p-3 rounded-xl shadow-xl animate-bounce" style="animation-duration: 3s;">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-orange-500/20 flex items-center justify-center text-orange-400">
                            <i class="fas fa-calendar-alt text-xs"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider leading-none mb-0.5">Update</p>
                            <p class="text-xs font-bold leading-none">Mingguan</p>
                        </div>
                    </div>
                </div>

                {{-- Floating Badge 2 --}}
                <div class="absolute bottom-4 left-8 bg-slate-800/80 backdrop-blur-md border border-blue-500/30 p-3 rounded-xl shadow-xl animate-bounce" style="animation-duration: 4s;">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-blue-500/20 flex items-center justify-center text-blue-400">
                            <i class="fas fa-download text-xs"></i>
                        </div>
                        <div>
                            <p class="text-[10px] text-slate-400 uppercase tracking-wider leading-none mb-0.5">Format</p>
                            <p class="text-xs font-bold leading-none">PDF & Excel</p>
                        </div>
                    </div>
                </div>

            </div>
            
        </div>
    </div>
</div>

<style>
/* Pastikan CSS ini ada di file Anda */
.perspective-1000 { perspective: 1000px; }
.rotate-y-6 { transform: rotateY(-15deg) rotateX(5deg); }
.animation-delay-2000 { animation-delay: 2s; }

@keyframes blob {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
}
.animate-blob { animation: blob 7s infinite; }
</style>
<div class="container mx-auto px-4 mt-10 relative z-20 pb-24">
    {{-- Filter Section --}}
    @if($schedules->isNotEmpty())
    <div class="mb-10">
        <div class="relative overflow-hidden bg-white rounded-3xl border border-slate-200 shadow-xl">
            {{-- Gradient Background Accent --}}
            <div class="absolute inset-0 bg-gradient-to-br from-blue-950 via-blue-900 to-slate-900 opacity-[0.02]"></div>
            
            {{-- Decorative Elements --}}
            <div class="absolute -top-24 -right-24 w-48 h-48 bg-gradient-to-br from-orange-500/10 to-red-500/10 rounded-full blur-3xl"></div>
            <div class="absolute -bottom-24 -left-24 w-48 h-48 bg-gradient-to-br from-blue-900/10 to-blue-950/10 rounded-full blur-3xl"></div>
            
            <div class="relative p-6 md:p-8">
                {{-- Header Section --}}
                <div class="flex items-center gap-4 mb-6 pb-6 border-b border-slate-100">
                    <div class="relative">
                        <div class="w-14 h-14 bg-gradient-to-br from-blue-900 via-blue-800 to-blue-900 rounded-2xl flex items-center justify-center shadow-lg shadow-blue-900/20 flex-shrink-0">
                            <i class="fas fa-filter text-orange-400 text-lg"></i>
                        </div>
                        <div class="absolute -bottom-1 -right-1 w-4 h-4 bg-gradient-to-br from-orange-500 to-red-600 rounded-full border-2 border-white"></div>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-blue-950 mb-0.5">Filter Jadwal</h3>
                        <p class="text-xs text-slate-500 font-medium">Pilih kriteria untuk menyaring jadwal</p>
                    </div>
                </div>
                
                {{-- Filter Controls Grid --}}
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                    {{-- Academic Year Filter --}}
                    <div class="relative group">
                        <label class="block text-xs font-bold text-blue-900 mb-2 ml-1">
                            <i class="fas fa-calendar-alt text-orange-500 mr-1.5"></i>
                            Tahun Akademik
                        </label>
                        <div class="relative">
                            <select id="academicYearFilter" class="w-full pl-4 pr-10 py-3.5 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-semibold text-blue-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:bg-white transition-all appearance-none cursor-pointer hover:border-blue-300 hover:bg-white">
                                <option value="">Semua Tahun Akademik</option>
                                @foreach($schedules->unique('academic_year')->sortByDesc('academic_year') as $schedule)
                                    <option value="{{ $schedule->academic_year }}">{{ $schedule->academic_year }}</option>
                                @endforeach
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-chevron-down text-slate-400 text-xs"></i>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Semester Filter --}}
                    <div class="relative group">
                        <label class="block text-xs font-bold text-blue-900 mb-2 ml-1">
                            <i class="fas fa-book-open text-orange-500 mr-1.5"></i>
                            Semester
                        </label>
                        <div class="relative">
                            <select id="semesterFilter" class="w-full pl-4 pr-10 py-3.5 bg-slate-50 border-2 border-slate-200 rounded-xl text-sm font-semibold text-blue-900 focus:outline-none focus:ring-2 focus:ring-orange-500 focus:border-orange-500 focus:bg-white transition-all appearance-none cursor-pointer hover:border-blue-300 hover:bg-white">
                                <option value="">Semua Semester</option>
                                <option value="ganjil">Semester Ganjil</option>
                                <option value="genap">Semester Genap</option>
                            </select>
                            <div class="absolute inset-y-0 right-0 flex items-center pr-3 pointer-events-none">
                                <i class="fas fa-chevron-down text-slate-400 text-xs"></i>
                            </div>
                        </div>
                    </div>
                    
                    {{-- Reset Button --}}
                    <div class="relative group md:col-span-2 lg:col-span-1">
                        <label class="block text-xs font-bold text-transparent mb-2 ml-1 select-none">.</label>
                       <button id="resetFilter"
    class="w-full relative overflow-hidden px-6 py-3.5 bg-slate-900 text-white rounded-xl text-sm font-bold
           transition-all active:scale-[0.98] shadow-lg shadow-slate-200 hover:bg-indigo-600 group">
    Reset
</button>

                                
                            </span>
                            <div class="absolute inset-0 bg-gradient-to-r from-white/0 via-white/20 to-white/0 translate-x-[-100%] group-hover:translate-x-[100%] transition-transform duration-700"></div>
                        </button>
                    </div>
                </div>
                
                {{-- Quick Stats (Optional Enhancement) --}}
                <div class="mt-6 pt-6 border-t border-slate-100">
                    <div class="flex flex-wrap items-center gap-4 text-xs">
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                            <span class="text-slate-600 font-medium">
                                <span class="font-bold text-blue-900" id="totalSchedules">{{ $schedules->count() }}</span> jadwal tersedia
                            </span>
                        </div>
                        <div class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-orange-500 rounded-full"></div>
                            <span class="text-slate-600 font-medium">Filter aktif: <span class="font-bold text-orange-600" id="activeFilters">0</span></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Empty State --}}
    @if($schedules->isEmpty())
        <div class="bg-white/80 backdrop-blur-sm rounded-[2.5rem] border border-slate-100 shadow-sm p-20 text-center">
            <div class="relative w-24 h-24 mx-auto mb-8">
                <div class="absolute inset-0 bg-indigo-50 rounded-full animate-ping opacity-25"></div>
                <div class="relative w-24 h-24 bg-indigo-50 rounded-full flex items-center justify-center">
                    <i class="fas fa-calendar-alt text-4xl text-indigo-400"></i>
                </div>
            </div>
            <h3 class="text-2xl font-extrabold text-slate-800 mb-3">Belum Ada Jadwal</h3>
            <p class="text-slate-500 max-w-sm mx-auto leading-relaxed">
                Halaman ini akan segera diperbarui. Admin akademik sedang menyiapkan dokumen jadwal terbaru untuk Anda.
            </p>
        </div>
    @else
        {{-- Results Count --}}
        <div class="mb-6 flex items-center justify-between">
            <div class="flex items-center gap-2">
                <span class="text-sm text-slate-500">Menampilkan</span>
                <span id="resultCount" class="px-3 py-1 bg-indigo-50 text-indigo-700 text-sm font-bold rounded-lg">
                    {{ $schedules->count() }}
                </span>
                <span class="text-sm text-slate-500">jadwal</span>
            </div>
            
            <div class="flex items-center gap-2 text-sm text-slate-500">
                <i class="fas fa-clock text-xs"></i>
                <span>Diperbarui {{ $schedules->first()->created_at->diffForHumans() }}</span>
            </div>
        </div>

        {{-- Schedule Cards Grid --}}
        <div id="scheduleGrid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($schedules as $schedule)
                <div class="schedule-card group bg-white rounded-[2rem] border border-slate-100 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-[0_20px_50px_rgba(79,70,229,0.1)] transition-all duration-500 flex flex-col overflow-hidden"
                     data-year="{{ $schedule->academic_year }}" 
                     data-semester="{{ $schedule->semester }}">
                    
                    <div class="p-8 pb-0">
                        <div class="flex justify-between items-start mb-6">
                            <div class="w-14 h-14 bg-gradient-to-br from-indigo-50 to-blue-50 text-indigo-600 rounded-2xl flex items-center justify-center text-2xl group-hover:scale-110 transition-transform duration-500">
                                <i class="fas fa-file-{{ strtolower($schedule->file_type) == 'pdf' ? 'pdf' : 'alt' }}"></i>
                            </div>
                            <div class="flex flex-col items-end gap-2">
                                <span class="px-4 py-1.5 bg-indigo-50 text-indigo-700 text-[11px] font-bold uppercase tracking-wider rounded-full border border-indigo-100/50">
                                    {{ ucfirst($schedule->semester) }}
                                </span>
                            </div>
                        </div>

                        <h3 class="text-xl font-bold text-slate-800 mb-3 group-hover:text-indigo-600 transition-colors leading-tight">
                            {{ $schedule->title }}
                        </h3>
                        
                        <div class="flex items-center gap-2 mb-6">
                            <div class="flex items-center px-3 py-1 bg-slate-50 rounded-lg border border-slate-100">
                                <i class="fas fa-graduation-cap text-xs text-slate-400 mr-2"></i>
                                <span class="text-xs font-semibold text-slate-600">{{ $schedule->academic_year }}</span>
                            </div>
                            @if($schedule->download_count > 0)
                            <div class="flex items-center px-3 py-1 bg-green-50 rounded-lg border border-green-100">
                                <i class="fas fa-download text-xs text-green-500 mr-2"></i>
                                <span class="text-xs font-semibold text-green-600">{{ $schedule->download_count }}x</span>
                            </div>
                            @endif
                        </div>

                        @if($schedule->description)
                            <p class="text-sm text-slate-500 line-clamp-2 leading-relaxed mb-6 font-normal">
                                {{ $schedule->description }}
                            </p>
                        @endif
                    </div>

                    <div class="mt-auto p-8 pt-4">
                        <div class="h-[1px] w-full bg-slate-50 mb-6"></div>
                        <a href="{{ $schedule->getDownloadUrl() }}" 
                           class="group/btn relative flex items-center justify-center gap-3 w-full py-4 bg-slate-900 text-white rounded-2xl font-bold overflow-hidden transition-all hover:bg-indigo-600 active:scale-[0.98] shadow-lg shadow-slate-200">
                            <div class="absolute inset-0 w-1/2 h-full bg-white/10 skew-x-[-25deg] -translate-x-full group-hover/btn:animate-[shine_0.75s_ease-in-out]"></div>
                            
                            <i class="fas fa-download text-sm group-hover/btn:translate-y-0.5 transition-transform"></i>
                            <div class="flex flex-col items-start leading-none">
                                <span class="text-[14px]">Unduh Jadwal</span>
                                <span class="text-[10px] opacity-60 font-medium">{{ strtoupper($schedule->file_type) }} • {{ $schedule->getFileSizeFormatted() }}</span>
                            </div>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- No Results Message (Hidden by default) --}}
        <div id="noResults" class="hidden bg-white/80 backdrop-blur-sm rounded-[2.5rem] border border-slate-100 shadow-sm p-16 text-center">
            <div class="w-20 h-20 bg-indigo-50 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-search text-3xl text-indigo-400"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-800 mb-3">Tidak Ada Hasil</h3>
            <p class="text-slate-500 max-w-sm mx-auto">
                Tidak ditemukan jadwal yang sesuai dengan filter yang dipilih. Coba ubah kriteria pencarian Anda.
            </p>
        </div>
    @endif
</div>

{{-- Help Section --}}
<div class="container mx-auto px-4 pb-20">
    <div class="relative bg-slate-900 rounded-[2rem] p-8 md:p-12 text-center overflow-hidden shadow-xl border border-white/5">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] z-0"></div>
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-60 h-60 bg-orange-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob z-0"></div>
        
        <div class="relative z-10">
            
            <h2 class="text-2xl md:text-3xl font-black text-white mb-4 uppercase tracking-tight">
                Kesulitan Menemukan <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Jadwal?</span>
            </h2>
            
            <p class="text-slate-400 max-w-xl mx-auto mb-8 text-base font-light">
                Jika jadwal kelas Anda belum tersedia atau terdapat kesalahan data, silakan hubungi bagian Akademik melalui WhatsApp.
            </p>

            <a href="https://wa.me/6285315654194?text=Halo%20Admin%20FEB%20UNSAP." target="_blank" class="inline-flex items-center gap-2 px-8 py-3.5 bg-orange-500 text-white rounded-xl font-bold transition-all shadow-lg hover:shadow-orange-500/40 hover:-translate-y-1 active:scale-95">
                <i class="fab fa-whatsapp text-xl"></i> Hubungi Akademik
            </a>
        </div>
    </div>
</div>

<style>
@keyframes shine {
    100% {
        translate: 250% 0;
    }
}

@keyframes blob {
    0%, 100% { transform: translate(0, 0) scale(1); }
    33% { transform: translate(30px, -50px) scale(1.1); }
    66% { transform: translate(-20px, 20px) scale(0.9); }
}

.animate-blob { animation: blob 7s infinite; }
.animate-fade-in-left { animation: fadeInLeft 0.8s ease-out; }

@keyframes fadeInLeft {
    from { opacity: 0; transform: translateX(-20px); }
    to { opacity: 1; transform: translateX(0); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const academicYearFilter = document.getElementById('academicYearFilter');
    const semesterFilter = document.getElementById('semesterFilter');
    const resetButton = document.getElementById('resetFilter');
    const scheduleCards = document.querySelectorAll('.schedule-card');
    const scheduleGrid = document.getElementById('scheduleGrid');
    const noResults = document.getElementById('noResults');
    const resultCount = document.getElementById('resultCount');

    function filterSchedules() {
        const selectedYear = academicYearFilter?.value || '';
        const selectedSemester = semesterFilter?.value || '';
        let visibleCount = 0;

        scheduleCards.forEach(card => {
            const cardYear = card.dataset.year;
            const cardSemester = card.dataset.semester;
            
            const yearMatch = !selectedYear || cardYear === selectedYear;
            const semesterMatch = !selectedSemester || cardSemester === selectedSemester;
            
            if (yearMatch && semesterMatch) {
                card.style.display = 'flex';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        // Update result count
        if (resultCount) {
            resultCount.textContent = visibleCount;
        }

        // Show/hide no results message
        if (noResults && scheduleGrid) {
            if (visibleCount === 0) {
                scheduleGrid.style.display = 'none';
                noResults.style.display = 'block';
            } else {
                scheduleGrid.style.display = 'grid';
                noResults.style.display = 'none';
            }
        }
    }

    // Event listeners
    if (academicYearFilter) {
        academicYearFilter.addEventListener('change', filterSchedules);
    }
    
    if (semesterFilter) {
        semesterFilter.addEventListener('change', filterSchedules);
    }
    
    if (resetButton) {
        resetButton.addEventListener('click', function() {
            if (academicYearFilter) academicYearFilter.value = '';
            if (semesterFilter) semesterFilter.value = '';
            filterSchedules();
        });
    }
});
</script>
@endsection