<x-admin-layout>
    <x-slot name="title">Dashboard Analytics</x-slot>
    <x-slot name="header">Ringkasan Bisnis SIPEDIS</x-slot>

    <div class="content-section max-w-7xl mx-auto">

        {{-- Quick action --}}
        <div class="flex justify-end">
            <a href="{{ route('reports.supplier') }}" class="btn btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                Lihat Rekap Supplier Hari Ini
            </a>
        </div>

        {{-- Stats grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <x-stat-card
                title="Total Omzet"
                value="Rp {{ \App\Helpers\NumberHelper::format($stats['total_omzet']) }}"
                caption="Keseluruhan tagihan invoice"
                color="success"
            />
            <x-stat-card
                title="Estimasi Laba"
                value="Rp {{ \App\Helpers\NumberHelper::format($stats['estimasi_laba']) }}"
                caption="Potensi keuntungan bersih"
                color="info"
            />
            <x-stat-card
                title="Total Qty Terpesan"
                value="{{ floatval($stats['total_qty']) }} Item"
                caption="Semua item pesanan aktif"
                color="default"
            />
            <x-stat-card
                title="Total Transaksi"
                value="{{ number_format($stats['total_orders']) }}"
                caption="Nota pesanan"
                color="default"
            />
            <x-stat-card
                title="Total Piutang"
                value="Rp {{ \App\Helpers\NumberHelper::format($stats['total_piutang']) }}"
                caption="{{ $stats['unpaid_customers'] }} customer berhutang"
                color="danger"
            />
            <x-stat-card
                title="Customer Aktif"
                value="{{ number_format($stats['active_customers']) }}"
                caption="Reseller terdaftar"
                color="info"
            />
        </div>

        {{-- Chart + Top Products --}}
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            <section class="lg:col-span-2 card shadow-card p-6">
                <div class="flex items-center justify-between mb-5">
                    <h3 style="color:var(--text-primary);">Tren Pesanan Bulanan</h3>
                    <div class="flex items-center gap-2">
                        <span class="w-2.5 h-2.5 rounded-full"
                              style="background-color:var(--navy-800);"></span>
                        <span class="text-xs font-bold uppercase tracking-widest"
                              style="color:var(--text-muted);">Total Pesanan</span>
                    </div>
                </div>
                <div class="h-72">
                    <canvas id="salesChart"></canvas>
                </div>
            </section>

            <section class="card shadow-card p-6">
                <h3 class="mb-5" style="color:var(--text-primary);">Produk Terlaris</h3>
                <div class="space-y-4">
                    @forelse($topProducts as $tp)
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-xs font-black shrink-0"
                                     style="background-color:var(--bg-surface); color:var(--navy-800);">
                                    {{ $loop->iteration }}
                                </div>
                                <div class="min-w-0">
                                    <p class="text-sm font-bold truncate" style="color:var(--text-primary);">{{ $tp->product_name }}</p>
                                    <p class="text-xs uppercase tracking-wide" style="color:var(--text-muted);">{{ $tp->product_unit }}</p>
                                </div>
                            </div>
                            <div class="text-right shrink-0 ml-2">
                                <p class="font-black" style="color:var(--text-primary);">{{ floatval($tp->total_qty) }}</p>
                                <p class="text-xs" style="color:var(--text-muted);">Terjual</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-center py-8 text-sm" style="color:var(--text-muted);">Belum ada data penjualan.</p>
                    @endforelse
                </div>
                <div class="pt-4 mt-4" style="border-top:1px solid var(--border-soft);">
                    <a href="{{ route('products.index') }}"
                       class="block text-center text-xs font-bold uppercase tracking-widest"
                       style="color:var(--text-muted);">
                        Lihat Semua Produk
                    </a>
                </div>
            </section>
        </div>

        {{-- Recent orders + payments --}}
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
            <section class="card shadow-card overflow-hidden">
                <div class="card-header">
                    <h3>Transaksi Terakhir</h3>
                    <a href="{{ route('orders.index') }}"
                       class="text-xs font-bold uppercase tracking-widest"
                       style="color:var(--accent-primary);">Lihat Semua</a>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No. Order</th>
                            <th>Customer</th>
                            <th class="text-right">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentOrders as $order)
                            <tr>
                                <td class="font-semibold" style="color:var(--text-primary);">{{ $order->order_number }}</td>
                                <td style="color:var(--text-secondary);">{{ $order->customer->nama_toko }}</td>
                                <td class="text-right" style="color:var(--text-muted);">{{ $order->order_date->format('d/m/Y') }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-10 text-sm" style="color:var(--text-muted);">Belum ada transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>

            <section class="card shadow-card overflow-hidden">
                <div class="card-header">
                    <h3>Pembayaran Terakhir</h3>
                    <a href="{{ route('invoices.index') }}"
                       class="text-xs font-bold uppercase tracking-widest"
                       style="color:var(--accent-primary);">Lihat Semua</a>
                </div>
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Customer</th>
                            <th class="text-right">Nominal Masuk</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPayments as $payment)
                            <tr>
                                <td style="color:var(--text-muted);">{{ $payment->payment_date->format('d/m/Y') }}</td>
                                <td style="color:var(--text-primary);">{{ $payment->customer->nama_toko }}</td>
                                <td class="text-right font-black" style="color:var(--color-success);">
                                    + Rp {{ \App\Helpers\NumberHelper::format($payment->amount) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center py-10 text-sm" style="color:var(--text-muted);">Belum ada pembayaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </section>
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
                    borderColor: '#11212D',
                    backgroundColor: 'rgba(17,33,45,0.06)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true,
                    pointBackgroundColor: '#ffffff',
                    pointBorderColor: '#11212D',
                    pointBorderWidth: 2,
                    pointRadius: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: { borderDash: [4,4], color: '#e2e7e7' },
                        ticks: { font: { size: 10, weight: '600' }, color: '#94a3b8' }
                    },
                    x: {
                        grid: { display: false },
                        ticks: { font: { size: 10, weight: '600' }, color: '#94a3b8' }
                    }
                }
            }
        });
    </script>
    @endpush
</x-admin-layout>
