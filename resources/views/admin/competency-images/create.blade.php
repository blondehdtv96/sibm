@extends('layouts.admin-modern')

@section('title', 'Upload Gambar - ' . $competency->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <div class="flex items-center gap-2 text-sm text-gray-500 mb-2">
                <a href="{{ route('admin.competencies.index') }}" class="hover:text-blue-600">Kompetensi Keahlian</a>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <a href="{{ route('admin.competencies.images.index', $competency) }}" class="hover:text-blue-600">{{ $competency->name }}</a>
                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
                </svg>
                <span class="text-gray-900 font-medium">Upload Gambar</span>
            </div>
            <h2 class="text-2xl font-bold text-gray-900">Upload Gambar Slider</h2>
            <p class="text-sm text-gray-500 mt-1">Tambahkan gambar baru untuk slider {{ $competency->name }}</p>
        </div>
        <a href="{{ route('admin.competencies.images.index', $competency) }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.competencies.images.store', $competency) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
            <!-- Images Upload -->
            <div>
                <label for="images" class="block text-sm font-medium text-gray-700 mb-2">
                    Gambar Slider * (Multiple)
                </label>
                <input 
                    type="file" 
                    name="images[]" 
                    id="images" 
                    accept="image/*"
                    multiple
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('images.*') border-red-500 @enderror"
                    onchange="previewImages(event)"
                    required
                >
                <p class="mt-1 text-xs text-gray-500">Pilih satu atau lebih gambar (JPG, PNG, max 5MB per file)</p>
                @error('images.*')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror

                <!-- Preview -->
                <div id="imagePreview" class="mt-4 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4 hidden"></div>
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
                    placeholder="Contoh: Ruang Praktik Komputer"
                >
                <p class="mt-1 text-xs text-gray-500">Judul akan diterapkan ke semua gambar yang diupload</p>
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Description -->
            <div>
                <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
                    Deskripsi (Opsional)
                </label>
                <textarea 
                    name="description" 
                    id="description" 
                    rows="3"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('description') border-red-500 @enderror"
                    placeholder="Deskripsi singkat tentang gambar..."
                >{{ old('description') }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Deskripsi akan diterapkan ke semua gambar yang diupload</p>
                @error('description')
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

        <!-- Actions -->
        <div class="flex items-center justify-end space-x-4">
            <a href="{{ route('admin.competencies.images.index', $competency) }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                Batal
            </a>
            <button type="submit" class="px-6 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
                Upload Gambar
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
function previewImages(event) {
    const files = event.target.files;
    const preview = document.getElementById('imagePreview');
    preview.innerHTML = '';
    
    if (files.length > 0) {
        preview.classList.remove('hidden');
        
        Array.from(files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.className = 'relative aspect-video bg-gray-100 rounded-lg overflow-hidden border border-gray-200';
                div.innerHTML = `
                    <img src="${e.target.result}" alt="Preview ${index + 1}" class="w-full h-full object-cover">
                    <div class="absolute top-2 left-2 bg-black/70 text-white px-2 py-1 rounded text-xs font-semibold">
                        #${index + 1}
                    </div>
                `;
                preview.appendChild(div);
            }
            reader.readAsDataURL(file);
        });
    } else {
        preview.classList.add('hidden');
    }
}
</script>
@endpush
