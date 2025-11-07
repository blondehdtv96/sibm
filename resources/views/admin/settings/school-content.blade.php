@extends('layouts.admin-modern')

@section('title', 'Konten Sekolah')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Konten Sekolah</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola konten Selayang Pandang dan Sambutan Kepala Sekolah</p>
        </div>
        <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Pengaturan
        </a>
    </div>

    <!-- Selayang Pandang Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900">Selayang Pandang</h3>
            </div>
            <a href="{{ route('info.overview') }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-700">
                Lihat Halaman →
            </a>
        </div>

        <form action="{{ route('admin.settings.update-overview') }}" method="POST" class="p-6">
            @csrf
            <div class="space-y-4">
                <div>
                    <label for="school_overview" class="block text-sm font-medium text-gray-700 mb-2">
                        Konten Selayang Pandang *
                    </label>
                    <textarea 
                        name="school_overview" 
                        id="school_overview" 
                        rows="12"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('school_overview') border-red-500 @enderror"
                        placeholder="Masukkan konten selayang pandang sekolah..."
                        required
                    >{{ old('school_overview', $overview) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Jelaskan sejarah, visi, misi, dan informasi umum sekolah</p>
                    @error('school_overview')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
                        Simpan Selayang Pandang
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Sambutan Kepala Sekolah Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-emerald-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900">Sambutan Kepala Sekolah</h3>
            </div>
            <a href="{{ route('info.principal-message') }}" target="_blank" class="text-sm text-emerald-600 hover:text-emerald-700">
                Lihat Halaman →
            </a>
        </div>

        <form action="{{ route('admin.settings.update-principal-message') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <div class="space-y-6">
                <!-- Principal Name -->
                <div>
                    <label for="principal_name" class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Kepala Sekolah *
                    </label>
                    <input 
                        type="text" 
                        name="principal_name" 
                        id="principal_name" 
                        value="{{ old('principal_name', $principalName) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('principal_name') border-red-500 @enderror"
                        placeholder="Contoh: Dr. Ahmad Suryadi, M.Pd"
                        required
                    >
                    @error('principal_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Principal Photo -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Foto Kepala Sekolah
                    </label>
                    
                    @if($principalPhoto)
                        <div class="mb-4">
                            <div class="relative inline-block">
                                <img src="{{ asset('storage/' . $principalPhoto) }}" alt="Foto Kepala Sekolah" class="w-48 h-48 object-cover rounded-lg border border-gray-200">
                                <button 
                                    type="button" 
                                    onclick="deletePrincipalPhoto()"
                                    class="absolute top-2 right-2 p-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    @endif

                    <input 
                        type="file" 
                        name="principal_photo" 
                        id="principal_photo" 
                        accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('principal_photo') border-red-500 @enderror"
                        onchange="previewPhoto(event)"
                    >
                    <p class="mt-1 text-xs text-gray-500">Ukuran rekomendasi: 400x400px (JPG, PNG, max 2MB)</p>
                    @error('principal_photo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                    <!-- Preview -->
                    <div id="photoPreview" class="mt-4 hidden">
                        <p class="text-sm font-medium text-gray-700 mb-2">Preview:</p>
                        <img id="photoPreviewImage" src="" alt="Preview" class="w-48 h-48 object-cover rounded-lg border border-gray-200">
                    </div>
                </div>

                <!-- Principal Message -->
                <div>
                    <label for="principal_message" class="block text-sm font-medium text-gray-700 mb-2">
                        Sambutan Kepala Sekolah *
                    </label>
                    <textarea 
                        name="principal_message" 
                        id="principal_message" 
                        rows="12"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('principal_message') border-red-500 @enderror"
                        placeholder="Masukkan sambutan kepala sekolah..."
                        required
                    >{{ old('principal_message', $principalMessage) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Tulis pesan dan harapan dari kepala sekolah</p>
                    @error('principal_message')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
                        Simpan Sambutan Kepala Sekolah
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Hidden Delete Photo Form -->
<form id="deletePrincipalPhotoForm" action="{{ route('admin.settings.delete-principal-photo') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function previewPhoto(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('photoPreviewImage').src = e.target.result;
            document.getElementById('photoPreview').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

function deletePrincipalPhoto() {
    if (confirm('Apakah Anda yakin ingin menghapus foto kepala sekolah?')) {
        document.getElementById('deletePrincipalPhotoForm').submit();
    }
}
</script>
@endpush
