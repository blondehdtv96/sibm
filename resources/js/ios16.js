/**
 * iOS 16 Design System - JavaScript Components
 * Provides interactive components and utilities for the iOS 16 design system
 */

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    initializeComponents();
});

/**
 * Initialize all iOS 16 components
 */
function initializeComponents() {
    initializeTooltips();
    initializeModals();
    initializeDropdowns();
    initializeTabs();
    initializeAccordions();
    initializeImageLightbox();
    initializeFormValidation();
    initializePageTransitions();
    initializeLoadingStates();
    initializeTouchInteractions();
    initializeScrollAnimations();
    initializeKeyboardShortcuts();
    initializeAccessibility();
}

/**
 * Tooltip Component
 */
function initializeTooltips() {
    const tooltips = document.querySelectorAll('[data-tooltip]');
    
    tooltips.forEach(element => {
        const tooltipText = element.getAttribute('data-tooltip');
        const position = element.getAttribute('data-tooltip-position') || 'top';
        
        // Create tooltip element
        const tooltip = document.createElement('div');
        tooltip.className = 'ios-tooltip';
        tooltip.textContent = tooltipText;
        tooltip.setAttribute('data-position', position);
        document.body.appendChild(tooltip);
        
        // Show tooltip on hover
        element.addEventListener('mouseenter', (e) => {
            showTooltip(tooltip, e.target, position);
        });
        
        element.addEventListener('mouseleave', () => {
            hideTooltip(tooltip);
        });
    });
}

function showTooltip(tooltip, target, position) {
    const rect = target.getBoundingClientRect();
    const tooltipRect = tooltip.getBoundingClientRect();
    
    let top, left;
    
    switch(position) {
        case 'top':
            top = rect.top - tooltipRect.height - 8;
            left = rect.left + (rect.width - tooltipRect.width) / 2;
            break;
        case 'bottom':
            top = rect.bottom + 8;
            left = rect.left + (rect.width - tooltipRect.width) / 2;
            break;
        case 'left':
            top = rect.top + (rect.height - tooltipRect.height) / 2;
            left = rect.left - tooltipRect.width - 8;
            break;
        case 'right':
            top = rect.top + (rect.height - tooltipRect.height) / 2;
            left = rect.right + 8;
            break;
    }
    
    tooltip.style.top = `${top + window.scrollY}px`;
    tooltip.style.left = `${left + window.scrollX}px`;
    tooltip.classList.add('show');
}

function hideTooltip(tooltip) {
    tooltip.classList.remove('show');
}

/**
 * Modal Component
 */
function initializeModals() {
    const modalTriggers = document.querySelectorAll('[data-modal-target]');
    const modals = document.querySelectorAll('.ios-modal');
    
    modalTriggers.forEach(trigger => {
        trigger.addEventListener('click', (e) => {
            e.preventDefault();
            const targetId = trigger.getAttribute('data-modal-target');
            const modal = document.getElementById(targetId);
            if (modal) {
                showModal(modal);
            }
        });
    });
    
    modals.forEach(modal => {
        // Close on backdrop click
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                hideModal(modal);
            }
        });
        
        // Close on close button click
        const closeButtons = modal.querySelectorAll('[data-modal-close]');
        closeButtons.forEach(button => {
            button.addEventListener('click', () => {
                hideModal(modal);
            });
        });
    });
    
    // Close on escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape') {
            const openModal = document.querySelector('.ios-modal.show');
            if (openModal) {
                hideModal(openModal);
            }
        }
    });
}

function showModal(modal) {
    modal.classList.add('show');
    document.body.style.overflow = 'hidden';
    
    // Focus trap
    const focusableElements = modal.querySelectorAll(
        'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
    );
    if (focusableElements.length > 0) {
        focusableElements[0].focus();
    }
}

function hideModal(modal) {
    modal.classList.remove('show');
    document.body.style.overflow = '';
}

/**
 * Dropdown Component
 */
