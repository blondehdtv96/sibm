@extends('layouts.public-tailwind')

@php
    $spmbYear = \Carbon\Carbon::parse($activeSetting->registration_start)->year;
@endphp

@section('title', 'SPMB ' . $spmbYear . ' Segera Dibuka - SMK Bina Mandiri Kota Bekasi')
@section('description', 'Jadwal pendaftaran SPMB ' . $spmbYear . ' SMK Bina Mandiri Kota Bekasi.')

@section('content')
<section class="min-h-[70vh] bg-slate-50 pt-28 pb-16 sm:pt-36 sm:pb-24">
    <div class="mx-auto max-w-3xl px-4 sm:px-6 lg:px-8">
        <div class="overflow-hidden rounded-3xl border border-slate-200 bg-white text-center shadow-xl shadow-slate-900/5">
            <div class="bg-[#0B1F4B] px-6 py-12 text-white sm:px-12">
                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-white/10 text-3xl" aria-hidden="true">🗓</div>
                <p class="mt-6 text-sm font-bold uppercase tracking-[.2em] text-amber-300">SPMB {{ $spmbYear }}</p>
                <h1 class="mt-3 text-3xl font-black sm:text-4xl">Pendaftaran segera dibuka</h1>
                <p class="mx-auto mt-4 max-w-xl text-blue-100">Siapkan data dan dokumen Anda. Pendaftaran SPMB akan tersedia sesuai jadwal resmi sekolah.</p>
            </div>
            <div class="p-6 sm:p-10">
                <p class="text-sm font-bold uppercase tracking-[.16em] text-slate-500">Pendaftaran dibuka</p>
                <time datetime="{{ \Carbon\Carbon::parse($activeSetting->registration_start)->toDateString() }}" class="mt-2 block text-2xl font-black text-[#1E3A8A] sm:text-3xl">{{ \Carbon\Carbon::parse($activeSetting->registration_start)->translatedFormat('d F Y') }}</time>
                <p class="mt-2 text-sm text-slate-600">Periode berakhir {{ \Carbon\Carbon::parse($activeSetting->registration_end)->translatedFormat('d F Y') }}.</p>
                @if(!empty($activeSetting->requirements))
                    <div class="mt-8 rounded-2xl bg-blue-50 p-5 text-left"><h2 class="font-black text-[#0B1F4B]">Persiapkan dokumen</h2><ul class="mt-3 space-y-2 text-sm text-slate-600">@foreach(is_string($activeSetting->requirements) ? json_decode($activeSetting->requirements, true) : $activeSetting->requirements as $requirement)<li class="flex gap-2"><span class="text-[#3B82F6]">✓</span><span>{{ $requirement }}</span></li>@endforeach</ul></div>
                @endif
                <div class="mt-8 flex flex-col gap-3 sm:flex-row"><a href="{{ route('ppdb.check-status') }}" class="inline-flex flex-1 items-center justify-center rounded-xl bg-[#3B82F6] px-5 py-3.5 font-bold text-white transition hover:bg-blue-600">Cek Status Pendaftaran</a><a href="{{ route('home') }}" class="inline-flex flex-1 items-center justify-center rounded-xl border border-slate-300 px-5 py-3.5 font-bold text-[#1E3A8A] transition hover:border-blue-300 hover:bg-blue-50">Kembali ke Beranda</a></div>
            </div>
        </div>
    </div>
</section>
@endsection