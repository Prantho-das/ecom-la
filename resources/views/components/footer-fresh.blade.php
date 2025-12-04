<footer class="bg-white">
    <div class="mx-auto max-w-7xl overflow-hidden px-6 py-12 sm:py-16 lg:px-8">
        <nav class="-mb-6 columns-2 sm:flex sm:justify-center sm:space-x-12" aria-label="Footer">
            @if(isset($navLinks))
                @foreach($navLinks->take(4) as $link)
                    <div class="pb-6">
                        <a href="{{ $link->url }}" class="text-sm leading-6 text-gray-600 hover:text-gray-900">{{ $link->label }}</a>
                    </div>
                @endforeach
            @else
                <div class="pb-6">
                    <a href="#" class="text-sm leading-6 text-gray-600 hover:text-gray-900">Link 1</a>
                </div>
                <div class="pb-6">
                    <a href="#" class="text-sm leading-6 text-gray-600 hover:text-gray-900">Link 2</a>
                </div>
            @endif
        </nav>
        <p class="mt-10 text-center text-xs leading-5 text-gray-500">&copy; {{ date('Y') }} {{ config('app.name', 'Laravel') }}. All rights reserved.</p>
    </div>
</footer>
