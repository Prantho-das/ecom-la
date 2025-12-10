<section class="bg-white">
    {{-- <div class="">
        <a href="#" onclick="my_modal_1.showModal()"
            class="inline-block bg-[#27ad4c] text-white font-semibold py-3 px-8 rounded-md hover:bg-green-700 transition-colors">
            Contact Sales
        </a>

        <dialog id="my_modal_1" class="modal">
            <div class="p-0 modal-box">
                <div class="modal-action ">
                    <form method="dialog bg-white">
                        <button class="p-1 btn">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>

                        </button>
                    </form>
                </div>
                <div>
                    <x-country-form />
                </div>

            </div>
        </dialog>
    </div> --}}











    <div class="max-w-screen-xl px-4 mx-auto sm:px-6 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="py-4 text-sm text-gray-500">
            <a href="/" class="hover:underline">Home</a> &gt;
            <a href="/products" class="hover:underline">Products</a> &gt;
            <span>{{ $product->name }}</span>
        </nav>

        <!-- Product Hero -->
        <section class="grid grid-cols-1 gap-8 py-8 lg:grid-cols-2" wire:ignore>
            <!-- Left Column - Image Gallery -->
            {{-- <div>
            <div class="w-full mb-4 border border-gray-200 rounded-lg swiper mySwiper2">
                <div class="swiper-wrapper">
                    @foreach ($images as $image)
                    <div class="swiper-slide"><img src="{{asset('storage/'.$image)}}" class="object-contain w-full" alt="Server Rack"></div>
                    @endforeach
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>

            <div class="mt-4 swiper mySwiper">
                <div class="swiper-wrapper">
                    @foreach ($images as $image)
                    <div class="w-24 h-24 overflow-hidden border border-gray-200 rounded-lg swiper-slide"><img src="{{asset('storage/'.$image)}}" class="object-cover w-full h-full" alt="Server Rack Thumbnail"></div>

                    @endforeach
                </div>
            </div>
        </div> --}}

            <div>
                <!-- Main Gallery -->
                <div class="w-full mb-4 border border-gray-200 rounded-lg swiper mySwiper2">
                    <div class="swiper-wrapper">
                        @foreach ($images as $image)
                            <div class="swiper-slide">
                                <img src="{{ asset('storage/' . $image) }}"
                                    class="object-contain object-cover w-full h-auto max-h-screen md:h-full aspect-square"
                                    alt="Server Rack">
                            </div>
                        @endforeach
                    </div>
                    <div class="text-gray-600 swiper-button-next"></div>
                    <div class="text-gray-600 swiper-button-prev"></div>
                </div>

                <!-- Thumbnails -->
                <div class="mt-4 swiper mySwiper">
                    <div class="swiper-wrapper">
                        @foreach ($images as $image)
                            <div
                                class="w-24 h-24 overflow-hidden border-2 border-gray-300 rounded-lg cursor-pointer hover:border-green-600 swiper-slide">
                                <img src="{{ asset('storage/' . $image) }}"
                                    class="object-cover w-full h-full aspect-square" alt="Thumbnail">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Right Column - Details -->
            <div>
                <div class="w-10 mb-2">
                    <img src="{{ $product->brand && $product->brand->logo_path ? asset('storage/' . $product->brand->logo_path) : 'https://placehold.co/600x400?text=' . $product->name }}"
                        alt="{{ $product->brand?->name }}">
                </div>

                <h1 class="mb-2 text-3xl font-light text-black">{{ $product->name }}</h1>
                <p class="mb-2 text-sm text-gray-500 ">SKU: {{ $product->sku }}</p>
                <hr class="my-6">
                <button
                    class="flex items-center gap-1 mb-4 text-sm font-semibold text-green-600 transition rounded hover:text-green-800 drop-shadow-blue-300">
                    <x-heroicon-o-star class="w-5 h-5" /> Add to My Quotation</button>



                <ul class="mb-6 space-y-2 text-base text-gray-500">
                    <li class="flex items-start ">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="mr-2 text-green-600 size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                        2 pure sine wave AC
                        outlets
                    </li>
                    <li class="flex items-start "><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="mr-2 text-green-600 size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                        3 USB-A and 1 USB-C
                        PD60W</li>
                    <li class="flex items-start "><svg xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                            class="mr-2 text-green-600 size-4">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                        </svg>
                        Recharge via wall,
                        solar, and car</li>
                </ul>

                {{-- <hr class="my-4"> --}}

                <div class="space-y-3">
                    <a href="/reseller-partner"
                        class="flex items-center text-sm font-semibold text-green-600 hover:text-green-800">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="mr-2 text-green-600 size-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                        </svg>
                        Find a reseller
                    </a>
                    <a href="mailto:sales@example.com"
                        class="flex items-center text-sm font-semibold text-green-600 hover:text-green-800">

                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                            stroke-width="1.5" stroke="currentColor" class="mr-2 text-green-600 size-4">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>
                        Contact Sales
                    </a>
                </div>
            </div>
        </section>

        <!-- Main Documents -->
        <section class="py-8">
            <h2 class="mb-6 text-2xl font-light">Main Documents</h2>
            <div class="p-6 border border-gray-200 rounded-lg">
                @if (!empty($product->pdf_files))
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3">
                        @foreach ($product->pdf_files as $pdf_file)
                            <a href="{{ asset('storage/' . $pdf_file) }}" target="_blank"
                                class="flex items-center text-gray-700 hover:text-green-600 group">
                                <span class="mr-2 ">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="text-red-700 size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                    </svg>

                                </span> {{ basename($pdf_file) }}
                            </a>
                        @endforeach
                    </div>
                @else
                    <p class="text-gray-500">No main documents available.</p>
                @endif
            </div>
        </section>

        <!-- Description -->
        <section class="py-8">
            <h2 class="mb-4 text-2xl font-light">Description</h2>
            <div x-data="{ expanded: false }" class="relative">
                <div x-show="expanded" class="prose max-w-none">
                    {!! $product->description !!}
                </div>
                <div x-show="!expanded" class="prose max-w-none line-clamp-3">
                    {!! $product->description !!}
                </div>
                @if (strlen(strip_tags($product->description)) > 200)
                    {{-- Adjust character limit as needed --}}
                    <button x-on:click="expanded = !expanded"
                        class="flex items-center mt-2 text-sm font-semibold text-green-600 hover:text-green-800">
                        <span x-show="!expanded">Read more</span>
                        <span x-show="expanded">Read less</span>
                    </button>
                @endif
            </div>
        </section>

        <!-- Specifications -->
        <section class="py-8">
            <h2 class="mb-4 text-2xl font-light ">Specifications</h2>
            <div class="p-6 space-y-4 border border-gray-200 rounded-lg">
                @forelse($product->custom_sections ?? [] as $section)
                    <div>
                        <div class="px-3 py-1 bg-gray-200">
                            <h3 class="text-base font-semibold text-gray-800 ">{{ $section['title'] }}</h3>
                        </div>
                        @foreach ($section['fields'] ?? [] as $field)
                            <div class="grid grid-cols-1 gap-2 px-3 py-1 border-b border-gray-100 md:grid-cols-3">
                                <dt class="font-semibold text-gray-600">{{ $field['key'] }}</dt>
                                <dd class="text-gray-800 md:col-span-2">{{ $field['value'] }}</dd>
                            </div>
                        @endforeach
                    </div>
                @empty
                    <p class="text-gray-500">No specifications available.</p>
                @endforelse
            </div>
        </section>

        <!-- Gallery -->
        <section class="py-8">
            <h2 class="mb-4 text-2xl font-light">Gallery</h2>
            <div class="grid grid-cols-2 gap-4 md:grid-cols-3">
                {{-- @foreach ($images as $image)
                    <img src="{{ asset('storage/' . $image) }}" class="object-cover w-full h-full rounded-lg"
                        alt="Gallery Image">
                @endforeach --}}
                @foreach ($images as $image)
                    <a href="image-a.jpeg" data-fancybox="gallery" data-caption="Gallery image">
                        <img src="{{ asset('storage/' . $image) }}"
                            class="object-cover w-full h-full rounded-lg aspect-square" alt="Gallery Image">
                    </a>
                @endforeach
            </div>
        </section>

        <!-- FAQ -->
        <section class="py-8">
            <h2 class="mb-4 text-2xl font-light">FAQ</h2>

            @php
                $faqSection = collect($product->custom_sections ?? [])->firstWhere('title', 'FAQ');
            @endphp

            @if ($faqSection && !empty($faqSection['fields']))
                <div class="space-y-3">
                    @foreach ($faqSection['fields'] as $index => $faqItem)
                        <div class="border rounded-lg collapse bg-base-100 border-base-300">
                            <input type="radio" name="faq-accordion" {{ $index === 0 ? 'checked' : '' }} />
                            <div class="font-semibold collapse-title">
                                {{ $faqItem['key'] }}
                            </div>
                            <div class="text-sm text-gray-600 collapse-content">
                                {{ $faqItem['value'] }}
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-gray-500">No FAQs available.</p>
            @endif
        </section>


        <!-- Related Products Swiper -->
        <section class="py-8" wire:ignore>
            <h2 class="mb-4 text-2xl font-light">Related Products</h2>
            <div class="swiper relatedSwiper">
                <div class="swiper-wrapper">
                    @foreach ($relatedProducts as $relatedProduct)
                        <div class="swiper-slide">
                            <div
                                class="flex flex-col items-center h-full p-6 text-center bg-white border border-gray-200 rounded-lg">
                                <img src="{{ $relatedProduct->logo_path ? asset('storage/' . $relatedProduct->thumbnail) : 'https://placehold.co/600x400?text=' . $relatedProduct->name }}"
                                    alt="{{ $relatedProduct->name }}" class="object-contain w-40 h-40 my-4" />
                                <p class="mb-2 text-sm text-gray-500">AR3003</p>
                                <h3 class="text-base font-medium text-gray-800">{{ $relatedProduct->name }}</h3>
                                <a href="{{ route('details', $relatedProduct->slug) }}"
                                    class="inline-block w-full px-4 py-2 mt-6 border border-gray-300 rounded-md hover:bg-gray-100">
                                    View Details
                                </a>
                            </div>
                        </div>
                    @endforeach

                </div>
                <!-- Optional navigation -->
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
            </div>
        </section>
