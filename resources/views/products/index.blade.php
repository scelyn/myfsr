<x-admin-layout>
    <x-slot name="title">Data Produk</x-slot>
    <x-slot name="header">Kelola Data Produk</x-slot>

    <div class="content-section" x-data="{
        showDeleteModal: false,
        deleteName: '',
        deleteAction: '',
        confirmDelete(name, action) {
            this.deleteName = name;
            this.deleteAction = action;
            this.showDeleteModal = true;
        },
        submitDelete() {
            this.$refs.deleteForm.action = this.deleteAction;
            this.$refs.deleteForm.submit();
        }
    }">
        <div class="page-header">
            <div>
                <h2 class="page-title">Daftar Produk</h2>
                <p class="page-subtitle">Master data barang yang tersedia untuk transaksi</p>
            </div>
            <a href="{{ route('products.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Produk
            </a>
        </div>

        {{-- Filter --}}
        <form action="{{ route('products.index') }}" method="GET">
            <div class="card shadow-card" style="padding:1rem 1.25rem;">
                <div class="flex gap-3 items-center">
                    <div class="search-bar flex-1">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk...">
                    </div>
                    <button type="submit" class="btn btn-soft btn-sm">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('products.index') }}" class="btn btn-ghost btn-sm">Reset</a>
                    @endif
                </div>
            </div>
        </form>

        {{-- Table --}}
        <div class="card shadow-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama Barang</th>
                            <th>Satuan</th>
                            <th class="text-right">Harga Beli Default</th>
                            <th class="text-right">Margin Default</th>
                            <th class="text-right" style="width:100px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($products as $product)
                            <tr>
                                <td>
                                    <p class="font-semibold" style="color:var(--text-primary);">{{ $product->nama_barang }}</p>
                                </td>
                                <td>
                                    <span class="badge badge-neutral">{{ strtoupper($product->satuan) }}</span>
                                </td>
                                <td class="text-right font-medium" style="color:var(--text-secondary);">
                                    Rp {{ \App\Helpers\NumberHelper::format($product->harga_beli_default) }}
                                </td>
                                <td class="text-right font-semibold" style="color:var(--color-success);">
                                    +Rp {{ \App\Helpers\NumberHelper::format($product->margin_default) }}
                                </td>
                                <td class="text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('products.edit', $product) }}" class="icon-btn icon-btn-edit" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <button type="button"
                                            class="icon-btn icon-btn-delete"
                                            title="Hapus"
                                            @click="confirmDelete('{{ addslashes($product->nama_barang) }}', '{{ route('products.destroy', $product) }}')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-16" style="color:var(--text-muted);">
                                    <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
                                    <p class="font-medium">Belum ada data produk</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if($products->hasPages())
                <div class="px-5 py-3" style="border-top:1px solid var(--border-soft);">
                    {{ $products->links() }}
                </div>
            @endif
        </div>

        {{-- ===== DELETE CONFIRMATION MODAL ===== --}}
        <div x-cloak x-show="showDeleteModal"
             class="session-modal-backdrop"
             @click="showDeleteModal = false"
             @keydown.escape.window="showDeleteModal = false">

            <div x-show="showDeleteModal"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 @click.stop
                 class="session-modal-panel" style="max-width:26rem;">

                <div class="session-modal-body">
                    <div class="session-modal-icon session-modal-icon--danger">
                        <svg width="28" height="28" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="1.75">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                        </svg>
                    </div>
                    <h3 class="session-modal-title">Konfirmasi Hapus Produk</h3>
                    <p class="session-modal-text">
                        Apakah Anda yakin ingin menghapus produk
                        <strong x-text="deleteName" style="color:var(--text-primary);"></strong>?
                        <br><span style="color:var(--text-muted); font-size:0.75rem;">Data yang sudah dihapus tidak dapat dikembalikan.</span>
                    </p>
                </div>

                <div class="session-modal-actions">
                    <button @click="showDeleteModal = false" class="btn btn-ghost" style="min-width:100px;">Batal</button>
                    <button @click="submitDelete()" class="btn session-btn-danger" style="min-width:100px;">
                        <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        Hapus
                    </button>
                </div>
            </div>
        </div>

        {{-- Hidden delete form (shared by all rows) --}}
        <form x-ref="deleteForm" method="POST" action="" class="hidden">
            @csrf
            @method('DELETE')
        </form>
    </div>
</x-admin-layout>
