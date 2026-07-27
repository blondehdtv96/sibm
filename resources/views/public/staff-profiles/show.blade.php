@extends('layouts.public-tailwind')

@section('title', $staffProfile->display_name . ' - Profil Guru & Tenaga Kependidikan')
@section('description', Str::limit(strip_tags($staffProfile->bio ?: $staffProfile->position), 160))

@section('content')
<section class="relative overflow-hidden bg-[#1E3A8A] text-white pt-28 pb-16 md:pt-36">
    <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,_#FBBF24,_transparent_30%)] opacity-20"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav aria-label="Breadcrumb" class="mb-8 text-sm text-blue-100"><ol class="flex items-center gap-2"><li><a href="{{ route('home') }}" class="hover:text-white">Beranda</a></li><li>›</li><li><a href="{{ route('public.staff-profiles.index') }}" class="hover:text-white">Profil Guru</a></li><li>›</li><li class="text-white">{{ $staffProfile->name }}</li></ol></nav>
        <div class="grid lg:grid-cols-[240px_1fr] gap-8 items-center">
            <div class="w-48 h-48 md:w-56 md:h-56 rounded-3xl overflow-hidden bg-white/10 border-4 border-white/30 shadow-2xl mx-auto lg:mx-0">
                @if($staffProfile->photo)<img src="{{ $staffProfile->photo_url }}" alt="Foto {{ $staffProfile->display_name }}" class="w-full h-full object-cover">@else<div class="w-full h-full flex items-center justify-center text-7xl font-black text-yellow-300">{{ strtoupper(substr($staffProfile->name, 0, 1)) }}</div>@endif
            </div>
            <div>
                <span class="inline-flex px-3 py-1 rounded-full bg-yellow-400 text-[#1E3A8A] text-xs font-bold">{{ $staffProfile->employment_status ?: $staffProfile->category }}</span>
                <h1 class="mt-4 text-4xl md:text-5xl font-black tracking-tight">{{ $staffProfile->display_name }}</h1>
                <p class="mt-3 text-xl text-yellow-300 font-semibold">{{ $staffProfile->position }}</p>
                @if($staffProfile->subjects || $staffProfile->jurusan)
                    <p class="mt-4 text-blue-100">{{ $staffProfile->subjects }}{{ $staffProfile->subjects && $staffProfile->jurusan ? ' · ' : '' }}{{ $staffProfile->jurusan }}</p>
                @endif
                @if($staffProfile->motto)<blockquote class="mt-6 max-w-2xl text-lg italic text-white/90 border-l-4 border-yellow-400 pl-4">“{{ $staffProfile->motto }}”</blockquote>@endif
            </div>
        </div>
    </div>
</section>

