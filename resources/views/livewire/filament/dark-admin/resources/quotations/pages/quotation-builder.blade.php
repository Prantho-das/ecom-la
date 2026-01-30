<x-filament-panels::page>
    <x-slot name="heading">
        {{ $quotationId ? 'Edit Quotation ' . (\App\Models\Quotation::find($quotationId)?->reference_number ?? '#' . $quotationId) : 'Create Quotation' }}
    </x-slot>
    @vite(['resources/css/app.css'])
    <div class="space-y-8">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-zinc-900 p-6 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-800">
            <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                <flux:field>
                    <flux:label>Customer Name <span class="text-red-500">*</span></flux:label>
                    <flux:input wire:model="customer_name" placeholder="Enter customer name" />
                    @error('customer_name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </flux:field>
                <flux:field>
                    <flux:label>Email Address <span class="text-red-500">*</span></flux:label>
                    <flux:input type="email" wire:model="customer_email" placeholder="Enter email address" />
                    @error('customer_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </flux:field>
                <flux:field>
                    <flux:label>Quotation Date <span class="text-red-500">*</span></flux:label>
                    <flux:input type="date" wire:model="quotation_date" />
                    @error('quotation_date') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </flux:field>
                <flux:field>
                    <flux:label>Currency <span class="text-red-500">*</span></flux:label>
                    <flux:select wire:model.live="currency" class="min-w-[120px]">
                        <flux:select.option value="USD">USD ($)</flux:select.option>
                        <flux:select.option value="EUR">EUR (€)</flux:select.option>
                        <flux:select.option value="GBP">GBP (£)</flux:select.option>
                        <flux:select.option value="BDT">BDT (৳)</flux:select.option>
                        <flux:select.option value="AED">AED (د.إ)</flux:select.option>
                    </flux:select>
                    @error('currency') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                </flux:field>
            </div>
            <div class="flex gap-3 w-full md:w-auto">
                <flux:button wire:click="addTable" icon="plus" variant="subtle">Add Product</flux:button>
                <flux:button wire:click="save" variant="primary" icon="check" wire:loading.attr="disabled">
                    <span wire:loading.remove wire:target="save">Save Quotation</span>
                    <span wire:loading wire:target="save">Saving...</span>
                </flux:button>
            </div>
        </div>

        {{-- Tables Container --}}
        <div class="space-y-12">
            @foreach($tables as $t_idx => $table)
                @php
                    $calculations = $this->getCalculations($t_idx);
                @endphp
                <div wire:key="table-{{ $table['id'] }}" class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                    <div class="px-6 py-4 bg-zinc-50 dark:bg-zinc-800/50 border-b border-zinc-200 dark:border-zinc-800 flex justify-between items-center">
                        <div class="flex items-center gap-4">
                            <flux:select wire:model.live="tables.{{ $t_idx }}.product_id" placeholder="Choose a product..." class="w-80">
                                @foreach(\App\Models\Product::all() as $p)
                                    <flux:select.option value="{{ $p->id }}">{{ $p->name }}</flux:select.option>
                                @endforeach
                            </flux:select>
                        </div>
                        <div class="flex items-center gap-2">
                            <flux:button wire:click="duplicateTable('{{ $table['id'] }}')" size="sm" variant="ghost" icon="square-2-stack">Duplicate</flux:button>
                            <flux:button wire:click="removeTable('{{ $table['id'] }}')" size="sm" variant="ghost" color="red" icon="trash">Remove</flux:button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-zinc-50 dark:bg-zinc-800/30 border-b border-zinc-200 dark:border-zinc-800">
                                    <th class="px-4 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800 w-32">Incoterm</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800 min-w-[160px]">Unit Product Price</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800 min-w-[140px]">Export Freight</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800 min-w-[140px]">Export Clearance</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800 min-w-[180px]">Origin THC (Rate/Qty)</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800 min-w-[180px]">Int. Freight (CBM/KG)</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800 min-w-[140px]">Insurance</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800 min-w-[200px]">Import Duties (Fixed/Mult)</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800">Handling</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800">Inland</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800">Conv. Rate</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800">Factor</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800">Unit Price</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800">Price + MG</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800">MG</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800">TAX</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800">VAT</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-white bg-indigo-600 dark:bg-indigo-500 uppercase tracking-wider rounded-tr-xl">Final Price</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                                {{-- Config Row --}}
                                <tr class="bg-zinc-50/50 dark:bg-zinc-800/20">
                                    <td class="px-4 py-3 font-bold text-zinc-400 border-r border-zinc-200 dark:border-zinc-800 text-xs">-- CONFIG --</td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800">
                                        <flux:input size="sm" type="number" wire:model.live="tables.{{ $t_idx }}.unit_product_price" class="text-right font-bold text-indigo-600 dark:text-indigo-400 w-36" />
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800">
                                        <flux:input size="sm" type="number" step="0.001" wire:model.live="tables.{{ $t_idx }}.config.export_freight_rate" class="text-right w-32" />
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800">
                                        <flux:input size="sm" type="number" step="0.001" wire:model.live="tables.{{ $t_idx }}.config.export_clearance_rate" class="text-right w-32" />
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800">
                                        <div class="flex items-center gap-1 justify-end">
                                            <flux:input size="sm" type="number" wire:model.live="tables.{{ $t_idx }}.config.origin_thc_rate" class="text-right w-28" />
                                            <span class="text-zinc-400 text-xs">/</span>
                                            <flux:input size="sm" type="number" wire:model.live="tables.{{ $t_idx }}.config.origin_thc_qty" class="text-right w-28" />
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800">
                                        <div class="flex items-center gap-1 justify-end">
                                            <flux:input size="sm" type="number" wire:model.live="tables.{{ $t_idx }}.config.int_freight_cbm" class="text-right w-28" />
                                            <span class="text-zinc-400 text-xs">/</span>
                                            <flux:input size="sm" type="number" wire:model.live="tables.{{ $t_idx }}.config.int_freight_kg" class="text-right w-28" />
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800">
                                        <flux:input size="sm" type="number" step="0.001" wire:model.live="tables.{{ $t_idx }}.config.insurance_rate" class="text-right w-32" />
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800">
                                        <div class="flex items-center gap-1 justify-end">
                                            <flux:input size="sm" type="number" wire:model.live="tables.{{ $t_idx }}.config.import_duties_fixed" class="text-right w-32" />
                                            <span class="text-zinc-400 text-xs">/</span>
                                            <flux:input size="sm" type="number" step="0.01" wire:model.live="tables.{{ $t_idx }}.config.import_duties_multiplier" class="text-right w-28" />
                                        </div>
                                    </td>
                                    <td colspan="10" class="bg-zinc-100/50 dark:bg-zinc-900/50"></td>
                                </tr>

                                {{-- Breakdown Rows --}}
                                @php
                                    $selectedIncoterm = $table['selected_incoterm'] ?? 'DDP';
                                    $selectedCalc = $calculations[$selectedIncoterm] ?? $calculations['DDP'];
                                    $bdtCalc = $calculations['BDT'] ?? null;
                                    $bdtLocalCalc = $calculations['BDT (Local)'] ?? null;
                                @endphp

                                {{-- USD Incoterm Row (Consolidated with Dropdown) --}}
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                                    <td class="px-4 py-3 border-r border-zinc-200 dark:border-zinc-800">
                                        <flux:select wire:model.live="tables.{{ $t_idx }}.selected_incoterm" size="sm" class="min-w-[120px]">
                                            <flux:select.option value="Exwork">Exwork</flux:select.option>
                                            <flux:select.option value="FOB">FOB</flux:select.option>
                                            <flux:select.option value="CFR">CFR</flux:select.option>
                                            <flux:select.option value="CIF">CIF</flux:select.option>
                                            <flux:select.option value="DDU/DAP">DDU/DAP</flux:select.option>
                                            <flux:select.option value="DDP">DDP</flux:select.option>
                                        </flux:select>
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ number_format($table['unit_product_price'], 0) }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $selectedCalc['costs']['ef'] ? number_format($selectedCalc['costs']['ef'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $selectedCalc['costs']['ec'] ? number_format($selectedCalc['costs']['ec'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $selectedCalc['costs']['oh'] ? number_format($selectedCalc['costs']['oh'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $selectedCalc['costs']['inf'] ? number_format($selectedCalc['costs']['inf'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $selectedCalc['costs']['ins'] ? number_format($selectedCalc['costs']['ins'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $selectedCalc['costs']['id'] ? number_format($selectedCalc['costs']['id'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $selectedCalc['costs']['hc'] ? number_format($selectedCalc['costs']['hc'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $selectedCalc['costs']['it'] ? number_format($selectedCalc['costs']['it'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-500 text-sm">—</td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 font-medium text-purple-600 dark:text-purple-400 text-sm">
                                        {{ $selectedCalc['cf_disp'] }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm">
                                        {{ number_format($selectedCalc['up'], 0) }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm font-medium">
                                        {{ number_format($selectedCalc['up_mg'], 0) }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-amber-600 font-bold text-sm">
                                        {{ $margin }}%
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs">—</td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs">—</td>
                                    <td class="px-4 py-3 text-right font-bold text-sm text-indigo-600 dark:text-indigo-400">
                                        {{ $this->getCurrencySymbol() }}{{ number_format($selectedCalc['final'], 0) }}
                                    </td>
                                </tr>

                                {{-- BDT Row --}}
                                @if($bdtCalc)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors bg-indigo-50/30 dark:bg-indigo-500/5">
                                    <td class="px-4 py-3 border-r border-zinc-200 dark:border-zinc-800 font-bold text-indigo-600 dark:text-indigo-400 text-sm">BDT</td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ number_format($table['unit_product_price'], 0) }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $bdtCalc['costs']['ef'] ? number_format($bdtCalc['costs']['ef'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $bdtCalc['costs']['ec'] ? number_format($bdtCalc['costs']['ec'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $bdtCalc['costs']['oh'] ? number_format($bdtCalc['costs']['oh'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $bdtCalc['costs']['inf'] ? number_format($bdtCalc['costs']['inf'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $bdtCalc['costs']['ins'] ? number_format($bdtCalc['costs']['ins'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $bdtCalc['costs']['id'] ? number_format($bdtCalc['costs']['id'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $bdtCalc['costs']['hc'] ? number_format($bdtCalc['costs']['hc'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $bdtCalc['costs']['it'] ? number_format($bdtCalc['costs']['it'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-500 text-sm">
                                        {{ $conversion_rate }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 font-medium text-purple-600 dark:text-purple-400 text-sm">
                                        {{ $bdtCalc['cf_disp'] }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm">
                                        {{ number_format($bdtCalc['up'], 0) }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm font-medium">
                                        {{ number_format($bdtCalc['up_mg'], 0) }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-amber-600 font-bold text-sm">
                                        {{ $margin }}%
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs">
                                        {{ $tax }}%
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs">
                                        {{ $vat }}%
                                    </td>
                                    <td class="px-4 py-3 text-right font-bold text-sm text-purple-700 dark:text-purple-400">
                                        ৳{{ number_format($bdtCalc['final'], 0) }}
                                    </td>
                                </tr>
                                @endif

                                {{-- BDT (Local) Row --}}
                                @if($bdtLocalCalc)
                                <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors bg-indigo-50/30 dark:bg-indigo-500/5">
                                    <td class="px-4 py-3 border-r border-zinc-200 dark:border-zinc-800 font-bold text-indigo-600 dark:text-indigo-400 text-sm">BDT (Local)</td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">—</td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $bdtLocalCalc['costs']['ef'] ? number_format($bdtLocalCalc['costs']['ef'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $bdtLocalCalc['costs']['ec'] ? number_format($bdtLocalCalc['costs']['ec'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $bdtLocalCalc['costs']['oh'] ? number_format($bdtLocalCalc['costs']['oh'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $bdtLocalCalc['costs']['inf'] ? number_format($bdtLocalCalc['costs']['inf'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $bdtLocalCalc['costs']['ins'] ? number_format($bdtLocalCalc['costs']['ins'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $bdtLocalCalc['costs']['id'] ? number_format($bdtLocalCalc['costs']['id'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $bdtLocalCalc['costs']['hc'] ? number_format($bdtLocalCalc['costs']['hc'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                        {{ $bdtLocalCalc['costs']['it'] ? number_format($bdtLocalCalc['costs']['it'], 0) : '—' }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-500 text-sm">—</td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 font-medium text-purple-600 dark:text-purple-400 text-sm">
                                        {{ $bdtLocalCalc['cf_disp'] }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm">
                                        {{ number_format($bdtLocalCalc['up'], 0) }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm font-medium">
                                        {{ number_format($bdtLocalCalc['up_mg'], 0) }}
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-amber-600 font-bold text-sm">
                                        {{ $margin }}%
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs">
                                        {{ $tax }}%
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs">
                                        {{ $vat }}%
                                    </td>
                                    <td class="px-4 py-3 text-right font-bold text-sm text-purple-700 dark:text-purple-400">
                                        ৳{{ number_format($bdtLocalCalc['final'], 0) }}
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Global Configuration Footer --}}
        <div class="bg-white dark:bg-zinc-900 p-8 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-800">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <flux:field>
                    <flux:label>Exchange Rate (1 USD to BDT)</flux:label>
                    <div class="flex items-center gap-2">
                        <flux:input type="number" wire:model.live="conversion_rate" class="w-full font-bold text-indigo-600 dark:text-indigo-400" />
                        <span class="text-sm font-bold text-zinc-500">BDT</span>
                    </div>
                </flux:field>

                <flux:field>
                    <flux:label>Global Margin (%)</flux:label>
                    <div class="flex items-center gap-2">
                        <flux:input type="number" wire:model.live="margin" class="w-full font-bold text-amber-600" />
                        <span class="text-sm font-bold text-zinc-500">%</span>
                    </div>
                </flux:field>

                <div class="grid grid-cols-2 gap-4">
                    <flux:field>
                        <flux:label>Tax (%)</flux:label>
                        <flux:input type="number" wire:model.live="tax" />
                    </flux:field>
                    <flux:field>
                        <flux:label>VAT (%)</flux:label>
                        <flux:input type="number" wire:model.live="vat" />
                    </flux:field>
                </div>

                <div class="flex items-center justify-end">
                    <div class="text-right">
                        <span class="text-xs font-bold text-zinc-400 uppercase tracking-widest">Total Products</span>
                        <div class="text-4xl font-black text-indigo-600 dark:text-indigo-400">{{ count($tables) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
