<x-filament-panels::page>
    <x-slot name="heading">
        {{ $heading ?? 'Generate Invoice' }}
    </x-slot>

    <div class="space-y-8">
        {{-- Header Section --}}
        <div class="bg-white dark:bg-zinc-900 border border-zinc-200 dark:border-zinc-800 rounded-2xl shadow-sm overflow-hidden">
            <div class="p-6 border-b border-zinc-200 dark:border-zinc-800/50 flex justify-between items-center bg-zinc-50 dark:bg-zinc-800/40">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-emerald-600 flex items-center justify-center text-white shadow-lg shadow-emerald-600/20">
                        <flux:icon icon="document-text" class="w-5 h-5" />
                    </div>
                    <div>
                        <h3 class="text-sm font-black uppercase tracking-widest text-zinc-900 dark:text-zinc-100">Invoice Details</h3>
                        <p class="text-[10px] font-bold text-zinc-400 uppercase">Customer and reference information</p>
                    </div>
                </div>
                <div class="flex gap-3">
                    <flux:button wire:click="addTable" icon="plus" variant="subtle" size="sm" class="font-black uppercase text-[10px] tracking-widest">Add Product</flux:button>
                    <flux:button wire:click="save" variant="primary" icon="check" size="sm" wire:loading.attr="disabled" class="font-black uppercase text-[10px] tracking-widest shadow-lg shadow-emerald-600/20">
                        <span wire:loading.remove wire:target="save">Generate Invoice</span>
                        <span wire:loading wire:target="save">Processing...</span>
                    </flux:button>
                </div>
            </div>

            <div class="p-8">
                <div class="grid grid-cols-1 md:grid-cols-4 gap-8">
                    {{-- Basic Info --}}
                    <div class="md:col-span-1 space-y-6">
                        <flux:field>
                            <flux:label>Customer Name <span class="text-red-500">*</span></flux:label>
                            <flux:input wire:model="customer_name" placeholder="Full Name" />
                            @error('customer_name') <span class="text-red-500 text-[10px] font-bold">{{ $message }}</span> @enderror
                        </flux:field>
                        <flux:field>
                            <flux:label>Business or Name</flux:label>
                            <flux:input wire:model="business_name" placeholder="Company Name" />
                        </flux:field>
                        <flux:field>
                            <flux:label>Email Address</flux:label>
                            <flux:input type="email" wire:model="email" placeholder="email@example.com" />
                        </flux:field>
                    </div>

                    {{-- Dates & References --}}
                    <div class="md:col-span-1 space-y-6">
                        <flux:field>
                            <flux:label>Invoice Date <span class="text-red-500">*</span></flux:label>
                            <flux:input type="date" wire:model="invoice_date" />
                        </flux:field>
                        <flux:field>
                            <flux:label>Quotation Date</flux:label>
                            <flux:input type="date" wire:model="quotation_date" />
                        </flux:field>
                        <flux:field>
                            <flux:label>Customer PO Ref</flux:label>
                            <flux:input wire:model="customer_po_ref" placeholder="PO-12345" />
                        </flux:field>
                    </div>

                    {{-- Contact --}}
                    <div class="md:col-span-1 space-y-6">
                        <flux:field>
                            <flux:label>Contact Person (Attn)</flux:label>
                            <flux:input wire:model="contact_person" placeholder="Name" />
                        </flux:field>
                        <flux:field>
                            <flux:label>Phone Number</flux:label>
                            <flux:input wire:model="phone_number" placeholder="+00 000 0000" />
                        </flux:field>
                        <flux:field>
                            <flux:label>Fax Number</flux:label>
                            <flux:input wire:model="fax_number" placeholder="+00 000 0000" />
                        </flux:field>
                    </div>

                    {{-- Other & Address --}}
                    <div class="md:col-span-1 space-y-6">
                        <flux:field>
                            <flux:label>Payment Term</flux:label>
                            <flux:input wire:model="payment_term" placeholder="TT Before Delivery" />
                        </flux:field>
                        <flux:field>
                            <flux:label>Cost Factor</flux:label>
                            <flux:input type="number" step="0.01" wire:model="cost_factor" placeholder="0.00" readonly disabled />
                        </flux:field>
                        <flux:field>
                            <flux:label>Global Discount</flux:label>
                            <flux:input type="number" step="0.01" wire:model="global_discount" placeholder="0.00" />
                        </flux:field>
                        <flux:field>
                            <flux:label>Office Address</flux:label>
                            <flux:textarea wire:model="office_address" placeholder="Address..." rows="4" />
                        </flux:field>
                    </div>
                </div>
            </div>
        </div>



        {{-- Products Section --}}
        <div class="space-y-4">
            <div class="flex items-center gap-3 px-2">
                <flux:icon icon="shopping-cart" class="w-5 h-5 text-zinc-400" />
                <h3 class="text-xs font-black uppercase tracking-widest text-zinc-500">Items List</h3>
            </div>

            <div class="bg-white dark:bg-zinc-900 rounded-xl shadow-sm border border-zinc-200 dark:border-zinc-800 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-zinc-50 dark:bg-zinc-800/30 border-b border-zinc-200 dark:border-zinc-800">
                            <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-zinc-500">Product Selection</th>
                            <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-zinc-500">Port (Incoterm)</th>
                            <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-zinc-500">Currency</th>
                            <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-zinc-500 w-32 text-right">Quantity</th>
                            <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-zinc-500 w-48 text-right">Unit Price</th>
                            <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-zinc-500 w-48 text-right">Row Total</th>
                            <th class="px-6 py-4 text-xs font-black uppercase tracking-widest text-zinc-500 w-20"></th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-zinc-200 dark:divide-zinc-800">
                        @foreach($tables as $idx => $table)
                            <tr wire:key="item-{{ $table['id'] }}" class="group hover:bg-zinc-50 dark:hover:bg-zinc-800/20 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex flex-col gap-1">
                                        <flux:select wire:model.live="tables.{{ $idx }}.product_id" placeholder="Select a product...">
                                            @foreach($products as $product)
                                                <flux:select.option value="{{ $product->id }}">{{ $product->name }}</flux:select.option>
                                            @endforeach
                                        </flux:select>
                                        @if($table['name'])
                                            <span class="text-[10px] text-zinc-400 font-bold uppercase pl-1">{{ $table['name'] }}</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <flux:select wire:model.live="tables.{{ $idx }}.incoterm" placeholder="Incoterm...">
                                        @if(!empty($table['available_incoterms']))
                                            <flux:select.option value="">Choice Incoterm</flux:select.option>
                                            @foreach($table['available_incoterms'] as $code)
                                                <flux:select.option value="{{ $code }}">{{ $code }}</flux:select.option>
                                            @endforeach
                                        @else
                                            @foreach(\App\Models\Incoterm::all() as $i)
                                                <flux:select.option value="{{ $i->code }}">{{ $i->code }}</flux:select.option>
                                            @endforeach
                                        @endif
                                    </flux:select>
                                </td>
                                <td class="px-6 py-4">
                                    <flux:select wire:model.live="tables.{{ $idx }}.currency" placeholder="Currency...">
                                        @if(!empty($table['available_currencies']))
                                            <flux:select.option value="">Choice Currency</flux:select.option>
                                            @foreach($table['available_currencies'] as $symbol)
                                                <flux:select.option value="{{ $symbol }}">{{ $symbol }}</flux:select.option>
                                            @endforeach
                                        @else
                                            @foreach(\App\Models\Currency::where('is_active', true)->get() as $c)
                                                <flux:select.option value="{{ $c->code }}">{{ $c->code }}</flux:select.option>
                                            @endforeach
                                        @endif
                                    </flux:select>
                                </td>
                                <td class="px-6 py-4">
                                    <flux:input type="number" step="0.01" wire:model.live="tables.{{ $idx }}.quantity" class="text-right" />
                                </td>
                                <td class="px-6 py-4">
                                    <flux:input type="number" step="0.01" wire:model.live="tables.{{ $idx }}.unit_price" class="text-right font-bold text-emerald-600 dark:text-emerald-400" />
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="text-sm font-black text-zinc-900 dark:text-zinc-100">
                                        {{ number_format(((float)($table['quantity'] ?? 0)) * ((float)($table['unit_price'] ?? 0)), 2) }}
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <flux:button wire:click="removeTable('{{ $table['id'] }}')" variant="ghost" color="red" icon="trash" size="sm" />
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="p-6 bg-zinc-50 dark:bg-zinc-800/40 flex justify-between items-center border-t border-zinc-200 dark:border-zinc-800">
                    <flux:button wire:click="addTable" icon="plus" variant="subtle" size="sm" class="font-black uppercase text-[10px] tracking-widest">Add Another Item</flux:button>
                    
                    <div class="text-right" style="display: none;">
                        <span class="text-[10px] font-black uppercase text-zinc-400 tracking-widest block">Grand Total</span>
                        <div class="text-3xl font-black text-emerald-600 dark:text-emerald-400">
                            {{ number_format(collect($tables)->sum(fn($t) => ((float)($t['quantity'] ?? 0)) * ((float)($t['unit_price'] ?? 0))), 2) }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>
