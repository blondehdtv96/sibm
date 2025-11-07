@extends('layouts.admin-modern')

@section('title', 'Menu Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Menu Management</h2>
            <p class="text-sm text-gray-500 mt-1">Kelola menu navigasi website</p>
        </div>
        <a href="{{ route('admin.menus.create') }}" class="inline-flex items-center px-4 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Tambah Menu
        </a>
    </div>

    <!-- Menu List -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
        @if($menus->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50 border-b border-gray-200">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Menu</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">URL/Route</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Order</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                        @foreach($menus as $menu)
                            <!-- Parent Menu -->
                            <tr class="hover:bg-gray-50">
                                <td class="px-6 py-4">
                                    <div class="flex items-center">
                                        @if($menu->icon)
                                            <span class="mr-2">{!! $menu->icon !!}</span>
                                        @endif
                                        <span class="font-medium text-gray-900">{{ $menu->title }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $menu->route_name ?: $menu->url ?: '-' }}
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    {{ $menu->order }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $menu->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                        {{ ucfirst($menu->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-right space-x-2">
                                    <a href="{{ route('admin.menus.edit', $menu) }}" class="text-blue-600 hover:text-blue-800">
                                        Edit
                                    </a>
                                    <button onclick="deleteMenu({{ $menu->id }})" class="text-red-600 hover:text-red-800">
                                        Delete
                                    </button>
                                </td>
                            </tr>

                            <!-- Child Menus -->
                            @foreach($menu->children as $child)
                                <tr class="hover:bg-gray-50 bg-gray-50/50">
                                    <td class="px-6 py-4">
                                        <div class="flex items-center pl-8">
                                            <svg class="w-4 h-4 mr-2 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                            </svg>
                                            @if($child->icon)
                                                <span class="mr-2">{!! $child->icon !!}</span>
                                            @endif
                                            <span class="text-gray-700">{{ $child->title }}</span>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $child->route_name ?: $child->url ?: '-' }}
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-600">
                                        {{ $child->order }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $child->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                            {{ ucfirst($child->status) }}
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 text-right space-x-2">
                                        <a href="{{ route('admin.menus.edit', $child) }}" class="text-blue-600 hover:text-blue-800">
                                            Edit
                                        </a>
                                        <button onclick="deleteMenu({{ $child->id }})" class="text-red-600 hover:text-red-800">
                                            Delete
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="text-center py-12">
                <svg class="w-16 h-16 mx-auto text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                </svg>
                <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada menu</h3>
                <p class="text-gray-500 mb-4">Mulai dengan menambahkan menu pertama Anda</p>
                <a href="{{ route('admin.menus.create') }}" class="inline-flex items-center px-4 py-2 bg-ios-blue text-white rounded-lg hover:bg-blue-600 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Tambah Menu
                </a>
            </div>
        @endif
    </div>
</div>

<!-- Hidden Delete Form -->
<form id="deleteForm" method="POST" class="hidden">
    @csrf
    @method('DELETE')
</form>
@endsection

@push('scripts')
<script>
function deleteMenu(id) {
    if (confirm('Apakah Anda yakin ingin menghapus menu ini? Submenu juga akan terhapus.')) {
        const form = document.getElementById('deleteForm');
        form.action = `/admin/menus/${id}`;
        form.submit();
    }
}
</script>
@endpush
