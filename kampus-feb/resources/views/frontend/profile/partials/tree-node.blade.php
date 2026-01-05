{{-- resources/views/frontend/profile/partials/tree-node.blade.php --}}

@php
    $isRoot = $level === 0;

    // --- DATA SENAT MANUAL DITAMBAHKAN DI SINI ---
    $senatNodeManual = (object) [
        'name' => 'Senat Fakultas',
        'position' => 'Badan Pertimbangan & Legislatif',
        'photo' => null,
        'nip' => null,
        'email' => null,
        'phone' => null,
        'description' => 'Lembaga normatif tertinggi di tingkat fakultas yang menjalankan fungsi pertimbangan, penetapan kebijakan akademik, dan pengawasan terhadap tata kelola fakultas.',
    ];
    // --- AKHIR DATA SENAT MANUAL ---

    // --- LOGIC FILTER DATA ---
    $wakilDekans = $node->children->filter(function($child) {
        return $child->is_active && (
            stripos($child->position, 'wakil dekan') !== false ||
            stripos($child->position, 'wadir') !== false
        );
    });

    $staffLangsung = $node->children->filter(function($child) use ($wakilDekans) {
        return $child->is_active && !$wakilDekans->contains($child);
    });

    // --- HELPER: Styles Mapper untuk Tailwind ---
   function getCardStyles($position) {
        $position = strtolower($position);
        
        // 1. PRIORITAS UTAMA: Struktural (Blue Theme)
        if (stripos($position, 'dekan') !== false ||
            stripos($position, 'wakil') !== false ||
            stripos($position, 'wadir') !== false ||
            stripos($position, 'ketua') !== false || 
            stripos($position, 'kepala upt') !== false ||
            stripos($position, 'senat') !== false) {
            return [
                'card' => 'bg-[#5B7FDB] text-white border-white/20 hover:bg-[#4a6bc9] shadow-[0_6px_20px_rgba(91,127,219,0.3)] hover:shadow-[0_16px_32px_rgba(91,127,219,0.4)]',
                'text_primary' => 'text-white',
                'text_secondary' => 'text-blue-100',
                'nip_bg' => 'bg-white/20 text-white border-white/30',
                'modal_gradient' => 'from-blue-600 to-blue-800'
            ];
        }

        // 2. PRIORITAS KEDUA: Administratif (Purple Theme)
        if (stripos($position, 'staff') !== false ||
            stripos($position, 'administrasi') !== false ||
            stripos($position, 'administratif') !== false ||
            stripos($position, 'sekretaris') !== false ||
            stripos($position, 'tata usaha') !== false ||
            stripos($position, 'kasubag') !== false ||
            stripos($position, 'layanan') !== false ||
            stripos($position, 'umum') !== false || 
            stripos($position, 'kemahasiswaan') !== false) {
            return [
                'card' => 'bg-[#8B5CF6] text-white border-white/20 hover:bg-[#7c3aed] shadow-[0_3px_10px_rgba(139,92,246,0.3)] hover:shadow-[0_10px_20px_rgba(139,92,246,0.4)]',
                'text_primary' => 'text-white',
                'text_secondary' => 'text-purple-100',
                'nip_bg' => 'bg-white/20 text-white border-white/30',
                'modal_gradient' => 'from-purple-600 to-purple-800'
            ];
        }

        // 3. PRIORITAS KETIGA: Akademik (Green Theme)
        if (stripos($position, 'program studi') !== false ||
            stripos($position, 'prodi') !== false ||
            stripos($position, 'kaprodi') !== false ||
            stripos($position, 'departemen') !== false ||
            stripos($position, 'dosen') !== false ||
            stripos($position, 'lektor') !== false ||
            stripos($position, 'guru besar') !== false ||
            stripos($position, 'akademik') !== false) {
            return [
                'card' => 'bg-[#5FAD56] text-white border-white/20 hover:bg-[#4f9747] shadow-[0_4px_12px_rgba(95,173,86,0.3)] hover:shadow-[0_12px_24px_rgba(95,173,86,0.4)]',
                'text_primary' => 'text-white',
                'text_secondary' => 'text-green-100',
                'nip_bg' => 'bg-white/20 text-white border-white/30',
                'modal_gradient' => 'from-green-600 to-green-800'
            ];
        }

        // 4. Fallback
        return [
            'card' => 'bg-[#8B5CF6] text-white border-white/20 hover:bg-[#7c3aed] shadow-[0_3px_10px_rgba(139,92,246,0.3)] hover:shadow-[0_10px_20px_rgba(139,92,246,0.4)]',
            'text_primary' => 'text-white',
            'text_secondary' => 'text-purple-100',
            'nip_bg' => 'bg-white/20 text-white border-white/30',
            'modal_gradient' => 'from-purple-600 to-purple-800'
        ];
    }