function initializeDropdowns() {
    const dropdowns = document.querySelectorAll('.ios-dropdown');
    
    dropdowns.forEach(dropdown => {
        const trigger = dropdown.querySelector('.dropdown-trigger');
        const menu = dropdown.querySelector('.dropdown-menu');
        
        if (trigger && menu) {
            trigger.addEventListener('click', (e) => {
                e.preventDefault();
                e.stopPropagation();
                
                // Close other dropdowns
                document.querySelectorAll('.ios-dropdown.open').forEach(other => {
                    if (other !== dropdown) {
                        other.classList.remove('open');
                    }
                });
                
                dropdown.classList.toggle('open');
            });
        }
    });
    
    // Close dropdowns when clicking outside
    document.addEventListener('click', () => {
        document.querySelectorAll('.ios-dropdown.open').forEach(dropdown => {
            dropdown.classList.remove('open');
        });
    });
}

/**
 * Tab Component
 */
function initializeTabs() {
    const tabGroups = document.querySelectorAll('.ios-tabs');
    
    tabGroups.forEach(tabGroup => {
        const tabs = tabGroup.querySelectorAll('.tab-trigger');
        const panels = tabGroup.querySelectorAll('.tab-panel');
        
        tabs.forEach(tab => {
            tab.addEventListener('click', (e) => {
                e.preventDefault();
                const targetId = tab.getAttribute('data-tab-target');
                
                // Remove active class from all tabs and panels
                tabs.forEach(t => t.classList.remove('active'));
                panels.forEach(p => p.classList.remove('active'));
                
                // Add active class to clicked tab and corresponding panel
                tab.classList.add('active');
                const targetPanel = document.getElementById(targetId);
                if (targetPanel) {
                    targetPanel.classList.add('active');
                }
            });
        });
    });
}

/**
 * Accordion Component
 */
function initializeAccordions() {
    const accordions = document.querySelectorAll('.ios-accordion');
    
    accordions.forEach(accordion => {
        const items = accordion.querySelectorAll('.accordion-item');
        
        items.forEach(item => {
            const header = item.querySelector('.accordion-header');
            const content = item.querySelector('.accordion-content');
            
            if (header && content) {
                header.addEventListener('click', () => {
                    const isOpen = item.classList.contains('open');
                    
                    // Close all items if not allowing multiple
                    if (!accordion.hasAttribute('data-multiple')) {
                        items.forEach(otherItem => {
                            otherItem.classList.remove('open');
                        });
                    }
                    
                    // Toggle current item
                    if (!isOpen) {
                        item.classList.add('open');
                    }
                });
            }
        });
    });
}

/**
 * Image Lightbox Component
 */
function initializeImageLightbox() {
    const images = document.querySelectorAll('[data-lightbox]');
    
    images.forEach(image => {
        image.addEventListener('click', (e) => {
            e.preventDefault();
            const src = image.getAttribute('data-lightbox') || image.src;
            const alt = image.alt || '';
            showLightbox(src, alt);
        });
    });
}

function showLightbox(src, alt) {
    const lightbox = document.createElement('div');
    lightbox.className = 'ios-lightbox';
    lightbox.innerHTML = `
        <div class="lightbox-backdrop"></div>
        <div class="lightbox-content">
            <img src="${src}" alt="${alt}" class="lightbox-image">
            <button class="lightbox-close" aria-label="Close">
                <svg width="24" height="24" fill="currentColor" viewBox="0 0 20 20">
                    <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"/>
                </svg>
            </button>
        </div>
    `;
    
    document.body.appendChild(lightbox);
    document.body.style.overflow = 'hidden';
    
    // Close handlers
    const closeButton = lightbox.querySelector('.lightbox-close');
    const backdrop = lightbox.querySelector('.lightbox-backdrop');
    
    const closeLightbox = () => {
        lightbox.remove();
        document.body.style.overflow = '';
    };
    
    closeButton.addEventListener('click', closeLightbox);
    backdrop.addEventListener('click', closeLightbox);
    
    document.addEventListener('keydown', function escapeHandler(e) {
        if (e.key === 'Escape') {
            closeLightbox();
            document.removeEventListener('keydown', escapeHandler);
        }
    });
    
    // Animate in
    requestAnimationFrame(() => {
        lightbox.classList.add('show');
    });
}

/**
 * Form Validation Component
 */
function initializeFormValidation() {
    const forms = document.querySelectorAll('.ios-form-validation');
    
    forms.forEach(form => {
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            input.addEventListener('blur', () => validateField(input));
            input.addEventListener('input', () => clearFieldError(input));
        });
        
        form.addEventListener('submit', (e) => {
            let isValid = true;
            
            inputs.forEach(input => {
                if (!validateField(input)) {
                    isValid = false;
                }
            });
            
            if (!isValid) {
                e.preventDefault();
            }
        });
    });
}

