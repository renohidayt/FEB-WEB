@extends('admin.layouts.app')

@section('title', 'Detail Struktur Organisasi')
@section('page-title', 'Detail Struktur Organisasi')

@section('content')
<div class="bg-white rounded-lg shadow-lg overflow-hidden">
    
    {{-- Header Section --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-800 p-6">
        <div class="flex items-center">
            @if($organizationalStructure->photo)
                <img src="{{ asset('storage/' . $organizationalStructure->photo) }}" 
                     class="w-28 h-28 rounded-full object-cover border-4 border-white shadow-lg mr-6">
            @else
                <div class="w-28 h-28 bg-white/20 rounded-full flex items-center justify-center border-4 border-white shadow-lg mr-6">
                    <i class="fas fa-user text-white text-4xl"></i>
                </div>
            @endif

            <div class="flex-1">
                <h2 class="text-2xl font-bold text-white mb-1">{{ $organizationalStructure->name }}</h2>
                <p class="text-blue-100 text-lg mb-2">{{ $organizationalStructure->position }}</p>
                
                <div class="flex gap-2 mt-3">
                    @if($organizationalStructure->is_active)
                        <span class="px-3 py-1 bg-green-500 text-white text-sm rounded-full">
                            <i class="fas fa-check-circle mr-1"></i> Aktif
                        </span>
                    @else
                        <span class="px-3 py-1 bg-red-500 text-white text-sm rounded-full">
                            <i class="fas fa-times-circle mr-1"></i> Nonaktif
                        </span>
                    @endif
                    
                    <span class="px-3 py-1 bg-white/20 text-white text-sm rounded-full">
                        {{ ucfirst($organizationalStructure->type) }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Content Section --}}
    <div class="p-6">
        
        {{-- Hierarchical Info --}}
        @if($organizationalStructure->parent)
        <div class="mb-6 p-4 bg-blue-50 rounded-lg border border-blue-200">
            <p class="text-sm text-gray-600 mb-1">Atasan Langsung:</p>
            <a href="{{ route('admin.organizational-structures.show', $organizationalStructure->parent_id) }}" 
               class="text-blue-600 hover:text-blue-800 font-semibold flex items-center">
                <i class="fas fa-arrow-up mr-2"></i>
                {{ $organizationalStructure->parent->name }} 
                <span class="text-gray-600 ml-2">({{ $organizationalStructure->parent->position }})</span>
            </a>
        </div>
        @endif

        {{-- Contact Info Grid --}}
        <div class="grid md:grid-cols-2 gap-6 mb-6">
            <div class="space-y-4">
                <div>
                    <label class="text-sm text-gray-500 uppercase tracking-wide">NIP</label>
                    <p class="text-gray-900 font-mono">{{ $organizationalStructure->nip ?? '-' }}</p>
                </div>
                
                <div>
                    <label class="text-sm text-gray-500 uppercase tracking-wide">Email</label>
                    <p class="text-gray-900">
                        @if($organizationalStructure->email)
                            <a href="mailto:{{ $organizationalStructure->email }}" class="text-blue-600 hover:underline">
                                <i class="fas fa-envelope mr-1"></i>{{ $organizationalStructure->email }}
                            </a>
                        @else
                            -
                        @endif
                    </p>
                </div>
            </div>

            <div class="space-y-4">
                <div>
                    <label class="text-sm text-gray-500 uppercase tracking-wide">No. HP</label>
                    <p class="text-gray-900">
                        @if($organizationalStructure->phone)
                            <a href="tel:{{ $organizationalStructure->phone }}" class="text-blue-600 hover:underline">
                                <i class="fas fa-phone mr-1"></i>{{ $organizationalStructure->phone }}
                            </a>
                        @else
                            -
                        @endif
                    </p>
                </div>
                
                <div>
                    <label class="text-sm text-gray-500 uppercase tracking-wide">Jumlah Bawahan</label>
                    <p class="text-gray-900 font-semibold">{{ $organizationalStructure->children->count() }} orang</p>
                </div>
            </div>
        </div>

        {{-- Description --}}
        @if($organizationalStructure->description)
        <div class="mb-6">
            <label class="text-sm text-gray-500 uppercase tracking-wide mb-2 block">Deskripsi</label>
            <div class="bg-gray-50 p-4 rounded-lg border border-gray-200">
                <p class="text-gray-700 leading-relaxed">{!! nl2br(e($organizationalStructure->description)) !!}</p>
            </div>
        </div>
        @endif

        {{-- Subordinates --}}
        @if($organizationalStructure->children->where('is_active', true)->count() > 0)
        <div class="mb-6">
            <h3 class="text-lg font-semibold mb-3">Bawahan Langsung</h3>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($organizationalStructure->children->where('is_active', true) as $child)
                <a href="{{ route('admin.organizational-structures.show', $child->id) }}" 
                   class="p-4 border border-gray-200 rounded-lg hover:border-blue-500 hover:shadow-md transition">
                    <div class="flex items-center">
                        @if($child->photo)
                            <img src="{{ asset('storage/' . $child->photo) }}" 
                                 class="w-12 h-12 rounded-full object-cover mr-3">
                        @else
                            <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center mr-3">
                                <i class="fas fa-user text-gray-400"></i>
                            </div>
                        @endif
                        <div class="flex-1 min-w-0">
                            <p class="font-semibold text-gray-900 truncate">{{ $child->name }}</p>
                            <p class="text-sm text-gray-600 truncate">{{ $child->position }}</p>
                        </div>
                    </div>
                </a>
                @endforeach
            </div>
        </div>
        @endif

        {{-- Action Buttons --}}
        <div class="flex gap-3 pt-6 border-t">
            <a href="{{ route('admin.organizational-structures.index') }}" 
               class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-lg transition">
                <i class="fas fa-arrow-left mr-2"></i>Kembali
            </a>
            
            <a href="{{ route('admin.organizational-structures.edit', $organizationalStructure->id) }}" 
               class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition">
                <i class="fas fa-edit mr-2"></i>Edit
            </a>
        </div>
    </div>
</div>
@endsection