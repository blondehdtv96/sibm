@extends('layouts.admin-modern')

@section('title', 'Kontak & Sosial Media')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Kontak & Sosial Media</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola informasi kontak dan link sosial media</p>
        </div>
        <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali ke Pengaturan
        </a>
    </div>

    <!-- Contact Information Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center">
            <svg class="w-5 h-5 text-blue-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900">Informasi Kontak</h3>
        </div>

        <form action="{{ route('admin.settings.update-contact') }}" method="POST" class="p-6">
            @csrf
            <div class="space-y-6">
                <!-- Address -->
                <div>
                    <label for="contact_address" class="block text-sm font-medium text-gray-700 mb-2">
                        Alamat Sekolah *
                    </label>
                    <textarea 
                        name="contact_address" 
                        id="contact_address" 
                        rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('contact_address') border-red-500 @enderror"
                        placeholder="Jl. Contoh No. 123, Kota, Provinsi"
                        required
                    >{{ old('contact_address', $contactAddress) }}</textarea>
                    @error('contact_address')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Phone -->
                    <div>
                        <label for="contact_phone" class="block text-sm font-medium text-gray-700 mb-2">
                            Nomor Telepon *
                        </label>
                        <input 
                            type="text" 
                            name="contact_phone" 
                            id="contact_phone" 
                            value="{{ old('contact_phone', $contactPhone) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('contact_phone') border-red-500 @enderror"
                            placeholder="+62 21 88888888"
                            required
                        >
                        @error('contact_phone')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Email -->
                    <div>
                        <label for="contact_email" class="block text-sm font-medium text-gray-700 mb-2">
                            Email *
                        </label>
                        <input 
                            type="email" 
                            name="contact_email" 
                            id="contact_email" 
                            value="{{ old('contact_email', $contactEmail) }}"
                            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('contact_email') border-red-500 @enderror"
                            placeholder="info@sekolah.sch.id"
                            required
                        >
                        @error('contact_email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- WhatsApp -->
                <div>
                    <label for="contact_whatsapp" class="block text-sm font-medium text-gray-700 mb-2">
                        WhatsApp (Opsional)
                    </label>
                    <input 
                        type="text" 
                        name="contact_whatsapp" 
                        id="contact_whatsapp" 
                        value="{{ old('contact_whatsapp', $contactWhatsapp) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('contact_whatsapp') border-red-500 @enderror"
                        placeholder="628123456789 (tanpa +)"
                    >
                    <p class="mt-1 text-xs text-gray-500">Format: 628123456789 (tanpa tanda + dan spasi)</p>
                    @error('contact_whatsapp')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
                        Simpan Informasi Kontak
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- Social Media Section -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 bg-gray-50 border-b border-gray-200 flex items-center">
            <svg class="w-5 h-5 text-purple-600 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
            </svg>
            <h3 class="text-lg font-semibold text-gray-900">Link Sosial Media</h3>
        </div>

        <form action="{{ route('admin.settings.update-social-media') }}" method="POST" class="p-6">
            @csrf
            <div class="space-y-6">
                <!-- Facebook -->
                <div>
                    <label for="social_facebook" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                        </svg>
                        Facebook
                    </label>
                    <input 
                        type="url" 
                        name="social_facebook" 
                        id="social_facebook" 
                        value="{{ old('social_facebook', $socialFacebook) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('social_facebook') border-red-500 @enderror"
                        placeholder="https://facebook.com/username"
                    >
                    @error('social_facebook')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Instagram -->
                <div>
                    <label for="social_instagram" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                        </svg>
                        Instagram
                    </label>
                    <input 
                        type="url" 
                        name="social_instagram" 
                        id="social_instagram" 
                        value="{{ old('social_instagram', $socialInstagram) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('social_instagram') border-red-500 @enderror"
                        placeholder="https://instagram.com/username"
                    >
                    @error('social_instagram')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Twitter -->
                <div>
                    <label for="social_twitter" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-sky-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/>
                        </svg>
                        Twitter / X
                    </label>
                    <input 
                        type="url" 
                        name="social_twitter" 
                        id="social_twitter" 
                        value="{{ old('social_twitter', $socialTwitter) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('social_twitter') border-red-500 @enderror"
                        placeholder="https://twitter.com/username"
                    >
                    @error('social_twitter')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- YouTube -->
                <div>
                    <label for="social_youtube" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                        </svg>
                        YouTube
                    </label>
                    <input 
                        type="url" 
                        name="social_youtube" 
                        id="social_youtube" 
                        value="{{ old('social_youtube', $socialYoutube) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('social_youtube') border-red-500 @enderror"
                        placeholder="https://youtube.com/@username"
                    >
                    @error('social_youtube')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- TikTok -->
                <div>
                    <label for="social_tiktok" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12.525.02c1.31-.02 2.61-.01 3.91-.02.08 1.53.63 3.09 1.75 4.17 1.12 1.11 2.7 1.62 4.24 1.79v4.03c-1.44-.05-2.89-.35-4.2-.97-.57-.26-1.1-.59-1.62-.93-.01 2.92.01 5.84-.02 8.75-.08 1.4-.54 2.79-1.35 3.94-1.31 1.92-3.58 3.17-5.91 3.21-1.43.08-2.86-.31-4.08-1.03-2.02-1.19-3.44-3.37-3.65-5.71-.02-.5-.03-1-.01-1.49.18-1.9 1.12-3.72 2.58-4.96 1.66-1.44 3.98-2.13 6.15-1.72.02 1.48-.04 2.96-.04 4.44-.99-.32-2.15-.23-3.02.37-.63.41-1.11 1.04-1.36 1.75-.21.51-.15 1.07-.14 1.61.24 1.64 1.82 3.02 3.5 2.87 1.12-.01 2.19-.66 2.77-1.61.19-.33.4-.67.41-1.06.1-1.79.06-3.57.07-5.36.01-4.03-.01-8.05.02-12.07z"/>
                        </svg>
                        TikTok
                    </label>
                    <input 
                        type="url" 
                        name="social_tiktok" 
                        id="social_tiktok" 
                        value="{{ old('social_tiktok', $socialTiktok) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('social_tiktok') border-red-500 @enderror"
                        placeholder="https://tiktok.com/@username"
                    >
                    @error('social_tiktok')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- LinkedIn -->
                <div>
                    <label for="social_linkedin" class="block text-sm font-medium text-gray-700 mb-2 flex items-center">
                        <svg class="w-5 h-5 mr-2 text-blue-700" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
                        </svg>
                        LinkedIn
                    </label>
                    <input 
                        type="url" 
                        name="social_linkedin" 
                        id="social_linkedin" 
                        value="{{ old('social_linkedin', $socialLinkedin) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('social_linkedin') border-red-500 @enderror"
                        placeholder="https://linkedin.com/company/username"
                    >
                    @error('social_linkedin')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-end">
                    <button type="submit" class="px-6 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
                        Simpan Link Sosial Media
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
