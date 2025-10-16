@extends('layouts.admin-modern')

@section('title', 'Tambah Balasan Chatbot')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div>
        <a href="{{ route('admin.chatbot-responses.index') }}" class="inline-flex items-center text-sm text-gray-600 hover:text-gray-900 transition-colors mb-4">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar Balasan
        </a>
        <h2 class="text-2xl font-bold text-gray-900">Tambah Balasan Chatbot</h2>
        <p class="text-sm text-gray-500 mt-1">Buat balasan otomatis baru untuk chatbot</p>
    </div>

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('admin.chatbot-responses.store') }}" method="POST" class="space-y-6">
            @csrf

            <!-- Trigger Name -->
            <div>
                <label for="trigger_name" class="block text-sm font-medium text-gray-700 mb-2">
                    Trigger Name <span class="text-red-600">*</span>
                </label>
                <input 
                    type="text" 
                    id="trigger_name" 
                    name="trigger_name" 
                    value="{{ old('trigger_name') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('trigger_name') border-red-500 @enderror"
                    placeholder="contoh: greeting, jurusan, ppdb"
                    required
                >
                @error('trigger_name')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Nama unik untuk identifikasi (gunakan huruf kecil, tanpa spasi)</p>
            </div>

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul <span class="text-red-600">*</span>
                </label>
                <input 
                    type="text" 
                    id="title" 
                    name="title" 
                    value="{{ old('title') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror"
                    placeholder="contoh: Salam & Perkenalan"
                    required
                >
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Judul untuk ditampilkan di admin</p>
            </div>

            <!-- Keywords -->
            <div>
                <label for="keywords" class="block text-sm font-medium text-gray-700 mb-2">
                    Keywords <span class="text-red-600">*</span>
                </label>
                <input 
                    type="text" 
                    id="keywords" 
                    name="keywords" 
                    value="{{ old('keywords') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('keywords') border-red-500 @enderror"
                    placeholder="halo, hai, hello, hi"
                    required
                >
                @error('keywords')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Kata kunci yang memicu balasan ini (pisahkan dengan koma)</p>
            </div>

            <!-- Response -->
            <div>
                <label for="response" class="block text-sm font-medium text-gray-700 mb-2">
                    Balasan <span class="text-red-600">*</span>
                </label>
                <textarea 
                    id="response" 
                    name="response" 
                    rows="8"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('response') border-red-500 @enderror"
                    placeholder="Halo! 😊 Selamat datang di SMK Bina Mandiri Bekasi..."
                    required
                >{{ old('response') }}</textarea>
                @error('response')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">Balasan yang akan dikirim chatbot. Gunakan \n untuk baris baru, gunakan emoji untuk lebih friendly</p>
            </div>

            <!-- Priority -->
            <div>
                <label for="priority" class="block text-sm font-medium text-gray-700 mb-2">
                    Prioritas <span class="text-red-600">*</span>
                </label>
                <input 
                    type="number" 
                    id="priority" 
                    name="priority" 
                    value="{{ old('priority', 50) }}"
                    min="0"
                    max="100"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('priority') border-red-500 @enderror"
                    required
                >
                @error('priority')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                <p class="mt-1 text-xs text-gray-500">0-100 (semakin tinggi semakin prioritas dicek duluan)</p>
            </div>

            <!-- Is Active -->
            <div class="flex items-center">
                <input 
                    type="checkbox" 
                    id="is_active" 
                    name="is_active" 
                    value="1"
                    {{ old('is_active', true) ? 'checked' : '' }}
                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500"
                >
                <label for="is_active" class="ml-2 text-sm text-gray-700">
                    Aktifkan balasan ini
                </label>
            </div>

            <!-- Buttons -->
            <div class="flex items-center gap-4 pt-4 border-t border-gray-200">
                <button type="submit" class="inline-flex items-center px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Simpan Balasan
                </button>
                <a href="{{ route('admin.chatbot-responses.index') }}" class="inline-flex items-center px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Batal
                </a>
            </div>
        </form>
    </div>

    <!-- Tips Box -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="text-sm text-blue-800">
                <p class="font-semibold mb-2">Tips Membuat Balasan Efektif:</p>
                <ul class="list-disc list-inside space-y-1">
                    <li>Gunakan bahasa yang ramah dan sopan</li>
                    <li>Tambahkan emoji untuk membuat lebih friendly (😊, 🏫, 📚, dll)</li>
                    <li>Berikan informasi yang lengkap tapi ringkas</li>
                    <li>Gunakan format yang rapi dengan line breaks (\n)</li>
                    <li>Test balasan di chatbot setelah menyimpan</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
