{{-- resources/views/frontend/home/partials/events-list.blade.php --}}
@if($events->count() > 0)
    <div class="divide-y divide-gray-200">
        @php
            $currentDate = null;
        @endphp

        @foreach($events as $event)
            @if($currentDate != $event->start_date->format('Y-m-d'))
                @php $currentDate = $event->start_date->format('Y-m-d'); @endphp
                
                {{-- Close previous group --}}
                @if(!$loop->first)
                    </div>
                @endif
                
                {{-- Date Header --}}
                <div class="bg-gray-50 px-6 py-3 border-t-2 border-blue-600">
                    <h4 class="font-bold text-gray-700">
                        {{ $event->start_date->locale('id')->isoFormat('dddd, DD MMMM YYYY') }}
                    </h4>
                </div>
                <div>
            @endif

            {{-- Event Item --}}
            <a href="{{ route('events.show', $event->slug) }}" class="flex items-start p-6 hover:bg-blue-50 transition-colors group">
                <!-- Time Badge -->
                <div class="flex-shrink-0 mr-4">
                    <div class="w-16 text-center">
                        <div class="bg-blue-600 text-white rounded-t-lg px-2 py-1">
                            <span class="block text-xs font-semibold">
                                {{ $event->start_date->format('M') }}
                            </span>
                        </div>
                        <div class="bg-gray-100 text-gray-800 rounded-b-lg px-2 py-2 border border-t-0 border-gray-300">
                            <span class="block text-2xl font-bold leading-none">
                                {{ $event->start_date->format('d') }}
                            </span>
                        </div>
                    </div>
                    <div class="mt-2 text-center">
                        <span class="text-sm font-bold text-gray-700">
                            {{ date('H:i', strtotime($event->start_time)) }}
                        </span>
                    </div>
                </div>

                <!-- Event Image/Poster -->
                @if($event->poster)
                <div class="flex-shrink-0 mr-4">
                    <div class="w-32 h-32 rounded-lg overflow-hidden bg-gray-100 shadow-md">
                        <img src="{{ asset('storage/' . $event->poster) }}" 
                             alt="{{ $event->title }}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300"
                             loading="lazy">
                    </div>
                </div>
                @else
                <div class="flex-shrink-0 mr-4">
                    <div class="w-32 h-32 rounded-lg overflow-hidden bg-gradient-to-br from-blue-100 to-orange-100 shadow-md flex items-center justify-center">
                        <i class="fas fa-calendar-alt text-4xl text-blue-400"></i>
                    </div>
                </div>
                @endif

                <!-- Event Details -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between mb-2">
                        <h3 class="text-lg font-bold text-gray-800 group-hover:text-blue-600 transition pr-4">
                            {{ $event->title }}
                        </h3>
                        
                        <!-- Status Badge -->
                        @if($event->isOngoing())
                            <span class="flex-shrink-0 px-3 py-1 bg-orange-500 text-white text-xs font-bold rounded-full animate-pulse flex items-center">
                                <span class="w-2 h-2 bg-white rounded-full mr-1 animate-ping"></span>
                                LIVE
                            </span>
                        @elseif($event->start_date->isToday())
                            <span class="flex-shrink-0 px-3 py-1 bg-green-500 text-white text-xs font-bold rounded-full">
                                Hari Ini
                            </span>
                        @elseif($event->start_date->isTomorrow())
                            <span class="flex-shrink-0 px-3 py-1 bg-blue-500 text-white text-xs font-bold rounded-full">
                                Besok
                            </span>
                        @endif
                    </div>

                    <!-- Event Meta Info -->
                    <div class="space-y-1 text-sm text-gray-600">
                        <div class="flex items-center">
                            <i class="fas fa-clock text-orange-500 mr-2 w-4"></i>
                            <span>
                                {{ date('H:i', strtotime($event->start_time)) }} - 
                                {{ date('H:i', strtotime($event->end_time)) }} WIB
                            </span>
                            @if($event->start_date > now() && !$event->start_date->isToday())
                                <span class="ml-3 text-blue-600 font-semibold">
                                    • {{ $event->start_date->diffForHumans() }}
                                </span>
                            @endif
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-map-marker-alt text-red-500 mr-2 w-4"></i>
                            <span>{{ $event->location }}</span>
                        </div>
                        <div class="flex items-center">
                            <i class="fas fa-user-tie text-purple-500 mr-2 w-4"></i>
                            <span>{{ $event->organizer }}</span>
                        </div>
                    </div>

                    <!-- Description Preview -->
                    @if($event->description)
                        <p class="mt-2 text-sm text-gray-600 line-clamp-2">
                            {{ Str::limit(strip_tags($event->description), 120) }}
                        </p>
                    @endif
                </div>

                <!-- Arrow Icon -->
                <div class="flex-shrink-0 ml-4 opacity-0 group-hover:opacity-100 transition-opacity">
                    <i class="fas fa-arrow-right text-blue-600 text-xl"></i>
                </div>
            </a>

            {{-- Close last group --}}
            @if($loop->last)
                </div>
            @endif
        @endforeach
    </div>
@else
    <div class="p-12 text-center">
        <div class="w-20 h-20 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
            <i class="fas fa-calendar-times text-3xl text-gray-400"></i>
        </div>
        <h3 class="text-xl font-bold text-gray-800 mb-2">Tidak Ada Event</h3>
        <p class="text-gray-600">Tidak ada event pada tanggal ini</p>
    </div>
@endif

<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>