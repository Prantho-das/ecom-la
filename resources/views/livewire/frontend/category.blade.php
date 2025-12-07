<section>
    <x-breadcrumb />

    <div class="container lg:max-w-[1780px] mx-auto px-4">
        <div class="py-12">
            <div class="flex flex-col md:flex-row items-center gap-8">

                <!-- Left Content -->
                <div class="md:basis-2/3 basis-full">
                    <h1 class="text-4xl font-light text-gray-900">
                        APC
                        <a href="#" class="font-semibold">
                            NetShelter
                        </a>
                        SX Enclosures
                    </h1>

                    <p class="mt-4 text-xl text-gray-600">
                        Our high-performance IT Rack for data centers, server rooms & wiring closets
                    </p>

                    <p class="mt-8 text-gray-500">
                        Part of
                        <a href="#" class="font-semibold text-gray-700 hover:underline">
                            NetShelter
                        </a>
                    </p>

                    <p class="mt-4 text-gray-600">
                        Bring your business the power of global scale, sustainable leadership and unparalleled
                        quality with APC <span class="font-bold">NetShelter SX</span>: our most versatile IT rack
                        for AI applications and everyday excellence.
                    </p>

                    <div class="mt-6">
                        logo
                        <!-- Replace this with your actual logo later -->
                    </div>

                    <div class="mt-8">
                        <a href="#"
                            class="inline-block bg-[#27ad4c] text-white font-semibold py-3 px-8 rounded-md hover:bg-green-700 transition-colors">
                            Contact Sales
                        </a>
                    </div>
                </div>

                <!-- Right Image -->
                <div class="hidden md:block md:basis-1/3 basis-full">
                    <img src="/assets/images/server-rack-hero.png" alt="APC NetShelter SX Enclosures"
                        class="rounded-lg object-contain" />
                </div>

            </div>
        </div>
    </div>



    <div class=" bg-gray-50">
        <div class="container lg:max-w-[1780px] mx-auto px-4">
            <div class="py-12  grid grid-cols-1 lg:grid-cols-4 gap-8">

                <!-- SIDEBAR -->
                <aside class="lg:col-span-1">
                    <h2 class="text-sm font-medium text-gray-500 mb-4">Filter by:</h2>

                    <div class="border border-gray-200 rounded-md">
                        <div class="p-4 border-b border-gray-200">
                            <button class="flex justify-between items-center w-full text-left">
                                <span class="font-semibold text-gray-800">Category</span>

                                <!-- Chevron Icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <div class="p-4">
                            <ul>

