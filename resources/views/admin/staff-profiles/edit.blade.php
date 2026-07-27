@extends('layouts.admin-modern')

@section('title', 'Edit Profil Guru dan Karyawan')

@section('content')
<div class="space-y-6">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Profil</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi {{ $staffProfile->name }}.</p>
        </div>
        <a href="{{ route('admin.staff-profiles.index') }}" class="px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200">Kembali</a>
    </div>

    @include('admin.staff-profiles._form')
</div>
@endsection
