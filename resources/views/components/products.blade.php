<section class="py-10 lg:py-24 md:py-16 bg-slate-50 {{ empty($products) ? 'hidden' : '' }}">
    <div class="lg:max-w-[1780px] mx-auto px-4  ">

        <!-- Header -->
        <div class="flex items-center justify-between mb-12">
            <h2 class="text-4xl font-bold md:text-5xl text-slate-900">New Products</h2>
            <a href="{{ route('category') }}"
                class="flex items-center space-x-2 text-slate-600 hover:text-[#27ad4c] font-medium transition duration-300">
                <div class="flex items-center justify-center w-8 h-8 p-1 border rounded-full border-slate-400">
                    <x-heroicon-o-arrow-up-right />
                </div>
                <span>View All Product</span>
            </a>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-5">

            <!-- Product 1 -->
            @foreach ($products as $product)
                <a


                       @click="
            $dispatch('open-product-modal', {{ json_encode(['slug' => $product->slug]) }});
            my_modal_3.showModal();
        "


        >
                    <div
                        class="bg-white h-full rounded-lg shadow-md p-4 text-center group transition-all duration-300 hover:shadow-xl hover:-translate-y-1 hover:scale-[1.02]">
                        <div
                            class="relative flex items-center justify-center h-56 mb-4 overflow-hidden border border-gray-100 rounded-lg">
                            <img src="{{ $product->thumbnail ? asset('storage/' . $product->thumbnail) : 'https://placehold.co/600x400?text=' . $product->name }}"
                                alt={{ $product->name }} class="object-cover max-w-full max-h-full aspect-square">
                        </div>
                        <h3 class="font-bold text-slate-800 group-hover:text-[#27ad4c]">{{ $product->name }}</h3>
                    </div>
                </a>
            @endforeach




        </div>
    </div>
</section>