<section class="py-14 md:py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-[minmax(0,2fr)_minmax(280px,1fr)] gap-8">
            <main class="space-y-8">
                @if($staffProfile->bio)
                    <section class="bg-white rounded-2xl border border-gray-200 p-6 md:p-8 shadow-sm"><h2 class="text-2xl font-black text-[#1E3A8A] mb-4">Tentang Saya</h2><p class="text-gray-700 leading-relaxed whitespace-pre-line">{{ $staffProfile->bio }}</p></section>
                @endif
                <section class="bg-white rounded-2xl border border-gray-200 p-6 md:p-8 shadow-sm">
                    <h2 class="text-2xl font-black text-[#1E3A8A] mb-6">Biodata Profesional</h2>
                    <dl class="grid sm:grid-cols-2 gap-x-8 gap-y-5">
                        @foreach([
                            ['Nama Lengkap', $staffProfile->display_name], ['NIP', $staffProfile->nip], ['NUPTK', $staffProfile->nuptk],
                            ['Tempat, Tanggal Lahir', trim(($staffProfile->birth_place ?: '') . ($staffProfile->birth_date ? ', ' . $staffProfile->birth_date->format('d F Y') : ''))],
                            ['Jenis Kelamin', $staffProfile->gender], ['Agama', $staffProfile->religion], ['Email', $staffProfile->email], ['Nomor HP', $staffProfile->phone],
                        ] as [$label, $value])
                            @if($value)<div><dt class="text-xs uppercase tracking-wide text-gray-500 font-semibold">{{ $label }}</dt><dd class="mt-1 text-gray-800 font-medium break-words">{{ $value }}</dd></div>@endif
                        @endforeach
                        @if($staffProfile->address)<div class="sm:col-span-2"><dt class="text-xs uppercase tracking-wide text-gray-500 font-semibold">Alamat</dt><dd class="mt-1 text-gray-800 whitespace-pre-line">{{ $staffProfile->address }}</dd></div>@endif
                    </dl>
                </section>

                @foreach([
                    ['Pendidikan & Sertifikasi', [['Pendidikan Terakhir', $staffProfile->education], ['Riwayat Pendidikan', $staffProfile->education_history], ['Sertifikasi', $staffProfile->certifications]]],
                    ['Kompetensi & Pengalaman', [['Bidang Keahlian', $staffProfile->competencies], ['Pengalaman Mengajar', $staffProfile->experience], ['Prestasi', $staffProfile->achievements]]],
                ] as [$title, $items])
                    @if(collect($items)->contains(fn ($item) => filled($item[1])))
                        <section class="bg-white rounded-2xl border border-gray-200 p-6 md:p-8 shadow-sm">
                            <h2 class="text-2xl font-black text-[#1E3A8A] mb-6">{{ $title }}</h2>
                            <div class="space-y-5">
                                @foreach($items as [$label, $value])
                                    @if($value)<div><h3 class="text-xs uppercase tracking-wide text-gray-500 font-semibold">{{ $label }}</h3><p class="mt-1 text-gray-700 leading-relaxed whitespace-pre-line">{{ $value }}</p></div>@endif
                                @endforeach
                            </div>
                        </section>
                    @endif
                @endforeach

                @if($staffProfile->activeImages->count() > 0)
                    <section class="bg-white rounded-2xl border border-gray-200 p-6 md:p-8 shadow-sm">
                        <h2 class="text-2xl font-black text-[#1E3A8A] mb-6">Galeri Kegiatan Guru</h2>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                            @foreach($staffProfile->activeImages as $image)
                                <button type="button" class="gallery-item group relative aspect-square rounded-xl overflow-hidden bg-gray-100 text-left focus:outline-none focus:ring-4 focus:ring-yellow-300" data-full="{{ $image->image_url }}" data-caption="{{ $image->caption ?: 'Kegiatan ' . $staffProfile->display_name }}" aria-label="Perbesar foto {{ $image->caption ?: 'kegiatan ' . $staffProfile->display_name }}">
                                    <img src="{{ $image->thumbnail_url }}" alt="{{ $image->caption ?: 'Kegiatan ' . $staffProfile->display_name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300" loading="lazy">
                                    <span class="absolute inset-0 flex items-center justify-center bg-black/0 group-hover:bg-black/25 transition-colors" aria-hidden="true"><span class="opacity-0 group-hover:opacity-100 rounded-full bg-white/90 p-3 text-[#1E3A8A] shadow-lg transition-opacity">↗</span></span>
                                    @if($image->caption)<span class="absolute inset-x-0 bottom-0 p-3 bg-gradient-to-t from-black/70 to-transparent text-white text-xs opacity-0 group-hover:opacity-100 transition">{{ $image->caption }}</span>@endif
                                </button>
                            @endforeach
                        </div>
                    </section>
                @endif
            </main>

            <aside class="space-y-6">
                <section class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm"><h2 class="text-lg font-black text-[#1E3A8A] mb-4">Hubungi & Sosial Media</h2><div class="space-y-3 text-sm">@if($staffProfile->email)<a href="mailto:{{ $staffProfile->email }}" class="flex items-center gap-3 text-gray-600 hover:text-blue-700"><span class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">✉</span>{{ $staffProfile->email }}</a>@endif @if($staffProfile->phone)<a href="tel:{{ $staffProfile->phone }}" class="flex items-center gap-3 text-gray-600 hover:text-blue-700"><span class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">☎</span>{{ $staffProfile->phone }}</a>@endif
                    @foreach([['Instagram', $staffProfile->instagram], ['Facebook', $staffProfile->facebook], ['LinkedIn', $staffProfile->linkedin], ['YouTube', $staffProfile->youtube], ['Website', $staffProfile->website]] as [$label, $url]) @if($url)<a href="{{ $url }}" target="_blank" rel="noopener noreferrer" class="flex items-center gap-3 text-gray-600 hover:text-blue-700"><span class="w-8 h-8 rounded-lg bg-yellow-50 flex items-center justify-center text-yellow-700">↗</span>{{ $label }}</a>@endif @endforeach
                </div></section>
                @if($related->count() > 0)<section class="bg-white rounded-2xl border border-gray-200 p-6 shadow-sm"><h2 class="text-lg font-black text-[#1E3A8A] mb-4">Profil Lainnya</h2><div class="space-y-3">@foreach($related as $other)<a href="{{ route('public.staff-profiles.show', ['staffProfile' => $other]) }}" class="flex items-center gap-3 group">@if($other->photo)<img src="{{ $other->photo_url }}" alt="{{ $other->display_name }}" class="w-11 h-11 rounded-full object-cover">@else<div class="w-11 h-11 rounded-full bg-blue-100 text-[#1E3A8A] flex items-center justify-center font-bold">{{ substr($other->name, 0, 1) }}</div>@endif<div><p class="font-semibold text-gray-800 group-hover:text-blue-700">{{ $other->display_name }}</p><p class="text-xs text-gray-500">{{ $other->position }}</p></div></a>@endforeach</div></section>@endif
            </aside>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<div id="staff-gallery-modal" class="hidden fixed inset-0 z-[9999] bg-black/85 p-4 sm:p-8" role="dialog" aria-modal="true" aria-labelledby="staff-gallery-caption" aria-hidden="true">
    <button type="button" id="staff-gallery-close" class="absolute top-4 right-4 z-10 rounded-full p-2 text-white hover:bg-white/20 focus:outline-none focus:ring-2 focus:ring-yellow-300" aria-label="Tutup galeri">✕</button>
    <div class="flex h-full items-center justify-center" data-gallery-backdrop>
        <figure class="max-w-6xl text-center">
            <img id="staff-gallery-image" src="" alt="" class="max-h-[80vh] max-w-full rounded-xl object-contain shadow-2xl">
            <figcaption id="staff-gallery-caption" class="mt-4 text-sm text-white"></figcaption>
        </figure>
    </div>
</div>
<script>
(function () {
    const modal = document.getElementById('staff-gallery-modal');
    const modalImage = document.getElementById('staff-gallery-image');
    const modalCaption = document.getElementById('staff-gallery-caption');
    const closeButton = document.getElementById('staff-gallery-close');
    let lastFocusedElement = null;

    if (!modal || !modalImage || !closeButton) return;

    function closeGallery() {
        modal.classList.add('hidden');
        modal.setAttribute('aria-hidden', 'true');
        modalImage.removeAttribute('src');
        document.body.style.overflow = '';
        if (lastFocusedElement) lastFocusedElement.focus();
    }

    document.querySelectorAll('.gallery-item').forEach(function (item) {
        item.addEventListener('click', function () {
            lastFocusedElement = item;
            modalImage.src = item.dataset.full;
            modalImage.alt = item.dataset.caption || 'Foto kegiatan';
            modalCaption.textContent = item.dataset.caption || '';
            modal.classList.remove('hidden');
            modal.setAttribute('aria-hidden', 'false');
            document.body.style.overflow = 'hidden';
            closeButton.focus();
        });
    });

    closeButton.addEventListener('click', closeGallery);
    modal.addEventListener('click', function (event) {
        if (event.target === modal || event.target.matches('[data-gallery-backdrop]')) closeGallery();
    });
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && !modal.classList.contains('hidden')) closeGallery();
    });
})();
</script>
<script type="application/ld+json">{!! json_encode(['@context' => 'https://schema.org', '@type' => 'Person', 'name' => $staffProfile->display_name, 'jobTitle' => $staffProfile->position, 'worksFor' => ['@type' => 'EducationalOrganization', 'name' => config('school.name')], 'email' => $staffProfile->email, 'image' => $staffProfile->photo_url], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) !!}</script>
@endpush
