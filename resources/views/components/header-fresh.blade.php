<header x-data="{ atTop: window.scrollY === 0 }"
        @scroll.window="atTop = (window.scrollY > 50) ? false : true"
        :class="{
            'bg-transparent border-none': atTop && {{ request()->is('/') ? 'true' : 'false' }},
            'border-b border-gray-200 bg-white/80 backdrop-blur-sm': !atTop || !{{ request()->is('/') ? 'true' : 'false' }}
        }"
        class="sticky top-0 z-50 w-full transition-all">

    <div class="flex h-16 items-center px-4 sm:px-6 lg:px-8 container mx-auto">
        <!-- Left section - Logo -->
        <div class="flex-none">
            <a class="flex items-center space-x-2" href="{{ route('home') }}">
                <x-app-logo class="h-10" />
            </a>
        </div>

        <!-- Center section - Spacer -->
        <div class="flex-1 flex justify-center">
            {{-- Placeholder for middle content if needed --}}
        </div>

        <!-- Right section - Navigation links -->
        <div class="flex-none flex items-center space-x-6">
            @if(isset($navLinks))
                @foreach($navLinks->take(2) as $link)
                    <a href="{{ $link->url }}"
                       class="text-sm text-gray-600 hover:text-blue-600 transition-all hover:-translate-y-0.5">
                        {{ $link->label }}
                    </a>
                @endforeach
            @else
                <a href="/" class="text-sm text-gray-600 hover:text-blue-600 transition-all hover:-translate-y-0.5">Home</a>
                <a href="#" class="text-sm text-gray-600 hover:text-blue-600 transition-all hover:-translate-y-0.5">About</a>
            @endif
        </div>
    </div>
</header>
