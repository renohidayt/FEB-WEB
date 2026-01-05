@extends('layouts.app')
@php
    use App\Models\Scholarship;
@endphp

@section('content')
<div class="relative bg-slate-900 text-white pt-6 pb-16 overflow-hidden border-b border-white/5">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] z-0"></div>
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-orange-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob z-0"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-blue-700 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000 z-0"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        <nav class="w-full flex items-center text-sm font-medium mb-10">
            <a href="{{ url('/') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 group">
                <i class="fas fa-home text-orange-500/80 group-hover:text-orange-500 transition-colors"></i> 
                <span class="group-hover:underline decoration-orange-500 decoration-2 underline-offset-4">Beranda</span>
            </a>
            <span class="mx-3 text-slate-600">/</span>
            <span class="text-orange-500 font-semibold cursor-default">Beasiswa</span>
        </nav>

        <div class="grid md:grid-cols-2 gap-8 items-center">
            <div class="text-left animate-fade-in-left"> 
                
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 tracking-tight leading-tight uppercase">
                    Informasi <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Beasiswa</span>
                </h1>
                <div class="w-20 h-1.5 bg-orange-500 mb-6 rounded-full"></div>
                <p class="text-lg text-slate-300 font-light leading-relaxed max-w-lg">
                    Wujudkan impian akademik Anda melalui berbagai jalur pendanaan prestasi dan bantuan pendidikan di Fakultas Ekonomi dan Bisnis UNSAP.
                </p>
            </div>

            <div class="hidden md:block relative h-[280px] flex items-center justify-center perspective-1000">
                
                <div class="absolute w-56 h-56 bg-orange-500/10 rounded-full blur-[60px]"></div>

                <div class="relative w-72 bg-slate-800/40 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl transform -rotate-y-6 hover:rotate-y-0 transition-transform duration-700">
                    <div class="bg-gradient-to-br from-slate-700/50 to-slate-800/50 h-32 rounded-xl mb-4 flex items-center justify-center border border-white/5 group">
                        <i class="fas fa-hand-holding-usd text-5xl text-slate-500 group-hover:text-orange-500 transition-all duration-500 transform group-hover:scale-110"></i>
                    </div>

                    <div class="space-y-3">
                        <div class="flex justify-between items-end mb-1">
                            <div class="h-1.5 bg-orange-500 rounded-full w-3/4"></div>
                            <span class="text-[10px] text-orange-500 font-bold leading-none">Kuota Tersedia</span>
                        </div>
                        <div class="h-1.5 bg-slate-600/30 rounded-full w-full"></div>
                    </div>
                </div>

                <div class="absolute -top-6 right-6 bg-slate-800/95 backdrop-blur-md border border-orange-500/30 p-4 rounded-2xl shadow-xl animate-bounce" style="animation-duration: 3s;">
                    <div class="flex flex-col items-center">
                        <div class="w-12 h-12 rounded-full bg-orange-500 shadow-[0_0_15px_rgba(249,115,22,0.4)] flex items-center justify-center mb-1">
                            <i class="fas fa-award text-white text-xl"></i>
                        </div>
                        <span class="text-[10px] font-bold text-white tracking-wider uppercase">Prestasi</span>
                    </div>
                </div>

                <div class="absolute -bottom-6 left-6 bg-slate-800/90 backdrop-blur-md border border-blue-500/30 p-3 rounded-xl shadow-xl animate-bounce" style="animation-duration: 4s;">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-500/20 flex items-center justify-center text-blue-400">
                            <i class="fas fa-graduation-cap text-sm"></i>
                        </div>
                        <div>
                            <p class="text-[9px] text-slate-400 uppercase leading-none mb-1 tracking-tighter">Bantuan</p>
                            <p class="text-xs font-bold text-white leading-none">Pendidikan</p>
                        </div>
                    </div>
                </div>

            </div>
            </div>
    </div>
