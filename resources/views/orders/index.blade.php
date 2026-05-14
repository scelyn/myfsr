<x-admin-layout>
    <x-slot name="title">Daftar Transaksi Pesanan</x-slot>
    <x-slot name="header">Manajemen Transaksi</x-slot>

    <div class="space-y-6">
        <!-- Top Actions & Filters -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 bg-[#11212D] p-6 rounded-2xl border border-[#253745] shadow-md shadow-black/20">
            <form action="{{ route('orders.index') }}" method="GET" class="flex-1 grid grid-cols-1 md:grid-cols-2 gap-4 items-end">
                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-[#9BA8AB] uppercase tracking-widest ml-1">Cari Transaksi</label>
                    <div class="relative group">
                        <span class="absolute inset-y-0 left-3 flex items-center pointer-events-none text-[#4A5C6A] group-focus-within:text-[#CCD0CF] transition-colors">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        </span>
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="Cari No. Order / Nama Customer..." 
                            class="w-full pl-9 pr-4 py-2.5 bg-[#06141B] border border-[#253745] text-[#CCD0CF] rounded-xl text-sm focus:ring-2 focus:ring-[#9BA8AB]/20 focus:border-[#9BA8AB] transition-all placeholder-[#4A5C6A] outline-none"
                        >
                    </div>
                </div>

                <div class="flex gap-2">
                    <button type="submit" class="flex-1 bg-[#253745] hover:bg-[#4A5C6A] text-[#CCD0CF] hover:text-theme-text1 px-4 py-2.5 rounded-xl text-sm font-bold transition-all shadow-md shadow-black/20">
                        Cari Data
                    </button>
                    <a href="{{ route('orders.index') }}" class="p-2.5 bg-[#06141B] border border-[#253745] text-[#4A5C6A] rounded-xl hover:text-[#9BA8AB] hover:border-[#4A5C6A] transition-all" title="Reset Pencarian">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/></svg>
                    </a>
                </div>
            </form>
            
            <a href="{{ route('orders.create') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#CCD0CF] hover:bg-theme-card text-[#06141B] text-sm font-black rounded-xl shadow-lg shadow-[#CCD0CF]/10 transition-all transform hover:-translate-y-0.5 whitespace-nowrap">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                <span>BUAT TRANSAKSI</span>
            </a>
        </div>

        <!-- Table Card -->
        <div class="bg-[#11212D] rounded-2xl border border-[#253745] shadow-md shadow-black/20 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-[#06141B]/50 border-b border-[#253745]">
                            <th class="px-8 py-4 text-[10px] font-bold text-[#9BA8AB] uppercase tracking-widest">Detail Transaksi</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-[#9BA8AB] uppercase tracking-widest">Customer</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-[#9BA8AB] uppercase tracking-widest">Total Qty Produk</th>
                            <th class="px-8 py-4 text-[10px] font-bold text-[#9BA8AB] uppercase tracking-widest text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-[#253745]">
                        @forelse($orders as $order)
                            <tr class="hover:bg-[#253745]/20 transition-colors group">
                                <td class="px-8 py-5">
                                    <div class="text-sm font-black text-[#CCD0CF]">{{ $order->order_number }}</div>
                                    <div class="flex items-center gap-2 mt-1">
                                        <svg class="w-3.5 h-3.5 text-[#4A5C6A]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                        <span class="text-[11px] font-bold text-[#9BA8AB]">{{ $order->order_date->format('d M Y') }}</span>
                                    </div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="text-sm font-bold text-[#CCD0CF]">{{ $order->customer->nama_toko }}</div>
                                    <div class="text-[11px] text-[#4A5C6A] font-medium mt-0.5">PIC: {{ $order->customer->nama_pemilik }}</div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="text-sm font-black text-[#CCD0CF]">{{ $order->items->sum('quantity') }} Items</div>
                                    <div class="text-[10px] font-bold text-[#9BA8AB] mt-0.5">{{ $order->items->count() }} Macam Produk</div>
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <div class="flex items-center justify-end gap-2 opacity-50 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('orders.show', $order) }}" class="p-2 bg-[#06141B] text-[#9BA8AB] hover:text-[#CCD0CF] hover:bg-[#253745] border border-[#253745] rounded-xl transition-all" title="Lihat Detail Transaksi">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        <form action="{{ route('orders.destroy', $order) }}" method="POST" onsubmit="return confirm('Hapus riwayat transaksi ini secara permanen?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="p-2 bg-[#06141B] text-[#4A5C6A] hover:text-theme-errorText hover:bg-theme-error/10 border border-[#253745] hover:border-red-400/30 rounded-xl transition-all" title="Hapus Transaksi">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-8 py-24 text-center">
                                    <div class="flex flex-col items-center">
                                        <div class="w-20 h-20 bg-[#06141B] border border-[#253745] rounded-full flex items-center justify-center text-[#4A5C6A] mb-5">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-[#CCD0CF]">Belum ada data transaksi</h3>
                                        <p class="text-[#9BA8AB] text-sm mt-1">Transaksi yang Anda buat akan muncul di sini.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div class="px-8 py-6 border-t border-[#253745] bg-[#06141B]/50">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
