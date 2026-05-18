<x-admin-layout>
    <x-slot name="title">Daftar Pesanan</x-slot>
    <x-slot name="header">Manajemen Transaksi</x-slot>

    <div class="content-section">
        <div class="page-header">
            <div>
                <h2 class="page-title">Daftar Pesanan</h2>
                <p class="page-subtitle">Riwayat seluruh transaksi pesanan customer</p>
            </div>
            <a href="{{ route('orders.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Buat Transaksi
            </a>
        </div>

        <form action="{{ route('orders.index') }}" method="GET">
            <div class="card shadow-card" style="padding:1rem 1.25rem;">
                <div class="flex gap-3 items-center">
                    <div class="search-bar flex-1">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No. Order / Nama Customer...">
                    </div>
                    <button type="submit" class="btn btn-soft btn-sm">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('orders.index') }}" class="btn btn-ghost btn-sm">Reset</a>
                    @endif
                </div>
            </div>
        </form>

        <div class="card shadow-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No. Order / Tanggal</th>
                            <th>Customer</th>
                            <th class="text-right">Total Qty</th>
                            <th class="text-right" style="width:80px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td>
                                    <p class="font-semibold" style="color:var(--text-primary);">{{ $order->order_number }}</p>
                                    <p class="text-xs mt-0.5" style="color:var(--text-muted);">{{ $order->order_date->format('d M Y') }}</p>
                                </td>
                                <td>
                                    <p class="font-medium" style="color:var(--text-primary);">{{ $order->customer->nama_toko }}</p>
                                    <p class="text-xs" style="color:var(--text-muted);">{{ $order->customer->nama_pemilik }}</p>
                                </td>
                                <td class="text-right">
                                    <p class="font-bold" style="color:var(--text-primary);">{{ floatval($order->items->sum('quantity')) }}</p>
                                    <p class="text-xs" style="color:var(--text-muted);">{{ $order->items->count() }} produk</p>
                                </td>
                                <td class="text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('orders.show', $order) }}" class="icon-btn icon-btn-view" title="Lihat">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        <form action="{{ route('orders.destroy', $order) }}" method="POST"
                                              onsubmit="return confirm('Hapus pesanan {{ $order->order_number }}?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="icon-btn icon-btn-delete" title="Hapus">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-14" style="color:var(--text-muted);">
                                    <p class="font-medium">Belum ada pesanan</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(isset($orders) && method_exists($orders, 'hasPages') && $orders->hasPages())
                <div class="px-5 py-3" style="border-top:1px solid var(--border-soft);">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
