<section class="py-10 bg-white lg:py-24 md:py-16">
    <div class="container px-4 mx-auto">
        <div class="flex flex-col items-center justify-center w-full gap-12 lg:flex-row">

            <!-- Left Content -->
            <div class="pr-0 lg:pr-12">
                <p class="mb-2 font-semibold tracking-wider text-lime-600">
                    {{ $subtitle }}
                </p>
                <h2 class="mb-6 text-4xl font-bold md:text-5xl text-slate-900">
                    {{ $title}}
                </h2>
                <p class="mb-6 text-slate-600">
                    {!! $description !!}
                </p>

                @if(!empty($listItems))
                <ul class="mb-8 space-y-3 text-slate-700">
                    @foreach($listItems as $item)
                    <li class="flex items-center">
                        <span>✅</span>
                        <span class="ml-3">{{ $item['item'] }}</span>
                    </li>
                    @endforeach
                </ul>
                @endif

                <a href="{{ $buttonLink }}"
                    class="px-8 py-3 font-bold text-white transition-colors rounded-full bg-slate-900 hover:bg-slate-800">
                    {{ $buttonText }}
                </a>
            </div>

            <!-- Right Content -->
            <div class="relative mx-auto">
                <img src="{{ $image ? asset('storage/' . $image) : 'https://picsum.photos/seed/dam/500/600' }}"
                    alt="{{ $title }}" class="h-auto shadow-xl rounded-2xl" />

                <!-- Stats Cards -->
                <div class="absolute flex flex-col w-full gap-4 bottom-8 sm:-left-12 left-8 lg:flex-col xl:flex-row">
                    <div class="bg-[#a4cc1c] text-white p-8 rounded-2xl shadow-lg w-64">
                        <p class="font-semibold">{{ $stat1Title }}</p>
                        <p class="text-4xl font-bold md:text-6xl">{{ $stat1Value }}</p>
                        <p class="mt-2 text-sm">{{ $stat1Description }}</p>
                    </div>

                    <div class="bg-[#002134] text-white p-8 rounded-2xl shadow-lg w-64">
                        <p class="font-semibold">{{ $stat2Title }}</p>
                        <p class="text-4xl font-bold md:text-6xl">{{ $stat2Value }}</p>
                        <p class="mt-2 text-sm">{{ $stat2Description }}</p>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>