</div>

    <div class="container mx-auto px-4 mt-16 relative z-20">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @php
                $statItems = [
                    ['label' => 'Total Beasiswa', 'val' => $stats['total'], 'icon' => 'fa-graduation-cap', 'color' => 'blue'],
                    ['label' => 'Pendaftaran Dibuka', 'val' => $stats['open'], 'icon' => 'fa-door-open', 'color' => 'emerald'],
                    ['label' => 'Segera Dibuka', 'val' => $stats['upcoming'], 'icon' => 'fa-clock', 'color' => 'orange'],
                ];
            @endphp
            @foreach($statItems as $item)
            <div class="bg-slate-50 border border-slate-200 rounded-2xl shadow-md p-6 flex items-center gap-5 group hover:translate-y-[-5px] transition-all duration-300">
    <div class="w-14 h-14 bg-{{ $item['color'] }}-50 text-{{ $item['color'] }}-600 rounded-xl flex items-center justify-center text-2xl group-hover:bg-{{ $item['color'] }}-600 group-hover:text-white transition-colors">
        <i class="fas {{ $item['icon'] }}"></i>
    </div>
    <div>
        <p class="text-slate-500 text-xs font-bold uppercase tracking-wider">{{ $item['label'] }}</p>
        <p class="text-3xl font-black text-slate-900">{{ $item['val'] }}</p>
    </div>
</div>

            @endforeach
        </div>
    </div>

   <div class="container mx-auto px-4 pt-16 pb-8">
    <div class="bg-slate-50 rounded-3xl shadow-md border border-slate-200 p-4">
        <form method="GET" action="{{ route('scholarships.index') }}" class="flex flex-wrap md:flex-nowrap gap-3">
            
            <div class="relative flex-grow">
                <i class="fas fa-search absolute left-4 top-1/2 -translate-y-1/2 text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari beasiswa..." 
                    class="w-full pl-11 pr-4 py-3.5 bg-white border border-slate-200 rounded-2xl focus:ring-2 focus:ring-orange-500/20 transition-all">
            </div>

            <select name="category" 
                class="w-full md:w-48 py-3.5 bg-white border border-slate-200 rounded-2xl focus:ring-2 focus:ring-orange-500/20 cursor-pointer">
                <option value="">Semua Kategori</option>
                @foreach($categories as $key => $value)
                    <option value="{{ $key }}" {{ request('category') == $key ? 'selected' : '' }}>
                        {{ $value }}
                    </option>
                @endforeach
            </select>

            <button type="submit" 
                class="w-full md:w-auto px-8 py-3.5 bg-slate-900 text-white rounded-2xl font-bold hover:bg-orange-600 transition-all shadow-lg active:scale-95">
                Filter
            </button>

            @if(request()->anyFilled(['search', 'category', 'status']))
            <a href="{{ route('scholarships.index') }}" 
                class="flex items-center justify-center w-12 h-12 bg-white border border-slate-200 text-slate-500 rounded-2xl hover:bg-red-50 hover:text-red-500 transition-colors">
                <i class="fas fa-redo"></i>
            </a>
            @endif

        </form>
    </div>