function validateField(field) {
    const value = field.value.trim();
    const rules = field.getAttribute('data-validation');
    
    if (!rules) return true;
    
    const ruleList = rules.split('|');
    let isValid = true;
    let errorMessage = '';
    
    for (const rule of ruleList) {
        const [ruleName, ruleValue] = rule.split(':');
        
        switch (ruleName) {
            case 'required':
                if (!value) {
                    isValid = false;
                    errorMessage = 'This field is required';
                }
                break;
            case 'email':
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (value && !emailRegex.test(value)) {
                    isValid = false;
                    errorMessage = 'Please enter a valid email address';
                }
                break;
            case 'min':
                if (value && value.length < parseInt(ruleValue)) {
                    isValid = false;
                    errorMessage = `Minimum ${ruleValue} characters required`;
                }
                break;
            case 'max':
                if (value && value.length > parseInt(ruleValue)) {
                    isValid = false;
                    errorMessage = `Maximum ${ruleValue} characters allowed`;
                }
                break;
        }
        
        if (!isValid) break;
    }
    
    showFieldError(field, isValid ? '' : errorMessage);
    return isValid;
}

function showFieldError(field, message) {
    clearFieldError(field);
    
    if (message) {
        field.classList.add('error');
        const errorElement = document.createElement('div');
        errorElement.className = 'ios-form-error';
        errorElement.textContent = message;
        field.parentNode.appendChild(errorElement);
    }
}

function clearFieldError(field) {
    field.classList.remove('error');
    const existingError = field.parentNode.querySelector('.ios-form-error');
    if (existingError) {
        existingError.remove();
    }
}

/**
 * Page Transitions
 */
function initializePageTransitions() {
    const links = document.querySelectorAll('a[href^="/"], a[href^="' + window.location.origin + '"]');
    
    links.forEach(link => {
        link.addEventListener('click', (e) => {
            const href = link.getAttribute('href');
            
            // Skip if external link, hash link, or has data-no-transition
            if (link.hasAttribute('data-no-transition') || 
                href.startsWith('#') || 
                href.includes('mailto:') || 
                href.includes('tel:') ||
                link.target === '_blank') {
                return;
            }
            
            e.preventDefault();
            
            // Show loading indicator
            showPageLoading();
            
            // Add exit animation
            document.body.classList.add('page-transitioning');
            
            setTimeout(() => {
                window.location.href = href;
            }, 300);
        });
    });
    
    // Add enter animation on page load
    window.addEventListener('load', () => {
        document.body.classList.add('page-loaded');
        hidePageLoading();
    });
    
    // Handle browser back/forward
    window.addEventListener('pageshow', (e) => {
        if (e.persisted) {
            document.body.classList.add('page-loaded');
            hidePageLoading();
        }
    });
}

/**
 * Loading States
 */
function showPageLoading() {
    let loader = document.getElementById('page-loader');
    if (!loader) {
        loader = document.createElement('div');
        loader.id = 'page-loader';
        loader.className = 'ios-page-loader';
        loader.innerHTML = `
            <div class="loader-content">
                <div class="loader-spinner"></div>
                <div class="loader-text">Loading...</div>
            </div>
        `;
        document.body.appendChild(loader);
    }
    
    requestAnimationFrame(() => {
        loader.classList.add('show');
    });
}

function hidePageLoading() {
    const loader = document.getElementById('page-loader');
    if (loader) {
        loader.classList.remove('show');
        setTimeout(() => {
            loader.remove();
        }, 300);
    }
}

/**
 * Enhanced Loading States for Forms and Buttons
 */
function initializeLoadingStates() {
    // Auto-loading for forms
    const forms = document.querySelectorAll('form[data-loading]');
    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            const submitButton = form.querySelector('button[type="submit"], input[type="submit"]');
            if (submitButton) {
                showButtonLoading(submitButton);
            }
        });
    });
    
    // Auto-loading for buttons with data-loading attribute
    const loadingButtons = document.querySelectorAll('button[data-loading], a[data-loading]');
    loadingButtons.forEach(button => {
        button.addEventListener('click', () => {
            showButtonLoading(button);
        });
    });
}

