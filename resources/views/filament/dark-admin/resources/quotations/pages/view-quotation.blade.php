<x-filament-panels::page>
    <div class="flex justify-center bg-gray-100 p-4 md:p-8 min-h-screen">
        <div class="w-full max-w-[210mm] bg-white shadow-xl p-8 md:p-12 rounded-none text-black border border-gray-300">
            {{-- Header --}}
            <div class="flex justify-between items-start mb-10 border-b border-black pb-6">
                <div>
                    {{-- Logo placeholder - based on company site, often a green swirl/circle with CITEC --}}
                    <img src="https://citecinternational.com/path-to-logo.png" alt="CITEC Logo" class="h-16 mb-2"> <!-- Replace with actual logo URL if available; otherwise use text -->
                    <h1 class="text-3xl font-bold">CITEC INTERNATIONAL SDN BHD</h1>
                    <div class="text-sm mt-1">
                        No. 1C (3rd Floor), Jalan Anggerik Vanilla X31/X,<br>
                        Kota Kemuning, Seksyen 31, 40460 Shah Alam,<br>
                        Selangor Darul Ehsan, Malaysia<br>
                        Tel: +603-51245668 / 67&nbsp;&nbsp; Fax: +603-51245669
                    </div>
    <div class="flex flex-col gap-6">
        {{-- Action Bar --}}
        <div class="flex justify-between items-center bg-white dark:bg-zinc-900 p-4 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-800">
            <div class="flex items-center gap-4">
                <span class="px-3 py-1 text-xs font-bold uppercase tracking-wider rounded-full bg-indigo-100 text-indigo-700 dark:bg-indigo-900/30 dark:text-indigo-400">
                    {{ $record->status }}
                </span>
                <h2 class="text-xl font-bold text-zinc-800 dark:text-zinc-200">
                    {{ $record->reference_number }}
                </h2>
            </div>
            <div class="flex gap-3">
                <flux:button href="{{ route('filament.dark-admin.resources.quotations.builder', ['record' => $record->id]) }}" icon="pencil-square" variant="subtle">Edit</flux:button>
                <flux:button href="#" icon="printer" variant="primary">Print PDF</flux:button>
            </div>
        </div>

        {{-- Document Preview --}}
        <div class="bg-zinc-100 dark:bg-zinc-950 p-8 md:p-12 rounded-2xl border border-zinc-200 dark:border-zinc-800 flex justify-center">
            <div class="bg-white dark:bg-zinc-900 w-full max-w-[850px] shadow-2xl rounded-sm p-12 text-zinc-900 dark:text-zinc-100 font-serif leading-relaxed min-h-[1100px]">
                
                {{-- Logo and Company Header --}}
                <div class="flex flex-col items-center text-center mb-10">
                    <div class="mb-4">
                        <div class="text-4xl font-black tracking-tighter text-indigo-600 dark:text-indigo-400 mb-1">CITEC</div>
                        <div class="h-1 w-24 bg-indigo-600 dark:bg-indigo-400 mx-auto"></div>
                    </div>
                    <div class="text-xl font-bold tracking-wide mb-1 uppercase">CITEC INTERNATIONAL SDN BHD</div>
                    <div class="text-xs text-zinc-500 max-w-[500px]">
                        NO. 1C (3RD FLOOR), JALAN ANGGERIK VANILLA X31/X, KOTA KEMUNING, SEKSYEN 31, 40460 SHAH ALAM, SELANGOR DARUL EHSAN. TEL: +603- 51245668/67, FAX: +603-51245669
                    </div>
                </div>

                <div class="w-full h-px bg-zinc-200 dark:bg-zinc-800 mb-6"></div>
                <div class="text-center text-2xl font-black underline underline-offset-8 decoration-2 uppercase mb-10">PROFORMA INVOICE</div>

                <div class="grid grid-cols-2 gap-12 mb-10 text-sm">
                    {{-- Customer Info --}}
                    <div>
                        <div class="font-black text-xs uppercase text-zinc-400 tracking-widest mb-2 italic">To:</div>
                        <div class="font-black text-lg mb-1">{{ $record->customer_name }}</div>
                        <div class="text-zinc-600 dark:text-zinc-400 mb-2">{{ $record->customer_email }}</div>
                        @if($record->customer_address)
                            <div class="whitespace-pre-line text-zinc-700 dark:text-zinc-300">{{ $record->customer_address }}</div>
                        @else
                            <div class="text-zinc-400 italic">No address provided</div>
                        @endif
                        
                        <div class="mt-4 space-y-1">
                            @if($record->attn) <div class="font-bold flex gap-2 uppercase text-xs"><span>Attn:</span> <span class="text-zinc-700 dark:text-zinc-300">{{ $record->attn }}</span></div> @endif
                            @if($record->customer_phone) <div class="font-bold flex gap-2 uppercase text-xs"><span>Tel:</span> <span class="text-zinc-700 dark:text-zinc-300">{{ $record->customer_phone }}</span></div> @endif
                            @if($record->customer_fax) <div class="font-bold flex gap-2 uppercase text-xs"><span>Fax:</span> <span class="text-zinc-700 dark:text-zinc-300">{{ $record->customer_fax }}</span></div> @endif
                        </div>
                    </div>

                    {{-- Invoice Metadata --}}
                    <div class="flex flex-col items-end">
                        <table class="w-full max-w-[300px] text-xs font-bold uppercase border-collapse">
                            <tr class="border-b border-zinc-100 dark:border-zinc-800">
                                <td class="py-2 text-zinc-400">Invoice No.:</td>
                                <td class="py-2 text-right">{{ $record->reference_number }}</td>
                            </tr>
                            <tr class="border-b border-zinc-100 dark:border-zinc-800">
                                <td class="py-2 text-zinc-400">Invoice Date:</td>
                                <td class="py-2 text-right">{{ $record->quotation_date?->format('d/m/Y') ?? $record->created_at->format('d/m/Y') }}</td>
                            </tr>
                            <tr class="border-b border-zinc-100 dark:border-zinc-800">
                                <td class="py-2 text-zinc-400">Customer PO No.:</td>
                                <td class="py-2 text-right">{{ $record->customer_po ?? 'N/A' }}</td>
                            </tr>
                            <tr class="border-b border-zinc-100 dark:border-zinc-800">
                                <td class="py-2 text-zinc-400">Payment Term:</td>
                                <td class="py-2 text-right">{{ $record->payment_term ?? 'TT Before Delivery' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>

                {{-- Items Table --}}
                <div class="mb-10">
                    <table class="w-full text-sm border-collapse">
                        <thead>
                            <tr class="border-t-2 border-b-2 border-zinc-900 dark:border-zinc-100 font-black uppercase text-xs tracking-tighter">
                                <th class="py-3 px-2 text-left w-12">Item</th>
                                <th class="py-3 px-2 text-left">Product Description</th>
                                <th class="py-3 px-2 text-center w-20">Quantity</th>
                                <th class="py-3 px-2 text-center w-16">UOM</th>
                                <th class="py-3 px-2 text-right w-32">Unit Price ({{ $record->currency }})</th>
                                <th class="py-3 px-2 text-right w-32">Amount ({{ $record->currency }})</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach($record->items as $index => $item)
                            <tr>
                                <td class="py-4 px-2 align-top text-center font-bold text-zinc-400">{{ $index + 1 }}</td>
                                <td class="py-4 px-2 align-top">
                                    <div class="font-black mb-1 uppercase tracking-tight">MODEL: {{ $item->product_name }}</div>
                                    <div class="text-[10px] text-zinc-500 leading-tight uppercase">
                                        {{ $item->incoterm }} PRICE / {{ $item->shipment_mode }} SHIPMENT
                                    </div>
                                </td>
                                <td class="py-4 px-2 align-top text-center font-black">{{ $item->quantity }}</td>
                                <td class="py-4 px-2 align-top text-center font-bold text-zinc-500 uppercase">{{ $item->uom }}</td>
                                <td class="py-4 px-2 align-top text-right font-bold">{{ number_format($item->final_unit_price, 2) }}</td>
                                <td class="py-4 px-2 align-top text-right font-black">{{ number_format($item->row_total, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr class="border-t-2 border-zinc-900 dark:border-zinc-100">
                                <td colspan="4" class="py-4"></td>
                                <td class="py-4 px-2 text-right font-black uppercase text-xs">Total ({{ $record->currency }})</td>
                                <td class="py-4 px-2 text-right font-black text-lg border-2 border-zinc-900 dark:border-zinc-100">{{ number_format($record->subtotal, 2) }}</td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- Total In Words --}}
                @php
                    $formatter = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
                    $totalInWords = strtoupper($formatter->format($record->subtotal));
                @endphp
                <div class="bg-zinc-50 dark:bg-zinc-800/30 p-4 border border-zinc-900 dark:border-zinc-100 mb-10 text-xs font-black uppercase leading-relaxed italic">
                    {{ $record->currency }}: {{ $totalInWords }} ONLY
                </div>

                {{-- Terms and BANK --}}
                <div class="grid grid-cols-2 gap-12 text-xs font-bold leading-relaxed">
                    <div>
                        <div class="font-black uppercase tracking-widest mb-2 underline decoration-zinc-400">Delivery term:</div>
                        <div class="mb-4 text-zinc-700 dark:text-zinc-300">
                            {{ strtoupper($record->pricing_tier) }} {{ $record->shipping_method == 'sea' ? 'SEA PORT' : 'AIRPORT' }}<br>
                            <span class="text-red-600 font-bold">* PLEASE INCLUDE INTERMEDIARY BANK CHARGE AND YOUR LOCAL BANK CHARGE</span>
                        </div>

                        <div class="font-black uppercase tracking-widest mb-2 underline decoration-zinc-400">Terms & conditions:</div>
                        <ol class="list-decimal list-inside text-zinc-700 dark:text-zinc-300">
                            <li>Please make a payment to CITEC INTERNATIONAL SDN BHD</li>
                        </ol>
                    </div>

                    <div class="flex flex-col gap-4">
                        <div class="bg-zinc-50 dark:bg-zinc-800 p-4 border border-zinc-200 dark:border-zinc-800">
                            <div class="font-black uppercase tracking-widest mb-2 italic">Bank details:</div>
                            <div class="space-y-1">
                                <div class="font-black text-zinc-900 dark:text-zinc-100 uppercase">CIMB Bank Berhad</div>
                                <div class="text-[10px] text-zinc-500 uppercase leading-none mb-2">22 A-0, Wisma Esther Robert, Lorong Batu Nilam 4B, Bandar Bukit Tinggi, 41200 Klang, Selangor, Malaysia</div>
                                <div class="font-black text-indigo-700 dark:text-indigo-400 bg-indigo-50 dark:bg-indigo-900/30 px-2 py-1 inline-block rounded">
                                    A/C No: 800004305840 (For Payment in {{ $record->currency }})
                                </div>
                            </div>
                        </div>

                        <div class="mt-8 text-center pt-12 border-t border-zinc-200 dark:border-zinc-800">
                            <div class="mb-2">For and on behalf of:</div>
                            <div class="font-black uppercase mb-12 italic">CITEC INTERNATIONAL SDN BHD</div>
                            <div class="w-48 h-px bg-zinc-900 dark:bg-zinc-100 mx-auto mb-2"></div>
                            <div class="text-[10px] uppercase font-bold tracking-widest text-zinc-400">Authorized Signature</div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</x-filament-panels::page>