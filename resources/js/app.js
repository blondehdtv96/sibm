/**
 * Main Application JavaScript
 * Initializes Alpine.js and iOS 16 Design System components
 */

import Alpine from 'alpinejs';
import Swiper from 'swiper';
import { A11y, Autoplay, EffectFade, Keyboard, Navigation, Pagination } from 'swiper/modules';
import 'swiper/css';
import 'swiper/css/effect-fade';
import 'swiper/css/pagination';
import './ios16';
import './alpine-components';

// Make Alpine and Swiper available to Blade components.
window.Alpine = Alpine;
window.Swiper = Swiper;
Swiper.use([A11y, Autoplay, EffectFade, Keyboard, Navigation, Pagination]);

// Start Alpine
Alpine.start();

// Initialize iOS 16 components when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    console.log('iOS 16 Design System initialized');
});