function showButtonLoading(button) {
    if (button.classList.contains('loading')) return;
    
    button.classList.add('loading');
    button.disabled = true;
    
    // Store original content
    button.dataset.originalContent = button.innerHTML;
    
    // Add loading spinner
    button.innerHTML = `
        <span class="button-spinner"></span>
        <span class="button-text">${button.dataset.loadingText || 'Loading...'}</span>
    `;
}

function hideButtonLoading(button) {
    button.classList.remove('loading');
    button.disabled = false;
    
    if (button.dataset.originalContent) {
        button.innerHTML = button.dataset.originalContent;
        delete button.dataset.originalContent;
    }
}

/**
 * Touch Interactions for Mobile
 */
function initializeTouchInteractions() {
    // Add touch feedback to buttons and interactive elements
    const interactiveElements = document.querySelectorAll(
        '.ios-button, .ios-nav-item, .mobile-nav-item, .ios-card-interactive, .nav-item, .dropdown-item'
    );
    
    interactiveElements.forEach(element => {
        // Touch feedback
        element.addEventListener('touchstart', (e) => {
            element.classList.add('touch-active');
            
            // Haptic feedback for supported devices
            if ('vibrate' in navigator) {
                navigator.vibrate(10);
            }
        });
        
        element.addEventListener('touchend', () => {
            setTimeout(() => {
                element.classList.remove('touch-active');
            }, 150);
        });
        
        element.addEventListener('touchcancel', () => {
            element.classList.remove('touch-active');
        });
        
        // Prevent double-tap zoom on buttons
        if (element.tagName === 'BUTTON' || element.classList.contains('ios-button')) {
            element.addEventListener('touchend', (e) => {
                e.preventDefault();
            });
        }
    });
    
    // Enhanced swipe gestures
    const swipeElements = document.querySelectorAll('.ios-gallery-swipe, .ios-swipe-container, [data-swipe]');
    
    swipeElements.forEach(element => {
        let startX = 0;
        let startY = 0;
        let currentX = 0;
        let currentY = 0;
        let startTime = 0;
        let isScrolling = false;
        
        element.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
            startTime = Date.now();
            isScrolling = false;
        });
        
        element.addEventListener('touchmove', (e) => {
            currentX = e.touches[0].clientX;
            currentY = e.touches[0].clientY;
            
            // Determine if user is scrolling vertically
            const diffY = Math.abs(startY - currentY);
            const diffX = Math.abs(startX - currentX);
            
            if (diffY > diffX && diffY > 10) {
                isScrolling = true;
            }
            
            // Prevent default if horizontal swipe
            if (!isScrolling && diffX > 10) {
                e.preventDefault();
            }
        });
        
        element.addEventListener('touchend', () => {
            if (isScrolling) return;
            
            const diffX = startX - currentX;
            const diffY = startY - currentY;
            const timeDiff = Date.now() - startTime;
            const velocity = Math.abs(diffX) / timeDiff;
            
            // Only trigger if horizontal swipe is more significant than vertical
            // and it's fast enough or far enough
            if (Math.abs(diffX) > Math.abs(diffY) && 
                (Math.abs(diffX) > 50 || velocity > 0.3)) {
                
                if (diffX > 0) {
                    // Swipe left - next
                    element.dispatchEvent(new CustomEvent('swipe-left', {
                        detail: { distance: Math.abs(diffX), velocity }
                    }));
                } else {
                    // Swipe right - previous
                    element.dispatchEvent(new CustomEvent('swipe-right', {
                        detail: { distance: Math.abs(diffX), velocity }
                    }));
                }
            }
            
            // Vertical swipes
            if (Math.abs(diffY) > Math.abs(diffX) && 
                (Math.abs(diffY) > 50 || velocity > 0.3)) {
                
                if (diffY > 0) {
                    element.dispatchEvent(new CustomEvent('swipe-up', {
                        detail: { distance: Math.abs(diffY), velocity }
                    }));
                } else {
                    element.dispatchEvent(new CustomEvent('swipe-down', {
                        detail: { distance: Math.abs(diffY), velocity }
                    }));
                }
            }
        });
    });
    
    // Pull-to-refresh functionality
    const pullToRefreshElements = document.querySelectorAll('[data-pull-refresh]');
    
    pullToRefreshElements.forEach(element => {
        let startY = 0;
        let currentY = 0;
        let isPulling = false;
        let refreshThreshold = 80;
        
        element.addEventListener('touchstart', (e) => {
            if (window.scrollY === 0) {
                startY = e.touches[0].clientY;
                isPulling = true;
            }
        });
        
        element.addEventListener('touchmove', (e) => {
            if (!isPulling) return;
            
            currentY = e.touches[0].clientY;
            const pullDistance = currentY - startY;
            
            if (pullDistance > 0 && window.scrollY === 0) {
                e.preventDefault();
                
                // Visual feedback
                const pullIndicator = element.querySelector('.pull-refresh-indicator');
                if (pullIndicator) {
                    pullIndicator.style.transform = `translateY(${Math.min(pullDistance, refreshThreshold)}px)`;
                    
                    if (pullDistance >= refreshThreshold) {
                        pullIndicator.classList.add('ready');
                    } else {
                        pullIndicator.classList.remove('ready');
                    }
                }
            }
        });
        
        element.addEventListener('touchend', () => {
            if (!isPulling) return;
            
            const pullDistance = currentY - startY;
            
            if (pullDistance >= refreshThreshold) {
                element.dispatchEvent(new CustomEvent('pull-refresh'));
            }
            
            // Reset
            const pullIndicator = element.querySelector('.pull-refresh-indicator');
            if (pullIndicator) {
                pullIndicator.style.transform = '';
                pullIndicator.classList.remove('ready');
            }
            
            isPulling = false;
        });
    });
    
    // Long press functionality
    const longPressElements = document.querySelectorAll('[data-long-press]');
    
    longPressElements.forEach(element => {
        let pressTimer;
        let startX, startY;
        
        element.addEventListener('touchstart', (e) => {
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
            
            pressTimer = setTimeout(() => {
                element.dispatchEvent(new CustomEvent('long-press'));
                
                // Haptic feedback
                if ('vibrate' in navigator) {
                    navigator.vibrate(50);
                }
            }, 500);
        });
        
        element.addEventListener('touchmove', (e) => {
            const currentX = e.touches[0].clientX;
            const currentY = e.touches[0].clientY;
            const distance = Math.sqrt(
                Math.pow(currentX - startX, 2) + Math.pow(currentY - startY, 2)
            );
            
            // Cancel long press if finger moves too much
            if (distance > 10) {
                clearTimeout(pressTimer);
            }
        });
        
        element.addEventListener('touchend', () => {
            clearTimeout(pressTimer);
        });
        
        element.addEventListener('touchcancel', () => {
            clearTimeout(pressTimer);
        });
    });
}

