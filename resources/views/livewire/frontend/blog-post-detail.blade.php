<section class="max-w-4xl mx-auto py-8 px-4">
    <article class="prose lg:prose-xl">
        <h1>{{ $post->title }}</h1>
        <p class="text-gray-500 text-sm">Published on {{ $post->published_at->format('M d, Y') }} by {{ $post->user->name }}</p>
        @if($post->thumbnail)
            <img src="{{ asset('storage/' . $post->thumbnail) }}" alt="{{ $post->title }}" class="w-full h-auto object-cover mb-4 rounded-lg">
        @endif
        <div>
            {!! $post->content !!}
        </div>
    </article>
</section>
