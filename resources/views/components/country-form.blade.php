{{-- resources/views/components/destination-selector.blade.php --}}
<div x-data="destinationSelector()" class="flex flex-col overflow-hidden bg-white shadow-2xl rounded-2xl ">

    {{-- Content --}}
    <div class="flex-1 p-6 overflow-y-auto">

        {{-- Step 1: Continents --}}
        <template x-if="step === 1">
            <div class="space-y-6">
                <div class="text-center">
                    <h2 class="text-2xl font-bold text-gray-800">Where would you like to explore?</h2>
                    <p class="mt-2 text-gray-600">Select a continent to continue</p>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <template x-for="continent in continents" :key="continent.id">
                        <button @click="selectedContinent = continent.id"
                            class="relative h-40 overflow-hidden transition-all duration-300 transform shadow-lg rounded-2xl hover:scale-105 active:scale-98"
                            :class="selectedContinent == continent.id ? 'ring-4 ring-green-500' : ''">
                            <!-- Background -->
                            <div :class="selectedContinent == continent.id
                                    ? 'bg-green-600'
                                    : 'bg-white border-2 border-green-200'" class="absolute inset-0 rounded-2xl"></div>

                            <!-- Content -->
                            <div class="relative flex flex-col items-center justify-center h-full p-4"
                                :class="selectedContinent == continent.id ? 'text-white' : 'text-green-700'">
                                <div class="mb-3 text-6xl" x-text="continent.emoji"></div>
                                <h3 class="text-lg font-bold" x-text="continent.name"></h3>

                                <!-- Selected Checkmark -->
                                <template x-if="selectedContinent == continent.id">
                                    <div class="absolute top-3 right-3">
                                        <svg class="w-8 h-8 text-white drop-shadow-lg" fill="currentColor"
                                            viewBox="0 0 20 20">
                                            <path fill-rule="evenodd"
                                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                clip-rule="evenodd" />
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
                    <div
                        class="inline-flex items-center gap-2 px-5 py-2 font-semibold text-green-700 bg-green-100 rounded-full">
                        Selected:
                        <span x-text="selectedContinentObj?.name"></span>
                    </div>
                    <h2 class="mt-3 text-2xl font-bold text-gray-800">Choose your country</h2>
                </div>

                <div class="space-y-5">
                    <select @change="selectedCountry = $event.target.value"
                        class="w-full px-5 py-4 text-lg bg-white border-2 border-green-300 outline-none rounded-xl focus:border-green-600 focus:ring-4 focus:ring-green-100">
                        <option value="" disabled selected>Select country</option>

                        <template x-for="country in filteredCountries" :key="country.id">
                            <option :value="country.id" x-text="country.name"></option>
                        </template>
                    </select>

                    <template x-if="selectedCountry">
                        <div
                            class="p-6 text-center border-2 border-green-200 bg-green-50 rounded-2xl animate__animated animate__fadeIn">
                            <div class="mb-4 text-6xl" x-text="selectedContinentObj?.emoji"></div>
                            <h3 class="text-2xl font-bold text-gray-800" x-text="selectedCountryObj?.name"></h3>
                            <p class="mt-1 font-medium text-green-700" x-text="selectedContinentObj?.name"></p>
                            <p class="mt-4 text-gray-700">Ready to explore <strong
                                    x-text="selectedCountryObj?.name"></strong>!</p>
                        </div>
                    </template>
                </div>
            </div>
        </template>
    </div>

    {{-- Footer --}}
    <div class="p-6 border-t-2 border-gray-200 bg-gray-50">
        <div class="flex items-center gap-4">
            <button @click="step = 1; selectedCountry = ''" x-show="step === 2"
                class="px-6 py-3 font-medium text-green-700 transition bg-white border-2 border-green-300 rounded-xl hover:bg-green-50">
                Back
            </button>

            <button @click="nextStep()"
                :disabled="(step === 1 && !selectedContinent) || (step === 2 && !selectedCountry) || submitting"
                class="flex-1 px-8 py-4 text-lg font-bold text-white transition-all bg-green-600 shadow-lg rounded-xl hover:bg-green-700 active:bg-green-800 disabled:bg-gray-400 disabled:cursor-not-allowed"
                :class="submitting ? '' : 'hover:shadow-xl hover:-translate-y-1'">
                <template x-if="submitting">
                    <span class="flex items-center gap-3">
                        <svg class="w-6 h-6 animate-spin" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4">
                            </circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path>
                        </svg>
                        Processing...
                    </span>
                </template>
                <template x-if="!submitting && step === 1">Next: Choose Country</template>
                <template x-if="!submitting && step === 2">Complete Selection</template>
            </button>
        </div>
    </div>
</div>

@php
$continents = \DB::table('continents')->get();
$countries = \DB::table('countries')->get();
@endphp

<script>
    function destinationSelector() {
    return {
        step: 1,
        selectedContinent: '',
        selectedCountry: '',
        submitting: false,

        continents: @json($continents),
        countries: @json($countries),

        get filteredCountries() {
            return this.selectedContinent
                ? this.countries.filter(c => c.continent_id == this.selectedContinent)
                : [];
        },

        get selectedContinentObj() {
            return this.continents.find(c => c.id == this.selectedContinent);
        },

        get selectedCountryObj() {
            return this.countries.find(c => c.id == this.selectedCountry);
        },

        nextStep() {
            if (this.step === 1 && this.selectedContinent) {
                this.step = 2;
                return;
            }

            if (this.step === 2 && this.selectedCountry) {
                this.submitting = true;

                setTimeout(() => {
                    alert(
                        `Success! Destination: ${this.selectedCountryObj?.name}, ${this.selectedContinentObj?.name}`
                    );

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
        from {
            opacity: 0;
            transform: translateY(20px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .animate__fadeIn {
        animation: fadeIn 0.6s ease-out;
    }
</style>
