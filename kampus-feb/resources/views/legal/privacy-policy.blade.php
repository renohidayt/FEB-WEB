@extends('layouts.app')

@section('title', 'Kebijakan Privasi - FEB UNSAP')

@section('content')
{{-- Font Import --}}
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<div style="font-family: 'Poppins', sans-serif;" class="bg-slate-50 min-h-screen text-slate-700">
    
    {{-- HERO SECTION --}}
    <div class="relative bg-slate-900 border-b border-slate-800 pt-20 pb-20 overflow-hidden">
        {{-- Abstract Pattern --}}
        <div class="absolute inset-0 opacity-20" style="background-image: radial-gradient(#cbd5e1 1px, transparent 1px); background-size: 32px 32px;"></div>
        
        {{-- Glow Effect (Orange) --}}
        <div class="absolute top-0 right-0 w-[500px] h-[500px] bg-orange-600/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/3"></div>

        <div class="container mx-auto px-6 relative z-10">
            {{-- Breadcrumb --}}
            <nav class="mb-6">
                <ol class="flex items-center text-sm font-medium">
                    <li>
                        <a href="{{ route('home') }}" class="text-slate-400 hover:text-orange-400 transition flex items-center gap-2">
                            <i class="fas fa-home"></i> Beranda
                        </a>
                    </li>
                    <li class="mx-3 text-slate-600">/</li>
                    <li class="text-orange-500">Kebijakan Privasi</li>
                </ol>
            </nav>

            {{-- Title Header --}}
            <div class="max-w-4xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-slate-800 border border-slate-700 rounded text-xs font-bold text-orange-400 tracking-wider uppercase mb-4">
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 leading-tight">
                    Kebijakan Privasi & <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Perlindungan Data</span>
                </h1>
                <p class="text-lg text-slate-400 max-w-2xl leading-relaxed">
                    Kami menghargai privasi Anda. Dokumen ini menjelaskan transparansi kami dalam mengelola data akademik dan personal Anda di lingkungan FEB UNSAP.
                </p>
            </div>
        </div>
    </div>

    {{-- CONTENT LAYOUT --}}
    <div class="container mx-auto px-6 py-12">
        <div class="grid lg:grid-cols-12 gap-10">
            
            {{-- SIDEBAR NAVIGATION (Sticky) --}}
            <div class="lg:col-span-3">
                <div class="sticky top-24">
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 px-2">Daftar Isi</h3>
                    <nav class="space-y-1" id="toc-nav">
                        <a href="#pendahuluan" class="group flex items-center justify-between px-3 py-2 text-sm font-medium text-slate-600 hover:text-orange-600 hover:bg-orange-50 border-l-2 border-transparent hover:border-orange-500 transition-all rounded-r-md">
                            <span>1. Pendahuluan</span>
                        </a>
                        <a href="#data-dikumpulkan" class="group flex items-center justify-between px-3 py-2 text-sm font-medium text-slate-600 hover:text-orange-600 hover:bg-orange-50 border-l-2 border-transparent hover:border-orange-500 transition-all rounded-r-md">
                            <span>2. Data Dikumpulkan</span>
                        </a>
                        <a href="#penggunaan-data" class="group flex items-center justify-between px-3 py-2 text-sm font-medium text-slate-600 hover:text-orange-600 hover:bg-orange-50 border-l-2 border-transparent hover:border-orange-500 transition-all rounded-r-md">
                            <span>3. Penggunaan Data</span>
                        </a>
                        <a href="#keamanan-data" class="group flex items-center justify-between px-3 py-2 text-sm font-medium text-slate-600 hover:text-orange-600 hover:bg-orange-50 border-l-2 border-transparent hover:border-orange-500 transition-all rounded-r-md">
                            <span>4. Keamanan</span>
                        </a>
                        <a href="#hak-pengguna" class="group flex items-center justify-between px-3 py-2 text-sm font-medium text-slate-600 hover:text-orange-600 hover:bg-orange-50 border-l-2 border-transparent hover:border-orange-500 transition-all rounded-r-md">
                            <span>5. Hak Pengguna</span>
                        </a>
                        <a href="#cookies" class="group flex items-center justify-between px-3 py-2 text-sm font-medium text-slate-600 hover:text-orange-600 hover:bg-orange-50 border-l-2 border-transparent hover:border-orange-500 transition-all rounded-r-md">
                            <span>6. Cookies</span>
                        </a>
                    </nav>
                </div>
            </div>

            {{-- MAIN DOCUMENT --}}
            <div class="lg:col-span-9">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 md:p-12 space-y-16">
                    
                    {{-- 1. Pendahuluan --}}
                    <section id="pendahuluan" class="scroll-mt-28">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="flex items-center justify-center w-10 h-10 rounded bg-slate-100 text-slate-600 font-bold border border-slate-200">01</span>
                            <h2 class="text-2xl font-bold text-slate-900">Pendahuluan</h2>
                        </div>
                        <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed">
                            <p class="mb-4">
                                Selamat datang di portal resmi Fakultas Ekonomi dan Bisnis Universitas Sebelas April (FEB UNSAP). Kebijakan Privasi ini merupakan wujud komitmen kami untuk menghormati dan melindungi setiap informasi pribadi yang Anda berikan melalui situs web ini.
                            </p>
                            <p>
                                Dengan mengakses layanan digital kami, Anda dianggap telah membaca, memahami, dan menyetujui praktik pengelolaan data yang dijelaskan di bawah ini. Dokumen ini disusun sesuai dengan peraturan perlindungan data yang berlaku di Indonesia.
                            </p>
                        </div>
                    </section>

                    <div class="w-full h-px bg-slate-100"></div>

                    {{-- 2. Data yang Dikumpulkan --}}
                    <section id="data-dikumpulkan" class="scroll-mt-28">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="flex items-center justify-center w-10 h-10 rounded bg-slate-100 text-slate-600 font-bold border border-slate-200">02</span>
                            <h2 class="text-2xl font-bold text-slate-900">Data yang Dikumpulkan</h2>
                        </div>
                        <p class="text-slate-600 mb-6">Untuk menunjang layanan akademik dan administrasi, kami mengumpulkan beberapa kategori data:</p>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            {{-- Card 1: Data Pribadi --}}
                            <div class="bg-slate-50 rounded-lg p-6 border-l-4 border-orange-500 hover:bg-white hover:shadow-md transition duration-300">
                                <div class="flex items-center gap-3 mb-4">
                                    <i class="fas fa-id-card text-orange-600 text-xl"></i>
                                    <h3 class="font-bold text-slate-800">Identitas Personal</h3>
                                </div>
                                <ul class="space-y-2 text-sm text-slate-600">
                                    <li class="flex items-start gap-2"><i class="fas fa-check text-orange-500 mt-1"></i> Nama Lengkap & Foto</li>
                                    <li class="flex items-start gap-2"><i class="fas fa-check text-orange-500 mt-1"></i> Nomor Induk Mahasiswa (NIM)</li>
                                    <li class="flex items-start gap-2"><i class="fas fa-check text-orange-500 mt-1"></i> Tanggal Lahir & Jenis Kelamin</li>
                                    <li class="flex items-start gap-2"><i class="fas fa-check text-orange-500 mt-1"></i> Program Studi & Angkatan</li>
                                </ul>
                            </div>

                            {{-- Card 2: Data Kontak --}}
                            <div class="bg-slate-50 rounded-lg p-6 border-l-4 border-slate-400 hover:bg-white hover:shadow-md transition duration-300">
                                <div class="flex items-center gap-3 mb-4">
                                    <i class="fas fa-address-book text-slate-600 text-xl"></i>
                                    <h3 class="font-bold text-slate-800">Informasi Kontak</h3>
                                </div>
                                <ul class="space-y-2 text-sm text-slate-600">
                                    <li class="flex items-start gap-2"><i class="fas fa-check text-slate-400 mt-1"></i> Alamat Email Institusi/Pribadi</li>
                                    <li class="flex items-start gap-2"><i class="fas fa-check text-slate-400 mt-1"></i> Nomor Telepon/WhatsApp</li>
                                    <li class="flex items-start gap-2"><i class="fas fa-check text-slate-400 mt-1"></i> Alamat Domisili</li>
                                    <li class="flex items-start gap-2"><i class="fas fa-check text-slate-400 mt-1"></i> Kontak Darurat</li>
                                </ul>
                            </div>

                            {{-- Card 3: Data Teknis --}}
                            <div class="md:col-span-2 bg-slate-50 rounded-lg p-6 border-l-4 border-slate-400 hover:bg-white hover:shadow-md transition duration-300">
                                <div class="flex items-center gap-3 mb-4">
                                    <i class="fas fa-server text-slate-600 text-xl"></i>
                                    <h3 class="font-bold text-slate-800">Data Teknis & Akademik</h3>
                                </div>
                                <div class="grid md:grid-cols-2 gap-4">
                                    <ul class="space-y-2 text-sm text-slate-600">
                                        <li class="flex items-start gap-2"><i class="fas fa-check text-slate-400 mt-1"></i> IP Address & Device Info</li>
                                        <li class="flex items-start gap-2"><i class="fas fa-check text-slate-400 mt-1"></i> Log Aktivitas Login</li>
                                    </ul>
                                    <ul class="space-y-2 text-sm text-slate-600">
                                        <li class="flex items-start gap-2"><i class="fas fa-check text-slate-400 mt-1"></i> Riwayat Pengajuan Surat</li>
                                        <li class="flex items-start gap-2"><i class="fas fa-check text-slate-400 mt-1"></i> Transkrip & Nilai (terenkripsi)</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="w-full h-px bg-slate-100"></div>

                    {{-- 3. Penggunaan Data --}}
                    <section id="penggunaan-data" class="scroll-mt-28">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="flex items-center justify-center w-10 h-10 rounded bg-slate-100 text-slate-600 font-bold border border-slate-200">03</span>
                            <h2 class="text-2xl font-bold text-slate-900">Tujuan Penggunaan Data</h2>
                        </div>
                        <p class="text-slate-600 mb-6">Kami menggunakan informasi Anda semata-mata untuk kepentingan operasional kampus:</p>

                        <div class="grid sm:grid-cols-3 gap-5">
                            {{-- Item 1 --}}
                            <div class="group p-5 bg-white border border-slate-200 rounded-lg hover:border-orange-500 transition-colors duration-300">
                                <div class="w-12 h-12 bg-slate-50 rounded-lg flex items-center justify-center mb-4 group-hover:bg-orange-50 transition-colors">
                                    <i class="fas fa-user-graduate text-slate-600 group-hover:text-orange-600 text-xl"></i>
                                </div>
                                <h4 class="font-bold text-slate-800 mb-2">Administrasi Akademik</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Pemrosesan Kartu Rencana Studi (KRS), transkrip nilai, dan validasi status mahasiswa aktif.
                                </p>
                            </div>
                            
                            {{-- Item 2 --}}
                            <div class="group p-5 bg-white border border-slate-200 rounded-lg hover:border-orange-500 transition-colors duration-300">
                                <div class="w-12 h-12 bg-slate-50 rounded-lg flex items-center justify-center mb-4 group-hover:bg-orange-50 transition-colors">
                                    <i class="fas fa-envelope-open-text text-slate-600 group-hover:text-orange-600 text-xl"></i>
                                </div>
                                <h4 class="font-bold text-slate-800 mb-2">Layanan Persuratan</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Memproses pengajuan surat keterangan, surat izin penelitian, dan dokumen resmi fakultas lainnya.
                                </p>
                            </div>

                            {{-- Item 3 --}}
                            <div class="group p-5 bg-white border border-slate-200 rounded-lg hover:border-orange-500 transition-colors duration-300">
                                <div class="w-12 h-12 bg-slate-50 rounded-lg flex items-center justify-center mb-4 group-hover:bg-orange-50 transition-colors">
                                    <i class="fas fa-chart-pie text-slate-600 group-hover:text-orange-600 text-xl"></i>
                                </div>
                                <h4 class="font-bold text-slate-800 mb-2">Evaluasi Institusi</h4>
                                <p class="text-xs text-slate-500 leading-relaxed">
                                    Analisis statistik anonim untuk keperluan akreditasi dan peningkatan kualitas layanan fakultas.
                                </p>
                            </div>
                        </div>
                    </section>

                    <div class="w-full h-px bg-slate-100"></div>

                    {{-- 4. Keamanan Data --}}
                    <section id="keamanan-data" class="scroll-mt-28">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="flex items-center justify-center w-10 h-10 rounded bg-slate-100 text-slate-600 font-bold border border-slate-200">04</span>
                            <h2 class="text-2xl font-bold text-slate-900">Keamanan & Penyimpanan</h2>
                        </div>
                        
                        <div class="bg-slate-900 rounded-xl p-8 text-white relative overflow-hidden">
                            {{-- Pattern Overlay --}}
                            <div class="absolute top-0 right-0 w-64 h-64 bg-slate-800 rounded-full mix-blend-overlay filter blur-3xl opacity-50 -mr-16 -mt-16"></div>
                            
                            <div class="relative z-10 grid md:grid-cols-2 gap-8 items-center">
                                <div>
                                    <h3 class="text-xl font-bold mb-4 text-orange-400">Protokol Keamanan Tingkat Lanjut</h3>
                                    <p class="text-slate-300 text-sm leading-relaxed mb-6">
                                        Kami menerapkan standar keamanan industri untuk mencegah akses ilegal, perubahan, atau kebocoran data. Server kami dilindungi oleh firewall berlapis dan sistem enkripsi.
                                    </p>
                                    <ul class="space-y-3">
                                        <li class="flex items-center gap-3 text-sm text-slate-200">
                                            <i class="fas fa-lock text-orange-500"></i> Enkripsi SSL/TLS 256-bit
                                        </li>
                                        <li class="flex items-center gap-3 text-sm text-slate-200">
                                            <i class="fas fa-database text-orange-500"></i> Backup Data Berkala (Harian)
                                        </li>
                                        <li class="flex items-center gap-3 text-sm text-slate-200">
                                            <i class="fas fa-user-shield text-orange-500"></i> Akses Terbatas (Hanya Staff Berwenang)
                                        </li>
                                    </ul>
                                </div>
                                <div class="bg-slate-800/50 p-6 rounded-lg border border-slate-700">
                                    <div class="flex items-start gap-4">
                                        <div class="bg-orange-500/20 p-3 rounded-md">
                                            <i class="fas fa-exclamation-triangle text-orange-400 text-xl"></i>
                                        </div>
                                        <div>
                                            <h4 class="font-bold text-white text-sm mb-1">Peringatan Keamanan</h4>
                                            <p class="text-xs text-slate-400 leading-relaxed">
                                                Meskipun kami berusaha sebaik mungkin, tidak ada metode transmisi internet yang 100% aman. Mahasiswa dihimbau untuk menjaga kerahasiaan password akun SIAkad/Website masing-masing.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="w-full h-px bg-slate-100"></div>

                    {{-- 5. Hak Pengguna --}}
                    <section id="hak-pengguna" class="scroll-mt-28">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="flex items-center justify-center w-10 h-10 rounded bg-slate-100 text-slate-600 font-bold border border-slate-200">05</span>
                            <h2 class="text-2xl font-bold text-slate-900">Hak Pengguna</h2>
                        </div>
                        <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed">
                            <p>Sebagai pemilik data, Anda memiliki hak-hak berikut:</p>
                            <ul class="list-disc pl-5 space-y-2 mt-2">
                                <li><strong>Hak Akses:</strong> Meminta salinan data pribadi yang kami simpan.</li>
                                <li><strong>Hak Koreksi:</strong> Meminta perbaikan data yang tidak akurat.</li>
                                <li><strong>Hak Penghapusan:</strong> Meminta penghapusan data jika tidak lagi relevan dengan tujuan akademik (sesuai ketentuan UU Pendidikan).</li>
                            </ul>
                        </div>
                    </section>

                    <div class="w-full h-px bg-slate-100"></div>

                    {{-- 6. Cookies --}}
                    <section id="cookies" class="scroll-mt-28">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="flex items-center justify-center w-10 h-10 rounded bg-slate-100 text-slate-600 font-bold border border-slate-200">06</span>
                            <h2 class="text-2xl font-bold text-slate-900">Kebijakan Cookies</h2>
                        </div>
                        <div class="flex flex-col md:flex-row gap-6 items-start">
                            <div class="flex-1">
                                <p class="text-slate-600 mb-4 leading-relaxed">
                                    Website FEB UNSAP menggunakan "cookies" (file teks kecil yang disimpan di perangkat Anda) untuk meningkatkan pengalaman pengguna, mempercepat waktu loading, dan mengingat preferensi login Anda.
                                </p>
                                <p class="text-sm text-slate-500 italic">
                                    *Anda dapat menonaktifkan cookies melalui pengaturan browser, namun beberapa fitur website mungkin tidak berfungsi optimal.
                                </p>
                            </div>
                            <div class="md:w-1/3 bg-orange-50 border border-orange-100 p-5 rounded-lg">
                                <h4 class="font-bold text-slate-800 text-sm mb-3">Tipe Cookies Kami:</h4>
                                <ul class="space-y-2">
                                    <li class="flex items-center justify-between text-xs text-slate-600 border-b border-orange-200 pb-2">
                                        <span>Session Cookies</span>
                                        <span class="text-orange-600 font-medium">Wajib</span>
                                    </li>
                                    <li class="flex items-center justify-between text-xs text-slate-600 border-b border-orange-200 pb-2">
                                        <span>Analytics Cookies</span>
                                        <span class="text-slate-400">Opsional</span>
                                    </li>
                                    <li class="flex items-center justify-between text-xs text-slate-600">
                                        <span>Functional Cookies</span>
                                        <span class="text-orange-600 font-medium">Wajib</span>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection