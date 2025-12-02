<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Details</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css" />
</head>
<body class="font-sans text-gray-800 bg-white">

<div class="max-w-screen-xl px-4 mx-auto sm:px-6 lg:px-8">

    <!-- Breadcrumb -->
    <nav class="py-4 text-sm text-gray-500">
        <a href="/" class="hover:underline">Home</a> &gt;
        <a href="/products" class="hover:underline">Products</a> &gt;
        <span>OffGrid Portable Power Station</span>
    </nav>

    <!-- Product Hero -->
    <section class="grid grid-cols-1 gap-8 py-8 lg:grid-cols-2">
        <!-- Left Column - Image Gallery -->
        <div>
            <div class="w-full mb-4 border border-gray-200 rounded-lg swiper mySwiper2">
                <div class="swiper-wrapper">
                    <div class="swiper-slide"><img src="/assets/images/server-rack.png" class="object-contain w-full" alt="Server Rack"></div>
                    <div class="swiper-slide"><img src="/assets/images/server-rack.png" class="object-contain w-full" alt="Server Rack"></div>
                    <div class="swiper-slide"><img src="/assets/images/server-rack.png" class="object-contain w-full" alt="Server Rack"></div>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

            <div class="mt-4 swiper mySwiper">
                <div class="swiper-wrapper">
                    <div class="w-24 h-24 overflow-hidden border border-gray-200 rounded-lg swiper-slide"><img src="/assets/images/server-rack.png" class="object-cover w-full h-full" alt="Server Rack Thumbnail"></div>
                    <div class="w-24 h-24 overflow-hidden border border-gray-200 rounded-lg swiper-slide"><img src="/assets/images/server-rack.png" class="object-cover w-full h-full" alt="Server Rack Thumbnail"></div>
                    <div class="w-24 h-24 overflow-hidden border border-gray-200 rounded-lg swiper-slide"><img src="/assets/images/server-rack.png" class="object-cover w-full h-full" alt="Server Rack Thumbnail"></div>
                </div>
            </div>
        </div>

        <!-- Right Column - Details -->
        <div>
            <div class="mb-2">
                <img src="https://via.placeholder.com/100x50" alt="Brand Logo">
            </div>
            <h1 class="mb-2 text-3xl font-light">OffGrid Portable Power Station</h1>
            <p class="mb-4 text-sm text-gray-500">SKU: OPPS-1234</p>
            <button class="px-6 py-2 mb-6 font-semibold text-white bg-green-600 rounded hover:bg-green-800">Add to My Quotation</button>

            <ul class="mb-6 space-y-2">
                <li class="flex items-start"><span class="mr-2 text-green-600">&#10003;</span> 2 pure sine wave AC outlets</li>
                <li class="flex items-start"><span class="mr-2 text-green-600">&#10003;</span> 3 USB-A and 1 USB-C PD60W</li>
                <li class="flex items-start"><span class="mr-2 text-green-600">&#10003;</span> Recharge via wall, solar, and car</li>
            </ul>

            <div class="space-y-2">
                <a href="/reseller-partner" class="flex items-center text-sm font-semibold text-green-600 hover:text-green-800">
                    <span class="mr-2">&#x1F4CD;</span> Find a reseller
                </a>
                <a href="mailto:sales@example.com" class="flex items-center text-sm font-semibold text-green-600 hover:text-green-800">
                    <span class="mr-2">&#x2709;</span> Contact Sales
                </a>
            </div>
        </div>
    </section>

    <!-- Main Documents -->
    <section class="py-8">
        <h2 class="mb-6 text-2xl font-light">Main Documents</h2>
        <div class="p-6 border border-gray-200 rounded-lg">
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                <a href="#" class="flex items-center text-gray-700 hover:text-green-600 group">
                    <span class="mr-2">&#128196;</span> Datasheet.pdf
                </a>
                <a href="#" class="flex items-center text-gray-700 hover:text-green-600 group">
                    <span class="mr-2">&#128196;</span> User Manual.pdf
                </a>
                <a href="#" class="flex items-center text-gray-700 hover:text-green-600 group">
                    <span class="mr-2">&#128196;</span> Installation Guide.pdf
                </a>
            </div>
            <div class="mt-6">
                <a href="#" class="text-sm font-semibold text-green-600 hover:text-green-800 hover:underline">See all documents</a>
            </div>
        </div>
    </section>

    <!-- Description -->
    <section class="py-8">
        <h2 class="mb-4 text-2xl font-light">Description</h2>
        <p class="mb-2 text-gray-600 line-clamp-3">
            Schneider Electric's OffGrid Portable Power Station is designed for outdoor enthusiasts and home users...
        </p>
        <button class="flex items-center mt-2 text-sm font-semibold text-green-600 hover:text-green-800">
            Read more
        </button>
    </section>

    <!-- Specifications -->
    <section class="py-8">
        <h2 class="mb-4 text-2xl font-light">Specifications</h2>
        <div class="p-6 space-y-4 border border-gray-200 rounded-lg">
            <div>
                <h3 class="mb-2 text-lg font-semibold text-gray-800">Overview</h3>
                <div class="grid grid-cols-1 gap-2 py-1 border-b border-gray-100 md:grid-cols-3">
                    <dt class="font-medium text-gray-600">Power Output</dt>
                    <dd class="text-gray-800 md:col-span-2">600W</dd>
                </div>
                <div class="grid grid-cols-1 gap-2 py-1 border-b border-gray-100 md:grid-cols-3">
                    <dt class="font-medium text-gray-600">Battery Capacity</dt>
                    <dd class="text-gray-800 md:col-span-2">1500Wh</dd>
                </div>
            </div>
        </div>
        <button class="flex items-center mt-4 text-sm font-semibold text-green-600 hover:text-green-800">
            Show more specifications
        </button>
    </section>

    <!-- Gallery -->
    <section class="py-8">
        <h2 class="mb-4 text-2xl font-light">Gallery</h2>
        <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
            <img src="/assets/images/server-rack.png" class="object-cover w-full h-full rounded-lg" alt="Gallery 1">
            <img src="/assets/images/server-rack.png" class="object-cover w-full h-full rounded-lg" alt="Gallery 2">
            <img src="/assets/images/server-rack.png" class="object-cover w-full h-full rounded-lg" alt="Gallery 3">
        </div>
    </section>

    <!-- FAQ -->
    <section class="py-8">
        <h2 class="mb-4 text-2xl font-light">FAQ</h2>
        <div class="space-y-2">
            <div class="border border-gray-200 rounded-lg">
                <button class="flex justify-between w-full px-4 py-2 font-semibold text-left faq-question">
                    What is the warranty period?
                    <span>&#9660;</span>
                </button>
                <div class="hidden px-4 py-2 text-gray-600 faq-answer">2 years warranty included.</div>
            </div>
            <div class="border border-gray-200 rounded-lg">
                <button class="flex justify-between w-full px-4 py-2 font-semibold text-left faq-question">
                    How long to charge via solar?
                    <span>&#9660;</span>
                </button>
                <div class="hidden px-4 py-2 text-gray-600 faq-answer">Approx. 3 hours with 200W panel.</div>
            </div>
        </div>
    </section>

    <!-- Related Products Swiper -->
    <section class="py-8">
        <h2 class="mb-4 text-2xl font-light">Related Products</h2>
        <div class="swiper relatedSwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide">
                    <div class="flex flex-col items-center h-full p-6 text-center bg-white border border-gray-200 rounded-lg">
                        <img src="/assets/images/server-rack.png" alt="APC NetShelter SX" class="object-contain w-40 h-40 my-4" />
                        <p class="mb-2 text-sm text-gray-500">AR3003</p>
                        <h3 class="text-base font-medium text-gray-800">APC NetShelter SX, Server Rack Enclosure, 12U</h3>
                        <a href="#" class="inline-block w-full px-4 py-2 mt-6 border border-gray-300 rounded-md hover:bg-gray-100">
                            View Details
                        </a>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="flex flex-col items-center h-full p-6 text-center bg-white border border-gray-200 rounded-lg">
                        <img src="/assets/images/server-rack.png" alt="APC NetShelter SX" class="object-contain w-40 h-40 my-4" />
                        <p class="mb-2 text-sm text-gray-500">AR3105</p>
                        <h3 class="text-base font-medium text-gray-800">APC NetShelter SX, Server Rack Enclosure, 45U</h3>
                        <a href="#" class="inline-block w-full px-4 py-2 mt-6 border border-gray-300 rounded-md hover:bg-gray-100">
                            View Details
                        </a>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="flex flex-col items-center h-full p-6 text-center bg-white border border-gray-200 rounded-lg">
                        <img src="/assets/images/server-rack.png" alt="APC NetShelter SX" class="object-contain w-40 h-40 my-4" />
                        <p class="mb-2 text-sm text-gray-500">AR3300</p>
                        <h3 class="text-base font-medium text-gray-800">APC NetShelter SX, Server Rack Enclosure, 42U</h3>
                        <a href="#" class="inline-block w-full px-4 py-2 mt-6 border border-gray-300 rounded-md hover:bg-gray-100">
                            View Details
                        </a>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="flex flex-col items-center h-full p-6 text-center bg-white border border-gray-200 rounded-lg">
                        <img src="/assets/images/server-rack.png" alt="APC NetShelter SX" class="object-contain w-40 h-40 my-4" />
                        <p class="mb-2 text-sm text-gray-500">AR3140</p>
                        <h3 class="text-base font-medium text-gray-800">APC NetShelter SX, Networking Rack Enclosure, 42U</h3>
                        <a href="#" class="inline-block w-full px-4 py-2 mt-6 border border-gray-300 rounded-md hover:bg-gray-100">
                            View Details
                        </a>
                    </div>
                </div>
                <div class="swiper-slide">
                    <div class="flex flex-col items-center h-full p-6 text-center bg-white border border-gray-200 rounded-lg">
                        <img src="/assets/images/server-rack.png" alt="APC NetShelter SX" class="object-contain w-40 h-40 my-4" />
                        <p class="mb-2 text-sm text-gray-500">AR3350</p>
                        <h3 class="text-base font-medium text-gray-800">APC NetShelter SX, Server Rack Enclosure, 42U</h3>
                        <a href="#" class="inline-block w-full px-4 py-2 mt-6 border border-gray-300 rounded-md hover:bg-gray-100">
                            View Details
                        </a>
                    </div>
                </div>
            </div>
            <!-- Optional navigation -->
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </section>

</div>

<!-- Swiper JS -->
<script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

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
            const answer = q.nextElementSibling;
            answer.classList.toggle('hidden');
        });
    });
</script>

</body>
</html>
