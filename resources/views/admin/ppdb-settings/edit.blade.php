@extends('layouts.admin-modern')

@section('title', 'Edit Pengaturan PPDB')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Pengaturan PPDB</h2>
            <p class="text-sm text-gray-500 mt-1">Ubah pengaturan periode pendaftaran PPDB</p>
        </div>
        <a href="{{ route('admin.ppdb-settings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Daftar
        </a>
    </div>

    <!-- Error Messages -->
    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-800 rounded-lg p-4">
            <div class="flex items-start">
                <svg class="w-5 h-5 text-red-400 mt-0.5 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
                <div>
                    <h3 class="font-semibold mb-2">Terdapat kesalahan pada form:</h3>
                    <ul class="list-disc list-inside space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif

    <!-- Form -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
        <form action="{{ route('admin.ppdb-settings.update', $ppdbSetting) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Registration Period -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="registration_start" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Mulai Pendaftaran <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        id="registration_start" 
                        name="registration_start" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('registration_start') border-red-500 @enderror"
                        value="{{ old('registration_start', $ppdbSetting->registration_start) }}"
                        required
                    >
                    @error('registration_start')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="registration_end" class="block text-sm font-medium text-gray-700 mb-2">
                        Tanggal Selesai Pendaftaran <span class="text-red-500">*</span>
                    </label>
                    <input 
                        type="date" 
                        id="registration_end" 
                        name="registration_end" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('registration_end') border-red-500 @enderror"
                        value="{{ old('registration_end', $ppdbSetting->registration_end) }}"
                        required
                    >
                    @error('registration_end')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Requirements -->
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Persyaratan Pendaftaran
                </label>
                <div id="requirements-container" class="space-y-3">
                    @php
                        $requirements = is_string($ppdbSetting->requirements) 
                            ? json_decode($ppdbSetting->requirements, true) 
                            : $ppdbSetting->requirements;
                        $requirements = is_array($requirements) ? $requirements : [];
                        $oldRequirements = old('requirements', $requirements);
                    @endphp
                    
                    @if(empty($oldRequirements))
                        <div class="requirement-item flex gap-3 items-center">
                            <input 
                                type="text" 
                                name="requirements[]" 
                                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent"
                                placeholder="Contoh: Fotokopi akta kelahiran"
                            >
                        </div>
                    @else
                        @foreach($oldRequirements as $index => $requirement)
                            <div class="requirement-item flex gap-3 items-center">
                                <input 
                                    type="text" 
                                    name="requirements[]" 
                                    class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent"
                                    placeholder="Contoh: Fotokopi akta kelahiran"
                                    value="{{ $requirement }}"
                                >
                                @if($index > 0)
                                    <button type="button" class="px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors remove-requirement">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                    </button>
                                @endif
                            </div>
                        @endforeach
                    @endif
                </div>
                <button type="button" id="add-requirement" class="mt-3 inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                    </svg>
                    Tambah Persyaratan
                </button>
            </div>

            <!-- Status -->
            <div>
                <label for="status" class="block text-sm font-medium text-gray-700 mb-2">
                    Status <span class="text-red-500">*</span>
                </label>
                <select 
                    id="status" 
                    name="status" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('status') border-red-500 @enderror"
                    required
                >
                    <option value="inactive" {{ old('status', $ppdbSetting->status) === 'inactive' ? 'selected' : '' }}>Tidak Aktif</option>
                    <option value="active" {{ old('status', $ppdbSetting->status) === 'active' ? 'selected' : '' }}>Aktif</option>
                </select>
                <p class="mt-2 text-sm text-gray-500">
                    <svg class="w-4 h-4 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    Catatan: Hanya satu pengaturan yang dapat aktif pada satu waktu. Mengaktifkan ini akan menonaktifkan yang lain.
                </p>
                @error('status')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Actions -->
            <div class="flex items-center justify-end space-x-4 pt-6 border-t border-gray-200">
                <a href="{{ route('admin.ppdb-settings.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
                    Perbarui Pengaturan
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const addButton = document.getElementById('add-requirement');
    const container = document.getElementById('requirements-container');
    
    addButton.addEventListener('click', function() {
        const newItem = document.createElement('div');
        newItem.className = 'requirement-item flex gap-3 items-center';
        newItem.innerHTML = `
            <input 
                type="text" 
                name="requirements[]" 
                class="flex-1 px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent"
                placeholder="Contoh: Fotokopi kartu keluarga"
            >
            <button type="button" class="px-3 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors remove-requirement">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                </svg>
            </button>
        `;
        container.appendChild(newItem);
        
        // Add event listener to the new remove button
        newItem.querySelector('.remove-requirement').addEventListener('click', function() {
            newItem.remove();
        });
    });

    // Handle removal of existing items
    document.addEventListener('click', function(e) {
        if (e.target.closest('.remove-requirement')) {
            e.target.closest('.requirement-item').remove();
        }
    });
});
</script>
@endpush
@endsection
