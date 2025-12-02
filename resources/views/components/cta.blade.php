<section class="bg-[#27ad4c]">
  <div class="container px-4 py-10 mx-auto lg:py-24 md:py-16">
    <div class="flex flex-col items-center justify-between gap-8 text-center lg:flex-row lg:text-start">
      <div>
        <h2 class="mb-4 text-3xl font-bold text-white md:text-4xl">
          {!! $title !!}
        </h2>
        <p class="max-w-2xl mx-auto mb-8 text-white lg:mx-0">
          {!! $description !!}
        </p>
      </div>

      <!-- Button -->
      <a href="{{ $buttonLink }}" class="bg-[#27ad4c] text-white border-2 border-white font-bold py-2.5 px-8 rounded-md hover:bg-white hover:border-white hover:text-[#27ad4c] transition-colors">
        {{ $buttonText }}
      </a>

    </div>
  </div>
</section>
