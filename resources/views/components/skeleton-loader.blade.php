<!-- 
    Skeleton Loader Component
    Untuk menampilkan placeholder saat content loading
    
    Usage:
    @include('components.skeleton-loader', ['type' => 'card', 'count' => 3])
-->

@php
    $type = $type ?? 'card';
    $count = $count ?? 1;
@endphp

<div class="skeleton-loader">
    @for($i = 0; $i < $count; $i++)
        @if($type === 'card')
            <!-- Card Skeleton -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6 mb-4 animate-pulse">
                <div class="h-4 bg-gray-200 rounded w-3/4 mb-4"></div>
                <div class="h-3 bg-gray-200 rounded w-full mb-2"></div>
                <div class="h-3 bg-gray-200 rounded w-5/6 mb-2"></div>
                <div class="h-3 bg-gray-200 rounded w-4/6"></div>
            </div>
        @elseif($type === 'table')
            <!-- Table Row Skeleton -->
            <tr class="animate-pulse">
                <td class="px-6 py-4">
                    <div class="h-4 bg-gray-200 rounded w-24"></div>
                </td>
                <td class="px-6 py-4">
                    <div class="h-4 bg-gray-200 rounded w-32"></div>
                </td>
                <td class="px-6 py-4">
                    <div class="h-4 bg-gray-200 rounded w-40"></div>
                </td>
                <td class="px-6 py-4">
                    <div class="h-4 bg-gray-200 rounded w-20"></div>
                </td>
            </tr>
        @elseif($type === 'list')
            <!-- List Item Skeleton -->
            <div class="flex items-center space-x-4 p-4 mb-2 animate-pulse">
                <div class="w-12 h-12 bg-gray-200 rounded-full"></div>
                <div class="flex-1">
                    <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
                    <div class="h-3 bg-gray-200 rounded w-1/2"></div>
                </div>
            </div>
        @elseif($type === 'text')
            <!-- Text Skeleton -->
            <div class="animate-pulse mb-4">
                <div class="h-4 bg-gray-200 rounded w-full mb-2"></div>
                <div class="h-4 bg-gray-200 rounded w-5/6 mb-2"></div>
                <div class="h-4 bg-gray-200 rounded w-4/6"></div>
            </div>
        @elseif($type === 'image')
            <!-- Image Skeleton -->
            <div class="bg-gray-200 rounded-lg animate-pulse" style="aspect-ratio: 16/9;"></div>
        @endif
    @endfor
</div>

<style>
@keyframes pulse {
    0%, 100% {
        opacity: 1;
    }
    50% {
        opacity: 0.5;
    }
}

.animate-pulse {
    animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite;
}
</style>
