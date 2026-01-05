<!-- Quick Access Section -->
<section class="py-12 bg-slate-50">
    <div class="max-w-7xl mx-auto px-4">
        <!-- Header -->
        <div class="mb-10">
    <h2 class="text-2xl md:text-4xl font-extrabold text-gray-900 tracking-tight inline-block pb-3
               border-b-4 border-gradient-to-r from-[#C91818] to-[#FFCC00]"
        style="border-image: linear-gradient(90deg, #C91818, #FFCC00) 1;">
        Akses <span class="text-orange-500">Cepat</span>
    </h2>
</div>

        
        <!-- Flex Container dengan ukuran tetap -->
        <div class="flex flex-wrap rounded-2xl overflow-hidden" style="border: 3px solid; border-image: linear-gradient(135deg, #C91818, #FFCC00) 1; width: fit-content;">
            
            <!-- BARIS 1 -->
            @include('frontend.home.partials.quick-access-item', [
    'title' => 'Program Studi',
    'description' => 'Informasi Program Studi Dalam Fakultas Ekonomi & Bisnis',
    'icon_default' => asset('images/icons/Program_Studi1.png'),
    'icon_hover' => asset('images/icons/Program_Studi2.png'),
    'link' => route('study-programs.index'),
    'image' => asset('images/Program_Studi.jpg'), // ganti gambar di sini
    'border_right' => true,
    'border_bottom' => true
])


            @include('frontend.home.partials.quick-access-item', [
                'title' => 'Fasilitas Kampus',
                'description' => 'Informasi Fasilitas Fakultas Ekonomi & Bisnis',
                'icon_default' => asset('images/icons/Fasilitas_Kampus1.png'),
                'icon_hover' => asset('images/icons/Fasilitas_Kampus2.png'),
                'link' => route('facilities.index'),
                'image' => asset('images/Fasilitas_Kampus.jpg'), // ganti gambar di sini
                'border_right' => true,
                'border_bottom' => true
            ])

            @include('frontend.home.partials.quick-access-item', [
                'title' => 'SIAKAD',
                'description' => 'Informasi Tentang Nilai, KRS, dan Kehadiran',
                'icon_default' => asset('images/icons/Siakad1.png'),
                'icon_hover' => asset('images/icons/Siakad2.png'),
                'link' => 'http://103.151.227.36:8060/index.php/login',
                'image' => 'https://images.unsplash.com/photo-1460925895917-afdab827c52f?w=800',
                'border_bottom' => true
            ])

            <!-- BARIS 2 -->
            @include('frontend.home.partials.quick-access-item', [
                'title' => 'Visi Misi',
                'description' => 'Tujuan dan Visi untuk Kelangsungan Masa Depan',
                'icon_default' => asset('images/icons/Visi_Misi1.png'),
                'icon_hover' => asset('images/icons/Visi_Misi2.png'),
                'link' => route('profile.visi-misi'),
                'image' => 'https://images.unsplash.com/photo-1552664730-d307ca884978?w=800',
                'border_right' => true
            ])

            @include('frontend.home.partials.quick-access-item', [
                'title' => 'Akreditasi',
                'description' => 'Informasi Akreditasi di FE-BI',
                'icon_default' => asset('images/icons/Akreditasi2.png'),
                'icon_hover' => asset('images/icons/Akreditasi1.png'),
                'link' => route('profile.accreditation.index'),
                'image' => 'https://images.unsplash.com/photo-1589829545856-d10d557cf95f?w=800',
                'border_right' => true
            ])

            @include('frontend.home.partials.quick-access-item', [
                'title' => 'Pengajuan Surat',
                'description' => 'Informasi Pengajuan Surat Resmi',
                'icon_default' => asset('images/icons/Pengajuan_Surat1.png'),
                'icon_hover' => asset('images/icons/Pengajuan_Surat2.png'),
                'link' => auth()->check() ? '#' : route('login'),
                'image' => 'https://images.unsplash.com/photo-1450101499163-c8848c66ca85?w=800',
                'auth_required' => true
            ])

        </div>
    </div>
</section>