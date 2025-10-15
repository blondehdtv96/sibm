@extends('layouts.public-tailwind')

@section('title', 'Cek Status PPDB - SMK Negeri 4 Bogor')

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-400/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-400/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-gradient-to-r from-blue-400/5 to-purple-400/5 rounded-full blur-3xl"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 container mx-auto px-4 pt-32 pb-20">
        <div class="max-w-2xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-full px-6 py-3 mb-6">
                    <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="text-blue-100 font-semibold">Cek Status Pendaftaran</span>
                </div>
                
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
                    Status
                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-purple-300">
                        PPDB Anda
                    </span>
                </h1>
                
                <p class="text-xl text-blue-100 mb-8 max-w-xl mx-auto leading-relaxed">
                    Masukkan nomor registrasi untuk melihat status pendaftaran PPDB Anda
                </p>
            </div>

            <!-- Alert Messages -->
            @if(session('error'))
                <div class="bg-gradient-to-r from-red-500/20 to-pink-500/20 backdrop-blur-sm border border-red-400/30 rounded-2xl p-4 mb-6">
                    <div class="flex items-center gap-3">
                        <svg class="w-6 h-6 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-red-100">{{ session('error') }}</span>
                    </div>
                </div>
            @endif

            @if($errors->any())
                <div class="bg-gradient-to-r from-red-500/20 to-pink-500/20 backdrop-blur-sm border border-red-400/30 rounded-2xl p-4 mb-6">
                    <div class="flex items-start gap-3">
                        <svg class="w-6 h-6 text-red-300 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <div>
                            <p class="text-red-100 font-semibold mb-2">Terdapat kesalahan:</p>
                            <ul class="space-y-1">
                                @foreach($errors->all() as $error)
                                    <li class="text-red-200">• {{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Check Status Form -->
            <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-8 border border-white/20 mb-8">
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 bg-blue-500/20 rounded-2xl mb-4">
                        <svg class="w-8 h-8 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-white mb-2">Cek Status Pendaftaran</h2>
                    <p class="text-blue-100">Masukkan nomor registrasi PPDB Anda untuk melihat status terkini</p>
                </div>

                <form action="{{ route('ppdb.show-status') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="registration_number" class="block text-sm font-semibold text-blue-100 mb-3">
                            Nomor Registrasi <span class="text-red-400">*</span>
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"/>
                                </svg>
                            </div>
                            <input 
                                type="text" 
                                id="registration_number" 
                                name="registration_number" 
                                class="w-full pl-12 pr-4 py-4 bg-white/10 border border-white/20 rounded-xl text-white placeholder-blue-200 focus:outline-none focus:ring-2 focus:ring-blue-400 focus:border-transparent transition-all font-mono text-lg tracking-wider @error('registration_number') border-red-400 @enderror"
                                placeholder="PPDB20240001"
                                value="{{ old('registration_number') }}"
                                required
                            >
                        </div>
                        @error('registration_number')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                        <p class="mt-2 text-sm text-blue-200">
                            Format: PPDB diikuti tahun dan nomor urut (contoh: PPDB20240001)
                        </p>
                    </div>

                    <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-4 px-8 rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 flex items-center justify-center gap-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                        Cek Status Sekarang
                    </button>
                </form>
            </div>

            <!-- Information Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
                <!-- Status Info -->
                <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-blue-500/20 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white">Status Pendaftaran</h3>
                    </div>
                    <ul class="space-y-2 text-sm text-blue-100">
                        <li class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-yellow-400 rounded-full"></div>
                            Menunggu Verifikasi
                        </li>
                        <li class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-blue-400 rounded-full"></div>
                            Sedang Diproses
                        </li>
                        <li class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-green-400 rounded-full"></div>
                            Diterima
                        </li>
                        <li class="flex items-center gap-2">
                            <div class="w-2 h-2 bg-red-400 rounded-full"></div>
                            Ditolak
                        </li>
                    </ul>
                </div>

                <!-- Help Info -->
                <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 border border-white/10">
                    <div class="flex items-center gap-3 mb-4">
                        <div class="w-10 h-10 bg-purple-500/20 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5 text-purple-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <h3 class="text-lg font-semibold text-white">Butuh Bantuan?</h3>
                    </div>
                    <p class="text-sm text-blue-100 mb-3">
                        Jika Anda mengalami kesulitan atau memiliki pertanyaan, silakan hubungi tim kami.
                    </p>
                    <a href="{{ route('info.contact') }}" class="inline-flex items-center gap-2 text-purple-300 hover:text-purple-200 font-semibold text-sm transition-colors">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                        Hubungi Kami
                    </a>
                </div>
            </div>

            <!-- Navigation Links -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center items-center">
                <a href="{{ route('ppdb.register') }}" class="inline-flex items-center gap-2 text-blue-300 hover:text-blue-200 font-semibold transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Kembali ke Pendaftaran
                </a>
                
                <div class="hidden sm:block w-px h-6 bg-white/20"></div>
                
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-blue-300 hover:text-blue-200 font-semibold transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Beranda
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action Section -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold text-white mb-6">
            Belum Mendaftar?
        </h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
            Jangan lewatkan kesempatan bergabung dengan SMK Negeri 4 Bogor. Daftar sekarang dan wujudkan masa depan cemerlang Anda!
        </p>
        
        <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
            <a href="{{ route('ppdb.register') }}" 
               class="group px-10 py-4 bg-white text-blue-600 rounded-2xl font-bold text-lg shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 hover:scale-105 transition-all duration-300 flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Daftar PPDB
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            
            <a href="{{ route('info.about') }}" 
               class="group px-10 py-4 bg-transparent border-2 border-white text-white rounded-2xl font-bold text-lg hover:bg-white hover:text-blue-600 transform hover:-translate-y-2 hover:scale-105 transition-all duration-300 flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Tentang Sekolah
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
@endsection
