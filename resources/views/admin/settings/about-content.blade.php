@extends('layouts.admin-modern')

@section('title', 'Konten Tentang Kami')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Konten Tentang Kami</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola konten halaman Tentang Kami (About)</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('info.about') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Lihat Halaman
            </a>
            <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
    </div>

    <!-- Hero Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-indigo-600 border-b border-gray-200">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-white mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
                <h3 class="text-lg font-semibold text-white">Hero Section</h3>
            </div>
        </div>

        <form action="{{ route('admin.settings.update-about-hero') }}" method="POST" class="p-6">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="about_hero_title" class="block text-sm font-medium text-gray-700 mb-2">Judul *</label>
                    <input type="text" name="about_hero_title" id="about_hero_title" 
                        value="{{ old('about_hero_title', $aboutHeroTitle) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                </div>
                <div>
                    <label for="about_hero_subtitle" class="block text-sm font-medium text-gray-700 mb-2">Subtitle *</label>
                    <input type="text" name="about_hero_subtitle" id="about_hero_subtitle" 
                        value="{{ old('about_hero_subtitle', $aboutHeroSubtitle) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>
                </div>
                <div>
                    <label for="about_hero_description" class="block text-sm font-medium text-gray-700 mb-2">Deskripsi *</label>
                    <textarea name="about_hero_description" id="about_hero_description" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                        required>{{ old('about_hero_description', $aboutHeroDescription) }}</textarea>
                </div>
                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        Simpan Hero
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Quick Stats Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-green-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900">Statistik Hero</h3>
            </div>
        </div>

        <form action="{{ route('admin.settings.update-about-stats') }}" method="POST" class="p-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach([1, 2, 3, 4] as $i)
                <div class="bg-gray-50 rounded-lg p-4">
                    <h4 class="font-semibold text-gray-900 mb-4">Statistik {{ $i }}</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nilai</label>
                            <input type="text" name="about_stat{{ $i }}_value" 
                                value="{{ old('about_stat'.$i.'_value', ${'aboutStat'.$i.'Value'}) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Label</label>
                            <input type="text" name="about_stat{{ $i }}_label" 
                                value="{{ old('about_stat'.$i.'_label', ${'aboutStat'.$i.'Label'}) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                required>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-6 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                    Simpan Statistik
                </button>
            </div>
        </form>
    </div>


    <!-- Vision & Mission Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900">Visi & Misi</h3>
            </div>
        </div>

        <form action="{{ route('admin.settings.update-about-vision-mission') }}" method="POST" class="p-6">
            @csrf
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <div>
                    <label for="about_vision" class="block text-sm font-medium text-gray-700 mb-2">Visi *</label>
                    <textarea name="about_vision" id="about_vision" rows="6"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        placeholder="Masukkan visi sekolah..."
                        required>{{ old('about_vision', $aboutVision) }}</textarea>
                </div>
                <div>
                    <label for="about_mission" class="block text-sm font-medium text-gray-700 mb-2">Misi * (pisahkan dengan baris baru)</label>
                    <textarea name="about_mission" id="about_mission" rows="6"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                        placeholder="1. Misi pertama&#10;2. Misi kedua&#10;3. Misi ketiga"
                        required>{{ old('about_mission', $aboutMission) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Gunakan format: 1. Misi pertama (setiap misi di baris baru)</p>
                </div>
            </div>
            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-6 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors">
                    Simpan Visi & Misi
                </button>
            </div>
        </form>
    </div>

    <!-- Values Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900">Nilai-Nilai Kami</h3>
            </div>
        </div>

        <form action="{{ route('admin.settings.update-about-values') }}" method="POST" class="p-6">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @php
                    $colors = ['blue', 'green', 'purple', 'orange'];
                @endphp
                @foreach([1, 2, 3, 4] as $i)
                <div class="bg-{{ $colors[$i-1] }}-50 rounded-lg p-4 border border-{{ $colors[$i-1] }}-200">
                    <h4 class="font-semibold text-gray-900 mb-4">Nilai {{ $i }}</h4>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Judul</label>
                            <input type="text" name="about_value{{ $i }}_title" 
                                value="{{ old('about_value'.$i.'_title', ${'aboutValue'.$i.'Title'}) }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-{{ $colors[$i-1] }}-500 focus:border-transparent"
                                required>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea name="about_value{{ $i }}_desc" rows="2"
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-{{ $colors[$i-1] }}-500 focus:border-transparent"
                                required>{{ old('about_value'.$i.'_desc', ${'aboutValue'.$i.'Desc'}) }}</textarea>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                    Simpan Nilai-Nilai
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
