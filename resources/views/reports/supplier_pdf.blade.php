<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rekap Pesanan Supplier {{ $date ?? '-' }}</title>
    <style>
        @page { margin: 30px; }
        body {
            font-family: 'DejaVu Sans', sans-serif;
            font-size: 13px;
            color: #1e293b;
            margin: 0;
            padding: 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td, th {
            padding: 8px;
            vertical-align: top;
        }
        .header-table {
            border-bottom: 2px solid #334155;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            color: #0f172a;
            margin: 0 0 5px 0;
            text-transform: uppercase;
        }
        .subtitle {
            font-size: 14px;
            color: #475569;
            margin: 0;
        }
        .data-table th {
            background-color: #f1f5f9;
            border-top: 2px solid #334155;
            border-bottom: 2px solid #334155;
            text-align: left;
            text-transform: uppercase;
            font-size: 11px;
            color: #475569;
        }
        .data-table td {
            border-bottom: 1px solid #e2e8f0;
            padding: 12px 8px;
        }
        .text-center { text-align: center; }
        .font-bold { font-weight: bold; }
    </style>
</head>
<body>
    <table class="header-table">
        <tr>
            <td>
                <h1 class="title">REKAP PESANAN SUPPLIER</h1>
                <p class="subtitle">Nama Supplier: <strong>__________________________</strong></p>
                <p class="subtitle">Tanggal: <strong>{{ isset($date) ? \Carbon\Carbon::parse($date)->format('d M Y') : '-' }}</strong></p>
            </td>
        </tr>
    </table>

    <table class="data-table">
        <thead>
            <tr>
                <th class="text-center" style="width: 10%;">No</th>
                <th style="width: 70%;">Nama Barang</th>
                <th class="text-center" style="width: 20%;">Qty</th>
            </tr>
        </thead>
        <tbody>
            @if(isset($rekaps) && count($rekaps) > 0)
                @foreach($rekaps as $rekap)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="font-bold">{{ $rekap->product_name ?? '-' }}</td>
                        <td class="text-center font-bold">
                            {{ floatval($rekap->total_qty ?? 0) }} <span style="font-size:10px; color:#64748b; font-weight:normal;">{{ $rekap->product_unit ?? '' }}</span>
                        </td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <td colspan="3" class="text-center" style="padding: 30px; color: #64748b;">Tidak ada rekap pesanan di tanggal ini.</td>
                </tr>
            @endif
        </tbody>
    </table>
</body>
</html>
