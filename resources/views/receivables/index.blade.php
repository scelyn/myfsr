<x-admin-layout>
    <x-slot name="title">Manajemen Piutang</x-slot>
    <x-slot name="header">Monitoring Piutang Customer</x-slot>

    <div class="space-y-8">
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-theme-card p-8 rounded-2xl border border-slate-50 shadow-md shadow-sm">
                <p class="text-[10px] font-black text-theme-text2 uppercase tracking-widest">Total Piutang Berjalan</p>
                <div class="text-3xl font-black text-theme-text1 mt-2">Rp {{ number_format($stats['total_outstanding'], 0, ',', '.') }}</div>
            </div>
            <div class="bg-theme-card p-8 rounded-2xl border border-slate-50 shadow-md shadow-sm border-l-4 border-l-red-500">
                <p class="text-[10px] font-black text-rose-600 uppercase tracking-widest">Jatuh Tempo (Overdue)</p>
                <div class="text-3xl font-black text-rose-600 mt-2">Rp {{ number_format($stats['total_overdue'], 0, ',', '.') }}</div>
            </div>
            <div class="bg-theme-success p-8 rounded-2xl shadow-xl shadow-emerald-100 text-theme-text1">
                <p class="text-[10px] font-black text-emerald-200 uppercase tracking-widest">Invoice Belum Lunas</p>
                <div class="text-3xl font-black mt-2">{{ $stats['count_unpaid'] }} <span class="text-sm font-bold text-emerald-200">Dokumen</span></div>
            </div>
        </div>

        <!-- Filter Card -->
        <div class="bg-theme-card p-6 rounded-2xl border border-slate-50 shadow-md shadow-sm">
            <form action="{{ route('receivables.index') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
                <div class="flex-1 space-y-1.5">
                    <label class="text-[10px] font-bold text-theme-text2 uppercase tracking-widest ml-1">Customer</label>
                    <select name="customer_id" class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                        <option value="">Semua Customer</option>
                        @foreach($customers as $customer)
                            <option value="{{ $customer->id }}" {{ request('customer_id') == $customer->id ? 'selected' : '' }}>{{ $customer->nama_toko }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="w-full md:w-48 space-y-1.5">
                    <label class="text-[10px] font-bold text-theme-text2 uppercase tracking-widest ml-1">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 bg-theme-bg border border-theme-border rounded-xl text-sm focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 transition-all">
                        <option value="">Semua Status</option>
                        <option value="unpaid" {{ request('status') == 'unpaid' ? 'selected' : '' }}>Belum Bayar</option>
                        <option value="partial" {{ request('status') == 'partial' ? 'selected' : '' }}>Dicicil</option>
                        <option value="paid" {{ request('status') == 'paid' ? 'selected' : '' }}>Lunas</option>
                    </select>
                </div>
                <button type="submit" class="bg-slate-800 text-theme-text1 px-8 py-2.5 rounded-xl text-sm font-bold hover:bg-slate-900 transition-all">Tampilkan</button>
            </form>
        </div>

        <!-- Table Card -->
        <div class="bg-theme-card rounded-2xl border border-slate-50 shadow-md shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="bg-theme-bg/50">
                            <th class="px-8 py-4 font-bold text-theme-text2 uppercase tracking-widest text-[10px]">Invoice / Customer</th>
                            <th class="px-8 py-4 font-bold text-theme-text2 uppercase tracking-widest text-[10px]">Jatuh Tempo</th>
                            <th class="px-8 py-4 font-bold text-theme-text2 uppercase tracking-widest text-[10px]">Total Tagihan</th>
                            <th class="px-8 py-4 font-bold text-theme-text2 uppercase tracking-widest text-[10px]">Sisa Piutang</th>
                            <th class="px-8 py-4 font-bold text-theme-text2 uppercase tracking-widest text-[10px]">Status</th>
                            <th class="px-8 py-4 font-bold text-theme-text2 uppercase tracking-widest text-[10px] text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($receivables as $r)
                            <tr class="hover:bg-theme-bg/30 transition-colors">
                                <td class="px-8 py-5">
                                    <div class="font-black text-theme-text1">{{ $r->invoice->invoice_number }}</div>
                                    <div class="text-[10px] font-bold text-theme-text2 mt-0.5">{{ $r->customer->nama_toko }}</div>
                                </td>
                                <td class="px-8 py-5">
                                    <div class="{{ $r->is_overdue ? 'text-red-500 font-bold' : 'text-theme-text1' }}">
                                        {{ $r->due_date->format('d M Y') }}
                                        @if($r->is_overdue)
                                            <span class="block text-[10px] uppercase tracking-tighter">Terlambat!</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-8 py-5 font-medium text-theme-text1">Rp {{ number_format($r->total_amount, 0, ',', '.') }}</td>
                                <td class="px-8 py-5">
                                    <div class="text-base font-black text-theme-text1">Rp {{ number_format($r->remaining_amount, 0, ',', '.') }}</div>
                                </td>
                                <td class="px-8 py-5">
                                    @if($r->status === 'paid')
                                        <span class="px-3 py-1 bg-theme-success/40 text-emerald-600 text-[10px] font-black rounded-full uppercase tracking-widest">LUNAS</span>
                                    @elseif($r->status === 'partial')
                                        <span class="px-3 py-1 bg-blue-100 text-blue-600 text-[10px] font-black rounded-full uppercase tracking-widest">DICICIL</span>
                                    @else
                                        <span class="px-3 py-1 bg-theme-error/40 text-rose-600 text-[10px] font-black rounded-full uppercase tracking-widest">BELUM BAYAR</span>
                                    @endif
                                </td>
                                <td class="px-8 py-5 text-right">
                                    <a href="{{ route('receivables.show', $r) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-theme-bg text-theme-text1 hover:bg-theme-success/20 hover:text-emerald-600 text-xs font-bold rounded-xl transition-all">
                                        <span>Detail & Bayar</span>
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr><td colspan="6" class="px-8 py-20 text-center text-theme-text2">Tidak ada data piutang.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-admin-layout>
