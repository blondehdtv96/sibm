<!-- 
    Page Loader Component
    Animasi loading saat halaman di-refresh atau berpindah
-->
<div id="page-loader" class="fixed inset-0 z-[9999] bg-white flex items-center justify-center transition-opacity duration-500">
    <div class="text-center">
        <!-- Animated Logo/Spinner -->
        <div class="relative w-24 h-24 mx-auto mb-6">
            <!-- Outer Ring -->
            <div class="absolute inset-0 border-4 border-blue-200 rounded-full"></div>
            
            <!-- Spinning Ring -->
            <div class="absolute inset-0 border-4 border-transparent border-t-blue-600 border-r-blue-600 rounded-full animate-spin"></div>
            
            <!-- Inner Icon -->
            <div class="absolute inset-0 flex items-center justify-center">
                <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
        </div>
        
        <!-- Loading Text -->
        <div class="space-y-2">
            <h3 class="text-lg font-semibold text-gray-900">Memuat Halaman</h3>
            <div class="flex items-center justify-center space-x-1">
                <div class="w-2 h-2 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                <div class="w-2 h-2 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                <div class="w-2 h-2 bg-blue-600 rounded-full animate-bounce" style="animation-delay: 300ms"></div>
            </div>
        </div>
    </div>
</div>

<script>
// Hide loader when page is fully loaded
window.addEventListener('load', function() {
    const loader = document.getElementById('page-loader');
    if (loader) {
        loader.style.opacity = '0';
        setTimeout(() => {
            loader.style.display = 'none';
        }, 500);
    }
});

// Show loader on page navigation
document.addEventListener('DOMContentLoaded', function() {
    // Show loader when clicking links (except hash links and external)
    document.querySelectorAll('a').forEach(link => {
        link.addEventListener('click', function(e) {
            const href = this.getAttribute('href');
            
            // Skip if it's a hash link, external link, or has target="_blank"
            if (!href || 
                href.startsWith('#') || 
                href.startsWith('javascript:') ||
                this.getAttribute('target') === '_blank' ||
                href.startsWith('http') && !href.includes(window.location.hostname)) {
                return;
            }
            
            // Show loader
            const loader = document.getElementById('page-loader');
            if (loader) {
                loader.style.display = 'flex';
                loader.style.opacity = '1';
            }
        });
    });
    
    // Show loader on form submit
    document.querySelectorAll('form').forEach(form => {
        form.addEventListener('submit', function(e) {
            // Skip if form has data-no-loader attribute
            if (this.hasAttribute('data-no-loader')) {
                return;
            }
            
            const loader = document.getElementById('page-loader');
            if (loader) {
                loader.style.display = 'flex';
                loader.style.opacity = '1';
            }
        });
    });
});
</script>

<style>
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

@keyframes bounce {
    0%, 100% {
        transform: translateY(0);
    }
    50% {
        transform: translateY(-10px);
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

.animate-bounce {
    animation: bounce 1s infinite;
}
</style>
