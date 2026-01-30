<x-filament-panels::page>
    @vite(['resources/css/app.css'])
    <div class="space-y-8">
        {{-- Header Section --}}
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 bg-white dark:bg-zinc-900 p-6 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-800">
            <div class="flex flex-col md:flex-row gap-4 w-full md:w-auto">
                <flux:field>
                    <flux:label>Customer Name</flux:label>
                    <flux:input wire:model="customer_name" placeholder="Enter customer name" />
                </flux:field>
                <flux:field>
                    <flux:label>Email Address</flux:label>
                    <flux:input type="email" wire:model="customer_email" placeholder="Enter email address" />
                </flux:field>
            </div>
            <div class="flex gap-3 w-full md:w-auto">
                <flux:button wire:click="addTable" icon="plus" variant="subtle">Add Product</flux:button>
                <flux:button wire:click="save" variant="primary" icon="check">Save Quotation</flux:button>
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
                            <flux:select wire:model.live="tables.{{ $t_idx }}.variant_id" placeholder="Choose a product model..." class="w-80">
                                @foreach(\App\Models\ProductVariant::with('product')->get() as $v)
                                    <flux:select.option value="{{ $v->id }}">{{ $v->product->name }} ({{ $v->title }})</flux:select.option>
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
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800 min-w-[120px]">Unit Product Price</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800 min-w-[100px]">Export Freight</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800 min-w-[100px]">Export Clearance</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800 min-w-[120px]">Origin THC (Rate/Qty)</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800 min-w-[120px]">Int. Freight (CBM/KG)</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800 min-w-[100px]">Insurance</th>
                                    <th class="px-4 py-3 text-right text-xs font-semibold text-zinc-500 uppercase tracking-wider border-r border-zinc-200 dark:border-zinc-800 min-w-[120px]">Import Duties (Fixed/Mult)</th>
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
                                        <flux:input size="sm" type="number" wire:model.live="tables.{{ $t_idx }}.unit_product_price" class="text-right font-bold text-indigo-600 dark:text-indigo-400" />
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800">
                                        <flux:input size="sm" type="number" step="0.001" wire:model.live="tables.{{ $t_idx }}.config.export_freight_rate" class="text-right" />
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800">
                                        <flux:input size="sm" type="number" step="0.001" wire:model.live="tables.{{ $t_idx }}.config.export_clearance_rate" class="text-right" />
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800">
                                        <div class="flex items-center gap-1 justify-end">
                                            <flux:input size="sm" type="number" wire:model.live="tables.{{ $t_idx }}.config.origin_thc_rate" class="text-right w-16" />
                                            <span class="text-zinc-400 text-xs">/</span>
                                            <flux:input size="sm" type="number" wire:model.live="tables.{{ $t_idx }}.config.origin_thc_qty" class="text-right w-16" />
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800">
                                        <div class="flex items-center gap-1 justify-end">
                                            <flux:input size="sm" type="number" wire:model.live="tables.{{ $t_idx }}.config.int_freight_cbm" class="text-right w-16" />
                                            <span class="text-zinc-400 text-xs">/</span>
                                            <flux:input size="sm" type="number" wire:model.live="tables.{{ $t_idx }}.config.int_freight_kg" class="text-right w-16" />
                                        </div>
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800">
                                        <flux:input size="sm" type="number" step="0.001" wire:model.live="tables.{{ $t_idx }}.config.insurance_rate" class="text-right" />
                                    </td>
                                    <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800">
                                        <div class="flex items-center gap-1 justify-end">
                                            <flux:input size="sm" type="number" wire:model.live="tables.{{ $t_idx }}.config.import_duties_fixed" class="text-right w-20" />
                                            <span class="text-zinc-400 text-xs">/</span>
                                            <flux:input size="sm" type="number" step="0.01" wire:model.live="tables.{{ $t_idx }}.config.import_duties_multiplier" class="text-right w-16" />
                                        </div>
                                    </td>
                                    <td colspan="10" class="bg-zinc-100/50 dark:bg-zinc-900/50"></td>
                                </tr>

                                {{-- Breakdown Rows --}}
                                @foreach($calculations as $name => $calc)
                                    <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors {{ $calc['is_bdt_row'] ? 'bg-indigo-50/30 dark:bg-indigo-500/5' : '' }}">
                                        <td class="px-4 py-3 border-r border-zinc-200 dark:border-zinc-800 {{ $name === 'BDT' ? 'font-bold text-indigo-600 dark:text-indigo-400' : 'text-zinc-700 dark:text-zinc-300' }} text-sm">{{ $name }}</td>
                                        <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                            {{ $name === 'BDT (Local)' ? '—' : number_format($table['unit_product_price'], 0) }}
                                        </td>
                                        <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                            {{ $calc['costs']['ef'] ? number_format($calc['costs']['ef'], 0) : '—' }}
                                        </td>
                                        <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                            {{ $calc['costs']['ec'] ? number_format($calc['costs']['ec'], 0) : '—' }}
                                        </td>
                                        <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                            {{ $calc['costs']['oh'] ? number_format($calc['costs']['oh'], 0) : '—' }}
                                        </td>
                                        <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                            {{ $calc['costs']['inf'] ? number_format($calc['costs']['inf'], 0) : '—' }}
                                        </td>
                                        <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                            {{ $calc['costs']['ins'] ? number_format($calc['costs']['ins'], 0) : '—' }}
                                        </td>
                                        <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                            {{ $calc['costs']['id'] ? number_format($calc['costs']['id'], 0) : '—' }}
                                        </td>
                                        <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                            {{ $calc['costs']['hc'] ? number_format($calc['costs']['hc'], 0) : '—' }}
                                        </td>
                                        <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-600 dark:text-zinc-400 text-sm">
                                            {{ $calc['costs']['it'] ? number_format($calc['costs']['it'], 0) : '—' }}
                                        </td>
                                        <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-500 text-sm">
                                            {{ $name === 'BDT' ? $conversion_rate : '—' }}
                                        </td>
                                        <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 font-medium text-purple-600 dark:text-purple-400 text-sm">
                                            {{ $calc['cf_disp'] }}
                                        </td>
                                        <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm">
                                            {{ number_format($calc['up'], 0) }}
                                        </td>
                                        <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-900 dark:text-zinc-100 text-sm font-medium">
                                            {{ number_format($calc['up_mg'], 0) }}
                                        </td>
                                        <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-amber-600 font-bold text-sm">
                                            {{ $margin }}%
                                        </td>
                                        <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs">
                                            {{ $calc['is_bdt_row'] ? $tax.'%' : '—' }}
                                        </td>
                                        <td class="px-4 py-3 text-right border-r border-zinc-200 dark:border-zinc-800 text-zinc-500 text-xs">
                                            {{ $calc['is_bdt_row'] ? $vat.'%' : '—' }}
                                        </td>
                                        <td class="px-4 py-3 text-right font-bold text-sm {{ $name === 'BDT' ? 'text-purple-700 dark:text-purple-400' : 'text-indigo-600 dark:text-indigo-400' }}">
                                            {{ $calc['is_bdt_row'] ? '৳' : '$' }}{{ number_format($calc['final'], 0) }}
                                        </td>
                                    </tr>
                                @endforeach
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
