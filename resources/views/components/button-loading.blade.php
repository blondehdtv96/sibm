<!-- 
    Button Loading Component
    Untuk menampilkan loading state pada button
    
    Usage:
    <button type="submit" class="btn-loading" data-loading-text="Menyimpan...">
        Simpan
    </button>
-->

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle button loading state
    document.querySelectorAll('.btn-loading').forEach(button => {
        const form = button.closest('form');
        
        if (form) {
            form.addEventListener('submit', function(e) {
                // Skip if button is already disabled
                if (button.disabled) {
                    return;
                }
                
                // Get loading text
                const loadingText = button.getAttribute('data-loading-text') || 'Memproses...';
                const originalText = button.innerHTML;
                
                // Disable button and show loading
                button.disabled = true;
                button.classList.add('opacity-75', 'cursor-not-allowed');
                
                // Add spinner and change text
                button.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-3 h-5 w-5 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                    ${loadingText}
                `;
                
                // Store original text for potential reset
                button.setAttribute('data-original-text', originalText);
            });
        }
    });
    
    // Handle AJAX button loading
    window.showButtonLoading = function(button, loadingText = 'Memproses...') {
        if (!button) return;
        
        const originalText = button.innerHTML;
        button.disabled = true;
        button.classList.add('opacity-75', 'cursor-not-allowed');
        
        button.innerHTML = `
            <svg class="animate-spin -ml-1 mr-3 h-5 w-5 inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            ${loadingText}
        `;
        
        button.setAttribute('data-original-text', originalText);
    };
    
    window.hideButtonLoading = function(button) {
        if (!button) return;
        
        const originalText = button.getAttribute('data-original-text');
        if (originalText) {
            button.innerHTML = originalText;
        }
        
        button.disabled = false;
        button.classList.remove('opacity-75', 'cursor-not-allowed');
    };
});
</script>
