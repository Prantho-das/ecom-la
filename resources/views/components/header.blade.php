<header>
    <!-- Top Bar -->
    <div class="bg-[#27ad4c] text-white text-sm">
        <div class="container lg:max-w-[1780px] mx-auto px-4">
            <div class="flex items-center justify-between py-2">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-1">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-5">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                        </svg>
                        <span>Mon – Fri 8:00 – 18:00 / Sunday 8:00 – 14:00</span>
                    </div>

                    <div class="items-center hidden space-x-1 md:flex">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                        </svg>

                        <a href="mailto:info@" class="hover:underline">info@datohall.com</a>
                    </div>
                </div>

                {{-- <div class="items-center hidden space-x-3 md:flex">
                    <a href="#">
                        <!-- Facebook -->
                    </a>
                    <a href="#">
                        <!-- Twitter -->
                    </a>
                    <a href="#">
                        <!-- Linkedin -->
                    </a>
                    <a href="#">
                        <!-- Instagram -->
                    </a>
                </div> --}}

                <x-social-media />
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <div class="sticky top-0 z-50 bg-white shadow-sm lg:shadow-none">
        <div class="container lg:max-w-[1780px] mx-auto px-4">
            <div class="flex items-center justify-between py-3 md:py-6">
                @php
                    $serviceCategories = \App\Models\ServiceCategory::where('published', 1)
                    ->with(['parent', 'children'])
                    ->where('parent_id', null)
                    ->get();
                    $solutionCategories = \App\Models\SolutionCategory::where('published', 1)
                    ->with(['parent', 'children'])
                    ->where('parent_id', null)
                    ->get();
                @endphp
                <!-- Logo -->
                <div class="lg:w-[150px] md:w-[150px] w-[120px]">
                    <a href="{{ route('home') }}" wire:navigate>
                        @php
                            $site_logo = getSetting('logo');
                        @endphp
                        <img src="{{ $site_logo ? asset('storage/' . $site_logo) : asset('assets/images/logo.svg') }}"
                            alt="Logo" class="h-[40px]" />
                    </a>
                </div>

                <!-- Search Box -->
                <div class="relative hidden w-5/10 sm:block">
                    <form action="{{ route('category') }}">


                        <input type="text" placeholder="Search" name="search"
                            class="border border-gray-400 py-1.5 px-3 w-full focus:outline-none focus:ring-1 focus:ring-[#27ad4c]" />
                        <button class="absolute right-0 top-0 h-full px-2 text-white bg-[#27ad4c]">
                            <!-- SearchIcon -->
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>

                        </button>
                    </form>
                </div>

                <!-- Desktop Links -->
                <div class="items-center hidden space-x-4 lg:flex">
                    <a href="#" class="font-medium text-slate-700 hover:text-[#27ad4c]">Login</a>
                    <a href="#"
                        class="bg-[#27ad4c] text-white font-bold py-2 px-4 rounded-md hover:bg-[#27ad4c] transition-colors">
                        Get a Free Quotation
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="lg:hidden">
                    <div class="drawer">
                        <input id="my-drawer-1" type="checkbox" class="drawer-toggle" />
                        <div class="drawer-content">
                            <!-- Page content here -->
                            <label for="my-drawer-1" class="btn drawer-button">

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                </svg>
                            </label>

                        </div>
                        <div class="drawer-side">
                            <label for="my-drawer-1" aria-label="close sidebar" class="drawer-overlay"></label>

                            <div class="min-h-full px-4 py-4 bg-white shadow-lg w-80">

                                <div class="relative w-full mb-4 sm:hidden">
                                    <input type="text" placeholder="Search"
                                        class="border border-gray-400 py-1.5 px-3 w-full focus:outline-none focus:ring-1 focus:ring-[#27ad4c]" />
                                    <button class="absolute right-0 top-0 h-full px-2 text-white bg-[#27ad4c]">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                                        </svg>
                                    </button>
                                </div>

                               <nav class="flex flex-col space-y-4 font-medium text-slate-700">
                                    <a href="{{ route('home') }}" wire:navigate class="pb-2 hover:text-[#27ad4c]">
                                        Home
                                    </a>

                                    <!-- Services Main Accordion -->
                                    <div x-data="{ open: false }">
                                        <button @click="open = !open"
                                            class="flex items-center justify-between w-full pb-2 font-medium text-slate-700 hover:text-[#27ad4c]">
                                            <a href="{{ url('/services') }}" wire:navigate>
                                                <span>Services</span>
                                            </a>
                                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>

                                        <div x-show="open" x-collapse class="pt-2 pl-4">
                                            <div class="flex flex-col gap-3">
                                                @foreach ($serviceCategories as $parentCategory)
                                                <div x-data="{ categoryOpen: false }">
                                                    <button @click="categoryOpen = !categoryOpen"
                                                        class="flex items-center justify-between w-full py-2 text-sm font-semibold text-gray-800 hover:text-[#27ad4c]">
                                                        <a href="{{ url('/services') }}?category_id={{ $parentCategory->slug }}" wire:navigate
                                                            class="block w-full text-left">
                                                            {{ $parentCategory->title }}
                                                        </a>
                                                        <svg :class="{ 'rotate-180': categoryOpen }"
                                                            class="flex-shrink-0 w-4 h-4 ml-2 transition-transform" xmlns="http://www.w3.org/2000/svg"
                                                            fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                        </svg>
                                                    </button>

                                                    <div x-show="categoryOpen" x-collapse class="pl-4">
                                                        <ul class="py-1 space-y-1 text-sm">
                                                            @foreach ($parentCategory->children as $child)
                                                            <li>
                                                                <a href="{{ url('/services') }}?category_id={{ $child->id }}" wire:navigate
                                                                    class="block py-1 hover:text-[#27ad4c]">
                                                                    {{ $child->title }}
                                                                </a>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
