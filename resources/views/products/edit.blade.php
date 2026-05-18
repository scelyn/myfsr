<x-admin-layout>
    <x-slot name="title">Edit Produk</x-slot>
    <x-slot name="header">Edit Data Produk</x-slot>

    <div class="max-w-2xl">
        <a href="{{ route('products.index') }}" class="back-link">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Produk
        </a>

        <form action="{{ route('products.update', $product) }}" method="POST"
              x-data="{ harga_beli: {{ old('harga_beli_default', $product->harga_beli_default) }}, margin: {{ old('margin_default', $product->margin_default) }} }">
            @csrf @method('PUT')
            <section class="card shadow-card">
                <div class="card-header"><h3>Edit: {{ $product->nama_barang }}</h3></div>
                <div class="p-6 space-y-5">
                    <div class="form-group">
                        <label class="form-label">Nama Barang <span style="color:var(--color-danger);">*</span></label>
                        <input type="text" name="nama_barang" value="{{ old('nama_barang', $product->nama_barang) }}"
                               class="form-input {{ $errors->has('nama_barang') ? 'error' : '' }}" autofocus>
                        @error('nama_barang')<p class="text-xs" style="color:var(--color-danger);">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">Satuan <span style="color:var(--color-danger);">*</span></label>
                        <select name="satuan" class="form-input {{ $errors->has('satuan') ? 'error' : '' }}">
                            @foreach(['kg','dus','pcs','liter','pack','karung','sak','bal','butir'] as $u)
                                <option value="{{ $u }}" {{ old('satuan', $product->satuan) == $u ? 'selected' : '' }}>{{ strtoupper($u) }}</option>
                            @endforeach
                        </select>
                        @error('satuan')<p class="text-xs" style="color:var(--color-danger);">{{ $message }}</p>@enderror
                    </div>
                    <hr class="divider">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="form-group">
                            <label class="form-label">Harga Beli Default <span style="color:var(--color-danger);">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold" style="color:var(--text-muted);">Rp</span>
                                <input type="number" name="harga_beli_default" x-model.number="harga_beli"
                                       value="{{ old('harga_beli_default', $product->harga_beli_default) }}" min="0" step="500"
                                       class="form-input pl-9">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Margin Default <span style="color:var(--color-danger);">*</span></label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-xs font-bold" style="color:var(--text-muted);">Rp</span>
                                <input type="number" name="margin_default" x-model.number="margin"
                                       value="{{ old('margin_default', $product->margin_default) }}" min="0" step="500"
                                       class="form-input pl-9">
                            </div>
                        </div>
                    </div>
                    <div class="rounded-xl p-4 flex justify-between items-center"
                         style="background-color:var(--bg-surface); border:1px solid var(--border-soft);">
                        <div>
                            <p class="form-label mb-1">Estimasi Harga Jual</p>
                            <p class="text-xl font-black" style="color:var(--text-primary);"
                               x-text="'Rp ' + new Intl.NumberFormat('id-ID').format(harga_beli + margin)"></p>
                        </div>
                        <div class="text-right">
                            <p class="form-label mb-1">Margin %</p>
                            <p class="text-lg font-black" style="color:var(--color-success);"
                               x-text="harga_beli > 0 ? Math.round((margin / harga_beli) * 100) + '%' : '0%'"></p>
                        </div>
                    </div>
                </div>
                <div class="px-6 py-4 flex justify-end gap-3"
                     style="border-top:1px solid var(--border-soft); background-color:var(--bg-surface);">
                    <a href="{{ route('products.index') }}" class="btn btn-ghost">Batal</a>
                    <button type="submit" class="btn btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Simpan Perubahan
                    </button>
                </div>
            </section>
        </form>
    </div>
</x-admin-layout>
