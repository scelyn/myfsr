# MyFSR — Enterprise Reseller Management System

MyFSR adalah sistem manajemen reseller sembako preorder berbasis web yang dirancang untuk membantu UMKM mengelola transaksi customer, rekap supplier, invoice, piutang, dan laporan bisnis secara lebih efektif, terintegrasi, dan profesional.

Sistem ini dibangun menggunakan Laravel dengan pendekatan clean architecture dan modern enterprise dashboard UI.

---

# ✨ Features

## Dashboard Analytics
- Total omzet
- Total piutang customer
- Estimasi laba
- Rekap supplier harian
- Aktivitas transaksi terbaru

---

## Master Produk
- CRUD produk
- Search & pagination
- Harga beli & harga jual
- Estimasi keuntungan otomatis
- Realtime calculation

---

## Data Customer
- CRUD customer
- Histori transaksi
- Histori pembayaran
- Total piutang aktif
- Detail customer

---

## Transaksi Pesanan
- Multi produk
- Dynamic order form
- Realtime subtotal & total
- Invoice otomatis
- Integrasi WhatsApp
- Cetak invoice PDF

---

## Rekap Supplier Otomatis
- Agregasi otomatis dari seluruh transaksi harian
- Penggabungan produk otomatis
- Filter tanggal
- Export PDF
- Print supplier sheet
- WhatsApp supplier integration

---

## Invoice System
- Generate invoice otomatis
- Cetak thermal / A4
- PDF export
- WhatsApp share
- Deteksi piutang otomatis

---

## Sistem Piutang
- Histori tagihan
- Pembayaran parsial
- Sisa piutang otomatis
- Tracking tunggakan customer
- Sinkronisasi invoice

---

## UI/UX Enterprise
- Modern enterprise dashboard
- Responsive layout
- Dark premium palette
- Compact professional spacing
- Interactive sidebar
- Modern hover interaction
- Toast notification
- Confirmation modal

---

# 🛠️ Tech Stack

## Backend
- Laravel 12
- PHP 8.2
- MySQL

## Frontend
- Blade Template
- Tailwind CSS
- Alpine.js
- TomSelect

## Additional
- DomPDF
- Vite
- WhatsApp Integration
- Service Layer Architecture

---

# 🎨 Design System

## Color Palette

| Color | Hex |
|------|------|
| Primary Dark | #06141B |
| Dark Navy | #11212D |
| Secondary | #253745 |
| Muted Blue | #4A5C6A |
| Soft Gray | #9BA8AB |
| Neutral Light | #CCD0CF |

---

# 🔄 Business Flow

## Customer Order Flow

Customer melakukan pemesanan  
↓  
Admin input transaksi customer  
↓  
Sistem generate invoice otomatis  
↓  
Data transaksi otomatis masuk rekap supplier harian  
↓  
Admin generate rekap supplier  
↓  
Supplier menerima rekap barang  
↓  
Barang dikirim supplier  
↓  
Admin mengelola pembayaran customer  
↓  
Jika belum lunas → masuk piutang  
↓  
Piutang otomatis muncul di invoice berikutnya

---

# 📄 Module Overview

## Product Management
Mengelola data barang reseller.

## Customer Management
Mengelola data pelanggan dan histori transaksi.

## Order Transaction
Mengelola transaksi pemesanan customer.

## Invoice Management
Generate dan export invoice customer.

## Supplier Recap
Rekap kebutuhan barang supplier otomatis.

## Receivable Management
Mengelola piutang customer.

## Dashboard Analytics
Visualisasi performa bisnis.

---

# ⚙️ Installation

## Clone Repository

```bash
git clone https://github.com/USERNAME/myfsr-sipedis.git
