<section class="lg:py-24 md:py-16 py-10 bg-white">
  <div class="container lg:max-w-[1780px] mx-auto px-4  ">
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-12">
        @forelse($featuresList as $feature)
            <div class="flex items-start space-x-4">

                <div class="text-orange-500 mt-1 text-5xl">{!! $feature['icon'] !!}</div>
                <div>
                    <h3 class="font-bold text-xl mb-2 text-slate-900">{{ $feature['title'] }}</h3>
                    <p class="text-slate-600">
                        {{ $feature['description'] }}
                    </p>
                </div>
            </div>
        @empty
            <p class="text-gray-500 col-span-full text-center">No features available.</p>
        @endforelse
    </div>
  </div>
</section>
