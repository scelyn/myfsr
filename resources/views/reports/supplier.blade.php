<x-admin-layout>
    <x-slot name="title">Rekap Supplier Harian</x-slot>
    <x-slot name="header">Rekap Pesanan Supplier</x-slot>

    <div class="content-section max-w-5xl mx-auto">
        {{-- Controls (hidden on print) --}}
        <div class="card shadow-card p-4 print:hidden">
            <div class="flex flex-wrap gap-4 items-end justify-between">
                <form action="{{ route('reports.supplier') }}" method="GET" class="flex gap-3 items-end">
                    <div class="form-group">
                        <label class="form-label">Pilih Tanggal Rekap</label>
                        <div class="flex gap-2">
                            <input type="date" name="date" value="{{ request('date', $date) }}" class="form-input">
                            <button type="submit" class="btn btn-primary btn-sm">Filter</button>
                        </div>
                    </div>
                </form>

                <div class="flex gap-2 flex-wrap">
                    @php
                        $waText = "Halo Supplier,\n\nBerikut rekap pesanan hari ini:\n\n";
                        foreach($rekaps as $rekap) {
                            $waText .= "- " . $rekap->product_name . " : " . floatval($rekap->total_qty) . " " . $rekap->product_unit . "\n";
                        }
                        $waText .= "\nTerima kasih.";
                        $waUrl = "https://wa.me/?text=" . urlencode($waText);
                    @endphp

                    <a href="{{ $waUrl }}" target="_blank" class="btn btn-soft btn-sm">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24" style="color:#25d366;"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.168-.01-.345-.012-.52-.012-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/></svg>
                        Share WA
                    </a>

                    <div class="relative" x-data="{ printOpen: false }">
                        <button @click="printOpen = !printOpen" @click.away="printOpen = false"
                                class="btn btn-primary btn-sm">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                            Cetak Rekap
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                        </button>
                        <div x-show="printOpen" x-cloak x-transition.opacity
                             class="absolute right-0 mt-1 w-48 card shadow-elevated z-40 overflow-hidden py-1">
                            <a href="{{ route('reports.supplier.print', ['date' => $date]) }}" target="_blank"
                               class="block px-4 py-2.5 text-sm hover:bg-[#eef2f5] transition-colors" style="color:var(--text-primary); border-bottom:1px solid var(--border-soft);">
                                Unduh PDF Standar
                            </a>
                             <button onclick="printRekap('a4')" class="w-full text-left px-4 py-2.5 text-sm hover:bg-[#eef2f5] transition-colors" style="color:var(--text-primary);">Print A4</button>
                             <button onclick="printRekap('letter')" class="w-full text-left px-4 py-2.5 text-sm hover:bg-[#eef2f5] transition-colors" style="color:var(--text-primary);">Print Letter</button>
                             <button onclick="printRekap('thermal80')" class="w-full text-left px-4 py-2.5 text-sm hover:bg-[#eef2f5] transition-colors" style="color:var(--text-primary);">Thermal 80mm</button>
                             <button onclick="printRekap('thermal58')" class="w-full text-left px-4 py-2.5 text-sm hover:bg-[#eef2f5] transition-colors" style="color:var(--text-primary);">Thermal 58mm</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Print document --}}
        <x-print-document size="a4" class="card shadow-card overflow-hidden">
            <div class="px-8 py-6 flex items-center justify-between" style="border-bottom:2px solid var(--border-soft); background-color:var(--bg-surface);">
                <div>
                    <h2 class="text-2xl font-black uppercase tracking-widest" style="color:var(--text-primary);">Rekap Supplier</h2>
                    <p class="text-sm mt-1" style="color:var(--text-secondary);">Gabungan pesanan untuk supply barang harian</p>
                </div>
                <div class="text-right">
                    <p class="form-label mb-1">Tanggal Eksekusi</p>
                    <p class="text-lg font-black" style="color:var(--text-primary);">{{ \Carbon\Carbon::parse($date)->format('d F Y') }}</p>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th class="text-center w-16">No</th>
                            <th>Nama Barang</th>
                            <th class="text-center">Qty</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($rekaps as $rekap)
                            <tr>
                                <td class="text-center" style="color:var(--text-muted);">{{ $loop->iteration }}</td>
                                <td class="font-semibold" style="color:var(--text-primary);">{{ $rekap->product_name }}</td>
                                <td class="text-center">
                                    <span class="font-black" style="color:var(--text-primary);">{{ floatval($rekap->total_qty) }}</span>
                                    <span class="text-xs ml-1 uppercase" style="color:var(--text-muted);">{{ $rekap->product_unit }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-16" style="color:var(--text-muted);">
                                    <p class="font-medium">Belum ada transaksi di tanggal ini.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </x-print-document>
    </div>

    @push('scripts')
    <script>
        function printRekap(size) {
            document.body.classList.remove('print-a4', 'print-letter', 'print-thermal58', 'print-thermal80');
            document.body.classList.add('print-' + size);
            window.print();
        }
    </script>
    @endpush
</x-admin-layout>
