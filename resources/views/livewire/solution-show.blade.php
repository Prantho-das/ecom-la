<div>
    <!-- HERO SECTION -->
    <div class="relative w-full bg-black text-white overflow-hidden min-h-[500px] flex">
        <div class="absolute inset-0 w-full h-full">
            @if($page->hero_background_image ?? null)
            <img src="{{ asset('storage/' . $page->hero_background_image) }}" alt="Hero Background"
                class="object-cover object-right w-full h-full" />
            @else
            <div class="w-full h-full bg-gray-800"></div> <!-- Fallback background -->
            @endif

            <div class="absolute inset-0 bg-black/20 lg:bg-transparent"></div>
        </div>

        <div
            class="absolute z-10 w-full h-full lg:w-[70%] bg-black lg:[clip-path:polygon(0_0,100%_0,90%_100%,0_100%)] flex flex-col justify-center px-6 md:px-12 lg:pl-24 lg:pr-32 py-16 lg:py-24">
            <h1 class="mb-6 text-4xl font-bold leading-tight md:text-5xl">
                {{ $page->hero_title ?? 'Welcome to Our Liquid Cooling Solutions' }}
            </h1>
            <p class="max-w-2xl text-lg leading-relaxed text-gray-300 md:text-xl">
                {{ $page->hero_subtitle ?? '' }}
            </p>
        </div>
    </div>

    



    <!-- FEATURES -->
    <section class="px-4 py-16 mx-auto md:px-8 max-w-7xl">
        <div class="mb-16 text-center">
            <h2 class="max-w-4xl mx-auto text-2xl font-medium leading-relaxed text-gray-800 md:text-3xl">
                {{ $page->features_heading ?? 'Our Key Features' }}
            </h2>
        </div>

        @if(isset($page->feature_cards) && is_array($page->feature_cards) && count($page->feature_cards) > 0)
        <div class="grid grid-cols-1 gap-8 md:grid-cols-3">
            @foreach($page->feature_cards as $card)
            @if(is_array($card))
            <div class="flex flex-col">
                <div class="mb-4 overflow-hidden rounded-sm">
                    @if(!empty($card['image'] ?? null))
                    <img src="{{ asset('storage/' . $card['image']) }}" alt="{{ $card['title'] ?? 'Feature' }}"
                        class="object-cover w-full h-48 transition-transform duration-300 hover:scale-105" />
                    @else
                    <div class="w-full h-48 bg-gray-200 border-2 border-dashed rounded"></div>
                    @endif
                </div>
                <h3 class="mb-2 text-lg font-bold text-gray-900">
                    {{ $card['title'] ?? 'Feature Title' }}
                </h3>
                <p class="text-sm leading-relaxed text-gray-600">
                    {{ $card['description'] ?? '' }}
                </p>
            </div>
            @endif
            @endforeach
        </div>
        @else
        <p class="text-center text-gray-500">No features available at the moment.</p>
        @endif
    </section>

    <!-- TRENDS -->
    <section class="px-4 py-16 mx-auto md:px-8 max-w-7xl">
        <h2 class="mb-12 text-3xl font-bold text-center text-gray-900">
            {{ $page->trends_section['title'] ?? 'Industry Trends' }}
        </h2>

        <div class="flex flex-col items-center gap-12 lg:flex-row">
            <div class="flex-1 space-y-8">
                @php
                $trendItems = $page->trends_section['items'] ?? [];
                @endphp

                @if(is_array($trendItems) && count($trendItems) > 0)
                @foreach($trendItems as $item)
                @if(is_array($item))
                <div class="flex gap-4">
                    <div class="flex-shrink-0 mt-1 text-orange-500">
                        @if(!empty($item['icon'] ?? null))
                        <i data-lucide="{{ $item['icon'] }}" class="w-8 h-8"></i>
                        @else
                        <div class="w-8 h-8 bg-orange-200 rounded-full"></div>
                        @endif
                    </div>
                    <div>
                        <h3 class="mb-2 text-xl font-bold text-gray-900">
                            {{ $item['title'] ?? 'Trend Title' }}
                        </h3>
                        <p class="max-w-md leading-relaxed text-gray-600">
                            {{ $item['description'] ?? '' }}
                        </p>
                    </div>
                </div>
                @endif
                @endforeach
                @else
                <p class="text-gray-500">No trends to display.</p>
                @endif
            </div>

            <div class="flex-1 w-full">
                <div class="relative w-full overflow-hidden bg-gray-900 rounded-md shadow-lg aspect-video">
                    @php
                    $videoUrl = $page->trends_section['video_title'] ?? null;
                    @endphp

                    @if($videoUrl && filter_var($videoUrl, FILTER_VALIDATE_URL))
                    <iframe width="560" height="315" src="{{ $videoUrl }}" title="Industry Trends Video" frameborder="0"
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                        referrerpolicy="strict-origin-when-cross-origin" allowfullscreen class="w-full h-full">
                    </iframe>
                    @else
                    <div class="flex items-center justify-center w-full h-full text-gray-400 bg-gray-800">
                        <p>No video available</p>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section class="px-4 py-16 bg-gray-50 md:px-8">
        <div class="flex flex-col items-center gap-12 mx-auto max-w-7xl md:flex-row">
            <div class="flex-1 w-full">
                <div class="relative overflow-hidden rounded-lg shadow-xl">
                    @if(!empty($page->cta_section['image'] ?? null))
                    <img src="{{ asset('storage/' . $page->cta_section['image']) }}" alt="CTA Image"
                        class="object-cover w-full h-auto" />
                    @else
                    <div class="w-full h-96 bg-gradient-to-br from-blue-600 to-cyan-500"></div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-blue-900/60 to-transparent mix-blend-multiply">
                    </div>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span
                            class="text-6xl md:text-9xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-cyan-400 to-blue-600 drop-shadow-[0_0_15px_rgba(0,255,255,0.5)] tracking-tighter">
                            AI
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex-1 space-y-6">
                <h2 class="text-3xl font-bold text-gray-900">
                    {{ $page->cta_section['title'] ?? 'Ready to Transform Your Data Center?' }}
                </h2>
                <p class="leading-relaxed text-gray-700">
                    {{ $page->cta_section['description'] ?? 'Contact us today to learn how liquid cooling can reduce
                    costs and improve performance.' }}
                </p>
                <button
                    class="px-8 py-3 font-bold text-white transition-colors bg-green-600 rounded hover:bg-green-500">
                    {{ $page->cta_section['button_text'] ?? 'Get Started' }}
                </button>
            </div>
        </div>
    </section>

    <!-- CONTACT FORM (Livewire-powered) -->
    <section class="hidden px-4 py-16 bg-gray-100 md:px-8">
        <div class="max-w-4xl mx-auto">
            <h2 class="mb-2 text-2xl font-bold text-gray-900 md:text-3xl">
                Contact us about Liquid Cooling Services
            </h2>
            <p class="mb-8 text-sm text-gray-600">
                Please fill out the form below and we will get back to you as soon as possible.
            </p>

            @if($successMessage ?? false)
            <div class="p-4 mb-8 text-green-800 bg-green-100 rounded">
                Thank you! Your message has been sent successfully.
            </div>
            @endif

            <form wire:submit="submitContactForm" class="space-y-8">
                @csrf
                <div class="grid grid-cols-1 gap-8 md:grid-cols-2">
                    <!-- Left column fields remain the same (assuming Livewire handles validation) -->
                    <div class="space-y-5">
                        <!-- ... (your existing form fields - they are already safe with wire:model) -->
                        <div>
                            <label class="block mb-1 text-xs font-bold text-gray-700">First name</label>
                            <input type="text" wire:model="firstName" required
                                class="w-full p-2 text-sm bg-white border-b-2 border-gray-300 focus:border-green-500 focus:outline-none" />
                            @error('firstName') <span class="text-xs text-red-500">{{ $message }}</span> @enderror
                        </div>
                        <!-- Repeat for lastName, email, phone, company -->
                    </div>

                    <div class="space-y-5">
                        <!-- Country, Zip, Comment -->
                    </div>
                </div>

                <div class="pt-8">
                    <div class="flex items-start gap-3">
                        <input type="checkbox" wire:model="consent" id="consent" class="mt-1" required />
                        <label for="consent" class="text-[10px] text-gray-600 leading-tight">
                            The processing of my personal data for marketing purposes...
                        </label>
                    </div>
                    @error('consent') <span class="block mt-1 text-xs text-red-500">{{ $message }}</span> @enderror
                </div>

                <div class="mt-10">
                    <button type="submit"
                        class="px-8 py-3 text-sm font-bold text-white bg-green-600 rounded-sm shadow-md hover:bg-green-500">
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </section>

    <!-- FAQs -->
    <section class="max-w-4xl px-4 py-16 mx-auto md:px-8">
        <h2 class="mb-10 text-3xl font-bold text-center text-gray-900 md:text-left">
            {{ ($page->faqs['title'] ?? null) ?: 'Frequently Asked Questions' }}
        </h2>

        @php
        $faqItems = $page->faqs['items'] ?? [];
        @endphp

        @if(is_array($faqItems) && count($faqItems) > 0)
        <div class="space-y-3">
            @foreach($faqItems as $faq)
            @if(is_array($faq) && !empty($faq['question'] ?? null))
            <div class="transition-colors bg-gray-300 rounded-lg collapse collapse-arrow hover:bg-gray-200">
                <input type="radio" name="faq-accordion" />
                <div class="text-sm font-medium text-gray-800 collapse-title">
                    Q: {{ $faq['question'] }}
                </div>
                <div class="bg-white collapse-content">
                    <p class="pt-2 text-sm text-gray-600">
                        {{ $faq['answer'] ?? 'No answer provided.' }}
                    </p>
                </div>
            </div>
            @endif
            @endforeach
        </div>
        @else
        <p class="text-center text-gray-500">No FAQs available at this time.</p>
        @endif
    </section>
</div>
