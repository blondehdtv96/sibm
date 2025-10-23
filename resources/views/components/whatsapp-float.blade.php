{{-- WhatsApp Floating Button Component --}}
@props([
    'phone' => '6281292760717',
    'message' => 'Halo, saya ingin bertanya tentang SMK Bina Mandiri Bekasi',
    'position' => 'right' // left or right
])

<div x-data="{ 
    open: false, 
    phone: '{{ $phone }}',
    message: '{{ $message }}',
    showTooltip: false,
    lastClickTime: 0,
    isDisabled: false,
    
    openWhatsApp(customMessage = null) {
        const now = Date.now();
        const timeDiff = now - this.lastClickTime;
        
        // Rate limiting: prevent clicks within 3 seconds
        if (timeDiff < 3000) {
            this.showRateLimitWarning();
            return;
        }
        
        this.lastClickTime = now;
        this.isDisabled = true;
        
        const messageToSend = customMessage || this.message;
        const url = 'https://wa.me/' + this.phone + '?text=' + encodeURIComponent(messageToSend);
        
        // Open WhatsApp with a small delay to prevent rapid clicks
        setTimeout(() => {
            window.open(url, '_blank');
            this.isDisabled = false;
        }, 500);
    },
    
    showRateLimitWarning() {
        // Show a temporary warning
        const warning = document.createElement('div');
        warning.className = 'fixed top-4 right-4 bg-red-500 text-white px-4 py-2 rounded-lg shadow-lg z-50 animate-pulse';
        warning.textContent = 'Mohon tunggu sebentar sebelum mencoba lagi';
        document.body.appendChild(warning);
        
        setTimeout(() => {
            warning.remove();
        }, 2000);
    }
}" 
    class="fixed {{ $position === 'left' ? 'left-6' : 'right-6' }} bottom-6 z-50"
    @mouseenter="showTooltip = true"
    @mouseleave="showTooltip = false">
    
    <!-- Tooltip -->
    <div x-show="showTooltip" 
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="opacity-0 translate-x-2"
         x-transition:enter-end="opacity-100 translate-x-0"
         x-transition:leave="transition ease-in duration-150"
         x-transition:leave-start="opacity-100 translate-x-0"
         x-transition:leave-end="opacity-0 translate-x-2"
         class="absolute {{ $position === 'left' ? 'left-full ml-4' : 'right-full mr-4' }} bottom-0 mb-2 px-4 py-2 bg-gray-900 text-white text-sm rounded-lg shadow-lg whitespace-nowrap">
        💬 Chat via WhatsApp
        <div class="absolute {{ $position === 'left' ? 'left-0 -ml-2' : 'right-0 -mr-2' }} bottom-4 w-0 h-0 border-t-8 border-t-transparent border-b-8 border-b-transparent {{ $position === 'left' ? 'border-r-8 border-r-gray-900' : 'border-l-8 border-l-gray-900' }}"></div>
    </div>

    <!-- Chat Box - Removed (Direct WhatsApp link now) -->
    <div x-show="false" 
         class="hidden">
        
        <!-- Header -->
        <div class="bg-gradient-to-r from-green-500 to-green-600 p-4 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <div class="w-12 h-12 bg-white rounded-full flex items-center justify-center">
                        <svg class="w-7 h-7 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                        </svg>
                    </div>
                    <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-400 border-2 border-white rounded-full"></div>
                </div>
                <div>
                    <h3 class="text-white font-semibold text-lg">SMK Bina Mandiri</h3>
                    <p class="text-green-100 text-xs">Online - Siap membantu Anda</p>
                </div>
            </div>
            <button @click="open = false" class="text-white hover:text-green-100 transition-colors">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <!-- Body -->
        <div class="p-4 bg-gray-50 space-y-3">
            <!-- Admin Message -->
            <div class="flex items-start gap-2">
                <div class="flex-shrink-0 w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                </div>
                <div class="flex-1">
                    <div class="bg-white rounded-lg rounded-tl-none p-3 shadow-sm">
                        <p class="text-sm text-gray-800">Halo! 👋</p>
                        <p class="text-sm text-gray-800 mt-1">Ada yang bisa kami bantu?</p>
                        <p class="text-xs text-gray-500 mt-2">Tim Admin SMK Bina Mandiri</p>
                    </div>
                    <p class="text-xs text-gray-500 mt-1 ml-2">Baru saja</p>
                </div>
            </div>

            <!-- Quick Replies -->
            <div class="space-y-2">
                <p class="text-xs text-gray-600 font-medium px-2">Pilih topik:</p>
                <button @click="openWhatsApp('Halo, saya ingin bertanya tentang pendaftaran PPDB')" 
                        :disabled="isDisabled"
                        :class="isDisabled ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50'"
                        class="w-full text-left px-4 py-2.5 bg-white rounded-lg shadow-sm border border-gray-200 transition-colors group">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center group-hover:bg-blue-200 transition-colors">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-700 font-medium">Pendaftaran PPDB</span>
                    </div>
                </button>

                <button @click="openWhatsApp('Halo, saya ingin mengetahui informasi program keahlian')" 
                        :disabled="isDisabled"
                        :class="isDisabled ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50'"
                        class="w-full text-left px-4 py-2.5 bg-white rounded-lg shadow-sm border border-gray-200 transition-colors group">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-purple-100 rounded-full flex items-center justify-center group-hover:bg-purple-200 transition-colors">
                            <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-700 font-medium">Program Keahlian</span>
                    </div>
                </button>

                <button @click="openWhatsApp('Halo, saya ingin bertanya tentang fasilitas sekolah')" 
                        :disabled="isDisabled"
                        :class="isDisabled ? 'opacity-50 cursor-not-allowed' : 'hover:bg-gray-50'"
                        class="w-full text-left px-4 py-2.5 bg-white rounded-lg shadow-sm border border-gray-200 transition-colors group">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center group-hover:bg-green-200 transition-colors">
                            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                            </svg>
                        </div>
                        <span class="text-sm text-gray-700 font-medium">Fasilitas Sekolah</span>
                    </div>
                </button>
            </div>
        </div>

        <!-- Footer -->
        <div class="p-4 bg-white border-t border-gray-200">
            <button @click="openWhatsApp()" 
                    :disabled="isDisabled"
                    :class="isDisabled ? 'opacity-50 cursor-not-allowed' : 'hover:from-green-600 hover:to-green-700 hover:scale-105'"
                    class="flex items-center justify-center gap-2 w-full px-4 py-3 bg-gradient-to-r from-green-500 to-green-600 text-white font-semibold rounded-lg shadow-md transition-all duration-200 transform">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                </svg>
                <span x-show="!isDisabled">Chat via WhatsApp</span>
                <span x-show="isDisabled" class="flex items-center gap-2">
                    <svg class="animate-spin h-4 w-4" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    Tunggu...
                </span>
            </button>
            <p class="text-xs text-gray-500 text-center mt-2">Biasanya membalas dalam beberapa menit</p>
        </div>
    </div>

    <!-- Main Button - Direct WhatsApp Link -->
    <button @click="openWhatsApp()" 
            :disabled="isDisabled"
            :class="isDisabled ? 'opacity-50 cursor-not-allowed' : 'hover:from-green-600 hover:to-green-700 hover:scale-110'"
            class="relative w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-full shadow-2xl flex items-center justify-center transition-all duration-300 transform group">
        <!-- Pulse Animation -->
        <span x-show="!isDisabled" class="absolute inset-0 rounded-full bg-green-400 animate-ping opacity-75"></span>
        
        <!-- Loading Spinner (when disabled) -->
        <svg x-show="isDisabled" class="absolute w-8 h-8 text-white animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="m4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        
        <!-- WhatsApp Icon -->
        <svg x-show="!isDisabled" class="relative w-8 h-8 text-white transition-transform duration-300 group-hover:scale-110" fill="currentColor" viewBox="0 0 24 24">
            <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
        </svg>

        <!-- Badge Notification -->
        <span x-show="!isDisabled" class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full flex items-center justify-center border-2 border-white animate-bounce">
            !
        </span>
    </button>
</div>

<style>
    @keyframes ping {
        75%, 100% {
            transform: scale(1.5);
            opacity: 0;
        }
    }
    
    .animate-ping {
        animation: ping 1.5s cubic-bezier(0, 0, 0.2, 1) infinite;
    }
</style>