@endphp

@if($isRoot)
<style>
    /* * TREE CONNECTOR LINES */
    .tree-canvas ul { padding-top: 20px; position: relative; transition: all 0.5s; display: flex; justify-content: center; }
    .tree-canvas li { float: left; text-align: center; list-style-type: none; position: relative; padding: 20px 5px 0 5px; transition: all 0.5s; }

    /* Garis Vertikal & Horizontal */
    .tree-canvas li::before, .tree-canvas li::after {
        content: ''; position: absolute; top: 0; right: 50%;
        border-top: 2px solid rgba(255,255,255,0.3); width: 50%; height: 20px;
    }
    .tree-canvas li::after { right: auto; left: 50%; border-left: 2px solid rgba(255,255,255,0.3); }

    /* Menghilangkan garis untuk elemen tunggal/pertama/terakhir */
    .tree-canvas li:only-child::after, .tree-canvas li:only-child::before { display: none; }
    .tree-canvas li:only-child { padding-top: 0; }
    .tree-canvas li:first-child::before, .tree-canvas li:last-child::after { border: 0 none; }
    .tree-canvas li:last-child::before { border-right: 2px solid rgba(255,255,255,0.3); border-radius: 0 5px 0 0; }
    .tree-canvas li:first-child::after { border-radius: 5px 0 0 0; }

    /* Garis turun ke anak */
    .tree-canvas ul ul::before {
        content: ''; position: absolute; top: 0; left: 50%;
        border-left: 2px solid rgba(255,255,255,0.3); width: 0; height: 20px;
    }

    /* Animation Keyframes */
    @keyframes float { 0%, 100% { transform: translateY(0px) rotate(0deg); } 50% { transform: translateY(-20px) rotate(5deg); } }
    .animate-float-slow { animation: float 6s ease-in-out infinite; }
    .animate-float-reverse { animation: float 8s ease-in-out infinite reverse; }

    /* Fix Staff Line Dynamic */
    .staff-tree-connector::before {
        content: ''; position: absolute; width: 2px; background-color: rgba(255,255,255,0.3); left: 50%; z-index: 0;
    }

    /* Modal Animation */
    @keyframes modalFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }
    @keyframes modalSlideUp {
        from { transform: translateY(50px) scale(0.95); opacity: 0; }
        to { transform: translateY(0) scale(1); opacity: 1; }
    }
    .modal-overlay { animation: modalFadeIn 0.3s ease-out; }
    .modal-content { animation: modalSlideUp 0.3s ease-out; }

    /* Clickable card cursor */
    .org-card-clickable { cursor: pointer; }
    .org-card-clickable:active { transform: scale(0.98) !important; }

    /* RESPONSIVE: Senat Mobile Styling */
    @media (max-width: 768px) {
        /* Dekan Card - Lebih Kecil di Mobile */
        #dekan-node {
            width: 160px !important;
            padding: 0.875rem !important;
        }
        
        #dekan-node .w-\[80px\] {
            width: 50px !important;
            height: 50px !important;
        }
        
        #dekan-node h4 {
            font-size: 0.875rem !important;
            margin-bottom: 0.25rem !important;
        }
        
        #dekan-node span {
            font-size: 0.625rem !important;
            margin-bottom: 0.5rem !important;
        }
        
        #dekan-node .text-\[10px\] {
            font-size: 0.5rem !important;
            padding: 0.125rem 0.375rem !important;
        }
        
        /* Senat Container - Lebih Dekat ke Dekan */
        .senat-container {
            position: absolute !important;
            left: 50% !important;
            margin-left: 90px !important; /* Lebih dekat dari 120px */
            top: 0 !important;
        }
        
        /* Senat Card - Ukuran Konsisten */
        .senat-card-mobile {
            width: 140px !important;
            padding: 0.625rem !important;
        }
        
        .senat-card-mobile h4 {
            font-size: 0.75rem !important;
            line-height: 1.2 !important;
        }
        
        .senat-card-mobile span {
            font-size: 0.5rem !important;
            line-height: 1.2 !important;
        }
        
        /* Senat Icon - Lebih Kecil */
        .senat-icon-mobile {
            width: 1.75rem !important;
            height: 1.75rem !important;
        }
        
        .senat-icon-mobile i {
            font-size: 0.75rem !important;
        }
        
        /* Garis Penghubung - Lebih Pendek */
        .senat-horizontal-line {
            width: 25px !important;
            right: calc(100% + 2px) !important;
        }
    }