<div x-data="{ open: false }">
                                        <button @click="open = !open"
                                            class="flex items-center justify-between w-full pb-2 font-medium text-slate-700 hover:text-[#27ad4c]">
                                            <a href="{{ url('/solutions') }}" wire:navigate>
                                                <span>Solutions</span>
                                            </a>
                                            <svg class="w-4 h-4 transition-transform" :class="{ 'rotate-180': open }" xmlns="http://www.w3.org/2000/svg"
                                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>

                                        <div x-show="open" x-collapse class="pt-2 pl-4">
                                            <div class="flex flex-col gap-3">
                                                @foreach ($solutionCategories as $parentCategory)
                                                <div x-data="{ categoryOpen: false }">
                                                    <button @click="categoryOpen = !categoryOpen"
                                                        class="flex items-center justify-between w-full py-2 text-sm font-semibold text-gray-800 hover:text-[#27ad4c]">
                                                        <a href="{{ url('/solutions') }}?category_id={{ $parentCategory->slug }}" wire:navigate
                                                            class="block w-full text-left">
                                                            {{ $parentCategory->title }}
                                                        </a>
                                                        <svg :class="{ 'rotate-180': categoryOpen }" class="flex-shrink-0 w-4 h-4 ml-2 transition-transform"
                                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                                            stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                        </svg>
                                                    </button>

                                                    <div x-show="categoryOpen" x-collapse class="pl-4">
                                                        <ul class="py-1 space-y-1 text-sm">
                                                            @foreach ($parentCategory->children as $child)
                                                            <li>
                                                                <a href="{{ url('/solutions') }}?category_id={{ $child->id }}" wire:navigate
                                                                    class="block py-1 hover:text-[#27ad4c]">
                                                                    {{ $child->title }}
                                                                </a>
                                                            </li>
                                                            @endforeach
                                                        </ul>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <a href="{{ route('reseller.partner') }}" wire:navigate class="pb-2 hover:text-[#27ad4c]">
                                        Reseller
                                    </a>

                                    <a href="{{ route('category') }}" wire:navigate class="pb-2 hover:text-[#27ad4c]">
                                        Product
                                    </a>

                                    <div class="flex flex-col pt-4 space-y-4">
                                        <a href="#" class="font-medium text-slate-700 hover:text-[#27ad4c]">Login</a>
                                        <a href="#"
                                            class="bg-[#27ad4c] text-white text-center font-bold py-2 px-4 rounded-md hover:bg-[#1e8b3a] transition">
                                            Get a Free Quotation
                                        </a>
                                    </div>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Desktop Navigation with Mega Menu -->
            <div class="relative">
                <nav class="items-center hidden space-x-6 font-semibold text-black lg:flex">
                    <a href="{{ route('home') }}" wire:navigate
                        class="pb-2 {{ request()->routeIs('home') ? 'text-[#27ad4c] border-b-2 border-[#27ad4c]' : 'hover:text-[#27ad4c]' }}">
                        Home
                    </a>

                    <a href="{{ route('category') }}" wire:navigate class="pb-2 hover:text-[#27ad4c]">
                        Product
                    </a>

                    <!-- Products Menu Item with Mega Menu -->
                    <div class="group">
                        <a href="{{ url('/services') }}" wire:navigate
                            class="pb-2 hover:text-[#27ad4c] flex items-center">
                            Services
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </a>

                        <!-- Mega Menu (full width) -->
                        <div
                            class="absolute left-0 right-0 top-full opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 bg-white shadow-lg border-t-2 border-[#27ad4c] z-50">
                            <div class="px-4 py-8 ">

                                <div class="flex flex-col hidden w-full gap-8 md:flex-row " x-data="{ activeTab: 'tab2' }">
                                    <!-- Tabs on the left -->
                                    <div class="flex flex-col w-64 gap-2">
                                        @foreach ($serviceCategories as $servicCategory)
                                            <button @click="activeTab = '{{ $servicCategory->slug }}'"
                                                :class="activeTab === '{{ $servicCategory->slug }}' ?
                                                    'bg-[#27ad4c] text-white' :
                                                    'text-gray-700 hover:bg-gray-100 hover:text-[#27ad4c]'"
                                                class="block px-4 py-2 text-left transition-colors duration-200 rounded-md"
                                                aria-label="Tab 1">
                                                {{ $servicCategory->title }}
                                            </button>
                                        @endforeach


                                    </div>

                                    <!-- Content on the right - with fixed height behavior -->
                                    <div class="relative w-full mt-6 bg-white md:mt-0 min-h-96 md:min-h-screen-lg">
                                        <!-- Wrapper with relative positioning and min-height -->
                                        <div class="absolute inset-0 overflow-y-auto">
                                            <!-- All tab panels are absolutely positioned in the same space -->

                                            @foreach($serviceCategories as $servicCategory)
                                            <div x-show="activeTab === '{{$servicCategory->slug}}'" x-transition.opacity
                                                class="absolute inset-0 w-full p-4 overflow-y-auto prose border border-base-300 rounded-box">


                                                    <h2 class="mb-4 text-2xl font-bold">{{ $servicCategory->title }}
                                                    </h2>
                                                    <p class="mb-4 font-light">
                                                        {{ $servicCategory->short_description }}</p>
                                                    <!-- Add more content here if needed -->
                                                    <div class="grid grid-cols-4 gap-3">
                                                        <!-- Example Mega Menu Columns -->
                                                        <div>
                                                            @php
                                                                $searvices = \App\Models\Service::where(
                                                                    'published',
                                                                    true,
                                                                )
                                                                    ->whereHas('categories', function ($q) use (
                                                                        $servicCategory,
                                                                    ) {
                                                                        $q->where(
                                                                            'service_service_category.service_category_id',
                                                                            $servicCategory->id,
                                                                        );
                                                                    })
                                                                    ->get();
                                                            @endphp
                                                            <ul class="space-y-1 font-normal">
                                                                @foreach ($searvices as $service)
                                                                    <li><a href="{{ route('services.show', $service->slug) }}"
                                                                            wire:navigate
                                                                            class="hover:text-[#27ad4c]">{{ $service->title }}</a>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>

                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-5 gap-8">
                                    <!-- Example Mega Menu Columns -->
                                    @foreach ($serviceCategories as $servicCategory)
                                    <div>
                                        <h3 class="font-bold text-lg mb-4 text-[#27ad4c]">
                                            <a href="{{ url('/services') }}?category_id={{ $servicCategory->slug }}" wire:navigate>
                                            {{ $servicCategory->title }}</a>
                                        </h3>
                                        <ul class="space-y-2">
                                            @foreach($servicCategory->children as $child)
                                            <li><a href="{{ url('/services') }}?category_id={{ $child->id }}" wire:navigate class="hover:text-[#27ad4c]">{{ $child->title }}</a></li>
                                            @endforeach

                                        </ul>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Products Menu Item with Mega Menu -->
                    <div class="group">
                        <a href="{{ url('/solutions') }}" wire:navigate
                            class="pb-2 hover:text-[#27ad4c] flex items-center">
                            Solutions
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-1">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </a>

                        <!-- Mega Menu (full width) -->
                        <div
                            class="absolute left-0 right-0 top-full opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 bg-white shadow-lg border-t-2 border-[#27ad4c] z-50">
                            <div class="px-4 py-8 ">
                                <div class="grid grid-cols-5 gap-8">
                                    <!-- Example Mega Menu Columns -->
                                    @foreach ($solutionCategories as $solutionCategory)
<div>
                                        <h3 class="font-bold text-lg mb-4 text-[#27ad4c]">
                                            <a href="{{ url('/solutions') }}?category_id={{ $solutionCategory->slug }}" wire:navigate>
                                            {{ $solutionCategory->title }}
                                        </a>
                                        </h3>
                                        <ul class="space-y-2">
                                            @foreach($solutionCategory->children as $child)
                                            <li><a href="{{ url('/solutions') }}?category_id={{ $child->id }}" class="hover:text-[#27ad4c]" wire:navigate>{{ $child->title }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    @endforeach

                                </div>
                            </div>
                        </div>
                    </div>
                    <a href="{{ route('reseller.partner') }}" wire:navigate class="pb-2 hover:text-[#27ad4c]">
                        Reseller
                    </a>
                    <a href="{{ route('contact') }}" wire:navigate class="pb-2 hover:text-[#27ad4c]">
                        Contact
                    </a>
                </nav>
            </div>

        </div>
    </div>
</header>
