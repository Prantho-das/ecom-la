<x-filament-panels::page>
    {{-- Custom styling for the invoice view --}}
    @vite(['resources/css/app.css'])
    
    <div class="flex flex-col gap-8">
        {{-- Action Bar --}}
        <div class="flex justify-between items-center bg-white/80 dark:bg-zinc-900/80 backdrop-blur-md p-5 rounded-2xl shadow-sm border border-zinc-200 dark:border-zinc-800 sticky top-0 z-10 mx-auto w-full max-w-[1000px]">
            <div class="flex items-center gap-5">
                <div class="flex flex-col">
                    <div class="flex items-center gap-2">
                        <span class="w-2 h-2 rounded-full {{ $record->status === 'paid' ? 'bg-green-500' : 'bg-indigo-500' }} animate-pulse"></span>
                        <span class="text-[10px] font-black uppercase tracking-[0.2em] text-zinc-400">Invoice Status</span>
                    </div>
                    <h2 class="text-lg font-black text-zinc-800 dark:text-zinc-100 uppercase tracking-tight">
                        {{ $record->reference_number }}
                    </h2>
                </div>
            </div>
            <div class="flex gap-4">
                <flux:button href="{{ \App\Filament\DarkAdmin\Resources\Invoices\InvoiceResource::getUrl('edit', ['record' => $record->id]) }}" icon="pencil-square" variant="subtle" class="px-6">Edit Invoice</flux:button>
                <flux:button href="#" icon="printer" variant="primary" class="px-6 shadow-lg shadow-indigo-500/20">Print PDF</flux:button>
            </div>
        </div>

        {{-- Invoice Document Preview --}}
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
                    <h1 class="text-3xl font-black uppercase tracking-[0.1em] underline underline-offset-[16px] decoration-[3px] decoration-zinc-900 dark:decoration-zinc-100 mb-16">TAX INVOICE</h1>
                </div>

                <div class="grid grid-cols-2 gap-16 mb-16">
                    {{-- Customer Details --}}
                    <section>
                        <h2 class="font-black text-[11px] uppercase text-indigo-600 dark:text-indigo-400 tracking-[0.2em] mb-4 flex items-center gap-2">
                             Customer Details
                        </h2>
                        <div class="space-y-1">
                            <div class="font-black text-xl tracking-tight mb-2">{{ $record->customer_name }}</div>
                            @if($record->business_name)
                                <div class="text-xs font-bold text-zinc-500 mb-2 uppercase">{{ $record->business_name }}</div>
                            @endif
                            <div class="text-xs font-bold text-zinc-500 mb-4">{{ $record->email }}</div>
                            
                            @if($record->office_address)
                                <div class="text-sm border-l-4 border-indigo-100 dark:border-indigo-900/30 pl-4 whitespace-pre-line text-zinc-600 dark:text-zinc-400 leading-relaxed max-w-[320px]">{{ $record->office_address }}</div>
                            @endif
                        </div>
                        
                        <div class="mt-8 grid grid-cols-1 gap-3">
                            @if($record->contact_person) 
                                <div class="flex items-center gap-3">
                                    <span class="text-[10px] font-black text-zinc-400 border border-zinc-200 dark:border-zinc-700 px-1.5 py-0.5 rounded uppercase">Attn</span>
                                    <span class="text-xs font-black text-zinc-800 dark:text-zinc-100 uppercase tracking-tighter">{{ $record->contact_person }}</span>
                                </div> 
                            @endif
                            @if($record->phone_number) 
                                <div class="flex items-center gap-3 border-l-2 border-indigo-100 dark:border-indigo-900/30 pl-3">
                                    <span class="text-[10px] font-black text-zinc-400 uppercase">Tel</span>
                                    <span class="text-xs font-bold text-zinc-700 dark:text-zinc-300">{{ $record->phone_number }}</span>
                                </div> 
                            @endif
                        </div>
                    </section>

                    {{-- Invoice Metadata --}}
                    <aside class="flex flex-col items-end">
                        <div class="w-full max-w-[280px] bg-zinc-50 dark:bg-zinc-800/30 p-6 border border-zinc-100 dark:border-zinc-800 rounded-lg">
                            <table class="w-full text-xs font-bold border-separate border-spacing-y-4">
                                <tr>
                                    <td class="text-zinc-400 uppercase tracking-widest text-[9px]">Invoice No.</td>
                                    <td class="text-right font-black tracking-tight">{{ $record->reference_number }}</td>
                                </tr>
                                <tr>
                                    <td class="text-zinc-400 uppercase tracking-widest text-[9px]">Date</td>
                                    <td class="text-right">{{ $record->invoice_date?->format('d M Y') }}</td>
                                </tr>
                                @if($record->quotation_date)
                                <tr>
                                    <td class="text-zinc-400 uppercase tracking-widest text-[9px]">Quote Date</td>
                                    <td class="text-right">{{ $record->quotation_date?->format('d M Y') }}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td class="text-zinc-400 uppercase tracking-widest text-[9px]">PO Ref.</td>
                                    <td class="text-right text-indigo-600 dark:text-indigo-400">{{ $record->customer_po_ref ?? '—' }}</td>
                                </tr>
                                <tr>
                                    <td class="text-zinc-400 uppercase tracking-widest text-[9px]">Payment Term</td>
                                    <td class="text-right whitespace-nowrap uppercase">{{ $record->payment_term ?? 'TT BEFORE DELIVERY' }}</td>
                                </tr>
                            </table>
                        </div>
                    </aside>
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
                                    <div class="font-black text-sm uppercase tracking-tight mb-2 group-hover:text-indigo-600 transition-colors">{{ $item->product_name }}</div>
                                    <div class="flex items-center gap-3">
                                        @if($item->incoterm)
                                            <span class="px-1.5 py-0.5 bg-zinc-100 dark:bg-zinc-800 text-[9px] font-black rounded uppercase tracking-tighter text-zinc-500">{{ $item->incoterm }}</span>
                                        @endif
                                        @if($item->port)
                                            <span class="text-[9px] font-bold text-zinc-400 uppercase tracking-widest border-l border-zinc-200 dark:border-zinc-700 pl-3">Port: {{ $item->port }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-6 px-4 align-top text-center font-black text-base">{{ $item->quantity }}</td>
                                <td class="py-6 px-4 align-top text-center font-black text-zinc-400 uppercase text-xs pt-[26px]">{{ $item->uom }}</td>
                                <td class="py-6 px-4 align-top text-right font-bold text-sm pt-[24px]">
                                    <span class="text-[10px] text-zinc-400 mr-1">{{ $item->currency }}</span>{{ number_format($item->unit_price, 2) }}
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
                            @endphp
                            
                            @foreach($currencySubtotals as $curr => $subtotal)
                                {{-- Currency Summary Row --}}
                                <tr>
                                    <td colspan="4" class="py-2"></td>
                                    <td class="py-2 px-4 text-right font-black uppercase text-[10px] text-zinc-400 tracking-widest">{{ $curr }} Total</td>
                                    <td class="py-2 px-2 text-right font-black text-xl border-b-2 border-zinc-100 dark:border-zinc-800 leading-none">
                                        <span class="text-xs font-bold align-top mr-1">{{ $curr }}</span>{{ number_format($subtotal, 2) }}
                                    </td>
                                </tr>
                                <tr><td colspan="6" class="py-2"></td></tr>
                            @endforeach

                            @if($record->cost_factor > 0)
                                <tr>
                                    <td colspan="4" class="py-2"></td>
                                    <td class="py-2 px-4 text-right font-black uppercase text-[10px] text-zinc-400 tracking-widest">Cost Factor</td>
                                    <td class="py-2 px-2 text-right font-black text-xl border-b-2 border-zinc-100 dark:border-zinc-800 leading-none">
                                        {{ number_format($record->cost_factor, 2) }}
                                    </td>
                                </tr>
                                <tr><td colspan="6" class="py-2"></td></tr>
                            @endif

                            @if($record->global_discount > 0)
                                <tr>
                                    <td colspan="4" class="py-2"></td>
                                    <td class="py-2 px-4 text-right font-black uppercase text-[10px] text-zinc-400 tracking-widest">Global Discount</td>
                                    <td class="py-2 px-2 text-right font-black text-xl border-b-2 border-zinc-100 dark:border-zinc-800 leading-none text-red-600 dark:text-red-400">
                                        -{{ number_format($record->global_discount, 2) }}
                                    </td>
                                </tr>
                                <tr><td colspan="6" class="py-2"></td></tr>
                            @endif

                            {{-- Grand Total Section (If multiple items are in BDT or single currency sum) --}}
                            <tr class="bg-zinc-50/50 dark:bg-zinc-800/30" style="display: none;">
                                <td colspan="4" class="py-8 rounded-l-xl"></td>
                                <td class="py-8 px-4 text-right font-black uppercase text-[12px] text-indigo-600 dark:text-indigo-400 tracking-[0.2em]">Grand Total</td>
                                <td class="py-8 px-2 text-right font-black text-4xl border-b-[4px] border-double border-zinc-900 dark:border-zinc-100 leading-none rounded-r-xl">
                                    {{ number_format($record->grand_total, 2) }}
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

                {{-- Bank Info Section --}}
                <div class="grid grid-cols-2 gap-16 text-[11px] leading-relaxed mb-16">
                    <div>
                        <div class="flex items-center gap-3 mb-4">
                            <span class="w-8 h-px bg-zinc-400"></span>
                            <h3 class="font-black uppercase tracking-widest">Terms & Conditions</h3>
                        </div>
                        <ol class="list-decimal list-inside font-bold text-zinc-600 dark:text-zinc-400 space-y-1 uppercase">
                            <li>All payments should be directed to the account provided</li>
                            <li>Late payment charges may apply after due date</li>
                            <li>Goods sold are not returnable/exchangeable</li>
                        </ol>
                    </div>

                    <div class="space-y-6">
                        <div class="bg-zinc-50 dark:bg-zinc-800/50 p-6 rounded-xl text-zinc-900 dark:text-zinc-100 shadow-sm border border-zinc-100 dark:border-zinc-800">
                            <h3 class="font-black uppercase tracking-[0.2em] mb-4 text-[9px] text-zinc-400">Settlement Account</h3>
                            <div class="space-y-4">
                                <div>
                                    <div class="font-black text-sm uppercase mb-1 tracking-tight text-indigo-600 dark:text-indigo-400">CIMB Bank Berhad</div>
                                    <div class="text-[9px] text-zinc-500 uppercase leading-snug">Wisma Esther Robert, Bandar Bukit Tinggi, Klang, Selangor</div>
                                </div>
                                <div class="pt-4 border-t border-zinc-200 dark:border-zinc-700">
                                    <div class="text-[8px] uppercase font-black mb-1 text-zinc-400">Account Number</div>
                                    <div class="font-black text-2xl tracking-tighter text-zinc-900 dark:text-zinc-100">800004305840</div>
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
                    Generated via Citec Admin Portal
                </div>

            </article>
        </div>

        {{-- Edit Log History --}}
        @if($record->editLogs->count() > 0)
            <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-3xl p-8 max-w-[850px] mx-auto w-full shadow-sm">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-8 h-8 rounded-lg bg-indigo-600 flex items-center justify-center text-white shadow-md">
                        <flux:icon icon="clock" class="w-4 h-4" />
                    </div>
                    <div>
                        <h3 class="text-sm font-black uppercase tracking-widest text-zinc-900 dark:text-zinc-100">Edit Log History</h3>
                        <p class="text-[9px] font-bold text-zinc-400 uppercase">Changes made to cost factor and global discount</p>
                    </div>
                </div>
                <div class="divide-y divide-zinc-100 dark:divide-zinc-800">
                    @foreach($record->editLogs()->with('user')->latest()->get() as $log)
                        <div class="py-4 flex justify-between items-center text-xs">
                            <div class="space-y-1">
                                <div class="font-bold text-zinc-800 dark:text-zinc-200">
                                    {{ $log->user?->name ?? 'System User' }}
                                </div>
                                <div class="text-zinc-500">
                                    @if(isset($log->changed_to['cost_factor']) && isset($log->changed_from['cost_factor']) && $log->changed_to['cost_factor'] != $log->changed_from['cost_factor'])
                                        <div>Cost Factor: <span class="font-mono line-through text-zinc-400">{{ number_format($log->changed_from['cost_factor'], 2) }}</span> &rarr; <span class="font-mono text-emerald-600 dark:text-emerald-400 font-bold">{{ number_format($log->changed_to['cost_factor'], 2) }}</span></div>
                                    @endif
                                    @if(isset($log->changed_to['global_discount']) && isset($log->changed_from['global_discount']) && $log->changed_to['global_discount'] != $log->changed_from['global_discount'])
                                        <div>Global Discount: <span class="font-mono line-through text-zinc-400">{{ number_format($log->changed_from['global_discount'], 2) }}</span> &rarr; <span class="font-mono text-red-600 dark:text-red-400 font-bold">{{ number_format($log->changed_to['global_discount'], 2) }}</span></div>
                                    @endif
                                </div>
                            </div>
                            <div class="text-[10px] text-zinc-400 font-mono">
                                {{ $log->created_at->format('d M Y h:i A') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>
