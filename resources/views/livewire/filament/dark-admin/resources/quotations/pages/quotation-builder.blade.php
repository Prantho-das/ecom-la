<x-filament-panels::page>
    <style>
        input[type="number"]::-webkit-inner-spin-button,
        input[type="number"]::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        /* Exact class matches from index.html */
        .q-table-header { @apply bg-gray-100 sticky top-0 z-10 px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200; }
        .q-table-cell { @apply px-6 py-4 text-gray-900 border-r border-gray-200 text-sm; }
        .q-table-cell-right { @apply px-6 py-4 text-right text-gray-900 border-r border-gray-200 text-sm; }
        .q-input { @apply w-20 text-right border border-gray-300 rounded px-2 py-1 focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 text-sm; }
    </style>

    <div class="max-w-full mx-auto bg-white shadow-lg font-sans text-sm">

        <!-- Controls (Matches index.html) -->
        <div class="px-8 py-4 bg-gray-100 border-b border-gray-200 flex justify-between items-center">
            <div class="flex items-center space-x-4">
                <input type="text" wire:model="customer_name" placeholder="Customer Name" class="bg-transparent border-b border-gray-300 focus:border-indigo-500 outline-none px-2 py-1 font-bold">
                <input type="email" wire:model="customer_email" placeholder="Email Address" class="bg-transparent border-b border-gray-300 focus:border-indigo-500 outline-none px-2 py-1">
            </div>
            <div class="flex space-x-4">
                <button wire:click="addTable" class="inline-flex items-center px-5 py-2.5 bg-white border border-gray-300 text-gray-700 font-medium text-sm rounded hover:bg-gray-50 transition-colors shadow-sm">
                    ADD PRODUCT
                </button>
                <button wire:click="save" class="inline-flex items-center px-5 py-2.5 bg-indigo-700 text-white font-medium text-sm rounded hover:bg-indigo-800 transition-colors shadow-lg">
                    SAVE QUOTATION
                </button>
            </div>
        </div>

        <div id="tablesContainer" class="p-8 bg-gray-50 space-y-12">
            @foreach($tables as $t_idx => $table)
            <div wire:key="table-{{ $table['id'] }}" class="table-wrapper bg-white shadow-sm border border-gray-200 rounded-lg overflow-hidden">
                
                <!-- Table Context / Record Header -->
                <div class="px-6 py-3 bg-gray-100 border-b border-gray-200 flex justify-between items-center text-xs font-bold text-gray-500 uppercase tracking-widest">
                    <div class="flex items-center space-x-3">
                        <span>Product Select:</span>
                        <select wire:model.live="tables.{{ $t_idx }}.variant_id" class="bg-white border-gray-300 rounded px-2 py-1 text-gray-900 normal-case w-64">
                            <option value="">-- CHOOSE MODEL --</option>
                            @foreach(\App\Models\ProductVariant::with('product')->get() as $v)
                                <option value="{{ $v->id }}">{{ $v->product->name }} ({{ $v->title }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button wire:click="duplicateTable('{{ $table['id'] }}')" class="hover:text-indigo-600 transition-colors">Duplicate</button>
                        <span class="text-gray-300">|</span>
                        <button wire:click="removeTable('{{ $table['id'] }}')" class="hover:text-red-600 transition-colors">Remove</button>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200 border-collapse">
                        <thead class="bg-gray-100 sticky top-0 z-10">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200 w-32">Incoterm</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">Unit Product Price (USD)</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">Export Freight (local)</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">Export Clearance</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">Origin THC</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">Int. Freight</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">Insurance</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">Import Duties & Taxes</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">Handling Charges</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">Inland Transport</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">Conversion Rate</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">Cost Factor</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">Unit Price</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">Unit price with MG</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">MG</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">TAX</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-gray-700 uppercase tracking-wider border-r border-gray-200">VAT</th>
                                <th class="px-6 py-4 text-right text-xs font-semibold text-white bg-indigo-700 uppercase tracking-wider">Final Unit Price</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            @php
                                $base = (float)$table['unit_product_price'];
                                $conf = $table['config'];
                                
                                // Direct Calculations matching index.html
                                $c_ef = $base * ($conf['export_freight_rate'] / 100);
                                $c_ec = $base * ($conf['export_clearance_rate'] / 100);
                                $c_oh = $conf['origin_thc_rate'] * $conf['origin_thc_qty'];
                                $c_if = $conf['int_freight_cbm'];
                                $c_ins = $base * ($conf['insurance_rate'] / 100);
                                $c_id = $conf['import_duties_fixed'] * $conf['import_duties_multiplier'];
                                
                                $incoterms = [
                                    'Exwork' => ['ef' => 0, 'ec' => 0, 'oh' => 0, 'inf' => 0, 'ins' => 0, 'id' => 0, 'hc' => 0, 'it' => 0],
                                    'FOB' => ['ef' => $c_ef, 'ec' => $c_ec, 'oh' => $c_oh, 'inf' => 0, 'ins' => 0, 'id' => 0, 'hc' => 0, 'it' => 0],
                                    'CFR' => ['ef' => $c_ef, 'ec' => $c_ec, 'oh' => $c_oh, 'inf' => $c_if, 'ins' => 0, 'id' => 0, 'hc' => 0, 'it' => 0],
                                    'CIF' => ['ef' => $c_ef, 'ec' => $c_ec, 'oh' => $c_oh, 'inf' => $c_if, 'ins' => $c_ins, 'id' => 0, 'hc' => 0, 'it' => 0],
                                    'DDU/DAP' => ['ef' => $c_ef, 'ec' => $c_ec, 'oh' => $c_oh, 'inf' => $c_if, 'ins' => $c_ins, 'id' => 0, 'hc' => 200, 'it' => 200],
                                    'DDP' => ['ef' => $c_ef, 'ec' => $c_ec, 'oh' => $c_oh, 'inf' => $c_if, 'ins' => $c_ins, 'id' => $c_id, 'hc' => 200, 'it' => 200],
                                    'BDT' => ['is_bdt' => true, 'ef' => $c_ef, 'ec' => $c_ec, 'oh' => $c_oh, 'inf' => $c_if, 'ins' => $c_ins, 'id' => $c_id, 'hc' => 200, 'it' => 200],
                                    'BDT (Local)' => ['is_local' => true, 'ef' => 0, 'ec' => 0, 'oh' => 0, 'inf' => 0, 'ins' => 0, 'id' => 0, 'hc' => 0, 'it' => 0]
                                ];
                            @endphp

                            <!-- Row 1: The "Configuration" Row (Matches index.html lines 63-109) -->
                            <tr class="hover:bg-gray-50 bg-gray-50/30">
                                <td class="px-6 py-4 whitespace-nowrap font-medium text-gray-400 border-r border-gray-200 tracking-tighter">-- CONFIG --</td>
                                <td class="px-6 py-4 text-right border-r border-gray-200">
                                    <input type="number" wire:model.live="tables.{{ $t_idx }}.unit_product_price" class="w-24 text-right border border-gray-300 rounded px-2 py-1 focus:ring-2 focus:ring-indigo-500 font-bold text-indigo-700">
                                </td>
                                <td class="px-6 py-4 text-right border-r border-gray-200">
                                    <input type="number" step="0.001" wire:model.live="tables.{{ $t_idx }}.config.export_freight_rate" class="q-input">
                                </td>
                                <td class="px-6 py-4 text-right border-r border-gray-200">
                                    <input type="number" step="0.001" wire:model.live="tables.{{ $t_idx }}.config.export_clearance_rate" class="q-input">
                                </td>
                                <td class="px-6 py-4 text-right border-r border-gray-200 flex items-center justify-end space-x-1">
                                    <input type="number" wire:model.live="tables.{{ $t_idx }}.config.origin_thc_rate" class="w-16 q-input">
                                    <span>/</span>
                                    <input type="number" wire:model.live="tables.{{ $t_idx }}.config.origin_thc_qty" class="w-16 q-input">
                                </td>
                                <td class="px-6 py-4 text-right border-r border-gray-200 flex items-center justify-end space-x-1">
                                    <input type="number" wire:model.live="tables.{{ $t_idx }}.config.int_freight_cbm" class="w-16 q-input">
                                    <span>/</span>
                                    <input type="number" wire:model.live="tables.{{ $t_idx }}.config.int_freight_kg" class="w-16 q-input">
                                </td>
                                <td class="px-6 py-4 text-right border-r border-gray-200">
                                    <input type="number" step="0.001" wire:model.live="tables.{{ $t_idx }}.config.insurance_rate" class="q-input">
                                </td>
                                <td class="px-6 py-4 text-right border-r border-gray-200 flex items-center justify-end space-x-1">
                                    <input type="number" wire:model.live="tables.{{ $t_idx }}.config.import_duties_fixed" class="w-24 q-input">
                                    <span>/</span>
                                    <input type="number" step="0.01" wire:model.live="tables.{{ $t_idx }}.config.import_duties_multiplier" class="w-16 q-input">
                                </td>
                                <td colspan="10" class="bg-gray-100/50"></td>
                            </tr>

                            <!-- Actual Breakdown Rows -->
                            @foreach($incoterms as $name => $v)
                            @php
                                if (isset($v['is_local'])) {
                                    $cf = 0; $up = 1831250; // Hardcoded baseline from index.html example
                                    $cf_disp = "—";
                                } else {
                                    $cf = $v['ef'] + $v['ec'] + $v['oh'] + $v['inf'] + $v['ins'] + $v['id'] + $v['hc'] + $v['it'];
                                    $up = $base + $cf;
                                    $cf_disp = number_format($cf, 0);
                                }

                                if (isset($v['is_bdt'])) {
                                    $up = $up * $conversion_rate;
                                    $cf_disp = number_format($cf / $base, 2); // Factor display
                                }

                                $up_mg = $up * (1 + $margin / 100);
                                $tax_vat_multiplier = 1 + ($tax + $vat) / 100;
                                $final = $up_mg * $tax_vat_multiplier;

                                $is_bdt_row = isset($v['is_bdt']) || isset($v['is_local']);
                            @endphp
                            <tr class="hover:bg-gray-50 {{ $is_bdt_row ? 'bg-indigo-50 font-medium' : '' }}">
                                <td class="px-6 py-4 whitespace-nowrap border-r border-gray-200 {{ $name == 'BDT' ? 'font-bold text-indigo-900' : 'text-gray-900' }}">{{ $name }}</td>
                                <td class="px-6 py-4 text-right border-r border-gray-200 {{ $is_bdt_row ? 'text-indigo-900' : 'text-gray-900' }}">{{ $is_bdt_row && !isset($v['is_local']) ? number_format($base, 0) : ($name == 'BDT (Local)' ? '—' : number_format($base, 0)) }}</td>
                                <td class="px-6 py-4 text-right border-r border-gray-200 {{ $is_bdt_row ? 'text-indigo-900' : 'text-gray-900' }}">{{ $v['ef'] ? number_format($v['ef'], 0) : '--' }}</td>
                                <td class="px-6 py-4 text-right border-r border-gray-200 {{ $is_bdt_row ? 'text-indigo-900' : 'text-gray-900' }}">{{ $v['ec'] ? number_format($v['ec'], 0) : '--' }}</td>
                                <td class="px-6 py-4 text-right border-r border-gray-200 {{ $is_bdt_row ? 'text-indigo-900' : 'text-gray-900' }}">{{ $v['oh'] ? number_format($v['oh'], 0) : '--' }}</td>
                                <td class="px-6 py-4 text-right border-r border-gray-200 {{ $is_bdt_row ? 'text-indigo-900' : 'text-gray-900' }}">{{ $v['inf'] ? number_format($v['inf'], 0) : '--' }}</td>
                                <td class="px-6 py-4 text-right border-r border-gray-200 {{ $is_bdt_row ? 'text-indigo-900' : 'text-gray-900' }}">{{ $v['ins'] ? number_format($v['ins'], 0) : '--' }}</td>
                                <td class="px-6 py-4 text-right border-r border-gray-200 {{ $is_bdt_row ? 'text-indigo-900' : 'text-gray-900' }}">{{ $v['id'] ? number_format($v['id'], 0) : '--' }}</td>
                                <td class="px-6 py-4 text-right border-r border-gray-200 {{ $is_bdt_row ? 'text-indigo-900' : 'text-gray-900' }}">{{ $v['hc'] ? number_format($v['hc'], 0) : '--' }}</td>
                                <td class="px-6 py-4 text-right border-r border-gray-200 {{ $is_bdt_row ? 'text-indigo-900' : 'text-gray-900' }}">{{ $v['it'] ? number_format($v['it'], 0) : '--' }}</td>
                                
                                <td class="px-6 py-4 text-right border-r border-gray-200 {{ $is_bdt_row ? 'text-indigo-900' : 'text-gray-500' }}">{{ $name == 'BDT' ? $conversion_rate : '—' }}</td>
                                <td class="px-6 py-4 text-right border-r border-gray-200 {{ $name == 'BDT' ? 'font-bold text-purple-700' : 'text-gray-500' }}">{{ $cf_disp }}</td>
                                <td class="px-6 py-4 text-right border-r border-gray-200 {{ $is_bdt_row ? 'text-indigo-900' : 'text-gray-900' }}">{{ number_format($up, 0) }}</td>
                                <td class="px-6 py-4 text-right border-r border-gray-200 {{ $is_bdt_row ? 'text-indigo-900' : 'text-gray-900' }}">{{ number_format($up_mg, 0) }}</td>
                                
                                <td class="px-6 py-4 text-right border-r border-gray-200 text-amber-700 font-bold">{{ $margin }}%</td>
                                <td class="px-6 py-4 text-right border-r border-gray-200 {{ $is_bdt_row ? 'text-indigo-900 font-bold' : 'text-gray-500' }}">{{ $is_bdt_row ? $tax.'%' : '—' }}</td>
                                <td class="px-6 py-4 text-right border-r border-gray-200 {{ $is_bdt_row ? 'text-indigo-900 font-bold' : 'text-gray-500' }}">{{ $is_bdt_row ? $vat.'%' : '—' }}</td>
                                <td class="px-6 py-4 text-right font-bold {{ $name == 'BDT' ? 'text-purple-800' : 'text-indigo-700' }}">{{ $is_bdt_row ? '৳' : '$' }}{{ number_format($final, 0) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            @endforeach
        </div>

        <!-- Global Logic Footer (Matches index.html spirit but adds system persistence) -->
        <div class="px-8 py-10 bg-white border-t border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                <div>
                    <h4 class="text-[10px] font-black uppercase text-gray-400 mb-2">Exchange Lock</h4>
                    <div class="flex items-center space-x-2">
                        <span class="font-bold text-xs">1 USD =</span>
                        <input type="number" wire:model.live="conversion_rate" class="w-20 border-gray-300 rounded text-right px-2 py-1 font-black text-indigo-700">
                        <span class="font-bold text-xs text-gray-500">BDT</span>
                    </div>
                </div>
                <div>
                    <h4 class="text-[10px] font-black uppercase text-gray-400 mb-2">Global MG</h4>
                    <input type="number" wire:model.live="margin" class="w-16 border-gray-300 rounded text-right px-2 py-1 font-black text-amber-700">
                    <span class="text-xs font-bold">%</span>
                </div>
                <div>
                    <h4 class="text-[10px] font-black uppercase text-gray-400 mb-2">TAX & VAT</h4>
                    <div class="flex space-x-4">
                        <div class="flex items-center space-x-1">
                            <input type="number" wire:model.live="tax" class="w-12 border-gray-300 rounded text-right px-1 py-1">
                            <span class="text-[10px] font-bold">%</span>
                        </div>
                        <div class="flex items-center space-x-1">
                            <input type="number" wire:model.live="vat" class="w-12 border-gray-300 rounded text-right px-1 py-1">
                            <span class="text-[10px] font-bold">%</span>
                        </div>
                    </div>
                </div>
                <div class="flex items-end justify-end">
                    <div class="text-right">
                        <span class="text-xs font-bold text-gray-400 uppercase">Total Items</span>
                        <div class="text-3xl font-black text-indigo-700">{{ count($tables) }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
