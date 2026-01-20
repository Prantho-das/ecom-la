<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Proforma Invoice - {{ $quotation->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10pt;
            margin: 0;
            padding: 0;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .logo {
            font-size: 24pt;
            font-weight: bold;
            color: #4CAF50; /* Greenish color from logo perception */
            margin-bottom: 5px;
        }
        .company-name {
            font-size: 14pt;
            font-weight: bold;
        }
        .company-address {
            font-size: 9pt;
            margin-bottom: 5px;
        }
        .invoice-title {
            font-size: 16pt;
            font-weight: bold;
            margin-top: 15px;
            text-decoration: underline;
        }
        .info-table {
            width: 100%;
            margin-bottom: 20px;
        }
        .info-table td {
            vertical-align: top;
        }
        .box-title {
            font-weight: bold;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .items-table th {
            border-top: 2px solid #000;
            border-bottom: 2px solid #000;
            text-align: left;
            padding: 5px;
        }
        .items-table td {
            padding: 5px;
            vertical-align: top;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .footer {
            margin-top: 20px;
        }
        .total-box {
            border: 2px solid #000;
            padding: 10px;
            font-weight: bold;
            text-align: right;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .signatures {
            margin-top: 50px;
        }
        .signature-line {
            border-top: 1px solid #000;
            width: 200px;
            margin-top: 10px;
        }
        .page-number {
            text-align: right;
            font-size: 9pt;
        }
    </style>
</head>
<body>

    <div class="header">
        <!-- Logo Placeholder -->
        <div class="logo">CITEC</div>
        <div class="company-name">CITEC INTERNATIONAL SDN BHD</div>
        <div class="company-address">
            NO. 1C (3RD FLOOR), JALAN ANGGERIK VANILLA X31/X, KOTA KEMUNING, SEKSYEN 31,<br>
            40460 SHAH ALAM, SELANGOR DARUL EHSAN<br>
            TEL: +603- 51245668/67, FAX: +603-51245669
        </div>
        <div class="invoice-title">PROFORMA INVOICE</div>
    </div>

    <table class="info-table">
        <tr>
            <td width="60%">
                <strong>To:</strong><br>
                {{ $quotation->customer_name }}<br>
                {{ $quotation->customer_email }}<br>
                <!-- Placeholder for address as it's not in Quotation model yet, using notes or hardcoded -->
                139, LAKE CIRCUS,<br>
                KALABAGAN,<br>
                DHAKA - 1205<br>
                <strong>Attn:</strong> Mr. Amran<br>
                <strong>Tel:</strong> +88 02 8116 124<br>
                <strong>Fax:</strong> +88 02 9121 230
            </td>
            <td width="40%" class="text-right">
                <table width="100%">
                    <tr>
                        <td class="text-right"><strong>Invoice No.:</strong></td>
                        <td>PI25-{{ str_pad($quotation->id, 4, '0', STR_PAD_LEFT) }}</td>
                    </tr>
                    <tr>
                        <td class="text-right"><strong>Invoice Date:</strong></td>
                        <td>{{ $quotation->created_at->format('d/m/Y') }}</td>
                    </tr>
                    <tr>
                        <td class="text-right"><strong>Customer PO No.:</strong></td>
                        <td>TVSLFP{{ $quotation->created_at->format('ymd') }}R</td>
                    </tr>
                    <tr>
                        <td class="text-right"><strong>Payment Term:</strong></td>
                        <td>TT Before Delivery</td>
                    </tr>
                    <tr>
                        <td class="text-right"><strong>Page:</strong></td>
                        <td>1 / 1</td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <table class="items-table">
        <thead>
            <tr>
                <th width="5%">Item</th>
                <th width="45%">Product Description</th>
                <th width="10%" class="text-center">Quantity</th>
                <th width="10%" class="text-center">Uom</th>
                <th width="15%" class="text-right">Unit Price ({{ $quotation->currency }})</th>
                <th width="15%" class="text-right">Amount ({{ $quotation->currency }})</th>
            </tr>
        </thead>
        <tbody>
            @foreach($quotation->items as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>
                    <strong>MODEL: {{ $item->name }}</strong><br>
                    <!-- Display SKU or Description if available -->
                    <small>{{ $item->sku }}</small>
                </td>
                <td class="text-center">{{ $item->quantity }}</td>
                <td class="text-center">UNIT</td>
                <td class="text-right">{{ number_format($item->unit_product_price, 2) }}</td>
                <td class="text-right">{{ number_format($item->quantity * $item->unit_product_price, 2) }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Total In Words Check -->
    <div class="total-box">
        {{ $quotation->currency }}: {{ \NumberFormatter::create('en', \NumberFormatter::SPELLOUT)->format($quotation->grand_total) }} ONLY
        &nbsp;&nbsp;&nbsp;&nbsp;
        {{ number_format($quotation->grand_total, 2) }}
    </div>

    <div class="footer">
        <strong>Delivery term:</strong><br>
        {{ strtoupper($quotation->pricing_tier) }} {{ $quotation->shipping_method == 'sea' ? 'SEA PORT' : 'AIRPORT' }}<br>
        <small style="color: red;">* Please include intermediary bank charge and your local bank charge</small>
        <br><br>

        <strong>Terms & conditions</strong><br>
        1. Please make a payment to CITEC INTERNATIONAL SDN BHD<br>
        <br>

        <strong>Bank details:</strong><br>
        <b>CIMB Bank Berhad</b><br>
        22 A-0, Wisma Esther Robert, Lorong Batu Nilam 4B,<br>
        Bandar Bukit Tinggi, 41200 Klang, Selangor, Malaysia<br>
        <b>A/C No: 800004305840 (For Payment in {{ $quotation->currency }})</b>
    </div>

    <div class="signatures">
        For and on behalf of:<br>
        <strong>CITEC INTERNATIONAL SDN BHD</strong>
        <br><br><br><br>
        <div class="signature-line"></div>
        Authorized Signature
    </div>

</body>
</html>
