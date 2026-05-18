<x-admin-layout>
    <x-slot name="title">Histori Invoice</x-slot>
    <x-slot name="header">Generate Nota Customer</x-slot>

    <div class="content-section">
        <div class="page-header">
            <div>
                <h2 class="page-title">Histori Invoice</h2>
                <p class="page-subtitle">Seluruh nota tagihan yang telah dibuat</p>
            </div>
        </div>

        <form action="{{ route('invoices.index') }}" method="GET">
            <div class="card shadow-card" style="padding:1rem 1.25rem;">
                <div class="flex gap-3 items-center">
                    <div class="search-bar flex-1">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Invoice atau nama toko...">
                    </div>
                    <button type="submit" class="btn btn-soft btn-sm">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('invoices.index') }}" class="btn btn-ghost btn-sm">Reset</a>
                    @endif
                </div>
            </div>
        </form>

        <div class="card shadow-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No. Invoice</th>
                            <th>Tanggal</th>
                            <th>Customer</th>
                            <th class="text-right">Total Tagihan</th>
                            <th class="text-right">Sisa Tagihan</th>
                            <th class="text-center">Status</th>
                            <th class="text-center" style="width:60px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($invoices as $invoice)
                            <tr>
                                <td class="font-semibold" style="color:var(--text-primary);">{{ $invoice->invoice_number }}</td>
                                <td style="color:var(--text-muted);">{{ $invoice->created_at->format('d/m/Y') }}</td>
                                <td>
                                    <p class="font-medium" style="color:var(--text-primary);">{{ $invoice->customer->nama_toko }}</p>
                                    <p class="text-xs" style="color:var(--text-muted);">{{ $invoice->customer->nama_pemilik }}</p>
                                </td>
                                <td class="text-right font-medium" style="color:var(--text-primary);">
                                    Rp {{ \App\Helpers\NumberHelper::format($invoice->total_amount) }}
                                </td>
                                <td class="text-right font-bold"
                                    style="color:{{ $invoice->remaining_amount > 0 ? 'var(--color-danger)' : 'var(--color-success)' }};">
                                    Rp {{ \App\Helpers\NumberHelper::format($invoice->remaining_amount) }}
                                </td>
                                <td class="text-center">
                                    @if($invoice->status == 'paid')
                                        <span class="badge badge-success">Lunas</span>
                                    @elseif($invoice->status == 'partial')
                                        <span class="badge badge-warning">Sebagian</span>
                                    @else
                                        <span class="badge badge-danger">Belum</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <a href="{{ route('invoices.show', $invoice) }}" class="icon-btn icon-btn-view" title="Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-14" style="color:var(--text-muted);">
                                    <p class="font-medium">Belum ada invoice</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(isset($invoices) && method_exists($invoices, 'hasPages') && $invoices->hasPages())
                <div class="px-5 py-3" style="border-top:1px solid var(--border-soft);">
                    {{ $invoices->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
