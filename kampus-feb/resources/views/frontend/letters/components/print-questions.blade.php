{{-- RINCIAN PERMOHONAN --}}
<div class="mb-6 print:mb-2">
    {{-- TAMPILAN WEB (Tetap sama) --}}
    <div class="bg-white rounded-xl border border-slate-200 shadow-sm overflow-hidden print:hidden">
        {{-- ... (Kode tampilan web biarkan saja) ... --}}
        <div class="p-4 text-center text-slate-500">Tampilan Web</div>
    </div>

    {{-- TAMPILAN PRINT (REVISI ALIGNMENT) --}}
    <div class="hidden print:block" style="font-family: 'Times New Roman', Times, serif; font-size: 12pt; color: #000;">
        @if($submission->template && is_array($submission->template->form_fields))
            {{-- Hapus margin/padding di table wrapper agar mepet kiri --}}
            <table style="width: 100%; border-collapse: collapse; margin-left: 0;"> 
                @foreach($submission->template->form_fields as $index => $field)
                    @php
                        $fieldName = $field['name'] ?? 'field_' . $index;
                        $answer = $submission->form_data[$fieldName] ?? '-';
                    @endphp
                    <tr>
                        {{-- Label: Hapus padding-left 20px agar sejajar dengan "Nama Lengkap" diatas --}}
                        <td style="width: 160px; vertical-align: top; padding: 2px 0;"> 
                            <span style="display: block;">{{ $field['label'] ?? 'Keterangan ' . ($index + 1) }}</span>
                        </td>
                        
                        {{-- Separator --}}
                        <td style="width: 20px; vertical-align: top; padding: 2px 0; text-align: center;">:</td>
                        
                        {{-- Value --}}
                        <td style="vertical-align: top; padding: 2px 0; text-align: justify;">
                            @if(is_array($answer))
                                @if(count($answer) === 1)
                                    {{ $answer[0] }}
                                @else
                                    <ol style="margin: 0; padding-left: 15px; list-style-type: decimal;">
                                        @foreach($answer as $v) 
                                            <li style="padding-left: 5px;">{{ $v }}</li>
                                        @endforeach
                                    </ol>
                                @endif
                            @else
                                {!! nl2br(e($answer)) !!}
                            @endif
                        </td>
                    </tr>
                @endforeach
            </table>
        @endif
    </div>
</div>