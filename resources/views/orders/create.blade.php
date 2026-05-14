<x-admin-layout>
    <x-slot name="title">Input Transaksi Pesanan</x-slot>
    <x-slot name="header">Buat Transaksi Pesanan Baru</x-slot>

    <!-- Tom Select Custom Styles for #06141B Theme -->
    <style>
        .ts-control {
            border-radius: 0.75rem !important; /* rounded-xl */
            border: 1px solid #4A5C6A !important;
            background-color: transparent !important;
            padding: 0.75rem 1rem !important;
            color: #CCD0CF !important;
        }
        .ts-control.focus {
            border-color: #9BA8AB !important;
            box-shadow: 0 0 0 2px rgba(155, 168, 171, 0.2) !important;
        }
        .ts-dropdown {
            border-radius: 0.75rem !important;
            border: 1px solid #253745 !important;
            background-color: #11212D !important;
            color: #CCD0CF !important;
        }
        .ts-dropdown .option {
            padding: 0.75rem 1rem !important;
        }
        .ts-dropdown .option.active, .ts-dropdown .option:hover {
            background-color: #253745 !important;
            color: #fff !important;
        }
        .ts-control > input {
            color: #CCD0CF !important;
        }
    </style>

    <div class="max-w-6xl mx-auto" x-data="orderForm()">
        <a href="{{ route('orders.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-[#9BA8AB] hover:text-[#CCD0CF] transition-colors mb-6 group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            <span>Kembali ke Daftar Transaksi</span>
        </a>

        <form action="{{ route('orders.store') }}" method="POST">
            @csrf
            
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left: Order Info & Items -->
                <div class="lg:col-span-2 space-y-8">
                    <!-- Main Info -->
                    <div class="bg-[#11212D] rounded-2xl border border-[#253745] shadow-md shadow-black/20 p-8 transition-all hover:shadow-md">
                        <h3 class="text-lg font-bold text-[#CCD0CF] mb-6 flex items-center gap-2">
                            <svg class="w-5 h-5 text-[#9BA8AB]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                            Informasi Dasar
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div class="space-y-2" wire:ignore>
                                <label class="text-xs font-bold text-[#9BA8AB] uppercase tracking-widest">Pilih Customer <span class="text-theme-errorText">*</span></label>
                                <select name="customer_id" x-ref="customerSelect" class="w-full" required>
                                    <option value="">-- Cari atau Pilih Customer --</option>
                                    @foreach($customers as $customer)
                                        <option value="{{ $customer->id }}" {{ old('customer_id') == $customer->id ? 'selected' : '' }}>
                                            {{ $customer->nama_toko }} ({{ $customer->nama_pemilik }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            

                            <div class="space-y-2">
                                <label class="text-xs font-bold text-[#9BA8AB] uppercase tracking-widest">Tanggal Transaksi <span class="text-theme-errorText">*</span></label>
                                <input type="date" name="order_date" value="{{ old('order_date', date('Y-m-d')) }}" class="w-full px-4 py-3 bg-transparent border border-[#4A5C6A] text-[#CCD0CF] rounded-xl text-sm focus:ring-2 focus:ring-[#9BA8AB]/20 focus:border-[#9BA8AB] transition-all outline-none" required>
                            </div>
                        </div>
                    </div>

                    <!-- Items -->
                    <div class="bg-[#11212D] rounded-2xl border border-[#253745] shadow-md shadow-black/20 overflow-hidden">
                        <div class="px-8 py-6 border-b border-[#253745] bg-[#06141B] flex items-center justify-between">
                            <h3 class="text-lg font-bold text-[#CCD0CF] flex items-center gap-2">
                                <svg class="w-5 h-5 text-[#9BA8AB]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                                Daftar Produk
                            </h3>
                            <button type="button" @click="addItem()" class="inline-flex items-center gap-2 px-4 py-2 bg-[#253745] text-[#CCD0CF] hover:bg-[#4A5C6A] hover:text-theme-text1 text-xs font-bold rounded-xl transition-all shadow-md">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                <span>Tambah Produk</span>
                            </button>
                        </div>
                        
                        <div class="p-0 overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-[#06141B]/50">
                                    <tr>
                                        <th class="px-8 py-3 text-[10px] font-bold text-[#9BA8AB] uppercase tracking-widest w-1/2 border-b border-[#253745]">Produk</th>
                                        <th class="px-4 py-3 text-[10px] font-bold text-[#9BA8AB] uppercase tracking-widest w-32 text-center border-b border-[#253745]">Qty</th>
                                        <th class="px-8 py-3 text-[10px] font-bold text-[#9BA8AB] uppercase tracking-widest text-right border-b border-[#253745]">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-[#253745]">
                                    <template x-for="(item, index) in items" :key="item.id">
                                        <tr class="hover:bg-[#253745]/20 transition-colors">
                                            <td class="px-8 py-5">
                                                <div wire:ignore>
                                                    <select :id="`productSelect${item.id}`" class="w-full">
                                                        <option value="">-- Cari Produk --</option>
                                                        @foreach($products as $product)
                                                            <option value="{{ $product->id }}" data-price="{{ $product->harga_beli_default + $product->margin_default }}">
                                                                {{ $product->nama_barang }} ({{ $product->satuan }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <input type="hidden" :name="`items[${index}][product_id]`" x-model="item.product_id" required>
                                                <input type="text" :name="`items[${index}][notes]`" x-model="item.notes" placeholder="Catatan opsional..." class="w-full mt-2 bg-transparent border-none text-[11px] text-[#9BA8AB] p-0 focus:ring-0 placeholder-[#4A5C6A]">
                                            </td>
                                            <td class="px-4 py-5">
                                                <input type="number" :name="`items[${index}][quantity]`" x-model.number="item.quantity" step="1" min="1" class="w-full px-2 py-3 bg-transparent border border-[#4A5C6A] text-[#CCD0CF] rounded-xl text-sm text-center focus:ring-2 focus:ring-[#9BA8AB]/20 focus:border-[#9BA8AB] transition-all outline-none" required>
                                            </td>
                                            <td class="px-8 py-5 text-right">
                                                <button type="button" @click="removeItem(index)" class="p-2 text-[#4A5C6A] hover:text-theme-errorText hover:bg-theme-error/10 rounded-lg transition-all">
                                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                    <template x-if="items.length === 0">
                                        <tr>
                                            <td colspan="5" class="px-8 py-10 text-center text-[#4A5C6A] italic text-sm border-b border-[#253745]">
                                                Belum ada produk. Klik "Tambah Produk" untuk memulai.
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Right: Summary & Notes -->
                <div class="lg:col-span-1 space-y-8">
                    <!-- Summary Card -->
                    <div class="bg-[#11212D] rounded-2xl border border-[#253745] shadow-md shadow-black/20 overflow-hidden sticky top-8">
                        <div class="px-8 py-6 border-b border-[#253745] bg-[#06141B]">
                            <h3 class="text-lg font-bold text-[#CCD0CF]">Ringkasan Transaksi</h3>
                        </div>
                        <div class="p-8 space-y-6">
                            <div class="flex justify-between items-center pb-4 border-b border-[#253745]">
                                <span class="text-sm font-medium text-[#9BA8AB]">Total Produk</span>
                                <span class="text-sm font-bold text-[#CCD0CF]" x-text="items.length"></span>
                            </div>
                            <div class="flex justify-between items-center pb-4 border-b border-[#253745]">
                                <span class="text-sm font-medium text-[#9BA8AB]">Total Qty</span>
                                <span class="text-sm font-bold text-[#CCD0CF]" x-text="items.reduce((sum, item) => sum + (Number(item.quantity) || 0), 0)"></span>
                            </div>
                            
                            <div class="space-y-4 pt-6 border-t border-[#253745] mt-4">
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-[#9BA8AB] uppercase tracking-widest">Catatan Internal</label>
                                    <textarea name="notes" rows="3" placeholder="Contoh: Titipkan di toko..." class="w-full px-4 py-3 bg-transparent border border-[#4A5C6A] rounded-xl text-sm focus:ring-2 focus:ring-[#9BA8AB]/20 focus:border-[#9BA8AB] transition-all text-[#CCD0CF] placeholder-[#4A5C6A] outline-none">{{ old('notes') }}</textarea>
                                </div>
                            </div>

                            <button type="submit" @click="if(items.length === 0) { $event.preventDefault(); alert('Minimal 1 produk!'); }" class="w-full py-4 bg-[#CCD0CF] hover:bg-theme-card disabled:opacity-50 disabled:cursor-not-allowed text-[#06141B] text-sm font-black rounded-xl shadow-lg shadow-[#CCD0CF]/10 transition-all transform hover:-translate-y-0.5 active:scale-95 flex justify-center items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                <span>SIMPAN TRANSAKSI</span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    @push('scripts')
    <script>
        function orderForm() {
            return {
                items: [],
                itemCounter: 0,
                
                init() {
                    // Initialize Customer TomSelect
                    this.$nextTick(() => {
                        new TomSelect(this.$refs.customerSelect, {
                            create: false,
                            sortField: {
                                field: "text",
                                direction: "asc"
                            }
                        });
                    });

                    // Check if there's old data (from validation error)
                    const oldItems = @json(old('items', []));
                    if (oldItems.length > 0) {
                        oldItems.forEach(item => {
                            this.items.push({
                                id: this.itemCounter++,
                                product_id: item.product_id,
                                quantity: parseFloat(item.quantity),
                                notes: item.notes || ''
                            });
                        });
                        this.$nextTick(() => {
                            this.items.forEach((item, index) => {
                                this.initTomSelect(item.id, index, item.product_id);
                            });
                        });
                    } else {
                        this.addItem();
                    }
                },

                addItem() {
                    const newId = this.itemCounter++;
                    this.items.push({
                        id: newId,
                        product_id: '',
                        quantity: 1,
                        notes: ''
                    });
                    
                    this.$nextTick(() => {
                        this.initTomSelect(newId, this.items.length - 1);
                    });
                },

                initTomSelect(id, index, initialValue = '') {
                    const selectEl = document.getElementById(`productSelect${id}`);
                    if (!selectEl) return;
                    
                    const ts = new TomSelect(selectEl, {
                        create: false,
                        sortField: { field: "text", direction: "asc" },
                        onChange: (value) => {
                            const currentIndex = this.items.findIndex(i => i.id === id);
                            if (currentIndex !== -1) {
                                this.items[currentIndex].product_id = value;
                            }
                        }
                    });

                    if (initialValue) {
                        ts.setValue(initialValue);
                    }
                },

                removeItem(index) {
                    this.items.splice(index, 1);
                }
            }
        }
    </script>
    @endpush
</x-admin-layout>
