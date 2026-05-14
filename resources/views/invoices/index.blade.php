<x-admin-layout>
    <x-slot name="title">Histori Invoice</x-slot>
    <x-slot name="header">Histori Invoice</x-slot>

    <div class="space-y-6 max-w-7xl mx-auto">
        <!-- Search & Filter Bar -->
        <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
            <form action="{{ route('invoices.index') }}" method="GET" class="w-full md:w-96 relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="w-5 h-5 text-theme-text2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                </div>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari No Invoice atau Nama Toko..." class="w-full pl-10 pr-4 py-2.5 bg-theme-card border border-theme-border text-theme-text1 rounded-xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all outline-none shadow-md shadow-sm">
            </form>
        </div>

        <!-- Invoices Table -->
        <div class="bg-theme-card rounded-2xl border border-theme-border shadow-md shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-theme-bg border-b border-theme-border">
                            <th class="px-6 py-4 font-bold text-theme-text2 uppercase tracking-widest text-[10px]">No Invoice</th>
                            <th class="px-6 py-4 font-bold text-theme-text2 uppercase tracking-widest text-[10px]">Tanggal</th>
                            <th class="px-6 py-4 font-bold text-theme-text2 uppercase tracking-widest text-[10px]">Customer</th>
                            <th class="px-6 py-4 font-bold text-theme-text2 uppercase tracking-widest text-[10px] text-right">Total Tagihan</th>
                            <th class="px-6 py-4 font-bold text-theme-text2 uppercase tracking-widest text-[10px] text-right">Sisa Tagihan</th>
                            <th class="px-6 py-4 font-bold text-theme-text2 uppercase tracking-widest text-[10px] text-center">Status</th>
                            <th class="px-6 py-4 font-bold text-theme-text2 uppercase tracking-widest text-[10px] text-right w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($invoices as $invoice)
                            <tr class="hover:bg-theme-bg/50 transition-colors">
                                <td class="px-6 py-4">
                                    <span class="font-black text-theme-text1">{{ $invoice->invoice_number }}</span>
                                </td>
                                <td class="px-6 py-4 font-medium text-theme-text1">
                                    {{ $invoice->invoice_date->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-bold text-theme-text1">{{ $invoice->customer->nama_toko }}</div>
                                    <div class="text-xs text-theme-text2">{{ $invoice->customer->nama_pemilik }}</div>
                                </td>
                                <td class="px-6 py-4 text-right font-black text-theme-text1">
                                    Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right font-black {{ $invoice->remaining_amount > 0 ? 'text-rose-600' : 'text-emerald-600' }}">
                                    Rp {{ number_format($invoice->remaining_amount, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if($invoice->status == 'paid')
                                        <span class="inline-block px-3 py-1 bg-theme-success/40 text-emerald-600 text-[10px] font-black rounded-full uppercase tracking-widest border border-emerald-200">LUNAS</span>
                                    @elseif($invoice->status == 'partial')
                                        <span class="inline-block px-3 py-1 bg-yellow-100 text-yellow-700 text-[10px] font-black rounded-full uppercase tracking-widest border border-yellow-200">SEBAGIAN</span>
                                    @else
                                        <span class="inline-block px-3 py-1 bg-theme-error/40 text-rose-600 text-[10px] font-black rounded-full uppercase tracking-widest border border-red-200">BELUM DIBAYAR</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <a href="{{ route('invoices.show', $invoice) }}" class="inline-flex items-center justify-center w-8 h-8 rounded-xl bg-theme-sidebar text-theme-text2 hover:bg-theme-success/20 hover:text-emerald-600 transition-colors" title="Lihat Detail">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="inline-flex w-16 h-16 bg-theme-sidebar rounded-2xl items-center justify-center text-theme-text2 mb-4">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    </div>
                                    <p class="text-theme-text2 font-medium">Belum ada data invoice.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($invoices->hasPages())
                <div class="px-6 py-4 border-t border-theme-border">
                    {{ $invoices->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
