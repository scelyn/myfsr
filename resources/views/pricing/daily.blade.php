<x-admin-layout>
    <x-slot name="title">Finalisasi Harga Harian</x-slot>
    <x-slot name="header">Finalisasi Harga Harian</x-slot>
    <div class="content-section max-w-5xl mx-auto">
        <section class="card shadow-card p-5">
            <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
                <div>
                    <h3>Tanggal Transaksi</h3>
                    <p class="text-xs mt-1" style="color:var(--text-muted);">Pilih tanggal untuk update harga semua pesanan.</p>
                </div>
                <form action="{{ route('pricing.daily') }}" method="GET" class="flex gap-2">
                    <input type="date" name="date" value="{{ request('date', $date) }}" class="form-input w-48">
                    <button type="submit" class="btn btn-soft btn-sm">Load</button>
                </form>
            </div>
        </section>

        {{-- ⚠️ HIGH-RISK: x-data="pricingForm()" must stay on this element --}}
        <section class="card shadow-card overflow-hidden" x-data="pricingForm()">
            <div class="card-header">
                <div>
                    <h3>Input Harga Produk</h3>
                    <p class="text-xs mt-1" style="color:var(--text-muted);">Harga mengikat nota tanggal {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                </div>
            </div>

            {{-- ⚠️ HIGH-RISK: form id, action, hidden date field preserved --}}
            <form action="{{ route('pricing.store') }}" method="POST" id="form-pricing">
                @csrf
                <input type="hidden" name="date" value="{{ $date }}">
                <div class="overflow-x-auto">
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Produk</th>
                                <th class="text-center">Total Qty</th>
                                <th>Harga Beli (HPP)</th>
                                <th>Harga Jual</th>
                                <th class="text-right">Potensi Laba</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($products as $product)
                                <tr>
                                    <td>
                                        <p class="font-semibold" style="color:var(--text-primary);">{{ $product->nama_barang }}</p>
                                        <p class="text-xs uppercase tracking-wide mt-0.5" style="color:var(--text-muted);">{{ $product->satuan }}</p>
                                    </td>
                                    <td class="text-center font-black" style="color:var(--text-primary);">{{ floatval($product->total_qty) }}</td>
                                    <td>
                                        {{-- ⚠️ CRITICAL: name + x-model untouched --}}
                                        <div class="relative">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold" style="color:var(--text-muted);">Rp</span>
                                            <input type="number" name="prices[{{ $product->id }}][harga_beli]" x-model="items[{{ $product->id }}].beli" class="form-input pl-9" required min="0">
                                        </div>
                                    </td>
                                    <td>
                                        {{-- ⚠️ CRITICAL: name + x-model untouched --}}
                                        <div class="relative">
                                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold" style="color:var(--text-muted);">Rp</span>
                                            <input type="number" name="prices[{{ $product->id }}][harga_jual]" x-model="items[{{ $product->id }}].jual" class="form-input pl-9" required min="0">
                                        </div>
                                    </td>
                                    <td class="text-right">
                                        {{-- ⚠️ CRITICAL: Alpine x-text preserved --}}
                                        <div class="font-black text-sm" :class="getProfit(items[{{ $product->id }}]) >= 0 ? 'text-emerald-600' : 'text-red-500'">
                                            Rp <span x-text="formatMoney(getProfit(items[{{ $product->id }}]) * {{ floatval($product->total_qty) }})"></span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="5" class="text-center py-14" style="color:var(--text-muted);">Tidak ada transaksi pada tanggal ini.</td></tr>
                            @endforelse
                        </tbody>
                        @if($products->count() > 0)
                        <tfoot>
                            <tr>
                                <td colspan="4" class="text-right font-bold" style="color:var(--text-secondary); padding:1rem 1.25rem;">Total Estimasi Laba Hari Ini</td>
                                <td class="text-right" style="padding:1rem 1.25rem;">
                                    <div class="text-2xl font-black text-emerald-600">Rp <span x-text="formatMoney(getTotalProfit())"></span></div>
                                </td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>
                @if($products->count() > 0)
                <div class="px-6 py-4 flex justify-end" style="border-top:1px solid var(--border-soft); background-color:var(--bg-surface);">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        Finalisasi Harga &amp; Generate Invoice
                    </button>
                </div>
                @endif
            </form>
        </section>
    </div>

    {{-- ⚠️ HIGH-RISK: Alpine logic block — DO NOT MODIFY --}}
    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('pricingForm', () => ({
                items: {
                    @foreach($products as $product)
                    '{{ $product->id }}': { beli: {{ $product->harga_beli_default ?? 0 }}, jual: {{ ($product->harga_beli_default ?? 0) + ($product->margin_default ?? 0) }}, qty: {{ floatval($product->total_qty) }} },
                    @endforeach
                },
                getProfit(item) { if (!item.beli || !item.jual) return 0; return item.jual - item.beli; },
                getTotalProfit() { let t = 0; for (const [id, item] of Object.entries(this.items)) { t += this.getProfit(item) * item.qty; } return t; },
                formatMoney(amount) { return new Intl.NumberFormat('id-ID').format(amount); }
            }));
        });
    </script>
    @endpush
</x-admin-layout>
