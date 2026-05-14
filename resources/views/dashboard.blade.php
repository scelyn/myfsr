<x-admin-layout>
    <x-slot name="title">Dashboard Analytics</x-slot>
    <x-slot name="header">Ringkasan Bisnis MyFSR</x-slot>

    <div class="space-y-8 max-w-7xl mx-auto">
        <!-- Quick Actions -->
        <div class="flex justify-end print:hidden">
            <a href="{{ route('reports.supplier') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-[#CCD0CF] hover:bg-theme-card text-[#06141B] text-sm font-black rounded-xl shadow-lg shadow-[#CCD0CF]/10 transition-all transform hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                <span>LIHAT REKAP SUPPLIER HARI INI</span>
            </a>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Total Omzet -->
            <div class="bg-[#11212D] border border-[#253745] p-6 rounded-2xl shadow-md shadow-black/20 transition-all hover:shadow-md hover:border-[#4A5C6A]">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-[#06141B] rounded-2xl flex items-center justify-center text-theme-successText">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-[#4A5C6A] uppercase tracking-widest">Total Omzet</p>
                        <p class="text-xs font-bold text-[#9BA8AB] mt-0.5">Keseluruhan tagihan</p>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-[#CCD0CF]">Rp {{ number_format($stats['total_omzet'], 0, ',', '.') }}</h3>
            </div>

            <!-- Estimasi Laba -->
            <div class="bg-[#11212D] border border-[#253745] p-6 rounded-2xl shadow-md shadow-black/20 transition-all hover:shadow-md hover:border-[#4A5C6A]">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-[#06141B] rounded-2xl flex items-center justify-center text-theme-infoText">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-[#4A5C6A] uppercase tracking-widest">Estimasi Laba</p>
                        <p class="text-xs font-bold text-[#9BA8AB] mt-0.5">Potensi keuntungan</p>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-[#CCD0CF]">Rp {{ number_format($stats['estimasi_laba'], 0, ',', '.') }}</h3>
            </div>
            <!-- Total Penjualan -->
            <div class="bg-[#11212D] border border-[#253745] p-6 rounded-2xl shadow-md shadow-black/20 transition-all hover:shadow-md hover:border-[#4A5C6A]">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-[#06141B] rounded-2xl flex items-center justify-center text-[#9BA8AB]">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-[#4A5C6A] uppercase tracking-widest">Total Qty Terpesan</p>
                        <p class="text-xs font-bold text-[#9BA8AB] mt-0.5">Semua item pesanan</p>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-[#CCD0CF]">{{ number_format($stats['total_qty'], 0, ',', '.') }} Item</h3>
            </div>

            <!-- Total Transaksi -->
            <div class="bg-[#11212D] border border-[#253745] p-6 rounded-2xl shadow-md shadow-black/20 transition-all hover:shadow-md hover:border-[#4A5C6A]">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-[#06141B] rounded-2xl flex items-center justify-center text-theme-infoText">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-[#4A5C6A] uppercase tracking-widest">Total Transaksi</p>
                        <p class="text-xs font-bold text-[#9BA8AB] mt-0.5">Nota pesanan</p>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-[#CCD0CF]">{{ number_format($stats['total_orders']) }}</h3>
            </div>

            <!-- Total Piutang -->
            <div class="bg-[#11212D] border border-[#253745] p-6 rounded-2xl shadow-md shadow-black/20 transition-all hover:shadow-md hover:border-[#4A5C6A]">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-[#06141B] rounded-2xl flex items-center justify-center text-theme-errorText">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-[#4A5C6A] uppercase tracking-widest">Total Piutang</p>
                        <p class="text-xs font-bold text-theme-errorText mt-0.5">{{ $stats['unpaid_customers'] }} Customer Berhutang</p>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-[#CCD0CF]">Rp {{ number_format($stats['total_piutang'], 0, ',', '.') }}</h3>
            </div>

            <!-- Active Customers -->
            <div class="bg-[#11212D] border border-[#253745] p-6 rounded-2xl shadow-md shadow-black/20 transition-all hover:shadow-md hover:border-[#4A5C6A]">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-12 h-12 bg-[#06141B] rounded-2xl flex items-center justify-center text-theme-infoText">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                    </div>
                    <div>
                        <p class="text-[10px] font-black text-[#4A5C6A] uppercase tracking-widest">Customer Aktif</p>
                        <p class="text-xs font-bold text-[#9BA8AB] mt-0.5">Reseller terdaftar</p>
                    </div>
                </div>
                <h3 class="text-2xl font-black text-[#CCD0CF]">{{ number_format($stats['active_customers']) }}</h3>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            <!-- Chart Section -->
            <div class="lg:col-span-2 bg-[#11212D] p-8 rounded-2xl border border-[#253745] shadow-md shadow-black/20">
                <div class="flex items-center justify-between mb-8">
                    <h3 class="text-lg font-black text-[#CCD0CF]">Tren Pesanan Bulanan</h3>
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 bg-[#9BA8AB] rounded-full"></span>
                        <span class="text-xs font-bold text-[#4A5C6A] uppercase tracking-widest">Total Pesanan</span>
                    </div>
                </div>
                <div class="h-80">
                    <canvas id="salesChart"></canvas>
                </div>
            </div>

            <!-- Top Products -->
            <div class="bg-[#11212D] p-8 rounded-2xl border border-[#253745] shadow-md shadow-black/20">
                <h3 class="text-lg font-black text-[#CCD0CF] mb-8">Produk Terlaris</h3>
                <div class="space-y-6">
                    @forelse($topProducts as $tp)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 bg-[#06141B] border border-[#253745] rounded-xl flex items-center justify-center font-black text-[#9BA8AB] text-xs">
                                    {{ $loop->iteration }}
                                </div>
                                <div>
                                    <p class="text-sm font-black text-[#CCD0CF] leading-none">{{ $tp->product_name }}</p>
                                    <p class="text-[10px] font-bold text-[#4A5C6A] mt-1 uppercase">{{ $tp->product_unit }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="text-sm font-black text-[#CCD0CF]">{{ number_format($tp->total_qty) }}</p>
                                <p class="text-[10px] font-bold text-[#4A5C6A] uppercase">Terjual</p>
                            </div>
                        </div>
                    @empty
                        <div class="text-center text-[#4A5C6A] text-sm py-8">Belum ada data penjualan produk.</div>
                    @endforelse
                </div>
                <div class="mt-8 pt-8 border-t border-[#253745]">
                    <a href="{{ route('products.index') }}" class="block text-center text-xs font-black text-[#4A5C6A] hover:text-[#CCD0CF] uppercase tracking-widest transition-colors">Lihat Semua Produk</a>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Recent Transactions -->
            <div class="bg-[#11212D] rounded-2xl border border-[#253745] shadow-md shadow-black/20 overflow-hidden">
                <div class="px-8 py-6 border-b border-[#253745] flex items-center justify-between bg-[#06141B]/50">
                    <h3 class="text-lg font-black text-[#CCD0CF]">Transaksi Terakhir</h3>
                    <a href="{{ route('orders.index') }}" class="text-xs font-black text-[#9BA8AB] hover:text-theme-text1 uppercase tracking-widest transition-colors">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="bg-[#06141B]/80 border-b border-[#253745]">
                                <th class="px-8 py-4 font-bold text-[#4A5C6A] uppercase tracking-widest text-[10px]">No. Order</th>
                                <th class="px-8 py-4 font-bold text-[#4A5C6A] uppercase tracking-widest text-[10px]">Customer</th>
                                <th class="px-8 py-4 font-bold text-[#4A5C6A] uppercase tracking-widest text-[10px] text-right">Tanggal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#253745]">
                            @forelse($recentOrders as $order)
                                <tr class="hover:bg-[#253745]/20 transition-colors">
                                    <td class="px-8 py-5 font-black text-[#CCD0CF]">{{ $order->order_number }}</td>
                                    <td class="px-8 py-5">
                                        <div class="font-bold text-[#9BA8AB]">{{ $order->customer->nama_toko }}</div>
                                    </td>
                                    <td class="px-8 py-5 text-right font-medium text-[#4A5C6A]">{{ $order->order_date->format('d/m/Y') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-8 py-10 text-center text-[#4A5C6A] text-sm">Belum ada transaksi tercatat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Recent Payments -->
            <div class="bg-[#11212D] rounded-2xl border border-[#253745] shadow-md shadow-black/20 overflow-hidden">
                <div class="px-8 py-6 border-b border-[#253745] flex items-center justify-between bg-[#06141B]/50">
                    <h3 class="text-lg font-black text-[#CCD0CF]">Pembayaran Terakhir</h3>
                    <a href="{{ route('invoices.index') }}" class="text-xs font-black text-[#9BA8AB] hover:text-theme-text1 uppercase tracking-widest transition-colors">Lihat Semua</a>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-left text-sm">
                        <thead>
                            <tr class="bg-[#06141B]/80 border-b border-[#253745]">
                                <th class="px-8 py-4 font-bold text-[#4A5C6A] uppercase tracking-widest text-[10px]">Tanggal</th>
                                <th class="px-8 py-4 font-bold text-[#4A5C6A] uppercase tracking-widest text-[10px]">Customer</th>
                                <th class="px-8 py-4 font-bold text-[#4A5C6A] uppercase tracking-widest text-[10px] text-right">Nominal Masuk</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#253745]">
                            @forelse($recentPayments as $payment)
                                <tr class="hover:bg-[#253745]/20 transition-colors">
                                    <td class="px-8 py-5 text-[#4A5C6A]">{{ $payment->payment_date->format('d/m/Y') }}</td>
                                    <td class="px-8 py-5">
                                        <div class="font-bold text-[#9BA8AB]">{{ $payment->customer->nama_toko }}</div>
                                    </td>
                                    <td class="px-8 py-5 text-right font-black text-theme-successText">+ Rp {{ number_format($payment->amount, 0, ',', '.') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-8 py-10 text-center text-[#4A5C6A] text-sm">Belum ada pembayaran tercatat.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($monthlySales->pluck('month')),
                datasets: [{
                    label: 'Pesanan',
                    data: @json($monthlySales->pluck('total')),
                    borderColor: '#9BA8AB',
                    backgroundColor: 'rgba(155, 168, 171, 0.1)',
                    borderWidth: 4,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#11212D',
                    pointBorderColor: '#9BA8AB',
                    pointBorderWidth: 2,
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [5, 5], color: '#253745' },
                        ticks: {
                            callback: function(value) {
                                return value;
                            },
                            font: { size: 10, weight: 'bold' },
                            color: '#4A5C6A'
                        }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10, weight: 'bold' }, color: '#4A5C6A' }
                    }
                }
            }
        });
    </script>
    @endpush
</x-admin-layout>
