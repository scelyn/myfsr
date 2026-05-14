<x-admin-layout>
    <x-slot name="title">Tambah Customer Baru</x-slot>
    <x-slot name="header">Tambah Customer Baru</x-slot>

    <div class="max-w-2xl mx-auto">
        <a href="{{ route('customers.index') }}" class="inline-flex items-center gap-2 text-sm font-medium text-theme-text2 hover:text-white transition-colors mb-6 group">
            <svg class="w-4 h-4 group-hover:-translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Kembali ke Data Customer
        </a>

        <form action="{{ route('customers.store') }}" method="POST">
            @csrf
            <div class="bg-theme-card rounded-2xl border border-theme-border shadow-md shadow-sm p-8 space-y-6">
                <div>
                    <h3 class="text-sm font-bold text-white uppercase tracking-widest mb-5">Informasi Customer</h3>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        {{-- Nama Toko --}}
                        <div class="sm:col-span-2 space-y-1.5">
                            <label class="text-xs font-bold text-theme-text2 uppercase tracking-wider">Nama Toko <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_toko" value="{{ old('nama_toko') }}"
                                   placeholder="Contoh: Toko Sembako Berkah"
                                   class="w-full px-4 py-3 bg-theme-bg border {{ $errors->has('nama_toko') ? 'border-red-400' : 'border-theme-border' }} rounded-xl text-sm font-medium text-white placeholder-slate-400 focus:ring-2 focus:ring-emerald-500/20 focus:border-theme-success outline-none transition-all"
                                   autofocus>
                            @error('nama_toko')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Nama Pemilik --}}
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-theme-text2 uppercase tracking-wider">Nama Pemilik <span class="text-red-500">*</span></label>
                            <input type="text" name="nama_pemilik" value="{{ old('nama_pemilik') }}"
                                   placeholder="Contoh: Budi Santoso"
                                   class="w-full px-4 py-3 bg-theme-bg border {{ $errors->has('nama_pemilik') ? 'border-red-400' : 'border-theme-border' }} rounded-xl text-sm font-medium text-white placeholder-slate-400 focus:ring-2 focus:ring-emerald-500/20 focus:border-theme-success outline-none transition-all">
                            @error('nama_pemilik')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- WhatsApp --}}
                        <div class="space-y-1.5">
                            <label class="text-xs font-bold text-theme-text2 uppercase tracking-wider">Nomor WhatsApp <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2">
                                    <svg class="w-4 h-4 text-emerald-500" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                </span>
                                <input type="text" name="no_whatsapp" value="{{ old('no_whatsapp') }}"
                                       placeholder="08xxxxxxxxxx"
                                       class="w-full pl-10 pr-4 py-3 bg-theme-bg border {{ $errors->has('no_whatsapp') ? 'border-red-400' : 'border-theme-border' }} rounded-xl text-sm font-medium text-white placeholder-slate-400 focus:ring-2 focus:ring-emerald-500/20 focus:border-theme-success outline-none transition-all">
                            </div>
                            @error('no_whatsapp')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>

                        {{-- Alamat Pasar --}}
                        <div class="sm:col-span-2 space-y-1.5">
                            <label class="text-xs font-bold text-theme-text2 uppercase tracking-wider">Alamat Pasar</label>
                            <textarea name="alamat_pasar" rows="3"
                                      placeholder="Contoh: Pasar Induk Caringin Blok B-12"
                                      class="w-full px-4 py-3 bg-theme-bg border {{ $errors->has('alamat_pasar') ? 'border-red-400' : 'border-theme-border' }} rounded-xl text-sm font-medium text-white placeholder-slate-400 focus:ring-2 focus:ring-emerald-500/20 focus:border-theme-success outline-none transition-all resize-none">{{ old('alamat_pasar') }}</textarea>
                            @error('alamat_pasar')<p class="text-xs text-red-500 mt-1">{{ $message }}</p>@enderror
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-2 border-t border-theme-border">
                    <a href="{{ route('customers.index') }}" class="px-6 py-2.5 bg-theme-sidebar text-theme-text1 text-sm font-semibold rounded-xl hover:bg-theme-border transition-colors">Batal</a>
                    <button type="submit" class="px-8 py-2.5 bg-slate-100 hover:bg-theme-card text-theme-text1 text-sm font-bold rounded-xl shadow-lg transition-all hover:-translate-y-0.5">
                        Simpan Customer
                    </button>
                </div>
            </div>
        </form>
    </div>
</x-admin-layout>
