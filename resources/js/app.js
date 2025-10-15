/**
 * Main Application JavaScript
 * Initializes Alpine.js and iOS 16 Design System components
 */

import Alpine from 'alpinejs';
import './ios16';
import './alpine-components';

// Make Alpine available globally
window.Alpine = Alpine;

// Start Alpine
Alpine.start();

// Initialize iOS 16 components when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('iOS 16 Design System initialized');
});
