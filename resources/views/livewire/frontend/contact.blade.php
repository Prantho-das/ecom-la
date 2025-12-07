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
            <form wire:submit.prevent="save" class="space-y-6">

                @if (session()->has('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif

                <!-- First + Last Name -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">

                    <!-- First Name -->
                    <div>
                        <label for="firstName" class="block text-sm font-medium text-gray-700 mb-1">
                            First name
                        </label>
                        <input type="text" id="firstName" wire:model="firstName" placeholder="First name"
                            class="text-gray-700 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-gray-800" />
                        @error('firstName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Last Name -->
                    <div>
                        <label for="lastName" class="block text-sm font-medium text-gray-700 mb-1">
                            Last name
                        </label>
                        <input type="text" id="lastName" wire:model="lastName" placeholder="Last name"
                            class="text-gray-700 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-gray-800" />
                        @error('lastName') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                        Email
                    </label>
                    <input type="email" id="email" wire:model="email" placeholder="you@company.com"
                        class="text-gray-700 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-gray-800" />
                    @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Phone Number -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-gray-700 mb-1">
                        Phone number
                    </label>
                    <input type="tel" id="phone" wire:model="phone" placeholder="+1 (555) 000-0000"
                        class="text-gray-700 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-gray-800" />
                    @error('phone') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                </div>

                <!-- Message -->
                <div>
                    <label for="message" class="block text-sm font-medium text-gray-700 mb-1">
                        Message
                    </label>
                    <textarea id="message" wire:model="message" rows="5" placeholder="Leave us a message..."
                        class="text-gray-700 w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-800 focus:border-gray-800"></textarea>
                    @error('message') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.556-4.03 8.25-9 8.25a9.764 9.764 0 0 1-2.555-.337A5.972 5.972 0 0 1 5.41 20.97a5.969 5.969 0 0 1-.474-.065 4.48 4.48 0 0 0 .978-2.025c.09-.457-.133-.901-.467-1.226C3.93 16.178 3 14.189 3 12c0-4.556 4.03-8.25 9-8.25s9 3.694 9 8.25Z" />
                                </svg>                                  
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
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                </svg>                                  
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
                               <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="size-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                </svg>                                  
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
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 6.75c0 8.284 6.716 15 15 15h2.25a2.25 2.25 0 0 0 2.25-2.25v-1.372c0-.516-.351-.966-.852-1.091l-4.423-1.106c-.44-.11-.902.055-1.173.417l-.97 1.293c-.282.376-.769.542-1.21.38a12.035 12.035 0 0 1-7.143-7.143c-.162-.441.004-.928.38-1.21l1.293-.97c.363-.271.527-.734.417-1.173L6.963 3.102a1.125 1.125 0 0 0-1.091-.852H4.5A2.25 2.25 0 0 0 2.25 4.5v2.25Z" />
                                </svg>                                  
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
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                    class="size-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                                </svg>                                  
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