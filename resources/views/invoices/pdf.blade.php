<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice {{ $invoice->invoice_number }}</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            font-size: 13px;
            color: #333;
            margin: 0;
            padding: 20px;
        }
        .header {
            width: 100%;
            margin-bottom: 40px;
            border-bottom: 2px solid #253745;
            padding-bottom: 20px;
        }
        .header-left {
            float: left;
            width: 50%;
        }
        .header-right {
            float: right;
            width: 50%;
            text-align: right;
        }
        .logo {
            font-size: 28px;
            font-weight: bold;
            color: #06141B;
            margin: 0;
            letter-spacing: 2px;
        }
        .invoice-title {
            font-size: 20px;
            font-weight: bold;
            color: #4A5C6A;
            margin: 5px 0 10px 0;
            text-transform: uppercase;
        }
        .info-box {
            width: 100%;
            margin-bottom: 30px;
        }
        .info-left {
            float: left;
            width: 50%;
        }
        .info-right {
            float: right;
            width: 50%;
            text-align: right;
        }
        .info-label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            font-weight: bold;
            margin: 0 0 5px 0;
        }
        .info-value {
            font-size: 14px;
            color: #111;
            font-weight: bold;
            margin: 0 0 15px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        th {
            background-color: #f1f5f9;
            border-top: 2px solid #253745;
            border-bottom: 2px solid #253745;
            text-align: left;
            padding: 12px 10px;
            font-size: 11px;
            text-transform: uppercase;
            color: #4A5C6A;
        }
        td {
            padding: 12px 10px;
            border-bottom: 1px solid #e2e8f0;
            vertical-align: top;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        
        .footer-summary {
            width: 40%;
            float: right;
            border-top: 2px solid #253745;
            padding-top: 15px;
        }
        .summary-row {
            margin-bottom: 10px;
            clear: both;
        }
        .summary-label {
            float: left;
            font-weight: bold;
            color: #4A5C6A;
            font-size: 12px;
            text-transform: uppercase;
        }
        .summary-value {
            float: right;
            font-weight: bold;
            color: #06141B;
            font-size: 14px;
        }
        .grand-total {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #cbd5e1;
        }
        .grand-total .summary-label {
            font-size: 14px;
            color: #06141B;
        }
        .grand-total .summary-value {
            font-size: 20px;
        }
        .clear { clear: both; }
        
        .status-badge {
            display: inline-block;
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: bold;
            text-transform: uppercase;
        }
        .status-paid { background: #dcfce7; color: #166534; border: 1px solid #166534; }
        .status-unpaid { background: #fee2e2; color: #991b1b; border: 1px solid #991b1b; }
        .status-partial { background: #fef9c3; color: #854d0e; border: 1px solid #854d0e; }
        
        .footer-note {
            margin-top: 50px;
            font-size: 11px;
            color: #64748b;
            text-align: center;
            border-top: 1px dashed #cbd5e1;
            padding-top: 20px;
        }
    </style>
</head>
<body>

    <div class="header">
        <div class="header-left">
            <img src="{{ public_path('images/logo.png') }}" alt="MyFSR Logo" style="height: 40px; width: auto; object-fit: contain;">
            <p style="margin: 5px 0 0; color: #64748b; font-size: 12px;">Enterprise Management System</p>
        </div>
        <div class="header-right">
            <div class="invoice-title">INVOICE</div>
            <div style="font-size: 18px; font-weight: bold; color: #06141B;">#{{ $invoice->invoice_number }}</div>
        </div>
        <div class="clear"></div>
    </div>

    <div class="info-box">
        <div class="info-left">
            <p class="info-label">Tagihan Kepada:</p>
            <p class="info-value">{{ $invoice->customer->nama_toko }}<br>
            <span style="font-weight: normal; font-size: 12px; color: #4A5C6A;">
                {{ $invoice->customer->nama_pemilik }}<br>
                {{ $invoice->customer->alamat }}<br>
                {{ $invoice->customer->no_whatsapp }}
            </span></p>
        </div>
        <div class="info-right">
            <p class="info-label">Tanggal Invoice:</p>
            <p class="info-value">{{ $invoice->invoice_date->format('d M Y') }}</p>
            
            <p class="info-label" style="margin-top: 15px;">Status Pembayaran:</p>
            <p>
                @if($invoice->status == 'paid')
                    <span class="status-badge status-paid">LUNAS</span>
                @elseif($invoice->status == 'unpaid')
                    <span class="status-badge status-unpaid">BELUM DIBAYAR</span>
                @else
                    <span class="status-badge status-partial">SEBAGIAN</span>
                @endif
            </p>
        </div>
        <div class="clear"></div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">No</th>
                <th style="width: 40%;">Deskripsi Produk</th>
                <th class="text-center" style="width: 15%;">Qty</th>
                <th class="text-right" style="width: 20%;">Harga Satuan</th>
                <th class="text-right" style="width: 20%;">Subtotal</th>
            </tr>
        </thead>
        <tbody>
            @foreach($invoice->order->items as $item)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td>
                        <span class="font-bold">{{ $item->product_name }}</span>
                        @if($item->notes)
                            <br><span style="font-size: 11px; color: #64748b; font-style: italic;">{{ $item->notes }}</span>
                        @endif
                    </td>
                    <td class="text-center">
                        <span class="font-bold">{{ $item->quantity }}</span> 
                        <span style="font-size: 10px; color: #64748b;">{{ $item->product_unit }}</span>
                    </td>
                    <td class="text-right">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                    <td class="text-right font-bold">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer-summary">
        <div style="text-align: center; font-size: 10px; font-weight: bold; color: #4A5C6A; text-transform: uppercase; letter-spacing: 1px; border-bottom: 1px solid #cbd5e1; padding-bottom: 5px; margin-bottom: 10px;">Rincian Tagihan Customer</div>
        <div class="summary-row">
            <span class="summary-label" style="text-transform: none;">Belanja Hari Ini</span>
            <span class="summary-value">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</span>
        </div>
        
        @if($previous_tunggakan > 0)
        <div class="summary-row" style="padding-bottom: 5px; border-bottom: 1px dashed #cbd5e1; margin-bottom: 10px;">
            <span class="summary-label" style="color: #991b1b; text-transform: none;">Tunggakan Sebelumnya</span>
            <span class="summary-value" style="color: #991b1b;">Rp {{ number_format($previous_tunggakan, 0, ',', '.') }}</span>
        </div>
        @endif

        <div class="summary-row grand-total">
            <span class="summary-label">TOTAL TAGIHAN CUSTOMER</span>
            <span class="summary-value">Rp {{ number_format($invoice->total_amount + $previous_tunggakan, 0, ',', '.') }}</span>
        </div>

        @if($invoice->paid_amount > 0)
        <div class="summary-row" style="margin-top: 10px;">
            <span class="summary-label" style="color: #166534;">Sudah Dibayar (Nota Ini)</span>
            <span class="summary-value" style="color: #166534;">- Rp {{ number_format($invoice->paid_amount, 0, ',', '.') }}</span>
        </div>
        <div class="summary-row">
            <span class="summary-label" style="color: {{ $invoice->remaining_amount > 0 ? '#991b1b' : '#166534' }};">SISA TAGIHAN (Nota Ini)</span>
            <span class="summary-value" style="color: {{ $invoice->remaining_amount > 0 ? '#991b1b' : '#166534' }};">
                Rp {{ number_format($invoice->remaining_amount, 0, ',', '.') }}
            </span>
        </div>
        @endif
    </div>
    <div class="clear"></div>

    <div class="footer-note">
        Dokumen ini dihasilkan secara otomatis oleh sistem MyFSR dan sah tanpa tanda tangan.<br>
        Terima kasih atas kepercayaan Anda bermitra dengan kami.
    </div>

</body>
</html>
