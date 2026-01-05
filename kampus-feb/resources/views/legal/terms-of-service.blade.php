@extends('layouts.app')

@section('title', 'Syarat dan Ketentuan - FEB UNSAP')

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
                    <li class="text-orange-500">Syarat dan Ketentuan</li>
                </ol>
            </nav>

            {{-- Title Header --}}
            <div class="max-w-4xl">
                <div class="inline-flex items-center gap-2 px-3 py-1 bg-slate-800 border border-slate-700 rounded text-xs font-bold text-orange-400 tracking-wider uppercase mb-4">
                   
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-white mb-4 leading-tight">
                    Syarat & Ketentuan <br/>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Penggunaan Layanan</span>
                </h1>
                <p class="text-lg text-slate-400 max-w-2xl leading-relaxed">
                    Aturan dan panduan resmi penggunaan layanan digital di lingkungan Fakultas Ekonomi dan Bisnis UNSAP.
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
                        <a href="#penerimaan" class="group flex items-center justify-between px-3 py-2 text-sm font-medium text-slate-600 hover:text-orange-600 hover:bg-orange-50 border-l-2 border-transparent hover:border-orange-500 transition-all rounded-r-md">
                            <span>1. Penerimaan</span>
                        </a>
                        <a href="#penggunaan" class="group flex items-center justify-between px-3 py-2 text-sm font-medium text-slate-600 hover:text-orange-600 hover:bg-orange-50 border-l-2 border-transparent hover:border-orange-500 transition-all rounded-r-md">
                            <span>2. Penggunaan Layanan</span>
                        </a>
                        <a href="#akun" class="group flex items-center justify-between px-3 py-2 text-sm font-medium text-slate-600 hover:text-orange-600 hover:bg-orange-50 border-l-2 border-transparent hover:border-orange-500 transition-all rounded-r-md">
                            <span>3. Akun Pengguna</span>
                        </a>
                        <a href="#konten" class="group flex items-center justify-between px-3 py-2 text-sm font-medium text-slate-600 hover:text-orange-600 hover:bg-orange-50 border-l-2 border-transparent hover:border-orange-500 transition-all rounded-r-md">
                            <span>4. Konten</span>
                        </a>
                        <a href="#larangan" class="group flex items-center justify-between px-3 py-2 text-sm font-medium text-slate-600 hover:text-orange-600 hover:bg-orange-50 border-l-2 border-transparent hover:border-orange-500 transition-all rounded-r-md">
                            <span>5. Larangan</span>
                        </a>
                        <a href="#intelektual" class="group flex items-center justify-between px-3 py-2 text-sm font-medium text-slate-600 hover:text-orange-600 hover:bg-orange-50 border-l-2 border-transparent hover:border-orange-500 transition-all rounded-r-md">
                            <span>6. Hak Intelektual</span>
                        </a>
                        <a href="#tanggung-jawab" class="group flex items-center justify-between px-3 py-2 text-sm font-medium text-slate-600 hover:text-orange-600 hover:bg-orange-50 border-l-2 border-transparent hover:border-orange-500 transition-all rounded-r-md">
                            <span>7. Tanggung Jawab</span>
                        </a>
                        <a href="#perubahan" class="group flex items-center justify-between px-3 py-2 text-sm font-medium text-slate-600 hover:text-orange-600 hover:bg-orange-50 border-l-2 border-transparent hover:border-orange-500 transition-all rounded-r-md">
                            <span>8. Perubahan</span>
                        </a>
                    </nav>
                </div>
            </div>

            {{-- MAIN CONTENT --}}
            <div class="lg:col-span-9">
                <div class="bg-white rounded-xl shadow-sm border border-slate-200 p-8 md:p-12 space-y-16">
                    
                    {{-- Alert Box --}}
                    <div class="bg-slate-50 border border-slate-200 border-l-4 border-l-orange-500 p-6 rounded-r-lg">
                        <div class="flex items-start gap-4">
                            <i class="fas fa-gavel text-orange-600 text-xl mt-1"></i>
                            <div>
                                <h3 class="font-bold text-slate-900 mb-1">Pernyataan Persetujuan</h3>
                                <p class="text-sm text-slate-600 leading-relaxed">
                                    Dengan mengakses dan menggunakan website ini, Anda menyatakan telah membaca, memahami, dan menyetujui untuk terikat dengan Syarat dan Ketentuan berikut.
                                </p>
                            </div>
                        </div>
                    </div>

                    {{-- 1. Penerimaan --}}
                    <section id="penerimaan" class="scroll-mt-28">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="flex items-center justify-center w-10 h-10 rounded bg-slate-100 text-slate-600 font-bold border border-slate-200">01</span>
                            <h2 class="text-2xl font-bold text-slate-900">Penerimaan Ketentuan</h2>
                        </div>
                        <div class="prose prose-slate max-w-none text-slate-600 leading-relaxed">
                            <p class="mb-4">
                                Syarat dan Ketentuan ini mengatur penggunaan website Fakultas Ekonomi dan Bisnis Universitas Sebelas April ("Website"). Dengan mengakses atau menggunakan Website ini, Anda setuju untuk terikat oleh Syarat dan Ketentuan ini.
                            </p>
                            <p>
                                Jika Anda tidak setuju dengan syarat dan ketentuan ini, Anda tidak diperkenankan untuk menggunakan layanan kami. Kami berhak untuk mengubah atau memodifikasi ketentuan ini kapan saja demi kepatuhan hukum dan operasional.
                            </p>
                        </div>
                    </section>

                    <div class="w-full h-px bg-slate-100"></div>

                    {{-- 2. Penggunaan Layanan --}}
                    <section id="penggunaan" class="scroll-mt-28">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="flex items-center justify-center w-10 h-10 rounded bg-slate-100 text-slate-600 font-bold border border-slate-200">02</span>
                            <h2 class="text-2xl font-bold text-slate-900">Cakupan Layanan</h2>
                        </div>
                        <p class="text-slate-600 mb-6">Website ini menyediakan infrastruktur digital untuk mendukung kegiatan akademik, meliputi:</p>
                        
                        <div class="grid md:grid-cols-2 gap-6">
                            <div class="bg-slate-50 p-6 rounded-lg border border-slate-200 hover:border-orange-400 transition-colors">
                                <h4 class="font-bold text-slate-800 mb-3 flex items-center gap-2">
                                    <i class="fas fa-user-graduate text-orange-500"></i>
                                    Layanan Mahasiswa
                                </h4>
                                <ul class="text-sm text-slate-600 space-y-2">
                                    <li class="flex items-start gap-2"><span class="w-1.5 h-1.5 rounded-full bg-slate-400 mt-1.5"></span> Pengajuan surat keterangan & legalisir</li>
                                    <li class="flex items-start gap-2"><span class="w-1.5 h-1.5 rounded-full bg-slate-400 mt-1.5"></span> Akses dashboard akademik personal</li>
                                    <li class="flex items-start gap-2"><span class="w-1.5 h-1.5 rounded-full bg-slate-400 mt-1.5"></span> Portal bimbingan dan tugas akhir</li>
                                </ul>
                            </div>
                            
                            <div class="bg-slate-50 p-6 rounded-lg border border-slate-200 hover:border-orange-400 transition-colors">
                                <h4 class="font-bold text-slate-800 mb-3 flex items-center gap-2">
                                    <i class="fas fa-bullhorn text-orange-500"></i>
                                    Informasi Publik
                                </h4>
                                <ul class="text-sm text-slate-600 space-y-2">
                                    <li class="flex items-start gap-2"><span class="w-1.5 h-1.5 rounded-full bg-slate-400 mt-1.5"></span> Berita, agenda, dan pengumuman fakultas</li>
                                    <li class="flex items-start gap-2"><span class="w-1.5 h-1.5 rounded-full bg-slate-400 mt-1.5"></span> Profil dosen dan tenaga kependidikan</li>
                                    <li class="flex items-start gap-2"><span class="w-1.5 h-1.5 rounded-full bg-slate-400 mt-1.5"></span> Informasi akreditasi dan kurikulum</li>
                                </ul>
                            </div>
                        </div>
                    </section>

                    <div class="w-full h-px bg-slate-100"></div>

                    {{-- 3. Akun Pengguna --}}
                    <section id="akun" class="scroll-mt-28">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="flex items-center justify-center w-10 h-10 rounded bg-slate-100 text-slate-600 font-bold border border-slate-200">03</span>
                            <h2 class="text-2xl font-bold text-slate-900">Keamanan Akun</h2>
                        </div>
                        <div class="bg-white border border-slate-200 rounded-lg overflow-hidden">
                            <div class="p-4 bg-slate-50 border-b border-slate-200">
                                <h3 class="font-bold text-slate-800 text-sm uppercase tracking-wide">Kewajiban Pengguna</h3>
                            </div>
                            <div class="p-6 grid gap-6">
                                <div class="flex items-start gap-4">
                                    <div class="bg-orange-50 p-2 rounded text-orange-600">
                                        <i class="fas fa-key"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-sm">Kerahasiaan Kredensial</h4>
                                        <p class="text-sm text-slate-600 mt-1">Anda bertanggung jawab penuh menjaga kerahasiaan NIM/NIP dan password. Jangan membagikan akses kepada pihak ketiga.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="bg-orange-50 p-2 rounded text-orange-600">
                                        <i class="fas fa-user-check"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-sm">Validitas Data</h4>
                                        <p class="text-sm text-slate-600 mt-1">Pengguna wajib memastikan seluruh data profil yang diinput adalah akurat, terbaru, dan dapat dipertanggungjawabkan.</p>
                                    </div>
                                </div>
                                <div class="flex items-start gap-4">
                                    <div class="bg-orange-50 p-2 rounded text-orange-600">
                                        <i class="fas fa-shield-alt"></i>
                                    </div>
                                    <div>
                                        <h4 class="font-bold text-slate-800 text-sm">Pelaporan Insiden</h4>
                                        <p class="text-sm text-slate-600 mt-1">Segera laporkan kepada Unit ICT jika Anda mencurigai adanya akses tidak sah pada akun Anda.</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <div class="w-full h-px bg-slate-100"></div>

                    {{-- 4. Konten & 5. Larangan --}}
                    <div class="grid md:grid-cols-2 gap-8">
                        <section id="konten" class="scroll-mt-28">
                            <div class="flex items-center gap-4 mb-6">
                                <span class="flex items-center justify-center w-10 h-10 rounded bg-slate-100 text-slate-600 font-bold border border-slate-200">04</span>
                                <h2 class="text-2xl font-bold text-slate-900">Akses Konten</h2>
                            </div>
                            <p class="text-slate-600 text-sm leading-relaxed mb-4">
                                Seluruh materi digital (dokumen, gambar, logo) adalah aset FEB UNSAP. Penggunaan diatur sebagai berikut:
                            </p>
                            <ul class="space-y-3">
                                <li class="flex items-start gap-3 text-sm text-slate-600">
                                    <i class="fas fa-check-circle text-green-500 mt-1"></i>
                                    <span><strong>Diizinkan:</strong> Mengunduh materi kuliah dan dokumen publik untuk keperluan studi pribadi.</span>
                                </li>
                                <li class="flex items-start gap-3 text-sm text-slate-600">
                                    <i class="fas fa-times-circle text-red-500 mt-1"></i>
                                    <span><strong>Dilarang:</strong> Memodifikasi, menjual kembali, atau mendistribusikan materi akademik tanpa izin tertulis.</span>
                                </li>
                            </ul>
                        </section>

                        <section id="larangan" class="scroll-mt-28">
                            <div class="flex items-center gap-4 mb-6">
                                <span class="flex items-center justify-center w-10 h-10 rounded bg-slate-100 text-slate-600 font-bold border border-slate-200">05</span>
                                <h2 class="text-2xl font-bold text-slate-900">Larangan Keras</h2>
                            </div>
                            <div class="bg-slate-50 p-5 rounded-lg border-l-4 border-red-500">
                                <p class="text-xs font-bold text-red-600 uppercase mb-3">Tindakan berikut dapat mengakibatkan sanksi akademik:</p>
                                <ul class="space-y-2 text-sm text-slate-700">
                                    <li class="flex items-center gap-2">
                                        <i class="fas fa-ban text-red-500 text-xs"></i> Hacking, scraping, atau serangan DDoS.
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <i class="fas fa-ban text-red-500 text-xs"></i> Memalsukan dokumen akademik digital.
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <i class="fas fa-ban text-red-500 text-xs"></i> Menyebarkan malware/virus melalui upload file.
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <i class="fas fa-ban text-red-500 text-xs"></i> Ujaran kebencian atau pelecehan di forum.
                                    </li>
                                </ul>
                            </div>
                        </section>
                    </div>

                    <div class="w-full h-px bg-slate-100"></div>

                    {{-- 6. HAKI --}}
                    <section id="intelektual" class="scroll-mt-28">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="flex items-center justify-center w-10 h-10 rounded bg-slate-100 text-slate-600 font-bold border border-slate-200">06</span>
                            <h2 class="text-2xl font-bold text-slate-900">Hak Kekayaan Intelektual</h2>
                        </div>
                        <div class="bg-slate-900 text-slate-300 p-6 rounded-lg flex flex-col md:flex-row items-center gap-6">
                            <div class="text-4xl text-slate-600">
                                <i class="fas fa-copyright"></i>
                            </div>
                            <div class="text-sm leading-relaxed">
                                <p class="mb-2">
                                    Hak Cipta © {{ date('Y') }} <strong>FEB UNSAP</strong>. All rights reserved.
                                </p>
                                <p>
                                    Logo, desain antarmuka, dan kode sumber website ini dilindungi oleh undang-undang Hak Cipta. Penggunaan nama dan atribut universitas harus sesuai dengan pedoman identitas visual institusi.
                                </p>
                            </div>
                        </div>
                    </section>

                    <div class="w-full h-px bg-slate-100"></div>

                    {{-- 7. Batasan Tanggung Jawab & 8. Perubahan --}}
                    <section id="tanggung-jawab" class="scroll-mt-28">
                        <div class="flex items-center gap-4 mb-6">
                            <span class="flex items-center justify-center w-10 h-10 rounded bg-slate-100 text-slate-600 font-bold border border-slate-200">07</span>
                            <h2 class="text-2xl font-bold text-slate-900">Disclaimer & Perubahan</h2>
                        </div>
                        <div class="prose prose-slate max-w-none text-slate-600">
                            <p class="mb-4">
                                FEB UNSAP berupaya menyajikan informasi seakurat mungkin. Namun, kami tidak bertanggung jawab atas kerugian langsung maupun tidak langsung yang timbul akibat:
                            </p>
                            <ul class="list-disc pl-5 mb-6 space-y-1">
                                <li>Gangguan teknis server atau jaringan internet pengguna.</li>
                                <li>Kesalahan input data oleh pengguna.</li>
                                <li>Konten dari tautan eksternal pihak ketiga.</li>
                            </ul>
                            
                            <div class="p-4 bg-orange-50 border border-orange-100 rounded-lg">
                                <h4 class="font-bold text-slate-800 text-sm mb-1">Klausul Perubahan</h4>
                                <p class="text-sm text-slate-600">
                                    Kami berhak memperbarui Syarat dan Ketentuan ini sewaktu-waktu tanpa pemberitahuan individu. Pengguna disarankan meninjau halaman ini secara berkala. Penggunaan berkelanjutan dianggap sebagai persetujuan terhadap perubahan tersebut.
                                </p>
                            </div>
                        </div>
                    </section>

                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Custom Scroll Offset for Sticky Header overlap */
    .scroll-mt-28 {
        scroll-margin-top: 7rem;
    }
    html {
        scroll-behavior: smooth;
    }
</style>
@endsection