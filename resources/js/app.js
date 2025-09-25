import './bootstrap';
import Alpine from 'alpinejs';

// Import Swiper bundle with all modules included
import Swiper from 'swiper/bundle';
import 'swiper/css/bundle';

// Make Swiper globally available
window.Swiper = Swiper;

window.Alpine = Alpine;
Alpine.start();
