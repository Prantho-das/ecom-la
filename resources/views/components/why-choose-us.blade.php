<section class="bg-white relative overflow-hidden">
    <div class="flex flex-wrap">
        <!-- Left Image -->
        <div class="w-full lg:w-3/5">
            <img src="{{ $backgroundImage  }}" alt="Engineer with wind turbine models"
                class="w-full h-full object-cover" />
        </div>

        <!-- Right Image -->
        <div class="w-full lg:w-2/5">
            <img src="{{ $backgroundImageTwo }}" alt="Engineer with wind turbine models"
                class="w-full h-full object-cover" />
        </div>
    </div>

    <!-- Floating Content Box -->
    <div
        class="absolute top-1/2 left-1/2 -translate-y-1/2 -translate-x-1/2 lg:translate-x-0 bg-[#27ad4c] text-white md:p-12 p-8 shadow-2xl lg:-ml-48 md:max-w-[550px] w-4/5">
        <p class="font-semibold mb-2 capitalize">{{$subTitle}}</p>

        <h2 class="md:text-4xl text-3xl font-bold md:mb-6 mb-4">
           {{ $mainTitle }}
        </h2>

        <!-- List -->
        <ul class="space-y-6">
            <li class="flex">
                <div class="text-2xl mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
  <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
</svg>


                </div>
                <div class="ml-4">
                    <h3 class="font-bold text-lg">{{$statOneTitle}}</h3>
                    <p class="text-sm opacity-90">
                       {{ $statOneDesc }}
                    </p>
                </div>
            </li>
            <li class="flex">
                <div class="text-2xl mt-1">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="size-6">
  <path fill-rule="evenodd" d="M2.25 12c0-5.385 4.365-9.75 9.75-9.75s9.75 4.365 9.75 9.75-4.365 9.75-9.75 9.75S2.25 17.385 2.25 12Zm13.36-1.814a.75.75 0 1 0-1.22-.872l-3.236 4.53L9.53 12.22a.75.75 0 0 0-1.06 1.06l2.25 2.25a.75.75 0 0 0 1.14-.094l3.75-5.25Z" clip-rule="evenodd" />
</svg>


                </div>
                <div class="ml-4">
                    <h3 class="font-bold text-lg">{{$statTwoTitle}}</h3>
                    <p class="text-sm opacity-90">
                         {{ $statTwoDesc }}
                    </p>
                </div>
            </li>
        </ul>
    </div>
</section>
