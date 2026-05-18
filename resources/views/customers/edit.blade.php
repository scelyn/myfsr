<x-admin-layout>
    <x-slot name="title">Edit Customer</x-slot>
    <x-slot name="header">Edit Data Customer</x-slot>

    <div class="max-w-2xl">
        <a href="{{ route('customers.index') }}" class="back-link">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Daftar Customer
        </a>

        <form action="{{ route('customers.update', $customer) }}" method="POST">
            @csrf @method('PUT')
            <section class="card shadow-card">
                <div class="card-header"><h3>Edit: {{ $customer->nama_toko }}</h3></div>
                <div class="p-6 space-y-5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div class="form-group">
                            <label class="form-label">Nama Toko <span style="color:var(--color-danger);">*</span></label>
                            <input type="text" name="nama_toko" value="{{ old('nama_toko', $customer->nama_toko) }}"
                                   class="form-input {{ $errors->has('nama_toko') ? 'error' : '' }}" autofocus>
                            @error('nama_toko')<p class="text-xs" style="color:var(--color-danger);">{{ $message }}</p>@enderror
                        </div>
                        <div class="form-group">
                            <label class="form-label">Nama Pemilik <span style="color:var(--color-danger);">*</span></label>
                            <input type="text" name="nama_pemilik" value="{{ old('nama_pemilik', $customer->nama_pemilik) }}"
                                   class="form-input {{ $errors->has('nama_pemilik') ? 'error' : '' }}">
                            @error('nama_pemilik')<p class="text-xs" style="color:var(--color-danger);">{{ $message }}</p>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Alamat Pasar <span style="color:var(--color-danger);">*</span></label>
                        <input type="text" name="alamat_pasar" value="{{ old('alamat_pasar', $customer->alamat_pasar) }}"
                               class="form-input {{ $errors->has('alamat_pasar') ? 'error' : '' }}">
                        @error('alamat_pasar')<p class="text-xs" style="color:var(--color-danger);">{{ $message }}</p>@enderror
                    </div>
                    <div class="form-group">
                        <label class="form-label">No. WhatsApp <span style="color:var(--color-danger);">*</span></label>
                        <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp', $customer->no_whatsapp) }}"
                               class="form-input {{ $errors->has('no_whatsapp') ? 'error' : '' }}">
                        @error('no_whatsapp')<p class="text-xs" style="color:var(--color-danger);">{{ $message }}</p>@enderror
                    </div>
                </div>
                <div class="px-6 py-4 flex justify-end gap-3"
                     style="border-top:1px solid var(--border-soft); background-color:var(--bg-surface);">
                    <a href="{{ route('customers.index') }}" class="btn btn-ghost">Batal</a>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </section>
        </form>
    </div>
</x-admin-layout>
