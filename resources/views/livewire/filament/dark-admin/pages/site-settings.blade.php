<x-filament-panels::page>
   
        

    <form wire:submit.prevent="save" class="space-y-6 max-w-xl">
        {{ $this->form }}

        <x-filament::button type="submit" class="mt-4">
            Save Settings
        </x-filament::button>
    </form>

    @if($logo)
    <div class="mt-4">
        <p class="font-semibold">Current Logo:</p>
        <img src="{{ \Illuminate\Support\Facades\Storage::url($logo) }}" alt="Site Logo" class="h-24 mt-2">
    </div>
    @endif
</x-filament-panels::page>