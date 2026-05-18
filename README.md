# MyFSR (SIPEDIS) — Enterprise Management System

MyFSR (SIPEDIS) adalah sistem manajemen operasional bisnis (grosir/reseller) berbasis web yang dirancang untuk mengelola transaksi pemesanan, rekap supplier harian, penetapan harga (pricing), invoice, pembayaran piutang (dengan alokasi FIFO), hingga pelaporan secara terintegrasi dan profesional.

Sistem ini dibangun menggunakan **Laravel 12** dengan pendekatan *Clean Architecture* (Service-Repository Pattern) dan mengusung antarmuka **Enterprise Modern UI** (Dark Navy Theme).

---

## ✨ Fitur Utama

### 1. Dashboard & Analytics
- Ringkasan performa bisnis (Total Omzet, Total Piutang, Laba, dll).
- Indikator metrik harian/bulanan.
- Desain *card* analitik yang responsif.

### 2. Master Data
- **Data Produk**: Pengelolaan barang, harga beli default, dan margin default (estimasi keuntungan).
- **Data Customer**: Manajemen profil pelanggan, histori order, dan status piutang berjalan (terintegrasi otomatis).

### 3. Modul Transaksi (Order)
- Form input pesanan dinamis (Multi-item) dengan *searchable dropdown* (TomSelect).
- Perhitungan otomatis subtotal dan estimasi laba.
- Konversi otomatis dari Order menjadi Invoice.

### 4. Modul Keuangan & Piutang (Receivables)
- **Smart Payment Allocation (FIFO)**: Sistem pembayaran otomatis yang mendistribusikan nominal bayar ke invoice-invoice tertua yang belum lunas.
- Manajemen Invoice (Terbit, Dibayar Sebagian, Lunas).
- Cetak Nota/Invoice (Mendukung format A4 dan Thermal Printer) dengan komponen *Blade* terstandarisasi.
- Tracking tunggakan dan histori tagihan per customer.

### 5. Modul Harga Harian (Pricing)
- Finalisasi Harga Beli Aktual harian sebelum rekap dikirim ke supplier.
- Sistem otomatis menghitung ulang margin/laba aktual berdasarkan harga beli real-time vs harga jual ke customer.

### 6. Laporan (Reports)
- **Laporan Transaksi**: Filter laporan omzet, pesanan, dan qty berdasarkan rentang waktu (Hari ini, Minggu ini, Bulan ini, Tahun ini, Custom Range).
- **Rekap Supplier**: Agregasi total kebutuhan barang (QTY) dari semua order harian untuk diteruskan ke supplier. Mendukung cetak PDF.

### 7. Enterprise UI/UX & Keamanan
- **Dark Navy Theme**: Desain premium standar aplikasi korporat/ERP (`#06141B`, `#11212D`).
- **Session Management**: Peringatan sesi *idle* otomatis (14 menit) dan *auto-logout* (15 menit) via Alpine.js untuk keamanan ekstra tanpa *reload*.
- **Smart Feedback**: Toast notifications otomatis dan Modal Konfirmasi Hapus Data bergaya Enterprise.
- **Data Integrity Guard**: Pencegahan *hard-delete* pada data master (Produk/Customer) yang sudah memiliki relasi histori transaksi untuk menjaga integritas laporan.

---

## 🛠️ Tech Stack

**Backend:**
- Laravel 12.x
- PHP 8.2+
- MySQL / MariaDB
- Barryvdh DomPDF (Cetak Dokumen)

**Frontend:**
- Blade Templates
- Tailwind CSS (Vanilla CSS Custom Properties & Utility Classes)
- Alpine.js (Reaktivitas UI, Modals, Auto-Logout Timer)
- TomSelect (Advanced Select/Dropdown)

**Architecture & Patterns:**
- MVC (Model-View-Controller)
- Service Layer Pattern (Pemisahan Business Logic seperti FIFO Allocation ke lapisan *Service*)

---

## 🎨 Design System

**Enterprise Dark Palette:**

| Color | Hex | Penggunaan |
|-------|-----|------------|
| Primary Dark | `#06141B` | Global Sidebar & Header |
| Dark Navy | `#11212D` | Active States / Table Headers |
| Secondary | `#253745` | Hover effects / Muted borders |
| Muted Blue | `#4A5C6A` | Secondary icons |
| Soft Gray | `#9BA8AB` | Muted Text / Placeholders |
| Background | `#F7F9FB` | App Body Background |
| Primary Accent | `#3B82F6` | Primary Buttons / Links |
| Success Accent | `#10B981` | Positive Indicators |

---

## 🔄 Alur Bisnis (Business Flow)

1. **Input Pesanan**: Admin mencatat pesanan customer (Order). Sistem otomatis membuatkan Invoice dengan status *Unpaid* atau *Issued*.
2. **Rekap Harian**: Admin mengecek "Rekap Supplier" untuk mengetahui total akumulasi barang yang harus dibeli ke supplier pada hari tersebut.
3. **Update Harga (Opsional)**: Jika ada perubahan harga modal dari supplier hari ini, admin memperbarui harga beli aktual di menu "Finalisasi Harga Harian".
4. **Pembayaran Customer**: Saat customer membayar tagihannya, admin menginput nominal di modul Piutang/Pembayaran. Sistem mendistribusikan pembayaran secara *FIFO* ke invoice-invoice lama yang masih menunggak.
5. **Cetak Nota**: Admin mencetak atau mendownload PDF Nota (format A4/Thermal) untuk diberikan kepada customer sebagai bukti transaksi maupun rekap sisa piutang.

---

## ⚙️ Panduan Instalasi (Local Development)

Pastikan sistem Anda telah terinstal **PHP 8.2+**, **Composer**, **Node.js**, dan **MySQL** (direkomendasikan menggunakan Laragon atau XAMPP).

1. **Clone Repository**
   ```bash
   git clone <repository-url> myfsr
   cd myfsr
   ```

2. **Install Dependensi Backend & Frontend**
   ```bash
   composer install
   npm install
   ```

3. **Konfigurasi Environment**
   Salin file konfigurasi bawaan Laravel:
   ```bash
   cp .env.example .env
   ```
   Lalu, buka file `.env` dan atur koneksi database:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sipedis_db   # Sesuaikan nama database
   DB_USERNAME=root         # Sesuaikan username db
   DB_PASSWORD=             # Sesuaikan password db
   ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Migrasi Database & Seeder**
   Sistem membutuhkan migrasi tabel dan data akun awal (Admin).
   ```bash
   php artisan migrate:fresh --seed
   ```

6. **Build Asset Frontend**
   Kompilasi file Tailwind CSS dan JavaScript bawaan:
   ```bash
   npm run build
   ```

7. **Jalankan Aplikasi**
   Jika menggunakan terminal bawaan (tanpa Laragon domain):
   ```bash
   php artisan serve
   ```
   Akses aplikasi melalui web browser di: `http://localhost:8000`

---
*Dikembangkan untuk mempercepat digitalisasi UMKM, Grosir, & Reseller menuju standar operasional kelas Enterprise.*