/**
 * Scroll Animations
 */
function initializeScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
            }
        });
    }, observerOptions);
    
    // Observe elements with animation classes
    const animatedElements = document.querySelectorAll(
        '.ios-fade-in-scroll, .ios-slide-in-scroll, .ios-scale-in-scroll, .ios-stagger-item'
    );
    
    animatedElements.forEach(element => {
        observer.observe(element);
    });
}

/**
 * Utility Functions
 */

// Debounce function for performance
function debounce(func, wait) {
    let timeout;
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Throttle function for scroll events
function throttle(func, limit) {
    let inThrottle;
    return function() {
        const args = arguments;
        const context = this;
        if (!inThrottle) {
            func.apply(context, args);
            inThrottle = true;
            setTimeout(() => inThrottle = false, limit);
        }
    }
}

// Show loading state
function showLoading(element) {
    element.classList.add('loading');
    element.disabled = true;
}

// Hide loading state
function hideLoading(element) {
    element.classList.remove('loading');
    element.disabled = false;
}

// Show toast notification
function showToast(message, type = 'info', duration = 3000) {
    const toast = document.createElement('div');
    toast.className = `ios-toast ios-toast-${type}`;
    toast.textContent = message;
    
    document.body.appendChild(toast);
    
    // Animate in
    requestAnimationFrame(() => {
        toast.classList.add('show');
    });
    
    // Auto remove
    setTimeout(() => {
        toast.classList.remove('show');
        setTimeout(() => {
            toast.remove();
        }, 300);
    }, duration);
}

// Copy to clipboard
function copyToClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(() => {
            showToast('Copied to clipboard', 'success');
        });
    } else {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = text;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        showToast('Copied to clipboard', 'success');
    }
}

/**
 * Keyboard Shortcuts
 */
