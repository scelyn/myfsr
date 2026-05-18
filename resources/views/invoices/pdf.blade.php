<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        /* ── Base Reset ─────────────────────────────────────── */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            color: #1f2937;
            padding: 30px 35px;
            line-height: 1.4;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }

        /* ── Layout Tables ──────────────────────────────────── */
        .layout-table {
            width: 100%;
            border-collapse: collapse;
            border: none;
        }
        .layout-table td {
            vertical-align: top;
            padding: 0;
            border: none;
        }

        /* ── Header ─────────────────────────────────────────── */
        .invoice-header {
            margin-bottom: 30px;
            padding-bottom: 18px;
            border-bottom: 2px solid #253745;
            page-break-inside: avoid;
        }
        .invoice-header .col-left {
            width: 50%;
        }
        .invoice-header .col-right {
            width: 50%;
            text-align: right;
        }
        .logo-img {
            height: 40px;
            width: auto;
        }
        .company-subtitle {
            margin-top: 6px;
            color: #64748b;
            font-size: 11px;
        }
        .invoice-title {
            font-size: 22px;
            font-weight: 800;
            color: #4A5C6A;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .invoice-number {
            font-size: 16px;
            font-weight: 700;
            color: #06141B;
            margin-top: 4px;
        }

        /* ── Status Badge ───────────────────────────────────── */
        .status-badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-top: 8px;
        }
        .status-paid    { background: #dcfce7; color: #166534; border: 1px solid #166534; }
        .status-unpaid  { background: #fee2e2; color: #991b1b; border: 1px solid #991b1b; }
        .status-partial { background: #fef9c3; color: #854d0e; border: 1px solid #854d0e; }

        /* ── Customer + Meta Section ────────────────────────── */
        .invoice-meta {
            margin-bottom: 28px;
            page-break-inside: avoid;
        }
        .invoice-meta .col-left {
            width: 55%;
            vertical-align: top;
        }
        .invoice-meta .col-right {
            width: 45%;
            text-align: right;
            vertical-align: top;
        }
        .meta-label {
            font-size: 10px;
            color: #64748b;
            text-transform: uppercase;
            font-weight: 700;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .meta-value {
            font-size: 14px;
            color: #111;
            font-weight: 700;
            margin-bottom: 12px;
        }
        .meta-detail {
            font-weight: 400;
            font-size: 12px;
            color: #4A5C6A;
            line-height: 1.6;
        }

        /* ── Product Table ──────────────────────────────────── */
        .invoice-items {
            margin-bottom: 28px;
        }
        .invoice-items table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .invoice-items th {
            background-color: #f1f5f9;
            border-top: 2px solid #253745;
            border-bottom: 2px solid #253745;
            text-align: left;
            padding: 10px 10px;
            font-size: 10px;
            text-transform: uppercase;
            color: #4A5C6A;
            font-weight: 700;
            letter-spacing: 0.5px;
            vertical-align: middle;
            line-height: 1.4;
        }
        .invoice-items td {
            padding: 10px 10px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: middle;
            line-height: 1.4;
            font-size: 12px;
        }
        .invoice-items .col-no       { width: 5%;  text-align: center; }
        .invoice-items .col-desc     { width: 45%; text-align: left; }
        .invoice-items .col-qty      { width: 15%; text-align: center; }
        .invoice-items .col-price    { width: 15%; text-align: right; }
        .invoice-items .col-subtotal { width: 20%; text-align: right; }

        .product-name {
            font-weight: 700;
            color: #1f2937;
        }
        .product-note {
            font-size: 10px;
            color: #64748b;
            font-style: italic;
            margin-top: 2px;
        }
        .product-unit {
            font-size: 9px;
            color: #64748b;
        }
        .currency {
            white-space: nowrap;
            font-variant-numeric: tabular-nums;
        }

        /* ── Totals Section ─────────────────────────────────── */
        .invoice-total-wrapper {
            width: 100%;
            margin-top: 0;
            page-break-inside: avoid;
        }
        .invoice-total-anchor {
            width: 100%;
            border-collapse: collapse;
        }
        .invoice-total-anchor td {
            border: none;
            padding: 0;
        }
        .invoice-total-anchor .spacer-col {
            width: 55%;
        }
        .invoice-total-anchor .total-col {
            width: 45%;
        }
        .invoice-total-table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
        }
        .invoice-total-table td {
            padding: 7px 10px;
            font-size: 12px;
            vertical-align: middle;
            line-height: 1.4;
            border: none;
        }
        .invoice-total-table .label-col {
            width: 55%;
            text-align: left;
        }
        .invoice-total-table .value-col {
            width: 45%;
            text-align: right;
        }
        .total-section-header {
            text-align: center;
            font-size: 10px;
            font-weight: 700;
            color: #4A5C6A;
            text-transform: uppercase;
            letter-spacing: 1px;
            padding-bottom: 8px !important;
            border-bottom: 1px solid #cbd5e1 !important;
        }
        .total-row-label {
            color: #4A5C6A;
            font-weight: 600;
        }
        .total-row-value {
            color: #06141B;
            font-weight: 700;
        }
        .total-row-warning .total-row-label,
        .total-row-warning .total-row-value {
            color: #991b1b;
        }
        .total-row-success .total-row-label,
        .total-row-success .total-row-value {
            color: #166534;
        }
        .total-row-grand td {
            padding-top: 12px !important;
            padding-bottom: 12px !important;
            border-top: 2px solid #253745 !important;
        }
        .total-row-grand .total-row-label {
            font-size: 13px;
            font-weight: 800;
            color: #06141B;
            text-transform: uppercase;
        }
        .total-row-grand .total-row-value {
            font-size: 18px;
            font-weight: 800;
            color: #06141B;
        }
        .total-row-remaining td {
            padding-top: 8px !important;
            border-top: 1px solid #cbd5e1 !important;
        }
        .total-row-remaining .total-row-label {
            font-weight: 800;
            text-transform: uppercase;
            font-size: 12px;
        }
        .total-row-remaining .total-row-value {
            font-size: 16px;
            font-weight: 800;
        }
        .total-row-dashed td {
            padding-bottom: 8px !important;
            border-bottom: 1px dashed #cbd5e1 !important;
        }

        /* ── Footer ─────────────────────────────────────────── */
        .invoice-footer {
            margin-top: 50px;
            text-align: center;
            font-size: 11px;
            color: #64748b;
            border-top: 1px dashed #cbd5e1;
            padding-top: 20px;
            page-break-inside: avoid;
        }
        .invoice-footer p {
            margin-bottom: 4px;
            line-height: 1.6;
        }
    </style>
</head>
<body>

    {{-- ═══════════════════════════════════════════════════════
         SECTION 1: HEADER
         ═══════════════════════════════════════════════════════ --}}
    <div class="invoice-header">
        <table class="layout-table">
            <tr>
                <td class="col-left">
                    <img src="{{ public_path('images/logo.png') }}" alt="MyFSR Logo" class="logo-img">
                    <p class="company-subtitle">Enterprise Management System</p>
                </td>
                <td class="col-right">
                    <div class="invoice-title">INVOICE</div>
                    <div class="invoice-number">#{{ $invoice->invoice_number }}</div>
                    @if($invoice->status == 'paid')
                        <span class="status-badge status-paid">LUNAS</span>
                    @elseif($invoice->status == 'unpaid')
                        <span class="status-badge status-unpaid">BELUM DIBAYAR</span>
                    @else
                        <span class="status-badge status-partial">DIBAYAR SEBAGIAN</span>
                    @endif
                </td>
            </tr>
        </table>
    </div>

    {{-- ═══════════════════════════════════════════════════════
         SECTION 2: CUSTOMER + META INFO
         ═══════════════════════════════════════════════════════ --}}
    <div class="invoice-meta">
        <table class="layout-table">
            <tr>
                <td class="col-left">
                    <p class="meta-label">Ditagihkan Kepada:</p>
                    <p class="meta-value">{{ $invoice->customer->nama_toko }}</p>
                    <p class="meta-detail">
                        {{ $invoice->customer->nama_pemilik }}<br>
                        {{ $invoice->customer->alamat }}<br>
                        {{ $invoice->customer->no_whatsapp }}
                    </p>
                </td>
                <td class="col-right">
                    <p class="meta-label">Tanggal Invoice</p>
                    <p class="meta-value">{{ $invoice->invoice_date->format('d M Y') }}</p>

                    <p class="meta-label" style="margin-top:10px;">Jatuh Tempo</p>
                    <p class="meta-value">{{ $invoice->due_date->format('d M Y') }}</p>

                    <p class="meta-label" style="margin-top:10px;">ID Order</p>
                    <p class="meta-value">{{ $invoice->order->order_number }}</p>
                </td>
            </tr>
        </table>
    </div>

    {{-- ═══════════════════════════════════════════════════════
         SECTION 3: PRODUCT TABLE
         ═══════════════════════════════════════════════════════ --}}
    <div class="invoice-items">
        <table>
            <thead>
                <tr>
                    <th class="col-no">No</th>
                    <th class="col-desc">Deskripsi Produk</th>
                    <th class="col-qty">Qty</th>
                    <th class="col-price">Harga Satuan</th>
                    <th class="col-subtotal">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                @foreach($invoice->order->items as $item)
                    <tr>
                        <td class="col-no">{{ $loop->iteration }}</td>
                        <td class="col-desc">
                            <span class="product-name">{{ $item->product_name }}</span>
                            @if($item->notes)
                                <br><span class="product-note">{{ $item->notes }}</span>
                            @endif
                        </td>
                        <td class="col-qty">
                            <span style="font-weight:700;">{{ $item->quantity }}</span>
                            <span class="product-unit">{{ $item->product_unit }}</span>
                        </td>
                        <td class="col-price currency">Rp {{ \App\Helpers\NumberHelper::format($item->unit_price) }}</td>
                        <td class="col-subtotal currency" style="font-weight:700;">Rp {{ \App\Helpers\NumberHelper::format($item->subtotal) }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- ═══════════════════════════════════════════════════════
         SECTION 4: TOTALS (TABLE-BASED, ZERO OVERLAP)
         ═══════════════════════════════════════════════════════ --}}
    <div class="invoice-total-wrapper">
        <table class="invoice-total-anchor">
            <tr>
                <td class="spacer-col"></td>
                <td class="total-col">
                    <table class="invoice-total-table">
                        <tr>
                            <td colspan="2" class="total-section-header">Rincian Tagihan Customer</td>
                        </tr>
                        <tr>
                            <td class="label-col total-row-label">Belanja Hari Ini</td>
                            <td class="value-col total-row-value currency">Rp {{ \App\Helpers\NumberHelper::format($invoice->total_amount) }}</td>
                        </tr>
                        @if($previous_tunggakan > 0)
                        <tr class="total-row-warning total-row-dashed">
                            <td class="label-col total-row-label">Tunggakan Sebelumnya</td>
                            <td class="value-col total-row-value currency">Rp {{ \App\Helpers\NumberHelper::format($previous_tunggakan) }}</td>
                        </tr>
                        @endif
                        <tr class="total-row-grand">
                            <td class="label-col total-row-label">TOTAL TAGIHAN</td>
                            <td class="value-col total-row-value currency">Rp {{ \App\Helpers\NumberHelper::format($invoice->total_amount + $previous_tunggakan) }}</td>
                        </tr>
                        @if($invoice->paid_amount > 0)
                        <tr class="total-row-success">
                            <td class="label-col total-row-label">Sudah Dibayar</td>
                            <td class="value-col total-row-value currency">- Rp {{ \App\Helpers\NumberHelper::format($invoice->paid_amount) }}</td>
                        </tr>
                        <tr class="total-row-remaining {{ $invoice->remaining_amount > 0 ? 'total-row-warning' : 'total-row-success' }}">
                            <td class="label-col total-row-label">Sisa Tagihan</td>
                            <td class="value-col total-row-value currency">Rp {{ \App\Helpers\NumberHelper::format($invoice->remaining_amount) }}</td>
                        </tr>
                        @endif
                    </table>
                </td>
            </tr>
        </table>
    </div>

    {{-- ═══════════════════════════════════════════════════════
         SECTION 5: FOOTER
         ═══════════════════════════════════════════════════════ --}}
    <div class="invoice-footer">
        <p>Dokumen ini dihasilkan secara otomatis oleh sistem MyFSR dan sah tanpa tanda tangan.</p>
        <p>Terima kasih atas kepercayaan Anda bermitra dengan kami.</p>
    </div>

</body>
</html>
