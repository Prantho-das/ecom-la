<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Product Details' }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />

    @livewireStyles
</head>

<body>
    <x-header />
    {{ $slot }}
    <x-footer />
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    {{-- Extra Scripts Slot For Components --}}


    @livewireScripts


    @stack('scripts')
    <script>
        // Main product image swiper
        var swiperThumbs = new Swiper(".mySwiper", {
            spaceBetween: 10,
            slidesPerView: 3,
            freeMode: true,
            watchSlidesProgress: true,
        });
    
        var swiperMain = new Swiper(".mySwiper2", {
            spaceBetween: 10,
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
            thumbs: {
                swiper: swiperThumbs,
            },
        });
    
        // Related products swiper
        var relatedSwiper = new Swiper(".relatedSwiper", {
            slidesPerView: 2,
            spaceBetween: 16,
            navigation: {
                nextEl: ".relatedSwiper .swiper-button-next",
                prevEl: ".relatedSwiper .swiper-button-prev",
            },
            breakpoints: {
                640: { slidesPerView: 3 },
                1024: { slidesPerView: 4 },
            },
        });
    
        // FAQ toggle
        document.querySelectorAll('.faq-question').forEach(q => {
            q.addEventListener('click', () => {
                q.nextElementSibling.classList.toggle('hidden');
            });
        });
    </script>
</body>

</html>