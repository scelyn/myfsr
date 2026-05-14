<x-admin-layout>
    <x-slot name="title">Nota Transaksi {{ $order->order_number }}</x-slot>
    <x-slot name="header">Detail Transaksi</x-slot>

    <div class="space-y-8 max-w-5xl mx-auto">
        <!-- Header Actions -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4 print:hidden">
            <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#9BA8AB] hover:text-[#CCD0CF] transition-colors group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                <span>Kembali ke Daftar</span>
            </a>
            
            <div class="flex items-center gap-3">
                <button onclick="window.print()" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#CCD0CF] hover:bg-theme-card text-[#06141B] text-sm font-bold rounded-xl transition-all shadow-lg">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                    <span>Print Transaksi</span>
                </button>
            </div>
        </div>

        <!-- Nota Card -->
        <div class="bg-theme-card rounded-2xl border border-theme-border shadow-md shadow-black/20 overflow-hidden p-10 print:shadow-none print:border-none print:p-0">
            <!-- Header -->
            <div class="flex justify-between items-start border-b-2 border-theme-border pb-6 mb-8">
                <div>
                    <h2 class="text-3xl font-black text-[#06141B] uppercase tracking-widest">TRANSAKSI PESANAN</h2>
                    <p class="text-lg font-bold text-[#4A5C6A] mt-1">#{{ $order->order_number }}</p>
                </div>
                <div class="text-right">
                    <p class="text-sm font-bold text-theme-text2 uppercase tracking-widest">Tanggal</p>
                    <p class="text-base font-bold text-[#06141B]">{{ $order->order_date->format('d F Y') }}</p>
                </div>
            </div>

            <!-- Customer Info -->
            <div class="grid grid-cols-2 gap-8 mb-10">
                <div>
                    <p class="text-[10px] font-black text-theme-text2 uppercase tracking-widest mb-3">Customer</p>
                    <div class="p-5 bg-theme-bg rounded-2xl border border-theme-border">
                        <p class="text-xl font-black text-[#06141B]">{{ $order->customer->nama_toko }}</p>
                        <p class="text-sm font-semibold text-theme-text1 mt-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-theme-text2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            {{ $order->customer->nama_pemilik }}
                        </p>
                        <p class="text-sm text-theme-text2 mt-1.5 flex items-center gap-2">
                            <svg class="w-4 h-4 text-theme-text2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"/></svg>
                            {{ $order->customer->no_whatsapp }}
                        </p>
                        @if($order->customer->alamat_pasar)
                            <p class="text-sm text-theme-text2 mt-1.5 flex items-start gap-2">
                                <svg class="w-4 h-4 text-theme-text2 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                <span class="leading-relaxed">{{ $order->customer->alamat_pasar }}</span>
                            </p>
                        @endif
                    </div>
                </div>
                <div class="text-right flex flex-col justify-end">
                    <p class="text-[10px] font-black text-theme-text2 uppercase tracking-widest mb-3">Admin Penerbit</p>
                    <p class="text-sm font-bold text-[#06141B]">{{ $order->createdBy->name }}</p>
                </div>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead class="border-y-2 border-theme-border bg-theme-bg/50">
                        <tr>
                            <th class="px-5 py-4 text-[10px] font-black text-theme-text2 uppercase tracking-widest w-2/3">Produk</th>
                            <th class="px-5 py-4 text-[10px] font-black text-theme-text2 uppercase tracking-widest text-right">Qty</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @foreach($order->items as $item)
                            <tr>
                                <td class="px-5 py-5">
                                    <div class="text-sm font-bold text-[#06141B]">{{ $item->product_name }}</div>
                                    @if($item->notes)
                                        <div class="text-[11px] text-theme-text2 mt-1 italic">{{ $item->notes }}</div>
                                    @endif
                                </td>
                                <td class="px-5 py-5 text-right">
                                    <span class="text-sm font-bold text-theme-text1">{{ $item->quantity }}</span>
                                    <span class="text-[11px] font-medium text-theme-text2 ml-1">{{ $item->product_unit }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="border-t-2 border-[#06141B]">
                        <tr>
                            <td class="px-5 py-6 text-right text-xs font-black text-theme-text2 uppercase tracking-widest">Total Produk</td>
                            <td class="px-5 py-6 text-right">
                                <div class="text-2xl font-black text-[#06141B]">{{ $order->items->sum('quantity') }}</div>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            @if($order->notes)
                <div class="mt-8 p-5 bg-theme-bg rounded-2xl border border-theme-border">
                    <p class="text-[10px] font-black text-theme-text2 uppercase tracking-widest mb-1.5">Catatan</p>
                    <p class="text-sm font-medium text-theme-text1 italic">{{ $order->notes }}</p>
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
