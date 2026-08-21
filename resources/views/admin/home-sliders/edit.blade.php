@extends('layouts.admin-modern')

@section('title', 'Edit Slider')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Slider</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi slider</p>
        </div>
        <a href="{{ route('admin.home-sliders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.home-sliders.update', $homeSlider) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
            <!-- Current Image -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</label>
                <img src="{{ $homeSlider->image_url }}" alt="{{ $homeSlider->title }}" class="w-full max-w-2xl rounded-lg border border-gray-200">
            </div>

            <!-- Replace Image -->
            <div>
                <label for="image" class="block text-sm font-medium text-gray-700 mb-2">
                    Ganti Gambar (Opsional)
                </label>
                <input 
                    type="file" 
                    name="image" 
                    id="image" 
                    accept="image/*"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('image') border-red-500 @enderror"
                    onchange="previewImage(event)"
                >
                <div class="mt-2 space-y-1">
                    <p class="text-xs text-gray-500">
                        <span class="font-medium">ℹ️ Info:</span> Kosongkan jika tidak ingin mengganti gambar
                    </p>
                    <p class="text-xs text-gray-600">
                        <span class="font-medium">✅ Rekomendasi:</span> 1920x1080px (16:9), landscape, JPG/PNG, max 10MB
                    </p>
                    <p class="text-xs text-gray-500">
                        <span class="font-medium">💡 Tips:</span> Gambar akan ditampilkan penuh tanpa terpotong
                    </p>
                </div>
                @error('image')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Preview -->
                <div id="imagePreview" class="mt-4 hidden">
                    <p class="text-sm font-medium text-gray-700 mb-2">Preview:</p>
                    <img id="previewImg" src="" alt="Preview" class="w-full max-w-2xl rounded-lg border border-gray-200">
                </div>
            </div>

            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
                    Judul (Opsional)
                </label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    value="{{ old('title', $homeSlider->title) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('title') border-red-500 @enderror"
                    placeholder="Selamat Datang di SMK Bina Mandiri"
                >
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Subtitle -->
            <div>
                <label for="subtitle" class="block text-sm font-medium text-gray-700 mb-2">
                    Subtitle (Opsional)
                </label>
                <textarea 
                    name="subtitle" 
                    id="subtitle" 
                    rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('subtitle') border-red-500 @enderror"
                    placeholder="Membangun generasi unggul dengan pendidikan berkualitas"
                >{{ old('subtitle', $homeSlider->subtitle) }}</textarea>
                @error('subtitle')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Button Text -->
                <div>
                    <label for="button_text" class="block text-sm font-medium text-gray-700 mb-2">
                        Teks Tombol (Opsional)
                    </label>
                    <input 
                        type="text" 
                        name="button_text" 
                        id="button_text" 
                        value="{{ old('button_text', $homeSlider->button_text) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('button_text') border-red-500 @enderror"
                        placeholder="Daftar Sekarang"
                    >
                    @error('button_text')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Button Link -->
                <div>
                    <label for="button_link" class="block text-sm font-medium text-gray-700 mb-2">
                        Link Tombol (Opsional)
                    </label>
                    <input 
                        type="text" 
                        name="button_link" 
                        id="button_link" 
                        value="{{ old('button_link', $homeSlider->button_link) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('button_link') border-red-500 @enderror"
                        placeholder="/ppdb/register"
                    >
                    @error('button_link')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Order -->
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Urutan *</label>
                    <input 
                        type="number" 
                        name="order" 
                        id="order" 
                        value="{{ old('order', $homeSlider->order) }}"
                        min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('order') border-red-500 @enderror"
                        required
                    >
                    @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                    <select 
                        name="status" 
                        id="status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('status') border-red-500 @enderror"
                        required
                    >
                        <option value="active" {{ old('status', $homeSlider->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $homeSlider->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between">
            <button type="button" onclick="deleteSlider()" class="px-6 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors">
                Hapus Slider
            </button>
            
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.home-sliders.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
                    Update Slider
                </button>
            </div>
        </div>
    </form>

    <!-- Hidden Delete Form -->
    <form id="deleteForm" action="{{ route('admin.home-sliders.destroy', $homeSlider) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection

@push('scripts')
<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').classList.remove('hidden');
        }
        reader.readAsDataURL(file);
    }
}

function deleteSlider() {
    if (confirm('Apakah Anda yakin ingin menghapus slider ini?')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endpush
