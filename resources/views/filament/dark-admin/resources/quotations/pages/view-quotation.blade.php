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
                </div>
                <div class="text-right">
                    <h2 class="text-2xl font-bold uppercase">PROFORMA INVOICE</h2>
                    <div class="mt-4 space-y-1 text-sm">
                        <div><strong>Invoice No.:</strong> P125-0011</div>
                        <div><strong>Invoice Date:</strong> 21/11/2025</div>
                        <div><strong>Customer PO No.:</strong> TVSLFP2511042R</div>
                        <div><strong>Payment Term:</strong> TT Before Delivery</div>
                        <div><strong>Page:</strong> 1/1</div>
                    </div>
                </div>
            </div>

            {{-- Recipient --}}
            <div class="mb-10">
                <strong>To:</strong><br>
                TECH VALLEY SOLUTIONS LTD.<br>
                139, LAKE CIRCUS, KALABAGAN,<br>
                DHAKA - 1205<br><br>
                <strong>Attn:</strong> Mr. Amran<br>
                <strong>Tel:</strong> +88 02 8116 124<br>
                <strong>Fax:</strong> +88 02 9121 230
            </div>

            {{-- Items Table --}}
            <table class="w-full text-left border-collapse mb-10">
                <thead>
                    <tr class="border-b-2 border-black">
                        <th class="py-2 pr-4 text-left">Item</th>
                        <th class="py-2 px-4 text-left">Product Description</th>
                        <th class="py-2 px-4 text-center">Quantity</th>
                        <th class="py-2 px-4 text-center">Uom</th>
                        <th class="py-2 px-4 text-right">Unit Price (USD)</th>
                        <th class="py-2 pl-4 text-right">Amount (USD)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-400">
                    <tr>
                        <td class="py-3 pr-4 font-bold">1</td>
                        <td class="py-3 px-4">
                            MODEL: EVD1035A (400V/3PH+N/50HZ)
                        </td>
                        <td class="py-3 px-4 text-center">5</td>
                        <td class="py-3 px-4 text-center">UNIT</td>
                        <td class="py-3 px-4 text-right">5910.00</td>
                        <td class="py-3 pl-4 text-right">29,550.00</td>
                    </tr>
                    <tr class="text-sm">
                        <td></td>
                        <td class="py-1 px-4 pl-8">a) HUMIDIFIER</td>
                        <td class="py-1 px-4 text-center">5</td>
                        <td class="py-1 px-4 text-center">PC</td>
                        <td class="py-1 px-4 text-right">360.00</td>
                        <td class="py-1 pl-4 text-right">1,800.00</td>
                    </tr>
                    <tr class="text-sm">
                        <td></td>
                        <td class="py-1 px-4 pl-8">b) FIRE ALARM RELAY</td>
                        <td class="py-1 px-4 text-center">5</td>
                        <td class="py-1 px-4 text-center">PC</td>
                        <td class="py-1 px-4 text-right">18.00</td>
                        <td class="py-1 pl-4 text-right">90.00</td>
                    </tr>
                    <tr class="text-sm">
                        <td></td>
                        <td class="py-1 px-4 pl-8">c) WOODEN CRATE</td>
                        <td class="py-1 px-4 text-center">5</td>
                        <td class="py-1 px-4 text-center">PC</td>
                        <td class="py-1 px-4 text-right">186.00</td>
                        <td class="py-1 pl-4 text-right">930.00</td>
                    </tr>
                    <tr class="text-sm border-b">
                        <td></td>
                        <td class="py-1 px-4 pl-8">d) AUTOMATIC TRANSFER SWITCH (ATS) (NADER)</td>
                        <td class="py-1 px-4 text-center">5</td>
                        <td class="py-1 px-4 text-center">PC</td>
                        <td class="py-1 px-4 text-right">335.00</td>
                        <td class="py-1 pl-4 text-right">1,675.00</td>
                    </tr>

                    <tr>
                        <td class="py-3 pr-4 font-bold">2</td>
                        <td class="py-3 px-4">
                            MODEL: HEC574 (230V/1PH/50HZ)
                        </td>
                        <td class="py-3 px-4 text-center">5</td>
                        <td class="py-3 px-4 text-center">UNIT</td>
                        <td class="py-3 px-4 text-right">1508.00</td>
                        <td class="py-3 pl-4 text-right">7,540.00</td>
                    </tr>
                    <tr class="text-sm">
                        <td></td>
                        <td class="py-1 px-4 pl-8">a) WOODEN CRATE (2 SETS PER CRATE)</td>
                        <td class="py-1 px-4 text-center">2</td>
                        <td class="py-1 px-4 text-center">PC</td>
                        <td class="py-1 px-4 text-right">182.00</td>
                        <td class="py-1 pl-4 text-right">364.00</td>
                    </tr>
                    <tr class="text-sm">
                        <td></td>
                        <td class="py-1 px-4 pl-8">b) WOODEN CRATE (1 SET PER CRATE)</td>
                        <td class="py-1 px-4 text-center">1</td>
                        <td class="py-1 px-4 text-center">PC</td>
                        <td class="py-1 px-4 text-right">133.00</td>
                        <td class="py-1 pl-4 text-right">133.00</td>
                    </tr>
                </tbody>
            </table>

            {{-- Total & Amount in Words --}}
            <div class="text-right mb-6">
                <div class="font-bold text-lg">US DOLLAR: FORTY TWO THOUSAND AND EIGHTY TWO ONLY</div>
                <div class="border-t-2 border-black mt-2 pt-2 inline-block">
                    <span class="font-bold">42,082.00</span>
                </div>
            </div>

            {{-- Delivery & Remarks --}}
            <div class="mb-8 text-sm">
                <strong>Delivery term:</strong> Ex-work Dongguan<br>
                <strong>REMARK:</strong><br>
                * Please include intermediary bank charge and your local bank charge
            </div>

            {{-- Terms & Bank Details --}}
            <div class="grid grid-cols-2 gap-8 text-sm">
                <div>
                    <strong>Terms & conditions</strong><br>
                    1. Please make a payment to CITEC INTERNATIONAL SDN BHD<br><br>
                    <strong>Bank details:</strong><br>
                    CIMB Bank Berhad<br>
                    22 A-0, Wisma Esther Robert, Lorong Batu Nilam 4B,<br>
                    Bandar Bukit Tinggi, 41200 Klang, Selangor, Malaysia<br>
                    A/C No: 800004305840 (For Payment in USD)
                </div>
                <div class="text-right">
                    <div class="mt-12">
                        <div class="border-b border-black w-48 mx-auto mb-2"></div>
                        <div class="font-bold">Ayu</div>
                        <div>For and on behalf of:</div>
                        <div class="font-bold">CITEC INTERNATIONAL SDN BHD</div>
                        <div class="text-xs mt-1">Authorized Signature</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>