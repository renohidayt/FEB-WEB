{{-- ======================= --}}
{{-- LOGIKA HITUNG SEMESTER  --}}
{{-- ======================= --}}
@php
    // 1. Ambil Tanggal Masuk (Sesuaikan 'mahasiswa' dengan relasi di model Anda)
    // Jika data tidak ketemu, default ke hari ini (Semester 1)
    $tglMasuk = $submission->user->student->tanggal_masuk 
                ?? $submission->mahasiswa->tanggal_masuk 
                ?? now(); 

    // 2. Hitung Semester
    $selisihBulan = $tglMasuk->diffInMonths(now());
    $semesterBerjalan = ceil(($selisihBulan + 1) / 6);
    
    // Pastikan minimal semester 1
    if ($semesterBerjalan < 1) { $semesterBerjalan = 1; }
@endphp

<div class="mb-6 print:mb-2" style="font-family: 'Times New Roman', Times, serif; font-size: 12pt; color: #000;">
    
    {{-- ======================= --}}
    {{-- 1. TABEL DATA PEMOHON --}}
    {{-- ======================= --}}
    <div class="bg-white rounded-xl border border-slate-200 p-5 print:p-0 print:border-none print:shadow-none print:bg-transparent print:rounded-none">
        
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 0;">
            {{-- Baris Nama --}}
            <tr>
                <td style="width: 160px; vertical-align: top; padding: 4px 0; print:padding: 2px 0 2px 20px;">
                    <span class="font-medium text-slate-500 print:text-black print:font-normal">Nama Lengkap</span>
                </td>
                <td style="width: 20px; vertical-align: top; padding: 4px 0; text-align: center; print:padding: 2px 0;">:</td>
                <td style="vertical-align: top; padding: 4px 0; font-weight: 600; color: #1e293b; print:font-weight: normal; print:color: #000; print:padding: 2px 0;">
                    {{ $submission->nama_mahasiswa }}
                </td>
            </tr>

            {{-- Baris NIM --}}
            <tr>
                <td style="width: 160px; vertical-align: top; padding: 4px 0; print:padding: 2px 0 2px 20px;">
                    <span class="font-medium text-slate-500 print:text-black print:font-normal">NIM</span>
                </td>
                <td style="width: 20px; vertical-align: top; padding: 4px 0; text-align: center; print:padding: 2px 0;">:</td>
                <td style="vertical-align: top; padding: 4px 0; print:padding: 2px 0;">
                    {{ $submission->nim ?? '-' }}
                </td>
            </tr>

            {{-- Baris Prodi --}}
            <tr>
                <td style="width: 160px; vertical-align: top; padding: 4px 0; print:padding: 2px 0 2px 20px;">
                    <span class="font-medium text-slate-500 print:text-black print:font-normal">Program Studi</span>
                </td>
                <td style="width: 20px; vertical-align: top; padding: 4px 0; text-align: center; print:padding: 2px 0;">:</td>
                <td style="vertical-align: top; padding: 4px 0; print:padding: 2px 0;">
                    {{ $submission->prodi ?? '-' }}
                </td>
            </tr>

            {{-- =========================== --}}
            {{-- Baris Semester (BARU)       --}}
            {{-- =========================== --}}
            <tr>
                <td style="width: 160px; vertical-align: top; padding: 4px 0; print:padding: 2px 0 2px 20px;">
                    <span class="font-medium text-slate-500 print:text-black print:font-normal">Semester</span>
                </td>
                <td style="width: 20px; vertical-align: top; padding: 4px 0; text-align: center; print:padding: 2px 0;">:</td>
                <td style="vertical-align: top; padding: 4px 0; print:padding: 2px 0;">
                    {{ $semesterBerjalan }}
                </td>
            </tr>
        </table>
    </div>
</div>

{{-- ======================= --}}
{{-- 2. PENGANTAR ISI SURAT --}}
{{-- ======================= --}}
{{-- Hanya tampil saat Print --}}
<div class="hidden print:block mb-4" style="font-family: 'Times New Roman', Times, serif; font-size: 12pt; line-height: 1.5; text-align: justify; margin-top: 15px;">
    <p style="margin: 0;">
        Melalui surat ini, saya bermaksud untuk mengajukan permohonan <strong>{{ strtolower($submission->template->title ?? 'surat') }}</strong> sesuai dengan kebutuhan dan ketentuan yang berlaku. Sebagai bahan pertimbangan Bapak/Ibu, berikut saya sampaikan rincian data dan informasi yang diperlukan:
    </p>
</div>