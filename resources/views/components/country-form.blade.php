{{-- resources/views/components/destination-selector.blade.php --}}
<div x-data="destinationSelector()"
     class="flex flex-col bg-white rounded-2xl shadow-2xl overflow-hidden ">

    {{-- Header --}}
    {{-- <div class="bg-gradient-to-r from-green-600 to-emerald-700 p-5 text-white">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2" fill="none"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 002 2h1.064M15 20.488V18a2 2 0 013-1.736"/>
                </svg>
                <div>
                    <h1 class="font-bold text-lg">Global Destination Selector</h1>
                    <p class="text-green-100 text-sm">Choose your dream destination</p>
                </div>
            </div>
            <div class="text-right">
                <div class="font-bold text-xl">Step <span x-text="step"></span>/2</div>
            </div>
        </div>
    </div> --}}

    {{-- Progress Bar --}}
    {{-- <div class="px-6 pt-6">
        <div class="flex items-center relative">
            <div class="absolute top-6 left-8 right-8 h-1 bg-gray-200 -z-10"></div>
            <div class="h-full bg-green-600 transition-all duration-500 absolute top-6 left-8 -z-10"
                 :style="{ width: step === 2 ? 'calc(100% - 4rem)' : '0%' }"></div>

            <template x-for="(label, i) in ['Continent', 'Country']">
                <div class="flex-1 text-center">
                    <div :class="{
                        'w-12 h-12 rounded-full flex items-center justify-center text-lg font-bold transition-all shadow-md': true,
                        'bg-green-600 text-white ring-4 ring-green-100': step >= i + 1,
                        'bg-gray-200 text-gray-500': step < i + 1
                    }">
                        <span x-text="i + 1"></span>
                    </div>
                    <p class="mt-2 text-xs font-semibold" :class="step >= i + 1 ? 'text-green-600' : 'text-gray-400'" x-text="label"></p>
                </div>
            </template>
        </div>
    </div> --}}

    {{-- Content --}}
    <div class="flex-1 overflow-y-auto p-6">
        {{-- Step 1: Continents --}}
        <template x-if="step === 1">
            <div class="space-y-6">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-800">Where would you like to explore?</h2>
                    <p class="text-gray-600 mt-2">Select a continent to continue</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <template x-for="continent in continents" :key="continent.name">
                        <button
                            @click="selectedContinent = continent.name"
                            class="relative rounded-2xl overflow-hidden h-40 transition-all duration-300 transform hover:scale-105 active:scale-98 shadow-lg"
                            :class="selectedContinent === continent.name ? 'ring-4 ring-green-500' : ''"
                        >
                            <!-- Background -->
                            <div
                                :class="selectedContinent === continent.name
                                    ? 'bg-green-600'
                                    : 'bg-white border-2 border-green-200'"
                                class="absolute inset-0 rounded-2xl"
                            ></div>

                            <!-- Content -->
                            <div class="relative h-full flex flex-col items-center justify-center p-4"
                                 :class="selectedContinent === continent.name ? 'text-white' : 'text-green-700'">
                                <div class="text-6xl mb-3" x-text="continent.emoji"></div>
                                <h3 class="text-lg font-bold" x-text="continent.name"></h3>

                                <!-- Selected Checkmark -->
                                <template x-if="selectedContinent === continent.name">
                                    <div class="absolute top-3 right-3">
                                        <svg class="w-8 h-8 text-white drop-shadow-lg" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                  clip-rule="evenodd"/>
                                        </svg>
                                    </div>
                                </template>
                            </div>
                        </button>
                    </template>
                </div>
            </div>
        </template>

        {{-- Step 2: Countries --}}
        <template x-if="step === 2">
            <div class="space-y-6">
                <div class="text-center">
                    <div class="inline-flex items-center gap-2 px-5 py-2 bg-green-100 text-green-700 rounded-full font-semibold">
                        Selected: <span x-text="selectedContinent"></span>
                    </div>
                    <h2 class="text-2xl font-bold text-gray-800 mt-3">Choose your country</h2>
                </div>

                <div class="space-y-5">
                    <select
                        @change="selectedCountry = $event.target.value"
                        class="w-full px-5 py-4 text-lg rounded-xl border-2 border-green-300 focus:border-green-600 focus:ring-4 focus:ring-green-100 outline-none bg-white">
                        <option value="" disabled selected>Select country</option>
                        <template x-for="country in countries[selectedContinent]">
                            <option :value="country" x-text="country"></option>
                        </template>
                    </select>

                    <template x-if="selectedCountry">
                        <div class="bg-green-50 border-2 border-green-200 rounded-2xl p-6 text-center animate__animated animate__fadeIn">
                            <div class="text-6xl mb-4" x-text="continents.find(c => c.name === selectedContinent)?.emoji"></div>
                            <h3 class="text-2xl font-bold text-gray-800" x-text="selectedCountry"></h3>
                            <p class="text-green-700 font-medium mt-1" x-text="selectedContinent"></p>
                            <p class="mt-4 text-gray-700">Ready to explore <strong x-text="selectedCountry"></strong>!</p>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </div>

    {{-- Footer --}}
    <div class="border-t-2 border-gray-200 p-6 bg-gray-50">
        <div class="flex items-center gap-4">
            <button
                @click="step = 1; selectedCountry = ''"
                x-show="step === 2"
                class="px-6 py-3 rounded-xl font-medium text-green-700 bg-white border-2 border-green-300 hover:bg-green-50 transition">
                Back
            </button>

            <button
                @click="nextStep()"
                :disabled="(step === 1 && !selectedContinent) || (step === 2 && !selectedCountry) || submitting"
                class="flex-1 px-8 py-4 rounded-xl font-bold text-white text-lg shadow-lg transition-all
                       bg-green-600 hover:bg-green-700 active:bg-green-800
                       disabled:bg-gray-400 disabled:cursor-not-allowed"
                :class="submitting ? '' : 'hover:shadow-xl hover:-translate-y-1'">
                <template x-if="submitting">
                    <span class="flex items-center gap-3">
                        <svg class="animate-spin h-6 w-6" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                        Processing...
                    </span>
                </template>
                <template x-if="!submitting && step === 1">
                    Next: Choose Country
                </template>
                <template x-if="!submitting && step === 2">
                    Complete Selection
                </template>
            </button>
        </div>
    </div>
