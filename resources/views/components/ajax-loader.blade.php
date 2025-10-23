<!-- 
    AJAX Loader Component
    Untuk menampilkan loading overlay saat AJAX request
-->

<!-- AJAX Loader Overlay -->
<div id="ajax-loader" class="hidden fixed inset-0 z-[9998] bg-black bg-opacity-50 flex items-center justify-center transition-opacity duration-300">
    <div class="bg-white rounded-2xl p-8 shadow-2xl">
        <div class="text-center">
            <!-- Spinner -->
            <div class="relative w-16 h-16 mx-auto mb-4">
                <div class="absolute inset-0 border-4 border-blue-200 rounded-full"></div>
                <div class="absolute inset-0 border-4 border-transparent border-t-blue-600 border-r-blue-600 rounded-full animate-spin"></div>
            </div>
            
            <!-- Text -->
            <p id="ajax-loader-text" class="text-gray-700 font-medium">Memproses...</p>
        </div>
    </div>
</div>

<script>
// Global functions to show/hide AJAX loader
window.showAjaxLoader = function(text = 'Memproses...') {
    const loader = document.getElementById('ajax-loader');
    const loaderText = document.getElementById('ajax-loader-text');
    
    if (loader) {
        loaderText.textContent = text;
        loader.classList.remove('hidden');
        setTimeout(() => {
            loader.style.opacity = '1';
        }, 10);
    }
};

window.hideAjaxLoader = function() {
    const loader = document.getElementById('ajax-loader');
    
    if (loader) {
        loader.style.opacity = '0';
        setTimeout(() => {
            loader.classList.add('hidden');
        }, 300);
    }
};

// Auto-detect fetch requests and show loader
(function() {
    const originalFetch = window.fetch;
    
    window.fetch = function(...args) {
        // Show loader for fetch requests (except chatbot)
        const url = args[0];
        if (typeof url === 'string' && !url.includes('/chatbot')) {
            showAjaxLoader();
        }
        
        return originalFetch.apply(this, args)
            .then(response => {
                hideAjaxLoader();
                return response;
            })
            .catch(error => {
                hideAjaxLoader();
                throw error;
            });
    };
})();
</script>

<style>
@keyframes spin {
    to {
        transform: rotate(360deg);
    }
}

.animate-spin {
    animation: spin 1s linear infinite;
}
</style>
