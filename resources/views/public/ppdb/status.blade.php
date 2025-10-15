@extends('layouts.public-tailwind')

@section('title', 'Status Pendaftaran PPDB - SMK Bina Mandiri Bekasi')

@section('content')
<!-- Status Hero Section -->
<section class="relative min-h-screen bg-gradient-to-br from-blue-900 via-blue-800 to-indigo-900 overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-10 w-72 h-72 bg-blue-400/10 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-purple-400/10 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-gradient-to-r from-blue-400/5 to-purple-400/5 rounded-full blur-3xl"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 container mx-auto px-4 pt-32 pb-20">
        <div class="max-w-3xl mx-auto">
            <!-- Back Link -->
            <div class="mb-8">
                <a href="{{ route('ppdb.check-status') }}" class="inline-flex items-center gap-2 text-blue-300 hover:text-blue-200 font-semibold transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Cek Pendaftaran Lain
                </a>
            </div>

            <!-- Header -->
            <div class="text-center mb-12">
                <div class="inline-flex items-center gap-3 bg-white/10 backdrop-blur-sm rounded-full px-6 py-3 mb-6">
                    <svg class="w-6 h-6 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    <span class="text-blue-100 font-semibold">Status Pendaftaran PPDB</span>
                </div>
                
                <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
                    Status
                    <span class="block text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-purple-300">
                        Pendaftaran Anda
                    </span>
                </h1>
            </div>

            <!-- Registration Number Card -->
            <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-8 mb-8 border border-white/20">
                <div class="flex flex-col md:flex-row justify-between items-center gap-6">
                    <div class="text-center md:text-left">
                        <p class="text-sm text-blue-200 mb-2 font-semibold">Nomor Registrasi</p>
                        <h2 class="text-3xl md:text-4xl font-mono font-bold text-white tracking-wider">
                            {{ $registration->registration_number }}
                        </h2>
                    </div>
                    <div>
                        @if($registration->status === 'pending')
                            <span class="inline-flex items-center gap-2 px-6 py-3 bg-yellow-500/20 border border-yellow-400/30 rounded-2xl text-yellow-300 font-bold text-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Menunggu
                            </span>
                        @elseif($registration->status === 'verified')
                            <span class="inline-flex items-center gap-2 px-6 py-3 bg-green-500/20 border border-green-400/30 rounded-2xl text-green-300 font-bold text-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Terverifikasi
                            </span>
                        @elseif($registration->status === 'rejected')
                            <span class="inline-flex items-center gap-2 px-6 py-3 bg-red-500/20 border border-red-400/30 rounded-2xl text-red-300 font-bold text-lg">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Ditolak
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Status Alert -->
            @if($registration->status === 'pending')
                <div class="bg-gradient-to-r from-yellow-500/20 to-amber-500/20 backdrop-blur-sm border border-yellow-400/30 rounded-2xl p-6 mb-8">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-yellow-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-2">Aplikasi Anda Sedang Ditinjau</h3>
                            <p class="text-yellow-100 leading-relaxed">
                                Harap tunggu sementara tim kami memverifikasi dokumen Anda. Proses ini biasanya membutuhkan 3-5 hari kerja. Anda akan menerima notifikasi melalui email setelah proses verifikasi selesai.
                            </p>
                        </div>
                    </div>
                </div>
            @elseif($registration->status === 'verified')
                <div class="bg-gradient-to-r from-green-500/20 to-emerald-500/20 backdrop-blur-sm border border-green-400/30 rounded-2xl p-6 mb-8">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-2">Selamat! Aplikasi Anda Telah Diverifikasi</h3>
                            <p class="text-green-100 leading-relaxed">
                                Anda akan menerima instruksi lebih lanjut melalui email mengenai langkah selanjutnya dalam proses penerimaan siswa baru.
                            </p>
                            @if($registration->verified_at)
                                <p class="text-green-200 text-sm mt-2">
                                    Diverifikasi pada: {{ \Carbon\Carbon::parse($registration->verified_at)->format('d F Y, H:i') }} WIB
                                </p>
                            @endif
                        </div>
                    </div>
                </div>
            @elseif($registration->status === 'rejected')
                <div class="bg-gradient-to-r from-red-500/20 to-pink-500/20 backdrop-blur-sm border border-red-400/30 rounded-2xl p-6 mb-8">
                    <div class="flex items-start gap-4">
                        <div class="flex-shrink-0">
                            <svg class="w-8 h-8 text-red-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-lg font-semibold text-white mb-2">Aplikasi Anda Tidak Disetujui</h3>
                            @if($registration->notes)
                                <p class="text-red-100 leading-relaxed mb-3">
                                    <strong>Alasan:</strong> {{ $registration->notes }}
                                </p>
                            @endif
                            <p class="text-red-100 leading-relaxed">
                                Silakan hubungi administrasi sekolah untuk informasi lebih lanjut atau jika Anda ingin mengajukan banding.
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Student Information Card -->
            <div class="bg-white/10 backdrop-blur-sm rounded-3xl p-8 mb-8 border border-white/20">
                <h3 class="text-2xl font-bold text-white mb-6 flex items-center gap-3">
                    <svg class="w-7 h-7 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    Informasi Siswa
                </h3>
                
                <div class="space-y-6">
                    <div>
                        <p class="text-sm text-blue-200 mb-2 font-semibold">Nama Lengkap</p>
                        <p class="text-lg text-white">{{ $registration->student_name }}</p>
                    </div>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <p class="text-sm text-blue-200 mb-2 font-semibold">Email</p>
                            <p class="text-white">{{ $registration->email }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-blue-200 mb-2 font-semibold">Telepon</p>
                            <p class="text-white">{{ $registration->phone }}</p>
                        </div>
                    </div>
                    
                    <div>
                        <p class="text-sm text-blue-200 mb-2 font-semibold">Tanggal Lahir</p>
                        <p class="text-white">{{ \Carbon\Carbon::parse($registration->birth_date)->format('d F Y') }}</p>
                    </div>
                    
                    <div>
                        <p class="text-sm text-blue-200 mb-2 font-semibold">Alamat</p>
                        <p class="text-white leading-relaxed">{{ $registration->address }}</p>
                    </div>
                    
                    <div class="pt-6 border-t border-white/20">
                        <h4 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Informasi Orang Tua/Wali
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <p class="text-sm text-blue-200 mb-2 font-semibold">Nama Orang Tua/Wali</p>
                                <p class="text-white">{{ $registration->parent_name }}</p>
                            </div>
                            <div>
                                <p class="text-sm text-blue-200 mb-2 font-semibold">Telepon Orang Tua</p>
                                <p class="text-white">{{ $registration->parent_phone }}</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="pt-6 border-t border-white/20">
                        <p class="text-sm text-blue-200 mb-2 font-semibold">Tanggal Pendaftaran</p>
                        <p class="text-white">{{ $registration->created_at->format('d F Y, H:i') }} WIB</p>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('ppdb.check-status') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-blue-600 to-purple-600 text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                    Cek Status Lain
                </a>
                
                <a href="{{ route('home') }}" class="inline-flex items-center justify-center px-8 py-4 bg-white/10 backdrop-blur-sm border-2 border-white/20 text-white font-bold rounded-2xl hover:bg-white/20 transform hover:-translate-y-1 transition-all duration-300 gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    Kembali ke Beranda
                </a>
            </div>
        </div>
    </div>
</section>

<!-- Help Section -->
<section class="py-20 bg-gradient-to-r from-blue-600 to-purple-600">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold text-white mb-6">
            Butuh Bantuan?
        </h2>
        <p class="text-xl text-blue-100 mb-8 max-w-2xl mx-auto">
            Jika Anda memiliki pertanyaan atau memerlukan bantuan lebih lanjut, jangan ragu untuk menghubungi kami
        </p>
        
        <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
            <a href="{{ route('info.contact') }}" 
               class="group px-10 py-4 bg-white text-blue-600 rounded-2xl font-bold text-lg shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 hover:scale-105 transition-all duration-300 flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                Hubungi Kami
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
            
            <a href="{{ route('ppdb.register') }}" 
               class="group px-10 py-4 bg-transparent border-2 border-white text-white rounded-2xl font-bold text-lg hover:bg-white hover:text-blue-600 transform hover:-translate-y-2 hover:scale-105 transition-all duration-300 flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                Daftar PPDB
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>
@endsection
