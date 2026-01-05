<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<section class="relative -mt-16 md:-mt-20 mb-12 md:mb-16 z-30">
    <div class="w-full max-w-4xl mx-auto px-4">
        
        <form action="{{ route('global.search') }}" method="GET">
            
            <div class="flex flex-row items-stretch shadow-[0_10px_40px_-15px_rgba(0,0,0,0.3)] bg-white h-12 md:h-auto">
                
                <input type="text" 
                       name="search"
                       value="{{ request('search') }}"
                       {{-- REVISI DISINI: Memberikan petunjuk jelas apa yang bisa dicari --}}
                       placeholder="Cari Dosen, Berita, Agenda, atau Jurnal..." 
                       class="flex-1 min-w-0 px-4 md:px-6 md:py-5 bg-white text-gray-800 text-sm md:text-lg focus:outline-none focus:ring-2 focus:ring-red-500 focus:z-10 placeholder-gray-500 border-0"
                       style="border-radius: 0; font-family: 'Poppins', sans-serif;">
                
                <button type="submit" 
                        class="bg-gradient-to-r from-orange-500 to-red-600 hover:from-orange-600 hover:to-red-700 text-white px-5 md:px-10 transition-all duration-300 font-bold tracking-wide flex items-center justify-center group shrink-0"
                        style="border-radius: 0; font-family: 'Poppins', sans-serif;">
                    
                    <span class="text-sm md:text-lg uppercase">Cari</span>
                    
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 md:h-6 md:w-6 ml-2 transform group-hover:scale-110 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </form>
    </div>
</section>