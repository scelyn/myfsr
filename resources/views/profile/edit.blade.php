<x-admin-layout>
    <x-slot name="title">Pengaturan Sistem</x-slot>
    <x-slot name="header">Pengaturan &amp; Konfigurasi</x-slot>

    <div class="max-w-4xl content-section pb-10">

        {{-- Informasi Toko --}}
        <section class="card shadow-card overflow-hidden">
            <div class="card-header"><h3>Informasi Toko</h3></div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="form-group"><label class="form-label">Nama Toko</label>
                    <input type="text" class="form-input" value="MyFSR Semesta"></div>
                <div class="form-group"><label class="form-label">No. WhatsApp Utama</label>
                    <input type="text" class="form-input" value="08123456789"></div>
                <div class="form-group md:col-span-2"><label class="form-label">Alamat Lengkap</label>
                    <textarea class="form-input resize-none" rows="2">Pasar Induk Kramat Jati, Blok A No. 12</textarea></div>
            </div>
        </section>

        {{-- Pengaturan Invoice --}}
        <section class="card shadow-card overflow-hidden">
            <div class="card-header"><h3>Pengaturan Invoice</h3></div>
            <div class="p-6 space-y-5">
                <div class="form-group">
                    <label class="form-label">Ukuran Print Default</label>
                    <select class="form-input md:w-1/2">
                        <option>Printer Thermal 80mm</option>
                        <option>Printer Thermal 58mm</option>
                        <option>Kertas A4 Standard</option>
                    </select>
                </div>
                <div class="form-group">
                    <label class="form-label">Footer Nota</label>
                    <textarea class="form-input resize-none" rows="2">Terima kasih atas kepercayaan Anda bermitra dengan kami.</textarea>
                </div>
            </div>
        </section>

        {{-- WhatsApp --}}
        <section class="card shadow-card overflow-hidden">
            <div class="card-header"><h3>Pengaturan WhatsApp</h3></div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="form-group"><label class="form-label">Nomor Admin (Fallback)</label>
                    <input type="text" class="form-input" value="08123456789"></div>
                <div class="form-group md:col-span-2"><label class="form-label">Template Pesan Invoice Customer</label>
                    <textarea class="form-input font-mono text-xs resize-none" rows="5">Halo Bapak/Ibu {nama_customer},
Berikut invoice terbaru Anda.
Total Belanja: {total_belanja}
Total Tagihan: {total_tagihan}
Link: {link_pdf}</textarea></div>
            </div>
        </section>

        {{-- Sistem --}}
        <section class="card shadow-card overflow-hidden">
            <div class="card-header"><h3>Pengaturan Sistem Inti</h3></div>
            <div class="p-6 grid grid-cols-1 md:grid-cols-2 gap-5">
                <div class="form-group"><label class="form-label">Timezone</label>
                    <select class="form-input">
                        <option>WIB (Asia/Jakarta)</option>
                        <option>WITA (Asia/Makassar)</option>
                        <option>WIT (Asia/Jayapura)</option>
                    </select>
                </div>
                <div class="form-group"><label class="form-label">Format Tanggal</label>
                    <select class="form-input">
                        <option>dd/mm/yyyy</option><option>dd-mm-yyyy</option><option>yyyy-mm-dd</option>
                    </select>
                </div>
            </div>
        </section>

        {{-- Akun Admin --}}
        <section class="card shadow-card overflow-hidden" style="border-left:3px solid var(--color-warning);">
            <div class="card-header">
                <div>
                    <h3>Pengaturan Akun Pribadi (Admin)</h3>
                    <p class="text-xs mt-1" style="color:var(--text-secondary);">Ubah email, password, atau hapus akun administrator Anda.</p>
                </div>
            </div>
            <div class="p-6 space-y-6">
                @include('profile.partials.update-profile-information-form')
                <div class="divider"></div>
                @include('profile.partials.update-password-form')
            </div>
        </section>
    </div>
</x-admin-layout>
