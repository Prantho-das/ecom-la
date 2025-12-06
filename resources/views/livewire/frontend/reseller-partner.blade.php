<section>
<div class="">
        <!-- Banner / Hero Section -->
        <div class="relative bg-cover bg-center h-48 md:h-64 flex items-center justify-center"
            style="background-image: url('https://picsum.photos/seed/partners/1600/400');">
            <div class="absolute inset-0 bg-[#2d3748]" style="
                background-image: url('data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNDAiIGhlaWdodD0iNDAiIHZpZXdCb3g9IjAgMCA0MCA0MCIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KICAgIDxnIGZpbGw9Im5vbmUiIGZpbGwtcnVsZT0iZXZlbm9kZCI+CiAgICAgICAgPHBhdGggZD0iTTAgNDAgTDQwIDAgTDQwIDQwIFoiIGZpbGw9IiNmZmYiIG9wYWNpdHk9IjAuMDUiLz4KICAgICAgICA8cGF0aCBkPSJNMCAwIEw0MCA0MCBMMC40MCA0MCBaIiBmaWxsPSIjZmZmIiBvcGFjaXR5PSIwLjA1Ii8+CiAgICA8L2c+Cjwvc3ZnPg==');
                background-repeat: repeat;
                opacity: 0.9;
            "></div>

            <div class="absolute inset-0 bg-gradient-to-t from-[#2d3748] via-transparent to-transparent opacity-50">
            </div>

            <h1 class="relative text-white text-4xl md:text-5xl font-light z-10">
                Reseller Partners
            </h1>
        </div>

        <main class="">

            <!-- ============================= -->
            <!-- Partner Portal Banner (HTML placeholder) -->
            <!-- ============================= -->
            <div class="bg-gray-50/75 border-b border-gray-200">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                    <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                        <div class="md:w-2/3">
                            <h2 class="text-xl font-semibold text-gray-800 mb-2">Already a partner?</h2>
                            <p class="text-gray-600">
                                Access the partner portal to register an opportunity or additional authorized users,
                                access the pricelist, marketing material, or training materials.
                            </p>
                        </div>
                        <div class="flex-shrink-0">
                            <button
                                class="bg-white border-2 border-gray-800 text-gray-800 font-semibold py-2 px-8 hover:bg-gray-800 hover:text-white transition-colors duration-300">
                                Partner Portal
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- ============================= -->
            <!-- Filter Section (HTML placeholder) -->
            <!-- ============================= -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
                <div class="flex flex-col sm:flex-row items-end gap-4">

                    <!-- Country Dropdown -->
                    <div class="w-full">
                        <label for="country" class="block text-sm font-medium text-gray-700 mb-1">
                            Country
                        </label>

                        <div class="relative">
                            <select id="country" name="country"
                                class="text-black block w-full bg-gray-100 border border-gray-300 rounded-md py-2 px-3 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm appearance-none">
                                <option value="Any">- Any -</option>
                                <option value="France">France</option>
                                <option value="United States">United States</option>
                                <option value="Czechia">Czechia</option>
                                <option value="Colombia">Colombia</option>
                                <option value="Germany">Germany</option>
                                <option value="United Kingdom">United Kingdom</option>
                            </select>

                            <!-- Dropdown Icon -->
                            <div
                                class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path
                                        d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z" />
                                </svg>
                            </div>
                        </div>
                    </div>

                    <!-- Apply Button -->
                    <button
                        class="w-full sm:w-auto bg-[#4a6da7] text-white font-semibold py-2 px-10 rounded-md hover:bg-[#3e5a8a] transition-colors duration-300">
                        Apply
                    </button>

                </div>
            </div>


            <!-- ============================= -->
            <!-- Partner List (dynamic) -->
            <!-- ============================= -->
            <div style="width: 1200px; margin: 0 auto; font-family: Arial, sans-serif; color: #333;">

                <!-- Header -->
                <div
                    style="display: flex; border-bottom: 2px solid #ccc; padding: 10px 0; font-weight: bold; text-transform: uppercase;">
                    <div style="width: 25%;">Company</div>
                    <div style="width: 35%;">Address</div>
                    <div style="width: 20%;">Country</div>
                    <div style="width: 20%;">Partner Level</div>
                </div>

                @foreach ($resellers as $reseller)
                    <!-- Partner Card -->
                    <div style="display: flex; padding: 15px 0; border-bottom: 1px solid #eee; align-items: center;">
                        <div style="width: 25%; display: flex; align-items: center;">
                            <span style="font-weight: 500;">{{ $reseller->name }}</span>
                        </div>
                        <div style="width: 35%;">
                            {{ $reseller->address }}<br>
                            {{ $reseller->city }}, {{ $reseller->state }} {{ $reseller->zip_code }}<br>
                        </div>
                        <div style="width: 20%; font-weight: 500;">{{ $reseller->country->name }}</div>
                        <div style="width: 20%; font-weight: 500;">Gold</div>
                    </div>
                @endforeach
            </div>


            <!-- Pagination (if you want later) -->
            <!--
        <div class="flex justify-center mt-10 space-x-2">
            <button class="px-4 py-2 bg-gray-200 rounded">Prev</button>
            <button class="px-4 py-2 bg-gray-200 rounded">Next</button>
        </div>
        -->

        </main>
    </div>
</section>
