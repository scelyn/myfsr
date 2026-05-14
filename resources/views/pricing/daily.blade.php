<x-admin-layout>
    <x-slot name="title">Finalisasi Harga Harian</x-slot>
    <x-slot name="header">Finalisasi Harga Harian</x-slot>

    <div class="space-y-8 max-w-5xl mx-auto">
        <!-- Date Filter -->
        <div class="bg-theme-card p-6 rounded-2xl border border-theme-border shadow-md shadow-sm flex flex-col md:flex-row items-center justify-between gap-6">
            <div>
                <h3 class="text-lg font-black text-theme-text1">Tanggal Transaksi</h3>
                <p class="text-xs font-bold text-theme-text2 mt-1">Pilih tanggal untuk update harga semua pesanan.</p>
            </div>
            <form action="{{ route('pricing.daily') }}" method="GET" class="flex gap-2 w-full md:w-auto">
                <input 
                    type="date" 
                    name="date" 
                    value="{{ request('date', $date) }}"
                    class="w-full md:w-48 px-4 py-2.5 bg-slate-100 border border-theme-border text-theme-text1 rounded-xl text-sm focus:ring-2 focus:ring-theme-primary/20 focus:border-theme-primary transition-all outline-none"
                >
                <button type="submit" class="bg-slate-100 hover:bg-[#4A5C6A] text-theme-text1 hover:text-theme-text1 px-6 py-2.5 rounded-xl text-sm font-bold transition-all shadow-md shadow-sm">
                    Load
                </button>
            </form>
        </div>

        @if(session('success'))
            <div class="p-4 bg-theme-success/200/10 border border-emerald-500/20 text-emerald-600 rounded-2xl text-sm font-bold flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="p-4 bg-rose-500/10 border border-rose-500/20 text-rose-400 rounded-2xl text-sm font-bold flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                {{ session('error') }}
            </div>
        @endif

        <!-- Pricing Form -->
        <div class="bg-theme-card rounded-2xl border border-theme-border shadow-md shadow-sm overflow-hidden" x-data="pricingForm()">
            <div class="px-8 py-6 border-b border-theme-border flex items-center justify-between bg-slate-50">
                <div>
                    <h3 class="text-lg font-black text-theme-text1">Input Harga Produk</h3>
                    <p class="text-xs font-bold text-theme-text2 mt-1">Harga yang disimpan akan mengikat seluruh nota pada tanggal {{ \Carbon\Carbon::parse($date)->format('d/m/Y') }}</p>
                </div>
            </div>

            <form action="{{ route('pricing.store') }}" method="POST" id="form-pricing">
                @csrf
                <input type="hidden" name="date" value="{{ $date }}">

                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead class="bg-slate-100 border-b border-theme-border">
                            <tr>
                                <th class="px-8 py-4 font-black text-slate-400 uppercase tracking-widest text-[10px]">Produk</th>
                                <th class="px-8 py-4 font-black text-slate-400 uppercase tracking-widest text-[10px] text-center w-32">Total Qty Order</th>
                                <th class="px-8 py-4 font-black text-slate-400 uppercase tracking-widest text-[10px]">Harga Beli (HPP)</th>
                                <th class="px-8 py-4 font-black text-slate-400 uppercase tracking-widest text-[10px]">Harga Jual</th>
                                <th class="px-8 py-4 font-black text-slate-400 uppercase tracking-widest text-[10px] text-right">Potensi Laba</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-theme-border">
                            @forelse($products as $product)
                                <tr class="hover:bg-slate-50 transition-colors">
                                    <td class="px-8 py-6">
                                        <div class="font-black text-theme-text1">{{ $product->nama_barang }}</div>
                                        <div class="text-[10px] font-bold text-theme-text2 uppercase tracking-widest mt-1">{{ $product->satuan }}</div>
                                    </td>
                                    <td class="px-8 py-6 text-center">
                                        <div class="text-lg font-black text-theme-text1">{{ floatval($product->total_qty) }}</div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-slate-400 text-sm font-bold">Rp</span>
                                            </div>
                                            <input 
                                                type="number" 
                                                name="prices[{{ $product->id }}][harga_beli]" 
                                                x-model="items[{{ $product->id }}].beli"
                                                class="w-full pl-9 pr-4 py-2.5 bg-slate-100 border border-theme-border text-theme-text1 rounded-xl text-sm font-bold focus:ring-2 focus:ring-theme-primary/20 focus:border-theme-primary transition-all outline-none"
                                                required
                                                min="0"
                                            >
                                        </div>
                                    </td>
                                    <td class="px-8 py-6">
                                        <div class="relative">
                                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                                <span class="text-slate-400 text-sm font-bold">Rp</span>
                                            </div>
                                            <input 
                                                type="number" 
                                                name="prices[{{ $product->id }}][harga_jual]" 
                                                x-model="items[{{ $product->id }}].jual"
                                                class="w-full pl-9 pr-4 py-2.5 bg-slate-100 border border-theme-border text-theme-text1 rounded-xl text-sm font-bold focus:ring-2 focus:ring-theme-primary/20 focus:border-theme-primary transition-all outline-none"
                                                required
                                                min="0"
                                            >
                                        </div>
                                    </td>
                                    <td class="px-8 py-6 text-right">
                                        <div class="text-sm font-black" :class="getProfit(items[{{ $product->id }}]) >= 0 ? 'text-emerald-600' : 'text-rose-400'">
                                            Rp <span x-text="formatMoney(getProfit(items[{{ $product->id }}]) * {{ floatval($product->total_qty) }})"></span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="px-8 py-16 text-center">
                                        <div class="inline-flex w-16 h-16 bg-slate-100 rounded-2xl items-center justify-center text-[#253745] mb-4">
                                            <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                        </div>
                                        <p class="text-slate-400 font-bold">Tidak ada transaksi pesanan pada tanggal ini.</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                        @if($products->count() > 0)
                        <tfoot class="border-t-2 border-[#06141B] bg-slate-100/30">
                            <tr>
                                <td colspan="4" class="px-8 py-6 text-right text-xs font-black text-theme-text2 uppercase tracking-widest">Total Estimasi Laba Hari Ini</td>
                                <td class="px-8 py-6 text-right">
                                    <div class="text-2xl font-black text-emerald-600">Rp <span x-text="formatMoney(getTotalProfit())"></span></div>
                                </td>
                            </tr>
                        </tfoot>
                        @endif
                    </table>
                </div>

                @if($products->count() > 0)
                <div class="px-8 py-6 border-t border-theme-border bg-slate-50 flex justify-end">
                    <button type="submit" class="inline-flex items-center gap-2 px-8 py-3 bg-theme-primary hover:bg-theme-card text-white text-sm font-black rounded-xl shadow-lg shadow-sm transition-all transform hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span>FINALISASI HARGA & GENERATE INVOICE</span>
                    </button>
                </div>
                @endif
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('pricingForm', () => ({
                items: {
                    @foreach($products as $product)
                    '{{ $product->id }}': {
                        beli: {{ $product->harga_beli_default ?? 0 }},
                        jual: {{ ($product->harga_beli_default ?? 0) + ($product->margin_default ?? 0) }},
                        qty: {{ floatval($product->total_qty) }}
                    },
                    @endforeach
                },

                getProfit(item) {
                    if (!item.beli || !item.jual) return 0;
                    return item.jual - item.beli;
                },

                getTotalProfit() {
                    let total = 0;
                    for (const [id, item] of Object.entries(this.items)) {
                        total += this.getProfit(item) * item.qty;
                    }
                    return total;
                },

                formatMoney(amount) {
                    return new Intl.NumberFormat('id-ID').format(amount);
                }
            }));
        });
    </script>
    @endpush
</x-admin-layout>
