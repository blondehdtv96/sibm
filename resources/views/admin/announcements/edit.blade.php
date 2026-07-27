@extends('layouts.admin-modern')

@section('title', 'Edit Pengumuman')

@section('content')
<div class="space-y-6">
    <div class="flex items-center gap-4">
        <a href="{{ route('admin.announcements.index') }}" class="p-2 hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
        </a>
        <div>
            <h1 class="text-2xl font-bold text-gray-900">Edit Pengumuman</h1>
            <p class="text-gray-600 mt-1">Perbarui gambar atau informasi pengumuman</p>
        </div>
    </div>

    <form action="{{ route('admin.announcements.update', $announcement) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 space-y-6">
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Pengumuman <span class="text-red-500">*</span></label>
                <input type="text" name="title" id="title" value="{{ old('title', $announcement->title) }}"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('title') border-red-500 @enderror" required>
                @error('title')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                <div class="w-full max-w-md bg-gray-50 border border-gray-200 rounded-lg flex items-center justify-center p-4">
                    <img src="{{ asset('storage/' . $announcement->image) }}" alt="{{ $announcement->title }}" class="max-w-full max-h-96 object-contain">
                </div>
            </div>

            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">Ganti Gambar</label>
                <input type="file" name="image" id="image" accept="image/*" onchange="previewImage(event)"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('image') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">Format: JPG, PNG, WEBP. Maksimal 10MB. Kosongkan jika tidak ingin mengganti</p>
                @error('image')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
                <div id="imagePreview" class="mt-4 hidden">
                    <p class="text-sm font-medium text-gray-700 mb-2">Preview Gambar Baru:</p>
                    <div class="w-full max-w-md bg-gray-50 border border-gray-200 rounded-lg flex items-center justify-center p-4">
                        <img id="preview" src="" alt="Preview" class="max-w-full max-h-96 object-contain">
                    </div>
                </div>
            </div>

            <div>
                <label for="link_url" class="block text-sm font-medium text-gray-700 mb-2">Link Tujuan (opsional)</label>
                <input type="url" name="link_url" id="link_url" value="{{ old('link_url', $announcement->link_url) }}" placeholder="https://example.com"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('link_url') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">Jika diisi, gambar dapat diklik menuju link ini</p>
                @error('link_url')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div>
                <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Urutan Tampil</label>
                <input type="number" name="order" id="order" value="{{ old('order', $announcement->order) }}" min="0"
                       class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('order') border-red-500 @enderror">
                <p class="mt-1 text-sm text-gray-500">Semakin kecil angka, semakin awal ditampilkan</p>
                @error('order')<p class="mt-1 text-sm text-red-600">{{ $message }}</p>@enderror
            </div>

            <div class="flex items-center">
                <input type="checkbox" name="is_active" id="is_active" value="1" {{ old('is_active', $announcement->is_active) ? 'checked' : '' }}
                       class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                <label for="is_active" class="ml-2 text-sm text-gray-700">Aktif (tampilkan di halaman utama)</label>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">Perbarui</button>
            <a href="{{ route('admin.announcements.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">Batal</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('preview').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
@endsection
