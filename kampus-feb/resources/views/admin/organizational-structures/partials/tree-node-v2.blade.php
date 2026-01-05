{{-- resources/views/admin/organizational-structures/partials/tree-node-v2.blade.php --}}

@php
    $isRoot = $level === 0;
@endphp

@if($isRoot)
    @php
        // Filter Data
        $wakilDekans = $node->children->filter(function($child) {
            return stripos($child->position, 'wakil dekan') !== false || 
                   stripos($child->position, 'wadir') !== false;
        });
        
        $staffLangsung = $node->children->filter(function($child) use ($wakilDekans) {
            return !$wakilDekans->contains($child);
        });
    @endphp
    
    <div class="org-tree-wrapper">
        <ul class="tree">
            <li>
                {{-- LEVEL 1: DEKAN --}}
                <div class="node-content structural" id="dekan-node">
                    @if($node->photo)
                        <img src="{{ Storage::url($node->photo) }}" class="node-photo" alt="{{ $node->name }}">
                    @else
                        <div class="node-placeholder">👤</div>
                    @endif
                    <div class="text-content">
                        <h4>{{ $node->name }}</h4>
                        <p>{{ $node->position }}</p>
                        @if($node->nip) <small>{{ $node->nip }}</small> @endif
                    </div>
                </div>

                {{-- LEVEL 2: WAKIL DEKAN --}}
                @if($wakilDekans->count() > 0)
                    <ul>
                        @foreach($wakilDekans as $wakil)
                            <li>
                                <div class="node-content {{ $wakil->type }}">
                                    @if($wakil->photo)
                                        <img src="{{ Storage::url($wakil->photo) }}" class="node-photo" alt="{{ $wakil->name }}">
                                    @else
                                        <div class="node-placeholder">👤</div>
                                    @endif
                                    <div class="text-content">
                                        <h4>{{ $wakil->name }}</h4>
                                        <p>{{ $wakil->position }}</p>
                                    </div>
                                </div>

                                {{-- LEVEL 3: CHILDREN DARI WAKIL --}}
                                @if($wakil->children->count() > 0)
                                    <ul>
                                        @foreach($wakil->children as $child)
                                            <li>
                                                <div class="node-content-small {{ $child->type }}">
                                                    @if($child->photo)
                                                        <img src="{{ Storage::url($child->photo) }}" class="node-photo-small" alt="{{ $child->name }}">
                                                    @else
                                                        <div class="node-placeholder-small">👤</div>
                                                    @endif
                                                    <div class="text-content">
                                                        <h5>{{ $child->name }}</h5>
                                                        <p>{{ $child->position }}</p>
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
                
                {{-- KHUSUS: STAFF LANGSUNG (Separate Branch dengan ID untuk JS) --}}
                @if($staffLangsung->count() > 0)
                    <ul class="staff-tree" id="staff-tree">
                        @foreach($staffLangsung as $staff)
                            <li>
                                <div class="node-content-small {{ $staff->type }}">
                                    @if($staff->photo)
                                        <img src="{{ Storage::url($staff->photo) }}" class="node-photo-small" alt="{{ $staff->name }}">
                                    @else
                                        <div class="node-placeholder-small">👤</div>
                                    @endif
                                    <div class="text-content">
                                        <h5>{{ $staff->name }}</h5>
                                        <p>{{ $staff->position }}</p>
                                    </div>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                @endif
            </li>
        </ul>
    </div>

    <style>
        /* --- RESET & LAYOUT DASAR --- */
        .org-tree-wrapper {
            display: flex;
            justify-content: center;
            padding: 20px 0;
            min-width: max-content;
            overflow-x: auto;
        }

        .tree, .tree ul, .staff-tree {
            padding-top: 15px; 
            position: relative;
            transition: all 0.5s;
            display: flex;
            justify-content: center;
            margin: 0;
            padding-left: 0;
        }

        .tree li {
            float: left; 
            text-align: center;
            list-style-type: none;
            position: relative;
            padding: 15px 5px 0 5px;
            transition: all 0.5s;
        }

        /* --- LOGIKA GARIS (MAGIC LINES) --- */
        .tree li::before, .tree li::after {
            content: '';
            position: absolute; 
            top: 0; 
            right: 50%;
            border-top: 1px solid rgba(255,255,255,0.7);
            width: 50%; 
            height: 15px;
        }
        
        .tree li::after {
            right: auto; 
            left: 50%;
            border-left: 1px solid rgba(255,255,255,0.7);
        }

        .tree li:only-child::after, .tree li:only-child::before {
            display: none;
        }
        .tree li:only-child { 
            padding-top: 0;
        }

        .tree li:first-child::before, .tree li:last-child::after {
            border: 0 none;
        }
        
        .tree li:last-child::before {
            border-right: 1px solid rgba(255,255,255,0.7);
            border-radius: 0 3px 0 0;
        }
        .tree li:first-child::after {
            border-radius: 3px 0 0 0;
        }

        .tree ul::before {
            content: '';
            position: absolute; 
            top: 0; 
            left: 50%;
            border-left: 1px solid rgba(255,255,255,0.7);
            width: 0; 
            height: 15px;
        }

        /* --- STYLE STAFF KHUSUS (GARIS PUTUS-PUTUS KE DEKAN) --- */
        .staff-tree {
            position: relative;
        }

        /* Garis vertikal putus-putus DINAMIS dari Dekan ke Staff Tree */
        .staff-tree::before {
            content: '';
            position: absolute;
            left: 50%;
            bottom: 100%;
            width: 1px;
            height: calc(100% + 15px);
            background: repeating-linear-gradient(
                to bottom,
                rgba(255,255,255,0.7) 0px,
                rgba(255,255,255,0.7) 4px,
                transparent 4px,
                transparent 8px
            );
            transform: translateX(-0.5px);
            z-index: 1;
        }

        /* Garis horizontal untuk staff items - SOLID untuk sambungan */
        .staff-tree li::before, 
        .staff-tree li::after {
            border-top: 1px solid rgba(255,255,255,0.7);
        }

        .staff-tree li::before {
            content: '';
            position: absolute; 
            top: 0; 
            right: 50%;
            width: 50%; 
            height: 15px;
        }
        
        .staff-tree li::after {
            content: '';
            position: absolute;
            top: 0;
            right: auto; 
            left: 50%;
            border-left: 1px solid rgba(255,255,255,0.7);
            width: 50%; 
            height: 15px;
        }

        /* Garis vertikal pendek SOLID dari staff tree ke node */
        .staff-tree::after {
            content: '';
            position: absolute;
            left: 50%;
            top: 0;
            width: 1px;
            height: 15px;
            background: rgba(255,255,255,0.7);
            transform: translateX(-0.5px);
            z-index: 2;
        }

        /* Fix untuk first dan last child di staff tree */
        .staff-tree li:first-child::before {
            border: 0 none;
        }
        
        .staff-tree li:last-child::after {
            border: 0 none;
        }
        
        .staff-tree li:last-child::before {
            border-right: 1px solid rgba(255,255,255,0.7);
            border-radius: 0 3px 0 0;
        }
        
        .staff-tree li:first-child::after {
            border-radius: 3px 0 0 0;
        }

        /* Jika hanya ada 1 staff, hapus garis horizontal */
        .staff-tree li:only-child::before,
        .staff-tree li:only-child::after {
            display: none;
        }

        /* --- KARTU (NODE) DESIGN --- */
        .node-content {
            border: 2px solid white;
            padding: 8px;
            text-decoration: none;
            color: white;
            display: inline-block;
            border-radius: 8px;
            transition: all 0.3s;
            background: #fff;
            min-width: 120px;
            max-width: 140px;
            position: relative;
            z-index: 10;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .node-content-small {
            border: 1px solid white;
            padding: 6px;
            color: white;
            display: inline-block;
            border-radius: 6px;
            min-width: 100px;
            max-width: 110px;
            position: relative;
            z-index: 10;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
        }

        .node-content:hover, .node-content-small:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            z-index: 20;
        }

        /* --- TYPOGRAPHY & IMAGES --- */
        .node-photo {
            width: 45px; 
            height: 45px;
            border-radius: 50%; 
            border: 2px solid white;
            object-fit: cover; 
            margin: 0 auto 5px;
            display: block;
        }
        .node-photo-small {
            width: 35px; 
            height: 35px;
            border-radius: 50%; 
            border: 1px solid white;
            object-fit: cover; 
            margin: 0 auto 4px;
            display: block;
        }
        .node-placeholder, .node-placeholder-small {
            border-radius: 50%; 
            border: 2px solid white;
            background: rgba(255,255,255,0.2);
            display: flex; 
            align-items: center; 
            justify-content: center;
            margin: 0 auto 5px;
        }
        .node-placeholder { 
            width: 45px; 
            height: 45px; 
            font-size: 20px; 
        }
        .node-placeholder-small { 
            width: 35px; 
            height: 35px; 
            font-size: 16px;
            border-width: 1px;
        }

        .text-content h4 { 
            font-weight: bold; 
            font-size: 10px; 
            margin: 0; 
            line-height: 1.2; 
            text-transform: uppercase; 
        }
        .text-content h5 { 
            font-weight: bold; 
            font-size: 9px; 
            margin: 0; 
            line-height: 1.2; 
        }
        .text-content p { 
            font-size: 8px; 
            margin: 3px 0 0; 
            opacity: 0.9; 
            text-transform: uppercase; 
            font-weight: 600; 
        }
        .text-content small { 
            font-size: 7px; 
            opacity: 0.8; 
            display: block; 
            margin-top: 2px; 
        }

        /* COLORS */
        .structural { background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); }
        .academic { background: linear-gradient(135deg, #10b981 0%, #059669 100%); }
        .administrative { background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); }

        /* Responsive untuk layar kecil */
        @media (max-width: 768px) {
            .node-content {
                min-width: 100px;
                max-width: 110px;
                padding: 6px;
            }
            
            .node-content-small {
                min-width: 85px;
                max-width: 95px;
                padding: 5px;
            }
            
            .node-photo {
                width: 35px;
                height: 35px;
            }
            
            .node-photo-small {
                width: 28px;
                height: 28px;
            }
            
            .text-content h4 { font-size: 9px; }
            .text-content h5 { font-size: 8px; }
            .text-content p { font-size: 7px; }
        }
    </style>

    <script>
        // Hitung jarak dinamis antara Dekan dan Staff Tree
        document.addEventListener('DOMContentLoaded', function() {
            const dekanNode = document.getElementById('dekan-node');
            const staffTree = document.getElementById('staff-tree');
            
            if (dekanNode && staffTree) {
                // Fungsi untuk update tinggi garis
                function updateStaffLine() {
                    const dekanRect = dekanNode.getBoundingClientRect();
                    const staffRect = staffTree.getBoundingClientRect();
                    
                    // Hitung jarak vertikal dari bawah dekan ke atas staff tree
                    const dekanBottom = dekanRect.bottom;
                    const staffTop = staffRect.top;
                    const distance = staffTop - dekanBottom;
                    
                    // Update CSS variable untuk ::before pseudo-element
                    const style = document.createElement('style');
                    style.innerHTML = `
                        .staff-tree::before {
                            height: ${distance}px !important;
                            top: ${-distance}px !important;
                        }
                    `;
                    document.head.appendChild(style);
                }
                
                // Run on load
                updateStaffLine();
                
                // Run on resize
                window.addEventListener('resize', updateStaffLine);
                
                // Run setelah 100ms untuk memastikan layout selesai
                setTimeout(updateStaffLine, 100);
            }
        });
    </script>
@endif