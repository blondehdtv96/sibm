<!-- 
    AJAX Loader Component
    Untuk menampilkan loading overlay saat AJAX request
-->

@php($ajaxLoaderLogoUrl = \App\Models\Setting::getLogo('site_logo'))

<!-- AJAX Loader Overlay -->
<div id="ajax-loader" class="hidden fixed inset-0 z-[9998] bg-black bg-opacity-50 flex items-center justify-center transition-opacity duration-300">
    <div class="bg-white rounded-2xl p-8 shadow-2xl">
        <div class="text-center">
            <!-- Spinner -->
            <div class="relative w-16 h-16 mx-auto mb-4">
                <div class="absolute inset-0 border-4 border-blue-200 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-transparent border-t-blue-600 border-r-blue-600 rounded-full animate-spin"></div>
                @if($ajaxLoaderLogoUrl)
                    <img src="{{ $ajaxLoaderLogoUrl }}" alt="Logo sekolah" class="ajax-loader-logo absolute inset-0 w-10 h-10 m-auto object-contain rounded-lg bg-white p-0.5" onerror="this.style.display='none';">
                @else
                    <svg class="ajax-loader-logo absolute inset-0 w-8 h-8 m-auto text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                @endif
            </div>
            
            <!-- Text -->
            <p id="ajax-loader-text" class="text-gray-700 font-medium">Memproses...</p>
        </div>
    </div>
</div>

<script>
(function () {
    let activeRequests = 0;
    let hideTimer;

    function beginLoading(text) {
        const loader = document.getElementById('ajax-loader');
        const loaderText = document.getElementById('ajax-loader-text');
        activeRequests++;
        window.clearTimeout(hideTimer);

        if (loader) {
            if (loaderText && text) loaderText.textContent = text;
            loader.classList.remove('hidden');
            loader.style.opacity = '1';
        }
    }

    function endLoading() {
        const loader = document.getElementById('ajax-loader');
        activeRequests = Math.max(0, activeRequests - 1);
        if (!loader || activeRequests > 0) return;

        loader.style.opacity = '0';
        hideTimer = window.setTimeout(function () {
            if (activeRequests === 0) loader.classList.add('hidden');
        }, 300);
    }

    window.showAjaxLoader = function (text = 'Memproses...') {
        beginLoading(text);
    };

    window.hideAjaxLoader = function () {
        endLoading();
    };

    if (window.__ajaxLoaderFetchPatched || typeof window.fetch !== 'function') return;
    window.__ajaxLoaderFetchPatched = true;
    const originalFetch = window.fetch;

    window.fetch = function (...args) {
        const request = args[0];
        const url = typeof request === 'string' ? request : (request && request.url) || '';
        const tracked = !url.includes('/chatbot');
        if (tracked) beginLoading();

        let fetchPromise;
        try {
            fetchPromise = originalFetch.apply(this, args);
        } catch (error) {
            if (tracked) endLoading();
            throw error;
        }

        return tracked ? fetchPromise.finally(endLoading) : fetchPromise;
    };
})();
</script>

<style>
.ajax-loader-logo {
    animation: ajax-loader-logo-pulse 1.8s ease-in-out infinite;
}

@keyframes ajax-loader-logo-pulse {
    0%, 100% { transform: scale(1) rotate(0deg); }
    50% { transform: scale(1.08) rotate(2deg); }
}

@media (prefers-reduced-motion: reduce) {
    .ajax-loader-logo,
    .animate-spin { animation: none; }
}

@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}
</style>
