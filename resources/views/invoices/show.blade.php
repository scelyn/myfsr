<x-admin-layout>
    <x-slot name="title">Invoice #{{ $invoice->invoice_number }}</x-slot>
    <x-slot name="header">Detail Invoice</x-slot>

    <div class="max-w-5xl mx-auto content-section">

        <div class="flex items-center justify-between print:hidden">
            <a href="{{ route('orders.index') }}" class="back-link" style="margin-bottom:0;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Pesanan
            </a>

            <div class="flex items-center gap-3 relative" x-data="{ printOpen: false }">
                <button @click="printOpen = !printOpen" @click.away="printOpen = false" class="btn btn-ghost">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    Cetak Nota
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                </button>
                <div x-show="printOpen" x-transition.opacity class="absolute right-0 top-full mt-1 w-48 card shadow-elevated z-50 overflow-hidden py-1" style="display:none;">
                    <a href="{{ URL::signedRoute('invoices.pdf', $invoice->id) }}" target="_blank" class="block px-4 py-2.5 text-sm hover:bg-[#f0f4f8] transition-colors" style="color:var(--text-primary); border-bottom:1px solid var(--border-soft);">Unduh PDF</a>
                    <button onclick="printNota('a4')"      class="w-full text-left px-4 py-2.5 text-sm hover:bg-[#f0f4f8] transition-colors" style="color:var(--text-primary);">Print Ukuran A4</button>
                    <button onclick="printNota('letter')"  class="w-full text-left px-4 py-2.5 text-sm hover:bg-[#f0f4f8] transition-colors" style="color:var(--text-primary);">Print Ukuran Letter</button>
                    <button onclick="printNota('thermal80')" class="w-full text-left px-4 py-2.5 text-sm hover:bg-[#f0f4f8] transition-colors" style="color:var(--text-primary);">Print Thermal 80mm</button>
                    <button onclick="printNota('thermal58')" class="w-full text-left px-4 py-2.5 text-sm hover:bg-[#f0f4f8] transition-colors" style="color:var(--text-primary);">Print Thermal 58mm</button>
                </div>

                @php
                    $waText  = "Halo Bapak/Ibu " . $invoice->customer->nama_pemilik . " (" . $invoice->customer->nama_toko . "),\n\n";
                    $waText .= "Berikut invoice terbaru Anda.\n\nInvoice:\n" . $invoice->invoice_number . "\n\n";
                    $waText .= "Belanja Hari Ini:\nRp " . \App\Helpers\NumberHelper::format($invoice->total_amount) . "\n\n";
                    if ($previous_tunggakan > 0) { $waText .= "Tunggakan Sebelumnya:\nRp " . \App\Helpers\NumberHelper::format($previous_tunggakan) . "\n\n"; }
                    $waText .= "TOTAL TAGIHAN:\nRp " . \App\Helpers\NumberHelper::format($invoice->total_amount + $previous_tunggakan) . "\n\n";
                    $waText .= "Link Invoice:\n" . URL::signedRoute('invoices.pdf', $invoice->id) . "\n\nTerima kasih.";
                    $waUrl   = "https://wa.me/" . preg_replace('/[^0-9]/', '', $invoice->customer->no_whatsapp) . "?text=" . urlencode($waText);
                @endphp
                <a href="{{ $waUrl }}" target="_blank" class="btn btn-soft">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/></svg>
                    Share WA
                </a>

                {{-- Cross-link: Invoice → Receivable --}}
                @if($invoice->remaining_amount > 0 && $invoice->status !== 'paid')
                <a href="{{ route('receivables.show', $invoice) }}" class="btn btn-ghost">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                    Lihat di Piutang
                </a>
                @endif
            </div>
        </div>

        <x-print-document size="a4" class="card shadow-card p-8">
            @if($previous_tunggakan > 0)
            <div class="mb-6 p-4 rounded-xl flex items-start gap-3 print:hidden"
                 style="background-color:var(--color-warning-bg); border:1px solid rgba(245,158,11,0.25);">
                <svg class="w-5 h-5 shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--color-warning);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                <p class="text-sm font-medium" style="color:var(--color-warning);">Customer memiliki tunggakan sebesar <span class="font-bold">Rp {{ \App\Helpers\NumberHelper::format($previous_tunggakan) }}</span></p>
            </div>
            @endif

            {{-- ═══════════════════════════════════════════════════
                 SECTION 1: INVOICE HEADER (TABLE-BASED)
                 ═══════════════════════════════════════════════════ --}}
            <div class="invoice-header" style="padding-bottom:1.5rem; margin-bottom:2rem; border-bottom:2px solid var(--border-soft);">
                <table class="invoice-layout-table">
                    <tr>
                        <td style="width:50%; vertical-align:top;">
                            <img src="{{ asset('images/logo.png') }}" alt="SIPEDIS" style="height:48px; width:auto; object-fit:contain; display:block; margin-bottom:6px;">
                            <p style="font-size:0.8125rem; color:var(--text-muted); margin:0;">Enterprise Management System</p>
                        </td>
                        <td style="width:50%; text-align:right; vertical-align:top;">
                            <h2 style="font-size:1.5rem; font-weight:900; color:var(--text-primary); margin:0;">INVOICE</h2>
                            <p style="font-size:0.875rem; font-weight:700; color:var(--text-secondary); margin-top:4px;">#{{ $invoice->invoice_number }}</p>
                            {{-- ⚠️ HIGH-RISK: bg-theme-success / bg-yellow-100 / bg-theme-error class names targeted by thermal print CSS --}}
                            @if($invoice->status == 'paid')
                                <span class="invoice-status-badge bg-theme-success" style="display:inline-block; margin-top:12px; padding:4px 12px; font-size:0.6875rem; font-weight:800; border-radius:99px; text-transform:uppercase; letter-spacing:0.1em; color:var(--color-success); border:1px solid var(--color-success-border);">LUNAS</span>
                            @elseif($invoice->status == 'partial')
                                <span class="invoice-status-badge bg-yellow-100" style="display:inline-block; margin-top:12px; padding:4px 12px; font-size:0.6875rem; font-weight:800; border-radius:99px; text-transform:uppercase; letter-spacing:0.1em; color:var(--color-warning);">DIBAYAR SEBAGIAN</span>
                            @else
                                <span class="invoice-status-badge bg-theme-error" style="display:inline-block; margin-top:12px; padding:4px 12px; font-size:0.6875rem; font-weight:800; border-radius:99px; text-transform:uppercase; letter-spacing:0.1em; color:var(--color-danger);">BELUM DIBAYAR</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            {{-- ═══════════════════════════════════════════════════
                 SECTION 2: CUSTOMER + META INFO (TABLE-BASED)
                 ═══════════════════════════════════════════════════ --}}
            <div class="invoice-meta" style="margin-bottom:2rem;">
                <table class="invoice-layout-table">
                    <tr>
                        <td style="width:55%; vertical-align:top; padding-right:20px;">
                            <p class="form-label" style="margin-bottom:6px;">Ditagihkan Kepada:</p>
                            <p style="font-size:1.125rem; font-weight:700; color:var(--text-primary); margin:0 0 4px;">{{ $invoice->customer->nama_toko }}</p>
                            <p style="font-size:0.875rem; color:var(--text-secondary); margin:0 0 2px;">{{ $invoice->customer->nama_pemilik }}</p>
                            <p style="font-size:0.875rem; color:var(--text-secondary); margin:0 0 8px;">{{ $invoice->customer->alamat_pasar }}</p>
                            <p style="font-size:0.875rem; color:var(--text-secondary); margin:0; display:flex; align-items:center; gap:6px;">
                                <svg class="print-hide-icon" style="width:16px; height:16px; flex-shrink:0;" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/></svg>
                                {{ $invoice->customer->no_whatsapp }}
                            </p>
                        </td>
                        <td style="width:45%; vertical-align:top;">
                            <div style="background-color:var(--bg-surface); border:1px solid var(--border-soft); border-radius:12px; padding:1.25rem;">
                                <table class="invoice-layout-table">
                                    <tr>
                                        <td style="width:50%; vertical-align:top; padding-bottom:12px;">
                                            <p class="form-label" style="margin-bottom:4px;">Tanggal Order</p>
                                            <p style="font-weight:600; font-size:0.875rem; color:var(--text-primary); margin:0;">{{ $invoice->order->order_date->format('d/m/Y') }}</p>
                                        </td>
                                        <td style="width:50%; vertical-align:top; padding-bottom:12px;">
                                            <p class="form-label" style="margin-bottom:4px;">Jatuh Tempo</p>
                                            <p style="font-weight:600; font-size:0.875rem; color:var(--text-primary); margin:0;">{{ $invoice->due_date->format('d/m/Y') }}</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2" style="vertical-align:top;">
                                            <p class="form-label" style="margin-bottom:4px;">ID Order</p>
                                            <p style="font-weight:600; font-size:0.875rem; color:var(--text-primary); margin:0;">{{ $invoice->order->order_number }}</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            {{-- ═══════════════════════════════════════════════════
                 SECTION 3: PRODUCT TABLE (FIXED LAYOUT)
                 ═══════════════════════════════════════════════════ --}}
            <div class="invoice-items" style="margin-bottom:2rem;">
                <table class="invoice-product-table">
                    <thead>
                        <tr style="border-bottom:2px solid var(--border-soft);">
                            <th class="col-no">No</th>
                            <th class="col-desc">Deskripsi Barang</th>
                            <th class="col-qty">Qty</th>
                            <th class="col-price">Harga Satuan</th>
                            <th class="col-subtotal">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($invoice->order->items as $item)
                            <tr style="border-bottom:1px solid var(--border-soft);">
                                <td class="col-no">{{ $loop->iteration }}</td>
                                <td class="col-desc" style="font-weight:600; color:var(--text-primary);">{{ $item->product_name }}</td>
                                <td class="col-qty" style="color:var(--text-primary);">{{ floatval($item->quantity) }} <span style="font-size:0.75rem; color:var(--text-muted);">{{ $item->product_unit }}</span></td>
                                <td class="col-price currency" style="color:var(--text-secondary);">Rp {{ \App\Helpers\NumberHelper::format($item->unit_price) }}</td>
                                <td class="col-subtotal currency" style="font-weight:600; color:var(--text-primary);">Rp {{ \App\Helpers\NumberHelper::format($item->subtotal) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            {{-- ═══════════════════════════════════════════════════
                 SECTION 4: TOTALS (TABLE-BASED, ZERO OVERLAP)
                 ═══════════════════════════════════════════════════ --}}
            <div class="invoice-total-wrapper">
                <table class="invoice-total-anchor">
                    <tr>
                        <td class="spacer-col"></td>
                        <td class="total-col">
                            <div style="background-color:var(--bg-surface); border:1px solid var(--border-soft); border-radius:12px; padding:1.25rem;" class="invoice-total-card">
                                <table class="invoice-total-table">
                                    <tr>
                                        <td colspan="2" class="total-section-header">Rincian Tagihan</td>
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
                                        <td class="label-col total-row-label">Total Tagihan</td>
                                        <td class="value-col total-row-value currency">Rp {{ \App\Helpers\NumberHelper::format($invoice->total_amount + $previous_tunggakan) }}</td>
                                    </tr>
                                    @if($invoice->paid_amount > 0)
                                    <tr class="total-row-success">
                                        <td class="label-col total-row-label">Sudah Dibayar</td>
                                        <td class="value-col total-row-value currency">- Rp {{ \App\Helpers\NumberHelper::format($invoice->paid_amount) }}</td>
                                    </tr>
                                    <tr class="total-row-remaining {{ $invoice->remaining_amount > 0 ? 'total-row-danger' : 'total-row-success' }}">
                                        <td class="label-col total-row-label">Sisa Tagihan</td>
                                        <td class="value-col total-row-value currency">Rp {{ \App\Helpers\NumberHelper::format($invoice->remaining_amount) }}</td>
                                    </tr>
                                    @endif
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>

            {{-- ═══════════════════════════════════════════════════
                 SECTION 5: FOOTER
                 ═══════════════════════════════════════════════════ --}}
            <div class="invoice-footer">
                <p>Terima kasih atas kepercayaannya.</p>
                <p>Pembayaran dapat ditransfer ke Rekening BCA: 1234567890 a.n MyFSR Semesta</p>
            </div>
        </x-print-document>
    </div>

    <div id="payment-section" class="mt-8 grid grid-cols-1 lg:grid-cols-2 gap-5 max-w-5xl mx-auto print:hidden">
        <section class="card shadow-card p-6">
            <h3 class="flex items-center gap-2 mb-5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--color-success);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Catat Pembayaran
            </h3>
            @php $totalPiutang = $invoice->customer->invoices()->where('status', '!=', 'paid')->sum('remaining_amount'); @endphp
            @if($totalPiutang <= 0)
                <div class="text-center py-10 rounded-xl" style="background-color:var(--color-success-bg); border:1px solid var(--color-success-border);">
                    <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--color-success);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                    <p class="font-bold" style="color:var(--color-success);">Semua Tagihan Sudah Lunas</p>
                </div>
            @else
                {{-- ⚠️ CRITICAL: all hidden fields + x-model="amount" preserved --}}
                <form action="{{ route('payments.store') }}" method="POST" class="space-y-4" x-data="{ amount: {{ $totalPiutang }} }">
                    @csrf
                    <input type="hidden" name="invoice_id"     value="{{ $invoice->id }}">
                    <input type="hidden" name="payment_date"   value="{{ date('Y-m-d') }}">
                    <input type="hidden" name="payment_method" value="cash">
                    <div>
                        <p class="form-label mb-1">Total Seluruh Piutang Customer</p>
                        <p class="text-2xl font-black" style="color:var(--text-primary);">Rp {{ \App\Helpers\NumberHelper::format($totalPiutang) }}</p>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Nominal Uang Masuk</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold" style="color:var(--text-muted);">Rp</span>
                            <input type="number" name="amount" x-model="amount" max="{{ $totalPiutang }}" required class="form-input pl-9 text-lg font-black">
                        </div>
                        <p class="text-xs" style="color:var(--text-muted);">Maks: Rp {{ \App\Helpers\NumberHelper::format($totalPiutang) }}. Sistem otomatis alokasi FIFO.</p>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Catatan (Opsional)</label>
                        <input type="text" name="notes" placeholder="Misal: Cicilan ke-1" class="form-input">
                    </div>
                    <button type="submit" class="btn btn-primary w-full" style="justify-content:center;">SIMPAN PEMBAYARAN</button>
                </form>
            @endif
        </section>

        <section class="card shadow-card overflow-hidden">
            <div class="card-header"><h3>Histori Pembayaran</h3></div>
            @if($invoice->payments->count() > 0)
                <div>
                    @foreach($invoice->payments()->latest()->get() as $payment)
                        <div class="flex items-center justify-between px-5 py-4" style="border-bottom:1px solid var(--border-soft);">
                            <div>
                                <p class="form-label mb-0.5">{{ $payment->payment_date->format('d M Y') }}</p>
                                <p class="text-sm font-semibold" style="color:var(--text-primary);">{{ $payment->payment_number }}</p>
                                @if($payment->notes)<p class="text-xs italic mt-0.5" style="color:var(--text-muted);">{{ $payment->notes }}</p>@endif
                            </div>
                            <p class="font-black" style="color:var(--color-success);">+ Rp {{ \App\Helpers\NumberHelper::format($payment->amount) }}</p>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="text-center py-12 text-sm" style="color:var(--text-muted);">Belum ada riwayat pembayaran.</p>
            @endif
        </section>
    </div>

    {{-- ⚠️ HIGH-RISK: printNota() JS function — must be preserved exactly --}}
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
