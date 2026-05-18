<x-admin-layout>
    <x-slot name="title">Nota Transaksi {{ $order->order_number }}</x-slot>
    <x-slot name="header">Detail Transaksi</x-slot>

    <div class="max-w-4xl mx-auto content-section">
        {{-- Actions --}}
        <div class="page-header print:hidden">
            <a href="{{ route('orders.index') }}" class="back-link" style="margin-bottom:0;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Kembali ke Daftar
            </a>
            <button onclick="window.print()" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                Print Transaksi
            </button>
        </div>

        {{-- Nota Card --}}
        <section class="card shadow-card p-8 print:shadow-none print:border-none print:p-0">
            {{-- Header --}}
            <div class="flex justify-between items-start pb-6 mb-8" style="border-bottom:2px solid var(--border-medium);">
                <div>
                    <h2 class="text-2xl font-black uppercase tracking-widest" style="color:var(--text-primary);">Transaksi Pesanan</h2>
                    <p class="text-sm font-bold mt-1" style="color:var(--text-secondary);">#{{ $order->order_number }}</p>
                </div>
                <div class="text-right">
                    <p class="form-label mb-1">Tanggal</p>
                    <p class="font-bold" style="color:var(--text-primary);">{{ $order->order_date->format('d F Y') }}</p>
                </div>
            </div>

            {{-- Info grid --}}
            <div class="grid grid-cols-2 gap-6 mb-8">
                <div>
                    <p class="form-label mb-2">Customer</p>
                    <div class="rounded-xl p-4" style="background-color:var(--bg-surface); border:1px solid var(--border-soft);">
                        <p class="text-lg font-black" style="color:var(--text-primary);">{{ $order->customer->nama_toko }}</p>
                        <p class="text-sm mt-1" style="color:var(--text-secondary);">{{ $order->customer->nama_pemilik }}</p>
                        <p class="text-sm mt-1" style="color:var(--text-secondary);">{{ $order->customer->no_whatsapp }}</p>
                        @if($order->customer->alamat_pasar)
                            <p class="text-sm mt-1" style="color:var(--text-secondary);">{{ $order->customer->alamat_pasar }}</p>
                        @endif
                    </div>
                </div>
                <div class="flex flex-col justify-end text-right">
                    <p class="form-label mb-1">Admin Penerbit</p>
                    <p class="font-bold" style="color:var(--text-primary);">{{ $order->createdBy->name }}</p>
                </div>
            </div>

            {{-- Items table --}}
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="w-2/3">Produk</th>
                            <th class="text-right">Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <p class="font-semibold" style="color:var(--text-primary);">{{ $item->product_name }}</p>
                                    @if($item->notes)
                                        <p class="text-xs mt-0.5 italic" style="color:var(--text-secondary);">{{ $item->notes }}</p>
                                    @endif
                                </td>
                                <td class="text-right">
                                    <span class="font-bold" style="color:var(--text-primary);">{{ floatval($item->quantity) }}</span>
                                    <span class="text-xs ml-1" style="color:var(--text-secondary);">{{ $item->product_unit }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <td class="text-right form-label">Total Produk</td>
                            <td class="text-right">
                                <span class="text-xl font-black" style="color:var(--text-primary);">
                                    {{ floatval($order->items->sum('quantity')) }}
                                </span>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if($order->notes)
                <div class="mt-6 p-4 rounded-xl" style="background-color:var(--bg-surface); border:1px solid var(--border-soft);">
                    <p class="form-label mb-1">Catatan</p>
                    <p class="text-sm italic" style="color:var(--text-secondary);">{{ $order->notes }}</p>
                </div>
            @endif
        </section>
    </div>
</x-admin-layout>
