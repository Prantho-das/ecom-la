<div class="pt-4 bg-white lg:pt-8">
  <div class="container lg:max-w-[1780px] mx-auto px-4">
    
    <section
      class="relative bg-white lg:h-[660px] md:h-[600px] h-[480px] bg-cover bg-center text-white flex items-center rounded-2xl overflow-hidden"
      style="background-image: url('{{ $backgroundImage ? asset('storage/' . $backgroundImage) : '/assets/images/hero.jpg' }}');"
    >
      <!-- Overlay -->
      <div class="absolute inset-0 bg-black opacity-40"></div>

      <div class="z-10 h-full b-0">
        <div class="absolute left-0 flex flex-col w-full gap-8 p-5 lg:flex-row lg:justify-between lg:items-end bottom-14 md:p-14">
          <!-- Text Section -->
          <div class="max-w-3xl">
            <p class="mb-4 text-lg md:text-xl">
              {{ $subtitle }}
            </p>
            <h1 class="text-4xl font-bold leading-tight md:text-5xl lg:text-7xl">
              {!! $title !!}
            </h1>
          </div>

          <!-- Button -->
          <a href="{{ $ctaLink }}"
            class="bg-orange-500 hover:bg-orange-600 text-white font-semibold py-3 px-8 rounded-full transition-colors text-md inline-block max-w-[200px] text-center">
            {{ $ctaText }}
          </a>
        </div>
      </div>
    </section>
  </div>
</div>
