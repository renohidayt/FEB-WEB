@extends('layouts.app')

@section('title', $lecturer->name . ' - FEB UNSAP')

@section('content')
{{-- ================= HEADER SECTION ================= --}}
<div class="relative bg-slate-900 text-white pt-10 pb-20 overflow-hidden border-b border-white/5">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] z-0"></div>
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-orange-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob z-0"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <nav class="flex items-center text-xs md:text-sm font-medium mb-8 text-slate-400">
            <a href="{{ url('/') }}" class="hover:text-white transition-colors flex items-center gap-2 group">
                <i class="fas fa-home text-orange-500"></i> Beranda
            </a>
            <span class="mx-3 text-slate-700">/</span>
            <a href="{{ route('lecturers.index') }}" class="hover:text-white transition-colors">Daftar Dosen</a>
            <span class="mx-3 text-slate-700">/</span>
            <span class="text-orange-500 uppercase tracking-wider font-bold">{{ $lecturer->name }}</span>
        </nav>

        <div class="max-w-4xl">
            <h1 class="text-3xl md:text-5xl font-extrabold mb-4 tracking-tight leading-tight uppercase animate-fade-in-left">
                Profil <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Dosen</span>
            </h1>
            <div class="w-20 h-1.5 bg-orange-500 rounded-full"></div>
        </div>
    </div>
</div>

