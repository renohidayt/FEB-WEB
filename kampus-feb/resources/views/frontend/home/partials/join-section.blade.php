<section class="relative py-24 overflow-hidden bg-slate-50">

    <div class="absolute left-0 top-1/2 -translate-y-1/2 w-96 h-96 bg-blue-100/60 rounded-full blur-3xl -z-10 mix-blend-multiply opacity-70"></div>

    <div class="absolute right-0 top-0 bottom-0
            w-full lg:w-[55%] h-full
            bg-gradient-to-br from-amber-400 via-orange-500 to-yellow-500

            rounded-tl-[80px]       /* mobile: kiri atas */
            rounded-br-[80px]       /* mobile: kanan bawah */
            rounded-bl-none         /* mobile: kiri bawah none */

            lg:rounded-l-[150px]    /* desktop: kiri melengkung */
            lg:rounded-br-none      /* desktop: kanan bawah tidak melengkung */

            shadow-[0_20px_50px_rgba(245,158,11,0.3)]">

        <div class="absolute inset-0 opacity-20" 
             style="background-image: radial-gradient(#fff 1px, transparent 1px); background-size: 24px 24px;">
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 lg:px-8 relative z-10">
        <div class="grid lg:grid-cols-2 items-center gap-12 lg:gap-16">

            <div class="relative flex justify-center lg:justify-start lg:pl-10 group">
                <div class="absolute inset-0 bg-blue-950 rounded-full blur-2xl opacity-0 group-hover:opacity-10 transition duration-500 scale-90 translate-x-4 translate-y-4"></div>

                
                <img src="{{ asset('images/mahasiswa-bergabung.png') }}" 
                     alt="Mahasiswa UNSAP"
                     class="relative w-full max-w-md lg:max-w-[115%] lg:scale-110 drop-shadow-2xl z-20 transition-transform duration-500 hover:scale-[1.12]">
            </div>

            <div class="text-center lg:text-left text-blue-950 pl-0 lg:pl-12">

            

                <h2 class="text-4xl lg:text-6xl font-extrabold mb-6 leading-tight tracking-tight">
                    Bergabung <br>
                    <span class="text-white drop-shadow-md">
                        Bersama Kami
                    </span>
                </h2>

                <p class="text-blue-900/80 font-medium text-lg lg:text-xl mb-10 max-w-lg mx-auto lg:mx-0 leading-relaxed">
                    Bersama kami, wujudkan prestasi dan karier masa depan yang membanggakan.
                </p>

                <a href="https://pmb.unsap.ac.id/"
                   class="group inline-flex items-center gap-3 bg-[#0f172a] text-white font-bold px-10 py-4 rounded-full shadow-lg hover:bg-blue-900 hover:shadow-xl hover:-translate-y-1 transition-all duration-300">
                    <span>Daftar Sekarang</span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="w-5 h-5 group-hover:translate-x-1 transition-transform">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                    </svg>
                </a>

            </div>

        </div>
    </div>

</section>