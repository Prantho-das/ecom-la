<x-filament-panels::page>
    <!-- DESIGN VERSION 2.0 -->
    @vite(['resources/css/app.css'])
    <div class="flex flex-col gap-8">
        {{-- Action Bar --}}
        <div class="flex justify-between items-center bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md p-5 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-800 sticky top-0 z-10 mx-auto w-full max-w-[1000px]">
            <div class="flex items-center gap-5">
                <div class="flex flex-col">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full {{ $record->status === 'accepted' ? 'bg-green-500' : ($record->status === 'draft' ? 'bg-zinc-400' : 'bg-indigo-500') }} animate-pulse"></span>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-zinc-400">Quotation Status</span>
                    </div>
                    <h2 class="text-lg font-black text-zinc-800 dark:text-zinc-100 uppercase tracking-tight">
                        {{ $record->reference_number }}
                    </h2>
                </div>
            </div>
            <div class="flex gap-4">
                <flux:button href="{{ route('filament.dark-admin.resources.quotations.quotation-builder', ['record' => $record->id]) }}" icon="pencil-square" variant="subtle" class="px-6">Edit Quote</flux:button>
                <flux:button href="#" icon="printer" variant="primary" class="px-6 shadow-lg shadow-indigo-500/20">Print PDF</flux:button>
            </div>
        </div>

        {{-- Document Preview --}}
        <div class="bg-zinc-100 dark:bg-zinc-950 px-4 md:px-12 py-12 rounded-3xl border border-zinc-200 dark:border-zinc-800 flex justify-center min-h-[1400px]">
            <article class="bg-white dark:bg-zinc-900 w-full max-w-[850px] shadow-[0_30px_60px_-15px_rgba(0,0,0,0.1)] dark:shadow-none rounded-none p-16 text-zinc-900 dark:text-zinc-100 font-sans leading-normal relative">
                
                {{-- Logo and Company Header --}}
                <header class="flex flex-col items-center text-center mb-12 border-b-2 border-zinc-100 dark:border-zinc-800 pb-12">
                    <div class="mb-6">
                        <div class="text-[52px] font-black tracking-[-0.05em] text-indigo-600 dark:text-indigo-400 flex items-center gap-1 leading-none">
                            CITEC
                            <span class="text-zinc-900 dark:text-zinc-100 w-2 h-2 bg-indigo-600 dark:bg-indigo-400 rounded-full self-end mb-2"></span>
                        </div>
                        <div class="h-1.5 w-full bg-indigo-600 dark:bg-indigo-400 mt-[-4px]"></div>
                    </div>
                    <div class="text-2xl font-black tracking-widest mb-3 uppercase">CITEC INTERNATIONAL SDN BHD</div>
                    <div class="text-[10px] text-zinc-400 font-bold uppercase tracking-wider max-w-[550px] leading-relaxed">
                        NO. 1C (3RD FLOOR), JALAN ANGGERIK VANILLA X31/X, KOTA KEMUNING, SEKSYEN 31, 40460 SHAH ALAM, SELANGOR DARUL EHSAN. <br>
                        TEL: +603- 51245668/67, FAX: +603-51245669
                    </div>
                </header>

                <div class="text-center">
                    <h1 class="text-3xl font-black uppercase tracking-[0.1em] underline underline-offset-[16px] decoration-[3px] decoration-zinc-900 dark:decoration-zinc-100 mb-16">PROFORMA INVOICE</h1>
                </div>

                <div class="grid grid-cols-2 gap-16 mb-16">
                <div class="grid grid-cols-2 gap-16 mb-16">
                    {{-- General Info Section --}}
                    <section>
                        <h2 class="font-black text-[11px] uppercase text-indigo-600 dark:text-indigo-400 tracking-[0.2em] mb-4 flex items-center gap-2">
                             Quotation Information
                        </h2>
                        <div class="space-y-4">
                            <div class="flex items-center gap-3">
                                <span class="text-[10px] font-black text-zinc-400 border border-zinc-200 dark:border-zinc-700 px-1.5 py-0.5 rounded uppercase">Reference</span>
                                <span class="text-sm font-black text-zinc-800 dark:text-zinc-100 uppercase">{{ $record->reference_number }}</span>
                            </div>
                            <div class="flex items-center gap-3">
                                <span class="text-[10px] font-black text-zinc-400 border border-zinc-200 dark:border-zinc-700 px-1.5 py-0.5 rounded uppercase">Date</span>
                                <span class="text-sm font-black text-zinc-800 dark:text-zinc-100 uppercase">{{ $record->quotation_date?->format('d M Y') ?? $record->created_at->format('d M Y') }}</span>
                            </div>
                        </div>
                    </section>
                </div>
                </div>

                {{-- Product Table Section --}}
                <div class="mb-16">
                    <table class="w-full border-collapse">
                        <thead>
                            <tr class="border-y-[3px] border-zinc-900 dark:border-zinc-100 font-black uppercase text-[10px] tracking-widest">
                                <th class="py-4 px-2 text-left w-12 text-zinc-400">#</th>
                                <th class="py-4 px-4 text-left">Description</th>
                                <th class="py-4 px-4 text-center w-24">QTY</th>
                                <th class="py-4 px-4 text-center w-20">UOM</th>
                                <th class="py-4 px-4 text-right w-44">Price</th>
                                <th class="py-4 px-2 text-right w-48">Amount</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-zinc-100 dark:divide-zinc-800">
                            @foreach($record->items as $index => $item)
                            <tr class="group">
                                <td class="py-6 px-2 align-top text-center font-black text-zinc-300 text-xs">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</td>
                                <td class="py-6 px-4 align-top">
                                    <div class="font-black text-sm uppercase tracking-tight mb-2 group-hover:text-indigo-600 transition-colors">MODEL: {{ $item->product_name }}</div>
                                    <div class="flex items-center gap-3">
                                        <span class="px-1.5 py-0.5 bg-zinc-100 dark:bg-zinc-800 text-[9px] font-black rounded uppercase tracking-tighter text-zinc-500">{{ $item->incoterm }}</span>
                                        <span class="text-[9px] font-bold text-zinc-400 uppercase tracking-widest border-l border-zinc-200 dark:border-zinc-700 pl-3">{{ $item->shipment_mode }} FREIGHT</span>
                                    </div>
                                </td>
                                <td class="py-6 px-4 align-top text-center font-black text-base">{{ $item->quantity }}</td>
                                <td class="py-6 px-4 align-top text-center font-black text-zinc-400 uppercase text-xs pt-[26px]">{{ $item->uom }}</td>
                                <td class="py-6 px-4 align-top text-right font-bold text-sm pt-[24px]">
                                    <span class="text-[10px] text-zinc-400 mr-1">{{ $item->currency }}</span>{{ number_format($item->final_unit_price, 2) }}
                                </td>
                                <td class="py-6 px-2 align-top text-right font-black text-base tracking-tighter pt-[24px]">
                                    <span class="text-xs text-zinc-400 mr-1">{{ $item->currency }}</span>{{ number_format($item->row_total, 2) }}
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            @php
                                $currencySubtotals = $record->items->groupBy('currency')->map(fn($items) => $items->sum('row_total'));
                                $discountPercentage = (float) $record->discount_percentage;
                            @endphp
                            
                            @foreach($currencySubtotals as $curr => $subtotal)
                                @php
                                    $discountAmt = $subtotal * ($discountPercentage / 100);
                                    $grandTotal = $subtotal - $discountAmt;
                                @endphp
                                
                                {{-- Subtotal Row --}}
                                <tr>
                                    <td colspan="4" class="py-2"></td>
                                    <td class="py-2 px-4 text-right font-black uppercase text-[9px] text-zinc-400 tracking-widest">{{ $curr }} Subtotal</td>
                                    <td class="py-2 px-2 text-right font-bold text-sm text-zinc-600 dark:text-zinc-400 leading-none">
                                        <span class="text-[10px] align-top mr-1">{{ $curr }}</span>{{ number_format($subtotal, 2) }}
                                    </td>
                                </tr>

                                {{-- Discount Row (Optional) --}}
                                @if($discountPercentage > 0)
                                <tr>
                                    <td colspan="4" class="py-1"></td>
                                    <td class="py-1 px-4 text-right font-bold uppercase text-[9px] text-red-400 tracking-widest">Discount ({{ $discountPercentage }}%)</td>
                                    <td class="py-1 px-2 text-right font-bold text-sm text-red-500 leading-none">
                                        - <span class="text-[10px] align-top mr-1">{{ $curr }}</span>{{ number_format($discountAmt, 2) }}
                                    </td>
                                </tr>
                                @endif

                                {{-- Currency Grand Total Row --}}
                                <tr>
                                    <td colspan="4" class="py-2"></td>
                                    <td class="py-2 px-4 text-right font-black uppercase text-[10px] text-indigo-600 dark:text-indigo-400 tracking-widest">{{ $curr }} Grand Total</td>
                                    <td class="py-2 px-2 text-right font-black text-xl border-b-2 border-zinc-100 dark:border-zinc-800 leading-none">
                                        <span class="text-xs font-bold align-top mr-1">{{ $curr }}</span>{{ number_format($grandTotal, 2) }}
                                    </td>
                                </tr>
                                
                                {{-- Spacer for next currency --}}
                                <tr><td colspan="6" class="py-2"></td></tr>
                            @endforeach

                            {{-- Final Combined Total --}}
                            <tr class="bg-zinc-50/50 dark:bg-zinc-800/30">
                                <td colspan="4" class="py-6 rounded-l-xl"></td>
                                <td class="py-6 px-4 text-right font-black uppercase text-[11px] text-indigo-600 dark:text-indigo-400 tracking-[0.2em]">Combined (BDT)</td>
                                <td class="py-6 px-2 text-right font-black text-3xl border-b-[4px] border-double border-zinc-900 dark:border-zinc-100 leading-none rounded-r-xl">
                                    <span class="text-sm font-bold align-top mr-1">৳</span>{{ number_format($record->grand_total, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- Amount In Words Section --}}
                @php
                    $formatter = new \NumberFormatter('en', \NumberFormatter::SPELLOUT);
                    $totalInWords = strtoupper($formatter->format($record->subtotal));
                @endphp
                <div class="relative mb-16">
                    <div class="absolute -top-3 left-6 bg-white dark:bg-zinc-900 px-3 text-[9px] font-black uppercase tracking-[0.3em] text-indigo-500">Amount in Words (Combined BDT)</div>
                    <div class="bg-indigo-50/50 dark:bg-indigo-500/5 p-8 rounded-xl border-2 border-indigo-100 dark:border-indigo-900/30 text-sm font-black uppercase leading-relaxed tracking-tight text-indigo-900 dark:text-indigo-400 italic">
                         BDT {{ $totalInWords }} ONLY
                    </div>
                </div>

                {{-- Legal and Bank Info Section --}}
                <div class="grid grid-cols-2 gap-16 text-[11px] leading-relaxed mb-16">
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <span class="w-8 h-px bg-zinc-400"></span>
                            <h3 class="font-black uppercase tracking-widest">Fulfillment Terms</h3>
                        </div>
                        <div class="mb-6 space-y-4">
                            <div class="flex flex-col gap-1">
                                <span class="text-zinc-400 uppercase text-[9px] font-black">Shipment Policy</span>
                                <span class="font-black uppercase">BY {{ $record->shipping_method == 'sea' ? 'SEA PORT' : 'AIR PORT' }} ({{ strtoupper($record->pricing_tier) }})</span>
                            </div>
                            <div class="p-3 bg-red-50 dark:bg-red-950/20 border-l-4 border-red-500 text-red-700 dark:text-red-400 font-bold uppercase text-[10px]">
                                * PLEASE INCLUDE INTERMEDIARY BANK CHARGE AND YOUR LOCAL BANK CHARGE
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mb-4">
                            <span class="w-8 h-px bg-zinc-400"></span>
                            <h3 class="font-black uppercase tracking-widest">Terms & Conditions</h3>
                        </div>
                        <ol class="list-decimal list-inside font-bold text-zinc-600 dark:text-zinc-400 space-y-1">
                            <li class="uppercase">All payments should be directed to the account provided below</li>
                            <li class="uppercase">Quote is valid for 30 days unless specified otherwise</li>
                        </ol>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 p-6 rounded-xl text-zinc-900 dark:text-zinc-100 shadow-sm border border-zinc-100 dark:border-zinc-800">
                            <h3 class="font-black uppercase tracking-[0.2em] mb-4 text-[9px] text-zinc-400">Settlement Account</h3>
                            <div class="space-y-4">
                                <div>
                                    <div class="font-black text-sm uppercase mb-1 tracking-tight text-indigo-600 dark:text-indigo-400">CIMB Bank Berhad</div>
                                    <div class="text-[9px] text-zinc-500 uppercase leading-snug">Wisma Esther Robert, Lorong Batu Nilam 4B, Bandar Bukit Tinggi, 41200 Klang, Selangor</div>
                                </div>
                                <div class="pt-4 border-t border-zinc-200 dark:border-zinc-700">
                                    <div class="text-[8px] uppercase font-black mb-1 text-zinc-400">Account Number</div>
                                    <div class="font-black text-2xl tracking-tighter text-zinc-900 dark:text-zinc-100">800004305840</div>
                                    <div class="text-[9px] font-bold mt-1 text-zinc-500 tracking-tight">SWIFT: CIMBBMYKL (for international transfers)</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Signatures Section --}}
                <footer class="mt-24">
                     <div class="flex justify-end">
                        <div class="w-full max-w-[280px] text-center">
                            <div class="text-xs font-bold mb-4">For and on behalf of:</div>
                            <div class="font-black uppercase text-sm mb-20 tracking-wide underline decoration-indigo-600 underline-offset-4 decoration-2">CITEC INTERNATIONAL SDN BHD</div>
                            <div class="w-full h-0.5 bg-zinc-900 dark:bg-zinc-100 mb-2"></div>
                            <div class="text-[9px] uppercase font-black tracking-[0.3em] text-zinc-400">Authorized Signature</div>
                        </div>
                     </div>
                </footer>

                {{-- Footer Page Mark --}}
                <div class="absolute bottom-6 right-16 text-[9px] font-black text-zinc-300 uppercase tracking-widest">
                    Page 01 // 01
                </div>

            </article>
        </div>
    </div>
</x-filament-panels::page>