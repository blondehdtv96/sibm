@extends('layouts.public-tailwind')

@section('title', 'Profil Guru & Tenaga Kependidikan - ' . config('school.name'))
@section('description', 'Kenali guru dan tenaga kependidikan profesional SMK Bina Mandiri Bekasi.')

@section('content')
<section class="relative overflow-hidden bg-[#1E3A8A] text-white pt-28 pb-20 md:pt-36 md:pb-28">
    <div class="absolute inset-0 opacity-10 bg-[radial-gradient(circle_at_top_right,_#FBBF24,_transparent_35%)]"></div>
    <div class="absolute -right-20 -bottom-32 w-96 h-96 rounded-full border-[40px] border-yellow-400/10"></div>
    <div class="relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav aria-label="Breadcrumb" class="mb-8 text-sm text-blue-100">
            <ol class="flex items-center gap-2">
                <li><a href="{{ route('home') }}" class="hover:text-white transition">Beranda</a></li>
                <li aria-hidden="true">›</li>
                <li class="text-white font-medium">Profil Guru</li>
            </ol>
        </nav>
        <div class="max-w-4xl">
            <span class="inline-flex items-center gap-2 text-yellow-300 text-xs font-bold uppercase tracking-[.22em] mb-5"><span class="w-8 h-px bg-yellow-300"></span> SDM Unggul</span>
            <h1 class="text-4xl sm:text-5xl lg:text-6xl font-black tracking-tight leading-tight">Profil Guru & Tenaga Kependidikan</h1>
            <p class="mt-6 text-lg md:text-xl text-blue-100 leading-relaxed max-w-3xl">Dibimbing oleh tenaga pendidik profesional, berpengalaman, kompeten, serta siap mencetak lulusan unggul, berkarakter, dan siap kerja.</p>
        </div>
    </div>
</section>

