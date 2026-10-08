@extends('layouts.admin-modern')

@section('title', 'Konten Sekolah')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Konten Sekolah</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola konten Selayang Pandang, Sambutan Kepala Sekolah, dan Statistik Homepage</p>
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
                    <p class="mt-1 text-xs text-gray-500">Ukuran rekomendasi: 400x400px (JPG, PNG, max 20MB)</p>
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

    <!-- Homepage Statistics Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900">Statistik Homepage</h3>
            </div>
            <a href="{{ route('home') }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-700">
                Lihat Homepage →
            </a>
        </div>

        <form action="{{ route('admin.settings.update-statistics') }}" method="POST" class="p-6">
            @csrf

            @if($statistics->isEmpty())
                <p class="text-sm text-gray-500">Belum ada data statistik.</p>
            @else
                <p class="mb-5 text-sm text-gray-500">
                    Angka ini tampil pada panel statistik di halaman utama. Kolom <strong>Akhiran</strong> diisi bila
                    angkanya perlu imbuhan, misalnya <code class="rounded bg-gray-100 px-1">+</code> atau
                    <code class="rounded bg-gray-100 px-1">%</code>.
                </p>

                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    @foreach($statistics as $index => $statistic)
                        <div class="rounded-lg bg-gray-50 p-4">
                            <div class="mb-4 flex items-center justify-between">
                                <h4 class="font-semibold text-gray-900">Statistik {{ $index + 1 }}</h4>
                                <label class="inline-flex items-center gap-2 text-sm text-gray-600">
                                    <input
                                        type="checkbox"
                                        name="statistics[{{ $index }}][is_active]"
                                        value="1"
                                        @checked(old("statistics.$index.is_active", $statistic->status === 'active'))
                                        class="rounded border-gray-300 text-ios-blue focus:ring-ios-blue"
                                    >
                                    Tampilkan
                                </label>
                            </div>

                            <input type="hidden" name="statistics[{{ $index }}][id]" value="{{ $statistic->id }}">

                            <div class="space-y-3">
                                <div class="grid grid-cols-3 gap-3">
                                    <div class="col-span-2">
                                        <label class="mb-1 block text-sm font-medium text-gray-700">Nilai</label>
                                        <input
                                            type="text"
                                            name="statistics[{{ $index }}][value]"
                                            value="{{ old("statistics.$index.value", $statistic->value) }}"
                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2 focus:ring-ios-blue @error("statistics.$index.value") border-red-500 @enderror"
                                            placeholder="1400"
                                        >
                                        @error("statistics.$index.value")
                                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <label class="mb-1 block text-sm font-medium text-gray-700">Akhiran</label>
                                        <input
                                            type="text"
                                            name="statistics[{{ $index }}][suffix]"
                                            value="{{ old("statistics.$index.suffix", $statistic->suffix) }}"
                                            class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2 focus:ring-ios-blue"
                                            placeholder="+"
                                        >
                                    </div>
                                </div>
                                <div>
                                    <label class="mb-1 block text-sm font-medium text-gray-700">Label</label>
                                    <input
                                        type="text"
                                        name="statistics[{{ $index }}][label]"
                                        value="{{ old("statistics.$index.label", $statistic->label) }}"
                                        class="w-full rounded-lg border border-gray-300 px-3 py-2 focus:border-transparent focus:ring-2 focus:ring-ios-blue @error("statistics.$index.label") border-red-500 @enderror"
                                        placeholder="Siswa Aktif"
                                    >
                                    @error("statistics.$index.label")
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit" class="rounded-lg bg-ios-blue px-6 py-2 text-white transition-colors hover:bg-blue-600">
                        Simpan Statistik
                    </button>
                </div>
            @endif
        </form>
    </div>

    <!-- Homepage Running Text Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-emerald-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.34 15.84c-.688-.06-1.386-.09-2.09-.09H7.5a4.5 4.5 0 1 1 0-9h.75c.704 0 1.402-.03 2.09-.09m0 9.18c.253.962.584 1.892.985 2.783.247.55.06 1.21-.463 1.511l-.657.38c-.551.318-1.26.117-1.527-.461a20.845 20.845 0 0 1-1.44-4.282m3.102.069a18.03 18.03 0 0 1-.59-4.59c0-1.586.205-3.124.59-4.59m0 9.18a23.848 23.848 0 0 1 8.835 2.535M10.34 6.66a23.847 23.847 0 0 0 8.835-2.535m0 0A23.74 23.74 0 0 0 18.795 3m.38 1.125a23.91 23.91 0 0 1 1.014 5.395m-1.014 8.855c-.118.38-.245.754-.38 1.125m.38-1.125a23.91 23.91 0 0 0 1.014-5.395m0-3.46c.495.413.811 1.035.811 1.73 0 .695-.316 1.317-.811 1.73m0-3.46a24.347 24.347 0 0 1 0 3.46"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900">Teks Berjalan Homepage</h3>
            </div>
            <a href="{{ route('home') }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-700">
                Lihat di Homepage →
            </a>
        </div>

        <form action="{{ route('admin.settings.update-running-text') }}" method="POST" class="p-6">
            @csrf
            <div class="space-y-6">
                <label class="flex items-start gap-3">
                    <input
                        type="checkbox"
                        name="running_text_enabled"
                        value="1"
                        @checked(old('running_text_enabled', $runningTextEnabled))
                        class="mt-1 rounded border-gray-300 text-ios-blue focus:ring-ios-blue"
                    >
                    <span>
                        <span class="block text-sm font-medium text-gray-700">Tampilkan teks berjalan</span>
                        <span class="block text-xs text-gray-500">Matikan untuk menyembunyikan baris teks berjalan dari halaman utama.</span>
                    </span>
                </label>

                <div>
                    <label for="running_text_content" class="mb-2 block text-sm font-medium text-gray-700">
                        Isi Teks Berjalan
                    </label>
                    <textarea
                        name="running_text_content"
                        id="running_text_content"
                        rows="6"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 font-mono text-sm focus:border-transparent focus:ring-2 focus:ring-ios-blue @error('running_text_content') border-red-500 @enderror"
                        placeholder="Pendaftaran SPMB 2026 telah dibuka&#10;Kunjungi sekolah setiap hari kerja pukul 08.00 - 15.00&#10;Informasi beasiswa | https://contoh.sch.id/beasiswa"
                    >{{ old('running_text_content', $runningTextContent) }}</textarea>
                    <p class="mt-2 text-xs text-gray-500">
                        <strong>Satu baris = satu pesan.</strong> Pesan akan berjalan bergantian.
                        Untuk membuat pesan bisa diklik, tambahkan tanda <code class="rounded bg-gray-100 px-1">|</code>
                        lalu alamat tautannya, contoh:
                        <code class="rounded bg-gray-100 px-1">Pendaftaran dibuka | https://contoh.sch.id/ppdb</code>
                    </p>
                    @error('running_text_content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="running_text_speed" class="mb-2 block text-sm font-medium text-gray-700">Kecepatan</label>
                    @php $currentSpeed = old('running_text_speed', $runningTextSpeed); @endphp
                    <select
                        name="running_text_speed"
                        id="running_text_speed"
                        class="w-full rounded-lg border border-gray-300 px-4 py-2 focus:border-transparent focus:ring-2 focus:ring-ios-blue md:max-w-xs"
                    >
                        <option value="slow" @selected($currentSpeed === 'slow')>Lambat</option>
                        <option value="normal" @selected($currentSpeed === 'normal')>Normal</option>
                        <option value="fast" @selected($currentSpeed === 'fast')>Cepat</option>
                    </select>
                    @error('running_text_speed')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="rounded-lg bg-emerald-600 px-6 py-2 text-white transition-colors hover:bg-emerald-700">
                        Simpan Teks Berjalan
                    </button>
                </div>
            </div>
        </form>
    </div>
    </div>

    <!-- PPDB Brochure Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center justify-between">
            <div class="flex items-center">
                <svg class="w-5 h-5 text-orange-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/>
                </svg>
                <h3 class="text-lg font-semibold text-gray-900">Brosur PPDB</h3>
            </div>
            <a href="{{ route('home') }}" target="_blank" class="text-sm text-blue-600 hover:text-blue-700">
                Lihat di Homepage →
            </a>
        </div>

        <form action="{{ route('admin.settings.update-ppdb-brochure') }}" method="POST" enctype="multipart/form-data" class="p-6">
            @csrf
            <div class="space-y-6">
                <!-- Current Brochure -->
                @if(setting('ppdb_brochure'))
                <div class="bg-orange-50 rounded-lg p-4 border border-orange-200">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <h4 class="font-medium text-gray-900 mb-2">Brosur Saat Ini</h4>
                            <div class="flex items-center gap-4">
                                <img src="{{ asset('storage/' . setting('ppdb_brochure')) }}" 
                                     alt="PPDB Brochure" 
                                     class="w-32 h-32 object-contain bg-white rounded-lg border border-gray-200">
                                <div class="flex flex-col gap-2">
                                    <a href="{{ asset('storage/' . setting('ppdb_brochure')) }}" 
                                       target="_blank"
                                       class="inline-flex items-center gap-2 px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Lihat Brosur
                                    </a>
                                    <button type="button" 
                                            onclick="if(confirm('Yakin ingin menghapus brosur?')) document.getElementById('deleteBrochureForm').submit();"
                                            class="inline-flex items-center gap-2 px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors text-sm">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                        </svg>
                                        Hapus Brosur
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Upload New Brochure -->
                <div>
                    <label for="ppdb_brochure" class="block text-sm font-medium text-gray-700 mb-2">
                        {{ setting('ppdb_brochure') ? 'Ganti Brosur' : 'Upload Brosur' }}
                    </label>
                    <input 
                        type="file" 
                        name="ppdb_brochure" 
                        id="ppdb_brochure" 
                        accept="image/*"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                    >
                    <p class="text-sm text-gray-500 mt-1">Format: JPG, PNG, atau PDF. Maksimal 10MB</p>
                </div>

                <!-- Title -->
                <div>
                    <label for="ppdb_brochure_title" class="block text-sm font-medium text-gray-700 mb-2">
                        Judul Brosur
                    </label>
                    <input 
                        type="text" 
                        name="ppdb_brochure_title" 
                        id="ppdb_brochure_title" 
                        value="{{ old('ppdb_brochure_title', setting('ppdb_brochure_title', 'Brosur PPDB')) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        placeholder="Brosur PPDB"
                    >
                </div>

                <!-- Description -->
                <div>
                    <label for="ppdb_brochure_description" class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea 
                        name="ppdb_brochure_description" 
                        id="ppdb_brochure_description" 
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-orange-500 focus:border-transparent"
                        placeholder="Download brosur PPDB untuk informasi lengkap..."
                    >{{ old('ppdb_brochure_description', setting('ppdb_brochure_description', 'Download brosur PPDB untuk informasi lengkap tentang pendaftaran siswa baru')) }}</textarea>
                </div>
            </div>

            <div class="mt-6 flex justify-end">
                <button type="submit" class="px-6 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                    Simpan Brosur
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Hidden Delete Photo Form -->
<form id="deletePrincipalPhotoForm" action="{{ route('admin.settings.delete-principal-photo') }}" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>

<!-- Hidden Delete Brochure Form -->
<form id="deleteBrochureForm" action="{{ route('admin.settings.delete-ppdb-brochure') }}" method="POST" class="hidden">
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
