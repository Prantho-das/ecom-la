<x-filament-panels::page>

    <form wire:submit.prevent="save" class="max-w-xl space-y-6">
        {{ $this->form }}
        <br />
        <x-filament::button type="submit" class="mt-4">
            Save Settings
        </x-filament::button>
    </form>

<x-filament-actions::modals />
</x-filament-panels::page>
