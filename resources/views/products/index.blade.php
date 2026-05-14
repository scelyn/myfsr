<x-admin-layout>
    <x-slot name="title">Master Produk</x-slot>
    <x-slot name="header">Master Data Produk</x-slot>

    <div class="space-y-6" x-data="{ showDeleteModal: false, deleteUrl: '', deleteName: '' }">

        {{-- Toast Notification --}}
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-2"
             x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed top-6 right-6 z-50 flex items-center gap-3 bg-theme-card border border-theme-success shadow-2xl shadow-emerald-100/50 px-5 py-4 rounded-2xl">
            <div class="w-8 h-8 bg-theme-success/40 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-theme-successText" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <p class="text-sm font-semibold text-theme-text1">{{ session('success') }}</p>
            <button @click="show = false" class="ml-2 text-slate-300 hover:text-theme-text2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        @endif

        {{-- Actions & Search --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <form action="{{ route('products.index') }}" method="GET" class="relative w-full sm:w-80">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-theme-text2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama barang..."
                    class="w-full pl-10 pr-4 py-2.5 bg-theme-card border border-theme-border rounded-xl text-sm text-theme-text1 placeholder-slate-400 focus:ring-2 focus:ring-emerald-500/20 focus:border-theme-success shadow-md shadow-black/20 transition-all outline-none">
            </form>
            <a href="{{ route('products.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#06141B] hover:bg-[#11212D] text-theme-text1 text-sm font-semibold rounded-xl shadow-lg transition-all hover:-translate-y-0.5 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Barang
            </a>
        </div>

        {{-- Table Card --}}
        <div class="bg-theme-card rounded-2xl border border-theme-border shadow-md shadow-black/20 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-theme-border bg-theme-bg/70">
                            <th class="px-6 py-3.5 text-[11px] font-bold text-theme-text2 uppercase tracking-wider">Nama Barang</th>
                            <th class="px-6 py-3.5 text-[11px] font-bold text-theme-text2 uppercase tracking-wider">Satuan</th>
                            <th class="px-6 py-3.5 text-[11px] font-bold text-theme-text2 uppercase tracking-wider">Harga Beli Default</th>
                            <th class="px-6 py-3.5 text-[11px] font-bold text-theme-text2 uppercase tracking-wider">Margin Default</th>
                            <th class="px-6 py-3.5 text-[11px] font-bold text-theme-text2 uppercase tracking-wider">Est. Harga Jual</th>
                            <th class="px-6 py-3.5 text-[11px] font-bold text-theme-text2 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($products as $product)
                            <tr class="hover:bg-theme-bg/60 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="font-semibold text-[#06141B]">{{ $product->nama_barang }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="px-2.5 py-1 bg-[#253745]/10 text-[#253745] text-[11px] font-bold rounded-lg uppercase tracking-wider">{{ $product->satuan }}</span>
                                </td>
                                <td class="px-6 py-4 text-[#4A5C6A] font-medium">
                                    Rp {{ number_format($product->harga_beli_default, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 font-bold text-theme-successText">
                                    + Rp {{ number_format($product->margin_default, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 font-black text-[#11212D]">
                                    Rp {{ number_format($product->harga_beli_default + $product->margin_default, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('products.edit', $product) }}"
                                           class="p-2 text-theme-text2 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <button
                                            @click="showDeleteModal = true; deleteUrl = '{{ route('products.destroy', $product) }}'; deleteName = '{{ addslashes($product->nama_barang) }}'"
                                            class="p-2 text-theme-text2 hover:text-red-500 hover:bg-theme-error/20 rounded-lg transition-all" title="Hapus">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-6 py-20 text-center">
                                    <div class="flex flex-col items-center gap-3">
                                        <div class="w-14 h-14 bg-theme-sidebar rounded-2xl flex items-center justify-center">
                                            <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4"/></svg>
                                        </div>
                                        <p class="text-sm font-medium text-theme-text2">Belum ada barang di Master Data.</p>
                                        <a href="{{ route('products.create') }}" class="text-sm font-semibold text-theme-successText hover:underline">+ Tambah barang baru</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($products->hasPages())
                <div class="px-6 py-4 border-t border-theme-border bg-theme-bg/40">
                    {{ $products->links() }}
                </div>
            @endif
        </div>

        {{-- Delete Confirmation Modal --}}
        <div x-show="showDeleteModal" x-cloak
             class="fixed inset-0 z-50 flex items-center justify-center p-4"
             x-transition:enter="transition ease-out duration-200"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100">
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" @click="showDeleteModal = false"></div>
            <div class="relative bg-theme-card rounded-2xl shadow-2xl p-8 max-w-sm w-full"
                 x-transition:enter="transition ease-out duration-200"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100">
                <div class="w-12 h-12 bg-theme-error/40 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-theme-errorText" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-center text-[#06141B] mb-1">Hapus Barang?</h3>
                <p class="text-sm text-center text-theme-text2 mb-6">Barang <strong x-text="deleteName" class="text-theme-text1"></strong> akan dihapus secara permanen.</p>
                <div class="flex gap-3">
                    <button @click="showDeleteModal = false"
                            class="flex-1 px-4 py-2.5 bg-theme-sidebar text-theme-text1 font-semibold rounded-xl hover:bg-theme-border transition-colors text-sm">
                        Batal
                    </button>
                    <form :action="deleteUrl" method="POST" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2.5 bg-red-600 text-theme-text1 font-semibold rounded-xl hover:bg-red-700 transition-colors text-sm">
                            Ya, Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
