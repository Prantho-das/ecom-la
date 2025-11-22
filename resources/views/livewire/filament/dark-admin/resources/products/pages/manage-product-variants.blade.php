<x-filament-panels::page>
    <div class="space-y-6">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold tracking-tight">{{ $this->record->name }}</h2>
                <p class="text-gray-600">Manage all variants, pricing and inventory</p>
            </div>
            <x-filament::button :href="ProductResource::getUrl('edit', $this->record)">
                ← Back to Product
            </x-filament::button>
        </div>
    
        {{ $this->table }}
    </div>
</x-filament-panels::page>
