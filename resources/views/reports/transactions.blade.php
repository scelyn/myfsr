<x-admin-layout>
    <x-slot name="title">Laporan Transaksi</x-slot>
    <x-slot name="header">Laporan Transaksi</x-slot>

    <div class="content-section max-w-5xl mx-auto">
        {{-- Stat summary --}}
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <x-stat-card
                title="Total Omzet"
                value="Rp {{ \App\Helpers\NumberHelper::format($totalOmzet ?? 0) }}"
                caption="Total tagihan periode ini"
                color="success"
            />
            <x-stat-card
                title="Total Pesanan"
                value="{{ number_format($totalOrders ?? 0) }}"
                caption="Nota transaksi"
                color="info"
            />
            <x-stat-card
                title="Total Qty"
                value="{{ floatval($totalQty ?? 0) }} Item"
                caption="Item terkirim"
                color="default"
            />
        </div>

        {{-- Filter --}}
        <section class="card shadow-card p-5" x-data="{
            filterType: '{{ $filterType ?? 'month' }}',
            startDate: '{{ isset($startDate) ? \Carbon\Carbon::parse($startDate)->format('Y-m-d') : now()->startOfMonth()->format('Y-m-d') }}',
            endDate: '{{ isset($endDate) ? \Carbon\Carbon::parse($endDate)->format('Y-m-d') : now()->format('Y-m-d') }}',
            applyPreset(type) {
                this.filterType = type;
                if (type !== 'custom') {
                    this.$nextTick(() => this.$refs.filterForm.submit());
                }
            }
        }">
            <form x-ref="filterForm" action="{{ route('reports.transactions') }}" method="GET">
                <input type="hidden" name="filter_type" :value="filterType">

                {{-- Preset buttons --}}
                <div class="flex flex-wrap gap-2 mb-4">
                    @php
                        $presets = [
                            'today' => 'Hari Ini',
                            'week'  => 'Minggu Ini',
                            'month' => 'Bulan Ini',
                            'year'  => 'Tahun Ini',
                            'custom'=> 'Custom',
                        ];
                    @endphp
                    @foreach ($presets as $key => $label)
                        <button type="button"
                            @click="applyPreset('{{ $key }}')"
                            :class="filterType === '{{ $key }}'
                                ? 'btn btn-primary'
                                : 'btn btn-ghost'"
                            class="!text-sm !px-4 !py-1.5"
                        >
                            {{ $label }}
                        </button>
                    @endforeach
                </div>

                {{-- Custom date range (shown only when 'custom' is selected) --}}
                <div x-show="filterType === 'custom'" x-collapse class="flex flex-col sm:flex-row gap-3 items-end">
                    <div class="form-group flex-1">
                        <label class="form-label">Dari Tanggal</label>
                        <input type="date" name="start_date" x-model="startDate" class="form-input">
                    </div>
                    <div class="form-group flex-1">
                        <label class="form-label">Sampai Tanggal</label>
                        <input type="date" name="end_date" x-model="endDate" class="form-input">
                    </div>
                    <button type="submit" class="btn btn-primary">Tampilkan</button>
                </div>

                {{-- Reset --}}
                <div class="mt-3">
                    <a href="{{ route('reports.transactions') }}" class="text-sm" style="color:var(--text-muted);">
                        ↩ Reset Filter
                    </a>
                    <span class="ml-4 text-sm" style="color:var(--text-muted);">
                        Menampilkan:
                        <strong style="color:var(--text-primary);">
                            {{ isset($startDate) ? \Carbon\Carbon::parse($startDate)->format('d/m/Y') : '-' }}
                            —
                            {{ isset($endDate) ? \Carbon\Carbon::parse($endDate)->format('d/m/Y') : '-' }}
                        </strong>
                    </span>
                </div>
            </form>
        </section>

        {{-- Table --}}
        <section class="card shadow-card overflow-hidden">
            <div class="card-header">
                <h3>Detail Transaksi</h3>
            </div>
            <div class="overflow-x-auto">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th>No. Order</th>
                            <th>Tanggal</th>
                            <th>Customer</th>
                            <th class="text-right">Total Qty</th>
                            <th class="text-right">Total Tagihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders ?? [] as $order)
                            <tr>
                                <td class="font-semibold" style="color:var(--text-primary);">{{ $order->order_number }}</td>
                                <td style="color:var(--text-muted);">{{ $order->order_date->format('d/m/Y') }}</td>
                                <td style="color:var(--text-secondary);">{{ $order->customer->nama_toko }}</td>
                                <td class="text-right font-medium" style="color:var(--text-primary);">{{ floatval($order->items->sum('quantity')) }}</td>
                                <td class="text-right font-bold" style="color:var(--accent-primary);">
                                    Rp {{ \App\Helpers\NumberHelper::format($order->invoice?->total_amount ?? 0) }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-14" style="color:var(--text-muted);">
                                    <p class="font-medium">Tidak ada transaksi pada periode ini</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                    @if(isset($orders) && $orders->count() > 0)
                    <tfoot>
                        <tr>
                            <td colspan="4" class="text-right font-bold" style="color:var(--text-secondary);">Total Omzet Periode</td>
                            <td class="text-right font-black" style="color:var(--accent-primary);">
                                Rp {{ \App\Helpers\NumberHelper::format($totalOmzet ?? 0) }}
                            </td>
                        </tr>
                    </tfoot>
                    @endif
                </table>
            </div>
        </section>
    </div>
</x-admin-layout>
