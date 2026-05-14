<x-admin-layout>
    <x-slot name="title">Pengaturan Sistem</x-slot>
    <x-slot name="header">Pengaturan & Konfigurasi</x-slot>

    <div class="max-w-5xl space-y-6 pb-12">
        <!-- 1. Informasi Toko -->
        <div class="bg-theme-sidebar rounded-2xl border border-theme-border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-theme-border bg-[#06141B]">
                <h3 class="text-base font-bold text-[#F8FAFC]">Informasi Toko</h3>
                <p class="text-xs text-[#9BA8AB] mt-1">Atur profil dasar, logo, dan kontak utama toko Anda.</p>
            </div>
            <div class="p-6 bg-theme-sidebar space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-[#9BA8AB] uppercase tracking-widest">Nama Toko</label>
                        <input type="text" class="w-full h-11 px-4 bg-[#06141B] border border-theme-border text-[#F8FAFC] rounded-xl text-sm focus:ring-1 focus:ring-[#9BA8AB] outline-none transition-colors" value="MyFSR Semesta">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-[#9BA8AB] uppercase tracking-widest">Nomor WhatsApp Utama</label>
                        <input type="text" class="w-full h-11 px-4 bg-[#06141B] border border-theme-border text-[#F8FAFC] rounded-xl text-sm focus:ring-1 focus:ring-[#9BA8AB] outline-none transition-colors" value="08123456789">
                    </div>
                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-[11px] font-bold text-[#9BA8AB] uppercase tracking-widest">Alamat Lengkap</label>
                        <textarea class="w-full px-4 py-3 bg-[#06141B] border border-theme-border text-[#F8FAFC] rounded-xl text-sm focus:ring-1 focus:ring-[#9BA8AB] outline-none transition-colors" rows="2">Pasar Induk Kramat Jati, Blok A No. 12</textarea>
                    </div>
                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-[11px] font-bold text-[#9BA8AB] uppercase tracking-widest">Logo Toko</label>
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-xl bg-[#06141B] border border-dashed border-[#4A5C6A] flex items-center justify-center text-[#9BA8AB]">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                            </div>
                            <button type="button" class="px-4 py-2 bg-[#253745] hover:bg-[#4A5C6A] text-[#E5E7EB] text-xs font-bold rounded-lg transition-colors border border-theme-border">Upload Logo Baru</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- 2. Pengaturan Invoice -->
        <div class="bg-theme-sidebar rounded-2xl border border-theme-border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-theme-border bg-[#06141B]">
                <h3 class="text-base font-bold text-[#F8FAFC]">Pengaturan Invoice</h3>
                <p class="text-xs text-[#9BA8AB] mt-1">Konfigurasi layout nota cetak dan footer struk.</p>
            </div>
            <div class="p-6 bg-theme-sidebar space-y-6">
                <div class="space-y-2">
                    <label class="block text-[11px] font-bold text-[#9BA8AB] uppercase tracking-widest">Ukuran Print Default</label>
                    <select class="w-full md:w-1/2 h-11 px-4 bg-[#06141B] border border-theme-border text-[#F8FAFC] rounded-xl text-sm focus:ring-1 focus:ring-[#9BA8AB] outline-none">
                        <option value="thermal80">Printer Thermal 80mm</option>
                        <option value="thermal58">Printer Thermal 58mm</option>
                        <option value="a4">Kertas A4 Standard</option>
                    </select>
                </div>
                <div class="space-y-2">
                    <label class="block text-[11px] font-bold text-[#9BA8AB] uppercase tracking-widest">Footer Nota (Pesan Penutup)</label>
                    <textarea class="w-full px-4 py-3 bg-[#06141B] border border-theme-border text-[#F8FAFC] rounded-xl text-sm focus:ring-1 focus:ring-[#9BA8AB] outline-none transition-colors" rows="2">Terima kasih atas kepercayaan Anda bermitra dengan kami. Barang yang sudah dibeli tidak dapat ditukar.</textarea>
                </div>
            </div>
        </div>

        <!-- 3. Pengaturan WhatsApp -->
        <div class="bg-theme-sidebar rounded-2xl border border-theme-border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-theme-border bg-[#06141B]">
                <h3 class="text-base font-bold text-[#F8FAFC]">Pengaturan WhatsApp</h3>
                <p class="text-xs text-[#9BA8AB] mt-1">Atur template pesan otomatis yang dikirimkan ke pelanggan & supplier.</p>
            </div>
            <div class="p-6 bg-theme-sidebar space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-[#9BA8AB] uppercase tracking-widest">Nomor Admin (Fallback)</label>
                        <input type="text" class="w-full h-11 px-4 bg-[#06141B] border border-theme-border text-[#F8FAFC] rounded-xl text-sm focus:ring-1 focus:ring-[#9BA8AB] outline-none transition-colors" value="08123456789">
                    </div>
                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-[11px] font-bold text-[#9BA8AB] uppercase tracking-widest">Template Pesan Invoice Customer</label>
                        <textarea class="w-full px-4 py-3 bg-[#06141B] border border-theme-border text-[#F8FAFC] rounded-xl text-sm focus:ring-1 focus:ring-[#9BA8AB] outline-none font-mono text-xs" rows="5">Halo Bapak/Ibu {nama_customer},
Berikut invoice terbaru Anda.
Total Belanja: {total_belanja}
Total Tagihan: {total_tagihan}
Link: {link_pdf}</textarea>
                    </div>
                    <div class="space-y-2 md:col-span-2">
                        <label class="block text-[11px] font-bold text-[#9BA8AB] uppercase tracking-widest">Template Rekap Supplier</label>
                        <textarea class="w-full px-4 py-3 bg-[#06141B] border border-theme-border text-[#F8FAFC] rounded-xl text-sm focus:ring-1 focus:ring-[#9BA8AB] outline-none font-mono text-xs" rows="3">Halo Supplier, berikut rekap pesanan untuk hari ini tanggal {tanggal_rekap}. 
Link PDF: {link_pdf}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <!-- 4. Pengaturan Sistem -->
        <div class="bg-theme-sidebar rounded-2xl border border-theme-border shadow-sm overflow-hidden">
            <div class="px-6 py-4 border-b border-theme-border bg-[#06141B]">
                <h3 class="text-base font-bold text-[#F8FAFC]">Pengaturan Sistem Inti</h3>
                <p class="text-xs text-[#9BA8AB] mt-1">Konfigurasi format tanggal, timezone, dan tampilan aplikasi.</p>
            </div>
            <div class="p-6 bg-theme-sidebar space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-[#9BA8AB] uppercase tracking-widest">Timezone</label>
                        <select class="w-full h-11 px-4 bg-[#06141B] border border-theme-border text-[#F8FAFC] rounded-xl text-sm focus:ring-1 focus:ring-[#9BA8AB] outline-none">
                            <option value="Asia/Jakarta">WIB (Asia/Jakarta)</option>
                            <option value="Asia/Makassar">WITA (Asia/Makassar)</option>
                            <option value="Asia/Jayapura">WIT (Asia/Jayapura)</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-[#9BA8AB] uppercase tracking-widest">Format Tanggal</label>
                        <select class="w-full h-11 px-4 bg-[#06141B] border border-theme-border text-[#F8FAFC] rounded-xl text-sm focus:ring-1 focus:ring-[#9BA8AB] outline-none">
                            <option value="d/m/Y">dd/mm/yyyy</option>
                            <option value="d-m-Y">dd-mm-yyyy</option>
                            <option value="Y-m-d">yyyy-mm-dd</option>
                        </select>
                    </div>
                    <div class="space-y-2">
                        <label class="block text-[11px] font-bold text-[#9BA8AB] uppercase tracking-widest">Pagination (Item per halaman)</label>
                        <select class="w-full h-11 px-4 bg-[#06141B] border border-theme-border text-[#F8FAFC] rounded-xl text-sm focus:ring-1 focus:ring-[#9BA8AB] outline-none">
                            <option value="15">15 Baris</option>
                            <option value="25">25 Baris</option>
                            <option value="50">50 Baris</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex justify-end gap-3 pt-4">
            <button type="button" class="px-6 py-2.5 bg-[#253745] hover:bg-[#4A5C6A] text-[#E5E7EB] text-sm font-bold rounded-xl transition-colors border border-theme-border">
                Batal
            </button>
            <button type="button" class="px-6 py-2.5 bg-[#1b4332] hover:bg-[#065f46] text-[#74c69d] text-sm font-bold rounded-xl transition-colors border border-emerald-900 shadow-md">
                Simpan Pengaturan
            </button>
        </div>
        
        <div class="mt-8 pt-8 border-t border-theme-border">
            <div class="bg-[#1D0002] border border-[#7f1d1d]/50 rounded-2xl p-6">
                <h3 class="text-base font-bold text-[#fca5a5]">Pengaturan Akun Pribadi (Admin)</h3>
                <p class="text-xs text-[#fca5a5]/70 mt-1 mb-6">Ubah email, password, atau hapus akun administrator Anda.</p>
                <div class="space-y-6">
                    @include('profile.partials.update-profile-information-form')
                    <hr class="border-[#7f1d1d]/30">
                    @include('profile.partials.update-password-form')
                </div>
            </div>
        </div>
    </div>
</x-admin-layout>
