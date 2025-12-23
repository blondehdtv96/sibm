@extends('layouts.public-tailwind')

@section('title', 'Tentang Kami - ' . config('school.name'))

@section('content')
<!-- Hero Section -->
<section class="relative min-h-screen flex items-center justify-center overflow-hidden">
    <!-- Gradient Background with Pattern -->
    <div class="absolute inset-0 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700"></div>
    
    <!-- Geometric Pattern Overlay -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="about-grid" width="10" height="10" patternUnits="userSpaceOnUse">
                    <path d="M 10 0 L 0 0 0 10" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#about-grid)" />
        </svg>
    </div>
    
    <!-- Animated Background Elements -->
    <div class="absolute inset-0 opacity-20">
        <div class="absolute top-20 left-10 w-72 h-72 bg-white rounded-full mix-blend-multiply filter blur-xl animate-blob"></div>
        <div class="absolute top-40 right-10 w-72 h-72 bg-purple-300 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-2000"></div>
        <div class="absolute bottom-20 left-20 w-72 h-72 bg-blue-300 rounded-full mix-blend-multiply filter blur-xl animate-blob animation-delay-4000"></div>
    </div>
    
    <!-- Hero Content -->
    <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <!-- School Logo/Badge -->
        <div class="mb-8 flex justify-center">
            <div class="w-24 h-24 bg-white/20 backdrop-blur-lg rounded-3xl flex items-center justify-center border border-white/30 shadow-2xl">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
            </div>
        </div>
        
        <h1 class="text-3xl sm:text-4xl md:text-5xl lg:text-7xl font-black text-white mb-6 leading-tight tracking-tight">
            {{ setting('about_hero_title', 'Tentang ' . config('school.name', 'SMK Bina Mandiri Bekasi')) }}
        </h1>
        <p class="text-xl sm:text-2xl md:text-3xl text-white/95 mb-4 max-w-4xl mx-auto leading-relaxed font-light">
            {{ setting('about_hero_subtitle', 'Membangun Generasi Unggul Melalui Pendidikan Berkualitas') }}
        </p>
        <p class="text-lg text-white/80 mb-12 max-w-2xl mx-auto leading-relaxed">
            {{ setting('about_hero_description', 'Pelajari lebih lanjut tentang sejarah, visi, misi, dan komitmen kami dalam memberikan pendidikan terbaik untuk masa depan yang cemerlang') }}
        </p>
        
        <!-- Quick Stats -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-6 mb-12 max-w-4xl mx-auto">
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-white mb-2">{{ setting('about_stat1_value', '25+') }}</div>
                <div class="text-white/80 text-sm md:text-base">{{ setting('about_stat1_label', 'Tahun Pengalaman') }}</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-white mb-2">{{ setting('about_stat2_value', '5000+') }}</div>
                <div class="text-white/80 text-sm md:text-base">{{ setting('about_stat2_label', 'Alumni Sukses') }}</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-white mb-2">{{ setting('about_stat3_value', '100+') }}</div>
                <div class="text-white/80 text-sm md:text-base">{{ setting('about_stat3_label', 'Tenaga Pendidik') }}</div>
            </div>
            <div class="text-center">
                <div class="text-3xl md:text-4xl font-bold text-white mb-2">{{ setting('about_stat4_value', '15+') }}</div>
                <div class="text-white/80 text-sm md:text-base">{{ setting('about_stat4_label', 'Program Keahlian') }}</div>
            </div>
        </div>
    </div>
    
    <!-- Scroll Indicator -->
    <div class="absolute bottom-8 left-1/2 transform -translate-x-1/2 animate-bounce">
        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 14l-7 7m0 0l-7-7m7 7V3"/>
        </svg>
    </div>
</section>

