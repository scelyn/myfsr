<x-admin-layout>
    <x-slot name="title">Detail Piutang — {{ $invoice->invoice_number }}</x-slot>
    <x-slot name="header">Kelola Piutang Customer</x-slot>

    <div class="max-w-4xl content-section">
        <a href="{{ route('receivables.index') }}" class="back-link">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Piutang
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            {{-- Summary — derived from invoice --}}
            <div class="space-y-4">
                <section class="card shadow-card p-5">
                    <p class="form-label mb-1">Customer</p>
                    <p class="text-lg font-black" style="color:var(--text-primary);">{{ $invoice->customer->nama_toko }}</p>
                    <p class="text-sm mt-0.5" style="color:var(--text-secondary);">{{ $invoice->customer->nama_pemilik }}</p>

                    <div class="divider"></div>

                    <div class="space-y-3">
                        <div class="flex justify-between items-center">
                            <span class="form-label" style="margin-bottom:0;">Invoice</span>
                            <a href="{{ route('invoices.show', $invoice) }}" class="font-semibold text-sm hover:underline" style="color:var(--accent-primary);">
                                {{ $invoice->invoice_number }}
                                <svg class="w-3 h-3 inline-block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                            </a>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="form-label" style="margin-bottom:0;">Tanggal Invoice</span>
                            <span class="text-sm" style="color:var(--text-primary);">{{ $invoice->invoice_date->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="form-label" style="margin-bottom:0;">Total Tagihan</span>
                            <span class="font-semibold text-sm" style="color:var(--text-primary);">Rp {{ \App\Helpers\NumberHelper::format($invoice->total_amount) }}</span>
                        </div>
                        <div class="flex justify-between items-center">
                            <span class="form-label" style="margin-bottom:0;">Sudah Dibayar</span>
                            <span class="font-semibold text-sm" style="color:var(--color-success);">Rp {{ \App\Helpers\NumberHelper::format($invoice->paid_amount) }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-2" style="border-top:1px solid var(--border-soft);">
                            <span class="form-label" style="margin-bottom:0;">Sisa Piutang</span>
                            <span class="text-lg font-black" style="color:var(--color-danger);">Rp {{ \App\Helpers\NumberHelper::format($invoice->remaining_amount) }}</span>
                        </div>
                    </div>

                    <div class="mt-4">
                        @php $pct = $invoice->total_amount > 0 ? ($invoice->paid_amount / $invoice->total_amount) * 100 : 0; @endphp
                        <div class="flex justify-between text-xs mb-1.5">
                            <span style="color:var(--text-secondary);">Progres Pembayaran</span>
                            <span style="color:var(--color-success);">{{ number_format($pct, 0) }}%</span>
                        </div>
                        <div class="rounded-full h-2 overflow-hidden" style="background-color:var(--bg-surface);">
                            <div class="h-full rounded-full transition-all" style="width:{{ $pct }}%; background-color:var(--color-success);"></div>
                        </div>
                    </div>
                </section>

                <section class="card shadow-card p-5">
                    <p class="form-label mb-1">Status</p>
                    @if($invoice->is_overdue)
                        <span class="badge badge-danger">Overdue</span>
                    @elseif($invoice->status === 'partial')
                        <span class="badge badge-warning">Dicicil</span>
                    @elseif($invoice->status === 'paid')
                        <span class="badge badge-success">Lunas</span>
                    @else
                        <span class="badge badge-neutral">Belum Bayar</span>
                    @endif

                    <div class="mt-4 pt-4" style="border-top:1px solid var(--border-soft);">
                        <p class="form-label mb-1">Jatuh Tempo</p>
                        <p class="font-semibold"
                           style="color:{{ $invoice->is_overdue ? 'var(--color-danger)' : 'var(--text-primary)' }};">
                            {{ $invoice->due_date->format('d M Y') }}
                        </p>
                        @if($invoice->is_overdue)
                            <p class="text-xs mt-1 font-bold" style="color:var(--color-danger);">Terlambat {{ $invoice->days_overdue }} hari</p>
                        @endif
                    </div>

                    {{-- Cross-link to Invoice --}}
                    <div class="mt-4 pt-4" style="border-top:1px solid var(--border-soft);">
                        <a href="{{ route('invoices.show', $invoice) }}" class="btn btn-soft btn-sm w-full" style="justify-content:center;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            Buka Detail Invoice
                        </a>
                    </div>
                </section>
            </div>

            {{-- Payment history + Items --}}
            <div class="lg:col-span-2 space-y-4">
                <section class="card shadow-card overflow-hidden">
                    <div class="card-header"><h3>Histori Pembayaran</h3></div>
                    <div>
                        @forelse($invoice->payments->sortByDesc('payment_date') as $payment)
                            <div class="flex items-center justify-between px-5 py-3.5"
                                 style="border-bottom:1px solid var(--border-soft);">
                                <div>
                                    <p class="font-semibold text-sm" style="color:var(--text-primary);">
                                        {{ $payment->payment_date->format('d M Y') }}
                                    </p>
                                    <p class="text-xs mt-0.5 capitalize" style="color:var(--text-secondary);">
                                        {{ $payment->payment_method }}
                                        @if($payment->reference_number) · {{ $payment->reference_number }} @endif
                                        @if($payment->notes) · <span class="italic">{{ $payment->notes }}</span> @endif
                                    </p>
                                </div>
                                <p class="font-black" style="color:var(--color-success);">
                                    +Rp {{ \App\Helpers\NumberHelper::format($payment->amount) }}
                                </p>
                            </div>
                        @empty
                            <p class="text-center py-10 text-sm" style="color:var(--text-muted);">Belum ada pembayaran.</p>
                        @endforelse
                    </div>
                </section>

                {{-- Items from order --}}
                @if($invoice->order && $invoice->order->items->count() > 0)
                <section class="card shadow-card overflow-hidden">
                    <div class="card-header"><h3>Detail Barang</h3></div>
                    <div class="overflow-x-auto">
                        <table class="data-table">
                            <thead>
                                <tr>
                                    <th>Produk</th>
                                    <th class="text-center">Qty</th>
                                    <th class="text-right">Harga</th>
                                    <th class="text-right">Subtotal</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($invoice->order->items as $item)
                                    <tr>
                                        <td style="color:var(--text-primary);">{{ $item->product_name }}</td>
                                        <td class="text-center" style="color:var(--text-secondary);">{{ \App\Helpers\NumberHelper::format($item->quantity) }} {{ $item->product_unit }}</td>
                                        <td class="text-right" style="color:var(--text-secondary);">Rp {{ \App\Helpers\NumberHelper::format($item->unit_price) }}</td>
                                        <td class="text-right font-semibold" style="color:var(--text-primary);">Rp {{ \App\Helpers\NumberHelper::format($item->subtotal) }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr style="border-top:2px solid var(--border-soft);">
                                    <td colspan="3" class="text-right font-bold" style="color:var(--text-secondary);">Total</td>
                                    <td class="text-right font-black" style="color:var(--text-primary);">Rp {{ \App\Helpers\NumberHelper::format($invoice->total_amount) }}</td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </section>
                @endif
            </div>
        </div>
    </div>
</x-admin-layout>
