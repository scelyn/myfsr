<x-admin-layout>
    <x-slot name="title">Rekap Supplier Harian</x-slot>
    <x-slot name="header">Rekap Pesanan Supplier</x-slot>

    <div class="space-y-8 max-w-6xl mx-auto">
        <!-- Filter & Actions Header (Hidden when printing) -->
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 bg-[#11212D] p-6 rounded-2xl border border-[#253745] shadow-md shadow-black/20 print:hidden">
            <form action="{{ route('reports.supplier') }}" method="GET" class="flex-1 max-w-sm">
                <div class="space-y-1.5">
                    <label class="text-[10px] font-bold text-[#9BA8AB] uppercase tracking-widest ml-1">Pilih Tanggal Rekap</label>
                    <div class="flex gap-2">
                        <input 
                            type="date" 
                            name="date" 
                            value="{{ request('date', $date) }}"
                            class="w-full px-4 py-2.5 bg-[#06141B] border border-[#253745] text-[#CCD0CF] rounded-xl text-sm focus:ring-2 focus:ring-[#9BA8AB]/20 focus:border-[#9BA8AB] transition-all outline-none"
                        >
                        <button type="submit" class="bg-[#253745] hover:bg-[#4A5C6A] text-[#CCD0CF] hover:text-theme-text1 px-5 py-2.5 rounded-xl text-sm font-bold transition-all shadow-md shadow-black/20">
                            Filter
                        </button>
                    </div>
                </div>
            </form>
            
            <div class="flex items-center gap-3">
                @php
                    $waText = "Halo Supplier,\n\nBerikut rekap pesanan hari ini:\n\n";
                    foreach($rekaps as $rekap) {
                        $waText .= "- " . $rekap->product_name . " : " . floatval($rekap->total_qty) . " " . $rekap->product_unit . "\n";
                    }
                    $waText .= "\nTerima kasih.";
                    $waUrl = "https://wa.me/?text=" . urlencode($waText);
                @endphp
                
                <a href="{{ $waUrl }}" target="_blank" class="inline-flex items-center gap-2 px-5 py-2.5 bg-[#25D366] text-theme-text1 text-sm font-bold rounded-xl shadow-lg shadow-[#25D366]/20 hover:bg-[#128C7E] transition-all">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.414 0 0 5.414 0 12.05c0 2.123.552 4.197 1.601 6.02L0 24l6.135-1.61a11.87 11.87 0 005.91 1.56h.005c6.637 0 12.05-5.414 12.05-12.05a11.816 11.816 0 00-3.486-8.525z"/></svg>
                    <span>Share WA</span>
                </a>

                <div class="relative" x-data="{ printOpen: false }">
                    <button @click="printOpen = !printOpen" @click.away="printOpen = false" class="inline-flex items-center gap-2 px-5 py-2.5 bg-theme-sidebar hover:bg-theme-border border border-theme-border text-theme-text1 text-sm font-bold rounded-xl transition-all shadow-md shadow-black/20">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
                        <span>Cetak Rekap</span>
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                    </button>
                    
                    <div x-show="printOpen" x-transition.opacity class="absolute right-0 mt-2 w-48 bg-theme-card border border-theme-border rounded-xl shadow-lg z-50 overflow-hidden" style="display: none;">
                        <a href="{{ route('reports.supplier.print', ['date' => $date]) }}" target="_blank" class="block px-4 py-3 text-sm text-theme-text1 hover:bg-theme-sidebar border-b border-theme-border">
                            Unduh PDF Standar
                        </a>
                        <button onclick="printRekap('a4')" class="w-full text-left px-4 py-3 text-sm text-theme-text1 hover:bg-theme-sidebar border-b border-theme-border">
                            Print Ukuran A4
                        </button>
                        <button onclick="printRekap('letter')" class="w-full text-left px-4 py-3 text-sm text-theme-text1 hover:bg-theme-sidebar border-b border-theme-border">
                            Print Ukuran Letter
                        </button>
                        <button onclick="printRekap('thermal80')" class="w-full text-left px-4 py-3 text-sm text-theme-text1 hover:bg-theme-sidebar border-b border-theme-border">
                            Print Thermal 80mm
                        </button>
                        <button onclick="printRekap('thermal58')" class="w-full text-left px-4 py-3 text-sm text-theme-text1 hover:bg-theme-sidebar">
                            Print Thermal 58mm
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Supplier Sheet Print Document -->
        <div class="bg-theme-card rounded-2xl shadow-md shadow-black/20 border border-theme-border overflow-hidden print:border-none print:shadow-none">
            <!-- Header -->
            <div class="px-10 py-8 border-b-2 border-theme-border flex items-center justify-between print:px-0">
                <div>
                    <h2 class="text-3xl font-black text-[#06141B] tracking-widest uppercase">REKAP SUPPLIER</h2>
                    <p class="text-theme-text2 font-medium mt-1">Gabungan pesanan untuk supply barang harian</p>
                </div>
                <div class="text-right">
                    <p class="text-[10px] font-black text-theme-text2 uppercase tracking-widest mb-1">Tanggal Eksekusi</p>
                    <p class="text-xl font-black text-[#06141B]">{{ \Carbon\Carbon::parse($date)->format('d F Y') }}</p>
                </div>
            </div>

            <!-- Table content -->
            <div class="overflow-x-auto print:overflow-visible">
                <table class="w-full text-left">
                    <thead class="bg-theme-bg/50 border-y-2 border-theme-border sticky top-0 z-10">
                        <tr>
                            <th class="px-10 py-4 text-[10px] font-black text-theme-text2 uppercase tracking-widest w-16 text-center print:px-4">No</th>
                            <th class="px-6 py-4 text-[10px] font-black text-theme-text2 uppercase tracking-widest print:px-2">Nama Barang</th>
                            <th class="px-6 py-4 text-[10px] font-black text-theme-text2 uppercase tracking-widest text-center print:px-2">Qty</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($rekaps as $rekap)
                            <tr class="hover:bg-theme-bg/30 transition-colors">
                                <td class="px-10 py-5 text-center text-sm font-bold text-theme-text2 print:px-4">{{ $loop->iteration }}</td>
                                <td class="px-6 py-5 print:px-2">
                                    <div class="text-sm font-black text-[#06141B]">{{ $rekap->product_name }}</div>
                                </td>
                                <td class="px-6 py-5 text-center print:px-2">
                                    <span class="text-sm font-black text-[#06141B]">{{ floatval($rekap->total_qty) }}</span>
                                    <span class="text-[10px] font-bold text-theme-text2 ml-1 uppercase">{{ $rekap->product_unit }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-10 py-16 text-center">
                                    <div class="text-theme-text2 font-medium">Belum ada transaksi di tanggal ini.</div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>


        </div>
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
