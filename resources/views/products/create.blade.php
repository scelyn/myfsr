<x-admin-layout>
    <x-slot name="title">Tambah Barang Baru</x-slot>
    <x-slot name="header">Tambah Barang Baru</x-slot>

    <div class="max-w-2xl mx-auto">
        <a href="{{ route('products.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-theme-text2 hover:text-white transition-colors mb-6 group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar
        </a>

        <form action="{{ route('products.store') }}" method="POST"
              x-data="{ harga_beli_default: {{ old('harga_beli_default', 0) }}, margin_default: {{ old('margin_default', 0) }} }">
            @csrf

            <div class="bg-theme-card rounded-2xl border border-theme-border shadow-md shadow-sm p-8 space-y-6">
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-widest mb-5">Informasi Barang</h3>
                    
                    {{-- Nama Barang --}}
                    <div class="space-y-1.5 mb-5">
                        <label class="text-xs font-bold text-theme-text2 uppercase tracking-wider">Nama Barang <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_barang" value="{{ old('nama_barang') }}"
                               placeholder="Contoh: Beras Pandan Wangi 5kg"
                               class="w-full px-4 py-3 bg-theme-bg border {{ $errors->has('nama_barang') ? 'border-red-400' : 'border-theme-border' }} rounded-xl text-sm font-medium text-white placeholder-slate-400 focus:ring-2 focus:ring-emerald-500/20 focus:border-theme-success outline-none transition-all"
                               autofocus>
                        @error('nama_barang')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>

                    {{-- Satuan --}}
                    <div class="space-y-1.5">
                        <label class="text-xs font-bold text-theme-text2 uppercase tracking-wider">Satuan <span class="text-red-500">*</span></label>
                        <select name="satuan" class="w-full px-4 py-3 bg-theme-bg border {{ $errors->has('satuan') ? 'border-red-400' : 'border-theme-border' }} rounded-xl text-sm font-medium text-white focus:ring-2 focus:ring-emerald-500/20 focus:border-theme-success outline-none transition-all">
                            @foreach(['kg', 'dus', 'pcs', 'liter', 'pack', 'karung', 'sak', 'bal', 'butir'] as $u)
                                <option value="{{ $u }}" {{ old('satuan') == $u ? 'selected' : '' }}>{{ strtoupper($u) }}</option>
                            @endforeach
                        </select>
                        @error('satuan')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                    </div>
                </div>

                <hr class="border-theme-border">

                {{-- Harga & Profit --}}
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-widest mb-5">Harga & Keuntungan Default</h3>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 mb-5">
                        {{-- Harga Beli --}}
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-theme-text2 uppercase tracking-wider">Harga Beli Default <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xs font-bold text-theme-text2">Rp</span>
                                <input type="number" name="harga_beli_default" x-model.number="harga_beli_default"
                                       value="{{ old('harga_beli_default') }}" min="0" step="500"
                                       class="w-full pl-10 pr-4 py-3 bg-theme-bg border {{ $errors->has('harga_beli_default') ? 'border-red-400' : 'border-theme-border' }} rounded-xl text-sm font-medium text-white focus:ring-2 focus:ring-emerald-500/20 focus:border-theme-success outline-none transition-all">
                            </div>
                            @error('harga_beli_default')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Margin Default --}}
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-theme-text2 uppercase tracking-wider">Margin (Keuntungan) Default <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-xs font-bold text-theme-text2">Rp</span>
                                <input type="number" name="margin_default" x-model.number="margin_default"
                                       value="{{ old('margin_default') }}" min="0" step="500"
                                       class="w-full pl-10 pr-4 py-3 bg-theme-bg border {{ $errors->has('margin_default') ? 'border-red-400' : 'border-theme-border' }} rounded-xl text-sm font-medium text-white focus:ring-2 focus:ring-emerald-500/20 focus:border-theme-success outline-none transition-all">
                            </div>
                            @error('margin_default')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>

                    {{-- Realtime Profit Preview --}}
                    <div class="bg-slate-100 rounded-xl p-5 flex items-center justify-between">
                        <div>
                            <p class="text-[10px] font-bold text-theme-text2 uppercase tracking-widest">Estimasi Harga Jual</p>
                            <div class="text-2xl font-black text-theme-text1 mt-1" 
                                 x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(harga_beli_default + margin_default)">
                                Rp 0
                            </div>
                        </div>
                        <div class="text-right">
                            <p class="text-[10px] font-bold text-theme-text2 uppercase tracking-widest">Persentase Margin</p>
                            <div class="text-xl font-black text-emerald-600 mt-1"
                                 x-text="harga_beli_default > 0 ? Math.round((margin_default / harga_beli_default) * 100) + '%' : '0%'">
                                0%
                            </div>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-2 border-t border-theme-border">
                    <a href="{{ route('products.index') }}" class="px-6 py-2.5 bg-theme-sidebar text-theme-text1 text-sm font-semibold rounded-xl hover:bg-theme-border transition-colors">
                        Batal
                    </a>
                    <button type="submit" class="px-8 py-2.5 bg-slate-100 hover:bg-theme-card text-theme-text1 text-sm font-bold rounded-xl shadow-lg transition-all hover:-translate-y-0.5">
                        Simpan Barang
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-admin-layout>
