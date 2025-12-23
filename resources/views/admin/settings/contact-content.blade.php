@extends('layouts.admin-modern')

@section('title', 'Konten Halaman Kontak')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Konten Halaman Kontak</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola konten dan pengaturan halaman Hubungi Kami</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('info.contact') }}" target="_blank" class="inline-flex items-center px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>
                Lihat Halaman
            </a>
            <a href="{{ route('admin.contact-messages.index') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
                Lihat Pesan Masuk
            </a>
            <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                Kembali
            </a>
        </div>
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

    <form action="{{ route('admin.settings.update-contact-content') }}" method="POST">
        @csrf
        
        <!-- Hero Section -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 bg-gradient-to-r from-teal-500 to-cyan-600">
                <h3 class="text-lg font-semibold text-white">Hero Section</h3>
            </div>
            <div class="p-6 space-y-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Judul Halaman *</label>
                    <input type="text" name="contact_page_title" value="{{ old('contact_page_title', $contactPageTitle) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Subtitle *</label>
                    <input type="text" name="contact_page_subtitle" value="{{ old('contact_page_subtitle', $contactPageSubtitle) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Deskripsi *</label>
                    <textarea name="contact_page_description" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" required>{{ old('contact_page_description', $contactPageDescription) }}</textarea>
                </div>
            </div>
        </div>

        <!-- Office Hours -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Jam Operasional</h3>
            </div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Jam Operasional (Hero) *</label>
                    <input type="text" name="contact_office_hours" value="{{ old('contact_office_hours', $contactOfficeHours) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" 
                        placeholder="07:00 - 16:00" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Senin - Jumat *</label>
                    <input type="text" name="contact_office_hours_weekday" value="{{ old('contact_office_hours_weekday', $contactOfficeHoursWeekday) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" 
                        placeholder="07:00 - 16:00" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Sabtu *</label>
                    <input type="text" name="contact_office_hours_saturday" value="{{ old('contact_office_hours_saturday', $contactOfficeHoursSaturday) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" 
                        placeholder="07:00 - 12:00" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Minggu *</label>
                    <input type="text" name="contact_office_hours_sunday" value="{{ old('contact_office_hours_sunday', $contactOfficeHoursSunday) }}"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500" 
                        placeholder="Tutup" required>
                </div>
            </div>
        </div>

        <!-- Google Maps -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden mb-6">
            <div class="px-6 py-4 bg-gray-50 border-b border-gray-200">
                <h3 class="text-lg font-semibold text-gray-900">Google Maps Embed</h3>
            </div>
            <div class="p-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">URL Embed Google Maps</label>
                    <textarea name="contact_map_embed" rows="3"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-teal-500 font-mono text-sm"
                        placeholder="https://www.google.com/maps/embed?pb=...">{{ old('contact_map_embed', $contactMapEmbed) }}</textarea>
                    <p class="mt-1 text-xs text-gray-500">Dapatkan URL embed dari Google Maps → Share → Embed a map → Copy src URL</p>
                </div>
                @if($contactMapEmbed)
                <div class="mt-4">
                    <p class="text-sm font-medium text-gray-700 mb-2">Preview:</p>
                    <div class="h-64 rounded-lg overflow-hidden border border-gray-200">
                        <iframe src="{{ $contactMapEmbed }}" width="100%" height="100%" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Submit -->
        <div class="flex justify-end">
            <button type="submit" class="px-6 py-3 bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition-colors font-medium">
                Simpan Semua Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
