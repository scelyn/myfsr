<x-admin-layout>
    <x-slot name="title">Detail Piutang</x-slot>
    <x-slot name="header">Informasi Tagihan & Pembayaran</x-slot>

    <div class="max-w-6xl mx-auto space-y-8">
        <div class="flex items-center justify-between">
            <a href="{{ route('receivables.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-theme-text2 hover:text-emerald-600 transition-colors group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                <span>Kembali ke Daftar Piutang</span>
            </a>
            
            @if($receivable->status !== 'paid')
                <a href="{{ route('payments.create', ['receivable_id' => $receivable->id]) }}" class="px-8 py-3 bg-theme-success hover:bg-emerald-700 text-theme-text1 text-sm font-black rounded-2xl shadow-lg shadow-emerald-200 transition-all transform hover:-translate-y-1">
                    INPUT PEMBAYARAN
                </a>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Left: Info & Items -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Invoice Info -->
                <div class="bg-theme-card rounded-2xl border border-slate-50 shadow-md shadow-sm p-8">
                    <div class="flex justify-between items-start mb-8">
                        <div>
                            <p class="text-[10px] font-black text-theme-text2 uppercase tracking-widest">Nomor Invoice</p>
                            <h2 class="text-2xl font-black text-theme-text1">{{ $receivable->invoice->invoice_number }}</h2>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-black text-theme-text2 uppercase tracking-widest">Status Tagihan</p>
                            <div class="mt-1">
                                @if($receivable->status === 'paid')
                                    <span class="px-4 py-1.5 bg-theme-success/40 text-emerald-600 text-xs font-black rounded-full uppercase tracking-widest">LUNAS</span>
                                @else
                                    <span class="px-4 py-1.5 bg-theme-error/40 text-rose-600 text-xs font-black rounded-full uppercase tracking-widest">BELUM LUNAS</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                        <div>
                            <p class="text-[10px] font-black text-theme-text2 uppercase tracking-widest">Customer</p>
                            <p class="text-sm font-bold text-theme-text1 mt-1">{{ $receivable->customer->nama_toko }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-theme-text2 uppercase tracking-widest">Tanggal Nota</p>
                            <p class="text-sm font-bold text-theme-text1 mt-1">{{ $receivable->invoice->invoice_date->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-theme-text2 uppercase tracking-widest">Jatuh Tempo</p>
                            <p class="text-sm font-bold text-theme-text1 mt-1">{{ $receivable->due_date->format('d M Y') }}</p>
                        </div>
                        <div>
                            <p class="text-[10px] font-black text-theme-text2 uppercase tracking-widest">Metode Nota</p>
                            <p class="text-sm font-bold text-theme-text1 mt-1">Tempo / Kredit</p>
                        </div>
                    </div>
                </div>

                <!-- Payment History -->
                <div class="bg-theme-card rounded-2xl border border-slate-50 shadow-md shadow-sm overflow-hidden">
                    <div class="px-8 py-6 border-b border-slate-50 bg-theme-bg/30 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-theme-text1">Histori Pembayaran</h3>
                        <span class="text-xs font-bold text-theme-text2 uppercase tracking-widest">{{ $receivable->payments->count() }} Transaksi</span>
                    </div>
                    <div class="p-0">
                        <table class="w-full text-left text-sm">
                            <thead class="bg-theme-bg/50">
                                <tr>
                                    <th class="px-8 py-4 font-bold text-theme-text2 uppercase tracking-widest text-[10px]">No. Bukti</th>
                                    <th class="px-8 py-4 font-bold text-theme-text2 uppercase tracking-widest text-[10px]">Tanggal</th>
                                    <th class="px-8 py-4 font-bold text-theme-text2 uppercase tracking-widest text-[10px]">Metode</th>
                                    <th class="px-8 py-4 font-bold text-theme-text2 uppercase tracking-widest text-[10px] text-right">Jumlah Bayar</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-50">
                                @forelse($receivable->payments as $payment)
                                    <tr class="hover:bg-theme-bg/30 transition-colors">
                                        <td class="px-8 py-4 font-black text-theme-text1">{{ $payment->payment_number }}</td>
                                        <td class="px-8 py-4 text-theme-text1">{{ $payment->payment_date->format('d M Y') }}</td>
                                        <td class="px-8 py-4">
                                            <span class="px-3 py-1 bg-theme-sidebar text-theme-text2 text-[10px] font-bold rounded-full uppercase tracking-widest">{{ $payment->payment_method }}</span>
                                        </td>
                                        <td class="px-8 py-4 text-right font-black text-emerald-600">Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                    </tr>
                                @empty
                                    <tr><td colspan="4" class="px-8 py-10 text-center text-theme-text2 italic">Belum ada cicilan pembayaran.</td></tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Right: Balance Summary -->
            <div class="lg:col-span-1 space-y-8">
                <div class="bg-slate-900 rounded-2xl p-8 text-theme-text1 shadow-xl shadow-slate-200">
                    <p class="text-[10px] font-black text-theme-text2 uppercase tracking-widest">Total Tagihan</p>
                    <div class="text-2xl font-black mt-1">Rp {{ number_format($receivable->total_amount, 0, ',', '.') }}</div>
                    
                    <div class="mt-8 pt-8 border-t border-white/10 space-y-4">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-theme-text2">Sudah Terbayar</span>
                            <span class="font-bold text-emerald-600">Rp {{ number_format($receivable->payments->sum('amount'), 0, ',', '.') }}</span>
                        </div>
                        <div class="flex justify-between items-center pt-4">
                            <span class="text-xs font-black uppercase tracking-widest">Sisa Piutang</span>
                            <span class="text-3xl font-black text-theme-text1">Rp {{ number_format($receivable->remaining_amount, 0, ',', '.') }}</span>
                        </div>
                    </div>

                    @if($receivable->remaining_amount > 0)
                        <div class="mt-10">
                            <div class="w-full bg-theme-card/10 rounded-full h-3">
                                @php $percent = ($receivable->payments->sum('amount') / $receivable->total_amount) * 100; @endphp
                                <div class="bg-theme-success/200 h-3 rounded-full" style="width: {{ $percent }}%"></div>
                            </div>
                            <p class="text-[10px] font-bold text-theme-text2 mt-2 uppercase tracking-widest">Progress Pelunasan: {{ round($percent) }}%</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
