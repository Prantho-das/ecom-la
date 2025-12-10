<dialog x-data="{ productSlug: '' }" @open-product-modal.window="productSlug = $event.detail.slug" id="my_modal_3"
    class="modal rounden-0">
    <div class="modal-box p-0 w-11/12 max-w-6xl h-[90vh]">
        <form method="dialog">
            <button class="absolute btn btn-sm btn-circle btn-ghost right-2 top-2">✕</button>
        </form>
        @php
            $firstContinent = null;
            $continents = cache()->rememberForever(
                'continents',
                fn() => DB::table('continents')->orderBy('name')->get(),
            );
            $firstContinent = $continents->first()->id;
        @endphp


        <div class="flex h-full" x-data="{ activeTab: '{{ $firstContinent }}' }">

            <!-- Vertical Tabs Sidebar -->
            <div class="bg-white border-r border-gray-200 lg:w-64 md:w-40">
                <div class="justify-center px-4 py-3 mb-0 text-center bg-white border-b border-gray-200">
                    <h2 class="text-2xl font-semibold text-center text-black">
                        Continent
                    </h2>
                </div>
                <div class="flex-col h-full tabs tabs-boxed ">

                    @foreach ($continents as $key => $conti)
                        <a class="h-12 text-base font-medium tab tab-lg "
                            :class="{ 'tab-active bg-green-600 text-white font-semibold': activeTab === '{{ $conti->id }}' }"
                            @click="activeTab = '{{ $conti->id }}'">
                            {{ $conti->name }}
                        </a>
                    @endforeach
                </div>
            </div>

            <!-- Tab Content Area - NOW WITH bg-gray-100 -->
            <div class="flex-1 overflow-y-auto bg-white">

                <!-- Asia -->
                @foreach ($continents as $conti)
                    @php

                        $countries = \DB::table('countries')->where('continent_id', $conti->id)->orderBy('name')->get();
                    @endphp
                    <div x-show="activeTab === '{{ $conti->id }}'" class="space-y-6">
                        <div class="px-4 py-3 mb-0 bg-white border-b border-gray-200">
                            <h2 class="flex items-center gap-3 text-2xl font-semibold text-black">
                                {{ $conti->name }} <span class="badge badge-ghost bg-white border-1 border-gray-400 text-gray-400 !text-sm">{{ count($countries) }} Countries</span>
                            </h2>
                        </div>
                        <div class="grid grid-cols-2 gap-2 p-4 bg-white sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6">
                            @foreach ($countries as $country)
                                <a
                                    @click.prevent="window.location.href = '/details/' + productSlug + '?country={{ $country->code }}'">
                                    <div class="text-gray-800 cursor-pointer text-start hover:text-green-600">
                                        <h3 class="text-sm font-base">{{ $country->name }}</h3>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                        <div class="text-center">
                            <button class="btn btn-sm">Load More</button>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
</dialog>
