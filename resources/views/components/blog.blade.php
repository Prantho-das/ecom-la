<section class="lg:py-24 md:py-16 py-10 bg-white">
  <div class="container mx-auto px-4">

    <!-- Section Title -->
    <div class="text-center mb-12">
      <p class="text-[#27ad4c] font-semibold tracking-wider mb-2">READ OUR BLOG</p>
      <h2 class="text-4xl md:text-5xl font-bold text-slate-900">Latest News</h2>
    </div>

    <!-- Blog Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
        @forelse($posts as $post)
            <div class="bg-white rounded-2xl shadow-lg overflow-hidden group hover:shadow-2xl transition-shadow duration-300">
                <div class="relative overflow-hidden">
                    <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500">
                    <div class="absolute bottom-[-20px] right-6 bg-slate-900 text-white text-center rounded-md p-2 w-16">
                        <span class="text-2xl font-bold block">{{ $post->published_at->format('d') }}</span>
                        <span class="text-xs font-semibold block">{{ $post->published_at->format('M') }}</span>
                    </div>
                </div>
                <div class="p-8">
                    <p class="text-sm text-slate-500 mb-2">
                        <span class="text-[#27ad4c] font-semibold">BLOG</span> • 0 Comments
                    </p>
                    <h3 class="text-xl font-bold text-slate-900 leading-tight group-hover:text-[#27ad4c] transition-colors">
                        <a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a>
                    </h3>
                </div>
            </div>
        @empty
            <p class="text-gray-500 col-span-full text-center">No latest news available.</p>
        @endforelse
    </div>

    <!-- Read More Button -->
    <div class="text-center mt-12">
      <button class="bg-[#27ad4c] text-white font-bold py-3 px-8 rounded-full hover:bg-[#1e8c3c] transition-colors">
        Read More
      </button>
    </div>

  </div>
</section>