function initializeKeyboardShortcuts() {
    document.addEventListener('keydown', (e) => {
        // Cmd/Ctrl + K for search
        if ((e.metaKey || e.ctrlKey) && e.key === 'k') {
            e.preventDefault();
            const searchInput = document.querySelector('input[type="search"], .search-input');
            if (searchInput) {
                searchInput.focus();
            }
        }
        
        // Escape to close modals/dropdowns
        if (e.key === 'Escape') {
            // Close modals
            const openModal = document.querySelector('.ios-modal.show');
            if (openModal) {
                hideModal(openModal);
                return;
            }
            
            // Close dropdowns
            const openDropdowns = document.querySelectorAll('.ios-dropdown.open');
            openDropdowns.forEach(dropdown => {
                dropdown.classList.remove('open');
            });
            
            // Clear search
            const searchInput = document.querySelector('input[type="search"]:focus');
            if (searchInput && searchInput.value) {
                searchInput.value = '';
                searchInput.dispatchEvent(new Event('input'));
            }
        }
        
        // Arrow keys for navigation in galleries
        if (e.key === 'ArrowLeft' || e.key === 'ArrowRight') {
            const activeGallery = document.querySelector('.ios-gallery:focus-within');
            if (activeGallery) {
                e.preventDefault();
                const event = e.key === 'ArrowLeft' ? 'swipe-right' : 'swipe-left';
                activeGallery.dispatchEvent(new CustomEvent(event));
            }
        }
    });
}

/**
 * Accessibility Enhancements
 */
function initializeAccessibility() {
    // Add focus indicators for keyboard navigation
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Tab') {
            document.body.classList.add('keyboard-navigation');
        }
    });
    
    document.addEventListener('mousedown', () => {
        document.body.classList.remove('keyboard-navigation');
    });
    
    // Announce dynamic content changes to screen readers
    const announceToScreenReader = (message) => {
        const announcement = document.createElement('div');
        announcement.setAttribute('aria-live', 'polite');
        announcement.setAttribute('aria-atomic', 'true');
        announcement.className = 'sr-only';
        announcement.textContent = message;
        
        document.body.appendChild(announcement);
        
        setTimeout(() => {
            document.body.removeChild(announcement);
        }, 1000);
    };
    
    // Make announcements available globally
    window.announceToScreenReader = announceToScreenReader;
    
    // Improve focus management for modals
    const trapFocus = (element) => {
        const focusableElements = element.querySelectorAll(
            'button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])'
        );
        
        if (focusableElements.length === 0) return;
        
        const firstElement = focusableElements[0];
        const lastElement = focusableElements[focusableElements.length - 1];
        
        element.addEventListener('keydown', (e) => {
            if (e.key === 'Tab') {
                if (e.shiftKey) {
                    if (document.activeElement === firstElement) {
                        e.preventDefault();
                        lastElement.focus();
                    }
                } else {
                    if (document.activeElement === lastElement) {
                        e.preventDefault();
                        firstElement.focus();
                    }
                }
            }
        });
        
        firstElement.focus();
    };
    
    // Apply focus trapping to modals
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            mutation.addedNodes.forEach((node) => {
                if (node.nodeType === 1 && node.classList && node.classList.contains('ios-modal')) {
                    trapFocus(node);
                }
            });
        });
    });
    
    observer.observe(document.body, { childList: true });
}

/**
 * Performance Optimizations
 */
function initializePerformanceOptimizations() {
    // Lazy load images
    const images = document.querySelectorAll('img[data-src]');
    const imageObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src;
                img.removeAttribute('data-src');
                imageObserver.unobserve(img);
            }
        });
    });
    
    images.forEach(img => imageObserver.observe(img));
    
    // Preload critical resources
    const preloadLinks = document.querySelectorAll('link[rel="preload"]');
    preloadLinks.forEach(link => {
        const resource = document.createElement('link');
        resource.rel = 'prefetch';
        resource.href = link.href;
        document.head.appendChild(resource);
    });
}

// Export functions for global use
window.iOS16 = {
    showModal,
    hideModal,
    showToast,
    copyToClipboard,
    showLoading: showButtonLoading,
    hideLoading: hideButtonLoading,
    showPageLoading,
    hidePageLoading,
    debounce,
    throttle,
    announceToScreenReader: () => window.announceToScreenReader
};