@foreach($categories as $categoryInfo)
                                <li class="py-2 pl-4">
                                   @if(request()->filled('category_slug') &&
                                    request()->category_slug==$categoryInfo->slug)
                                    <div class="w-1 h-6 bg-green-600 rounded-full mr-3"></div>
                                    @endif
                                    <a href="{{ url('/category') . '?category_slug=' . $categoryInfo->slug }}" class="text-gray-600 hover:text-gray-800">
                                        {{ $categoryInfo->name }}
                                    </a>
                                </li>
                                @endforeach
                            </ul>
                        </div>

                    </div>
                </aside>

                <!-- PRODUCT GRID -->
                <div class="lg:col-span-3">

                    <!-- Toolbar -->
                    <div class="flex justify-end items-center gap-3 mb-6 pb-4 border-b border-gray-200">
                        <div class="flex items-center space-x-2">
                    
                            <button  wire:click="$set('showMode', 'grid')" class="p-1 text-2xl {{ $showMode=='grid'?'text-green-600':'text-black' }}">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                                </svg>                                  
                            </button>
                
                            <button wire:click="$set('showMode', 'list')"  class="p-1 text-2xl {{ $showMode=='list'?'text-green-600':'text-black' }}">
                               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                </svg>                                  
                            </button>
                
                        </div>

                        <p id="productCount" class="text-sm text-gray-500"></p>
                    </div>

                    <!-- Product Container -->
                    <div id="productContainer"
                        class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-px bg-gray-200 border border-gray-200">
                    </div>

                    <!-- Pagination -->
                    <div class="mt-8 flex justify-center gap-2">
                        <button id="prevPage" class="px-3 py-2 rounded border">Prev</button>
                        <span id="pageInfo" class="px-4 py-2"></span>
                        <button id="nextPage" class="px-3 py-2 rounded border">Next</button>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <div class="py-16 ">
        <div class="container lg:max-w-[1780px] mx-auto px-4">
            <div>
                <h2 class="text-3xl font-light text-gray-900 mb-8">Need help?</h2>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">

                    <!-- Help Card 1 -->
                    <div class="bg-white p-6 border border-gray-200 rounded-lg flex flex-col h-full">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-semibold text-gray-800">Product Selector</h3>

                            <!-- Replace with your ProductSelectorIcon SVG -->
                            <div>
                                <!-- ICON -->

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 text-blue-400">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9 17.25v1.007a3 3 0 0 1-.879 2.122L7.5 21h9l-.621-.621A3 3 0 0 1 15 18.257V17.25m6-12V15a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 15V5.25m18 0A2.25 2.25 0 0 0 18.75 3H5.25A2.25 2.25 0 0 0 3 5.25m18 0V12a2.25 2.25 0 0 1-2.25 2.25H5.25A2.25 2.25 0 0 1 3 12V5.25" />
                                </svg>




                            </div>
                        </div>
                        <p class="text-gray-600 flex-grow">
                            Quickly and easily find the right products and accessories for your applications.
                        </p>
                    </div>

                    <!-- Help Card 2 -->
                    <div class="bg-white p-6 border border-gray-200 rounded-lg flex flex-col h-full">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-semibold text-gray-800">Get a Quote</h3>

                            <!-- Replace with your GetQuoteIcon SVG -->
                            <div>
                                <!-- ICON -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 text-blue-400">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>


                            </div>
                        </div>
                        <p class="text-gray-600 flex-grow">
                            Start your sales enquiry online and an expert will connect with you.
                        </p>
                    </div>

                    <!-- Help Card 3 -->
                    <div class="bg-white p-6 border border-gray-200 rounded-lg flex flex-col h-full">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-semibold text-gray-800">Where to buy?</h3>

                            <!-- Replace with your WhereToBuyIcon SVG -->
                            <div>
                                <!-- ICON -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6 text-blue-400">
  <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
  <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
</svg>

                            </div>
                        </div>
                        <p class="text-gray-600 flex-grow">
                            Easily find the nearest Schneider Electric distributor in your location.
                        </p>
                    </div>

                    <!-- Help Card 4 -->
                    <div class="bg-white p-6 border border-gray-200 rounded-lg flex flex-col h-full">
                        <div class="flex justify-between items-start mb-4">
                            <h3 class="text-xl font-semibold text-gray-800">Help Centre</h3>

                            <!-- Replace with your HelpCentreIcon SVG -->
                            <div>
                                <!-- ICON -->
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-6 text-blue-400">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M9.879 7.519c1.171-1.025 3.071-1.025 4.242 0 1.172 1.025 1.172 2.687 0 3.712-.203.179-.43.326-.67.442-.745.361-1.45.999-1.45 1.827v.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9 5.25h.008v.008H12v-.008Z" />
                                </svg>

                            </div>
                        </div>
                        <p class="text-gray-600 flex-grow">
                            Find support resources for all your needs, in one place.
                        </p>
                    </div>

                </div>
            </div>
        </div>
    </div>

