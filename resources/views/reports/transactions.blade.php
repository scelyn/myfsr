<x-admin-layout>
    <x-slot name="title">Laporan Transaksi</x-slot>
    <x-slot name="header">Laporan Transaksi Customer</x-slot>

    <div class="space-y-6">
        <!-- Summary Cards Compact -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-theme-sidebar border border-theme-border rounded-xl p-4 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-theme-text2 uppercase tracking-wider">Total Transaksi</p>
                    <p class="text-xl font-black text-theme-text1 mt-1">{{ number_format($summary['total_transaksi']) }} <span class="text-xs font-normal text-theme-text2">Invoice</span></p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-theme-bg flex items-center justify-center text-theme-text2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                </div>
            </div>
            <div class="bg-theme-sidebar border border-theme-border rounded-xl p-4 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-theme-text2 uppercase tracking-wider">Total Omzet</p>
                    <p class="text-xl font-black text-emerald-400 mt-1">Rp {{ number_format($summary['total_omzet'], 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-emerald-400/10 flex items-center justify-center text-emerald-400">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="bg-theme-sidebar border border-theme-border rounded-xl p-4 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-theme-text2 uppercase tracking-wider">Total Piutang</p>
                    <p class="text-xl font-black text-amber-500 mt-1">Rp {{ number_format($summary['total_piutang'], 0, ',', '.') }}</p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-amber-500/10 flex items-center justify-center text-amber-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
            <div class="bg-theme-sidebar border border-theme-border rounded-xl p-4 shadow-sm flex items-center justify-between">
                <div>
                    <p class="text-xs font-semibold text-theme-text2 uppercase tracking-wider">Lunas</p>
                    <p class="text-xl font-black text-theme-text1 mt-1">{{ number_format($summary['total_lunas']) }} <span class="text-xs font-normal text-theme-text2">Invoice</span></p>
                </div>
                <div class="w-10 h-10 rounded-lg bg-emerald-500/10 flex items-center justify-center text-emerald-500">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="bg-theme-sidebar rounded-2xl border border-theme-border shadow-sm overflow-hidden">
            <!-- Filter Section -->
            <div class="p-4 border-b border-theme-border bg-theme-bg/50">
                <form method="GET" action="{{ route('reports.transactions') }}" class="grid grid-cols-1 md:grid-cols-5 gap-4">
                    <div class="col-span-1">
                        <label class="block text-[10px] font-bold text-theme-text2 uppercase tracking-widest mb-1">Tanggal</label>
                        <input type="date" name="date" value="{{ request('date') }}" class="w-full h-10 px-3 bg-theme-bg border border-theme-border text-theme-text1 rounded-lg text-sm focus:ring-1 focus:ring-theme-text2 outline-none">
                    </div>
                    <div class="col-span-1 md:col-span-2">
                        <label class="block text-[10px] font-bold text-theme-text2 uppercase tracking-widest mb-1">Customer</label>
                        <select name="customer_id" class="w-full h-10 bg-theme-bg border border-theme-border text-theme-text1 rounded-lg text-sm outline-none">
                            <option value="">Semua Customer</option>
                            @foreach($customers as $c)
                                <option value="{{ $c->id }}" {{ request('customer_id') == $c->id ? 'selected' : '' }}>{{ $c->nama_toko }} ({{ $c->nama_pemilik }})</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-span-1">
                        <label class="block text-[10px] font-bold text-theme-text2 uppercase tracking-widest mb-1">Status</label>
                        <select name="status" class="w-full h-10 px-3 bg-theme-bg border border-theme-border text-theme-text1 rounded-lg text-sm focus:ring-1 focus:ring-theme-text2 outline-none">
                            <option value="">Semua Status</option>
                            <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                            <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Dibayar Sebagian</option>
                            <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Belum Dibayar</option>
                        </select>
                    </div>
                    <div class="col-span-1 flex items-end">
                        <button type="submit" class="h-10 w-full bg-theme-card text-theme-text1 border border-theme-border hover:bg-theme-border font-semibold rounded-lg text-sm transition-colors flex items-center justify-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                            Filter
                        </button>
                    </div>
                </form>
            </div>

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-theme-border bg-theme-bg/50">
                            <th class="py-3 px-4 text-[10px] font-bold text-theme-text2 uppercase tracking-widest whitespace-nowrap">Invoice & Tanggal</th>
                            <th class="py-3 px-4 text-[10px] font-bold text-theme-text2 uppercase tracking-widest whitespace-nowrap">Customer</th>
                            <th class="py-3 px-4 text-[10px] font-bold text-theme-text2 uppercase tracking-widest whitespace-nowrap text-right">Total Tagihan</th>
                            <th class="py-3 px-4 text-[10px] font-bold text-theme-text2 uppercase tracking-widest whitespace-nowrap text-right">Sisa Piutang</th>
                            <th class="py-3 px-4 text-[10px] font-bold text-theme-text2 uppercase tracking-widest whitespace-nowrap text-center">Status</th>
                            <th class="py-3 px-4 text-[10px] font-bold text-theme-text2 uppercase tracking-widest whitespace-nowrap text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-theme-border/50">
                        @forelse($invoices as $invoice)
                        <tr class="hover:bg-theme-bg/30 transition-colors">
                            <td class="py-3 px-4">
                                <p class="text-sm font-bold text-theme-text1">{{ $invoice->invoice_number }}</p>
                                <p class="text-xs text-theme-text2">{{ $invoice->order->order_date->format('d/m/Y') }}</p>
                            </td>
                            <td class="py-3 px-4">
                                <p class="text-sm font-bold text-theme-text1">{{ $invoice->customer->nama_toko }}</p>
                                <p class="text-xs text-theme-text2">{{ $invoice->customer->nama_pemilik }}</p>
                            </td>
                            <td class="py-3 px-4 text-right">
                                <p class="text-sm font-bold text-theme-text1">Rp {{ number_format($invoice->total_amount, 0, ',', '.') }}</p>
                            </td>
                            <td class="py-3 px-4 text-right">
                                @if($invoice->remaining_amount > 0)
                                    <p class="text-sm font-bold text-amber-500">Rp {{ number_format($invoice->remaining_amount, 0, ',', '.') }}</p>
                                @else
                                    <p class="text-sm font-medium text-emerald-500">Lunas</p>
                                @endif
                            </td>
                            <td class="py-3 px-4 text-center">
                                @if($invoice->status == 'paid')
                                    <span class="inline-flex items-center px-2 py-1 rounded-md bg-emerald-500/10 text-emerald-500 text-[10px] font-black uppercase tracking-wider border border-emerald-500/20">Lunas</span>
                                @elseif($invoice->status == 'partial')
                                    <span class="inline-flex items-center px-2 py-1 rounded-md bg-amber-500/10 text-amber-500 text-[10px] font-black uppercase tracking-wider border border-amber-500/20">Sebagian</span>
                                @else
                                    <span class="inline-flex items-center px-2 py-1 rounded-md bg-red-500/10 text-red-500 text-[10px] font-black uppercase tracking-wider border border-red-500/20">Belum Bayar</span>
                                @endif
                            </td>
                            <td class="py-3 px-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('invoices.show', $invoice->id) }}" class="p-1.5 bg-theme-bg text-theme-text2 hover:text-theme-text1 rounded-md border border-theme-border transition-colors" title="Detail Invoice">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                    </a>
                                    <a href="{{ URL::signedRoute('invoices.pdf', $invoice->id) }}" target="_blank" class="p-1.5 bg-theme-bg text-theme-text2 hover:text-emerald-400 rounded-md border border-theme-border transition-colors" title="Download PDF">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/></svg>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-theme-text2 text-sm">
                                Tidak ada data transaksi yang ditemukan.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <!-- Pagination -->
            @if($invoices->hasPages())
                <div class="p-4 border-t border-theme-border bg-theme-bg/50">
                    {{ $invoices->links() }}
                </div>
            @endif
        </div>
    </div>
</x-admin-layout>
