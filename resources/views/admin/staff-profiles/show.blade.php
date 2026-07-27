@extends('layouts.admin-modern')

@section('title', 'Detail Profil')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-2xl font-bold text-gray-900">Detail Profil</h2>
        <a href="{{ route('admin.staff-profiles.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Kembali</a>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-8">
        <div class="flex flex-col sm:flex-row items-center sm:items-start gap-6">
            @if($staffProfile->photo)
                <img src="{{ $staffProfile->photo_url }}" alt="{{ $staffProfile->name }}" class="w-36 h-36 rounded-2xl object-cover">
            @else
                <div class="w-36 h-36 rounded-2xl bg-blue-100 text-blue-600 flex items-center justify-center text-4xl font-bold">{{ strtoupper(substr($staffProfile->name, 0, 1)) }}</div>
            @endif
            <div class="text-center sm:text-left">
                <h3 class="text-2xl font-bold text-gray-900">{{ $staffProfile->name }}</h3>
                <p class="text-blue-600 font-medium mt-1">{{ $staffProfile->position }}</p>
                <span class="inline-block mt-3 px-3 py-1 text-xs font-semibold rounded-full bg-gray-100 text-gray-700">{{ $staffProfile->category }}</span>
                <span class="inline-block mt-3 px-3 py-1 text-xs font-semibold rounded-full {{ $staffProfile->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-700' }}">{{ $staffProfile->status === 'active' ? 'Aktif' : 'Tidak Aktif' }}</span>
            </div>
        </div>
        @if($staffProfile->bio)
            <div class="mt-8 pt-6 border-t border-gray-200 text-gray-700 whitespace-pre-line">{{ $staffProfile->bio }}</div>
        @endif
        <div class="mt-8 flex gap-3">
            <a href="{{ route('admin.staff-profiles.edit', $staffProfile) }}" class="px-4 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600">Edit Profil</a>
            <a href="{{ route('public.staff-profiles.index') }}" target="_blank" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Lihat Halaman Publik</a>
        </div>
    </div>
</div>
@endsection
