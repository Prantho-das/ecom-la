<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Category</title>
</head>

<body>
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
                        <a
                            href="#"
                            class="inline-block bg-[#27ad4c] text-white font-semibold py-3 px-8 rounded-md hover:bg-green-700 transition-colors">
                            Contact Sales
                        </a>
                    </div>
                </div>

                <!-- Right Image -->
                <div class="hidden md:block md:basis-1/3 basis-full">
                    <img
                        src="/assets/images/server-rack-hero.png"
                        alt="APC NetShelter SX Enclosures"
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
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                    viewBox="0 0 20 20" fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M14.707 12.707a1 1 0 01-1.414 0L10 9.414l-3.293 3.293a1 1 0 01-1.414-1.414l4-4a1 1 0 011.414 0l4 4a1 1 0 010 1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>

                        <div class="p-4">
                            <ul>
                                <li class="flex items-center py-2">
                                    <div class="w-1 h-6 bg-green-600 rounded-full mr-3"></div>
                                    <a href="#" class="text-gray-800 font-semibold">
                                        Rack Enclosures
                                    </a>
                                </li>

                                <li class="py-2 pl-4">
                                    <a href="#" class="text-gray-600 hover:text-gray-800">
                                        Accessories
                                    </a>
                                </li>
                            </ul>
                        </div>

                    </div>
                </aside>

                <!-- PRODUCT GRID -->
                <div class="lg:col-span-3">

                    <!-- Toolbar -->
                    <div class="flex justify-end items-center gap-3 mb-6 pb-4 border-b border-gray-200">
                        <div class="flex items-center space-x-2">
                            <button id="listViewBtn" class="p-1 text-2xl text-black">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                                </svg>

                            </button>
                            <button id="gridViewBtn" class="p-1 text-2xl text-green-600">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.375 19.5h17.25m-17.25 0a1.125 1.125 0 0 1-1.125-1.125M3.375 19.5h7.5c.621 0 1.125-.504 1.125-1.125m-9.75 0V5.625m0 12.75v-1.5c0-.621.504-1.125 1.125-1.125m18.375 2.625V5.625m0 12.75c0 .621-.504 1.125-1.125 1.125m1.125-1.125v-1.5c0-.621-.504-1.125-1.125-1.125m0 3.75h-7.5A1.125 1.125 0 0 1 12 18.375m9.75-12.75c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125m19.5 0v1.5c0 .621-.504 1.125-1.125 1.125M2.25 5.625v1.5c0 .621.504 1.125 1.125 1.125m0 0h17.25m-17.25 0h7.5c.621 0 1.125.504 1.125 1.125M3.375 8.25c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125m17.25-3.75h-7.5c-.621 0-1.125.504-1.125 1.125m8.625-1.125c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125v1.5c0 .621.504 1.125 1.125 1.125M12 10.875v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 10.875c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125M13.125 12h7.5m-7.5 0c-.621 0-1.125.504-1.125 1.125M20.625 12c.621 0 1.125.504 1.125 1.125v1.5c0 .621-.504 1.125-1.125 1.125m-17.25 0h7.5M12 14.625v-1.5m0 1.5c0 .621-.504 1.125-1.125 1.125M12 14.625c0 .621.504 1.125 1.125 1.125m-2.25 0c.621 0 1.125.504 1.125 1.125m0 1.5v-1.5m0 0c0-.621.504-1.125 1.125-1.125m0 0h7.5" />
                                </svg>

                            </button>
                        </div>

                        <p id="productCount" class="text-sm text-gray-500"></p>
                    </div>

                    <!-- Product Container -->
                    <div id="productContainer" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-px bg-gray-200 border border-gray-200">
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
                                <svg width="24" height="24" fill="currentColor">
                                    <circle cx="12" cy="12" r="10"></circle>
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
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 18v-5.25m0 0a6.01 6.01 0 0 0 1.5-.189m-1.5.189a6.01 6.01 0 0 1-1.5-.189m3.75 7.478a12.06 12.06 0 0 1-4.5 0m3.75 2.383a14.406 14.406 0 0 1-3 0M14.25 18v-.192c0-.983.658-1.823 1.508-2.316a7.5 7.5 0 1 0-7.517 0c.85.493 1.509 1.333 1.509 2.316V18" />
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
                                <svg width="24" height="24" fill="currentColor">
                                    <polygon points="12,2 22,22 2,22"></polygon>
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
                                <svg width="24" height="24" fill="currentColor">
                                    <path d="M12 2 L12 22 M2 12 L22 12"></path>
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




    <!-- ========================= -->
    <!--        JAVASCRIPT         -->
    <!-- ========================= -->
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
</body>

</html>