<!-- School Profile Section -->
<section class="py-20 bg-gradient-to-b from-gray-50 to-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Profil Sekolah</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-purple-600 mx-auto rounded-full mb-6"></div>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Informasi lengkap tentang identitas dan kontak sekolah kami
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            <!-- Address -->
            <div class="bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transform hover:-translate-y-4 transition-all duration-500 border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-blue-50 rounded-full -translate-y-10 translate-x-10"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Alamat</h3>
                    <p class="text-gray-600 leading-relaxed">{{ setting('contact_address', config('school.address', 'Jl. Pendidikan No. 123, Bekasi Timur, Jawa Barat 17113')) }}</p>
                </div>
            </div>
            
            <!-- Phone -->
            <div class="bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transform hover:-translate-y-4 transition-all duration-500 border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-green-50 rounded-full -translate-y-10 translate-x-10"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Telepon</h3>
                    <p class="text-gray-600 leading-relaxed">{{ setting('contact_phone', config('school.phone', '+62 21 1234 5678')) }}</p>
                </div>
            </div>
            
            <!-- Email -->
            <div class="bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transform hover:-translate-y-4 transition-all duration-500 border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-purple-50 rounded-full -translate-y-10 translate-x-10"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Email</h3>
                    <p class="text-gray-600 leading-relaxed">{{ setting('contact_email', config('school.email', 'info@smkbinamandiri.sch.id')) }}</p>
                </div>
            </div>
            
            <!-- Website -->
            <div class="bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transform hover:-translate-y-4 transition-all duration-500 border border-gray-100 relative overflow-hidden">
                <div class="absolute top-0 right-0 w-20 h-20 bg-orange-50 rounded-full -translate-y-10 translate-x-10"></div>
                <div class="relative z-10">
                    <div class="w-16 h-16 bg-gradient-to-br from-orange-500 to-orange-600 rounded-2xl flex items-center justify-center mb-6">
                        <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"/>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold text-gray-800 mb-3">Website</h3>
                    <p class="text-gray-600 leading-relaxed">
                        <a href="{{ config('app.url') }}" class="text-blue-600 hover:text-blue-800 transition-colors">
                            {{ str_replace(['https://', 'http://'], '', config('app.url')) }}
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- Vision & Mission Section -->
<section class="py-20 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-16">
            <!-- Vision -->
            <div class="relative">
                <div class="bg-gradient-to-br from-blue-50 to-indigo-100 rounded-3xl p-8 lg:p-12 h-full">
                    <div class="flex items-center mb-8">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Visi Kami</h2>
                    </div>
                    <p class="text-lg text-gray-700 leading-relaxed">
                        {{ setting('about_vision', 'Menjadi lembaga pendidikan terdepan yang menghasilkan lulusan kompeten, inovatif, dan berkarakter yang siap menghadapi tantangan global serta berkontribusi positif bagi masyarakat.') }}
                    </p>
                </div>
            </div>
            
            <!-- Mission -->
            <div class="relative">
                <div class="bg-gradient-to-br from-purple-50 to-pink-100 rounded-3xl p-8 lg:p-12 h-full">
                    <div class="flex items-center mb-8">
                        <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mr-4">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <h2 class="text-3xl md:text-4xl font-bold text-gray-800">Misi Kami</h2>
                    </div>
                    <ul class="space-y-4">
                        @php
                            $missions = explode("\n", setting('about_mission', "1. Menyelenggarakan pendidikan berkualitas yang memenuhi standar nasional dan internasional\n2. Mengembangkan kompetensi siswa melalui pendekatan pembelajaran inovatif dan praktis\n3. Membina pengembangan karakter berdasarkan nilai-nilai moral dan etika\n4. Membangun kemitraan dengan industri dan masyarakat untuk hasil pembelajaran yang optimal\n5. Menciptakan lingkungan belajar yang kondusif dan berbasis teknologi"));
                            $missionNumber = 1;
                        @endphp
                        @foreach($missions as $mission)
                            @if(trim($mission))
                            <li class="flex items-start gap-4">
                                <div class="w-8 h-8 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <span class="text-white text-sm font-bold">{{ $missionNumber++ }}</span>
                                </div>
                                <span class="text-gray-700 leading-relaxed">{{ preg_replace('/^\d+\.\s*/', '', trim($mission)) }}</span>
                            </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Values Section -->
