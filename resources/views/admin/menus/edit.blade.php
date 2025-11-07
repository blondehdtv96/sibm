@extends('layouts.admin-modern')

@section('title', 'Edit Menu')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Edit Menu</h2>
            <p class="text-sm text-gray-500 mt-1">Perbarui informasi menu</p>
        </div>
        <a href="{{ route('admin.menus.index') }}" class="inline-flex items-center px-4 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Kembali
        </a>
    </div>

    <!-- Form -->
    <form action="{{ route('admin.menus.update', $menu) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 space-y-6">
            <!-- Title -->
            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Judul Menu *</label>
                <input 
                    type="text" 
                    name="title" 
                    id="title" 
                    value="{{ old('title', $menu->title) }}"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('title') border-red-500 @enderror"
                    required
                >
                @error('title')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- Parent Menu -->
            <div>
                <label for="parent_id" class="block text-sm font-medium text-gray-700 mb-2">Parent Menu</label>
                <select 
                    name="parent_id" 
                    id="parent_id"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('parent_id') border-red-500 @enderror"
                >
                    <option value="">-- Menu Utama --</option>
                    @foreach($parentMenus as $parent)
                        <option value="{{ $parent->id }}" {{ old('parent_id', $menu->parent_id) == $parent->id ? 'selected' : '' }}>
                            {{ $parent->title }}
                        </option>
                    @endforeach
                </select>
                <p class="mt-1 text-xs text-gray-500">Kosongkan jika ini adalah menu utama</p>
                @error('parent_id')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <!-- URL Type -->
            <div x-data="{ urlType: '{{ old('url', $menu->url) ? 'url' : 'route' }}' }">
                <label class="block text-sm font-medium text-gray-700 mb-2">Tipe Link</label>
                <div class="flex gap-4 mb-4">
                    <label class="flex items-center">
                        <input type="radio" x-model="urlType" value="route" class="mr-2">
                        <span class="text-sm">Route Name</span>
                    </label>
                    <label class="flex items-center">
                        <input type="radio" x-model="urlType" value="url" class="mr-2">
                        <span class="text-sm">Custom URL</span>
                    </label>
                </div>

                <!-- Route Name -->
                <div x-show="urlType === 'route'" class="mb-4">
                    <label for="route_name" class="block text-sm font-medium text-gray-700 mb-2">Route Name</label>
                    <input 
                        type="text" 
                        name="route_name" 
                        id="route_name" 
                        value="{{ old('route_name', $menu->route_name) }}"
                        placeholder="e.g., info.about"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('route_name') border-red-500 @enderror"
                    >
                    <p class="mt-1 text-xs text-gray-500">Contoh: info.about, news.index, ppdb.register</p>
                    @error('route_name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Custom URL -->
                <div x-show="urlType === 'url'">
                    <label for="url" class="block text-sm font-medium text-gray-700 mb-2">Custom URL</label>
                    <input 
                        type="text" 
                        name="url" 
                        id="url" 
                        value="{{ old('url', $menu->url) }}"
                        placeholder="e.g., /about, https://example.com"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('url') border-red-500 @enderror"
                    >
                    <p class="mt-1 text-xs text-gray-500">Gunakan URL lengkap atau path relatif</p>
                    @error('url')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Icon -->
            <div>
                <label for="icon" class="block text-sm font-medium text-gray-700 mb-2">Icon (SVG)</label>
                <textarea 
                    name="icon" 
                    id="icon" 
                    rows="3"
                    placeholder='<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">...</svg>'
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent font-mono text-sm @error('icon') border-red-500 @enderror"
                >{{ old('icon', $menu->icon) }}</textarea>
                <p class="mt-1 text-xs text-gray-500">Paste SVG icon code (opsional)</p>
                @error('icon')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Order -->
                <div>
                    <label for="order" class="block text-sm font-medium text-gray-700 mb-2">Urutan *</label>
                    <input 
                        type="number" 
                        name="order" 
                        id="order" 
                        value="{{ old('order', $menu->order) }}"
                        min="0"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('order') border-red-500 @enderror"
                        required
                    >
                    @error('order')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Target -->
                <div>
                    <label for="target" class="block text-sm font-medium text-gray-700 mb-2">Target *</label>
                    <select 
                        name="target" 
                        id="target"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('target') border-red-500 @enderror"
                        required
                    >
                        <option value="_self" {{ old('target', $menu->target) === '_self' ? 'selected' : '' }}>Same Window</option>
                        <option value="_blank" {{ old('target', $menu->target) === '_blank' ? 'selected' : '' }}>New Tab</option>
                    </select>
                    @error('target')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Status -->
                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700 mb-2">Status *</label>
                    <select 
                        name="status" 
                        id="status"
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-ios-blue focus:border-transparent @error('status') border-red-500 @enderror"
                        required
                    >
                        <option value="active" {{ old('status', $menu->status) === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="inactive" {{ old('status', $menu->status) === 'inactive' ? 'selected' : '' }}>Inactive</option>
                    </select>
                    @error('status')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-between">
            <button type="button" onclick="deleteMenu()" class="px-6 py-2 bg-red-100 text-red-700 rounded-lg hover:bg-red-200 transition-colors">
                Hapus Menu
            </button>
            
            <div class="flex items-center space-x-4">
                <a href="{{ route('admin.menus.index') }}" class="px-6 py-2 bg-gray-100 text-gray-700 rounded-lg hover:bg-gray-200 transition-colors">
                    Batal
                </a>
                <button type="submit" class="px-6 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
                    Update Menu
                </button>
            </div>
        </div>
    </form>

    <!-- Hidden Delete Form -->
    <form id="deleteForm" action="{{ route('admin.menus.destroy', $menu) }}" method="POST" class="hidden">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection

@push('scripts')
<script>
function deleteMenu() {
    if (confirm('Apakah Anda yakin ingin menghapus menu ini? Submenu juga akan terhapus.')) {
        document.getElementById('deleteForm').submit();
    }
}
</script>
@endpush