</div>


    <div class="container mx-auto px-4 pb-20">
    @if($scholarships->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($scholarships as $scholarship)
                <div class="group bg-slate-50 rounded-xl border border-slate-200 shadow-md hover:shadow-xl transition-all duration-500 flex flex-col overflow-hidden">

                    <div class="relative h-52 overflow-hidden bg-slate-200">
                        @if($scholarship->poster)
                            <img src="{{ asset('storage/' . $scholarship->poster) }}" alt="{{ $scholarship->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-700">
                        @else
                            <div class="w-full h-full bg-gradient-to-br from-slate-700 to-slate-900 flex items-center justify-center">
                                <i class="fas fa-university text-5xl text-white/20"></i>
                            </div>
                        @endif
                        
                        <div class="absolute top-5 left-5 right-5 flex justify-between items-start">
                            <span class="px-3 py-1.5 bg-white/90 backdrop-blur-md text-slate-900 text-[10px] font-black uppercase tracking-widest rounded-lg shadow-sm">
                                {{ Scholarship::categories()[$scholarship->category] ?? $scholarship->category }}
                            </span>
                            <div class="transform scale-90 origin-right">
                                {!! $scholarship->getStatusBadge() !!}
                            </div>
                        </div>
                    </div>

                    <div class="p-8 flex flex-col flex-1">
                        <h3 class="text-xl font-bold text-slate-900 mb-2 group-hover:text-orange-600 transition-colors line-clamp-2 leading-snug">
                            {{ $scholarship->name }}
                        </h3>
                        
                        <div class="flex items-center gap-2 text-slate-400 text-sm mb-4">
                            <i class="fas fa-building text-orange-500/70"></i>
                            <span class="truncate">{{ $scholarship->provider ?? 'FEB UNSAP' }}</span>
                        </div>

                        <div class="mb-6 flex-1">
                            <div class="p-4 bg-slate-50 rounded-lg border border-slate-100">
                                <p class="text-[10px] text-slate-400 font-bold uppercase tracking-wider mb-1">Estimasi Bantuan</p>
                                <p class="text-lg font-black text-slate-900">{{ $scholarship->getFormattedAmount() }}</p>
                            </div>
                        </div>

                        <div class="space-y-3 mb-8">
                            <div class="flex items-center text-sm text-slate-600 font-medium">
                                <i class="fas fa-calendar-alt text-orange-500 mr-3 w-4"></i>
                                {{ $scholarship->registration_end ? $scholarship->registration_end->format('d M Y') : 'TBA' }}
                            </div>
                            @if($scholarship->getRemainingDays() !== null)
                            <div class="flex items-center text-sm font-bold text-blue-600">
                                <i class="fas fa-hourglass-half mr-3 w-4"></i>
                                {{ $scholarship->getRemainingDays() }} Hari Tersisa
                            </div>
                            @endif
                        </div>

                        <a href="{{ route('scholarships.show', $scholarship->id) }}" class="flex items-center justify-center gap-2 w-full py-3.5 bg-slate-900 text-white rounded-xl font-bold hover:bg-orange-600 transition-all shadow-lg active:scale-95">
                            Detail Beasiswa <i class="fas fa-arrow-right text-xs"></i>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="mt-12">
            {{ $scholarships->links() }}
        </div>
    @else
        <div class="py-20 text-center bg-white rounded-xl border-2 border-dashed border-slate-200">
            <div class="w-20 h-20 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-search text-3xl text-slate-300"></i>
            </div>
            <h3 class="text-xl font-bold text-slate-900">Belum Ada Data</h3>
            <p class="text-slate-500">Coba ubah filter atau kata kunci pencarian Anda.</p>
        </div>
    @endif
</div>
   <div class="container mx-auto px-4 pb-20">
    <div class="relative bg-slate-900 rounded-[2rem] p-8 md:p-12 text-center overflow-hidden shadow-xl border border-white/5">
        <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] z-0"></div>
        <div class="absolute top-0 right-0 -mr-16 -mt-16 w-60 h-60 bg-orange-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob z-0"></div>
        <div class="absolute bottom-0 left-0 -ml-16 -mb-16 w-60 h-60 bg-blue-700 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000 z-0"></div>

        <div class="relative z-10">
            
            <h2 class="text-2xl md:text-4xl font-black text-white mb-4 leading-tight uppercase tracking-tight">
                Butuh Bantuan <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Pendaftaran?</span>
            </h2>
            
            <p class="text-slate-400 max-w-xl mx-auto mb-8 text-base font-light leading-relaxed">
                Hubungi bagian administrasi kemahasiswaan FEB UNSAP jika Anda menemui kendala selama proses pendaftaran beasiswa.
            </p>

            <div class="flex flex-wrap justify-center gap-3">
                <a href="https://wa.me/6285315654194?text=Halo%20Admin%20FEB%20UNSAP." class="group relative px-8 py-3.5 bg-orange-500 text-white rounded-xl font-bold transition-all shadow-lg hover:shadow-orange-500/40 hover:-translate-y-1 active:scale-95 overflow-hidden">
                    <span class="relative z-10 flex items-center gap-2">
                        <i class="fab fa-whatsapp text-xl"></i> Hubungi Admin
                    </span>
                    <div class="absolute inset-0 bg-white opacity-0 group-hover:opacity-20 transition-opacity"></div>
                </a>

                <a href="https://pmb.unsap.ac.id/beasiswa/" class="px-8 py-3.5 bg-white/5 text-white backdrop-blur-md border border-white/10 rounded-xl font-bold hover:bg-white/10 hover:border-white/20 transition-all active:scale-95 text-sm">
                    Informasi Beasiswa
                </a>
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
    .animate-fade-in { animation: fadeIn 0.8s ease-out; }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection