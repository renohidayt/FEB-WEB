@if($dean_profile)
<section class="py-12 bg-white relative overflow-hidden">
    <div aria-hidden="true" class="absolute top-0 left-0 w-48 h-48 bg-blue-50 rounded-full mix-blend-multiply filter blur-3xl opacity-40 -translate-x-1/2 -translate-y-1/2 pointer-events-none"></div>
    <div aria-hidden="true" class="absolute bottom-0 right-0 w-48 h-48 bg-orange-50 rounded-full mix-blend-multiply filter blur-3xl opacity-40 translate-x-1/2 translate-y-1/2 pointer-events-none"></div>

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12 items-start">
            
            <div class="lg:col-span-3 relative group mt-2">
                <div class="relative w-64 sm:w-72 lg:w-full mx-auto">
                    <div class="absolute inset-0 bg-gradient-to-tr from-orange-700 to-orange-500 rounded-xl transform translate-x-3 translate-y-3 transition-transform duration-300 group-hover:translate-x-2 group-hover:translate-y-2" aria-hidden="true"></div>
                    
                    <div class="relative w-full aspect-[3/4] bg-white rounded-xl overflow-hidden shadow-lg border border-gray-100">
                        @if(!empty($dean_profile->photo))
                            <img src="{{ $dean_profile->photo_url }}" 
                                 alt="Foto {{ $dean_profile->name }}" 
                                 loading="lazy"
                                 class="w-full h-full object-cover object-top transform transition-transform duration-500 group-hover:scale-105">
                        @else
                            <div class="w-full h-full bg-gray-50 flex items-center justify-center text-gray-300">
                                <svg class="w-20 h-20" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="lg:col-span-9 text-left pl-0 lg:pl-6">
                <div class="mb-6 relative">
                    <svg class="absolute -top-6 -left-6 w-16 h-16 text-orange-100 opacity-80 transform -scale-x-100 pointer-events-none" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21L14.017 18C14.017 16.896 14.321 15.293 14.922 13.193C15.524 11.093 16.518 9.388 17.906 8.078C19.294 6.768 21.082 6.027 23.27 5.855L23.27 9.855C21.841 9.941 20.806 10.457 20.166 11.402C19.526 12.348 19.205 13.805 19.205 15.774L19.205 21L14.017 21ZM5.01699 21L5.01699 18C5.01699 16.896 5.321 15.293 5.922 13.193C6.524 11.093 7.518 9.388 8.906 8.078C10.294 6.768 12.082 6.027 14.27 5.855L14.27 9.855C12.841 9.941 11.806 10.457 11.166 11.402C10.526 12.348 10.205 13.805 10.205 15.774L10.205 21L5.01699 21Z" />
                    </svg>

                    <div class="flex items-center space-x-3 mb-2 relative z-10">
                        <span class="h-px w-8 bg-orange-600"></span>
                        <span class="text-orange-600 font-bold tracking-widest text-xs uppercase font-sans">Sambutan Dekan</span>
                    </div>
                    
                    <h2 class="text-2xl lg:text-3xl font-bold text-blue-900 leading-tight font-serif relative z-10">
                        Selamat Datang di <br>
                        <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-600 to-orange-500">
                            Fakultas Ekonomi & Bisnis
                        </span>
                    </h2>
                </div>

                <div>
                    <h3 class="font-bold text-lg text-blue-1000 font-serif">{{ $dean_profile->name ?? 'Nama Dekan' }}</h3>
                   <p class="text-gray-500 text-sm font-semibold font-sans">Dekan Fakultas</p>

                </div>

                <div class="prose max-w-none text-gray-600 mb-6 leading-relaxed font-light text-justify lg:text-left text-sm lg:text-base font-sans line-clamp-4 lg:line-clamp-6">
                    @if(!empty($dean_profile->content))
                        {{-- Menggunakan strip_tags jika ingin teks murni, atau {!! !!} jika HTML aman --}}
                        {!! nl2br(e($dean_profile->content)) !!}
                    @else
                        <p>Assalamu'alaikum warahmatullahi wabarakatuh.</p>
                        <p>Puji syukur senantiasa kita panjatkan ke hadirat Allah SWT. Fakultas kami berkomitmen untuk mencetak lulusan yang berintegritas dan kompeten.</p>
                    @endif
                </div>
<div>
    <a href="{{ Route::has('profile.dean') ? route('profile.dean') : '#' }}" 
       class="group inline-flex items-center px-6 py-2.5 bg-white border border-orange-600 text-orange-600 text-sm font-semibold rounded-full hover:bg-orange-600 hover:text-white transition-all duration-300 shadow-sm hover:shadow-md">
        <span>Baca Selengkapnya</span>
        <svg class="w-4 h-4 ml-2 transform group-hover:translate-x-1 transition-transform"
             fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M17 8l4 4m0 0l-4 4m4-4H3"/>
        </svg>
    </a>
</div>

            </div>
        </div>
    </div>
</section>
@endif