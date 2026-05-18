<x-admin-layout>
    <x-slot name="title">Input Pembayaran</x-slot>
    <x-slot name="header">Catat Cicilan / Pelunasan</x-slot>

    <div class="max-w-2xl">
        <a href="{{ route('invoices.index') }}" class="back-link">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Invoice
        </a>

        @php
            $totalPiutang = $invoice->customer->invoices()->where('status', '!=', 'paid')->sum('remaining_amount');
        @endphp

        <form action="{{ route('payments.store') }}" method="POST">
            @csrf
            {{-- ⚠️ CRITICAL: invoice_id hidden field — controller dependency --}}
            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">

            <section class="card shadow-card overflow-hidden">
                {{-- Customer header --}}
                <div class="flex items-center justify-between p-5"
                     style="background-color:var(--bg-surface); border-bottom:1px solid var(--border-soft);">
                    <div>
                        <p class="form-label mb-1">Membayar Untuk Customer</p>
                        <h3 class="text-lg font-black" style="color:var(--text-primary);">{{ $invoice->customer->nama_toko }}</h3>
                        <p class="text-sm" style="color:var(--text-secondary);">{{ $invoice->customer->nama_pemilik }}</p>
                    </div>
                    <div class="text-right">
                        <p class="form-label mb-1">Total Seluruh Piutang</p>
                        <p class="text-2xl font-black" style="color:var(--color-danger);">Rp {{ \App\Helpers\NumberHelper::format($totalPiutang) }}</p>
                        <p class="text-xs mt-0.5" style="color:var(--text-muted);">Otomatis FIFO</p>
                    </div>
                </div>

                <div class="p-6 space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="form-group">
                            <label class="form-label">Jumlah Bayar <span style="color:var(--color-danger);">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold" style="color:var(--text-muted);">Rp</span>
                                <input type="number" name="amount"
                                       value="{{ old('amount', $totalPiutang) }}"
                                       max="{{ $totalPiutang }}" required
                                       class="form-input pl-9 text-lg font-black {{ $errors->has('amount') ? 'error' : '' }}">
                            </div>
                            <p class="text-xs" style="color:var(--text-muted);">Sistem mengalokasikan ke nota terlama (FIFO)</p>
                            @error('amount')<p class="text-xs" style="color:var(--color-danger);">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Tanggal Bayar <span style="color:var(--color-danger);">*</span></label>
                            <input type="date" name="payment_date"
                                   value="{{ old('payment_date', date('Y-m-d')) }}" required
                                   class="form-input {{ $errors->has('payment_date') ? 'error' : '' }}">
                            @error('payment_date')<p class="text-xs" style="color:var(--color-danger);">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Metode Pembayaran <span style="color:var(--color-danger);">*</span></label>
                            <select name="payment_method" required class="form-input">
                                <option value="cash"     {{ old('payment_method') == 'cash'     ? 'selected' : '' }}>Tunai / Cash</option>
                                <option value="transfer" {{ old('payment_method') == 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label class="form-label">No. Referensi (Opsional)</label>
                            <input type="text" name="reference_number"
                                   value="{{ old('reference_number') }}"
                                   placeholder="No. Resi Transfer"
                                   class="form-input">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Catatan</label>
                        <textarea name="notes" rows="3" placeholder="Catatan tambahan..."
                                  class="form-input resize-none">{{ old('notes') }}</textarea>
                    </div>
                </div>

                <div class="px-6 py-4 flex justify-end gap-3"
                     style="border-top:1px solid var(--border-soft); background-color:var(--bg-surface);">
                    <a href="{{ route('invoices.index') }}" class="btn btn-ghost">Batal</a>
                    <button type="submit" class="btn btn-primary btn-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Pembayaran
                    </button>
                </div>
            </section>
        </form>
    </div>
</x-admin-layout>
