@extends('layouts.public-tailwind')

@section('title', 'Sambutan Kepala Sekolah - ' . config('app.name'))

@section('content')
<!-- Hero Section -->
<section class="relative bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 text-white py-20">
    <div class="absolute inset-0 bg-black/20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex mb-8 text-sm" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-2">
                <li class="inline-flex items-center">
                    <a href="{{ route('home') }}" class="text-white/80 hover:text-white transition">
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z"></path>
                        </svg>
                        Beranda
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-white/60" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="ml-2 text-white font-medium">Sambutan Kepala Sekolah</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Sambutan Kepala Sekolah</h1>
            <p class="text-xl text-white/90 max-w-3xl mx-auto">
                Pesan dan harapan dari pimpinan sekolah
            </p>
        </div>
    </div>
</section>

<!-- Principal Profile Section -->
<section class="py-16 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Sidebar with Photo -->
            <div class="lg:col-span-1">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-6 sticky top-24">
                    @if($principalPhoto)
                        <div class="mb-6">
                            <img src="{{ asset('storage/' . $principalPhoto) }}" 
                                 alt="{{ $principalName }}" 
                                 class="w-48 h-48 rounded-full mx-auto object-cover border-4 border-white shadow-lg">
                        </div>
                    @else
                        <div class="mb-6">
                            <div class="w-48 h-48 rounded-full mx-auto bg-blue-200 flex items-center justify-center border-4 border-white shadow-lg">
                                <svg class="w-24 h-24 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                        </div>
                    @endif
                    
                    <div class="text-center mb-6">
                        <h3 class="text-xl font-bold text-gray-900 mb-1">{{ $principalName }}</h3>
                        <p class="text-blue-600 font-medium">Kepala Sekolah</p>
                    </div>
                    
                    <div class="border-t border-blue-200 pt-6">
                        <h4 class="text-sm font-semibold text-gray-700 mb-3">Informasi Lainnya</h4>
                        <div class="space-y-2">
                            <a href="{{ route('info.about') }}" class="flex items-center p-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-white rounded-lg transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                                </svg>
                                Profil Sekolah
                            </a>
                            <a href="{{ route('info.overview') }}" class="flex items-center p-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-white rounded-lg transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Selayang Pandang
                            </a>
                            <a href="{{ route('info.contact') }}" class="flex items-center p-2 text-sm text-gray-600 hover:text-blue-600 hover:bg-white rounded-lg transition">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                                </svg>
                                Hubungi Kami
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="lg:col-span-2">
                <!-- Quote Section -->
                <div class="bg-gradient-to-br from-blue-50 to-indigo-50 rounded-2xl p-8 mb-8 border-l-4 border-blue-500">
                    <svg class="w-10 h-10 text-indigo-400 mb-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                    </svg>
                    <div class="prose prose-lg max-w-none">
                        @if($principalMessage)
                            {!! nl2br(e($principalMessage)) !!}
                        @else
                            <p class="text-gray-600 italic">Sambutan kepala sekolah belum tersedia. Silakan hubungi administrator untuk menambahkan konten.</p>
                        @endif
                    </div>
                </div>

                <!-- Vision & Mission Cards -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white rounded-xl p-6 border-2 border-blue-100 hover:border-indigo-300 transition">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Visi Sekolah</h3>
                        <p class="text-gray-600 text-sm">Menjadi lembaga pendidikan yang unggul, berkarakter, dan berdaya saing global</p>
                    </div>
                    
                    <div class="bg-white rounded-xl p-6 border-2 border-indigo-100 hover:border-indigo-300 transition">
                        <div class="w-12 h-12 bg-indigo-100 rounded-lg flex items-center justify-center mb-4">
                            <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"></path>
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-gray-900 mb-2">Misi Sekolah</h3>
                        <p class="text-gray-600 text-sm">Menyelenggarakan pendidikan berkualitas dengan mengembangkan potensi siswa secara optimal</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="py-16 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-3xl font-bold text-white mb-4">Bergabunglah Bersama Kami</h2>
        <p class="text-xl text-white/90 mb-8 max-w-2xl mx-auto">
            Mari bersama-sama mewujudkan pendidikan berkualitas untuk masa depan yang lebih baik
        </p>
        <div class="flex justify-center">
            <a href="{{ route('info.contact') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-blue-50 transition shadow-lg hover:shadow-xl">
                Hubungi Kami
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                </svg>
            </a>
        </div>
    </div>
</section>
@endsection