{{-- ================= MAIN CONTENT ================= --}}
<div class="bg-slate-50 py-16 relative z-20"> 
    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-start">
            
            {{-- === SIDEBAR KIRI === --}}
            <div class="lg:col-span-4">
                <div class="bg-white rounded-lg shadow-xl shadow-slate-200/40 overflow-hidden sticky top-24 border border-slate-100">
                    <div class="relative group">
                        {{-- Badge Status --}}
                        <div class="absolute top-4 right-4 z-20 flex flex-col gap-2">
                            @if($lecturer->is_active)
                                <span class="bg-green-500 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-lg">
                                    <i class="fas fa-check-circle mr-1"></i> Aktif
                                </span>
                            @else
                                <span class="bg-red-500 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-lg">
                                    Non-Aktif
                                </span>
                            @endif
                            
                            {{-- Employment Status Badge --}}
                            @if($lecturer->employment_status)
                                <span class="bg-blue-500 text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider shadow-lg">
                                    {{ $lecturer->employment_status }}
                                </span>
                            @endif
                        </div>

                        {{-- Foto Profil --}}
                        <div class="aspect-[3/4] overflow-hidden bg-slate-200">
                            <img 
                                src="{{ $lecturer->photo_url }}" 
                                alt="{{ $lecturer->name }}"
                                class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110"
                                onerror="this.src='{{ asset('images/default-lecturer.png') }}'"
                            >
                        </div>
                    </div>

                    <div class="p-6">
                        {{-- Nama --}}
                        <h2 class="text-2xl font-black text-slate-900 mb-1 leading-tight uppercase">
                            {{ $lecturer->name }}
                        </h2>
                        
                        {{-- Program Studi --}}
                        <p class="text-orange-600 font-bold text-[10px] tracking-[0.2em] mb-6 uppercase border-b border-slate-100 pb-4">
                            {{ $lecturer->study_program ?? '-' }}
                        </p>

                        <div class="space-y-4">
                            {{-- Gelar Akademik --}}
                            @if($lecturer->academic_degree)
                            <div class="flex items-start">
                                <div class="w-8 flex justify-center text-slate-400 mt-0.5"><i class="fas fa-graduation-cap"></i></div>
                                <div>
                                    <p class="text-[9px] uppercase tracking-widest text-slate-400 font-bold">Gelar Akademik</p>
                                    <p class="text-slate-900 font-bold text-sm">{{ $lecturer->academic_degree }}</p>
                                </div>
                            </div>
                            @endif

                            {{-- Jabatan Fungsional --}}
                            @if($lecturer->position)
                            <div class="flex items-start">
                                <div class="w-8 flex justify-center text-slate-400 mt-0.5"><i class="fas fa-briefcase"></i></div>
                                <div>
                                    <p class="text-[9px] uppercase tracking-widest text-slate-400 font-bold">Jabatan Fungsional</p>
                                    <p class="text-slate-900 font-bold text-sm">{{ $lecturer->position }}</p>
                                </div>
                            </div>
                            @endif

                            {{-- Jabatan Struktural --}}
                            @if($lecturer->structural_position)
                            <div class="flex items-start">
                                <div class="w-8 flex justify-center text-slate-400 mt-0.5"><i class="fas fa-user-tie"></i></div>
                                <div>
                                    <p class="text-[9px] uppercase tracking-widest text-slate-400 font-bold">Jabatan Struktural</p>
                                    <p class="text-slate-900 font-bold text-sm">{{ $lecturer->structural_position }}</p>
                                </div>
                            </div>
                            @endif

                            {{-- NIDN --}}
                            @if($lecturer->nidn)
                            <div class="flex items-start">
                                <div class="w-8 flex justify-center text-slate-400 mt-0.5"><i class="fas fa-id-card"></i></div>
                                <div>
                                    <p class="text-[9px] uppercase tracking-widest text-slate-400 font-bold">NIDN</p>
                                    <p class="text-slate-900 font-bold text-sm">{{ $lecturer->nidn }}</p>
                                </div>
                            </div>
                            @endif

                            {{-- Kontak --}}
                            <div class="pt-4 border-t border-slate-100 mt-4">
                                <p class="text-[10px] uppercase tracking-widest text-slate-900 font-black mb-3">Kontak</p>
                                
                                @if($lecturer->email)
                                <div class="flex items-center mb-3 group">
                                    <div class="w-8 flex justify-center text-orange-500"><i class="fas fa-envelope"></i></div>
                                    <a href="mailto:{{ $lecturer->email }}" class="text-slate-600 text-sm hover:text-orange-600 truncate transition-colors">
                                        {{ $lecturer->email }}
                                    </a>
                                </div>
                                @endif

                                @if($lecturer->phone)
                                <div class="flex items-center group">
                                    <div class="w-8 flex justify-center text-green-600"><i class="fab fa-whatsapp text-lg"></i></div>
                                    <a href="https://wa.me/{{ preg_replace('/^0/', '62', preg_replace('/[^0-9]/', '', $lecturer->phone)) }}" target="_blank" class="text-slate-600 text-sm hover:text-green-600 transition-colors">
                                        {{ $lecturer->phone }}
                                    </a>
                                </div>
                                @endif
                            </div>

                            {{-- Identitas Digital --}}
                            @if($lecturer->google_scholar_url || $lecturer->sinta_id || $lecturer->scopus_id || $lecturer->orcid)
                            <div class="pt-4 border-t border-slate-100 mt-4">
                                <p class="text-[10px] uppercase tracking-widest text-slate-900 font-black mb-3">Identitas Digital</p>
                                
                                @if($lecturer->google_scholar_url)
                                <div class="flex items-center mb-2">
                                    <div class="w-8 flex justify-center text-blue-600"><i class="fab fa-google"></i></div>
                                    <a href="{{ $lecturer->google_scholar_url }}" target="_blank" class="text-slate-600 text-xs hover:text-blue-600 transition-colors">
                                        Google Scholar
                                    </a>
                                </div>
                                @endif

                                @if($lecturer->sinta_id)
                                <div class="flex items-center mb-2">
                                    <div class="w-8 flex justify-center text-purple-600"><i class="fas fa-id-badge"></i></div>
                                    <a href="https://sinta.kemdikbud.go.id/authors/profile/{{ $lecturer->sinta_id }}" target="_blank" class="text-slate-600 text-xs hover:text-purple-600 transition-colors">
                                        SINTA: {{ $lecturer->sinta_id }}
                                    </a>
                                </div>
                                @endif

                                @if($lecturer->scopus_id)
                                <div class="flex items-center mb-2">
                                    <div class="w-8 flex justify-center text-orange-600"><i class="fas fa-graduation-cap"></i></div>
                                    <a href="https://www.scopus.com/authid/detail.uri?authorId={{ $lecturer->scopus_id }}" target="_blank" class="text-slate-600 text-xs hover:text-orange-600 transition-colors">
                                        Scopus: {{ $lecturer->scopus_id }}
                                    </a>
                                </div>
                                @endif

                                @if($lecturer->orcid)
                                <div class="flex items-center">
                                    <div class="w-8 flex justify-center text-green-600"><i class="fab fa-orcid"></i></div>
                                    <a href="https://orcid.org/{{ $lecturer->orcid }}" target="_blank" class="text-slate-600 text-xs hover:text-green-600 transition-colors">
                                        ORCID: {{ $lecturer->orcid }}
                                    </a>
                                </div>
                                @endif
                            </div>
                            @endif
                        </div>

                        <button onclick="shareProfile()" class="w-full mt-6 py-3 bg-slate-900 text-white rounded-md font-bold text-[10px] uppercase tracking-widest hover:bg-orange-600 transition-all shadow-md flex items-center justify-center gap-2">
                            <i class="fas fa-share-alt"></i> Share Profile
                        </button>
                    </div>
                </div>
            </div>

            {{-- === KONTEN KANAN === --}}
            <div class="lg:col-span-8 space-y-8">
                
                {{-- Riwayat Pendidikan --}}
                @if($lecturer->education_s1 || $lecturer->education_s2 || $lecturer->education_s3 || $lecturer->education_history)
                <div class="bg-white rounded-lg shadow-xl shadow-slate-200/50 p-8 md:p-10 border border-slate-100">
                    <div class="flex items-center gap-4 mb-6">
                        <span class="w-10 h-10 bg-blue-100 text-blue-600 rounded-md flex items-center justify-center text-lg">
                            <i class="fas fa-graduation-cap"></i>
                        </span>
                        <h3 class="text-lg md:text-xl font-black text-slate-900 uppercase">Riwayat Pendidikan</h3>
                    </div>
                    <div class="space-y-3">
                        @if($lecturer->education_s3)
                        <div class="flex items-start gap-3 pb-3 border-b border-slate-100">
                            <span class="text-xs font-bold text-orange-600 mt-1">S3</span>
                            <p class="text-slate-700 text-sm flex-1">{{ $lecturer->education_s3 }}</p>
                        </div>
                        @endif
                        
                        @if($lecturer->education_s2)
                        <div class="flex items-start gap-3 pb-3 border-b border-slate-100">
                            <span class="text-xs font-bold text-orange-600 mt-1">S2</span>
                            <p class="text-slate-700 text-sm flex-1">{{ $lecturer->education_s2 }}</p>
                        </div>
                        @endif
                        
                        @if($lecturer->education_s1)
                        <div class="flex items-start gap-3 pb-3 border-b border-slate-100">
                            <span class="text-xs font-bold text-orange-600 mt-1">S1</span>
                            <p class="text-slate-700 text-sm flex-1">{{ $lecturer->education_s1 }}</p>
                        </div>
                        @endif

                        @if($lecturer->education_history)
                        <div class="pt-2">
                            <p class="text-slate-600 text-sm leading-relaxed">{{ $lecturer->education_history }}</p>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                {{-- Bidang Keahlian & Minat Riset --}}
                <div class="bg-white rounded-lg shadow-xl shadow-slate-200/50 p-8 md:p-10 border border-slate-100">
                    <div class="flex items-center gap-4 mb-6">
                        <span class="w-10 h-10 bg-orange-100 text-orange-600 rounded-md flex items-center justify-center text-lg">
                            <i class="fas fa-lightbulb"></i>
                        </span>
                        <h3 class="text-lg md:text-xl font-black text-slate-900 uppercase">Bidang Keahlian</h3>
                    </div>
                    <p class="text-slate-600 leading-relaxed text-justify mb-4">
                        {{ $lecturer->expertise ?: 'Informasi keahlian belum ditambahkan.' }}
                    </p>

                    @if($lecturer->research_interests)
                    <div class="mt-6 pt-6 border-t border-slate-100">
                        <h4 class="text-sm font-bold text-slate-900 uppercase mb-3 flex items-center gap-2">
                            <i class="fas fa-flask text-purple-600"></i> Minat Riset
                        </h4>
                        <p class="text-slate-600 leading-relaxed text-justify">
                            {{ $lecturer->research_interests }}
                        </p>
                    </div>
                    @endif
                </div>

                {{-- Pengalaman Akademik --}}
                <div class="bg-white rounded-lg shadow-lg p-8 border border-slate-100">
                    <h4 class="flex items-center gap-3 text-slate-900 font-bold uppercase tracking-wider mb-6 text-sm">
                        <i class="fas fa-chalkboard-teacher text-green-500"></i> Pengalaman Akademik
                    </h4>
                    
                    {{-- Mata Kuliah --}}
                    @if($lecturer->courses_taught)
                    <div class="mb-6">
                        <p class="text-xs font-bold text-slate-400 uppercase mb-3">Mata Kuliah yang Diampu</p>
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $lecturer->courses_taught) as $course)
                                @if(trim($course) != '')
                                <span class="px-3 py-1.5 bg-slate-50 border border-slate-200 rounded text-slate-700 text-sm font-medium hover:border-orange-300 transition-colors">
                                    {{ trim($course) }}
                                </span>
                                @endif
                            @endforeach
                        </div>
                    </div>
                    @endif

                    {{-- Pengalaman Mengajar --}}
                    @if($lecturer->teaching_experience)
                    <div class="pt-6 border-t border-slate-100">
                        <p class="text-xs font-bold text-slate-400 uppercase mb-3">Pengalaman Mengajar</p>
                        <p class="text-slate-600 text-sm leading-relaxed whitespace-pre-line">{{ $lecturer->teaching_experience }}</p>
                    </div>
                    @endif
                </div>

                {{-- Publikasi & Penelitian --}}
                @if(!empty($publications) || !empty($conferencePapers) || !empty($books))
                <div class="bg-white rounded-lg shadow-xl shadow-slate-200/50 p-8 md:p-10 border border-slate-100">
                    <div class="flex items-center gap-4 mb-6">
                        <span class="w-10 h-10 bg-purple-100 text-purple-600 rounded-md flex items-center justify-center text-lg">
                            <i class="fas fa-book"></i>
                        </span>
                        <h3 class="text-lg md:text-xl font-black text-slate-900 uppercase">Publikasi & Penelitian</h3>
                    </div>

                    {{-- Jurnal --}}
                    @if(!empty($publications))
                    <div class="mb-6">
                        <h4 class="text-sm font-bold text-slate-900 uppercase mb-3 flex items-center gap-2">
                            <i class="fas fa-newspaper text-blue-600"></i> Publikasi Jurnal
                        </h4>
                        <ol class="list-decimal list-inside space-y-2">
                            @foreach($publications as $pub)
                            <li class="text-slate-600 text-sm leading-relaxed">{{ $pub }}</li>
                            @endforeach
                        </ol>
                    </div>
                    @endif

                    {{-- Prosiding --}}
                    @if(!empty($conferencePapers))
                    <div class="mb-6 pt-6 border-t border-slate-100">
                        <h4 class="text-sm font-bold text-slate-900 uppercase mb-3 flex items-center gap-2">
                            <i class="fas fa-file-alt text-green-600"></i> Prosiding Seminar/Konferensi
                        </h4>
                        <ol class="list-decimal list-inside space-y-2">
                            @foreach($conferencePapers as $paper)
                            <li class="text-slate-600 text-sm leading-relaxed">{{ $paper }}</li>
                            @endforeach
                        </ol>
                    </div>
                    @endif

                    {{-- Buku / HKI --}}
                    @if(!empty($books))
                    <div class="pt-6 border-t border-slate-100">
                        <h4 class="text-sm font-bold text-slate-900 uppercase mb-3 flex items-center gap-2">
                            <i class="fas fa-book-open text-orange-600"></i> Buku / HKI
                        </h4>
                        <ul class="list-disc list-inside space-y-2">
                            @foreach($books as $book)
                            <li class="text-slate-600 text-sm leading-relaxed">{{ $book }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
                @endif

                {{-- Pengabdian Masyarakat --}}
                @if(!empty($communityServices))
                <div class="bg-white rounded-lg shadow-xl shadow-slate-200/50 p-8 md:p-10 border border-slate-100">
                    <div class="flex items-center gap-4 mb-6">
                        <span class="w-10 h-10 bg-green-100 text-green-600 rounded-md flex items-center justify-center text-lg">
                            <i class="fas fa-hands-helping"></i>
                        </span>
                        <h3 class="text-lg md:text-xl font-black text-slate-900 uppercase">Pengabdian Masyarakat</h3>
                    </div>
                    <ul class="space-y-3">
                        @foreach($communityServices as $service)
                        <li class="flex items-start gap-3">
                            <span class="w-2 h-2 bg-orange-500 rounded-full mt-2 flex-shrink-0"></span>
                            <p class="text-slate-600 text-sm leading-relaxed">{{ $service }}</p>
                        </li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- Sertifikasi & Penghargaan --}}
                @if(!empty($certifications) || !empty($awards))
                <div class="bg-white rounded-lg shadow-xl shadow-slate-200/50 p-8 md:p-10 border border-slate-100">
                    <div class="flex items-center gap-4 mb-6">
                        <span class="w-10 h-10 bg-yellow-100 text-yellow-600 rounded-md flex items-center justify-center text-lg">
                            <i class="fas fa-award"></i>
                        </span>
                        <h3 class="text-lg md:text-xl font-black text-slate-900 uppercase">Sertifikasi & Penghargaan</h3>
                    </div>

                    @if(!empty($certifications))
                    <div class="mb-6">
                        <h4 class="text-sm font-bold text-slate-900 uppercase mb-3 flex items-center gap-2">
                            <i class="fas fa-certificate text-blue-600"></i> Sertifikasi
                        </h4>
                        <ul class="space-y-2">
                            @foreach($certifications as $cert)
                            <li class="flex items-start gap-3">
                                <i class="fas fa-check text-green-500 mt-1"></i>
                                <p class="text-slate-600 text-sm">{{ $cert }}</p>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif

                    @if(!empty($awards))
                    <div class="pt-6 border-t border-slate-100">
                        <h4 class="text-sm font-bold text-slate-900 uppercase mb-3 flex items-center gap-2">
                            <i class="fas fa-trophy text-yellow-600"></i> Penghargaan
                        </h4>
                        <ul class="space-y-2">
                            @foreach($awards as $award)
                            <li class="flex items-start gap-3">
                                <i class="fas fa-star text-yellow-500 mt-1"></i>
                                <p class="text-slate-600 text-sm">{{ $award }}</p>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                </div>
                @endif
            </div>
        </div>

        {{-- Footer Dosen Terkait --}}
        @if(isset($relatedLecturers) && $relatedLecturers->count() > 0)
        <div class="mt-24 border-t border-slate-200 pt-10">
            <div class="flex items-end justify-between mb-10">
                <div>
                    <h2 class="text-2xl font-black text-slate-900 uppercase tracking-tighter">Dosen Terkait</h2>
                    <p class="text-slate-400 text-sm mt-1 font-serif italic">Program Studi {{ $lecturer->study_program }}</p>
                </div>
                <a href="{{ route('lecturers.index') }}" class="text-orange-600 font-bold uppercase text-[10px] tracking-widest hover:underline">
                    Lihat Semua <i class="fas fa-arrow-right ml-1"></i>
                </a>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">
                @foreach($relatedLecturers as $related)
                <div class="flex justify-start">
                    <a href="{{ route('lecturers.show', $related->slug ?? $related->id) }}" class="group block w-full">
                        <div class="relative overflow-hidden shadow-xl bg-[#0E1035] rounded-lg border border-white/10 transition-all duration-300 hover:-translate-y-1">
                            <div class="relative h-64 overflow-hidden bg-slate-800">
                                <img src="{{ $related->photo_url }}" 
                                     class="w-full h-full object-cover transition-transform duration-700 ease-in-out group-hover:scale-110"
                                     onerror="this.src='{{ asset('images/default-lecturer.png') }}'">
                            </div>
                            <div class="px-4 py-4 text-center bg-[#0B0D2A]">
                                <h3 class="font-serif font-bold text-white text-[12px] leading-tight group-hover:text-orange-400 transition-colors uppercase truncate">
                                    {{ $related->name }}
                                </h3>
                                <p class="text-slate-500 text-[9px] mt-1 tracking-widest">
                                    {{ $related->position ?? 'Dosen' }}
                                </p>
                            </div>
                        </div>
                    </a>
                </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

<style>
    @keyframes blob {
        0%, 100% { transform: translate(0, 0) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
    }
    .animate-blob { animation: blob 7s infinite; }
    
    @keyframes fadeInLeft {
        from { opacity: 0; transform: translateX(-20px); }
        to { opacity: 1; transform: translateX(0); }
    }
    .animate-fade-in-left { animation: fadeInLeft 1s ease-out forwards; }
</style>

<script>
function shareProfile() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $lecturer->name }} - FEB UNSAP',
            text: 'Lihat profil akademik {{ $lecturer->name }}',
            url: window.location.href
        }).catch(() => {});
    } else {
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('Link berhasil disalin!');
        });
    }
}
</script>
@endsection