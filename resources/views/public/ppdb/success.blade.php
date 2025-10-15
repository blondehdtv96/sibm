@extends('layouts.public-tailwind')

@section('title', 'SMK Bina Mandiri Bekasi')

@section('content')
<!-- Success Hero Section -->
<section class="relative min-h-screen bg-gradient-to-br from-gray-900 via-gray-800 to-slate-900 overflow-hidden">
    <!-- Background Elements -->
    <div class="absolute inset-0">
        <div class="absolute top-20 left-10 w-72 h-72 bg-green-400/20 rounded-full blur-3xl animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-96 h-96 bg-emerald-400/20 rounded-full blur-3xl animate-pulse delay-1000"></div>
        <div class="absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2 w-[800px] h-[800px] bg-gradient-to-r from-green-400/10 to-emerald-400/10 rounded-full blur-3xl"></div>
    </div>

    <!-- Content -->
    <div class="relative z-10 container mx-auto px-4 pt-32 pb-20">
        <div class="max-w-2xl mx-auto text-center">
            <!-- Success Icon -->
            <div class="mb-8 flex justify-center">
                <div class="w-32 h-32 bg-green-500/30 backdrop-blur-lg rounded-full flex items-center justify-center border-2 border-green-400/50 shadow-2xl">
                    <svg class="w-16 h-16 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                    </svg>
                </div>
            </div>
            
            <h1 class="text-5xl md:text-6xl font-bold text-white mb-6 leading-tight">
                Pendaftaran
                <span class="block text-transparent bg-clip-text bg-gradient-to-r from-green-400 to-emerald-400">
                    Berhasil!
                </span>
            </h1>
            
            <p class="text-xl text-gray-200 mb-8 max-w-xl mx-auto leading-relaxed">
                Selamat! Pendaftaran PPDB Anda telah berhasil dikirim dan akan segera diproses oleh tim kami.
            </p>

            <!-- Registration Number Card -->
            <div class="bg-white/15 backdrop-blur-sm rounded-3xl p-8 mb-8 border border-white/30">
                <div class="text-center mb-6">
                    <h2 class="text-2xl font-bold text-white mb-2">Nomor Registrasi Anda</h2>
                    <p class="text-gray-200">Simpan nomor ini untuk referensi di masa mendatang</p>
                </div>
                
                <div class="bg-white rounded-2xl p-6 border border-gray-200">
                    <div class="text-center">
                        <div class="text-4xl font-mono font-bold text-green-600 tracking-wider">
                            {{ $registration->registration_number }}
                        </div>
                    </div>
                </div>
            </div>

            <!-- Important Information -->
            <div class="bg-blue-600/30 backdrop-blur-sm border border-blue-400/50 rounded-2xl p-6 mb-8 text-left">
                <div class="flex items-start gap-3 mb-4">
                    <svg class="w-6 h-6 text-blue-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <div>
                        <h3 class="text-lg font-semibold text-white mb-3">Informasi Penting</h3>
                        <ul class="space-y-3 text-gray-200">
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Simpan nomor registrasi Anda untuk referensi di masa mendatang</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Anda akan menerima email konfirmasi segera</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Cek status pendaftaran menggunakan tautan di bawah</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="w-5 h-5 text-green-400 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                                </svg>
                                <span>Proses verifikasi membutuhkan waktu 3-5 hari kerja</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Registration Details -->
            <div class="bg-white/5 backdrop-blur-sm rounded-2xl p-6 mb-8 border border-white/10 text-left">
                <h3 class="text-xl font-semibold text-white mb-4 flex items-center gap-3">
                    <svg class="w-6 h-6 text-green-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Detail Pendaftaran
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center py-2 border-b border-white/10">
                        <span class="text-green-200 font-medium">Nama:</span>
                        <span class="text-white">{{ $registration->student_name }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-white/10">
                        <span class="text-green-200 font-medium">Email:</span>
                        <span class="text-white">{{ $registration->email }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2 border-b border-white/10">
                        <span class="text-green-200 font-medium">Status:</span>
                        <span class="px-3 py-1 rounded-full text-sm font-semibold {{ $registration->status == 'pending' ? 'bg-yellow-500/20 text-yellow-300' : ($registration->status == 'verified' ? 'bg-green-500/20 text-green-300' : 'bg-red-500/20 text-red-300') }}">
                            {{ $registration->status == 'pending' ? 'Menunggu' : ($registration->status == 'verified' ? 'Terverifikasi' : 'Ditolak') }}
                        </span>
                    </div>
                    <div class="flex justify-between items-center py-2">
                        <span class="text-green-200 font-medium">Dikirim:</span>
                        <span class="text-white">{{ $registration->created_at->format('d M Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('ppdb.check-status') }}" class="inline-flex items-center justify-center px-8 py-4 bg-gradient-to-r from-green-600 to-emerald-600 text-white font-bold rounded-2xl shadow-xl hover:shadow-2xl transform hover:-translate-y-1 transition-all duration-300 gap-3">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                    </svg>
                    Cek Status Pendaftaran
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

<!-- Next Steps Section -->
<section class="py-20 bg-gradient-to-r from-green-600 to-emerald-600">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-4xl font-bold text-white mb-6">
            Langkah Selanjutnya
        </h2>
        <p class="text-xl text-green-100 mb-12 max-w-2xl mx-auto">
            Berikut adalah hal-hal yang perlu Anda ketahui setelah mendaftar
        </p>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 max-w-4xl mx-auto">
            <!-- Step 1 -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-white">1</span>
                </div>
                <h3 class="text-xl font-semibold text-white mb-3">Verifikasi Dokumen</h3>
                <p class="text-green-100">Tim kami akan memverifikasi dokumen yang Anda upload dalam 3-5 hari kerja</p>
            </div>
            
            <!-- Step 2 -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-white">2</span>
                </div>
                <h3 class="text-xl font-semibold text-white mb-3">Notifikasi Email</h3>
                <p class="text-green-100">Anda akan menerima email konfirmasi dan update status pendaftaran</p>
            </div>
            
            <!-- Step 3 -->
            <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 border border-white/20">
                <div class="w-16 h-16 bg-white/20 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <span class="text-2xl font-bold text-white">3</span>
                </div>
                <h3 class="text-xl font-semibold text-white mb-3">Pengumuman Hasil</h3>
                <p class="text-green-100">Hasil seleksi akan diumumkan sesuai jadwal yang telah ditentukan</p>
            </div>
        </div>
        
        <div class="mt-12">
            <p class="text-green-100 mb-4">Ada pertanyaan? Jangan ragu untuk menghubungi kami</p>
            <a href="{{ route('info.contact') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white text-green-600 rounded-xl font-semibold hover:bg-gray-100 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                Hubungi Kami
            </a>
        </div>
    </div>
</section>
@endsection
