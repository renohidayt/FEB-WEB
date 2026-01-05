{{-- LOGIKA PHP --}}
@php
    $eventsMap = [];
    $activeEvent = null; // Ini akan menampung event PERTAMA hari ini untuk tampilan awal
    $todayEvents = [];   // Ini menampung SEMUA event hari ini
    $today = date('Y-m-d'); 

    foreach($events as $event) {
        $dateKey = $event->start_date->format('Y-m-d'); 
        
        $eventData = [
            'title'       => $event->title,
            'slug'        => $event->slug,
            'poster'      => $event->poster ? asset('storage/' . $event->poster) : null,
            'time'        => date('H:i', strtotime($event->start_time)) . ' WIB',
            'location'    => $event->location,
            'description' => Str::limit(strip_tags($event->description), 100),
            'status'      => $event->isOngoing() ? 'LIVE NOW' : 'UPCOMING',
            'is_live'     => $event->isOngoing()
        ];

        // REVISI: Selalu append ke array (push), jangan cuma satu
        $eventsMap[$dateKey][] = $eventData;

        // Cek jika ini hari ini
        if ($dateKey === $today) {
            $todayEvents[] = $eventData;
        }
    }

    // Ambil event pertama hari ini untuk default view
    $activeEvent = !empty($todayEvents) ? $todayEvents[0] : null;
