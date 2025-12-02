<section class="lg:py-24 md:py-16 py-10 bg-white">
  <div class="container mx-auto px-4">
    <div class="flex flex-col lg:flex-row gap-12 justify-center items-center w-full">

      <!-- Left Content -->
      <div class="pr-0 lg:pr-12">
        <p class="text-lime-600 font-semibold tracking-wider mb-2">
          {{ $subtitle }}
        </p>
        <h2 class="text-4xl md:text-5xl font-bold text-slate-900 mb-6">
          {!! $title !!}
        </h2>
        <p class="text-slate-600 mb-6">
          {!! $description !!}
        </p>

        @if(!empty($listItems))
        <ul class="space-y-3 text-slate-700 mb-8">
          @foreach($listItems as $item)
          <li class="flex items-center">
            <span>✅</span>
            <span class="ml-3">{{ $item['item'] }}</span>
          </li>
          @endforeach
        </ul>
        @endif

        <a href="{{ $buttonLink }}" class="bg-slate-900 text-white font-bold py-3 px-8 rounded-full hover:bg-slate-800 transition-colors">
          {{ $buttonText }}
        </a>
      </div>

      <!-- Right Content -->
      <div class="relative mx-auto">
        <img
          src="{{ $image ? asset('storage/' . $image) : 'https://picsum.photos/seed/dam/500/600' }}"
          alt="{{ $title }}"
          class="rounded-2xl shadow-xl h-auto"
        />

        <!-- Stats Cards -->
        <div class="absolute bottom-8 sm:-left-12 left-8 flex lg:flex-col xl:flex-row flex-col w-full gap-4">
          <div class="bg-[#a4cc1c] text-white p-8 rounded-2xl shadow-lg w-64">
            <p class="font-semibold">{{ $stat1Title }}</p>
            <p class="md:text-6xl text-4xl font-bold">{{ $stat1Value }}</p>
            <p class="text-sm mt-2">{{ $stat1Description }}</p>
          </div>

          <div class="bg-[#002134] text-white p-8 rounded-2xl shadow-lg w-64">
            <p class="font-semibold">{{ $stat2Title }}</p>
            <p class="md:text-6xl text-4xl font-bold">{{ $stat2Value }}</p>
            <p class="text-sm mt-2">{{ $stat2Description }}</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>
