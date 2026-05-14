<x-admin-layout>
    <x-slot name="title">Detail Customer - {{ $customer->nama_toko }}</x-slot>
    <x-slot name="header">Detail Customer</x-slot>

    <div class="space-y-6">
        {{-- Back & Actions --}}
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <a href="{{ route('customers.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-theme-text2 hover:text-[#06141B] transition-colors group">
                <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                Data Customer
            </a>
            <div class="flex items-center gap-2">
                <a href="{{ route('customers.edit', $customer) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-theme-card border border-theme-border text-theme-text1 hover:text-blue-600 hover:border-blue-200 text-sm font-semibold rounded-xl transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                    Edit
                </a>
                @php
                    $waText = "Halo {$customer->nama_pemilik}, ini pemberitahuan dari MyFSR reseller sembako.";
                    $waUrl = "https://wa.me/" . preg_replace('/[^0-9]/', '', $customer->no_whatsapp) . "?text=" . urlencode($waText);
                @endphp
                <a href="{{ $waUrl }}" target="_blank"
                   class="inline-flex items-center gap-2 px-4 py-2 bg-theme-success text-theme-text1 text-sm font-semibold rounded-xl shadow-lg shadow-emerald-100 hover:bg-emerald-700 transition-all">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    WhatsApp
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left: Profile & Stats --}}
            <div class="lg:col-span-1 space-y-4">
                {{-- Profile Card --}}
                <div class="bg-[#06141B] rounded-2xl p-6 text-theme-text1">
                    <div class="w-14 h-14 bg-theme-card/10 rounded-2xl flex items-center justify-center text-2xl font-black mb-4">
                        {{ strtoupper(substr($customer->nama_toko, 0, 1)) }}
                    </div>
                    <h2 class="text-xl font-black">{{ $customer->nama_toko }}</h2>
                    <p class="text-[#9BA8AB] text-sm mt-1">{{ $customer->nama_pemilik }}</p>
                    <div class="mt-4 pt-4 border-t border-white/10 space-y-2">
                        <div class="flex items-center gap-2 text-sm text-[#CCD0CF]">
                            <svg class="w-4 h-4 text-theme-successText" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                            {{ $customer->no_whatsapp }}
                        </div>
                        @if($customer->alamat_pasar)
                        <div class="flex items-start gap-2 text-sm text-[#CCD0CF]">
                            <svg class="w-4 h-4 mt-0.5 shrink-0 text-[#9BA8AB]" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                            {{ $customer->alamat_pasar }}
                        </div>
                        @endif
                    </div>

                </div>

                {{-- Stats --}}
                <div class="grid grid-cols-2 gap-3">
                    <div class="bg-theme-card rounded-2xl border border-theme-border p-4">
                        <p class="text-[10px] font-bold text-theme-text2 uppercase tracking-wider">Total Order</p>
                        <p class="text-2xl font-black text-[#06141B] mt-1">{{ $customer->orders->count() }}</p>
                    </div>
                    <div class="bg-theme-card rounded-2xl border border-theme-border p-4">
                        <p class="text-[10px] font-bold text-theme-text2 uppercase tracking-wider">Pembayaran</p>
                        <p class="text-2xl font-black text-[#06141B] mt-1">{{ $customer->customerPayments->count() }}</p>
                    </div>
                    <div class="bg-theme-card rounded-2xl border border-theme-border p-4 col-span-2">
                        <p class="text-[10px] font-bold text-theme-errorText uppercase tracking-wider">Piutang Aktif</p>
                        <p class="text-xl font-black text-theme-errorText mt-1">
                            Rp {{ number_format($customer->total_receivable, 0, ',', '.') }}
                        </p>
                    </div>
                </div>
            </div>

            {{-- Right: History --}}
            <div class="lg:col-span-2 space-y-5">

                {{-- Histori Transaksi --}}
                <div class="bg-theme-card rounded-2xl border border-theme-border shadow-md shadow-black/20 overflow-hidden">
                    <div class="px-6 py-4 border-b border-theme-border flex items-center justify-between">
                        <h3 class="text-sm font-bold text-[#06141B]">Histori Pesanan</h3>
                        <a href="{{ route('orders.index') }}?customer={{ $customer->id }}" class="text-xs font-semibold text-theme-successText hover:underline">Lihat Semua</a>
                    </div>
                    <div class="divide-y divide-slate-50">
                        @forelse($customer->orders as $order)
                            <div class="flex items-center justify-between px-6 py-4 hover:bg-theme-bg/50 transition-colors">
                                <div>
                                    <a href="{{ route('orders.show', $order) }}" class="text-sm font-bold text-[#11212D] hover:text-theme-successText transition-colors">
                                        {{ $order->order_number }}
                                    </a>
                                    <p class="text-xs text-theme-text2 mt-0.5">{{ $order->order_date->format('d M Y') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-[#06141B]">Rp {{ number_format($order->total_amount, 0, ',', '.') }}</p>

                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-10 text-center text-sm text-theme-text2">Belum ada histori pesanan.</div>
                        @endforelse
                    </div>
                </div>

                {{-- Histori Piutang --}}
                <div class="bg-theme-card rounded-2xl border border-theme-border shadow-md shadow-black/20 overflow-hidden">
                    <div class="px-6 py-4 border-b border-theme-border">
                        <h3 class="text-sm font-bold text-[#06141B]">Status Piutang</h3>
                    </div>
                    <div class="divide-y divide-slate-50">
                        @forelse($customer->receivables as $receivable)
                            <div class="flex items-center justify-between px-6 py-4 hover:bg-theme-bg/50 transition-colors">
                                <div>
                                    <p class="text-sm font-bold text-[#11212D]">{{ $receivable->invoice->invoice_number ?? '-' }}</p>
                                    <p class="text-xs text-theme-text2 mt-0.5">Jatuh tempo: {{ $receivable->due_date->format('d M Y') }}
                                        @if($receivable->is_overdue)
                                            <span class="text-red-500 font-bold">(Terlambat {{ $receivable->days_overdue }} hari)</span>
                                        @endif
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-sm font-bold text-theme-errorText">Rp {{ number_format($receivable->remaining_amount, 0, ',', '.') }}</p>
                                    <span class="inline-block mt-0.5 px-2 py-0.5 text-[10px] font-bold rounded-full uppercase
                                        {{ $receivable->status === 'paid' ? 'bg-theme-success/40 text-theme-successText' : ($receivable->status === 'partial' ? 'bg-blue-100 text-blue-700' : 'bg-theme-error/40 text-theme-errorText') }}">
                                        {{ $receivable->status }}
                                    </span>
                                </div>
                            </div>
                        @empty
                            <div class="px-6 py-10 text-center text-sm text-theme-text2">Tidak ada piutang aktif.</div>
                        @endforelse
                    </div>
                </div>

                {{-- Histori Pembayaran --}}
                <div class="bg-theme-card rounded-2xl border border-theme-border shadow-md shadow-black/20 overflow-hidden">
                    <div class="px-6 py-4 border-b border-theme-border">
                        <h3 class="text-sm font-bold text-[#06141B]">Histori Pembayaran</h3>
                    </div>
                    <div class="divide-y divide-slate-50">
                        @forelse($customer->customerPayments as $payment)
                            <div class="flex items-center justify-between px-6 py-4">
                                <div>
                                    <p class="text-sm font-bold text-[#11212D]">{{ $payment->payment_date->format('d M Y') }}</p>
                                    <p class="text-xs text-theme-text2 capitalize mt-0.5">{{ $payment->payment_method }} — {{ $payment->notes ?? 'Pembayaran piutang' }}</p>
                                </div>
                                <p class="text-sm font-black text-theme-successText">+ Rp {{ number_format($payment->amount, 0, ',', '.') }}</p>
                            </div>
                        @empty
                            <div class="px-6 py-10 text-center text-sm text-theme-text2">Belum ada histori pembayaran.</div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
