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

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                </svg>
                            </label>

                        </div>
                        <div class="drawer-side">
                            <label for="my-drawer-1" aria-label="close sidebar" class="drawer-overlay"></label>

                            <div class=" px-4 py-4 bg-white shadow-lg min-h-full w-80">

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

                                    <div x-data="{ open: false }">
                                        <button @click="open = !open" class="flex items-center justify-between w-full pb-2 font-medium text-slate-700 hover:text-[#27ad4c]">
                                            <span>Megamenu</span>
                                            <svg class="w-4 h-4 transition-transform" :class="{'rotate-180': open}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                        <div x-show="open" x-collapse class="pt-2 pl-4">
                                            <div class="flex flex-col gap-2">
                                                <!-- Accordion Item 1 -->
                                                <div x-data="{ tabOpen: true }">
                                                    <button @click="tabOpen = !tabOpen" class="flex items-center justify-between w-full py-2 text-sm font-semibold text-gray-800">
                                                        <span>Tab 1</span>
                                                        <svg :class="{'rotate-180': tabOpen}" class="w-4 h-4 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                        </svg>
                                                    </button>
                                                    <div x-show="tabOpen" x-collapse class="pt-2 pl-2 text-sm">
                                                        
                                                        <div class="flex flex-col gap-2 text-xs">
                                                            <div class="pl-3" x-data="{ categoryOpen: false }">
                                                                <button @click="categoryOpen = !categoryOpen" class="flex items-center justify-between w-full py-1 text-sm font-medium">
                                                                    <span>Category 1</span>
                                                                    <svg :class="{'rotate-180': categoryOpen}" class="w-3 h-3 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                                    </svg>
                                                                </button>
                                                                <div x-show="categoryOpen" x-collapse class="pl-3">
                                                                    <ul class="py-1 space-y-1 font-normal">
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 1</a></li>
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 2</a></li>
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 3</a></li>
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 4</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="pl-3" x-data="{ categoryOpen: false }">
                                                                <button @click="categoryOpen = !categoryOpen" class="flex items-center justify-between w-full py-1 text-sm font-medium">
                                                                    <span>Category 2</span>
                                                                    <svg :class="{'rotate-180': categoryOpen}" class="w-3 h-3 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                                    </svg>
                                                                </button>
                                                                <div x-show="categoryOpen" x-collapse class="pl-3">
                                                                    <ul class="py-1 space-y-1 font-normal">
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 5</a></li>
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 6</a></li>
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 7</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="pl-3" x-data="{ categoryOpen: false }">
                                                                <button @click="categoryOpen = !categoryOpen" class="flex items-center justify-between w-full py-1 text-sm font-medium">
                                                                    <span>Category 3</span>
                                                                    <svg :class="{'rotate-180': categoryOpen}" class="w-3 h-3 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                                    </svg>
                                                                </button>
                                                                <div x-show="categoryOpen" x-collapse class="pl-3">
                                                                    <ul class="py-1 space-y-1 font-normal">
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 8</a></li>
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 9</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Accordion Item 2 -->
                                                <div x-data="{ tabOpen: false }">
                                                    <button @click="tabOpen = !tabOpen" class="flex items-center justify-between w-full py-2 text-sm font-semibold text-gray-800">
                                                        <span>Tab 2</span>
                                                        <svg :class="{'rotate-180': tabOpen}" class="w-4 h-4 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                        </svg>
                                                    </button>
                                                    <div x-show="tabOpen" x-collapse class="pt-2 pl-2 text-sm">
                                                        <div class="flex flex-col gap-2 text-xs">
                                                            <div class="pl-3" x-data="{ categoryOpen: false }">
                                                                <button @click="categoryOpen = !categoryOpen" class="flex items-center justify-between w-full py-1 text-sm font-medium">
                                                                    <span>Category 1</span>
                                                                    <svg :class="{'rotate-180': categoryOpen}" class="w-3 h-3 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                                    </svg>
                                                                </button>
                                                                <div x-show="categoryOpen" x-collapse class="pl-3">
                                                                    <ul class="py-1 space-y-1 font-normal">
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 1</a></li>
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 2</a></li>
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 3</a></li>
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 4</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="pl-3" x-data="{ categoryOpen: false }">
                                                                <button @click="categoryOpen = !categoryOpen" class="flex items-center justify-between w-full py-1 text-sm font-medium">
                                                                    <span>Category 2</span>
                                                                    <svg :class="{'rotate-180': categoryOpen}" class="w-3 h-3 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                                    </svg>
                                                                </button>
                                                                <div x-show="categoryOpen" x-collapse class="pl-3">
                                                                    <ul class="py-1 space-y-1 font-normal">
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 5</a></li>
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 6</a></li>
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 7</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="pl-3" x-data="{ categoryOpen: false }">
                                                                <button @click="categoryOpen = !categoryOpen" class="flex items-center justify-between w-full py-1 text-sm font-medium">
                                                                    <span>Category 3</span>
                                                                    <svg :class="{'rotate-180': categoryOpen}" class="w-3 h-3 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                                    </svg>
                                                                </button>
                                                                <div x-show="categoryOpen" x-collapse class="pl-3">
                                                                    <ul class="py-1 space-y-1 font-normal">
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 8</a></li>
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 9</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Accordion Item 3 -->
                                                <div x-data="{ tabOpen: false }">
                                                    <button @click="tabOpen = !tabOpen" class="flex items-center justify-between w-full py-2 text-sm font-semibold text-gray-800">
                                                        <span>Tab 3</span>
                                                        <svg :class="{'rotate-180': tabOpen}" class="w-4 h-4 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                        </svg>
                                                    </button>
                                                    <div x-show="tabOpen" x-collapse class="pt-2 pl-2 text-sm">
                                                       <div class="flex flex-col gap-2 text-xs">
                                                            <div class="pl-3" x-data="{ categoryOpen: false }">
                                                                <button @click="categoryOpen = !categoryOpen" class="flex items-center justify-between w-full py-1 text-sm font-medium">
                                                                    <span>Category 1</span>
                                                                    <svg :class="{'rotate-180': categoryOpen}" class="w-3 h-3 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                                    </svg>
                                                                </button>
                                                                <div x-show="categoryOpen" x-collapse class="pl-3">
                                                                    <ul class="py-1 space-y-1 font-normal">
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 1</a></li>
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 2</a></li>
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 3</a></li>
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 4</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="pl-3" x-data="{ categoryOpen: false }">
                                                                <button @click="categoryOpen = !categoryOpen" class="flex items-center justify-between w-full py-1 text-sm font-medium">
                                                                    <span>Category 2</span>
                                                                    <svg :class="{'rotate-180': categoryOpen}" class="w-3 h-3 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                                    </svg>
                                                                </button>
                                                                <div x-show="categoryOpen" x-collapse class="pl-3">
                                                                    <ul class="py-1 space-y-1 font-normal">
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 5</a></li>
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 6</a></li>
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 7</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                            <div class="pl-3" x-data="{ categoryOpen: false }">
                                                                <button @click="categoryOpen = !categoryOpen" class="flex items-center justify-between w-full py-1 text-sm font-medium">
                                                                    <span>Category 3</span>
                                                                    <svg :class="{'rotate-180': categoryOpen}" class="w-3 h-3 transition-transform" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                                                    </svg>
                                                                </button>
                                                                <div x-show="categoryOpen" x-collapse class="pl-3">
                                                                    <ul class="py-1 space-y-1 font-normal">
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 8</a></li>
                                                                        <li><a href="#" class="hover:text-[#27ad4c]">Product Item 9</a></li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <a href="{{ route('reseller.partner') }}" wire:navigate class="pb-2 hover:text-[#27ad4c]">
                                        Reseller
                                    </a>

                                    <a href="{{ route('category') }}" wire:navigate class="pb-2 hover:text-[#27ad4c]">
                                        Product
                                    </a>

                                    <a href="#" class="pb-2 hover:text-[#27ad4c]">Software</a>
                                    <a href="#" class="pb-2 hover:text-[#27ad4c]">Services</a>
                                    <a href="#" class="pb-2 hover:text-[#27ad4c]">Solutions</a>
                                    <a href="#" class="pb-2 hover:text-[#27ad4c]">Homeowner</a>
                                    <a href="#" class="pb-2 hover:text-[#27ad4c]">Support</a>
                                    <a href="#" class="pb-2 hover:text-[#27ad4c]">Company</a>

                                    <div class="flex flex-col pt-4 space-y-4">
                                        <a href="#" class="font-medium text-slate-700 hover:text-[#27ad4c]">Login</a>
                                        <a href="#"
                                            class="bg-[#27ad4c] text-white text-center font-bold py-2 px-4 rounded-md hover:bg-[#27ad4c]">
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
                        <a href="#" wire:navigate
                            class="pb-2 hover:text-[#27ad4c] flex items-center">
                            Megamenu
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </a>

                        <!-- Mega Menu (full width) -->
                        <div
                            class="absolute left-0 right-0 top-full opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 bg-white shadow-lg border-t-2 border-[#27ad4c] z-50">
                            <div class="  px-4 py-8">
                                {{-- <div class="grid grid-cols-4 gap-8">
                                    <!-- Example Mega Menu Columns -->
                                    <div>
                                        <h3 class="font-bold text-lg mb-4 text-[#27ad4c]">Category 1</h3>
                                        <ul class="space-y-2">
                                            <li><a href="#" class="hover:text-[#27ad4c]">Product Item 1</a></li>
                                            <li><a href="#" class="hover:text-[#27ad4c]">Product Item 2</a></li>
                                            <li><a href="#" class="hover:text-[#27ad4c]">Product Item 3</a></li>
                                            <li><a href="#" class="hover:text-[#27ad4c]">Product Item 4</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-lg mb-4 text-[#27ad4c]">Category 2</h3>
                                        <ul class="space-y-2">
                                            <li><a href="#" class="hover:text-[#27ad4c]">Product Item 5</a></li>
                                            <li><a href="#" class="hover:text-[#27ad4c]">Product Item 6</a></li>
                                            <li><a href="#" class="hover:text-[#27ad4c]">Product Item 7</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-lg mb-4 text-[#27ad4c]">Category 3</h3>
                                        <ul class="space-y-2">
                                            <li><a href="#" class="hover:text-[#27ad4c]">Product Item 8</a></li>
                                            <li><a href="#" class="hover:text-[#27ad4c]">Product Item 9</a></li>
                                        </ul>
                                    </div>
                                    <div>
                                        <h3 class="font-bold text-lg mb-4 text-[#27ad4c]">Featured</h3>
                                        <div class="bg-gray-200 border-2 border-dashed rounded-xl w-full h-48">
                                            <!-- Placeholder for image or featured content -->
                                        </div>
                                        <a href="#" class="block mt-4 text-[#27ad4c] font-semibold hover:underline">View All Products →</a>
                                    </div>
                                </div> --}}
                                <!-- Make sure to include Alpine.js in your layout, e.g. -->
                                <!-- <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script> -->

                                <div class="flex flex-col md:flex-row gap-8 w-full" x-data="{ activeTab: 'tab2' }">
                                    <!-- Tabs on the left -->
                                    <div class="flex flex-col gap-2 w-64">
                                        <button
                                            @click="activeTab = 'tab1'"
                                            :class="activeTab === 'tab1' ? 'bg-[#27ad4c] text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-[#27ad4c]'"
                                            class="block px-4 py-2 text-left rounded-md transition-colors duration-200"
                                            aria-label="Tab 1">
                                            Tab 1
                                        </button>

                                        <button
                                            @click="activeTab = 'tab2'"
                                            :class="activeTab === 'tab2' ? 'bg-[#27ad4c] text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-[#27ad4c]'"
                                            class="block px-4 py-2 text-left rounded-md transition-colors duration-200"
                                            aria-label="Tab 2">
                                            Tab 2
                                        </button>

                                        <button
                                            @click="activeTab = 'tab3'"
                                            :class="activeTab === 'tab3' ? 'bg-[#27ad4c] text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-[#27ad4c]'"
                                            class="block px-4 py-2 text-left rounded-md transition-colors duration-200"
                                            aria-label="Tab 3">
                                            Tab 3
                                        </button>
                                    </div>

                                    <!-- Content on the right - with fixed height behavior -->
                                    <div class="mt-6 md:mt-0 min-h-96 md:min-h-screen-lg relative w-full">
                                        <!-- Wrapper with relative positioning and min-height -->
                                        <div class="absolute inset-0 overflow-y-auto">
                                            <!-- All tab panels are absolutely positioned in the same space -->
                                            <div
                                                x-show="activeTab === 'tab1'"
                                                x-transition.opacity
                                                class="absolute inset-0 prose w-full border border-base-300 bg-base-100 rounded-box p-4 overflow-y-auto">


                                                <h2 class="text-2xl font-bold mb-4">EcoStruxure Building</h2>
                                                <p class="mb-4 font-light">Connecting your values to more valuable experiences, EcoStruxure Building is our end-to-end software designed to create positive outcomes and engaging experiences for buildings of all sizes.</p>
                                                <!-- Add more content here if needed -->
                                                <div class="grid grid-cols-4 gap-3">
                                                    <!-- Example Mega Menu Columns -->
                                                    <div>
                                                        <h3 class="font-bold text-lg mb-4 text-[#27ad4c]">Category 1</h3>
                                                        <ul class="space-y-1 font-normal">
                                                            <li><a href="#" class="hover:text-[#27ad4c]">Product Item 1</a></li>
                                                            <li><a href="#" class="hover:text-[#27ad4c]">Product Item 2</a></li>
                                                            <li><a href="#" class="hover:text-[#27ad4c]">Product Item 3</a></li>
                                                            <li><a href="#" class="hover:text-[#27ad4c]">Product Item 4</a></li>
                                                        </ul>
                                                    </div>
                                                    <div>
                                                        <h3 class="font-bold text-lg mb-4 text-[#27ad4c]">Category 2</h3>
                                                        <ul class="space-y-1 font-normal">
                                                            <li><a href="#" class="hover:text-[#27ad4c]">Product Item 5</a></li>
                                                            <li><a href="#" class="hover:text-[#27ad4c]">Product Item 6</a></li>
                                                            <li><a href="#" class="hover:text-[#27ad4c]">Product Item 7</a></li>
                                                        </ul>
                                                    </div>
                                                    <div>
                                                        <h3 class="font-bold text-lg mb-4 text-[#27ad4c]">Category 3</h3>
                                                        <ul class="space-y-1 font-normal">
                                                            <li><a href="#" class="hover:text-[#27ad4c]">Product Item 8</a></li>
                                                            <li><a href="#" class="hover:text-[#27ad4c]">Product Item 9</a></li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>

                                            <div
                                                x-show="activeTab === 'tab2'"
                                                x-transition.opacity
                                                class="absolute inset-0 prose w-full border border-base-300 bg-base-100 rounded-box p-4 overflow-y-auto">
                                                <h2 class="text-2xl font-bold mb-4">Tab 2</h2>
                                                <p>Tab content 2<br><br>This tab has more lines to make it taller.</p>
                                                <p>Extra content...</p>
                                            </div>

                                            <div
                                                x-show="activeTab === 'tab3'"
                                                x-transition.opacity
                                                class="absolute inset-0 prose w-full border border-base-300 bg-base-100 rounded-box p-4 overflow-y-auto">
                                                <h2 class="text-2xl font-bold mb-4">Tab 3</h2>
                                                <p>Tab content 3 – short again.</p>
                                            </div>
                                        </div>
                                    </div>
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