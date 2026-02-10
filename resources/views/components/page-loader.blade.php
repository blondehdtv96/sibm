<!-- Page Loader - Muncul saat refresh -->
<div id="page-loader" class="fixed inset-0 z-[99999] bg-gradient-to-br from-blue-600 via-indigo-700 to-purple-800 flex items-center justify-center transition-opacity duration-300">
    <div class="text-center">
        <!-- Animated Spinner -->
        <div class="relative w-24 h-24 mx-auto mb-6">
            <!-- Outer Ring -->
            <div class="absolute inset-0 border-4 border-white/20 rounded-full"></div>
            
            <!-- Spinning Ring -->
            <div class="absolute inset-0 border-4 border-transparent border-t-white border-r-white rounded-full animate-spin"></div>
            
            <!-- Inner Logo -->
            <div class="absolute inset-0 flex items-center justify-center">
                <svg class="w-12 h-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                </svg>
            </div>
        </div>
        
        <!-- Loading Text -->
        <div class="space-y-3">
            <h3 class="text-xl font-bold text-white">Memuat Halaman</h3>
            <div class="flex items-center justify-center space-x-2">
                <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 0ms"></div>
                <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 150ms"></div>
                <div class="w-2 h-2 bg-white rounded-full animate-bounce" style="animation-delay: 300ms"></div>
            </div>
        </div>
    </div>
</div>

<script>
(function() {
    'use strict';
    
    const loader = document.getElementById('page-loader');
    let isHiding = false;
    
    // Function to hide loader
    function hideLoader() {
        if (isHiding || !loader) return;
        isHiding = true;
        
        loader.style.opacity = '0';
        setTimeout(function() {
            loader.style.display = 'none';
            isHiding = false;
        }, 300);
    }
    
    // Function to show loader
    function showLoader() {
        if (!loader) return;
        loader.style.display = 'flex';
        loader.style.opacity = '1';
        isHiding = false;
    }
    
    // Show loader immediately on page load
    showLoader();
    
    // Hide loader when page is fully loaded
    window.addEventListener('load', function() {
        // Add small delay for smooth transition
        setTimeout(hideLoader, 300);
    });
    
    // Hide loader on DOMContentLoaded (faster)
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', function() {
            setTimeout(hideLoader, 200);
        });
    } else {
        // Document already loaded
        setTimeout(hideLoader, 200);
    }
    
    // Handle page visibility (back/forward navigation)
    document.addEventListener('visibilitychange', function() {
        if (!document.hidden) {
            setTimeout(hideLoader, 100);
        }
    });
    
    // Handle pageshow event (back/forward from cache)
    window.addEventListener('pageshow', function(event) {
        if (event.persisted) {
            // Page loaded from cache
            hideLoader();
        }
    });
    
    // Show loader on navigation (optional - for smooth transitions)
    document.addEventListener('click', function(e) {
        const link = e.target.closest('a');
        if (link && link.href && 
            !link.href.startsWith('#') && 
            !link.href.startsWith('javascript:') &&
            link.target !== '_blank' &&
            link.href.includes(window.location.hostname)) {
            
            // Show loader with small delay to prevent flash on fast navigation
            setTimeout(function() {
                if (!isHiding) {
                    showLoader();
                }
            }, 50);
        }
    });
    
    // Emergency fallback - force hide after 3 seconds
    setTimeout(function() {
        if (!isHiding) {
            console.warn('Loader emergency timeout - forcing hide');
            hideLoader();
        }
    }, 3000);
})();
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
        animation-timing-function: cubic-bezier(0.8, 0, 1, 1);
    }
    50% {
        transform: translateY(-25%);
        animation-timing-function: cubic-bezier(0, 0, 0.2, 1);
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}

.animate-bounce {
    animation: bounce 1s infinite;
}
</style>
