@extends('layouts.app')

@section('title', 'Ajukan Surat - ' . $template->title)

@section('content')

{{-- HERO BANNER --}}
<div class="relative bg-slate-900 text-white pt-10 pb-10 overflow-hidden border-b border-white/5 font-poppins">
    <div class="absolute inset-0 opacity-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] z-0"></div>
    <div class="absolute top-0 right-0 -mr-20 -mt-20 w-80 h-80 bg-orange-600 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob z-0"></div>
    <div class="absolute bottom-0 left-0 -ml-20 -mb-20 w-80 h-80 bg-blue-700 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000 z-0"></div>
    
    <div class="container mx-auto px-4 relative z-10">
        {{-- Breadcrumb --}}
        <nav class="w-full flex items-center text-sm font-medium mb-10">
            <a href="{{ url('/') }}" class="text-slate-400 hover:text-white transition-colors flex items-center gap-2 group">
                <i class="fas fa-home text-orange-500/80 group-hover:text-orange-500 transition-colors"></i> 
                <span class="group-hover:underline decoration-orange-500 decoration-2 underline-offset-4">Beranda</span>
            </a>
            <span class="mx-3 text-slate-600">/</span>
            <a href="{{ route('letters.index') }}" class="text-slate-400 hover:text-white transition-colors group">
                <span class="group-hover:underline decoration-orange-500 decoration-2 underline-offset-4">Pengajuan Surat</span>
            </a>
            <span class="mx-3 text-slate-600">/</span>
            <span class="text-orange-500 font-semibold cursor-default">{{ $template->title }}</span>
        </nav>

        <div class="grid md:grid-cols-2 gap-8 items-center">
            {{-- Text Content --}}
            <div class="text-left animate-fade-in-left"> 
                <h1 class="text-4xl md:text-6xl font-extrabold mb-4 tracking-tight leading-tight uppercase">
                    Form <br>
                    <span class="text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-orange-600">Pengajuan</span>
                </h1>
                <div class="w-20 h-1.5 bg-orange-500 mb-6 rounded-full"></div>
                <p class="text-lg text-slate-300 font-light leading-relaxed max-w-lg">
                    {{ $template->title }}
                </p>
                @if($template->description)
                <p class="text-sm text-slate-400 mt-2">
                    {{ $template->description }}
                </p>
                @endif
            </div>

            {{-- 3D Visual Element --}}
            <div class="hidden md:block relative h-[280px] flex items-center justify-center perspective-1000">
                <div class="absolute w-56 h-56 bg-orange-500/10 rounded-full blur-[60px]"></div>

                {{-- Main Card --}}
                <div class="relative w-72 bg-slate-800/40 backdrop-blur-xl border border-white/10 p-6 rounded-2xl shadow-2xl transform rotate-y-6 transition-transform duration-700 hover:rotate-y-0">
                    <div class="bg-gradient-to-br from-slate-700/50 to-slate-800/50 h-32 rounded-xl mb-4 flex items-center justify-center border border-white/5 group">
                        <i class="fas fa-edit text-5xl text-slate-500 group-hover:text-orange-500 transition-all duration-500"></i>
                    </div>
                    <div class="space-y-3 px-2">
                        <div class="h-2 bg-orange-500/40 rounded-full w-3/4 mx-auto"></div>
                        <div class="h-2 bg-slate-600/30 rounded-full w-1/2 mx-auto"></div>
                    </div>
                </div>

                {{-- Floating Badge 1 --}}
                <div class="absolute -top-4 right-8 bg-slate-800/95 backdrop-blur-md border border-orange-500/30 p-3 rounded-2xl shadow-xl animate-bounce" style="animation-duration: 3s;">
                    <i class="fas fa-pencil-alt text-orange-500 text-xl"></i>
                </div>
                
                {{-- Floating Badge 2 --}}
                <div class="absolute -bottom-4 left-8 bg-slate-800/90 backdrop-blur-md border border-blue-500/30 p-3 rounded-xl shadow-xl animate-bounce" style="animation-duration: 4s;">
                    <div class="flex items-center gap-2 font-bold text-xs text-white">
                        <i class="fas fa-paper-plane text-blue-400"></i> Submit Digital
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- MAIN CONTENT --}}
<div class="bg-slate-50 font-poppins text-slate-800 py-8">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 mt-4 relative z-20">
        
        {{-- Student Info Card (if student) --}}
        @if($student)
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-5 mb-6 shadow-sm">
            <div class="flex items-start gap-4">
                <div class="p-3 bg-blue-100 rounded-lg text-blue-600">
                    <i class="fas fa-user-graduate text-xl"></i>
                </div>
                <div class="flex-1">
                    <h3 class="text-sm font-bold text-blue-900 mb-3 uppercase tracking-wider">Data Mahasiswa</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-sm">
                        <div class="bg-white/60 rounded px-3 py-2">
                            <span class="text-blue-700 font-medium block text-xs mb-1">Nama</span>
                            <span class="text-blue-900 font-bold">{{ $student->nama }}</span>
                        </div>
                        <div class="bg-white/60 rounded px-3 py-2">
                            <span class="text-blue-700 font-medium block text-xs mb-1">NIM</span>
                            <span class="text-blue-900 font-bold">{{ $student->nim }}</span>
                        </div>
                        <div class="bg-white/60 rounded px-3 py-2">
                            <span class="text-blue-700 font-medium block text-xs mb-1">Program Studi</span>
                            <span class="text-blue-900 font-bold">{{ $student->program_studi }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        {{-- FORM CARD --}}
        <div class="bg-white border border-slate-200 rounded-lg shadow-lg overflow-hidden">
            <div class="bg-gradient-to-r from-orange-500 to-orange-600 px-6 py-4">
                <h2 class="text-xl font-bold text-white flex items-center gap-2">
                    <i class="fas fa-edit"></i>
                    Form Pengajuan Surat
                </h2>
            </div>

            <form action="{{ route('letters.store') }}" method="POST" enctype="multipart/form-data" class="p-6">
                @csrf
                <input type="hidden" name="letter_template_id" value="{{ $template->id }}">
                
                {{-- Dynamic Form Fields --}}
                <div class="space-y-6">
                    @if(is_array($template->form_fields) && count($template->form_fields) > 0)
                        @foreach($template->form_fields as $index => $field)
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2 uppercase tracking-wide text-xs">
                                {{ $field['label'] ?? 'Field ' . ($index + 1) }}
                                @if(($field['required'] ?? false))
                                <span class="text-red-500">*</span>
                                @endif
                            </label>
                            
                            @php
                                $fieldType = $field['type'] ?? 'text';
                                $fieldName = 'form_data[' . ($field['name'] ?? 'field_' . $index) . ']';
                                $isRequired = ($field['required'] ?? false) ? 'required' : '';
                            @endphp

                            @switch($fieldType)
                                @case('text')
                                @case('text_pendek')
                                    <input type="text" 
                                           name="{{ $fieldName }}" 
                                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition bg-white hover:border-slate-400"
                                           placeholder="{{ $field['placeholder'] ?? '' }}"
                                           {{ $isRequired }}>
                                    @break

                                @case('textarea')
                                @case('text_panjang')
                                    <textarea name="{{ $fieldName }}" 
                                              rows="4"
                                              class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition bg-white hover:border-slate-400"
                                              placeholder="{{ $field['placeholder'] ?? '' }}"
                                              {{ $isRequired }}></textarea>
                                    @break

                                @case('email')
                                    <input type="email" 
                                           name="{{ $fieldName }}" 
                                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition bg-white hover:border-slate-400"
                                           placeholder="email@example.com"
                                           {{ $isRequired }}>
                                    @break

                                @case('angka')
                                @case('number')
                                    <input type="number" 
                                           name="{{ $fieldName }}" 
                                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition bg-white hover:border-slate-400"
                                           {{ $isRequired }}>
                                    @break

                                @case('tanggal')
                                @case('date')
                                    <input type="date" 
                                           name="{{ $fieldName }}" 
                                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition bg-white hover:border-slate-400"
                                           {{ $isRequired }}>
                                    @break

                                @case('dropdown')
                                @case('select')
                                    <select name="{{ $fieldName }}" 
                                            class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition bg-white hover:border-slate-400"
                                            {{ $isRequired }}>
                                        <option value="">Pilih...</option>
                                        @if(isset($field['options']) && is_array($field['options']))
                                            @foreach($field['options'] as $option)
                                            <option value="{{ $option }}">{{ $option }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    @break

                                @case('radio')
                                @case('pilihan_ganda')
                                    <div class="space-y-2">
                                        @if(isset($field['options']) && is_array($field['options']))
                                            @foreach($field['options'] as $optIndex => $option)
                                            <label class="flex items-center p-3 border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer transition">
                                                <input type="radio" 
                                                       name="{{ $fieldName }}" 
                                                       value="{{ $option }}"
                                                       class="w-4 h-4 text-orange-600 border-slate-300 focus:ring-orange-500"
                                                       {{ $isRequired && $optIndex === 0 ? 'required' : '' }}>
                                                <span class="ml-3 text-slate-700 font-medium text-sm">{{ $option }}</span>
                                            </label>
                                            @endforeach
                                        @endif
                                    </div>
                                    @break

                                @case('checkbox')
                                    <div class="space-y-2">
                                        @if(isset($field['options']) && is_array($field['options']))
                                            @foreach($field['options'] as $option)
                                            <label class="flex items-center p-3 border border-slate-200 rounded-lg hover:bg-slate-50 cursor-pointer transition">
                                                <input type="checkbox" 
                                                       name="{{ $fieldName }}[]" 
                                                       value="{{ $option }}"
                                                       class="w-4 h-4 text-orange-600 border-slate-300 rounded focus:ring-orange-500">
                                                <span class="ml-3 text-slate-700 font-medium text-sm">{{ $option }}</span>
                                            </label>
                                            @endforeach
                                        @endif
                                    </div>
                                    @break

                                @case('upload_file')
                                @case('file')
                                    <input type="file" 
                                           name="attachments[]" 
                                           class="w-full px-4 py-3 border-2 border-dashed border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition hover:border-orange-300 bg-slate-50"
                                           accept=".pdf,.jpg,.jpeg,.png"
                                           {{ $isRequired }}>
                                    <p class="text-xs text-slate-500 mt-2 flex items-center gap-1">
                                        <i class="fas fa-info-circle text-blue-500"></i>
                                        Format: PDF, JPG, PNG (Max: 2MB)
                                    </p>
                                    @break

                                @default
                                    <input type="text" 
                                           name="{{ $fieldName }}" 
                                           class="w-full px-4 py-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-orange-500 transition bg-white hover:border-slate-400"
                                           {{ $isRequired }}>
                            @endswitch

                            @if(isset($field['helper']) && $field['helper'])
                            <p class="text-sm text-slate-500 mt-2 flex items-start gap-2 bg-amber-50 border border-amber-200 rounded px-3 py-2">
                                <i class="fas fa-lightbulb text-amber-500 mt-0.5"></i>
                                <span>{{ $field['helper'] }}</span>
                            </p>
                            @endif

                            @error('form_data.' . ($field['name'] ?? 'field_' . $index))
                                <p class="text-sm text-red-600 mt-2 flex items-center gap-1">
                                    <i class="fas fa-exclamation-circle"></i>
                                    {{ $message }}
                                </p>
                            @enderror
                        </div>
                        @endforeach
                    @else
                        <div class="bg-yellow-50 border border-yellow-200 border-dashed rounded-lg p-8 text-center">
                            <i class="fas fa-exclamation-triangle text-yellow-500 text-3xl mb-3"></i>
                            <p class="text-yellow-700 font-medium">
                                Template ini belum memiliki field form.
                            </p>
                        </div>
                    @endif
                </div>
                
                {{-- Actions --}}
                <div class="mt-8 pt-6 border-t border-slate-200 flex flex-col sm:flex-row justify-end gap-3">
                    <a href="{{ route('letters.index') }}" 
                       class="px-6 py-3 border-2 border-slate-300 text-slate-700 rounded-lg hover:bg-slate-50 font-bold text-center transition hover:border-slate-400 text-sm uppercase tracking-wide">
                        <i class="fas fa-times mr-2"></i>
                        Batal
                    </a>
                    <button type="submit" 
                            class="px-6 py-3 bg-gradient-to-r from-orange-500 to-orange-600 text-white rounded-lg hover:from-orange-600 hover:to-orange-700 font-bold shadow-md hover:shadow-lg transition text-sm uppercase tracking-wide">
                        <i class="fas fa-paper-plane mr-2"></i>
                        Kirim Pengajuan
                    </button>
                </div>
            </form>
        </div>
        
    </div>
</div>
@endsection