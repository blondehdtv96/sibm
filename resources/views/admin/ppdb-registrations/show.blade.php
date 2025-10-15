@extends('layouts.admin-modern')

@section('title', 'Detail Pendaftaran')

@section('content')
<div class="space-y-6">
    <!-- Back Button -->
    <div>
        <a href="{{ route('admin.ppdb-registrations.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Pendaftaran
        </a>
    </div>

    <!-- Alert Messages -->
    @if(session('success'))
        <div class="bg-green-50 border border-green-200 text-green-800 px-4 py-3 rounded-lg">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 px-4 py-3 rounded-lg">
            <ul class="list-disc list-inside space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Header Card -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 mb-2">Detail Pendaftaran</h1>
                <p class="text-lg font-mono font-semibold text-blue-600">
                    {{ $ppdbRegistration->registration_number }}
                </p>
            </div>
            <div>
                @if($ppdbRegistration->status === 'pending')
                    <span class="inline-flex items-center px-4 py-2 bg-yellow-100 text-yellow-800 rounded-lg font-semibold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Menunggu
                    </span>
                @elseif($ppdbRegistration->status === 'verified')
                    <span class="inline-flex items-center px-4 py-2 bg-green-100 text-green-800 rounded-lg font-semibold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Terverifikasi
                    </span>
                @elseif($ppdbRegistration->status === 'rejected')
                    <span class="inline-flex items-center px-4 py-2 bg-red-100 text-red-800 rounded-lg font-semibold">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        Ditolak
                    </span>
                @endif
            </div>
        </div>
    </div>

    <!-- Action Buttons -->
    @if($ppdbRegistration->status === 'pending')
        <div class="bg-gray-50 rounded-xl p-6 border border-gray-200">
            <h3 class="text-sm font-semibold text-gray-700 mb-4">Tindakan</h3>
            <div class="flex flex-col sm:flex-row gap-3">
                <form action="{{ route('admin.ppdb-registrations.verify', $ppdbRegistration) }}" method="POST" class="flex-1">
                    @csrf
                    @method('PATCH')
                    <button type="submit" class="w-full inline-flex items-center justify-center px-6 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors font-semibold" onclick="return confirm('Apakah Anda yakin ingin memverifikasi pendaftaran ini?')">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Verifikasi Pendaftaran
                    </button>
                </form>
                
                <button type="button" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold" onclick="document.getElementById('reject-modal').classList.remove('hidden')">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Tolak Pendaftaran
                </button>
            </div>
        </div>
    @endif

    <!-- Student Information -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
            </svg>
            Informasi Siswa
        </h3>
        
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <span class="text-sm font-medium text-gray-500">Nama Lengkap:</span>
                <span class="text-sm text-gray-900 md:col-span-2">{{ $ppdbRegistration->student_name }}</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <span class="text-sm font-medium text-gray-500">Email:</span>
                <span class="text-sm text-gray-900 md:col-span-2">{{ $ppdbRegistration->email }}</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <span class="text-sm font-medium text-gray-500">Telepon:</span>
                <span class="text-sm text-gray-900 md:col-span-2">{{ $ppdbRegistration->phone }}</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <span class="text-sm font-medium text-gray-500">Tanggal Lahir:</span>
                <span class="text-sm text-gray-900 md:col-span-2">{{ \Carbon\Carbon::parse($ppdbRegistration->birth_date)->format('d F Y') }}</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <span class="text-sm font-medium text-gray-500">Alamat:</span>
                <span class="text-sm text-gray-900 md:col-span-2">{{ $ppdbRegistration->address }}</span>
            </div>
        </div>
    </div>

    <!-- Parent Information -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
            </svg>
            Informasi Orang Tua/Wali
        </h3>
        
        <div class="space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <span class="text-sm font-medium text-gray-500">Nama:</span>
                <span class="text-sm text-gray-900 md:col-span-2">{{ $ppdbRegistration->parent_name }}</span>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                <span class="text-sm font-medium text-gray-500">Telepon:</span>
                <span class="text-sm text-gray-900 md:col-span-2">{{ $ppdbRegistration->parent_phone }}</span>
            </div>
        </div>
    </div>

    <!-- Documents -->
    @php
        $documents = is_string($ppdbRegistration->documents) 
            ? json_decode($ppdbRegistration->documents, true) 
            : $ppdbRegistration->documents;
    @endphp
    
    @if(!empty($documents))
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                Dokumen yang Diunggah
            </h3>
            
            <div class="space-y-3">
                @foreach($documents as $key => $document)
                    <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg border border-gray-200 hover:bg-gray-100 transition-colors">
                        <div class="flex items-center space-x-3">
                            <div class="flex-shrink-0">
                                <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <div>
                                <p class="text-sm font-medium text-gray-900">{{ $document['name'] }}</p>
                                <p class="text-xs text-gray-500">Dokumen {{ $key + 1 }}</p>
                            </div>
                        </div>
                        <a href="{{ route('admin.ppdb-registrations.download-document', [$ppdbRegistration, $key]) }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm rounded-lg hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                            </svg>
                            Unduh
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    <!-- Admin Notes -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
            </svg>
            Catatan Admin
        </h3>
        
        <form action="{{ route('admin.ppdb-registrations.update-notes', $ppdbRegistration) }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')
            
            <div>
                <textarea 
                    name="notes" 
                    rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent resize-none"
                    placeholder="Tambahkan catatan tentang pendaftaran ini..."
                >{{ $ppdbRegistration->notes }}</textarea>
            </div>
            
            <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors font-semibold">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                </svg>
                Simpan Catatan
            </button>
        </form>
    </div>

    <!-- Verification Info -->
    @if($ppdbRegistration->verified_at)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
                <svg class="w-5 h-5 mr-2 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                Informasi Verifikasi
            </h3>
            
            <div class="space-y-4">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                    <span class="text-sm font-medium text-gray-500">Diverifikasi Pada:</span>
                    <span class="text-sm text-gray-900 md:col-span-2">{{ \Carbon\Carbon::parse($ppdbRegistration->verified_at)->format('d F Y, H:i') }} WIB</span>
                </div>
                
                @if($ppdbRegistration->verifiedBy)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-2">
                        <span class="text-sm font-medium text-gray-500">Diverifikasi Oleh:</span>
                        <span class="text-sm text-gray-900 md:col-span-2">{{ $ppdbRegistration->verifiedBy->name }}</span>
                    </div>
                @endif
            </div>
        </div>
    @endif

    <!-- Registration Timeline -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4 flex items-center">
            <svg class="w-5 h-5 mr-2 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Timeline Pendaftaran
        </h3>
        
        <div class="space-y-4">
            <div class="flex items-start">
                <div class="flex-shrink-0 w-2 h-2 mt-2 bg-blue-600 rounded-full"></div>
                <div class="ml-4">
                    <p class="text-sm font-medium text-gray-900">Pendaftaran Dikirim</p>
                    <p class="text-xs text-gray-500">{{ $ppdbRegistration->created_at->format('d F Y, H:i') }} WIB</p>
                </div>
            </div>
            
            @if($ppdbRegistration->verified_at)
                <div class="flex items-start">
                    <div class="flex-shrink-0 w-2 h-2 mt-2 bg-green-600 rounded-full"></div>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">Pendaftaran Diverifikasi</p>
                        <p class="text-xs text-gray-500">{{ \Carbon\Carbon::parse($ppdbRegistration->verified_at)->format('d F Y, H:i') }} WIB</p>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Reject Modal -->
<div id="reject-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 p-4">
    <div class="bg-white rounded-xl shadow-xl max-w-md w-full p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-xl font-bold text-gray-900">Tolak Pendaftaran</h2>
            <button type="button" onclick="document.getElementById('reject-modal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
        
        <form action="{{ route('admin.ppdb-registrations.reject', $ppdbRegistration) }}" method="POST" class="space-y-4">
            @csrf
            @method('PATCH')
            
            <div>
                <label for="reject-notes" class="block text-sm font-medium text-gray-700 mb-2">
                    Alasan Penolakan <span class="text-red-600">*</span>
                </label>
                <textarea 
                    id="reject-notes"
                    name="notes" 
                    rows="4"
                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-transparent resize-none"
                    placeholder="Berikan alasan penolakan pendaftaran..."
                    required
                ></textarea>
            </div>
            
            <div class="flex gap-3">
                <button type="submit" class="flex-1 inline-flex items-center justify-center px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors font-semibold">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                    </svg>
                    Tolak Pendaftaran
                </button>
                <button type="button" onclick="document.getElementById('reject-modal').classList.add('hidden')" class="flex-1 px-6 py-3 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors font-semibold">
                    Batal
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
