@extends('admin.layouts.app')

@section('title', 'Pengaturan Website')

@section('content')
<div class="container-fluid px-4 py-4">
    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Pengaturan Website</h1>
            <p class="text-muted mb-0">Kelola informasi kontak, sosial media, dan pengaturan umum</p>
        </div>
    </div>

    {{-- SUCCESS MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <form action="{{ route('admin.settings.update') }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row g-4">
            {{-- GENERAL SETTINGS --}}
            <div class="col-xl-6 col-lg-12">
                <div class="card shadow-sm h-100">
                    <div class="card-header py-3 bg-primary text-white">
                        <h6 class="m-0 fw-bold">
                            <i class="fas fa-cog me-2"></i>Informasi Umum
                        </h6>
                    </div>
                    <div class="card-body">
                        @foreach($groups['general'] as $setting)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">{{ $setting->label }}</label>
                            @if($setting->type === 'textarea')
                                <textarea name="settings[{{ $setting->key }}]" 
                                          class="form-control" 
                                          rows="3"
                                          placeholder="Masukkan {{ strtolower($setting->label) }}">{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                            @else
                                <input type="text" 
                                       name="settings[{{ $setting->key }}]" 
                                       class="form-control" 
                                       value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                       placeholder="Masukkan {{ strtolower($setting->label) }}">
                            @endif
                            @if($setting->description)
                                <small class="text-muted d-block mt-1">{{ $setting->description }}</small>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- CONTACT INFO --}}
            <div class="col-xl-6 col-lg-12">
                <div class="card shadow-sm h-100">
                    <div class="card-header py-3 bg-success text-white">
                        <h6 class="m-0 fw-bold">
                            <i class="fas fa-phone me-2"></i>Informasi Kontak
                        </h6>
                    </div>
                    <div class="card-body">
                        @foreach($groups['contact'] as $setting)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">{{ $setting->label }}</label>
                            @if($setting->type === 'textarea')
                                <textarea name="settings[{{ $setting->key }}]" 
                                          class="form-control" 
                                          rows="3"
                                          placeholder="Masukkan {{ strtolower($setting->label) }}">{{ old('settings.' . $setting->key, $setting->value) }}</textarea>
                            @elseif($setting->type === 'url')
                                <input type="url" 
                                       name="settings[{{ $setting->key }}]" 
                                       class="form-control" 
                                       value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                       placeholder="https://example.com">
                            @elseif($setting->type === 'phone')
                                <input type="text" 
                                       name="settings[{{ $setting->key }}]" 
                                       class="form-control" 
                                       value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                       placeholder="+62xxx">
                            @else
                                <input type="text" 
                                       name="settings[{{ $setting->key }}]" 
                                       class="form-control" 
                                       value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                       placeholder="Masukkan {{ strtolower($setting->label) }}">
                            @endif
                            @if($setting->description)
                                <small class="text-muted d-block mt-1">{{ $setting->description }}</small>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- SOCIAL MEDIA --}}
            <div class="col-xl-6 col-lg-12">
                <div class="card shadow-sm h-100">
                    <div class="card-header py-3 bg-info text-white">
                        <h6 class="m-0 fw-bold">
                            <i class="fas fa-share-alt me-2"></i>Media Sosial
                        </h6>
                    </div>
                    <div class="card-body">
                        @foreach($groups['social_media'] as $setting)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                @php
                                    $icons = [
                                        'social_instagram' => 'fab fa-instagram text-danger',
                                        'social_facebook' => 'fab fa-facebook text-primary',
                                        'social_youtube' => 'fab fa-youtube text-danger',
                                        'social_twitter' => 'fab fa-twitter text-info',
                                        'social_linkedin' => 'fab fa-linkedin text-primary',
                                        'social_tiktok' => 'fab fa-tiktok text-dark',
                                    ];
                                @endphp
                                <i class="{{ $icons[$setting->key] ?? 'fas fa-link' }} me-2"></i>
                                {{ $setting->label }}
                            </label>
                            <input type="url" 
                                   name="settings[{{ $setting->key }}]" 
                                   class="form-control" 
                                   value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                   placeholder="https://... (opsional)">
                            @if($setting->description)
                                <small class="text-muted d-block mt-1">{{ $setting->description }}</small>
                            @endif
                        </div>
                        @endforeach
                        
                        {{-- Info Box --}}
                        <div class="alert alert-light border mb-0">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                <strong>Info:</strong> Kolom sosial media bersifat opsional. Kosongkan jika tidak digunakan.
                            </small>
                        </div>
                    </div>
                </div>
            </div>

            {{-- WORKING HOURS --}}
            <div class="col-xl-6 col-lg-12">
                <div class="card shadow-sm h-100">
                    <div class="card-header py-3 bg-warning text-dark">
                        <h6 class="m-0 fw-bold">
                            <i class="fas fa-clock me-2"></i>Jam Operasional
                        </h6>
                    </div>
                    <div class="card-body">
                        @foreach($groups['working_hours'] as $setting)
                        <div class="mb-3">
                            <label class="form-label fw-semibold">{{ $setting->label }}</label>
                            <input type="text" 
                                   name="settings[{{ $setting->key }}]" 
                                   class="form-control" 
                                   value="{{ old('settings.' . $setting->key, $setting->value) }}"
                                   placeholder="Contoh: 07.00 - 16.00 atau TUTUP">
                            @if($setting->description)
                                <small class="text-muted d-block mt-1">{{ $setting->description }}</small>
                            @endif
                        </div>
                        @endforeach

                        {{-- Info Box --}}
                        <div class="alert alert-warning border-0 mb-0">
                            <small>
                                <i class="fas fa-lightbulb me-1"></i>
                                <strong>Tips:</strong> Gunakan format "07.00 - 16.00" atau tulis "TUTUP" untuk hari libur.
                            </small>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- SUBMIT BUTTON --}}
        <div class="mt-4 d-flex gap-2">
            <button type="submit" class="btn btn-primary px-4">
                <i class="fas fa-save me-2"></i>Simpan Semua Pengaturan
            </button>
            <button type="reset" class="btn btn-outline-secondary px-4">
                <i class="fas fa-undo me-2"></i>Reset
            </button>
        </div>
    </form>
</div>

@push('styles')
<style>
    .card {
        transition: transform 0.2s;
    }
    .card:hover {
        transform: translateY(-2px);
    }
    .form-label {
        color: #495057;
        margin-bottom: 0.5rem;
    }
    .form-control:focus {
        border-color: #80bdff;
        box-shadow: 0 0 0 0.2rem rgba(0,123,255,.25);
    }
</style>
@endpush
@endsection