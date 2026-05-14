<x-admin-layout>
    <x-slot name="title">Input Pembayaran</x-slot>
    <x-slot name="header">Catat Cicilan / Pelunasan</x-slot>

    <div class="max-w-3xl mx-auto">
        <a href="{{ route('receivables.show', $receivable) }}" class="inline-flex items-center gap-2 text-sm font-semibold text-theme-text2 hover:text-emerald-600 transition-colors mb-6 group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Kembali ke Detail Piutang</span>
        </a>

        <div class="bg-theme-card rounded-2xl border border-slate-50 shadow-md shadow-sm overflow-hidden">
            @php
                $totalPiutang = $receivable->invoice->customer->invoices()->where('status', '!=', 'paid')->sum('remaining_amount');
            @endphp
            <div class="p-8 bg-theme-bg/50 border-b border-theme-border flex justify-between items-center">
                <div>
                    <p class="text-[10px] font-black text-theme-text2 uppercase tracking-widest">Membayar Untuk Customer</p>
                    <h3 class="text-xl font-black text-theme-text1">{{ $receivable->invoice->customer->nama_toko }}</h3>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-theme-text2 uppercase tracking-widest">Total Seluruh Piutang</p>
                    <div class="text-2xl font-black text-emerald-600">Rp {{ number_format($totalPiutang, 0, ',', '.') }}</div>
                </div>
            </div>

            <form action="{{ route('payments.store') }}" method="POST" class="p-8 space-y-6">
                @csrf
                <input type="hidden" name="invoice_id" value="{{ $receivable->invoice->id }}">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="text-xs font-black text-theme-text2 uppercase tracking-widest">Jumlah Bayar <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-4 flex items-center text-theme-text2 font-black text-sm">Rp</span>
                            <input type="number" name="amount" value="{{ old('amount', $totalPiutang) }}" max="{{ $totalPiutang }}" 
                                class="w-full pl-12 pr-4 py-4 bg-theme-bg border border-theme-border rounded-2xl text-xl font-black text-theme-text1 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all" required>
                        </div>
                        <p class="text-[10px] font-bold text-theme-text2 mt-2">Sistem otomatis mengalokasikan pembayaran ke nota terlama (FIFO).</p>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-theme-text2 uppercase tracking-widest">Tanggal Bayar <span class="text-red-500">*</span></label>
                        <input type="date" name="payment_date" value="{{ date('Y-m-d') }}" 
                            class="w-full px-5 py-4 bg-theme-bg border border-theme-border rounded-2xl text-base font-bold text-theme-text1 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all" required>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-theme-text2 uppercase tracking-widest">Metode Pembayaran <span class="text-red-500">*</span></label>
                        <select name="payment_method" class="w-full px-5 py-4 bg-theme-bg border border-theme-border rounded-2xl text-base font-bold text-theme-text1 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all" required>
                            <option value="cash">Tunai / Cash</option>
                            <option value="transfer">Transfer Bank</option>
                        </select>
                    </div>

                    <div class="space-y-2">
                        <label class="text-xs font-black text-theme-text2 uppercase tracking-widest">No. Referensi (Opsional)</label>
                        <input type="text" name="reference_number" placeholder="Misal: No. Resi Transfer" 
                            class="w-full px-5 py-4 bg-theme-bg border border-theme-border rounded-2xl text-base font-bold text-theme-text1 focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all">
                    </div>
                </div>

                <div class="space-y-2">
                    <label class="text-xs font-black text-theme-text2 uppercase tracking-widest">Catatan Pembayaran</label>
                    <textarea name="notes" rows="3" placeholder="Tambahkan catatan jika perlu..." 
                        class="w-full px-5 py-4 bg-theme-bg border border-theme-border rounded-2xl text-sm focus:ring-4 focus:ring-emerald-500/10 focus:border-emerald-500 transition-all"></textarea>
                </div>

                <div class="pt-6 border-t border-slate-50 flex justify-end">
                    <button type="submit" class="w-full md:w-auto px-12 py-4 bg-theme-success hover:bg-emerald-700 text-theme-text1 text-base font-black rounded-2xl shadow-xl shadow-emerald-200 transition-all transform hover:-translate-y-1 active:scale-95">
                        SIMPAN PEMBAYARAN
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-admin-layout>
