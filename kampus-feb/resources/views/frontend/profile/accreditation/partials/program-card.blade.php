{{-- Program Card Component - Modern & Professional --}}
<div class="group relative bg-white rounded-[1.5rem] border border-gray-100 shadow-[0_2px_15px_-3px_rgba(0,0,0,0.07),0_10px_20px_-2px_rgba(0,0,0,0.04)] hover:shadow-[0_8px_30px_rgb(0,0,0,0.12)] hover:border-gray-200 transition-all duration-300 overflow-hidden flex flex-col h-full">
    
    {{-- Logic Warna berdasarkan Grade --}}
    @php
        $isUnggul = in_array($accreditation->grade, ['A', 'Unggul']);
        $isBaikSekali = in_array($accreditation->grade, ['B', 'Baik Sekali']);
        
        // Base Colors
        $themeColor = $isUnggul ? 'emerald' : ($isBaikSekali ? 'blue' : 'amber');
        $gradientBg = $isUnggul ? 'bg-emerald-50/50' : ($isBaikSekali ? 'bg-blue-50/50' : 'bg-amber-50/50');
        $textColor = $isUnggul ? 'text-emerald-700' : ($isBaikSekali ? 'text-blue-700' : 'text-amber-700');
        $badgeBg = $isUnggul ? 'bg-emerald-100' : ($isBaikSekali ? 'bg-blue-100' : 'bg-amber-100');
    @endphp

    <div class="h-1.5 w-full bg-gradient-to-r {{ $isUnggul ? 'from-emerald-400 to-teal-500' : ($isBaikSekali ? 'from-blue-400 to-indigo-500' : 'from-amber-400 to-orange-500') }}"></div>

    <div class="p-6 flex-1 flex flex-col">
        <div class="flex justify-between items-start mb-6">
            <div class="flex-1 pr-4">
                @if($accreditation->category)
                <span class="inline-flex items-center px-2.5 py-1 rounded-md text-[10px] uppercase tracking-wider font-bold text-gray-500 bg-gray-50 border border-gray-100 mb-3">
                    {{ $accreditation->category }}
                </span>
                @endif
                
                <h3 class="text-xl font-bold text-gray-900 leading-snug tracking-tight group-hover:text-{{ $themeColor }}-600 transition-colors">
                    {{ $accreditation->study_program }}
                </h3>
            </div>

            <div class="flex flex-col items-center justify-center w-16 h-16 rounded-2xl {{ $badgeBg }} {{ $textColor }} shadow-sm flex-shrink-0 group-hover:scale-105 transition-transform duration-300">
                <span class="text-xs font-medium opacity-70">Grade</span>
                <span class="text-2xl font-extrabold leading-none mt-0.5">{{ $accreditation->grade }}</span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-3 mb-6">
            <div class="col-span-2 bg-gray-50 rounded-xl p-3 border border-gray-100/50 flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-white flex items-center justify-center text-gray-400 shadow-sm border border-gray-100">
                    <i class="fas fa-shield-alt text-xs"></i>
                </div>
                <div>
                    <p class="text-[10px] text-gray-400 uppercase font-semibold tracking-wide">Lembaga</p>
                    <p class="text-sm font-semibold text-gray-700 truncate">{{ $accreditation->accreditation_body }}</p>
                </div>
            </div>

            <div class="bg-gray-50 rounded-xl p-3 border border-gray-100/50">
                <p class="text-[10px] text-gray-400 uppercase font-semibold tracking-wide mb-1">Berlaku Hingga</p>
                <p class="text-sm font-bold text-gray-800">
                    {{ $accreditation->valid_until->format('d M Y') }}
                </p>
            </div>

            <div class="bg-gray-50 rounded-xl p-3 border border-gray-100/50 flex flex-col justify-center">
                @if(!$accreditation->isExpired())
                    <p class="text-[10px] text-gray-400 uppercase font-semibold tracking-wide mb-1">Status</p>
                    <div class="flex items-center gap-1.5">
                        <span class="relative flex h-2 w-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full {{ $accreditation->isExpiringSoon() ? 'bg-amber-400' : 'bg-emerald-400' }} opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 {{ $accreditation->isExpiringSoon() ? 'bg-amber-500' : 'bg-emerald-500' }}"></span>
                        </span>
                        <span class="text-xs font-semibold {{ $accreditation->isExpiringSoon() ? 'text-amber-600' : 'text-emerald-600' }}">
                            {{ $accreditation->remaining_days }} Hari Lagi
                        </span>
                    </div>
                @else
                    <span class="inline-flex items-center justify-center px-2 py-1 bg-red-100 text-red-700 text-xs font-bold rounded-lg">
                        Expired
                    </span>
                @endif
            </div>

            @if($accreditation->certificate_number)
            <div class="col-span-2 px-1">
                <p class="text-[10px] text-gray-400 font-mono text-center truncate">
                    SK: {{ $accreditation->certificate_number }}
                </p>
            </div>
            @endif
        </div>
    </div>

    <div class="p-4 bg-gray-50/80 border-t border-gray-100 backdrop-blur-sm mt-auto">
        @if($accreditation->certificate_file)
            <a href="{{ route('profile.accreditation.download', $accreditation->slug) }}" 
               class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-sm font-semibold text-white transition-all shadow-md hover:shadow-lg transform hover:-translate-y-0.5 focus:ring-2 focus:ring-offset-2 {{ 
                   $isUnggul ? 'bg-emerald-600 hover:bg-emerald-700 focus:ring-emerald-500' : 
                   ($isBaikSekali ? 'bg-blue-600 hover:bg-blue-700 focus:ring-blue-500' : 'bg-gray-800 hover:bg-gray-900 focus:ring-gray-600') 
               }}">
                <i class="fas fa-file-pdf"></i>
                <span>Unduh Sertifikat</span>
            </a>
        @else
            <button disabled class="flex items-center justify-center gap-2 w-full py-2.5 rounded-xl text-sm font-medium text-gray-400 bg-gray-200 cursor-not-allowed">
                <i class="fas fa-file-slash"></i>
                <span>Tidak Tersedia</span>
            </button>
        @endif
    </div>
</div>