</div>

<script>
function destinationSelector() {
    return {
        step: 1,
        selectedContinent: '',
        selectedCountry: '',
        submitting: false,

        continents: [
            { name: 'Asia', emoji: 'Asia', color: 'from-emerald-500 to-green-700' },
            { name: 'Africa', emoji: 'Africa', color: 'from-emerald-600 to-green-800' },
            { name: 'Europe', emoji: 'EU', color: 'from-green-500 to-emerald-700' },
            { name: 'North America', emoji: 'North America', color: 'from-emerald-400 to-green-600' },
            { name: 'South America', emoji: 'South America', color: 'from-green-600 to-emerald-800' },
            { name: 'Australia', emoji: 'Australia', color: 'from-emerald-500 to-green-700' },
            { name: 'Antarctica', emoji: 'Mountain', color: 'from-green-400 to-emerald-600' },
        ],

        countries: {
            'Asia': ['Japan', 'India', 'China', 'Thailand', 'South Korea', 'Indonesia', 'Vietnam', 'Singapore'],
            'Africa': ['Nigeria', 'Egypt', 'South Africa', 'Kenya', 'Morocco', 'Ghana', 'Ethiopia', 'Algeria'],
            'Europe': ['France', 'Germany', 'Italy', 'Spain', 'United Kingdom', 'Netherlands', 'Poland', 'Sweden'],
            'North America': ['United States', 'Canada', 'Mexico', 'Cuba', 'Costa Rica'],
            'South America': ['Brazil', 'Argentina', 'Colombia', 'Peru', 'Chile', 'Ecuador'],
            'Australia': ['Australia', 'New Zealand', 'Fiji'],
            'Antarctica': ['Research Stations Only'],
        },

        nextStep() {
            if (this.step === 1 && this.selectedContinent) {
                this.step = 2;
            } else if (this.step === 2 && this.selectedCountry) {
                this.submitting = true;
                setTimeout(() => {
                    alert(`Success! Destination: ${this.selectedCountry}, ${this.selectedContinent}`);
                    this.step = 1;
                    this.selectedContinent = '';
                    this.selectedCountry = '';
                    this.submitting = false;
                }, 1500);
            }
        }
    }
}
</script>

<style>
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(20px); }
    to { opacity: 1; transform: translateY(0); }
}
.animate__fadeIn { animation: fadeIn 0.6s ease-out; }
</style>