</style>

<div class="relative w-full overflow-x-auto bg-[#0f172a] rounded-[20px] p-8 md:p-14 font-sans select-none org-tree-wrapper">
    
       {{-- BACKGROUND PATTERN --}}
    <div class="absolute inset-0 overflow-hidden pointer-events-none rounded-[20px]">
        <svg class="absolute top-10 left-10 w-48 h-48 opacity-10 animate-float-slow text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zm0 9l2.5-1.25L12 8.5l-2.5 1.25L12 11zm0 2.5l-5-2.5-5 2.5L12 22l10-8.5-5-2.5-5 2.5z"/></svg>
    </div>

    <div class="tree-canvas min-w-max mx-auto text-center relative z-10">

        {{-- AREA ATAS: DEKAN & SENAT (SEJAJAR UNTUK SEMUA UKURAN LAYAR) --}}
        <div class="relative flex flex-col items-center justify-center mb-6">
            
            {{-- 1. DEKAN (CENTER) --}}
            <div class="relative z-20 flex flex-col items-center">
                @php $styles = getCardStyles($node->position); @endphp
                <div id="dekan-node" 
                     onclick="openModal('node-{{ $node->id }}', {{ json_encode($node) }})"
                     class="p-5 rounded-xl border-2 {{ $styles['card'] }} w-[240px] org-card-clickable relative z-20">
                    
                    {{-- Photo --}}
                    <div class="w-[80px] h-[80px] mx-auto mb-3 relative">
                        @if($node->photo)
                            <img src="{{ asset('storage/' . $node->photo) }}" class="w-full h-full object-cover rounded-full border-4 border-white/30 shadow-sm" alt="{{ $node->name }}">
                        @else
                            <div class="w-full h-full bg-white/20 rounded-full flex items-center justify-center text-white text-2xl border-2 border-white/40"><i class="fas fa-user"></i></div>
                        @endif
                    </div>
                    {{-- Info --}}
                    <div>
                        <h4 class="font-bold text-lg leading-tight mb-1 {{ $styles['text_primary'] }}">{{ $node->name }}</h4>
                        <span class="block text-xs font-bold uppercase tracking-wider mb-2 {{ $styles['text_secondary'] }}">{{ $node->position }}</span>
                        @if($node->nip) 
                            <div class="inline-block text-[10px] px-2 py-0.5 rounded font-mono border {{ $styles['nip_bg'] }}">{{ $node->nip }}</div> 
                        @endif
                    </div>
                </div>

              
            </div>

            {{-- 2. SENAT (UNTUK SEMUA UKURAN LAYAR - SELALU DI SAMPING) --}}
            <div class="senat-container absolute top-0 left-[50%] ml-[100px] md:ml-[180px] flex items-center z-10">
                
                {{-- Garis Penghubung Horizontal (Dashed) ke Dekan --}}
                <div class="senat-horizontal-line absolute right-full top-[50%] w-[40px] md:w-[60px] h-[2px] border-t-2 border-dashed border-white/60 mr-2"></div>
                
                @php $senatStyles = getCardStyles($senatNodeManual->position); @endphp
                <div onclick="openModal('senat', {{ json_encode($senatNodeManual) }})"
                     class="senat-card-mobile p-4 rounded-xl border-2 {{ $senatStyles['card'] }} w-[220px] org-card-clickable hover:-translate-y-1 transition-transform">
                    <div class="flex items-center gap-3">
                        <div class="senat-icon-mobile w-12 h-12 flex-shrink-0 bg-white/20 rounded-full flex items-center justify-center border-2 border-white/30">
                            <i class="fas fa-users text-white"></i>
                        </div>
                        <div class="text-left">
                            <h4 class="font-bold text-sm leading-tight {{ $senatStyles['text_primary'] }}">Senat Fakultas</h4>
                            <span class="text-[10px] uppercase {{ $senatStyles['text_secondary'] }}">Badan Pertimbangan</span>
                        </div>
                    </div>
                </div>
            </div>

        </div> 
        {{-- END AREA ATAS --}}

        {{-- HIERARKI DARI DEKAN KE BAWAH --}}
        <div class="flex justify-center">
            <ul>
                <li class="p-0 pt-0 relative">

                    {{-- LEVEL 2: WAKIL DEKAN --}}
                    @if($wakilDekans->count() > 0)
                        <ul>
                            @foreach($wakilDekans as $wakil)
                                @php $wStyles = getCardStyles($wakil->position); @endphp
                                <li>
                                    <div onclick="openModal('node-{{ $wakil->id }}', {{ json_encode($wakil) }})"
                                         class="inline-block p-3.5 rounded-xl border transition-all duration-300 transform hover:-translate-y-1.5 relative z-20 min-w-[160px] max-w-[200px] org-card-clickable {{ $wStyles['card'] }}">
                                        <div class="w-14 h-14 mx-auto mb-2.5 relative">
                                            @if($wakil->photo)
                                                <img src="{{ asset('storage/' . $wakil->photo) }}" class="w-full h-full object-cover rounded-full border-[3px] border-white/90 shadow-sm" alt="{{ $wakil->name }}">
                                            @else
                                                <div class="w-full h-full bg-white/20 rounded-full flex items-center justify-center text-white text-lg border-2 border-white/40">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="m-0 font-bold text-sm leading-tight mb-1 {{ $wStyles['text_primary'] }}">{{ $wakil->name }}</h4>
                                            <span class="block text-[0.65rem] font-medium uppercase tracking-wide mb-1.5 {{ $wStyles['text_secondary'] }}">{{ $wakil->position }}</span>
                                            @if($wakil->nip) 
                                                <div class="inline-block text-[0.6rem] px-2 py-0.5 rounded font-mono border {{ $wStyles['nip_bg'] }}">{{ $wakil->nip }}</div> 
                                            @endif
                                        </div>
                                    </div>

                                    {{-- LEVEL 3: CHILDREN DARI WAKIL --}}
                                    @php $activeChildren = $wakil->children->where('is_active', true); @endphp
                                    @if($activeChildren->count() > 0)
                                        <ul>
                                            @foreach($activeChildren as $child)
                                                @php $cStyles = getCardStyles($child->position); @endphp
                                                <li>
                                                    <div onclick="openModal('node-{{ $child->id }}', {{ json_encode($child) }})"
                                                         class="inline-block p-2.5 rounded-xl border transition-all duration-300 transform hover:-translate-y-1.5 relative z-20 min-w-[130px] max-w-[170px] org-card-clickable {{ $cStyles['card'] }}">
                                                        <div class="w-14 h-14 mx-auto mb-2.5 relative">
                                                            @if($child->photo)
                                                                <img src="{{ asset('storage/' . $child->photo) }}" class="w-full h-full object-cover rounded-full border-[3px] border-white/90 shadow-sm" alt="{{ $child->name }}">
                                                            @else
                                                                <div class="w-full h-full bg-white/20 rounded-full flex items-center justify-center text-white text-lg border-2 border-white/40">
                                                                    <i class="fas fa-user"></i>
                                                                </div>
                                                            @endif
                                                        </div>
                                                        <div>
                                                            <h5 class="m-0 font-bold text-[0.8rem] leading-tight mb-1 {{ $cStyles['text_primary'] }}">{{ $child->name }}</h5>
                                                            <span class="block text-[0.65rem] font-medium uppercase tracking-wide mb-1 {{ $cStyles['text_secondary'] }}">{{ $child->position }}</span>
                                                            @if($child->nip) 
                                                                <div class="inline-block text-[0.6rem] px-2 py-0.5 rounded font-mono border {{ $cStyles['nip_bg'] }}">{{ $child->nip }}</div> 
                                                            @endif
                                                        </div>
                                                    </div>

                                                    {{-- LEVEL 4: Sub-children --}}
                                                    @php $subChildren = $child->children->where('is_active', true); @endphp
                                                    @if($subChildren->count() > 0)
                                                        <ul>
                                                            @foreach($subChildren as $subChild)
                                                                @php $scStyles = getCardStyles($subChild->position); @endphp
                                                                <li>
                                                                    <div onclick="openModal('node-{{ $subChild->id }}', {{ json_encode($subChild) }})"
                                                                         class="inline-block p-2.5 rounded-xl border transition-all duration-300 transform hover:-translate-y-1.5 relative z-20 min-w-[130px] org-card-clickable {{ $scStyles['card'] }}">
                                                                        <div class="w-14 h-14 mx-auto mb-2.5 relative">
                                                                            @if($subChild->photo)
                                                                                <img src="{{ asset('storage/' . $subChild->photo) }}" class="w-full h-full object-cover rounded-full border-[3px] border-white/90 shadow-sm" alt="{{ $subChild->name }}">
                                                                            @else
                                                                                <div class="w-full h-full bg-white/20 rounded-full flex items-center justify-center text-white text-lg border-2 border-white/40">
                                                                                    <i class="fas fa-user"></i>
                                                                                </div>
                                                                            @endif
                                                                        </div>
                                                                        <div>
                                                                            <h5 class="m-0 font-bold text-[0.8rem] leading-tight mb-1 {{ $scStyles['text_primary'] }}">{{ $subChild->name }}</h5>
                                                                            <span class="block text-[0.65rem] font-medium uppercase tracking-wide {{ $scStyles['text_secondary'] }}">{{ $subChild->position }}</span>
                                                                        </div>
                                                                    </div>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    
                    {{-- KHUSUS: STAFF LANGSUNG --}}
                    @if($staffLangsung->count() > 0)
                        <ul id="staff-tree" class="staff-tree-connector mt-10">
                            @foreach($staffLangsung as $staff)
                                @php $sStyles = getCardStyles($staff->position); @endphp
                                <li>
                                    <div onclick="openModal('node-{{ $staff->id }}', {{ json_encode($staff) }})"
                                         class="inline-block p-2.5 rounded-xl border transition-all duration-300 transform hover:-translate-y-1.5 relative z-20 min-w-[130px] max-w-[160px] org-card-clickable {{ $sStyles['card'] }}">
                                        <div class="w-14 h-14 mx-auto mb-2.5 relative">
                                            @if($staff->photo)
                                                <img src="{{ asset('storage/' . $staff->photo) }}" class="w-full h-full object-cover rounded-full border-[3px] border-white/90 shadow-sm" alt="{{ $staff->name }}">
                                            @else
                                                <div class="w-full h-full bg-white/20 rounded-full flex items-center justify-center text-white text-lg border-2 border-white/40">
                                                    <i class="fas fa-user"></i>
                                                </div>
                                            @endif
                                        </div>
                                        <div>
                                            <h5 class="m-0 font-bold text-[0.8rem] leading-tight mb-1 {{ $sStyles['text_primary'] }}">{{ $staff->name }}</h5>
                                            <span class="block text-[0.65rem] font-medium uppercase tracking-wide mb-1 {{ $sStyles['text_secondary'] }}">{{ $staff->position }}</span>
                                            @if($staff->nip) 
                                                <div class="inline-block text-[0.6rem] px-2 py-0.5 rounded font-mono border {{ $sStyles['nip_bg'] }}">{{ $staff->nip }}</div> 
                                            @endif
                                        </div>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </li>
            </ul>
        </div>
    </div>
