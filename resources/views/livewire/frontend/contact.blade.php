<section>
    <div class="bg-white max-w-6xl w-full mx-auto p-8 sm:p-10 lg:p-12">
        <div class="max-w-2xl mx-auto text-center mb-12">
            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-bold text-gray-900">
                Contact our team
            </h1>
            <p class="mt-4 text-base sm:text-lg text-gray-600">
                Got any questions about the product or scaling on our platform? We're here to help. Chat to our friendly
                team 24/7 and get onboard in less than 5 minutes.
            </p>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 lg:gap-24">
            <form action="#" method="POST" class="space-y-6">

                <!-- First + Last Name -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <!-- First Name -->
                    <div>
                        <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">
                            First name
                        </label>
                        <input type="text" id="firstName" name="firstName" placeholder="First name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-gray-800" />
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">
                            Last name
                        </label>
                        <input type="text" id="lastName" name="lastName" placeholder="Last name"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-gray-800" />
                    </div>

                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email
                    </label>
                    <input type="email" id="email" name="email" placeholder="you@company.com"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-gray-800" />
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                        Phone number
                    </label>
                    <div class="relative">

                        <!-- Country Code -->
                        <div class="absolute inset-y-0 left-0 flex items-center">
                            <label for="country" class="sr-only">Country</label>
                            <select id="country" name="country"
                                class="h-full py-0 pl-3 pr-8 border-transparent bg-transparent text-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-gray-800 rounded-md">
                                <option>US</option>
                                <option>CA</option>
                                <option>EU</option>
                            </select>
                        </div>

                        <!-- Phone Input -->
                        <input type="tel" id="phone" name="phone" placeholder="+1 (555) 000-0000"
                            class="w-full pl-20 px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-gray-800" />
                    </div>
                </div>

                <!-- Message -->
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
                        Message
                    </label>
                    <textarea id="message" name="message" rows="5" placeholder="Leave us a message..."
                        class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-gray-800"></textarea>
                </div>

                <!-- Submit Button -->
                <div>
                    <button type="submit"
                        class="w-full lg:w-auto px-6 py-3 bg-gray-900 text-white font-semibold rounded-md shadow-sm hover:bg-gray-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-800 transition-colors">
                        Send message
                    </button>
                </div>

            </form>

            <div class="mt-16 lg:mt-0 space-y-10">

                <!-- Chat With Us -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Chat with us</h3>
                    <p class="mt-1 text-gray-600">Speak to our friendly team via live chat.</p>

                    <div class="mt-4 space-y-3">

                        <!-- Live Chat -->
                        <a href="#" class="flex items-center gap-3 text-gray-800 hover:text-gray-900 group">
                            <div class="flex-shrink-0">
                                <!-- ChatIcon -->
                                <!-- Replace with SVG -->
                                <svg width="22" height="22" class="text-gray-700"></svg>
                            </div>
                            <span
                                class="font-medium underline underline-offset-2 decoration-gray-400 group-hover:decoration-gray-800 transition">
                                Start a live chat
                            </span>
                        </a>

                        <!-- Email -->
                        <a href="mailto:hello@example.com"
                            class="flex items-center gap-3 text-gray-800 hover:text-gray-900 group">
                            <div class="flex-shrink-0">
                                <!-- PaperPlaneIcon -->
                                <svg width="22" height="22"></svg>
                            </div>
                            <span
                                class="font-medium underline underline-offset-2 decoration-gray-400 group-hover:decoration-gray-800 transition">
                                Shoot us an email
                            </span>
                        </a>

                        <!-- Message on X -->
                        <a href="#" class="flex items-center gap-3 text-gray-800 hover:text-gray-900 group">
                            <div class="flex-shrink-0">
                                <!-- XIcon -->
                                <svg width="22" height="22"></svg>
                            </div>
                            <span
                                class="font-medium underline underline-offset-2 decoration-gray-400 group-hover:decoration-gray-800 transition">
                                Message us on X
                            </span>
                        </a>

                    </div>
                </div>

                <!-- Call Us -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Call us</h3>
                    <p class="mt-1 text-gray-600">Call our team Mon-Fri from 8am to 5pm.</p>

                    <div class="mt-4">
                        <a href="tel:+15550000000"
                            class="flex items-center gap-3 text-gray-800 hover:text-gray-900 group">
                            <div class="flex-shrink-0">
                                <!-- PhoneIcon -->
                                <svg width="22" height="22"></svg>
                            </div>
                            <span
                                class="font-medium underline underline-offset-2 decoration-gray-400 group-hover:decoration-gray-800 transition">
                                +1 (555) 000-0000
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Visit Us -->
                <div>
                    <h3 class="text-lg font-semibold text-gray-900">Visit us</h3>
                    <p class="mt-1 text-gray-600">Chat to us in person at our Melbourne HQ.</p>

                    <div class="mt-4">
                        <a href="#" class="flex items-start gap-3 text-gray-800 hover:text-gray-900 group">
                            <div class="flex-shrink-0 mt-1">
                                <!-- MapPinIcon -->
                                <svg width="22" height="22"></svg>
                            </div>
                            <span
                                class="font-medium underline underline-offset-2 decoration-gray-400 group-hover:decoration-gray-800 transition">
                                100 Smith Street, Collingwood VIC 3066
                            </span>
                        </a>
                    </div>
                </div>

            </div>


        </div>
    </div>
</section>