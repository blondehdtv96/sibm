@extends('layouts.admin-modern')

@section('title', 'Tambah Slider')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Tambah Slider</h2>
            <p class="text-sm text-gray-500 mt-1">Upload satu atau beberapa gambar slider sekaligus untuk homepage</p>
        </div>
        <a href="{{ route('admin.home-sliders.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Info Banner -->
    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
        <div class="flex items-start">
            <svg class="w-5 h-5 text-blue-600 mt-0.5 mr-3 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <div class="flex-1">
                <h3 class="text-sm font-medium text-blue-900">Multiple Upload</h3>
                <p class="text-sm text-blue-700 mt-1">
                    Anda bisa upload beberapa gambar sekaligus. Semua gambar akan menggunakan title, subtitle, dan button yang sama. 
                    Urutan akan otomatis bertambah untuk setiap gambar.
                </p>
            </div>
        </div>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.home-sliders.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
            <!-- Multiple Image Upload -->
            <div>
                <label for="images" class="block text-sm font-medium text-gray-700 mb-2">
                    Gambar Slider * (1920x1080px)
                </label>
                <input 
                    type="file" 
                    name="images[]" 
                    id="images" 
                    accept="image/*"
                    multiple
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('images') border-red-500 @enderror @error('images.*') border-red-500 @enderror"
                    onchange="previewImages(event)"
                    required
                >
                <div class="mt-2 space-y-1">
                    <p class="text-xs text-gray-600">
                        <span class="font-medium">📸 Upload multiple:</span> Pilih beberapa gambar sekaligus
                    </p>
                    <p class="text-xs text-gray-600">
                        <span class="font-medium">✅ Rekomendasi:</span> 1920x1080px (16:9), landscape, JPG/PNG, max 5MB
                    </p>
                    <p class="text-xs text-gray-500">
                        <span class="font-medium">💡 Tips:</span> Gambar akan ditampilkan penuh tanpa terpotong
                    </p>
                </div>
                @error('images')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
                @error('images.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Preview Container -->
                <div id="imagePreviewContainer" class="mt-4 hidden">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-sm font-medium text-gray-700">Preview (<span id="imageCount">0</span> gambar):</p>
                        <button type="button" onclick="clearImages()" class="text-xs text-red-600 hover:text-red-700">
                            Hapus Semua
                        </button>
                    </div>
                    <div id="imagePreviewGrid" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4"></div>
                </div>
            </div>

            <!-- Info for Multiple Upload -->
            <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                <p class="text-sm text-gray-600">
                    <span class="font-medium">Catatan:</span> Jika Anda upload beberapa gambar sekaligus, 
                    semua gambar akan menggunakan informasi di bawah ini (title, subtitle, button). 
                    Anda bisa edit individual nanti jika diperlukan.
                </p>
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
                    value="{{ old('title') }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('title') border-red-500 @enderror"
                    placeholder="Selamat Datang di SMK Bina Mandiri"
                >
                <p class="mt-1 text-xs text-gray-500">Akan diterapkan ke semua gambar yang diupload</p>
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
                >{{ old('subtitle') }}</textarea>
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
                        value="{{ old('button_text') }}"
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
                        value="{{ old('button_link') }}"
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
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Urutan Awal *</label>
                    <input 
                        type="number" 
                        name="order" 
                        id="order" 
                        value="{{ old('order', 0) }}"
                        min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('order') border-red-500 @enderror"
                        required
                    >
                    <p class="mt-1 text-xs text-gray-500">Urutan akan otomatis bertambah untuk setiap gambar</p>
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
                        <option value="active" {{ old('status', 'active') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('admin.home-sliders.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
                Simpan Slider
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
let selectedFiles = [];

function previewImages(event) {
    const files = Array.from(event.target.files);
    selectedFiles = files;
    
    if (files.length === 0) {
        document.getElementById('imagePreviewContainer').classList.add('hidden');
        return;
    }

    const previewGrid = document.getElementById('imagePreviewGrid');
    previewGrid.innerHTML = '';
    
    document.getElementById('imageCount').textContent = files.length;
    document.getElementById('imagePreviewContainer').classList.remove('hidden');

    files.forEach((file, index) => {
        const reader = new FileReader();
        reader.onload = function(e) {
            const previewItem = document.createElement('div');
            previewItem.className = 'relative group';
            previewItem.innerHTML = `
                <div class="relative aspect-video rounded-lg overflow-hidden border-2 border-gray-200 hover:border-ios-blue transition-colors">
                    <img src="${e.target.result}" alt="Preview ${index + 1}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all flex items-center justify-center">
                        <button type="button" onclick="removeImage(${index})" class="opacity-0 group-hover:opacity-100 bg-red-500 text-white rounded-full p-2 hover:bg-red-600 transition-all">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>
                <p class="text-xs text-gray-500 mt-1 text-center truncate">${file.name}</p>
                <p class="text-xs text-gray-400 text-center">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
            `;
            previewGrid.appendChild(previewItem);
        }
        reader.readAsDataURL(file);
    });
}

function removeImage(index) {
    selectedFiles.splice(index, 1);
    
    // Create new FileList
    const dt = new DataTransfer();
    selectedFiles.forEach(file => dt.items.add(file));
    document.getElementById('images').files = dt.files;
    
    // Trigger preview update
    previewImages({ target: { files: dt.files } });
}

function clearImages() {
    selectedFiles = [];
    document.getElementById('images').value = '';
    document.getElementById('imagePreviewContainer').classList.add('hidden');
}
</script>
@endpush