</div>

{{-- MODAL DETAIL --}}
<div id="detailModal" class="fixed inset-0 bg-black/60 backdrop-blur-sm hidden items-center justify-center z-[9999] modal-overlay px-4" onclick="closeModal(event)">
    <div class="bg-white rounded-2xl shadow-2xl max-w-2xl w-full max-h-[90vh] overflow-y-auto modal-content" onclick="event.stopPropagation()">
        
        {{-- Header with Gradient --}}
        <div id="modalHeader" class="bg-gradient-to-r p-6 text-white relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-white/10 rounded-full -mr-32 -mt-32"></div>
            <div class="absolute bottom-0 left-0 w-48 h-48 bg-white/10 rounded-full -ml-24 -mb-24"></div>
            
            <button onclick="closeModal()" 
                    class="absolute top-4 right-4 z-50 w-12 h-12 flex items-center justify-center bg-white/20 hover:bg-white/40 backdrop-blur-sm rounded-full transition-all duration-200 cursor-pointer shadow-sm hover:shadow-md hover:scale-110 active:scale-95 group">
                <i class="fas fa-times text-xl group-hover:text-white transition-colors"></i>
            </button>
            
            <div class="flex items-center relative z-10">
                <div id="modalPhoto" class="w-24 h-24 bg-white/20 rounded-full flex items-center justify-center border-4 border-white/40 mr-5">
                    <i class="fas fa-user text-4xl"></i>
                </div>
                <div class="flex-1">
                    <h2 id="modalName" class="text-2xl font-bold mb-1">-</h2>
                    <p id="modalPosition" class="text-lg opacity-90">-</p>
                </div>
            </div>
        </div>

        {{-- Content --}}
        <div class="p-6">
            <div class="grid md:grid-cols-2 gap-6">
                <div class="space-y-4">
                    <div>
                        <label class="text-sm text-gray-500 uppercase tracking-wide block mb-1">NIP</label>
                        <p id="modalNip" class="text-gray-900 font-mono">-</p>
                    </div>
                    
                    <div>
                        <label class="text-sm text-gray-500 uppercase tracking-wide block mb-1">Email</label>
                        <p id="modalEmail" class="text-gray-900">-</p>
                    </div>
                </div>

                <div class="space-y-4">
                    <div>
                        <label class="text-sm text-gray-500 uppercase tracking-wide block mb-1">No. HP</label>
                        <p id="modalPhone" class="text-gray-900">-</p>
                    </div>
                    
                    <div>
                        <label class="text-sm text-gray-500 uppercase tracking-wide block mb-1">Status</label>
                        <span id="modalStatus" class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold">
                            <i class="fas fa-circle mr-2 text-xs"></i> -
                        </span>
                    </div>
                </div>
            </div>

            {{-- Description --}}
            <div id="modalDescriptionWrapper" class="mt-6 hidden">
                <label class="text-sm text-gray-500 uppercase tracking-wide block mb-2">Deskripsi</label>
                <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                    <p id="modalDescription" class="text-gray-700 leading-relaxed">-</p>
                </div>
            </div>

            {{-- Subordinates --}}
            <div id="modalSubordinatesWrapper" class="mt-6 hidden">
                <label class="text-sm text-gray-500 uppercase tracking-wide block mb-3">Bawahan Langsung</label>
                <div id="modalSubordinates" class="grid grid-cols-1 gap-3">
                    <!-- Subordinates will be inserted here -->
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    // ====== SCROLL MANAGEMENT - ULTIMATE FIX ======
    let savedScrollPosition = 0;
    
    function lockScroll() {
        savedScrollPosition = window.pageYOffset;
        document.body.style.overflow = 'hidden';
        document.body.style.paddingRight = '15px';
        console.log('🔒 SCROLL LOCKED at position:', savedScrollPosition);
    }
    
    function unlockScroll() {
        // FORCE REMOVE ALL LOCKS
        document.body.style.removeProperty('overflow');
        document.body.style.removeProperty('padding-right');
        document.body.style.removeProperty('position');
        document.body.style.removeProperty('top');
        document.body.style.removeProperty('width');
        
        document.documentElement.style.removeProperty('overflow');
        
        // Force enable scroll
        document.body.style.overflow = 'visible';
        document.body.style.overflowX = 'hidden';
        
        // Restore scroll position
        window.scrollTo(0, savedScrollPosition);
        
        console.log('🔓 SCROLL UNLOCKED, restored to:', savedScrollPosition);
        
        // Safety: Remove overflow hidden after 100ms
        setTimeout(() => {
            document.body.style.removeProperty('overflow');
            document.body.style.overflowX = 'hidden';
        }, 100);
    }

    // Helper function to get position color theme
    function getPositionTheme(position) {
        const pos = position.toLowerCase();
        
        if (pos.includes('dekan') || pos.includes('wakil') || pos.includes('wadir') || 
            pos.includes('ketua') || pos.includes('kepala upt') || pos.includes('senat')) {
            return {
                gradient: 'from-blue-600 to-blue-800',
                badge: 'bg-blue-100 text-blue-800'
            };
        }
        
        if (pos.includes('staff') || pos.includes('administrasi') || pos.includes('sekretaris') || 
            pos.includes('tata usaha') || pos.includes('kasubag') || pos.includes('kemahasiswaan')) {
            return {
                gradient: 'from-purple-600 to-purple-800',
                badge: 'bg-purple-100 text-purple-800'
            };
        }
        
        if (pos.includes('program studi') || pos.includes('prodi') || pos.includes('kaprodi') || 
            pos.includes('departemen') || pos.includes('dosen') || pos.includes('akademik')) {
            return {
                gradient: 'from-green-600 to-green-800',
                badge: 'bg-green-100 text-green-800'
            };
        }
        
        return {
            gradient: 'from-purple-600 to-purple-800',
            badge: 'bg-purple-100 text-purple-800'
        };
    }

    // Open Modal Function
    function openModal(id, data) {
        const modal = document.getElementById('detailModal');
        const theme = getPositionTheme(data.position || '');
        
        // Update header gradient
        const header = document.getElementById('modalHeader');
        header.className = `bg-gradient-to-r ${theme.gradient} p-6 text-white relative overflow-hidden`;
        
        // Update photo
        const photoDiv = document.getElementById('modalPhoto');
        if (data.photo) {
            photoDiv.innerHTML = `<img src="/storage/${data.photo}" class="w-full h-full object-cover rounded-full" alt="${data.name}">`;
        } else {
            const icon = data.position && data.position.toLowerCase().includes('senat') ? 'fa-users' : 'fa-user';
            photoDiv.innerHTML = `<i class="fas ${icon} text-4xl"></i>`;
        }
        
        // Update basic info
        document.getElementById('modalName').textContent = data.name || '-';
        document.getElementById('modalPosition').textContent = data.position || '-';
        document.getElementById('modalNip').textContent = data.nip || '-';
        
        // Update email with link
        const emailEl = document.getElementById('modalEmail');
        if (data.email) {
            emailEl.innerHTML = `<a href="mailto:${data.email}" class="text-blue-600 hover:underline"><i class="fas fa-envelope mr-1"></i>${data.email}</a>`;
        } else {
            emailEl.textContent = '-';
        }
        
        // Update phone with link
        const phoneEl = document.getElementById('modalPhone');
        if (data.phone) {
            phoneEl.innerHTML = `<a href="tel:${data.phone}" class="text-blue-600 hover:underline"><i class="fas fa-phone mr-1"></i>${data.phone}</a>`;
        } else {
            phoneEl.textContent = '-';
        }
        
        // Update status
        const statusEl = document.getElementById('modalStatus');
        const isActive = data.is_active === undefined || data.is_active === true || data.is_active === 1;
        if (isActive) {
            statusEl.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800';
            statusEl.innerHTML = '<i class="fas fa-check-circle mr-2 text-xs"></i> Aktif';
        } else {
            statusEl.className = 'inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-red-100 text-red-800';
            statusEl.innerHTML = '<i class="fas fa-times-circle mr-2 text-xs"></i> Nonaktif';
        }
        
        // Update description
        const descWrapper = document.getElementById('modalDescriptionWrapper');
        const descEl = document.getElementById('modalDescription');
        if (data.description) {
            descEl.textContent = data.description;
            descWrapper.classList.remove('hidden');
        } else {
            descWrapper.classList.add('hidden');
        }
        
        // Update subordinates
        const subWrapper = document.getElementById('modalSubordinatesWrapper');
        const subEl = document.getElementById('modalSubordinates');
        if (data.children && data.children.length > 0) {
            const activeChildren = data.children.filter(child => child.is_active);
            if (activeChildren.length > 0) {
                subEl.innerHTML = activeChildren.map(child => `
                    <div class="flex items-center p-3 bg-gray-50 rounded-lg hover:bg-gray-100 transition border border-gray-200">
                        ${child.photo 
                            ? `<img src="/storage/${child.photo}" class="w-12 h-12 rounded-full object-cover mr-3 border-2 border-white shadow-sm">`
                            : `<div class="w-12 h-12 bg-gray-300 rounded-full flex items-center justify-center mr-3"><i class="fas fa-user text-gray-500"></i></div>`
                        }
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 truncate">${child.name}</p>
                            <p class="text-sm text-gray-600 truncate">${child.position}</p>
                        </div>
                    </div>
                `).join('');
                subWrapper.classList.remove('hidden');
            } else {
                subWrapper.classList.add('hidden');
            }
        } else {
            subWrapper.classList.add('hidden');
        }
        
        // Show modal THEN lock scroll
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        
        // Small delay to ensure DOM is ready
        setTimeout(lockScroll, 10);
    }

    // Close Modal Function - AGGRESSIVE UNLOCK
    function closeModal(event) {
        if (!event || event.target.id === 'detailModal') {
            const modal = document.getElementById('detailModal');
            if (!modal) return;
            
            console.log('❌ CLOSING MODAL...');
            
            // Hide modal
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            
            // IMMEDIATE unlock (attempt 1)
            unlockScroll();
            
            // Backup unlock (attempt 2) after 50ms
            setTimeout(unlockScroll, 50);
            
            // Emergency unlock (attempt 3) after 200ms
            setTimeout(unlockScroll, 200);
            
            // Final safety unlock (attempt 4) after 500ms
            setTimeout(() => {
                document.body.style.overflow = '';
                document.body.style.overflowX = 'hidden';
                console.log('✅ FINAL SAFETY CHECK');
            }, 500);
        }
    }

    // Close modal with ESC key
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            const modal = document.getElementById('detailModal');
            if (modal && !modal.classList.contains('hidden')) {
                closeModal();
            }
        }
    });

    // ====== EMERGENCY BACKUP WATCHER ======
    // Check every 500ms if modal is hidden but scroll is still locked
    setInterval(() => {
        const modal = document.getElementById('detailModal');
        if (modal && modal.classList.contains('hidden')) {
            const bodyOverflow = window.getComputedStyle(document.body).overflow;
            if (bodyOverflow === 'hidden') {
                console.warn('⚠️ EMERGENCY: Modal hidden but scroll still locked! FORCE UNLOCKING...');
                unlockScroll();
            }
        }
    }, 500);

    // Dynamic staff line connector
    document.addEventListener('DOMContentLoaded', function() {
        const dekanNode = document.getElementById('dekan-node');
        const staffTree = document.getElementById('staff-tree');
        
        function updateStaffLine() {
            if (dekanNode && staffTree) {
                const dekanRect = dekanNode.getBoundingClientRect();
                const staffRect = staffTree.getBoundingClientRect();
                const distance = staffRect.top - dekanRect.bottom;
                
                const styleId = 'dynamic-tree-lines-tailwind';
                let style = document.getElementById(styleId);
                
                if (!style) {
                    style = document.createElement('style');
                    style.id = styleId;
                    document.head.appendChild(style);
                }

                style.innerHTML = `
                    .staff-tree-connector::before {
                        height: ${distance + 20}px !important; 
                        top: -${distance}px !important;
                    }
                `;
            }
        }
        
        updateStaffLine();
        window.addEventListener('resize', updateStaffLine);
        setTimeout(updateStaffLine, 300);
    });
</script>
@endif