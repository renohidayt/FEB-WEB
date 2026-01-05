<div class="fixed bottom-6 right-6 z-[9999] flex flex-col items-end">
    
    <div id="wa-popup" class="hidden mb-4 w-[320px] md:w-[360px] bg-[#222] rounded-2xl shadow-2xl overflow-hidden border border-white/10 transition-all duration-300 transform translate-y-4 opacity-0">
        
        <div class="bg-[#79c86a] p-4 flex justify-between items-center">
            <div class="flex items-center gap-3">
                <div class="w-2 h-2 bg-white rounded-full animate-pulse"></div>
                <span class="text-white font-bold text-sm tracking-wide uppercase">Fakultas Ekonomi dan Bisnis</span>
            </div>
            <button onclick="toggleWa()" class="text-white/80 hover:text-white transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>

        <div class="p-6 bg-[#1a1a1a] relative">
            <div class="relative bg-[#333] text-gray-200 p-4 rounded-2xl rounded-tl-none text-sm leading-relaxed shadow-lg">
                Hallo, Selamat datang di WhatsApp **FEB UNSAP**, Ada yang bisa kami bantu?
                <div class="absolute -left-2 top-0 w-0 h-0 border-t-[10px] border-t-[#333] border-l-[10px] border-l-transparent"></div>
            </div>

            <div class="mt-6">
                <a href="https://wa.me/6285315654194?text=Halo%20Admin%20FEB%20UNSAP%2C%20saya%20ingin%20bertanya%20mengenai..." 
                   target="_blank"
                   class="flex items-center justify-between bg-[#79c86a] hover:bg-[#68b05b] text-[#1a1a1a] font-bold py-3 px-6 rounded-full transition-all transform hover:scale-105 shadow-lg group">
                    <span>Buka WhatsApp</span>
                    <svg class="w-6 h-6 transform group-hover:translate-x-1 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M1.101 21.757L23.8 12.028 1.101 2.3l.011 7.912 13.623 1.816-13.623 1.817-.011 7.912z"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <button onclick="toggleWa()" 
            id="wa-button"
            class="bg-[#25d366] text-white w-16 h-16 rounded-full shadow-2xl hover:bg-[#20ba5a] transition-all duration-300 transform hover:scale-110 flex items-center justify-center border-4 border-white/10">
        <svg id="wa-icon" class="w-9 h-9" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413Z"/>
        </svg>
    </button>
</div>

<script>
function toggleWa() {
    const popup = document.getElementById('wa-popup');
    const isHidden = popup.classList.contains('hidden');

    if (isHidden) {
        // Show
        popup.classList.remove('hidden');
        setTimeout(() => {
            popup.classList.remove('translate-y-4', 'opacity-0');
            popup.classList.add('translate-y-0', 'opacity-100');
        }, 10);
    } else {
        // Hide
        popup.classList.add('translate-y-4', 'opacity-0');
        popup.classList.remove('translate-y-0', 'opacity-100');
        setTimeout(() => {
            popup.classList.add('hidden');
        }, 300);
    }
}
</script>