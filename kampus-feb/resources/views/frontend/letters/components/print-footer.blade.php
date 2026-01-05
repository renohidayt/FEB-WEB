<div class="hidden print:block" style="font-family: 'Times New Roman', Times, serif; font-size: 12pt; color: #000; margin-top: 20px;">
    
    {{-- ============================= --}}
    {{-- 1. KALIMAT PENUTUP --}}
    {{-- ============================= --}}
    <div style="text-align: justify; line-height: 1.6; margin-bottom: 50px;">
        <p style="margin: 0; text-indent: 40px;">
            Demikian surat permohonan ini saya sampaikan dengan sebenar-benarnya. Besar harapan saya kiranya permohonan ini dapat dipertimbangkan dan diproses sesuai dengan ketentuan yang berlaku. Atas perhatian, pertimbangan, dan kerjasamanya, saya ucapkan terima kasih.
        </p>
    </div>

    {{-- ============================= --}}
    {{-- 2. AREA TANDA TANGAN --}}
    {{-- ============================= --}}
    @if($submission->template && $submission->template->requires_approval_signature)
        {{-- ===== SCENARIO A: 2 TANDA TANGAN (Kiri: Pejabat, Kanan: Mahasiswa) ===== --}}
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px; page-break-inside: avoid;">
            <tr>
                {{-- KOLOM KIRI (PEJABAT) --}}
                <td style="width: 50%; vertical-align: top; text-align: center; padding-right: 15px;">
                    <p style="margin: 0 0 10px 0; line-height: 1.5;">
                        Mengetahui/Menyetujui,<br>
                        <span style="font-weight: normal;">{{ $submission->template->approval_title ?? 'Pejabat Berwenang' }}</span>
                    </p>
                    
                    {{-- Ruang untuk tanda tangan basah --}}
                    <div style="height: 70px; margin: 10px 0;"></div>
                    
                    <div style="text-align: center; margin-top: 5px;">
                        <span style="font-weight: bold; text-decoration: underline; text-decoration-style: solid; text-underline-offset: 3px;">
                            {{ $submission->status === 'approved' ? ($submission->template->approval_name ?? '( .................................. )') : '( .................................. )' }}
                        </span>
                        @if($submission->template->approval_nip)
                        <p style="margin: 5px 0 0 0; font-size: 11pt;">
                            NIP/NIDN. {{ $submission->status === 'approved' ? $submission->template->approval_nip : '................................' }}
                        </p>
                        @endif
                    </div>
                </td>

                {{-- KOLOM KANAN (MAHASISWA) --}}
                <td style="width: 50%; vertical-align: top; text-align: center; padding-left: 15px;">
                    <p style="margin: 0 0 10px 0; line-height: 1.5;">
                        Sumedang, {{ $submission->submitted_at->locale('id')->isoFormat('D MMMM YYYY') }}<br>
                        Pemohon,
                    </p>
                    
                    {{-- Ruang untuk tanda tangan basah --}}
                    <div style="height: 70px; margin: 10px 0;"></div>
                    
                    <div style="text-align: center; margin-top: 5px;">
                        <span style="font-weight: bold; text-decoration: underline; text-decoration-style: solid; text-underline-offset: 3px;">
                            {{ strtoupper($submission->nama_mahasiswa) }}
                        </span>
                        <p style="margin: 5px 0 0 0; font-size: 11pt;">
                            NIM. {{ $submission->nim ?? '-' }}
                        </p>
                    </div>
                </td>
            </tr>
        </table>
    @else
        {{-- ===== SCENARIO B: 1 TANDA TANGAN (Hanya Mahasiswa - Rata Kanan) ===== --}}
        <table style="width: 100%; border-collapse: collapse; margin-bottom: 30px; page-break-inside: avoid;">
            <tr>
                <td style="width: 55%;">&nbsp;</td>
                
                <td style="width: 45%; vertical-align: top; text-align: center; padding-left: 20px;">
                    <p style="margin: 0 0 10px 0; line-height: 1.5;">
                        Sumedang, {{ $submission->submitted_at->locale('id')->isoFormat('D MMMM YYYY') }}<br>
                        Hormat saya,
                    </p>
                    
                    {{-- Ruang untuk tanda tangan basah --}}
                    <div style="height: 70px; margin: 10px 0;"></div>
                    
                    <div style="text-align: center; margin-top: 5px;">
                        <span style="font-weight: bold; text-decoration: underline; text-decoration-style: solid; text-underline-offset: 3px;">
                            {{ strtoupper($submission->nama_mahasiswa) }}
                        </span>
                        <p style="margin: 5px 0 0 0; font-size: 11pt;">
                            NIM. {{ $submission->nim ?? '-' }}
                        </p>
                    </div>
                </td>
            </tr>
        </table>
    @endif

{{-- ============================= --}}
{{-- 3. FOOTER DOKUMEN --}}
{{-- ============================= --}}
<div style="margin-top: 70px; page-break-inside: avoid;">
    {{-- Garis Pemisah yang tidak melebihi margin --}}
    <hr style="border: none; border-top: 1.5px solid #999; margin: 0 0 12px 0;" />
    
    {{-- Teks Footer --}}
    <div style="font-size: 9pt; font-style: italic; color: #555; text-align: center; line-height: 1.5;">
        <p style="margin: 0 0 4px 0;">
            Dokumen ini dicetak secara otomatis dari Sistem Administrasi Digital FEB UNSAP.
        </p>
        <p style="margin: 0;">
            <span style="font-weight: 500;">Kode Validasi:</span> 
            <strong style="color: #000; font-style: normal;">#{{ str_pad($submission->id, 5, '0', STR_PAD_LEFT) }}</strong> 
            | Dicetak pada: <span style="font-weight: 500;">{{ now()->locale('id')->isoFormat('dddd, D MMMM YYYY [pukul] HH:mm') }} WIB</span>
        </p>
    </div>
</div>