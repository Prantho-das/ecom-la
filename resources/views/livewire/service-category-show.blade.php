<div>
    <section class="bg-white py-12 md:py-20">
        <div class="max-w-7xl mx-auto px-4">
            <div class="grid md:grid-cols-2 gap-12 items-start">
                <!-- Text Content -->
                <div class="space-y-6">
                    <span class="text-gray-500 text-xs font-bold uppercase tracking-widest">Product Family</span>
                    <h1 class="text-4xl md:text-5xl font-light text-gray-900 leading-tight">
                        {{ $serviceCategory->title }}
                    </h1>
                    <p class="text-gray-600 leading-relaxed text-sm md:text-base max-w-xl">
                        {{ $serviceCategory->short_description }}
                    </p>

                    <div class="flex flex-col sm:flex-row space-y-3 sm:space-y-0 sm:space-x-4 pt-4">
                        @if ($serviceCategory->links)
                            @foreach ($serviceCategory->links as $link)
                                <a href="{{ $link['url'] }}" class="bg-green-600 text-white px-8 py-3 text-xs font-bold uppercase tracking-widest hover:bg-orange-700 transition">
                                    {{ $link['label'] }}
                                </a>
                            @endforeach
                        @endif
                    </div>

                    <div class="pt-8 border-t border-gray-200">
                        <div class="flex flex-wrap gap-y-2 text-[10px] uppercase font-bold text-gray-500 tracking-wider">
                            <span class="mr-2 text-gray-900">Best Suited For:</span>
                            @if ($serviceCategory->industries)
                                @foreach ($serviceCategory->industries as $industry)
                                    <span class="after:content-['•'] after:mx-2 after:text-gray-300">{{ $industry['name'] }}</span>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Image -->
                <div class="relative">
                    <img src="{{ Storage::url($serviceCategory->image) }}" alt="{{ $serviceCategory->title }}" class="w-full h-auto shadow-xl" />
                </div>
            </div>
        </div>
    </section>

    <div class="border-b border-gray-200 bg-white sticky top-0 z-30">
        <div class="max-w-7xl mx-auto px-4">
            <nav class="flex space-x-12">
                <button onclick="setActiveTab('features')" class="py-4 px-1 text-xs font-bold uppercase tracking-widest border-b-2 transition-colors border-[#FF5C00] text-gray-900" id="tab-features">
                    Features and Benefits
                </button>
                <button onclick="setActiveTab('documents')" class="py-4 px-1 text-xs font-bold uppercase tracking-widest border-b-2 transition-colors border-transparent text-gray-400 hover:text-gray-600" id="tab-documents">
                    Documents & Downloads
                </button>
                <button onclick="setActiveTab('support')" class="py-4 px-1 text-xs font-bold uppercase tracking-widest border-b-2 transition-colors border-transparent text-gray-400 hover:text-gray-600" id="tab-support">
                    Support
                </button>
            </nav>
        </div>
    </div>

    <!-- Features Tab Content -->
    <div id="content-features" class="max-w-7xl mx-auto px-4 py-12 space-y-24">
        <!-- Benefits Section -->
        <section class="grid md:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="text-4xl font-bold text-gray-900 mb-8">Benefits</h2>
                <ul class="space-y-8">
                    @if ($serviceCategory->benefits)
                        @foreach ($serviceCategory->benefits as $benefit)
                            <li>
                                <h3 class="text-xl font-semibold text-gray-900">{{ $benefit['title'] }}</h3>
                                <p class="mt-2 text-gray-600">{{ $benefit['description'] }}</p>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-96">
                @if ($serviceCategory->benefit_image)
                    <img src="{{ Storage::url($serviceCategory->benefit_image) }}" alt="Benefit Image" class="w-full h-full object-cover rounded-xl" />
                @endif
            </div>
        </section>

        <!-- Features Section (reversed layout) -->
        <section class="grid md:grid-cols-2 gap-12 items-center md:grid-flow-col-dense">
            <div class="md:col-start-2">
                <h2 class="text-4xl font-bold text-gray-900 mb-8">Features</h2>
                <ul class="space-y-8">
                    @if ($serviceCategory->features)
                        @foreach ($serviceCategory->features as $feature)
                            <li>
                                <h3 class="text-xl font-semibold text-gray-900">{{ $feature['title'] }}</h3>
                                <p class="mt-2 text-gray-600">{{ $feature['description'] }}</p>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="md:col-start-1 md:row-start-1 bg-gray-200 border-2 border-dashed rounded-xl w-full h-96">
                @if ($serviceCategory->feature_image)
                    <img src="{{ Storage::url($serviceCategory->feature_image) }}" alt="Feature Image" class="w-full h-full object-cover rounded-xl" />
                @endif
            </div>
        </section>
    </div>

    <!-- Documents Tab Content -->
    <div id="content-documents" class="max-w-7xl mx-auto px-4 py-24 text-center text-gray-500 hidden">
        <h2 class="text-2xl font-bold">Documents & Downloads</h2>
        @if ($serviceCategory->links)
            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach ($serviceCategory->links as $link)
                <a href="{{ $link['url'] }}" class="text-lg text-blue-600 hover:underline">{{ $link['label'] }}</a>
            @endforeach
            </div>
        @else
            <p class="mt-4">No documents available.</p>
        @endif
    </div>


    <!-- Support Tab Content -->
    <div id="content-support" class="max-w-7xl mx-auto px-4 py-24 text-center text-gray-500 hidden">
        <h2 class="text-2xl font-bold">Support</h2>
        <p class="mt-4">Our support team is available 24/7 for emergency outage assistance.</p>
    </div>


    @if ($serviceCategory->related_services)
    <section class="bg-gray-50 py-20">
        <div class="max-w-7xl mx-auto px-4">
            <h2 class="text-3xl font-light text-center mb-16">Related Products And Services</h2>

            <div class="grid md:grid-cols-2 gap-12">
                @foreach ($serviceCategory->related_services as $relatedServiceId)
                    @php
                        $relatedService = \App\Models\ServiceCategory::find($relatedServiceId);
                    @endphp
                    @if ($relatedService)
                        <div class="flex flex-col items-center text-center">
                            <div class="mb-6 w-full h-64 overflow-hidden">
                                <a href="{{ route('services.show', $relatedService->slug) }}">
                                <img src="{{ Storage::url($relatedService->image) }}" alt="{{ $relatedService->title }}" class="w-full h-full object-cover" />
                                </a>
                            </div>
                            <h3 class="text-[#009CDE] text-lg font-bold mb-4 uppercase tracking-tight">
                                <a href="{{ route('services.show', $relatedService->slug) }}">{{ $relatedService->title }}</a>
                            </h3>
                            <p class="text-xs text-gray-600 leading-relaxed text-justify px-4">
                                {{ $relatedService->short_description }}
                            </p>
                        </div>
                    @endif
                @endforeach
            </div>
        </div>
    </section>
    @endif


    <script>
        // Default active tab
        let activeTab = 'features';

        function setActiveTab(tab) {
            // Update active state
            activeTab = tab;

            // Update tab buttons
            document.getElementById('tab-features').className =
                tab === 'features' ?
                'py-4 px-1 text-xs font-bold uppercase tracking-widest border-b-2 transition-colors border-[#FF5C00] text-gray-900' :
                'py-4 px-1 text-xs font-bold uppercase tracking-widest border-b-2 transition-colors border-transparent text-gray-400 hover:text-gray-600';

            document.getElementById('tab-documents').className =
                tab === 'documents' ?
                'py-4 px-1 text-xs font-bold uppercase tracking-widest border-b-2 transition-colors border-[#FF5C00] text-gray-900' :
                'py-4 px-1 text-xs font-bold uppercase tracking-widest border-b-2 transition-colors border-transparent text-gray-400 hover:text-gray-600';

            document.getElementById('tab-support').className =
                tab === 'support' ?
                'py-4 px-1 text-xs font-bold uppercase tracking-widest border-b-2 transition-colors border-[#FF5C00] text-gray-900' :
                'py-4 px-1 text-xs font-bold uppercase tracking-widest border-b-2 transition-colors border-transparent text-gray-400 hover:text-gray-600';

            // Show/hide content
            document.getElementById('content-features').classList.toggle('hidden', tab !== 'features');
            document.getElementById('content-documents').classList.toggle('hidden', tab !== 'documents');
            document.getElementById('content-support').classList.toggle('hidden', tab !== 'support');
        }

        // Initialize correct state on load
        setActiveTab('features');
    </script>
</div>