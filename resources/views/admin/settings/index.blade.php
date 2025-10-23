@extends('layouts.admin-modern')

@section('title', 'Pengaturan Website')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900">Pengaturan Website</h1>
            <p class="mt-1 text-sm text-gray-600">Kelola logo, nama, dan pengaturan website</p>
        </div>
        <form action="{{ route('admin.settings.clear-cache') }}" method="POST">
            @csrf
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white text-sm font-medium rounded-lg transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
                Clear Cache
            </button>
        </form>
    </div>

    @if(session('success'))
    <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="text-green-700 font-medium">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- Logo Settings -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-purple-50">
            <h2 class="text-xl font-bold text-gray-900">Logo & Branding</h2>
            <p class="text-sm text-gray-600 mt-1">Upload dan kelola logo sekolah</p>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Logo Utama -->
                <div class="space-y-4">
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Logo Utama</h3>
                        <p class="text-sm text-gray-600 mb-4">Digunakan di header website</p>
                        
                        <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-6 mb-4">
                            @if(App\Models\Setting::get('site_logo'))
                                <img src="{{ App\Models\Setting::getLogo('site_logo') }}" alt="Logo" class="max-h-32 mx-auto mb-4">
                            @else
                                <svg class="w-20 h-20 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-sm text-gray-500">Belum ada logo</p>
                            @endif
                        </div>

                        <form action="{{ route('admin.settings.update-logo') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <input type="hidden" name="logo_type" value="site_logo">
                            <input type="file" name="logo" accept="image/*" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg transition-colors">
                                Upload Logo
                            </button>
                        </form>

                        @if(App\Models\Setting::get('site_logo'))
                        <form action="{{ route('admin.settings.delete-logo') }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="logo_type" value="site_logo">
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus logo?')" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors">
                                Hapus Logo
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

                <!-- Logo Dark Mode -->
                <div class="space-y-4">
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Logo Dark Mode</h3>
                        <p class="text-sm text-gray-600 mb-4">Untuk background gelap (opsional)</p>
                        
                        <div class="bg-gray-900 border-2 border-dashed border-gray-600 rounded-lg p-6 mb-4">
                            @if(App\Models\Setting::get('site_logo_dark'))
                                <img src="{{ App\Models\Setting::getLogo('site_logo_dark') }}" alt="Logo Dark" class="max-h-32 mx-auto mb-4">
                            @else
                                <svg class="w-20 h-20 mx-auto text-gray-500 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                </svg>
                                <p class="text-sm text-gray-400">Belum ada logo</p>
                            @endif
                        </div>

                        <form action="{{ route('admin.settings.update-logo') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <input type="hidden" name="logo_type" value="site_logo_dark">
                            <input type="file" name="logo" accept="image/*" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-purple-50 file:text-purple-700 hover:file:bg-purple-100">
                            <button type="submit" class="w-full px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white text-sm font-medium rounded-lg transition-colors">
                                Upload Logo
                            </button>
                        </form>

                        @if(App\Models\Setting::get('site_logo_dark'))
                        <form action="{{ route('admin.settings.delete-logo') }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="logo_type" value="site_logo_dark">
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus logo?')" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors">
                                Hapus Logo
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

                <!-- Favicon -->
                <div class="space-y-4">
                    <div class="text-center">
                        <h3 class="text-lg font-semibold text-gray-900 mb-2">Favicon</h3>
                        <p class="text-sm text-gray-600 mb-4">Icon di tab browser (32x32px)</p>
                        
                        <div class="bg-gray-50 border-2 border-dashed border-gray-300 rounded-lg p-6 mb-4">
                            @if(App\Models\Setting::get('site_favicon'))
                                <img src="{{ App\Models\Setting::getFavicon() }}" alt="Favicon" class="w-16 h-16 mx-auto mb-4">
                            @else
                                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                                </svg>
                                <p class="text-sm text-gray-500">Belum ada favicon</p>
                            @endif
                        </div>

                        <form action="{{ route('admin.settings.update-logo') }}" method="POST" enctype="multipart/form-data" class="space-y-3">
                            @csrf
                            <input type="hidden" name="logo_type" value="site_favicon">
                            <input type="file" name="logo" accept="image/*,.ico" required class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-green-50 file:text-green-700 hover:file:bg-green-100">
                            <button type="submit" class="w-full px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors">
                                Upload Favicon
                            </button>
                        </form>

                        @if(App\Models\Setting::get('site_favicon'))
                        <form action="{{ route('admin.settings.delete-logo') }}" method="POST" class="mt-2">
                            @csrf
                            @method('DELETE')
                            <input type="hidden" name="logo_type" value="site_favicon">
                            <button type="submit" onclick="return confirm('Yakin ingin menghapus favicon?')" class="w-full px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-lg transition-colors">
                                Hapus Favicon
                            </button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Logo Guidelines -->
            <div class="mt-8 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                <h4 class="font-semibold text-blue-900 mb-2">📋 Panduan Upload Logo:</h4>
                <ul class="text-sm text-blue-800 space-y-1">
                    <li>• <strong>Logo Utama:</strong> Format PNG/JPG/SVG, ukuran maksimal 2MB, resolusi tinggi (min. 300x100px)</li>
                    <li>• <strong>Logo Dark:</strong> Gunakan warna terang untuk background gelap (putih/terang)</li>
                    <li>• <strong>Favicon:</strong> Format ICO/PNG, ukuran 32x32px atau 64x64px untuk hasil terbaik</li>
                    <li>• <strong>Background:</strong> Gunakan background transparan (PNG) untuk hasil terbaik</li>
                </ul>
            </div>
        </div>
    </div>

    <!-- General Settings -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-green-50 to-teal-50">
            <h2 class="text-xl font-bold text-gray-900">Pengaturan Umum</h2>
            <p class="text-sm text-gray-600 mt-1">Informasi dasar website</p>
        </div>

        <div class="p-6">
            <form action="{{ route('admin.settings.update-general') }}" method="POST" class="space-y-6">
                @csrf

                <div>
                    <label for="site_name" class="block text-sm font-medium text-gray-700 mb-2">Nama Sekolah</label>
                    <input type="text" name="site_name" id="site_name" value="{{ App\Models\Setting::get('site_name', 'SMK Bina Mandiri Bekasi') }}" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                </div>

                <div>
                    <label for="site_tagline" class="block text-sm font-medium text-gray-700 mb-2">Tagline Sekolah</label>
                    <input type="text" name="site_tagline" id="site_tagline" value="{{ App\Models\Setting::get('site_tagline', 'Unggul dalam Prestasi, Berkarakter dalam Kehidupan') }}" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <p class="mt-1 text-sm text-gray-500">Tagline atau motto sekolah</p>
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg transition-colors">
                        Simpan Pengaturan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
