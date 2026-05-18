<x-admin-layout>
    <x-slot name="title">Data Customer</x-slot>
    <x-slot name="header">Kelola Data Customer</x-slot>

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
                <h2 class="page-title">Daftar Customer</h2>
                <p class="page-subtitle">Reseller dan pelanggan terdaftar</p>
            </div>
            <a href="{{ route('customers.create') }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Customer
            </a>
        </div>

        <form action="{{ route('customers.index') }}" method="GET">
            <div class="card shadow-card" style="padding:1rem 1.25rem;">
                <div class="flex gap-3 items-center">
                    <div class="search-bar flex-1">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama toko atau pemilik...">
                    </div>
                    <button type="submit" class="btn btn-soft btn-sm">Cari</button>
                    @if(request('search'))
                        <a href="{{ route('customers.index') }}" class="btn btn-ghost btn-sm">Reset</a>
                    @endif
                </div>
            </div>
        </form>

        <div class="card shadow-card overflow-hidden">
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nama Toko / Pemilik</th>
                            <th>Area Pasar</th>
                            <th>WhatsApp</th>
                            <th class="text-right" style="width:110px;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($customers as $customer)
                            <tr>
                                <td>
                                    <p class="font-semibold" style="color:var(--text-primary);">{{ $customer->nama_toko }}</p>
                                    <p class="text-xs mt-0.5" style="color:var(--text-muted);">{{ $customer->nama_pemilik }}</p>
                                </td>
                                <td style="color:var(--text-secondary);">{{ $customer->alamat_pasar }}</td>
                                <td style="color:var(--text-secondary);">{{ $customer->no_whatsapp }}</td>
                                <td class="text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <a href="{{ route('customers.show', $customer) }}" class="icon-btn icon-btn-view" title="Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        <a href="{{ route('customers.edit', $customer) }}" class="icon-btn icon-btn-edit" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <button type="button"
                                            class="icon-btn icon-btn-delete"
                                            title="Hapus"
                                            @click="confirmDelete('{{ addslashes($customer->nama_toko) }}', '{{ route('customers.destroy', $customer) }}')">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center py-14" style="color:var(--text-muted);">
                                    <svg class="w-10 h-10 mx-auto mb-3 opacity-30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                                    <p class="font-medium">Belum ada data customer</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            @if(isset($customers) && method_exists($customers, 'hasPages') && $customers->hasPages())
                <div class="px-5 py-3" style="border-top:1px solid var(--border-soft);">
                    {{ $customers->links() }}
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
                    <h3 class="session-modal-title">Konfirmasi Hapus Customer</h3>
                    <p class="session-modal-text">
                        Apakah Anda yakin ingin menghapus customer
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
