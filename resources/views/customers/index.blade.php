<x-admin-layout>
    <x-slot name="title">Data Customer</x-slot>
    <x-slot name="header">Data Customer</x-slot>

    <div class="space-y-6" x-data="{ showDeleteModal: false, deleteUrl: '', deleteName: '' }">

        {{-- Toast --}}
        @if(session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 3500)"
             x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="fixed top-6 right-6 z-50 flex items-center gap-3 bg-theme-card border border-theme-success shadow-2xl shadow-emerald-100/50 px-5 py-4 rounded-2xl">
            <div class="w-8 h-8 bg-theme-success/40 rounded-xl flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>
            <p class="text-sm font-semibold text-theme-text1">{{ session('success') }}</p>
            <button @click="show = false" class="ml-2 text-slate-300 hover:text-theme-text2"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg></button>
        </div>
        @endif

        {{-- Actions --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <form action="{{ route('customers.index') }}" method="GET" class="relative w-full sm:w-80">
                <svg class="absolute left-3.5 top-1/2 -translate-y-1/2 w-4 h-4 text-theme-text2 pointer-events-none" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama toko, pemilik, WA..."
                    class="w-full pl-10 pr-4 py-2.5 bg-theme-card border border-theme-border rounded-xl text-sm text-theme-text1 placeholder-slate-400 focus:ring-2 focus:ring-emerald-500/20 focus:border-theme-success shadow-md shadow-sm transition-all outline-none">
            </form>
            <a href="{{ route('customers.create') }}"
               class="inline-flex items-center gap-2 px-5 py-2.5 bg-slate-100 hover:bg-theme-card text-theme-text1 text-sm font-semibold rounded-xl shadow-lg transition-all hover:-translate-y-0.5 shrink-0">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Tambah Customer
            </a>
        </div>

        {{-- Table --}}
        <div class="bg-theme-card rounded-2xl border border-theme-border shadow-md shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead>
                        <tr class="border-b border-theme-border bg-theme-bg/70">
                            <th class="px-6 py-3.5 text-[11px] font-bold text-theme-text2 uppercase tracking-wider">Nama Toko</th>
                            <th class="px-6 py-3.5 text-[11px] font-bold text-theme-text2 uppercase tracking-wider">Pemilik</th>
                            <th class="px-6 py-3.5 text-[11px] font-bold text-theme-text2 uppercase tracking-wider">WhatsApp</th>
                            <th class="px-6 py-3.5 text-[11px] font-bold text-theme-text2 uppercase tracking-wider">Piutang Aktif</th>
                            <th class="px-6 py-3.5 text-[11px] font-bold text-theme-text2 uppercase tracking-wider">Total Order</th>
                            <th class="px-6 py-3.5 text-[11px] font-bold text-theme-text2 uppercase tracking-wider text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50">
                        @forelse($customers as $customer)
                            <tr class="hover:bg-theme-bg/60 transition-colors group">
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-9 h-9 bg-slate-100/10 rounded-xl flex items-center justify-center text-white text-sm font-black shrink-0">
                                            {{ strtoupper(substr($customer->nama_toko, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div class="font-semibold text-white">{{ $customer->nama_toko }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-theme-text1 font-medium">{{ $customer->nama_pemilik }}</td>
                                <td class="px-6 py-4">
                                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $customer->no_whatsapp) }}" target="_blank"
                                       class="flex items-center gap-1.5 text-sm text-emerald-600 hover:text-emerald-600 font-medium">
                                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                        {{ $customer->no_whatsapp }}
                                    </a>
                                </td>
                                <td class="px-6 py-4">
                                    @php $piutang = $customer->total_piutang ?? 0; @endphp
                                    <span class="font-bold {{ $piutang > 0 ? 'text-red-500' : 'text-theme-text2' }}">
                                        Rp {{ number_format($piutang, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">
                                    <span class="text-[#253745] font-semibold">{{ $customer->orders_count ?? 0 }}</span>
                                    <span class="text-theme-text2 text-xs ml-1">order</span>
                                </td>
                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                        <a href="{{ route('customers.show', $customer) }}"
                                           class="p-2 text-theme-text2 hover:text-emerald-600 hover:bg-theme-success/20 rounded-lg transition-all" title="Detail">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                        </a>
                                        <a href="{{ route('customers.edit', $customer) }}"
                                           class="p-2 text-theme-text2 hover:text-blue-600 hover:bg-blue-50 rounded-lg transition-all" title="Edit">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </a>
                                        <button
                                            @click="showDeleteModal = true; deleteUrl = '{{ route('customers.destroy', $customer) }}'; deleteName = '{{ addslashes($customer->nama_toko) }}'"
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
                                            <svg class="w-7 h-7 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                        </div>
                                        <p class="text-sm font-medium text-theme-text2">Belum ada data customer.</p>
                                        <a href="{{ route('customers.create') }}" class="text-sm font-semibold text-emerald-600 hover:underline">+ Tambah customer baru</a>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($customers->hasPages())
                <div class="px-6 py-4 border-t border-theme-border bg-theme-bg/40">
                    {{ $customers->links() }}
                </div>
            @endif
        </div>

        {{-- Delete Confirmation Modal --}}
        <div x-show="showDeleteModal" x-cloak class="fixed inset-0 z-50 flex items-center justify-center p-4"
             x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100">
            <div class="absolute inset-0 bg-slate-900/40 backdrop-blur-sm" @click="showDeleteModal = false"></div>
            <div class="relative bg-theme-card rounded-2xl shadow-2xl p-8 max-w-sm w-full"
                 x-transition:enter="transition ease-out duration-200" x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100">
                <div class="w-12 h-12 bg-theme-error/40 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
                </div>
                <h3 class="text-lg font-bold text-center text-white mb-1">Hapus Customer?</h3>
                <p class="text-sm text-center text-theme-text2 mb-6">Customer <strong x-text="deleteName" class="text-theme-text1"></strong> akan dihapus dari sistem.</p>
                <div class="flex gap-3">
                    <button @click="showDeleteModal = false" class="flex-1 px-4 py-2.5 bg-theme-sidebar text-theme-text1 font-semibold rounded-xl hover:bg-theme-border transition-colors text-sm">Batal</button>
                    <form :action="deleteUrl" method="POST" class="flex-1">
                        @csrf @method('DELETE')
                        <button type="submit" class="w-full px-4 py-2.5 bg-red-600 text-theme-text1 font-semibold rounded-xl hover:bg-red-700 transition-colors text-sm">Ya, Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
