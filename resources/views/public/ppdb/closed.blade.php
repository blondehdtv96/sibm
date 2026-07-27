@extends('layouts.public-tailwind')

@section('title', 'SPMB Belum Dibuka - SMK Bina Mandiri Kota Bekasi')
@section('description', 'Informasi periode pendaftaran SPMB SMK Bina Mandiri Kota Bekasi.')

@section('content')
<section class="min-h-[70vh] bg-slate-50 pt-28 pb-16 sm:pt-36 sm:pb-24">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white text-center shadow-xl shadow-slate-900/5">
            <div class="bg-[#0B1F4B] px-6 py-12 text-white sm:px-12">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white/10 text-3xl" aria-hidden="true">⌛</div>
                <p class="mt-6 text-sm font-bold uppercase tracking-[.2em] text-amber-300">Informasi SPMB</p>
                <h1 class="mt-3 text-3xl font-black sm:text-4xl">Pendaftaran belum tersedia</h1>
                <p class="mx-auto mt-4 max-w-xl text-blue-100">Periode pendaftaran SPMB saat ini belum dibuka atau telah berakhir. Silakan pantau informasi resmi sekolah untuk jadwal berikutnya.</p>
            </div>
            <div class="p-6 text-left sm:p-10">
                <h2 class="text-xl font-black text-[#0B1F4B]">Yang dapat Anda lakukan</h2>
                <ul class="mt-5 space-y-3 text-sm leading-relaxed text-slate-600">
                    <li class="flex gap-3"><span class="font-bold text-[#3B82F6]" aria-hidden="true">✓</span><span>Periksa status pendaftaran yang sudah pernah dikirim.</span></li>
                    <li class="flex gap-3"><span class="font-bold text-[#3B82F6]" aria-hidden="true">✓</span><span>Siapkan dokumen persyaratan untuk periode pendaftaran berikutnya.</span></li>
                    <li class="flex gap-3"><span class="font-bold text-[#3B82F6]" aria-hidden="true">✓</span><span>Hubungi sekolah melalui kanal resmi untuk informasi jadwal SPMB.</span></li>
                </ul>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('ppdb.check-status') }}" class="inline-flex flex-1 items-center justify-center rounded-xl bg-[#3B82F6] px-5 py-3.5 font-bold text-white transition hover:bg-blue-600">Cek Status Pendaftaran</a>
                    <a href="{{ route('info.contact') }}" class="inline-flex flex-1 items-center justify-center rounded-xl border border-slate-300 px-5 py-3.5 font-bold text-[#1E3A8A] transition hover:border-blue-300 hover:bg-blue-50">Hubungi Sekolah</a>
                </div>
                <a href="{{ route('home') }}" class="mt-6 inline-flex font-bold text-[#1D4ED8] hover:text-[#0B1F4B]">← Kembali ke Beranda</a>
            </div>
        </div>
    </div>
</section>
@endsection