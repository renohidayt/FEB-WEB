@extends('admin.layouts.app')

@section('title', 'Edit Akreditasi')

@section('content')
<div class="mb-6">
    <a href="{{ route('admin.accreditations.index') }}" class="text-blue-600 hover:underline mb-2 inline-block">
        ← Kembali
    </a>
    <h1 class="text-2xl font-bold">Edit Akreditasi</h1>
</div>

<div class="bg-white rounded-lg shadow p-6 max-w-3xl">
    <form action="{{ route('admin.accreditations.update', $accreditation) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <!-- Program Studi -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Program Studi <span class="text-red-500">*</span>
            </label>
            <input type="text" 
                   name="study_program" 
                   value="{{ old('study_program', $accreditation->study_program) }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('study_program') border-red-500 @enderror"
                   required>
            @error('study_program')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Grade -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Peringkat Akreditasi <span class="text-red-500">*</span>
            </label>
            <select name="grade" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('grade') border-red-500 @enderror"
                    required>
                <option value="">Pilih Peringkat</option>
                <optgroup label="BAN-PT (Lama)">
                    <option value="A" {{ old('grade', $accreditation->grade) == 'A' ? 'selected' : '' }}>A</option>
                    <option value="B" {{ old('grade', $accreditation->grade) == 'B' ? 'selected' : '' }}>B</option>
                    <option value="C" {{ old('grade', $accreditation->grade) == 'C' ? 'selected' : '' }}>C</option>
                </optgroup>
                <optgroup label="BAN-PT (Baru)">
                    <option value="Unggul" {{ old('grade', $accreditation->grade) == 'Unggul' ? 'selected' : '' }}>Unggul</option>
                    <option value="Baik Sekali" {{ old('grade', $accreditation->grade) == 'Baik Sekali' ? 'selected' : '' }}>Baik Sekali</option>
                    <option value="Baik" {{ old('grade', $accreditation->grade) == 'Baik' ? 'selected' : '' }}>Baik</option>
                </optgroup>
            </select>
            @error('grade')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Lembaga Akreditasi -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Lembaga Akreditasi <span class="text-red-500">*</span>
            </label>
            <select name="accreditation_body" 
                    class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('accreditation_body') border-red-500 @enderror"
                    required>
                <option value="BAN-PT" {{ old('accreditation_body', $accreditation->accreditation_body) == 'BAN-PT' ? 'selected' : '' }}>BAN-PT</option>
                <option value="LAM-PTKes" {{ old('accreditation_body', $accreditation->accreditation_body) == 'LAM-PTKes' ? 'selected' : '' }}>LAM-PTKes</option>
                <option value="LAMEMBA" {{ old('accreditation_body', $accreditation->accreditation_body) == 'LAMEMBA' ? 'selected' : '' }}>LAMEMBA</option>
                <option value="Lainnya" {{ old('accreditation_body', $accreditation->accreditation_body) == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
            </select>
            @error('accreditation_body')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Nomor Sertifikat -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Nomor Sertifikat
            </label>
            <input type="text" 
                   name="certificate_number" 
                   value="{{ old('certificate_number', $accreditation->certificate_number) }}"
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
            @error('certificate_number')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Periode Berlaku -->
        <div class="grid grid-cols-2 gap-4 mb-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Berlaku Dari
                </label>
                <input type="date" 
                       name="valid_from" 
                       value="{{ old('valid_from', $accreditation->valid_from?->format('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Berlaku Sampai <span class="text-red-500">*</span>
                </label>
                <input type="date" 
                       name="valid_until" 
                       value="{{ old('valid_until', $accreditation->valid_until->format('Y-m-d')) }}"
                       class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500 @error('valid_until') border-red-500 @enderror"
                       required>
                @error('valid_until')
                    <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <!-- Sertifikat Saat Ini -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Sertifikat Saat Ini
            </label>
            <div class="bg-gray-50 p-4 rounded-lg flex items-center justify-between">
                <div class="flex items-center">
                    <svg class="w-8 h-8 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"></path>
                    </svg>
                    <span class="text-sm text-gray-700">{{ basename($accreditation->certificate_file) }}</span>
                </div>
                <a href="{{ asset('storage/' . $accreditation->certificate_file) }}" 
                   target="_blank"
                   class="text-blue-600 hover:underline text-sm">
                    Lihat PDF
                </a>
            </div>
        </div>

        <!-- Upload Sertifikat Baru -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Upload Sertifikat Baru (Opsional)
            </label>
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-6 text-center">
                <input type="file" 
                       name="certificate_file" 
                       id="fileInput"
                       accept=".pdf"
                       onchange="displayFileName(this)"
                       class="hidden">
                <label for="fileInput" class="cursor-pointer">
                    <svg class="w-12 h-12 mx-auto text-gray-400 mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <span class="text-blue-600 hover:text-blue-700 font-medium">Pilih file PDF baru</span>
                    <p class="text-xs text-gray-500 mt-2">PDF (Max: 10MB)</p>
                </label>
                <p id="fileName" class="text-sm text-gray-700 mt-2 font-medium hidden"></p>
            </div>
            @error('certificate_file')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Deskripsi -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">
                Deskripsi / Catatan
            </label>
            <textarea name="description" 
                      rows="4"
                      class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500">{{ old('description', $accreditation->description) }}</textarea>
        </div>

        <!-- Status Aktif -->
        <div class="mb-6">
            <label class="flex items-center">
                <input type="checkbox" 
                       name="is_active" 
                       value="1"
                       {{ old('is_active', $accreditation->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <span class="ml-2 text-sm text-gray-700">Aktif (tampilkan di website)</span>
            </label>
        </div>

        <!-- Buttons -->
        <div class="flex items-center gap-3">
            <button type="submit" 
                    class="bg-blue-500 text-white px-6 py-2 rounded-lg hover:bg-blue-600 font-medium">
                Update Akreditasi
            </button>
            <a href="{{ route('admin.accreditations.index') }}" 
               class="bg-gray-200 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-300 font-medium">
                Batal
            </a>
        </div>
    </form>
</div>

<script>
function displayFileName(input) {
    const fileName = document.getElementById('fileName');
    if (input.files && input.files[0]) {
        const file = input.files[0];
        const fileSize = (file.size / 1024 / 1024).toFixed(2);
        fileName.textContent = `${file.name} (${fileSize} MB)`;
        fileName.classList.remove('hidden');
    }
}
</script>
@endsection