<section class="relative -mt-10 z-10">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-px overflow-hidden rounded-2xl bg-gray-200 shadow-xl">
            @foreach([
                ['total', 'Total SDM'], ['staff', 'Total Staff'], ['certified', 'Bersertifikat'], ['productive', 'Produktif'],
                ['normative', 'Normatif'], ['adaptive', 'Adaptif'], ['s2', 'Guru S2'], ['s3', 'Guru S3']
            ] as [$key, $label])
                <div class="bg-white px-3 py-5 text-center">
                    <div class="text-2xl font-black text-[#1E3A8A]">{{ $stats[$key] ?? 0 }}</div>
                    <div class="mt-1 text-[11px] font-semibold text-gray-500 uppercase tracking-wide">{{ $label }}</div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="py-16 md:py-20 bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="mb-10 text-center">
            <span class="text-sm font-bold uppercase tracking-[.2em] text-yellow-600">Keluarga Besar Sekolah</span>
            <h2 class="mt-3 text-3xl md:text-4xl font-black text-[#1E3A8A]">Temukan Profil Pendidik Kami</h2>
            <p class="mt-3 text-gray-600 max-w-2xl mx-auto">Gunakan pencarian dan filter untuk menemukan guru atau tenaga kependidikan berdasarkan bidang keahlian dan unit kerja.</p>
        </div>

        <form method="GET" action="{{ route('public.staff-profiles.index') }}" class="mb-10 rounded-2xl bg-white border border-gray-200 p-4 md:p-5 shadow-sm">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-3">
                <label class="relative lg:col-span-2">
                    <span class="sr-only">Cari guru</span>
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                    <input id="staff-search" type="search" name="search" value="{{ request('search') }}" placeholder="Cari nama, NIP, mapel, jurusan, email..." class="w-full pl-12 pr-4 py-3 rounded-xl border border-gray-300 focus:border-[#1E3A8A] focus:ring-2 focus:ring-blue-100">
                </label>
                <select name="category" class="px-4 py-3 rounded-xl border border-gray-300 focus:border-[#1E3A8A] focus:ring-2 focus:ring-blue-100">
                    <option value="">Semua Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category }}" {{ request('category') === $category ? 'selected' : '' }}>{{ $category }}</option>
                    @endforeach
                </select>
                <select name="employment_status" class="px-4 py-3 rounded-xl border border-gray-300 focus:border-[#1E3A8A] focus:ring-2 focus:ring-blue-100">
                    <option value="">Semua Status</option>
                    @foreach($employmentStatuses as $employmentStatus)
                        <option value="{{ $employmentStatus }}" {{ request('employment_status') === $employmentStatus ? 'selected' : '' }}>{{ $employmentStatus }}</option>
                    @endforeach
                </select>
                <input type="search" name="jurusan" value="{{ request('jurusan') }}" placeholder="Filter jurusan / program..." class="px-4 py-3 rounded-xl border border-gray-300 focus:border-[#1E3A8A] focus:ring-2 focus:ring-blue-100">
                <div class="flex gap-2 lg:col-span-3">
                    <button type="submit" class="px-5 py-3 rounded-xl bg-[#1E3A8A] text-white font-semibold hover:bg-blue-900 transition">Terapkan Filter</button>
                    @if(request()->hasAny(['search', 'category', 'employment_status', 'jurusan']))
                        <a href="{{ route('public.staff-profiles.index') }}" class="px-5 py-3 rounded-xl bg-gray-100 text-gray-700 font-semibold hover:bg-gray-200 transition">Reset</a>
                    @endif
                </div>
            </div>
        </form>

        @if($staffProfiles->count() > 0)
            <div id="staff-grid" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($staffProfiles as $profile)
                    <article class="staff-card group bg-white rounded-2xl overflow-hidden border border-gray-200 shadow-sm hover:shadow-2xl hover:-translate-y-1 transition-all duration-300" data-search="{{ strtolower($profile->display_name . ' ' . $profile->nip . ' ' . $profile->position . ' ' . $profile->subjects . ' ' . $profile->jurusan . ' ' . $profile->email) }}">
                        <div class="relative aspect-square bg-gradient-to-br from-blue-50 to-blue-100 overflow-hidden">
                            @if($profile->photo)
                                <img src="{{ $profile->photo_url }}" alt="Foto {{ $profile->display_name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500" loading="lazy">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-6xl font-black text-[#1E3A8A]">{{ strtoupper(substr($profile->name, 0, 1)) }}</div>
                            @endif
                            @if($profile->is_featured)
                                <span class="absolute top-4 left-4 px-3 py-1 rounded-full bg-yellow-400 text-[#1E3A8A] text-xs font-bold shadow">Unggulan</span>
                            @endif
                            <span class="absolute bottom-4 left-4 px-3 py-1 rounded-full bg-[#1E3A8A]/90 text-white text-xs font-semibold">{{ $profile->employment_status ?: $profile->category }}</span>
                        </div>
                        <div class="p-5">
                            <h3 class="text-lg font-bold text-[#1E3A8A] line-clamp-2">{{ $profile->display_name }}</h3>
                            <p class="mt-2 text-sm font-semibold text-yellow-600">{{ $profile->position }}</p>
                            @if($profile->subjects)
                                <p class="mt-3 text-sm text-gray-600"><span class="font-semibold text-gray-800">Mapel:</span> {{ $profile->subjects }}</p>
                            @endif
                            @if($profile->jurusan)
                                <p class="mt-1 text-sm text-gray-600"><span class="font-semibold text-gray-800">Jurusan:</span> {{ $profile->jurusan }}</p>
                            @endif
                            <a href="{{ route('public.staff-profiles.show', ['staffProfile' => $profile]) }}" class="mt-5 inline-flex items-center gap-2 text-sm font-bold text-[#1E3A8A] hover:text-yellow-600 transition">Lihat Profil <span aria-hidden="true">→</span></a>
                        </div>
                    </article>
                @endforeach
            </div>
            <div id="staff-empty-search" class="hidden text-center py-12 text-gray-500">Tidak ada profil yang sesuai dengan pencarian.</div>
            @if($staffProfiles->hasPages())
                <div class="mt-10">{{ $staffProfiles->links() }}</div>
            @endif
        @else
            <div class="rounded-2xl bg-white border border-gray-200 text-center py-16 px-6 shadow-sm">
                <div class="w-20 h-20 mx-auto rounded-full bg-blue-50 text-[#1E3A8A] flex items-center justify-center mb-5"><svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.7" d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m7-6a4 4 0 11-8 0 4 4 0 018 0z"/></svg></div>
                <h2 class="text-2xl font-bold text-[#1E3A8A]">Profil Segera Hadir</h2>
                <p class="mt-2 text-gray-600">Data guru dan tenaga kependidikan akan segera ditampilkan.</p>
            </div>
        @endif
    </div>
</section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const search = document.getElementById('staff-search');
    const form = search ? search.closest('form') : null;
    if (!search || !form) return;

    let timer;
    search.addEventListener('input', function () {
        window.clearTimeout(timer);
        timer = window.setTimeout(function () {
            form.submit();
        }, 450);
    });
});
</script>
@endpush
