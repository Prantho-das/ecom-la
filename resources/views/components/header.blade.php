{{-- resources/views/components/header.blade.php --}}
<header>
    <!-- Top Bar -->
    <div class="bg-[#27ad4c] text-white text-sm">
        <div class="container mx-auto px-4">
            <div class="py-2 flex flex-col sm:flex-row justify-between items-center gap-4">
                <div class="flex flex-wrap items-center gap-6 text-center sm:text-left">
                    <div class="flex items-center gap-2">
                        <x-icons.clock class="w-4 h-4" />
                        <span>Mon – Fri 8:00 – 18:00 / Sunday 8:00 – 14:00</span>
                    </div>
                    <div class="hidden md:flex items-center gap-2">
                        <x-icons.mail class="w-4 h-4" />
                        <a href="mailto:info@yourcompany.com" class="hover:underline">info@yourcompany.com</a>
                    </div>
                </div>

                <div class="hidden md:flex items-center gap-4">
                    <a href="#" aria-label="Facebook" class="hover:opacity-80">
                        <x-icons.facebook class="w-5 h-5" />
                    </a>
                    <a href="#" aria-label="Twitter" class="hover:opacity-80">
                        <x-icons.twitter class="w-5 h-5" />
                    </a>
                    <a href="#" aria-label="LinkedIn" class="hover:opacity-80">
                        <x-icons.linkedin class="w-5 h-5" />
                    </a>
                    <a href="#" aria-label="Instagram" class="hover:opacity-80">
                        <x-icons.instagram class="w-5 h-5" />
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <div class="bg-white sticky top-0 z-50 shadow-sm lg:shadow-none" x-data="{ mobileMenu: false }">
        <div class="container mx-auto px-4">
            <div class="flex items-center justify-between py-4 lg:py-6">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('assets/images/logo.svg') }}" alt="Company Logo" class="h-10 md:h-12 lg:h-14">
                    </a>
                </div>

                <!-- Search Bar (hidden on mobile) -->
                <div class="hidden sm:block flex-1 max-w-md mx-8">
                    <form action="{{ route('search') }}" method="GET" class="relative">
                        <input
                            type="text"
                            name="q"
                            placeholder="Search..."
                            class="w-full border border-gray-400 py-2 px-4 rounded-md focus:outline-none focus:ring-2 focus:ring-[#27ad4c] focus:border-transparent"
                        />
                        <button type="submit" class="absolute right-0 top-0 h-full px-4 bg-[#27ad4c] text-white rounded-r-md">
                            <x-icons.search class="w-5 h-5" />
                        </button>
                    </form>
                </div>

                <!-- Desktop Buttons -->
                <div class="hidden lg:flex items-center gap-6">
                    <a href="{{ route('login') }}" class="font-medium text-slate-700 hover:text-[#27ad4c]">Login</a>
                    <a href="{{ route('quote') }}"
                       class="bg-[#27ad4c] text-white font-bold py-2 px-6 rounded-md hover:bg-green-600 transition">
                        Get a Free Quotation
                    </a>
                </div>

                <!-- Mobile Menu Toggle -->
                <button @click="mobileMenu = !mobileMenu" class="lg:hidden text-[#27ad4c]">
                    <template x-if="!mobileMenu">
                        <x-icons.menu class="w-8 h-8" />
                    </template>
                    <template x-if="mobileMenu">
                        <x-icons.x class="w-8 h-8" />
                    </template>
                </button>
            </div>

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center gap-8 border-t border-gray-200 pt-4 pb-2">
                @foreach($navLinks as $link)
                    <a href="{{ $link->url }}"
                       class="font-semibold text-gray-800 hover:text-[#27ad4c] pb-3 border-b-2 border-transparent {{ request()->fullUrlIs($link->url) ? 'text-[#27ad4c] border-[#27ad4c]' : '' }}">
                        {{ $link->label }}
                    </a>
                @endforeach
            </nav>
        </div>

        <!-- Mobile Menu -->
        <div x-show="mobileMenu" x-transition class="lg:hidden bg-white border-t border-gray-200">
            <div class="container mx-auto px-4 py-6">
                <!-- Mobile Search -->
                <form action="{{ route('search') }}" method="GET" class="mb-6 sm:hidden">
                    <div class="relative">
                        <input
                            type="text"
                            name="q"
                            placeholder="Search..."
                            class="w-full border border-gray-400 py-2 px-4 rounded-md"
                        />
                        <button type="submit" class="absolute right-0 top-0 h-full px-4 bg-[#27ad4c] text-white rounded-r-md">
                            <x-icons.search class="w-5 h-5" />
                        </button>
                    </div>
                </form>

                <!-- Mobile Nav Links -->
                <nav class="flex flex-col gap-5 text-lg font-medium">
                    @foreach($navLinks as $link)
                        <a href="{{ $link->url }}"
                           class="text-gray-700 hover:text-[#27ad4c] {{ request()->fullUrlIs($link->url) ? 'text-[#27ad4c]' : '' }}">
                            {{ $link->label }}
                        </a>
                    @endforeach
                </nav>

                <!-- Mobile CTA Buttons -->
                <div class="mt-8 flex flex-col gap-4">
                    <a href="{{ route('login') }}" class="text-center font-medium text-gray-700 hover:text-[#27ad4c]">Login</a>
                    <a href="{{ route('quote') }}"
                       class="text-center bg-[#27ad4c] text-white font-bold py-3 px-6 rounded-md hover:bg-green-600 transition">
                        Get a Free Quotation
                    </a>
                </div>
            </div>
        </div>
    </div>
</header>