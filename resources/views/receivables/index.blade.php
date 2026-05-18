<x-admin-layout>
    <x-slot name="title">Monitoring Piutang</x-slot>
    <x-slot name="header">Kelola Piutang Customer</x-slot>

    <div class="content-section">
        {{-- Stats — live from invoices, no cache --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <x-stat-card
                title="Total Piutang Berjalan"
                value="Rp {{ \App\Helpers\NumberHelper::format($stats['total_outstanding']) }}"
                color="default"
            />
            <x-stat-card
                title="Jatuh Tempo (Overdue)"
                value="Rp {{ \App\Helpers\NumberHelper::format($stats['total_overdue']) }}"
                color="danger"
                caption="Perlu tindakan segera"
            />
            <x-stat-card
                title="Invoice Belum Lunas"
                value="{{ $stats['count_unpaid'] }} Dokumen"
                color="warning"
            />
        </div>

        {{-- Filter --}}
        <form action="{{ route('receivables.index') }}" method="GET">
            <div class="card shadow-card" style="padding:1rem 1.25rem;">
                <div class="flex flex-wrap gap-3 items-end">
                    <div class="form-group flex-1" style="min-width:180px;">
                        <label class="form-label">Customer</label>
                        <select name="customer_id" class="form-input">
                            <option value="">Semua Customer</option>
                            @foreach($customers as $customer)
                                <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>
                                    {{ $customer->nama_toko }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group w-40">
                        <label class="form-label">Status</label>
                        <select name="status" class="form-input">
                            <option value="">Semua Status</option>
                            <option value="unpaid"  {{ request('status') == 'unpaid'  ? 'selected' : '' }}>Belum Bayar</option>
                            <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Dicicil</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm" style="margin-bottom:0; align-self:flex-end;">Tampilkan</button>
                    @if(request('status') || request('customer_id'))
                        <a href="{{ route('receivables.index') }}" class="btn btn-ghost btn-sm" style="align-self:flex-end;">Reset</a>
                    @endif
                </div>
            </div>
        </form>

        {{-- Table — reads directly from invoices --}}
        <div class="card shadow-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Invoice / Customer</th>
                            <th>Tanggal</th>
                            <th>Jatuh Tempo</th>
                            <th class="text-right">Total</th>
                            <th class="text-right">Dibayar</th>
                            <th class="text-right">Sisa</th>
                            <th class="text-center">Status</th>
                            <th class="text-right" style="width:120px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $inv)
                            <tr style="{{ $inv->is_overdue ? 'background-color:rgba(153,27,27,0.04);' : '' }}">
                                <td>
                                    <p class="font-semibold" style="color:var(--text-primary);">{{ $inv->invoice_number }}</p>
                                    <p class="text-xs mt-0.5" style="color:var(--text-secondary);">{{ $inv->customer->nama_toko }}</p>
                                </td>
                                <td style="color:var(--text-muted);">
                                    {{ $inv->invoice_date->format('d/m/Y') }}
                                </td>
                                <td>
                                    <p class="{{ $inv->is_overdue ? 'font-bold' : '' }}"
                                       style="color:{{ $inv->is_overdue ? 'var(--color-danger)' : 'var(--text-primary)' }};">
                                        {{ $inv->due_date->format('d M Y') }}
                                    </p>
                                    @if($inv->is_overdue)
                                        <p class="text-xs font-bold uppercase mt-0.5" style="color:var(--color-danger);">Terlambat {{ $inv->days_overdue }} hari</p>
                                    @endif
                                </td>
                                <td class="text-right" style="color:var(--text-secondary);">
                                    Rp {{ \App\Helpers\NumberHelper::format($inv->total_amount) }}
                                </td>
                                <td class="text-right" style="color:var(--color-success);">
                                    Rp {{ \App\Helpers\NumberHelper::format($inv->paid_amount) }}
                                </td>
                                <td class="text-right font-bold" style="color:var(--text-primary);">
                                    Rp {{ \App\Helpers\NumberHelper::format($inv->remaining_amount) }}
                                </td>
                                <td class="text-center">
                                    @if($inv->is_overdue)
                                        <span class="badge badge-danger">Overdue</span>
                                    @elseif($inv->status === 'partial')
                                        <span class="badge badge-warning">Dicicil</span>
                                    @else
                                        <span class="badge badge-neutral">Belum Bayar</span>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('receivables.show', $inv) }}" class="btn btn-ghost btn-sm" title="Detail Piutang">
                                            Detail
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-16" style="color:var(--text-secondary);">
                                    @if(request('status') === 'partial')
                                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--text-muted);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <p class="font-medium" style="color:var(--text-primary);">Tidak ada nota dengan status dicicil</p>
                                        <p class="text-xs mt-1">Semua transaksi saat ini berstatus belum dibayar penuh atau sudah lunas.</p>
                                        <p class="text-xs mt-0.5" style="color:var(--text-muted);">Nota dengan pembayaran sebagian akan muncul di sini.</p>
                                    @elseif(request('status') === 'unpaid')
                                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--text-muted);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        <p class="font-medium" style="color:var(--text-primary);">Tidak ada nota dengan status belum bayar</p>
                                        <p class="text-xs mt-1">Semua invoice sudah memiliki pembayaran atau sudah lunas.</p>
                                    @elseif(request('customer_id'))
                                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--text-muted);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                        <p class="font-medium" style="color:var(--text-primary);">Customer ini tidak memiliki piutang aktif</p>
                                        <p class="text-xs mt-1">Semua tagihan customer ini sudah lunas.</p>
                                    @else
                                        <svg class="w-8 h-8 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:var(--color-success);"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                        <p class="font-medium" style="color:var(--text-primary);">Semua tagihan sudah lunas!</p>
                                        <p class="text-xs mt-1">Tidak ada piutang yang belum dibayar.</p>
                                    @endif
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($invoices->hasPages())
                <div class="px-5 py-3" style="border-top:1px solid var(--border-soft);">
                    {{ $invoices->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