</section>
@push('scripts')
    <script>
        const products = [{
                id: '3',
                sku: 'AR3003',
                name: 'APC NetShelter SX, Server Rack Enclosure, 12U, Black, 658H x 600W x 900D mm',
                imageUrl: '/assets/images/server-rack.png'
            },
            {
                id: '4',
                sku: 'AR3105',
                name: 'APC NetShelter SX, Server Rack Enclosure, 45U, Black, 2124H x 600W x 1070D mm',
                imageUrl: '/assets/images/server-rack.png'
            },
            {
                id: '8',
                sku: 'AR3300',
                name: 'APC NetShelter SX, Server Rack Enclosure, 42U, Black, 1991H x 600W x 1200D mm',
                imageUrl: '/assets/images/server-rack.png'
            },
            {
                id: '9',
                sku: 'AR3140',
                name: 'APC NetShelter SX, Networking Rack Enclosure, 42U, Black, 1991H x 750W x 1070D mm',
                imageUrl: '/assets/images/server-rack.png'
            },
            {
                id: '5',
                sku: 'AR3350',
                name: 'APC NetShelter SX, Server Rack Enclosure, 42U, Black, 1991H x 750W x 1200D mm',
                imageUrl: '/assets/images/server-rack.png'
            },
            {
                id: '2',
                sku: 'AR3006',
                name: 'APC NetShelter SX, Server Rack Enclosure, 18U, Black, 925H x 600W x 900D mm',
                imageUrl: '/assets/images/server-rack.png'
            },
        ];

        let currentPage = 1;
        const productsPerPage = 6;
        let view = "grid";

        function renderProducts() {
            const container = document.getElementById("productContainer");
            container.innerHTML = "";

            const totalPages = Math.ceil(products.length / productsPerPage);
            const startIndex = (currentPage - 1) * productsPerPage;
            const endIndex = startIndex + productsPerPage;

            const currentProducts = products.slice(startIndex, endIndex);

            document.getElementById("productCount").textContent =
                `${startIndex + 1} - ${Math.min(endIndex, products.length)} of ${products.length} products`;

            document.getElementById("pageInfo").textContent =
                `Page ${currentPage} of ${totalPages}`;

            // Set view type
            if (view === "grid") {
                container.class =
                    "grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-px bg-gray-200 border";
            } else {
                container.class =
                    "flex flex-col gap-px bg-gray-200 border";
            }

            currentProducts.forEach((product) => {
                if (view === "grid") {
                    container.innerHTML += `
                        <div class="bg-white p-6 flex flex-col items-center text-center h-full">
                            <img src="${product.imageUrl}" alt="${product.name}" class="w-40 h-40 object-contain my-4" />
                            <p class="text-sm text-gray-500 mb-2">${product.sku}</p>
                            <h3 class="text-base text-gray-800 font-medium">${product.name}</h3>
                            <a href="#" class="mt-6 w-full inline-block border border-gray-300 py-2 px-4 rounded-md hover:bg-gray-100">
                                View Details
                            </a>
                        </div>
                    `;
                } else {
                    container.innerHTML += `
                        <div class="bg-white p-4 flex items-center w-full">
                            <img src="${product.imageUrl}" alt="${product.name}" class="w-24 h-24 object-contain mr-4" />
                            <div class="flex-grow">
                                <p class="text-sm text-gray-500 mb-1">${product.sku}</p>
                                <h3 class="text-base text-gray-800 font-medium">${product.name}</h3>
                            </div>
                            <div class="ml-4">
                                <a href="#" class="inline-block border border-gray-300 py-2 px-4 rounded-md hover:bg-gray-100">
                                    View Details
                                </a>
                            </div>
                        </div>
                    `;
                }
            });
        }

        // Buttons
        document.getElementById("listViewBtn").onclick = () => {
            view = "list";
            renderProducts();
        };

        document.getElementById("gridViewBtn").onclick = () => {
            view = "grid";
            renderProducts();
        };

        document.getElementById("prevPage").onclick = () => {
            if (currentPage > 1) {
                currentPage--;
                renderProducts();
            }
        };

        document.getElementById("nextPage").onclick = () => {
            const totalPages = Math.ceil(products.length / productsPerPage);
            if (currentPage < totalPages) {
                currentPage++;
                renderProducts();
            }
        };

        // First render
        renderProducts();
    </script>
@endpush
