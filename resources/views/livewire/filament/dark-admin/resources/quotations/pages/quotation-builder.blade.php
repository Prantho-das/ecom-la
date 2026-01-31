<x-filament-panels::page>
    <x-slot name="heading">
        {{ $quotationId ? 'Edit Quotation ' . (\App\Models\Quotation::find($quotationId)?->reference_number ?? '#' . $quotationId) : 'Create Quotation' }}
    </x-slot>
    @vite(['resources/css/app.css'])
    <div class="space-y-8">
        {{-- Header Section --}}
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-800/50 flex justify-between items-center bg-zinc-50 dark:bg-zinc-800/40">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-indigo-600 flex items-center justify-center text-white shadow-lg shadow-indigo-600/20">
                        <flux:icon icon="document-text" class="w-5 h-5" />
                    </div>
                    <div>
                        <h3 class="text-sm font-black uppercase tracking-widest text-zinc-900 dark:text-zinc-100">Customer Metadata</h3>
                        <p class="text-[10px] font-bold text-zinc-400 uppercase">Specify recipient & reference details</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <flux:button wire:click="addTable" icon="plus" variant="subtle" size="sm" class="font-black uppercase text-[10px] tracking-widest">Add Product</flux:button>
                    <flux:button wire:click="save" variant="primary" icon="check" size="sm" wire:loading.attr="disabled" class="font-black uppercase text-[10px] tracking-widest shadow-lg shadow-indigo-600/20">
                        <span wire:loading.remove wire:target="save">Save Quote</span>
                        <span wire:loading wire:target="save">Saving...</span>
                    </flux:button>
                </div>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    {{-- Basic Info --}}
                    <div class="md:col-span-1 space-y-6">
                        <flux:field>
                            <flux:label>Customer Name <span class="text-red-500">*</span></flux:label>
                            <flux:input wire:model="customer_name" placeholder="Business or Name" />
                            @error('customer_name') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </flux:field>
                        <flux:field>
                            <flux:label>Email Address <span class="text-red-500">*</span></flux:label>
                            <flux:input type="email" wire:model="customer_email" placeholder="email@example.com" />
                            @error('customer_email') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </flux:field>
                        <flux:field>
                            <flux:label>Quotation Date <span class="text-red-500">*</span></flux:label>
                            <flux:input type="date" wire:model="quotation_date" />
                        </flux:field>
                    </div>

                    {{-- References --}}
                    <div class="md:col-span-1 space-y-6">
                        <flux:field>
                            <flux:label>Attention To</flux:label>
                            <flux:input wire:model="attn" placeholder="Contact Person" />
                        </flux:field>
                        <flux:field>
                            <flux:label>Payment Term</flux:label>
                            <flux:input wire:model="payment_term" placeholder="TT Before Delivery" />
                        </flux:field>
                        <flux:field>
                            <flux:label>Customer PO Ref</flux:label>
                            <flux:input wire:model="customer_po" placeholder="PO-12345" />
                        </flux:field>
                    </div>

                    {{-- Communication --}}
                    <div class="md:col-span-1 space-y-6">
                        <flux:field>
                            <flux:label>Phone Number</flux:label>
                            <flux:input wire:model="customer_phone" placeholder="+00 000 0000" />
                        </flux:field>
                        <flux:field>
                            <flux:label>Fax Number</flux:label>
                            <flux:input wire:model="customer_fax" placeholder="+00 000 0000" />
                        </flux:field>
                    </div>

                    {{-- Full Address --}}
                    <div class="md:col-span-1">
                        <flux:field class="h-full">
                            <flux:label>Office Address</flux:label>
                            <flux:textarea wire:model="customer_address" placeholder="Line 1, Line 2, Zip, Country" class="h-[calc(100%-2rem)]" rows="8" />
                        </flux:field>
                    </div>
                </div>
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
                                        <div x-data="{ open: false }">
                                            <flux:button x-on:click="open = ! open" size="sm" variant="ghost" icon="beaker">Show Logic</flux:button>

                                            <template x-teleport="body">
                                                <div x-show="open" 
                                                     x-transition:enter="transition ease-out duration-300"
                                                     x-transition:enter-start="opacity-0 translate-y-4"
                                                     x-transition:enter-end="opacity-100 translate-y-0"
                                                     class="fixed inset-0 z-50 flex items-center justify-center p-4 bg-zinc-900/50 backdrop-blur-sm"
                                                     x-on:click.self="open = false">
                                                    <div class="bg-white dark:bg-zinc-900 rounded-2xl shadow-2xl border border-zinc-200 dark:border-zinc-800 w-full max-w-2xl overflow-hidden">
                                                        <div class="px-6 py-4 border-b border-zinc-100 dark:border-zinc-800/50 flex justify-between items-center bg-zinc-50/50 dark:bg-zinc-800/20">
                                                            <div class="flex items-center gap-3">
                                                                <div class="w-8 h-8 rounded-lg bg-purple-600 flex items-center justify-center text-white">
                                                                    <flux:icon icon="beaker" class="w-4 h-4" />
                                                                </div>
                                                                <h3 class="text-sm font-black uppercase tracking-widest">{{ $table['name'] ?: 'Product' }} - Calculation Logic</h3>
                                                            </div>
                                                            <flux:button x-on:click="open = false" variant="ghost" size="sm" icon="x-mark" />
                                                        </div>
                                                        <div class="p-6 overflow-y-auto max-h-[70vh] space-y-4">
                                                            @foreach(($calculations[$table['selected_incoterm'] ?? 'DDP']['formulas'] ?? []) as $label => $formula)
                                                                <div class="space-y-1">
                                                                    <span class="text-[10px] font-black uppercase text-zinc-400 tracking-wider">{{ $label }}</span>
                                                                    <div class="p-3 bg-zinc-50 dark:bg-zinc-800/50 rounded-xl border border-zinc-100 dark:border-zinc-800 font-mono text-xs text-zinc-600 dark:text-zinc-300 break-all">
                                                                        {{ $formula }}
                                                                    </div>
                                                                </div>
                                                            @endforeach
                                                        </div>
                                                        <div class="p-4 bg-zinc-50 dark:bg-zinc-800/20 border-t border-zinc-100 dark:border-zinc-800/50 text-right">
                                                            <flux:button x-on:click="open = false" size="sm" variant="subtle">Close Breakdown</flux:button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </template>
                                        </div>
                                        <flux:button wire:click="duplicateTable('{{ $table['id'] }}')" size="sm" variant="ghost" icon="square-2-stack">Duplicate</flux:button>
                                        <flux:button wire:click="removeTable('{{ $table['id'] }}')" size="sm" variant="ghost" color="red" icon="trash">Remove</flux:button>
                                    </div>
                                </div>

                                <div class="overflow-x-auto">
                                    <table class="w-full text-left border-collapse">
                                        <thead>
                                            <tr class="bg-zinc-50 dark:bg-zinc-800/30 border-b border-zinc-200 dark:border-zinc-800">
                                                <th class="px-4 py-3 text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800 w-32">Incoterm</th>
                                                <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800 min-w-[80px]">Qty</th>
                                                <th class="px-4 py-3 text-left text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800 w-24">Uom</th>
                                                <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800 min-w-[200px]">Unit Price / Curr</th>
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
                                                <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800 min-w-[100px]">MG %</th>
                                                <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800">Price + MG</th>
                                                <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800 min-w-[100px]">TAX %</th>
                                                <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800 min-w-[100px]">VAT %</th>
                                                <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800 min-w-[100px]">Disc %</th>
                                                <th class="px-4 py-3 text-right text-xs font-semibold text-white bg-indigo-600 dark:bg-indigo-500 uppercase tracking-wider rounded-tr-xl">Final Price</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                                            {{-- Config Row --}}
                                            <tr class="bg-zinc-50 dark:bg-zinc-800/40">
                                                <td class="px-4 py-3 font-bold text-zinc-400 border-r border-zinc-200 dark:border-zinc-800 text-xs">-- CONFIG --</td>
                                                <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800">

                                                </td>
                                                <td class="px-4 py-3 text-left border-r border-zinc-200 dark:border-zinc-800">

                                                </td>
                                                <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800">
                                                    <div class="flex gap-1">
                                                        <flux:input type="number" wire:model.live="tables.{{ $t_idx }}.unit_product_price" class="text-right font-bold text-indigo-600 dark:text-indigo-400 w-32" />
                                                        <flux:select wire:model.live="tables.{{ $t_idx }}.currency" class="w-24">
                                                            <flux:select.option value="USD">USD</flux:select.option>
                                                            <flux:select.option value="EUR">EUR</flux:select.option>
                                                            <flux:select.option value="GBP">GBP</flux:select.option>
                                                            <flux:select.option value="BDT">BDT</flux:select.option>
                                                            <flux:select.option value="AED">AED</flux:select.option>
                                                        </flux:select>
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800">
                                                    <flux:input type="number" step="0.001" wire:model.live="tables.{{ $t_idx }}.config.export_freight_rate" class="text-right w-40" />
                                                </td>
                                                <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800">
                                                    <flux:input type="number" step="0.001" wire:model.live="tables.{{ $t_idx }}.config.export_clearance_rate" class="text-right w-40" />
                                                </td>
                                                <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800">
                                                    <div class="flex items-center gap-1 justify-end">
                                                        <flux:input type="number" wire:model.live="tables.{{ $t_idx }}.config.origin_thc_rate" class="text-right w-40" />
                                                        <span class="text-zinc-400 text-xs">/</span>
                                                        <flux:input type="number" wire:model.live="tables.{{ $t_idx }}.config.origin_thc_qty" class="text-right w-40" />
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800">
                                                    <div class="flex items-center gap-1 justify-end">
                                                        <flux:input type="number" wire:model.live="tables.{{ $t_idx }}.config.int_freight_cbm" class="text-right w-40" />
                                                        <span class="text-zinc-400 text-xs">/</span>
                                                        <flux:input type="number" wire:model.live="tables.{{ $t_idx }}.config.int_freight_kg" class="text-right w-40" />
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800">
                                                    <flux:input type="number" step="0.001" wire:model.live="tables.{{ $t_idx }}.config.insurance_rate" class="text-right w-40" />
                                                </td>
                                                <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800">
                                                    <div class="flex items-center gap-1 justify-end">
                                                        <flux:input type="number" wire:model.live="tables.{{ $t_idx }}.config.import_duties_fixed" class="text-right w-40" />
                                                        <span class="text-zinc-400 text-xs">/</span>
                                                        <flux:input type="number" step="0.01" wire:model.live="tables.{{ $t_idx }}.config.import_duties_multiplier" class="text-right w-40" />
                                                    </div>
                                                </td>
                                                <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800">
                                                    <flux:input type="number" wire:model.live="tables.{{ $t_idx }}.config.handling_charges_global" class="text-right w-40" />
                                                </td>
                                                <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800">
                                                    <flux:input type="number" wire:model.live="tables.{{ $t_idx }}.config.inland_transport_global" class="text-right w-40" />
                                                </td>
                                                <td colspan="9" class="p-4 bg-zinc-100 dark:bg-zinc-800/60 font-black text-[9px] text-zinc-400 uppercase tracking-[0.2em] text-center italic">Pricing Configuration Inputs</td>
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
                                                    <flux:select wire:model.live="tables.{{ $t_idx }}.selected_incoterm" class="min-w-[200px]">
                                                        <flux:select.option value="Exwork">Exwork</flux:select.option>
                                                        <flux:select.option value="FOB">FOB</flux:select.option>
                                                        <flux:select.option value="CFR">CFR</flux:select.option>
                                                        <flux:select.option value="CIF">CIF</flux:select.option>
                                                        <flux:select.option value="DDU/DAP">DDU/DAP</flux:select.option>
                                                        <flux:select.option value="DDP">DDP</flux:select.option>
                                                    </flux:select>
                                                </td>
                                                <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-zinc-100 font-bold text-sm">
                                                    <flux:input type="number" wire:model.live="tables.{{ $t_idx }}.quantity" class="text-right w-32" />
                                                </td>
                                                <td class="px-4 py-3 text-left border-r border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm">
                                                    {{ $table['uom'] }}
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
                                                <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-amber-600 font-bold text-sm">
                                                    <flux:input type="number" wire:model.live="tables.{{ $t_idx }}.margin" class="text-right w-40" />
                                                </td>
                                                <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm font-medium">
                                                    {{ number_format($selectedCalc['up_mg'], 0) }}
                                                </td>
                                                <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs">
                                                    <flux:input type="number" wire:model.live="tables.{{ $t_idx }}.tax" class="text-right w-40" />
                                                </td>
                                                <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs">
                                                    <flux:input type="number" wire:model.live="tables.{{ $t_idx }}.vat" class="text-right w-40" />
                                                </td>
                                                <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs">
                                                    <flux:input type="number" wire:model.live="tables.{{ $t_idx }}.discount" class="text-right w-40" />
                                                </td>
                                                <td class="px-4 py-3 text-right font-bold text-sm text-indigo-600 dark:text-indigo-400">
                                                    {{-- Use the table specific currency symbol based on selection if needed, or global? User asked for product wise currency. --}}
                                                    @php
                $curr = $table['currency'] ?? $this->currency;
                $sym = match ($curr) {
                    'USD' => '$', 'EUR' => '€', 'GBP' => '£', 'BDT' => '৳', 'AED' => 'د.إ', default => '$'
                };
                                                    @endphp
                                                    <span class="text-xs text-gray-400 mr-1">{{ $curr }}</span>{{ $sym }}{{ number_format($selectedCalc['final'], 0) }}
                                                </td>
                                            </tr>

                                            {{-- BDT Row --}}
                                            @if($bdtCalc)
                                            <tr class="hidden hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors bg-indigo-50/30 dark:bg-indigo-500/5">
                                                <td class="px-4 py-3 border-r border-zinc-200 dark:border-zinc-800 font-bold text-indigo-600 dark:text-indigo-400 text-sm">BDT</td>
                                                <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-zinc-100 font-bold text-sm">
                                                    {{ number_format($table['quantity'], 0) }}
                                                </td>
                                                <td class="px-4 py-3 text-left border-r border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm">
                                                    {{ $table['uom'] }}
                                                </td>
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
                                                    {{ $table['margin'] ?? 0 }}%
                                                </td>
                                                <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs">
                                                    {{ $table['tax'] ?? 0 }}%
                                                </td>
                                                <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs">
                                                    {{ $table['vat'] ?? 0 }}%
                                                </td>
                                                <td class="px-4 py-3 text-right font-bold text-sm text-purple-700 dark:text-purple-400">
                                                    ৳{{ number_format($bdtCalc['final'], 0) }}
                                                </td>
                                            </tr>
                                            @endif

                                            {{-- BDT (Local) Row --}}
                                            @if($bdtLocalCalc)
                                            <tr class="hidden hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors bg-indigo-50/30 dark:bg-indigo-500/5">
                                                <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-zinc-100 font-bold text-sm">
                                                    {{ number_format($table['quantity'], 0) }}
                                                </td>
                                                <td class="px-4 py-3 text-left border-r border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm">
                                                    {{ $table['uom'] }}
                                                </td>
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
                                                    {{ $table['margin'] ?? 0 }}%
                                                </td>
                                                <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs">
                                                    {{ $table['tax'] ?? 0 }}%
                                                </td>
                                                <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs">
                                                    {{ $table['vat'] ?? 0 }}%
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

                <div class="md:col-span-2"></div>

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
