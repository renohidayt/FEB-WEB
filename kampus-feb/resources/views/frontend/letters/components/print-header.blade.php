<div class="hidden print:block mb-8" style="font-family: 'Times New Roman', Times, serif; color: #000;">
    {{-- Header Container --}}
    <table class="w-full" style="width: 100%; border-collapse: collapse; margin-bottom: 2px;">
        <tr>
            {{-- 1. Kolom Logo (Kiri) - Lebar fix --}}
            <td style="width: 15%; vertical-align: middle; text-align: left;">
                <img src="{{ asset('assets/img/logo/logo.png') }}" 
                     alt="Logo FEB UNSAP" 
                     style="width: 90px; height: auto; object-fit: contain;"
                     onerror="this.style.display='none'">
            </td>

            {{-- 2. Kolom Teks (Tengah) - Mengisi sisa ruang --}}
            <td style="width: 70%; vertical-align: middle; text-align: center;">
                <h2 style="font-size: 18px; font-weight: bold; margin: 0; line-height: 1.2; letter-spacing: 1px;">
                    UNIVERSITAS SEBELAS APRIL
                </h2>
                <h1 style="font-size: 22px; font-weight: bold; margin: 5px 0; text-transform: uppercase; line-height: 1.2;">
                    FAKULTAS EKONOMI & BISNIS
                </h1>
                <p style="font-size: 11px; margin: 0; line-height: 1.3; font-style: normal;">
                    Jl. Angkrek Situ No.19, Kec. Sumedang Utara, Kab. Sumedang, Jawa Barat 45323<br>
                    Telp: +62 852-1111-6071 | Email: feb@unsap.ac.id | Website: feb.unsap.ac.id
                </p>
            </td>

            {{-- 3. Kolom Penyeimbang (Kanan) - Kosong tapi lebarnya SAMA dengan Logo --}}
            <td style="width: 15%; text-align: right;">
                &nbsp; </td>
        </tr>
    </table>

    {{-- Garis Pembatas (Double Line) --}}
    <div style="border-top: 3px solid #000; border-bottom: 1px solid #000; height: 3px; margin-bottom: 25px;"></div>

    {{-- Judul Surat --}}
    <div style="text-align: center; margin-bottom: 30px;">
        <h3 style="font-size: 16px; font-weight: bold; text-transform: uppercase; text-decoration: underline; text-underline-offset: 4px; margin: 0 0 5px 0; letter-spacing: 0.5px;">
            {{ strtoupper($submission->template->title ?? 'SURAT PERMOHONAN') }}
        </h3>
        <p style="font-size: 12px; margin: 0;">
            Nomor: {{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}/FEB-UNSAP/{{ $submission->submitted_at->format('m/Y') }}
        </p>
    </div>

   {{-- Pembuka Surat --}}
    <div style="margin-bottom: 16px; font-size: 12pt; font-family: 'Times New Roman', Times, serif; line-height: 1.5; text-align: left; color: #000;">
        <p style="margin: 0;">
            Yang bertanda tangan di bawah ini:
        </p>
    </div>
</div>