<section class="py-20 bg-gradient-to-br from-gray-50 to-blue-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Nilai-Nilai Kami</h2>
            <div class="w-24 h-1 bg-gradient-to-r from-blue-500 to-purple-600 mx-auto rounded-full mb-6"></div>
            <p class="text-xl text-gray-600 max-w-2xl mx-auto leading-relaxed">
                Nilai-nilai fundamental yang menjadi landasan dalam setiap kegiatan pendidikan kami
            </p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @php
                $valueColors = [
                    1 => ['from' => 'blue-500', 'to' => 'blue-600'],
                    2 => ['from' => 'green-500', 'to' => 'green-600'],
                    3 => ['from' => 'purple-500', 'to' => 'purple-600'],
                    4 => ['from' => 'orange-500', 'to' => 'orange-600'],
                ];
                $valueIcons = [
                    1 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>',
                    2 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>',
                    3 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/>',
                    4 => '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>',
                ];
            @endphp
            
            @foreach([1, 2, 3, 4] as $i)
            <div class="bg-white rounded-3xl p-8 shadow-xl hover:shadow-2xl transition-all duration-300 text-center group">
                <div class="w-20 h-20 bg-gradient-to-br from-{{ $valueColors[$i]['from'] }} to-{{ $valueColors[$i]['to'] }} rounded-full flex items-center justify-center mx-auto mb-6 group-hover:scale-110 transition-transform duration-300">
                    <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        {!! $valueIcons[$i] !!}
                    </svg>
                </div>
                <h3 class="text-xl font-bold text-gray-800 mb-4">{{ setting('about_value'.$i.'_title', ['Keunggulan', 'Integritas', 'Inovasi', 'Menghargai'][$i-1]) }}</h3>
                <p class="text-gray-600 leading-relaxed">{{ setting('about_value'.$i.'_desc', ['Berusaha mencapai standar tertinggi dalam setiap hal yang kami lakukan', 'Bertindak dengan kejujuran dan prinsip moral yang kuat', 'Mengembangkan kreativitas dan ide-ide baru dalam pembelajaran', 'Menghargai keberagaman dan memperlakukan setiap orang dengan martabat'][$i-1]) }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>


<!-- Call to Action Section -->
<section class="py-20 bg-gradient-to-br from-blue-600 via-indigo-600 to-purple-700 relative overflow-hidden">
    <!-- Background Pattern -->
    <div class="absolute inset-0 opacity-10">
        <svg class="w-full h-full" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <pattern id="cta-grid" width="20" height="20" patternUnits="userSpaceOnUse">
                    <path d="M 20 0 L 0 0 0 20" fill="none" stroke="white" stroke-width="0.5"/>
                </pattern>
            </defs>
            <rect width="100%" height="100%" fill="url(#cta-grid)" />
        </svg>
    </div>
    
    <!-- Floating Elements -->
    <div class="absolute inset-0 overflow-hidden">
        <div class="absolute top-20 left-10 w-32 h-32 bg-white/10 rounded-full animate-pulse"></div>
        <div class="absolute bottom-20 right-10 w-24 h-24 bg-white/10 rounded-full animate-pulse animation-delay-2000"></div>
        <div class="absolute top-1/2 left-1/4 w-16 h-16 bg-white/10 rounded-full animate-pulse animation-delay-4000"></div>
    </div>
    
    <div class="relative z-10 max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
        <h2 class="text-4xl md:text-5xl font-bold text-white mb-6 leading-tight">
            Bergabunglah dengan Komunitas Kami
        </h2>
        <p class="text-xl text-white/90 mb-12 leading-relaxed max-w-2xl mx-auto">
            Temukan lebih banyak tentang program-program kami dan bagaimana menjadi bagian dari keluarga besar {{ config('school.name', 'SMK Bina Mandiri') }}
        </p>
        
        <div class="flex flex-col sm:flex-row gap-6 justify-center items-center">
            <a href="{{ route('public.competencies.index') }}" 
               class="group px-10 py-4 bg-white text-blue-600 rounded-2xl font-bold text-lg shadow-2xl hover:shadow-3xl transform hover:-translate-y-2 hover:scale-105 transition-all duration-300 flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                <span>Lihat Program</span>
                <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                </svg>
            </a>
            
            <a href="{{ route('info.contact') }}" 
               class="px-10 py-4 bg-white/10 backdrop-blur-lg text-white rounded-2xl font-bold text-lg border-2 border-white/30 hover:bg-white/20 hover:border-white/50 transition-all duration-300 flex items-center gap-3">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/>
                </svg>
                <span>Hubungi Kami</span>
            </a>
        </div>
    </div>
</section>

@endsection

@push('styles')
<style>
    @keyframes blob {
        0%, 100% { transform: translate(0, 0) scale(1); }
        25% { transform: translate(20px, -50px) scale(1.1); }
        50% { transform: translate(-20px, 20px) scale(0.9); }
        75% { transform: translate(50px, 50px) scale(1.05); }
    }
    .animate-blob { animation: blob 7s infinite; }
    .animation-delay-2000 { animation-delay: 2s; }
    .animation-delay-4000 { animation-delay: 4s; }
    html { scroll-behavior: smooth; }
    .backdrop-blur-lg { backdrop-filter: blur(16px); -webkit-backdrop-filter: blur(16px); }
    .shadow-3xl { box-shadow: 0 35px 60px -12px rgba(0, 0, 0, 0.25); }
</style>
@endpush
