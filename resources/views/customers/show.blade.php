<x-admin-layout>
    <x-slot name="title">Detail Customer - {{ $customer->nama_toko }}</x-slot>
    <x-slot name="header">Detail Customer</x-slot>

    <div class="content-section">
        {{-- Actions bar --}}
        <div class="page-header">
            <a href="{{ route('customers.index') }}" class="back-link" style="margin-bottom:0;">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Data Customer
            </a>
            <div class="flex gap-2">
                <a href="{{ route('customers.edit', $customer) }}" class="btn btn-primary btn-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit
                </a>
                @php
                    $waText = "Halo {$customer->nama_pemilik}, ini pemberitahuan dari MyFSR reseller sembako.";
                    $waUrl  = "https://wa.me/".preg_replace('/[^0-9]/','',$customer->no_whatsapp)."?text=".urlencode($waText);
                @endphp
                <a href="{{ $waUrl }}" target="_blank" class="btn btn-sm"
                   style="background-color:var(--color-success-bg); color:var(--color-success); border:1px solid var(--color-success-border);">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.168-.01-.345-.012-.52-.012-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/></svg>
                    WhatsApp
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-5">
            {{-- Left: profile + stats --}}
            <div class="space-y-4">
                <section class="card shadow-card p-5">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center text-xl font-black mb-4"
                         style="background-color:var(--accent-light); color:var(--accent-primary);">
                        {{ strtoupper(substr($customer->nama_toko, 0, 1)) }}
                    </div>
                    <h2 class="text-lg font-black" style="color:var(--text-primary);">{{ $customer->nama_toko }}</h2>
                    <p class="text-sm mt-0.5" style="color:var(--text-secondary);">{{ $customer->nama_pemilik }}</p>
                    <div class="mt-4 pt-4 space-y-2" style="border-top:1px solid var(--border-soft);">
                        <div class="flex items-center gap-2 text-sm" style="color:var(--text-secondary);">
                            <svg class="w-4 h-4 shrink-0" fill="currentColor" viewBox="0 0 24 24" style="color:var(--color-success);"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.168-.01-.345-.012-.52-.012-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413z"/></svg>
                            {{ $customer->no_whatsapp }}
                        </div>
                        @if($customer->alamat_pasar)
                        <div class="flex items-start gap-2 text-sm" style="color:var(--text-secondary);">
                            <svg class="w-4 h-4 mt-0.5 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $customer->alamat_pasar }}
                        </div>
                        @endif
                    </div>
                </section>

                <div class="grid grid-cols-2 gap-3">
                    <section class="card shadow-card p-4">
                        <p class="form-label mb-1">Total Order</p>
                        <p class="text-2xl font-black" style="color:var(--text-primary);">{{ $customer->orders->count() }}</p>
                    </section>
                    <section class="card shadow-card p-4">
                        <p class="form-label mb-1">Pembayaran</p>
                        <p class="text-2xl font-black" style="color:var(--text-primary);">{{ $customer->customerPayments->count() }}</p>
                    </section>
                    <section class="card shadow-card p-4 col-span-2" style="border-left:3px solid var(--color-danger-border);">
                        <p class="form-label mb-1" style="color:var(--color-danger);">Piutang Aktif</p>
                        <p class="text-lg font-black" style="color:var(--color-danger);">
                            Rp {{ \App\Helpers\NumberHelper::format($customer->total_receivable) }}
                        </p>
                    </section>
                </div>
            </div>

            {{-- Right: history --}}
            <div class="lg:col-span-2 space-y-4">
                {{-- Orders --}}
                <section class="card shadow-card overflow-hidden">
                    <div class="card-header">
                        <h3>Histori Pesanan</h3>
                        <a href="{{ route('orders.index') }}?customer={{ $customer->id }}"
                           class="text-xs font-semibold" style="color:var(--accent-primary);">Lihat Semua</a>
                    </div>
                    <div>
                        @forelse($customer->orders as $order)
                            <div class="flex items-center justify-between px-5 py-3.5 hover:bg-gray-50 transition-colors"
                                 style="border-bottom:1px solid var(--border-soft);">
                                <div>
                                    <a href="{{ route('orders.show', $order) }}"
                                       class="text-sm font-semibold hover:underline" style="color:var(--text-primary);">
                                        {{ $order->order_number }}
                                    </a>
                                    <p class="text-xs mt-0.5" style="color:var(--text-secondary);">{{ $order->order_date->format('d M Y') }}</p>
                                </div>
                                <p class="text-sm font-semibold" style="color:var(--text-primary);">
                                    Rp {{ \App\Helpers\NumberHelper::format($order->total_amount) }}
                                </p>
                            </div>
                        @empty
                            <p class="text-center py-10 text-sm" style="color:var(--text-muted);">Belum ada histori pesanan.</p>
                        @endforelse
                    </div>
                </section>

                {{-- Piutang (derived from outstanding invoices) --}}
                <section class="card shadow-card overflow-hidden">
                    <div class="card-header"><h3>Status Piutang</h3></div>
                    <div>
                        @forelse($customer->outstandingInvoices()->with('customer')->orderBy('due_date')->get() as $inv)
                            <div class="flex items-center justify-between px-5 py-3.5"
                                 style="border-bottom:1px solid var(--border-soft);{{ $inv->is_overdue ? 'background-color:rgba(153,27,27,0.04);' : '' }}">
                                <div>
                                    <a href="{{ route('receivables.show', $inv) }}" class="text-sm font-semibold hover:underline" style="color:var(--text-primary);">
                                        {{ $inv->invoice_number }}
                                    </a>
                                    <p class="text-xs mt-0.5" style="color:var(--text-secondary);">
                                        Jatuh tempo: {{ $inv->due_date->format('d M Y') }}
                                        @if($inv->is_overdue)
                                            <span style="color:var(--color-danger); font-weight:700;">(Terlambat {{ $inv->days_overdue }} hari)</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-semibold" style="color:var(--color-danger);">
                                        Rp {{ \App\Helpers\NumberHelper::format($inv->remaining_amount) }}
                                    </p>
                                    @if($inv->status === 'partial')
                                        <span class="badge badge-warning mt-1">Cicilan</span>
                                    @else
                                        <span class="badge badge-neutral mt-1">Belum Bayar</span>
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-center py-10 text-sm" style="color:var(--text-muted);">Tidak ada piutang aktif.</p>
                        @endforelse
                    </div>
                </section>

                {{-- Payments --}}
                <section class="card shadow-card overflow-hidden">
                    <div class="card-header"><h3>Histori Pembayaran</h3></div>
                    <div>
                        @forelse($customer->customerPayments as $payment)
                            <div class="flex items-center justify-between px-5 py-3.5"
                                 style="border-bottom:1px solid var(--border-soft);">
                                <div>
                                    <p class="text-sm font-semibold" style="color:var(--text-primary);">
                                        {{ $payment->payment_date->format('d M Y') }}
                                    </p>
                                    <p class="text-xs mt-0.5 capitalize" style="color:var(--text-secondary);">
                                        {{ $payment->payment_method }} — {{ $payment->notes ?? 'Pembayaran piutang' }}
                                    </p>
                                </div>
                                <p class="text-sm font-black" style="color:var(--color-success);">
                                    +Rp {{ \App\Helpers\NumberHelper::format($payment->amount) }}
                                </p>
                            </div>
                        @empty
                            <p class="text-center py-10 text-sm" style="color:var(--text-muted);">Belum ada histori pembayaran.</p>
                        @endforelse
                    </div>
                </section>
            </div>
        </div>
    </div>
</x-admin-layout>