@endphp
<section class="py-8 md:py-12 bg-[#0B1120] text-white flex items-center justify-center font-sans">
    <div class="w-full max-w-6xl px-4">
        
        {{-- HEADER (Sama seperti sebelumnya) --}}
        <div class="flex flex-col md:flex-row md:items-center justify-between mb-6 md:mb-8 border-b border-gray-800 pb-4 gap-4">
            <div>
                <h2 class="text-2xl md:text-4xl font-extrabold text-white tracking-tight">
                    Event & Agenda <span class="text-orange-500">Kampus</span>
                </h2>
                <p class="text-gray-400 text-xs md:text-sm mt-1">Intip detail keseruan dan agenda utama acara ini.</p>
            </div>
            <a href="{{ route('events.index') }}" class="group flex items-center text-sm font-semibold text-gray-400 hover:text-white transition-colors self-start md:self-auto">
                Lihat Semua <i class="fas fa-arrow-right ml-2 group-hover:text-orange-500 transition-colors"></i>
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 lg:h-[450px]">
            
            {{-- 1. KALENDER (Sama, tapi logic JS nanti berubah dikit) --}}
            <div class="order-1 lg:order-2 lg:col-span-4 h-auto lg:h-full bg-[#161e2e] rounded-3xl border border-gray-800 p-5 md:p-6 flex flex-col relative shadow-xl">
                <div class="flex items-center justify-between mb-4">
                    <button id="prevMonth" class="p-2 hover:bg-gray-800 rounded-full text-gray-400 hover:text-white transition"><i class="fas fa-chevron-left"></i></button>
                    <h3 id="calendarMonth" class="text-white font-bold text-sm md:text-md uppercase tracking-widest"></h3>
                    <button id="nextMonth" class="p-2 hover:bg-gray-800 rounded-full text-gray-400 hover:text-white transition"><i class="fas fa-chevron-right"></i></button>
                </div>
                <div class="grid grid-cols-7 text-center mb-2">
                    <span class="text-[10px] text-gray-500 font-bold">M</span>
                    <span class="text-[10px] text-gray-500 font-bold">S</span>
                    <span class="text-[10px] text-gray-500 font-bold">S</span>
                    <span class="text-[10px] text-gray-500 font-bold">R</span>
                    <span class="text-[10px] text-gray-500 font-bold">K</span>
                    <span class="text-[10px] text-gray-500 font-bold">J</span>
                    <span class="text-[10px] text-gray-500 font-bold">S</span>
                </div>
                <div id="calendarGrid" class="grid grid-cols-7 gap-1 flex-grow content-start min-h-[200px]"></div>
                <div class="mt-4 pt-3 border-t border-gray-700 flex justify-center gap-4 text-[10px] text-gray-400">
                    <div class="flex items-center"><span class="w-2 h-2 bg-orange-500 rounded-full mr-1.5"></span> Event</div>
                    <div class="flex items-center"><span class="w-2 h-2 bg-blue-600 rounded-full mr-1.5"></span> Terpilih</div>
                </div>
            </div>

            {{-- 2. EVENT CARD (Ada tambahan tombol Navigasi Multi-Event) --}}
            <div class="order-2 lg:order-1 lg:col-span-8 h-auto min-h-[350px] lg:h-full bg-gray-900 rounded-3xl relative overflow-hidden shadow-2xl border border-gray-800 group" id="eventCard">
                
                {{-- Background Poster --}}
                <div class="absolute inset-0 bg-gray-800">
                    <img id="cardPoster" 
                         src="{{ $activeEvent['poster'] ?? '' }}" 
                         class="w-full h-full object-cover opacity-40 transition-transform duration-700 group-hover:scale-105"
                         style="{{ empty($activeEvent['poster']) ? 'display:none;' : '' }}">
                </div>
                <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/80 to-transparent"></div>
                
                {{-- Content --}}
                <div class="absolute inset-0 p-6 md:p-8 flex flex-col justify-end z-10">
                    
                    <div id="cardLoading" class="hidden absolute inset-0 bg-gray-900 flex items-center justify-center z-20">
                        <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-orange-500"></div>
                    </div>

                    {{-- NEW: Navigasi Multiple Events --}}
                    <div id="multiEventNav" class="hidden absolute top-6 right-6 flex items-center bg-black/40 backdrop-blur-md rounded-full px-3 py-1 border border-white/10 z-30">
                        <button onclick="prevEvent()" class="text-white hover:text-orange-500 px-2 transition"><i class="fas fa-chevron-left text-xs"></i></button>
                        <span id="eventCounter" class="text-[10px] font-bold text-gray-300 mx-2">1 / 3</span>
                        <button onclick="nextEvent()" class="text-white hover:text-orange-500 px-2 transition"><i class="fas fa-chevron-right text-xs"></i></button>
                    </div>

                    <div class="mb-3">
                        <span id="cardBadge" class="{{ ($activeEvent['is_live'] ?? false) ? 'bg-orange-600' : 'bg-blue-600' }} px-3 py-1 text-white text-[10px] font-bold uppercase rounded-full shadow-lg">
                            {{ $activeEvent['status'] ?? 'TIDAK ADA JADWAL' }}
                        </span>
                    </div>

                    <h3 id="cardTitle" class="text-2xl md:text-3xl font-extrabold text-white mb-3 leading-tight drop-shadow-lg line-clamp-2">
                        {{ $activeEvent['title'] ?? 'Tidak Ada Kegiatan' }}
                    </h3>

                    <div id="cardMeta" class="flex flex-wrap gap-x-4 gap-y-2 text-xs md:text-sm text-gray-300 mb-4 {{ !$activeEvent ? 'hidden' : '' }}">
                        <div class="flex items-center bg-black/30 px-2 py-1 rounded-md backdrop-blur-sm">
                            <i class="far fa-clock text-orange-500 mr-2"></i>
                            <span id="cardTime">{{ $activeEvent['time'] ?? '-' }}</span>
                        </div>
                        <div class="flex items-center bg-black/30 px-2 py-1 rounded-md backdrop-blur-sm">
                            <i class="fas fa-map-marker-alt text-orange-500 mr-2"></i>
                            <span id="cardLocation">{{ $activeEvent['location'] ?? '-' }}</span>
                        </div>
                    </div>

                    <p id="cardDesc" class="text-gray-400 text-xs md:text-sm line-clamp-3 md:line-clamp-2 max-w-xl mb-6 leading-relaxed">
                        {{ $activeEvent['description'] ?? 'Silakan pilih tanggal di kalender (atas) untuk melihat detail agenda.' }}
                    </p>

                    <div>
                        <a id="cardLink" href="{{ $activeEvent ? route('events.show', $activeEvent['slug']) : '#' }}" 
                           class="inline-flex items-center px-6 py-2.5 bg-white text-gray-900 text-xs font-bold rounded-lg hover:bg-orange-500 hover:text-white transition-all shadow-lg {{ !$activeEvent ? 'hidden' : '' }}">
                            Detail Event
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    // 1. TERIMA DATA
    const eventsMap = @json($eventsMap);
    
    // Variabel Global untuk Event Handling
    let currentEventList = []; // Menyimpan list event pada tanggal terpilih
    let currentEventIndex = 0; // Menyimpan posisi index event yang sedang dilihat

    // Setup Calendar Vars
    const calendarGrid = document.getElementById('calendarGrid');
    const calendarMonth = document.getElementById('calendarMonth');
    const months = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    
    let date = new Date();
    let currYear = date.getFullYear();
    let currMonth = date.getMonth(); 

    const getFormattedDate = (year, month, day) => {
        let m = String(month + 1).padStart(2, '0');
        let d = String(day).padStart(2, '0');
        return `${year}-${m}-${d}`;
    };

    const todayStr = getFormattedDate(new Date().getFullYear(), new Date().getMonth(), new Date().getDate());
    let selectedDate = todayStr;

    // --- LOGIC MULTI EVENT ---

    // Saat tanggal diklik
    window.selectDate = function(dateStr) {
        selectedDate = dateStr;
        
        // Cek apakah ada event di tanggal ini
        if (eventsMap[dateStr]) {
            currentEventList = eventsMap[dateStr]; // Load array events
            currentEventIndex = 0; // Reset ke event pertama
            renderEventCard(); // Tampilkan
        } else {
            currentEventList = [];
            currentEventIndex = 0;
            renderEmptyCard();
        }

        renderCalendar(); // Update UI Kalender (highlight active date)

        // Scroll di mobile
        if (window.innerWidth < 1024) {
            document.getElementById('eventCard').scrollIntoView({ behavior: 'smooth', block: 'nearest' });
        }
    }

    // Tombol Next Event
    window.nextEvent = function() {
        if (currentEventIndex < currentEventList.length - 1) {
            currentEventIndex++;
            renderEventCard();
        }
    }

    // Tombol Prev Event
    window.prevEvent = function() {
        if (currentEventIndex > 0) {
            currentEventIndex--;
            renderEventCard();
        }
    }

    // Fungsi Render Kartu Event
    function renderEventCard() {
        const data = currentEventList[currentEventIndex];
        const loader = document.getElementById('cardLoading');
        const poster = document.getElementById('cardPoster');
        
        loader.classList.remove('hidden');

        // Logic Navigasi (Tampil jika > 1 event)
        const nav = document.getElementById('multiEventNav');
        if (currentEventList.length > 1) {
            nav.classList.remove('hidden');
            document.getElementById('eventCounter').innerText = `${currentEventIndex + 1} / ${currentEventList.length}`;
        } else {
            nav.classList.add('hidden');
        }

        setTimeout(() => {
            // Update Poster
            if(data.poster) {
                poster.src = data.poster;
                poster.style.display = 'block';
            } else {
                poster.style.display = 'none';
            }

            // Update Text
            const badge = document.getElementById('cardBadge');
            badge.innerText = data.status;
            badge.className = `px-3 py-1 text-white text-[10px] font-bold uppercase rounded-full shadow-lg ${data.is_live ? 'bg-orange-600' : 'bg-blue-600'}`;
            
            document.getElementById('cardTitle').innerText = data.title;
            document.getElementById('cardTime').innerText = data.time;
            document.getElementById('cardLocation').innerText = data.location;
            document.getElementById('cardDesc').innerText = data.description;
            
            const link = document.getElementById('cardLink');
            link.href = `/events/${data.slug}`;
            link.classList.remove('hidden');
            document.getElementById('cardMeta').classList.remove('hidden');

            loader.classList.add('hidden');
        }, 150);
    }

    // Fungsi Render Kosong
    function renderEmptyCard() {
        const poster = document.getElementById('cardPoster');
        poster.style.display = 'none';
        document.getElementById('multiEventNav').classList.add('hidden');

        const badge = document.getElementById('cardBadge');
        badge.innerText = "KOSONG";
        badge.className = "px-3 py-1 bg-gray-700 text-gray-400 text-[10px] font-bold uppercase rounded-full";
        
        document.getElementById('cardTitle').innerText = "Tidak Ada Kegiatan";
        document.getElementById('cardDesc').innerText = "Belum ada agenda dijadwalkan pada tanggal ini.";
        
        document.getElementById('cardLink').classList.add('hidden');
        document.getElementById('cardMeta').classList.add('hidden');
    }

    // --- RENDER CALENDAR (Sedikit modifikasi untuk deteksi array) ---
    function renderCalendar() {
        let firstDayofMonth = new Date(currYear, currMonth, 1).getDay();
        let lastDateofMonth = new Date(currYear, currMonth + 1, 0).getDate();
        let lastDateofLastMonth = new Date(currYear, currMonth, 0).getDate();
        
        let liTag = "";

        for (let i = firstDayofMonth; i > 0; i--) {
            liTag += `<div class="py-2 text-xs text-gray-700 pointer-events-none opacity-50">${lastDateofLastMonth - i + 1}</div>`;
        }

        for (let i = 1; i <= lastDateofMonth; i++) {
            let dateKey = getFormattedDate(currYear, currMonth, i);
            let isToday = dateKey === todayStr;
            let hasEvent = eventsMap.hasOwnProperty(dateKey); // Tetap work karena array juga dianggap property
            let isSelected = dateKey === selectedDate;

            let classes = "h-8 w-8 mx-auto flex items-center justify-center rounded-lg text-xs cursor-pointer transition-all duration-200 relative ";
            
            if (isSelected) {
                classes += "bg-blue-600 text-white shadow-lg font-bold scale-110 ring-2 ring-offset-1 ring-offset-[#161e2e] ring-blue-600";
            } else if (hasEvent) {
                classes += "text-white font-bold bg-gray-800 hover:bg-gray-700";
            } else {
                classes += "text-gray-500 hover:bg-gray-800 hover:text-gray-300";
            }
            
            if (isToday && !isSelected) {
                classes += " border border-orange-500 text-orange-500 font-bold";
            }

            // Indikator jika ada event (jumlah dot bisa disesuaikan kalau mau)
            let dot = hasEvent && !isSelected ? `<span class="absolute -bottom-1 w-1 h-1 bg-orange-500 rounded-full shadow-md"></span>` : '';

            liTag += `<div class="${classes}" onclick="selectDate('${dateKey}')">${i}${dot}</div>`;
        }
        
        calendarMonth.innerText = `${months[currMonth]} ${currYear}`;
        calendarGrid.innerHTML = liTag;
    }

    // Init Calendar Button Listeners
    document.getElementById('prevMonth').addEventListener('click', () => {
        currMonth--;
        if(currMonth < 0) { currMonth = 11; currYear--; }
        renderCalendar();
    });

    document.getElementById('nextMonth').addEventListener('click', () => {
        currMonth++;
        if(currMonth > 11) { currMonth = 0; currYear++; }
        renderCalendar();
    });

    // INIT PAGE LOAD
    // Cek apakah hari ini ada event untuk initial load
    if(eventsMap[todayStr]) {
        currentEventList = eventsMap[todayStr];
        renderEventCard();
    } else {
        renderEmptyCard();
    }
    renderCalendar();

</script>