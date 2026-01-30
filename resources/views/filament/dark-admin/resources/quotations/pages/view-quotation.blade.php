<x-filament-panels::page>
    <div class="flex justify-center bg-zinc-100 dark:bg-zinc-950 p-4 md:p-8 min-h-screen">
        <div class="w-full max-w-[210mm] bg-white dark:bg-zinc-900 shadow-2xl p-[15mm] md:p-[20mm] rounded-sm text-zinc-900 dark:text-zinc-100 border border-zinc-200 dark:border-zinc-800 ring-1 ring-zinc-200 dark:ring-zinc-800">
            {{-- Professional Header --}}
            <div class="flex justify-between items-start mb-12 border-b-2 border-indigo-600 dark:border-indigo-500 pb-8">
                <div>
                    <h1 class="text-4xl font-black tracking-tighter text-indigo-600 dark:text-indigo-400 mb-2">CITEC</h1>
                    <div class="text-sm font-bold uppercase tracking-widest text-zinc-500">International Sdn Bhd</div>
                    <div class="mt-4 text-xs text-zinc-500 max-w-xs leading-relaxed">
                        No. 1C (3rd Floor), Jalan Anggerik Vanilla X31/X,<br>
                        Kota Kemuning, Seksyen 31, 40460 Shah Alam,<br>
                        Selangor Darul Ehsan, Malaysia<br>
                        Tel: +603-51245668/67 | Fax: +603-51245669
                    </div>
                </div>
                <div class="text-right">
                    <h2 class="text-3xl font-light text-zinc-400 uppercase tracking-[0.2em] mb-4">Proforma Invoice</h2>
                    <div class="space-y-1">
                        <div class="text-sm"><span class="text-zinc-500 font-medium">Invoice No:</span> <span class="font-bold underline decoration-indigo-500/30 underline-offset-4">{{ $record->reference_number ?? 'PI25-' . str_pad($record->id, 4, '0', STR_PAD_LEFT) }}</span></div>
                        <div class="text-sm"><span class="text-zinc-500 font-medium">Date:</span> <span class="font-bold">{{ $record->quotation_date ? $record->quotation_date->format('d M Y') : $record->created_at->format('d M Y') }}</span></div>
                        <div class="text-sm"><span class="text-zinc-500 font-medium">Status:</span> <flux:badge size="sm" color="{{ match($record->status) { 'draft' => 'gray', 'sent' => 'primary', 'accepted' => 'success', 'rejected' => 'danger', default => 'info' } }}">{{ strtoupper($record->status) }}</flux:badge></div>
                    </div>
                </div>
            </div>

            {{-- Info Selection --}}
            <div class="grid grid-cols-2 gap-12 mb-12">
                <div>
                    <div class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400 mb-4 border-b border-indigo-100 dark:border-indigo-900/50 pb-2">Bill To</div>
                    <div class="font-black text-xl mb-1">{{ $record->customer_name }}</div>
                    <div class="text-zinc-600 dark:text-zinc-400 text-sm mb-4">{{ $record->customer_email }}</div>
                    <div class="text-xs text-zinc-500 space-y-1">
                        <div>Attn: Mr. Amran</div>
                        <div>Tel: +88 02 8116 124</div>
                        <div>Fax: +88 02 9121 230</div>
                    </div>
                </div>
                <div class="space-y-4">
                    <div class="text-xs font-bold uppercase tracking-widest text-indigo-600 dark:text-indigo-400 mb-4 border-b border-indigo-100 dark:border-indigo-900/50 pb-2">Terms & Logistics</div>
                    <div class="grid grid-cols-2 gap-y-2 text-sm">
                        <div class="text-zinc-500">Shipping Method:</div>
                        <div class="font-bold border-b border-zinc-100 dark:border-zinc-800">{{ strtoupper($record->shipping_method) }}</div>
                        <div class="text-zinc-500">Pricing Tier:</div>
                        <div class="font-bold border-b border-zinc-100 dark:border-zinc-800">{{ strtoupper(str_replace('_', '/', $record->pricing_tier)) }}</div>
                        <div class="text-zinc-500">Currency:</div>
                        <div class="font-bold border-b border-zinc-100 dark:border-zinc-800">{{ $record->currency }}</div>
                        <div class="text-zinc-500">Payment Term:</div>
                        <div class="font-bold border-b border-zinc-100 dark:border-zinc-800">TT Before Delivery</div>
                    </div>
                </div>
            </div>

            {{-- Items Table --}}
            <div class="mb-12">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-indigo-600 text-white">
                            <th class="px-4 py-3 text-xs font-black uppercase tracking-wider rounded-tl-sm">Item</th>
                            <th class="px-4 py-3 text-xs font-black uppercase tracking-wider">Product Description</th>
                            <th class="px-4 py-3 text-xs font-black uppercase tracking-wider text-center">Qty</th>
                            <th class="px-4 py-3 text-xs font-black uppercase tracking-wider text-center">UOM</th>
                            <th class="px-4 py-3 text-xs font-black uppercase tracking-wider text-right">Unit Price</th>
                            <th class="px-4 py-3 text-xs font-black uppercase tracking-wider text-right rounded-tr-sm">Amount</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800 border-b border-zinc-200 dark:border-zinc-800">
                        @foreach($record->items as $index => $item)
                        <tr class="hover:bg-zinc-50 dark:hover:bg-zinc-800/50 transition-colors">
                            <td class="px-4 py-4 text-sm font-bold text-zinc-400">{{ $index + 1 }}</td>
                            <td class="px-4 py-4">
                                <div class="font-black text-zinc-900 dark:text-zinc-100 uppercase tracking-tight">{{ $item->product_name }}</div>
                                <div class="text-[10px] font-mono text-zinc-400 mt-1">ID: {{ str_pad($item->product_id, 6, '0', STR_PAD_LEFT) }}</div>
                                <div class="text-xs text-zinc-500 mt-1 italic">Incoterm: {{ $item->incoterm }}</div>
                            </td>
                            <td class="px-4 py-4 text-center font-bold">1</td>
                            <td class="px-4 py-4 text-center text-zinc-500 text-xs">UNIT</td>
                            <td class="px-4 py-4 text-right font-mono text-sm">{{ number_format($item->final_unit_price, 2) }}</td>
                            <td class="px-4 py-4 text-right font-black text-indigo-600 dark:text-indigo-400 text-sm">{{ number_format($item->final_unit_price, 2) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- Totals --}}
            <div class="flex justify-between items-start mb-12">
                <div class="max-w-md">
                    <div class="text-xs font-bold uppercase tracking-widest text-zinc-400 mb-2">Amount in Words</div>
                    <div class="text-sm font-black italic text-zinc-600 dark:text-zinc-400 p-4 bg-zinc-50 dark:bg-zinc-800/50 border-l-4 border-indigo-500">
                        {{ $record->currency }}: {{ strtoupper(\NumberFormatter::create('en', \NumberFormatter::SPELLOUT)->format($record->grand_total)) }} ONLY
                    </div>
                </div>
                <div class="w-72">
                    <div class="space-y-2">
                        <div class="flex justify-between text-sm">
                            <span class="text-zinc-500 font-medium">Subtotal</span>
                            <span class="font-bold">{{ number_format($record->subtotal, 2) }}</span>
                        </div>
                        <div class="flex justify-between text-sm">
                            <span class="text-zinc-500 font-medium">Discount</span>
                            <span class="font-bold text-red-500">- {{ number_format($record->discount_total ?? 0, 2) }}</span>
                        </div>
                        <div class="pt-2 mt-2 border-t-2 border-zinc-200 dark:border-zinc-800 flex justify-between items-center">
                            <span class="text-indigo-600 dark:text-indigo-400 font-black uppercase tracking-tighter text-lg">Grand Total</span>
                            <div class="text-right">
                                <div class="text-xs font-black text-zinc-400">{{ $record->currency }}</div>
                                <div class="text-2xl font-black text-indigo-600 dark:text-indigo-400">{{ number_format($record->grand_total, 2) }}</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Footer / Terms --}}
            <div class="grid grid-cols-2 gap-12 text-[10px] pt-8 border-t border-zinc-200 dark:border-zinc-800">
                <div class="space-y-4">
                    <div>
                        <div class="font-black uppercase tracking-widest text-zinc-400 mb-1">Bank Details</div>
                        <div class="text-zinc-600 dark:text-zinc-400 space-y-0.5">
                            <div class="font-bold text-zinc-900 dark:text-zinc-100">CIMB Bank Berhad</div>
                            <div>22 A-0, Wisma Esther Robert, Lorong Batu Nilam 4B,</div>
                            <div>Bandar Bukit Tinggi, 41200 Klang, Selangor, Malaysia</div>
                            <div class="font-black text-indigo-600 dark:text-indigo-400 mt-2">A/C No: 800004305840 (For Payment in {{ $record->currency }})</div>
                        </div>
                    </div>
                    <div>
                        <div class="font-black uppercase tracking-widest text-zinc-400 mb-1">Intermediary Bank Notice</div>
                        <div class="text-red-500 font-bold italic">
                            * Please include intermediary bank charge and your local bank charge
                        </div>
                    </div>
                </div>
                <div>
                    <div class="font-black uppercase tracking-widest text-zinc-400 mb-1">Company Signature</div>
                    <div class="mt-8 border-b-2 border-zinc-200 dark:border-zinc-800 w-48 mb-2"></div>
                    <div class="font-black uppercase text-xs leading-none">Citec International Sdn Bhd</div>
                    <div class="text-zinc-400 mt-1 uppercase tracking-widest">Authorized Signature</div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
