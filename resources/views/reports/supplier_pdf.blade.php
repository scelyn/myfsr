<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rekap Pesanan Supplier {{ $date }}</title>
    <style>
        @page { margin: 40px; }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 12px;
            color: #1a1a1a;
            line-height: 1.5;
            margin: 0;
            padding: 0;
        }
        .header-table {
            width: 100%;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
            margin-bottom: 25px;
        }
        .header-title h1 {
            margin: 0;
            font-size: 26px;
            color: #000;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        .header-title p {
            margin: 5px 0 0;
            color: #555;
            font-size: 11px;
        }
        .header-info {
            text-align: right;
        }
        .header-info h2 {
            margin: 0 0 5px 0; 
            font-size: 16px; 
            text-transform: uppercase;
        }
        .header-info p {
            margin: 2px 0;
            font-size: 11px;
            color: #444;
        }
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 30px;
        }
        .data-table th {
            background-color: #f4f4f4;
            border-bottom: 2px solid #333;
            text-align: left;
            padding: 10px 8px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #333;
        }
        .data-table td {
            padding: 8px;
            border-bottom: 1px solid #ddd;
            vertical-align: middle;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        
        .summary-wrapper {
            width: 100%;
        }
        .summary-table {
            width: 45%;
            margin-left: auto;
            border-collapse: collapse;
            border-top: 2px solid #333;
            margin-top: 10px;
        }
        .summary-table td {
            padding: 6px 8px;
            border-bottom: none;
        }
        .summary-label {
            color: #555;
            font-size: 11px;
        }
        .summary-value {
            font-weight: bold;
            font-size: 12px;
            text-align: right;
        }
        .grand-total td {
            padding-top: 12px;
            border-top: 1px solid #ccc;
        }
        .grand-total .summary-label {
            font-weight: bold;
            color: #000;
            font-size: 13px;
        }
        .grand-total .summary-value {
            font-size: 15px;
            color: #000;
        }
    </style>
</head>
<body>

    <table class="header-table">
        <tr>
            <td class="header-title" style="width: 50%; vertical-align: top;">
                <img src="{{ public_path('images/logo.png') }}" alt="MyFSR Logo" style="height: 40px; width: auto; object-fit: contain;">
                <p style="margin-top: 5px;">Enterprise Management System</p>
            </td>
            <td class="header-info" style="width: 50%; vertical-align: top;">
                <h2>Rekap Pesanan Supplier</h2>
                <p>Tanggal: <strong>{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</strong></p>
                <p>Dicetak Pada: {{ now()->format('d/m/Y H:i') }}</p>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 5%;">No</th>
                <th style="width: 35%;">Nama Produk</th>
                <th class="text-center" style="width: 15%;">Total Qty</th>
                <th class="text-right" style="width: 25%;">HPP / Unit (Est)</th>
                <th class="text-right" style="width: 20%;">Total Modal</th>
            </tr>
        </thead>
        <tbody>
            @forelse($rekaps as $rekap)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="font-bold">{{ $rekap->product_name }}</td>
                    <td class="text-center font-bold">
                        {{ $rekap->total_qty }} <span style="font-size:10px; color:#666; font-weight:normal;">{{ $rekap->product_unit }}</span>
                    </td>
                    <td class="text-right">Rp {{ number_format($rekap->estimated_base_price, 0, ',', '.') }}</td>
                    <td class="text-right font-bold">Rp {{ number_format($rekap->total_modal, 0, ',', '.') }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center" style="padding: 30px; color: #777;">Tidak ada rekap pesanan di tanggal ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    @if($summary && $summary->total_transaksi > 0)
        <div class="summary-wrapper">
            <table class="summary-table">
                <tr>
                    <td class="summary-label">Total Transaksi Harian</td>
                    <td class="summary-value">{{ $summary->total_transaksi }} Nota</td>
                </tr>
                <tr>
                    <td class="summary-label">Total Item Dipesan</td>
                    <td class="summary-value">{{ number_format($summary->total_qty, 0, ',', '.') }} Produk</td>
                </tr>
                <tr>
                    <td class="summary-label">Total Estimasi Laba</td>
                    <td class="summary-value">Rp {{ number_format($summary->total_laba, 0, ',', '.') }}</td>
                </tr>
                <tr class="grand-total">
                    <td class="summary-label">TOTAL MODAL SUPPLIER</td>
                    <td class="summary-value">Rp {{ number_format($summary->total_modal, 0, ',', '.') }}</td>
                </tr>
            </table>
        </div>
    @endif

</body>
</html>