<x-country-modal />
    </div>
</section>
@push('scripts')
    <script>
        function initializeSwipers() {
            console.log("Swiper Init");

            // destroy existing swiper
            document.querySelectorAll('.swiper').forEach(swiperEl => {
                if (swiperEl.swiper) {
                    swiperEl.swiper.destroy(true, true);
                }
            });

            // Thumbs
            const swiperThumbs = new Swiper(".mySwiper", {
                spaceBetween: 10,
                slidesPerView: 3,
                freeMode: true,
                watchSlidesProgress: true,
                touchStartPreventDefault: false
            });

            // Main Slider
            const swiperMain = new Swiper(".mySwiper2", {
                spaceBetween: 10,
                touchStartPreventDefault: false,
                navigation: {
                    nextEl: ".mySwiper2 .swiper-button-next",
                    prevEl: ".mySwiper2 .swiper-button-prev",
                },
                thumbs: {
                    swiper: swiperThumbs
                },
            });

            // Related slider
            const relatedSwiper = new Swiper(".relatedSwiper", {
                slidesPerView: 2,
                spaceBetween: 16,
                touchStartPreventDefault: false,
                navigation: {
                    nextEl: ".relatedSwiper .swiper-button-next",
                    prevEl: ".relatedSwiper .swiper-button-prev",
                },
                breakpoints: {
                    640: {
                        slidesPerView: 3
                    },
                    1024: {
                        slidesPerView: 4
                    }
                }
            });
        }

        document.addEventListener("DOMContentLoaded", initializeSwipers);
        document.addEventListener("livewire:navigated", initializeSwipers);
        document.querySelectorAll('.faq-question').forEach(q => {
            q.addEventListener('click', () => {
                const answer = q.nextElementSibling;
                answer.classList.toggle('hidden');
            });
        });
    </script>
@endpush
