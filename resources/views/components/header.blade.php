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
                    <button class="text-[#27ad4c]">
                        <!-- MenuIcon -->
                    </button>
                </div>
            </div>

            <!-- Desktop Navigation with Mega Menu -->
            <div class="relative">
                <nav class="items-center hidden space-x-6 font-semibold text-black lg:flex">
                    <a href="{{ route('home') }}" wire:navigate
                        class="pb-2 {{ request()->routeIs('home') ? 'text-[#27ad4c] border-b-2 border-[#27ad4c]' : 'hover:text-[#27ad4c]' }}">
                        Home
                    </a>

                    <!-- Products Menu Item with Mega Menu -->
                    <div class="group">
                        <a href="{{ route('category') }}" wire:navigate
                            class="pb-2 hover:text-[#27ad4c] flex items-center">
                            Products
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor" class="w-4 h-4 ml-1">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                            </svg>
                        </a>

                        <!-- Mega Menu (full width) -->
                        <div
                            class="absolute left-0 right-0 top-full opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 bg-white shadow-lg border-t-2 border-[#27ad4c] z-50">
                            <div class="container  px-4 py-8">
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

                                <div class="flex flex-col md:flex-row gap-8" x-data="{ activeTab: 'tab2' }">
    <!-- Tabs on the left -->
    <div class="flex flex-col gap-2 w-full md:w-64">
        <button
            @click="activeTab = 'tab1'"
            :class="{ 'tab-active': activeTab === 'tab1' }"
            class="tab tab-bordered tab-lifted w-full text-left"
            aria-label="Tab 1"
        >
            Tab 1
        </button>

        <button
            @click="activeTab = 'tab2'"
            :class="{ 'tab-active': activeTab === 'tab2' }"
            class="tab tab-bordered tab-lifted w-full text-left"
            aria-label="Tab 2"
        >
            Tab 2
        </button>

        <button
            @click="activeTab = 'tab3'"
            :class="{ 'tab-active': activeTab === 'tab3' }"
            class="tab tab-bordered tab-lifted w-full text-left"
            aria-label="Tab 3"
        >
            Tab 3
        </button>
    </div>

    <!-- Content on the right - with fixed height behavior -->
    <div class="grow mt-6 md:mt-0 min-h-96 md:min-h-screen-lg relative">
        <!-- Wrapper with relative positioning and min-height -->
        <div class="absolute inset-0 overflow-y-auto">
            <!-- All tab panels are absolutely positioned in the same space -->
            <div
                x-show="activeTab === 'tab1'"
                x-transition.opacity
                class="absolute inset-0 prose max-w-none border border-base-300 bg-base-100 rounded-box p-10"
            >
                <h2 class="text-2xl font-bold mb-4">Tab 1</h2>
                <p>Tab content 1</p>
                <!-- Add more content here if needed -->
            </div>

            <div
                x-show="activeTab === 'tab2'"
                x-transition.opacity
                class="absolute inset-0 prose max-w-none border border-base-300 bg-base-100 rounded-box p-10"
            >
                <h2 class="text-2xl font-bold mb-4">Tab 2</h2>
                <p>Tab content 2<br><br>This tab has more lines to make it taller.</p>
                <p>Extra content...</p>
            </div>

            <div
                x-show="activeTab === 'tab3'"
                x-transition.opacity
                class="absolute inset-0 prose max-w-none border border-base-300 bg-base-100 rounded-box p-10"
            >
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

            <!-- Mobile Navigation -->
            <div class="hidden px-4 py-4 bg-white shadow-lg lg:hidden">

                <div class="relative w-full mb-4 sm:hidden">
                    <input type="text" placeholder="Search"
                        class="border border-gray-400 py-1.5 px-3 w-full focus:outline-none focus:ring-1 focus:ring-[#27ad4c]" />
                    <button class="absolute right-0 top-0 h-full px-2 text-white bg-[#27ad4c]">
                        <!-- SearchIcon -->
                    </button>
                </div>

                <nav class="flex flex-col space-y-4 font-medium text-slate-700">

                    <a href="{{ route('home') }}" wire:navigate class="pb-2 hover:text-[#27ad4c]">
                        Home
                    </a>

                    <a href="{{ route('category') }}" wire:navigate class="pb-2 hover:text-[#27ad4c]">
                        Products
                    </a>

                    <a href="{{ route('reseller.partner') }}" wire:navigate class="pb-2 hover:text-[#27ad4c]">
                        Reseller
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
</header>
