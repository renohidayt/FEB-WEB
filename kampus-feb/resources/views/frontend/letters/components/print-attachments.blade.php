@if($submission->attachments && count($submission->attachments) > 0)
<div class="mb-6 print:mt-4"> {{-- ======================= --}}
    {{-- 1. TAMPILAN WEB (MODERN)--}}
    {{-- ======================= --}}
    <div class="print:hidden">
        <h3 class="text-sm font-bold text-slate-500 uppercase tracking-widest mb-3 flex items-center gap-2">
            <i class="fas fa-paperclip text-orange-500"></i> 
            Lampiran Berkas
        </h3>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
            @foreach($submission->attachments as $index => $attachment)
            <div class="bg-white border border-slate-200 rounded-lg p-3 flex items-center justify-between hover:shadow-md hover:border-orange-400 transition-all duration-200 group">
                <div class="flex items-center gap-3 overflow-hidden">
                    {{-- Icon PDF/File --}}
                    <div class="w-10 h-10 bg-orange-50 text-orange-600 rounded-md flex items-center justify-center flex-shrink-0 group-hover:bg-orange-600 group-hover:text-white transition-colors">
                        <i class="fas fa-file-alt text-lg"></i>
                    </div>
                    {{-- Nama File --}}
                    <div class="flex-1 min-w-0">
                        <p class="text-xs font-bold text-slate-700 mb-0.5">Lampiran {{ $index + 1 }}</p>
                        <p class="text-[11px] text-slate-500 truncate" title="{{ basename($attachment) }}">
                            {{ Str::limit(basename($attachment), 25) }}
                        </p>
                    </div>
                </div>
                {{-- Tombol Download --}}
                <a href="{{ route('letters.attachment.download', [$submission, $index]) }}" 
                   class="w-8 h-8 flex items-center justify-center text-slate-400 hover:text-orange-600 hover:bg-orange-50 rounded-full transition-colors"
                   title="Download Lampiran">
                    <i class="fas fa-download text-sm"></i>
                </a>
            </div>
            @endforeach
        </div>
    </div>

    {{-- ============================ --}}
    {{-- 2. TAMPILAN PRINT (FORMAL) --}}
    {{-- ============================ --}}
    <div class="hidden print:block" style="font-family: 'Times New Roman', Times, serif; font-size: 12pt; color: #000; margin-top: 10px;">
        <div style="margin-bottom: 5px; font-weight: bold;">
            Lampiran:
        </div>
        <ol style="margin: 0; padding-left: 20px; list-style-type: decimal;">
            @foreach($submission->attachments as $attachment)
            <li style="margin-bottom: 2px; line-height: 1.5; padding-left: 5px;">
                {{-- Membersihkan nama file jika terlalu panjang atau aneh saat di print --}}
                {{ basename($attachment) }}
            </li>
            @endforeach
        </ol>
    </div>

</div>
@endif