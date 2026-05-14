<x-admin-layout>
    <x-slot name="title">Invoice #{{ $invoice->invoice_number }}</x-slot>
    <x-slot name="header">Detail Invoice</x-slot>

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Actions -->
        <div class="flex items-center justify-between">
            <a href="{{ route('orders.index') }}" class="text-sm font-medium text-theme-text2 hover:text-emerald-600 flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Pesanan
            </a>
            
            <div class="flex items-center gap-3 relative" x-data="{ printOpen: false }">
                <!-- Dropdown Cetak -->
                <button @click="printOpen = !printOpen" @click.away="printOpen = false" class="px-4 py-2 bg-theme-sidebar text-theme-text1 hover:bg-theme-border rounded-xl text-sm font-bold flex items-center gap-2 transition-colors">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak Nota
                    <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                
                <div x-show="printOpen" x-transition.opacity class="absolute right-[120px] top-12 w-48 bg-theme-card border border-theme-border rounded-xl shadow-lg z-50 overflow-hidden" style="display: none;">
                    <a href="{{ URL::signedRoute('invoices.pdf', $invoice->id) }}" target="_blank" class="block px-4 py-3 text-sm text-theme-text1 hover:bg-theme-sidebar border-b border-theme-border">
                        Unduh PDF
                    </a>
                    <button onclick="printNota('a4')" class="w-full text-left px-4 py-3 text-sm text-theme-text1 hover:bg-theme-sidebar border-b border-theme-border">
                        Print Ukuran A4
                    </button>
                    <button onclick="printNota('letter')" class="w-full text-left px-4 py-3 text-sm text-theme-text1 hover:bg-theme-sidebar border-b border-theme-border">
                        Print Ukuran Letter
                    </button>
                    <button onclick="printNota('thermal80')" class="w-full text-left px-4 py-3 text-sm text-theme-text1 hover:bg-theme-sidebar border-b border-theme-border">
                        Print Thermal 80mm
                    </button>
                    <button onclick="printNota('thermal58')" class="w-full text-left px-4 py-3 text-sm text-theme-text1 hover:bg-theme-sidebar">
                        Print Thermal 58mm
                    </button>
                </div>
                
                @php
                    $waText = "Halo Bapak/Ibu " . $invoice->customer->nama_pemilik . " (" . $invoice->customer->nama_toko . "),\n\n";
                    $waText .= "Berikut invoice terbaru Anda.\n\n";
                    $waText .= "Invoice:\n" . $invoice->invoice_number . "\n\n";
                    $waText .= "Belanja Hari Ini:\nRp " . number_format($invoice->total_amount, 0, ',', '.') . "\n\n";
                    if ($previous_tunggakan > 0) {
                        $waText .= "Tunggakan Sebelumnya:\nRp " . number_format($previous_tunggakan, 0, ',', '.') . "\n\n";
                    }
                    $waText .= "TOTAL TAGIHAN:\nRp " . number_format($invoice->total_amount + $previous_tunggakan, 0, ',', '.') . "\n\n";
                    $waText .= "Link Invoice:\n" . URL::signedRoute('invoices.pdf', $invoice->id) . "\n\n";
                    $waText .= "Terima kasih.";
                    $waUrl = "https://wa.me/" . preg_replace('/[^0-9]/', '', $invoice->customer->no_whatsapp) . "?text=" . urlencode($waText);
                @endphp
                <a href="{{ $waUrl }}" target="_blank" class="px-4 py-2 bg-theme-border text-theme-text1 hover:bg-theme-text2 hover:text-theme-sidebar rounded-xl text-sm font-bold flex items-center gap-2 shadow-md shadow-sm transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    Share WA
                </a>
            </div>
        </div>

        <!-- Invoice Paper -->
        <div class="bg-theme-card p-12 rounded-2xl border border-slate-50 shadow-md shadow-sm print:shadow-none print:border-none print:p-0">
            @if($previous_tunggakan > 0)
            <div class="mb-8 p-4 bg-amber-500/10 border border-amber-500/20 rounded-xl print:hidden flex items-start gap-3">
                <svg class="w-5 h-5 text-amber-500 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <p class="text-sm text-amber-500 font-medium">⚠ Customer memiliki tunggakan sebelumnya sebesar <span class="font-bold">Rp {{ number_format($previous_tunggakan, 0, ',', '.') }}</span></p>
            </div>
            @endif

            <!-- Header -->
            <div class="flex justify-between items-start border-b border-theme-border pb-8 mb-8">
                <div>
                    <img src="{{ asset('images/logo.png') }}" alt="MyFSR Logo" class="h-12 w-auto object-contain mb-2 print:h-10">
                    <p class="text-sm text-theme-text2">Enterprise Management System</p>
                </div>
                <div class="text-right">
                    <h2 class="text-2xl font-black text-theme-text1">INVOICE</h2>
                    <p class="text-sm font-bold text-theme-text2 mt-1">#{{ $invoice->invoice_number }}</p>
                    
                    @if($invoice->status == 'paid')
                        <span class="inline-block mt-4 px-4 py-1.5 bg-theme-success/40 text-emerald-600 text-xs font-black rounded-full uppercase tracking-widest border border-emerald-200">LUNAS</span>
                    @elseif($invoice->status == 'partial')
                        <span class="inline-block mt-4 px-4 py-1.5 bg-yellow-100 text-yellow-700 text-xs font-black rounded-full uppercase tracking-widest border border-yellow-200">DIBAYAR SEBAGIAN</span>
                    @else
                        <span class="inline-block mt-4 px-4 py-1.5 bg-theme-error/40 text-rose-600 text-xs font-black rounded-full uppercase tracking-widest border border-red-200">BELUM DIBAYAR</span>
                    @endif
                </div>
            </div>

            <!-- Info -->
            <div class="grid grid-cols-2 gap-12 mb-12">
                <div>
                    <p class="text-[10px] font-black text-theme-text2 uppercase tracking-widest mb-3">Ditagihkan Kepada:</p>
                    <h3 class="text-lg font-bold text-theme-text1">{{ $invoice->customer->nama_toko }}</h3>
                    <p class="text-sm text-theme-text1 mt-1">{{ $invoice->customer->nama_pemilik }}</p>
                    <p class="text-sm text-theme-text1">{{ $invoice->customer->alamat_pasar }}</p>
                    <p class="text-sm text-theme-text1 mt-2 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                        {{ $invoice->customer->no_whatsapp }}
                    </p>
                </div>
                <div class="grid grid-cols-2 gap-6 bg-theme-bg p-6 rounded-2xl">
                    <div>
                        <p class="text-[10px] font-black text-theme-text2 uppercase tracking-widest mb-1">Tanggal Order</p>
                        <p class="text-sm font-bold text-theme-text1">{{ $invoice->order->order_date->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-theme-text2 uppercase tracking-widest mb-1">Jatuh Tempo</p>
                        <p class="text-sm font-bold text-theme-text1">{{ $invoice->due_date->format('d/m/Y') }}</p>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-theme-text2 uppercase tracking-widest mb-1">ID Order</p>
                        <p class="text-sm font-bold text-theme-text1">{{ $invoice->order->order_number }}</p>
                    </div>
                </div>
            </div>

            <!-- Items -->
            <table class="w-full text-left mb-8">
                <thead>
                    <tr class="border-b-2 border-theme-border">
                        <th class="py-4 text-[10px] font-black text-theme-text2 uppercase tracking-widest">Deskripsi Barang</th>
                        <th class="py-4 text-[10px] font-black text-theme-text2 uppercase tracking-widest text-center">Qty</th>
                        <th class="py-4 text-[10px] font-black text-theme-text2 uppercase tracking-widest text-right">Harga Satuan</th>
                        <th class="py-4 text-[10px] font-black text-theme-text2 uppercase tracking-widest text-right">Total</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($invoice->order->items as $item)
                        <tr>
                            <td class="py-4">
                                <p class="text-sm font-bold text-theme-text1">{{ $item->product_name }}</p>
                            </td>
                            <td class="py-4 text-center">
                                <p class="text-sm font-medium text-theme-text1">{{ floatval($item->quantity) }} <span class="text-xs text-theme-text2">{{ $item->product_unit }}</span></p>
                            </td>
                            <td class="py-4 text-right">
                                <p class="text-sm font-medium text-theme-text1">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</p>
                            </td>
                            <td class="py-4 text-right">
                                <p class="text-sm font-black text-theme-text1">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</p>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <!-- Summary -->
            <div class="flex flex-col items-end border-t border-theme-border pt-8 mt-8">
                <div class="w-full max-w-[320px]">
                    <h4 class="text-[10px] font-black text-theme-text2 uppercase tracking-widest mb-4 border-b border-theme-border pb-2 text-center">Rincian Tagihan Customer</h4>
                    <div class="space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-sm font-medium text-theme-text1">Belanja Hari Ini</span>
                            <span class="text-sm font-bold text-theme-text1">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</span>
                        </div>

                        @if($previous_tunggakan > 0)
                        <div class="flex justify-between items-center pb-2 border-b border-dashed border-slate-300">
                            <span class="text-sm font-medium text-theme-warningText">Tunggakan Sebelumnya</span>
                            <span class="text-sm font-bold text-theme-warningText">Rp {{ number_format($previous_tunggakan, 0, ',', '.') }}</span>
                        </div>
                        @endif
                        
                        <div class="flex justify-between items-center py-4 border-t-2 border-theme-border mt-4">
                            <span class="text-base font-black text-theme-text1">TOTAL TAGIHAN CUSTOMER</span>
                            <span class="text-xl font-black text-theme-text1">Rp {{ number_format($invoice->total_amount + $previous_tunggakan, 0, ',', '.') }}</span>
                        </div>

                        @if($invoice->paid_amount > 0)
                            <div class="flex justify-between items-center text-emerald-500 mt-2 text-sm font-medium">
                                <span>Sudah Dibayar (Nota Ini)</span>
                                <span>- Rp {{ number_format($invoice->paid_amount, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex justify-between items-center py-2 border-t border-theme-border mt-2">
                                <span class="text-base font-black text-rose-600">SISA TAGIHAN (Nota Ini)</span>
                                <span class="text-xl font-black text-rose-600">Rp {{ number_format($invoice->remaining_amount, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
            
            <div class="mt-16 text-center text-sm text-theme-text2">
                <p>Terima kasih atas kepercayaannya.</p>
                <p>Pembayaran dapat ditransfer ke Rekening BCA: 1234567890 a.n MyFSR Semesta</p>
            </div>
        </div>
    </div>

    <!-- Print Styles -->
    <style>
        @media print {
            /* Hide UI components globally */
            header, nav, button, a, #payment-section, .print\:hidden {
                display: none !important;
            }
            body * {
                visibility: hidden;
            }
            .print\:shadow-none, .print\:shadow-none * {
                visibility: visible;
            }
            .print\:shadow-none {
                position: absolute;
                left: 0;
                top: 0;
                width: 100%;
                margin: 0;
                padding: 0;
                border: none !important;
                box-shadow: none !important;
            }

            /* A4 Print Layout */
            body.print-a4 @page { size: A4 portrait; margin: 15mm; }
            body.print-a4 .print\:shadow-none { font-size: 12pt; }
            
            /* Letter Print Layout */
            body.print-letter @page { size: letter portrait; margin: 15mm; }
            body.print-letter .print\:shadow-none { font-size: 12pt; }

            /* Thermal 80mm Print Layout */
            body.print-thermal80 @page { size: 80mm auto; margin: 0; }
            body.print-thermal80 .print\:shadow-none {
                width: 76mm; /* leaving 2mm margin on sides */
                left: 2mm;
                top: 2mm;
                font-size: 11px;
                color: #000;
            }
            body.print-thermal80 table th, body.print-thermal80 table td {
                padding: 4px 2px !important;
                font-size: 10px;
            }
            body.print-thermal80 h2 { font-size: 16px !important; }
            body.print-thermal80 h3 { font-size: 14px !important; }
            body.print-thermal80 .text-xl { font-size: 14px !important; }
            body.print-thermal80 .grid-cols-2 { grid-template-columns: 1fr; gap: 8px; }
            body.print-thermal80 img { height: 30px !important; margin-bottom: 5px; }

            /* Thermal 58mm Print Layout */
            body.print-thermal58 @page { size: 58mm auto; margin: 0; }
            body.print-thermal58 .print\:shadow-none {
                width: 54mm; /* leaving 2mm margin on sides */
                left: 2mm;
                top: 2mm;
                font-size: 10px;
                color: #000;
            }
            body.print-thermal58 table th, body.print-thermal58 table td {
                padding: 2px 1px !important;
                font-size: 9px;
            }
            body.print-thermal58 h2 { font-size: 14px !important; }
            body.print-thermal58 h3 { font-size: 12px !important; }
            body.print-thermal58 .text-xl { font-size: 12px !important; }
            body.print-thermal58 .grid-cols-2 { grid-template-columns: 1fr; gap: 4px; }
            body.print-thermal58 img { height: 24px !important; margin-bottom: 5px; }
            body.print-thermal58 .tracking-widest { letter-spacing: normal !important; }
            body.print-thermal58 .text-sm { font-size: 10px !important; }
            
            /* General thermal tweaks */
            body.print-thermal80 .border-b, body.print-thermal58 .border-b,
            body.print-thermal80 .border-t, body.print-thermal58 .border-t {
                border-color: #000 !important;
            }
            body.print-thermal80 span.bg-theme-success, body.print-thermal58 span.bg-theme-success,
            body.print-thermal80 span.bg-yellow-100, body.print-thermal58 span.bg-yellow-100,
            body.print-thermal80 span.bg-theme-error, body.print-thermal58 span.bg-theme-error {
                background: none !important;
                color: #000 !important;
                border: 1px solid #000 !important;
                padding: 2px 4px !important;
                font-size: 8px !important;
            }
            body.print-thermal80 .bg-theme-bg, body.print-thermal58 .bg-theme-bg {
                background: transparent !important;
                padding: 0 !important;
            }
            body.print-thermal80 .text-theme-text1, body.print-thermal58 .text-theme-text1,
            body.print-thermal80 .text-theme-text2, body.print-thermal58 .text-theme-text2 {
                color: #000 !important;
            }
        }
    </style>

    <!-- Payment Section -->
    <div id="payment-section" class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-6 max-w-4xl mx-auto print:hidden">
        
        <!-- Form Pembayaran -->
        <div class="bg-theme-card rounded-2xl border border-theme-border shadow-md shadow-sm p-8">
            <h3 class="text-lg font-black text-theme-text1 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Catat Pembayaran
            </h3>

            @if(session('success'))
                <div class="mb-6 p-4 bg-theme-success/20 text-emerald-600 rounded-xl text-sm font-bold border border-theme-success flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="mb-6 p-4 bg-theme-error/20 text-rose-600 rounded-xl text-sm font-bold border border-theme-error flex items-center gap-3">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    {{ session('error') }}
                </div>
            @endif

            @php
                $totalPiutang = $invoice->customer->invoices()->where('status', '!=', 'paid')->sum('remaining_amount');
            @endphp
            @if($totalPiutang <= 0)
                <div class="p-6 bg-theme-bg border border-theme-border rounded-2xl text-center">
                    <div class="w-12 h-12 bg-theme-success/40 text-emerald-600 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <p class="font-bold text-theme-text1">Semua Tagihan Sudah Lunas</p>
                    <p class="text-xs text-theme-text2 mt-1">Tidak ada sisa piutang untuk customer ini.</p>
                </div>
            @else
                <form action="{{ route('payments.store') }}" method="POST" class="space-y-5" x-data="{ amount: {{ $totalPiutang }} }">
                    @csrf
                    <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                    <input type="hidden" name="payment_date" value="{{ date('Y-m-d') }}">
                    <input type="hidden" name="payment_method" value="cash">

                    <div>
                        <label class="block text-xs font-black text-theme-text2 uppercase tracking-widest mb-2">Total Seluruh Piutang Customer</label>
                        <div class="text-2xl font-black text-theme-text1">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</div>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-theme-text2 uppercase tracking-widest mb-2">Nominal Uang Masuk</label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                <span class="text-theme-text2 font-bold">Rp</span>
                            </div>
                            <input 
                                type="number" 
                                name="amount" 
                                x-model="amount"
                                max="{{ $totalPiutang }}"
                                class="w-full pl-12 pr-4 py-3 bg-theme-bg border border-theme-border text-theme-text1 rounded-xl text-lg font-black focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none shadow-md shadow-sm"
                                required
                            >
                        </div>
                        <p class="text-[10px] font-bold text-theme-text2 mt-2">Maksimal: Rp {{ number_format($totalPiutang, 0, ',', '.') }}. Sistem otomatis mengalokasikan pembayaran ke nota terlama (FIFO).</p>
                    </div>

                    <div>
                        <label class="block text-xs font-black text-theme-text2 uppercase tracking-widest mb-2">Catatan (Opsional)</label>
                        <input type="text" name="notes" placeholder="Misal: Cicilan ke-1" class="w-full px-4 py-3 bg-theme-card border border-theme-border text-theme-text1 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none shadow-md shadow-sm">
                    </div>

                    <button type="submit" class="w-full py-3.5 bg-theme-success hover:bg-emerald-700 text-theme-text1 font-black rounded-xl shadow-lg shadow-emerald-600/20 transition-all transform hover:-translate-y-0.5">
                        SIMPAN PEMBAYARAN
                    </button>
                </form>
            @endif
        </div>

        <!-- Histori Pembayaran -->
        <div class="bg-theme-card rounded-2xl border border-theme-border shadow-md shadow-sm p-8">
            <h3 class="text-lg font-black text-theme-text1 mb-6 flex items-center gap-2">
                <svg class="w-5 h-5 text-theme-text2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Histori Pembayaran
            </h3>

            @if($invoice->payments->count() > 0)
                <div class="space-y-4">
                    @foreach($invoice->payments()->latest()->get() as $payment)
                        <div class="p-4 border border-theme-border bg-theme-bg rounded-2xl flex items-center justify-between">
                            <div>
                                <p class="text-xs font-black text-theme-text2 uppercase tracking-widest mb-1">{{ $payment->payment_date->format('d M Y') }}</p>
                                <p class="text-sm font-bold text-theme-text1">{{ $payment->payment_number }}</p>
                                @if($payment->notes)
                                    <p class="text-[10px] text-theme-text2 mt-1 italic">{{ $payment->notes }}</p>
                                @endif
                            </div>
                            <div class="text-right">
                                <p class="text-base font-black text-emerald-600">+ Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-12">
                    <div class="w-12 h-12 bg-theme-bg text-slate-300 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"/></svg>
                    </div>
                    <p class="text-sm font-bold text-theme-text2">Belum ada riwayat pembayaran.</p>
                </div>
            @endif
        </div>

    </div>

    @push('scripts')
    <script>
        function printNota(size) {
            document.body.classList.remove('print-a4', 'print-letter', 'print-thermal58', 'print-thermal80');
            document.body.classList.add('print-' + size);
            window.print();
        }
    </script>
    @endpush
</x-admin-layout>
