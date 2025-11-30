<header>
    <!-- Top Bar -->
    <div class="bg-[#27ad4c] text-white text-sm">
        <div class="container lg:max-w-[1780px] mx-auto px-4">
            <div class="py-2 flex justify-between items-center">
                <div class="flex items-center space-x-4">
                    <div class="flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="currentColor">
                            <!-- ClockIcon -->
                        </svg>
                        <span>Mon – Fri 8:00 – 18:00 / Sunday 8:00 – 14:00</span>
                    </div>

                    <div class="hidden md:flex items-center space-x-1">
                        <svg class="w-4 h-4" fill="currentColor">
                            <!-- MailIcon -->
                        </svg>
                        <a href="mailto:info@" class="hover:underline">info@</a>
                    </div>
                </div>

                <div class="hidden md:flex items-center space-x-3">
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
                </div>
            </div>
        </div>
    </div>

    <!-- Main Navigation -->
    <div class="bg-white sticky top-0 z-50 shadow-sm lg:shadow-none">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center md:py-6 py-3">

                <!-- Logo -->
                <div class="lg:w-[180px] md:w-[150px] w-[120px]">
                    <a href="{{ route('home') }}" wire:navigate>
                        <img src="/assets/images/logo.svg" alt="Logo" />
                    </a>
                </div>

                <!-- Search Box -->
                <div class="relative w-5/10 hidden sm:block">
                    <input type="text" placeholder="Search"
                        class="border border-gray-400 py-1.5 px-3 w-full focus:outline-none focus:ring-1 focus:ring-[#27ad4c]" />
                    <button class="absolute right-0 top-0 h-full px-2 text-white bg-[#27ad4c]">
                        <!-- SearchIcon -->
                    </button>
                </div>

                <!-- Desktop Links -->
                <div class="hidden lg:flex items-center space-x-4">
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

            <!-- Desktop Navigation -->
            <nav class="hidden lg:flex items-center space-x-6 text-black font-semibold">
                <a href="{{ route('home') }}" wire:navigate
                    class="pb-2 {{ request()->routeIs('home') ? 'text-[#27ad4c] border-b-2 border-[#27ad4c]' : 'hover:text-[#27ad4c]' }}">
                    Home
                </a>

                <a href="{{ route('category') }}" wire:navigate class="pb-2 hover:text-[#27ad4c]">
                    Category
                </a>

                <a href="{{ route('reseller.partner') }}" wire:navigate class="pb-2 hover:text-[#27ad4c]">
                    Reseller
                </a>
                <a href="{{ route('contact') }}" wire:navigate class="pb-2 hover:text-[#27ad4c]">
                    Contact
                </a>
                <a href="{{ route('details',10) }}" wire:navigate class="pb-2 hover:text-[#27ad4c]">
                    Product Details
                </a>

                {{-- <a href="#" class="pb-2 hover:text-[#27ad4c]">Software</a>
                <a href="#" class="pb-2 hover:text-[#27ad4c]">Services</a>
                <a href="#" class="pb-2 hover:text-[#27ad4c]">Solutions</a>
                <a href="#" class="pb-2 hover:text-[#27ad4c]">Homeowner</a>
                <a href="#" class="pb-2 hover:text-[#27ad4c]">Support</a>
                <a href="#" class="pb-2 hover:text-[#27ad4c]">Company</a> --}}
            </nav>

            <!-- Mobile Navigation -->
            <div class="lg:hidden hidden bg-white py-4 px-4 shadow-lg">

                <div class="relative w-full sm:hidden mb-4">
                    <input type="text" placeholder="Search"
                        class="border border-gray-400 py-1.5 px-3 w-full focus:outline-none focus:ring-1 focus:ring-[#27ad4c]" />
                    <button class="absolute right-0 top-0 h-full px-2 text-white bg-[#27ad4c]">
                        <!-- SearchIcon -->
                    </button>
                </div>

                <nav class="flex flex-col space-y-4 text-slate-700 font-medium">

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

                    <div class="flex flex-col space-y-4 pt-4">
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
