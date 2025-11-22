<x-filament-panels::page>



    <form wire:submit.prevent="save" class="space-y-6 max-w-xl">
        {{ $this->form }}

        <x-filament::button type="submit" class="mt-4">
            Save Settings
        </x-filament::button>
    </form>

    
</x-filament-panels::page>
