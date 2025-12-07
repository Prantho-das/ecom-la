import { Swiper } from 'swiper';
import { Navigation, Thumbs } from 'swiper/modules';
// Import Swiper styles
import 'swiper/css';
import 'swiper/css/navigation';
import 'swiper/css/thumbs';
import "@fortawesome/fontawesome-free/css/all.css";

let thumbnailSwiper = null;
let gallerySwiper = null;

function initSwipers() {
    // Destroy existing instances if they exist (important!)
    if (gallerySwiper) gallerySwiper.destroy(true, true);
    if (thumbnailSwiper) thumbnailSwiper.destroy(true, true);

    // Initialize thumbnail swiper first
    thumbnailSwiper = new Swiper('.mySwiper', {
        spaceBetween: 10,
        slidesPerView: 4,
        freeMode: true,
        watchSlidesProgress: true,
        breakpoints: {
            640: { slidesPerView: 4 },
            768: { slidesPerView: 4 },
            1024: { slidesPerView: 4 },
        }
    });

    // Then initialize main gallery with thumbs
    gallerySwiper = new Swiper('.mySwiper2', {
        spaceBetween: 10,
        navigation: {
            nextEl: '.swiper-button-next',
            prevEl: '.swiper-button-prev',
        },
        thumbs: {
            swiper: thumbnailSwiper,
        },
        modules: [Navigation, Thumbs],
        loop: true, // optional
    });
}

// Initialize on page load
document.addEventListener('DOMContentLoaded', () => {
    if (document.querySelector('.mySwiper2')) {
        initSwipers();
    }
});

// Re-initialize every time Livewire finishes updating the DOM
document.addEventListener('livewire:navigated', () => {
    if (document.querySelector('.mySwiper2')) {
        initSwipers();
    }
});

// This is the most important one for Livewire components
document.addEventListener('livewire:update', () => {
    // Small delay to ensure DOM is fully rendered
    setTimeout(() => {
        if (document.querySelector('.mySwiper2')) {
            initSwipers();
        }
    }, 100);
});
