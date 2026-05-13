<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number', 30)->unique()->comment('Nomor order, contoh: ORD-2025-001');
            $table->foreignId('customer_id')->constrained('customers')->restrictOnDelete();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();

            // Status flow: draft → confirmed → processing → ready → delivered → completed | cancelled
            $table->enum('status', [
                'draft',       // baru input, belum dikonfirmasi
                'confirmed',   // sudah dikonfirmasi ke supplier
                'processing',  // supplier sedang proses
                'ready',       // barang siap
                'delivered',   // barang sudah dikirim ke customer
                'completed',   // order selesai, invoice dibayar lunas
                'cancelled',   // dibatalkan
            ])->default('draft');

            $table->enum('order_source', ['whatsapp', 'field_sales', 'direct', 'other'])->default('whatsapp');
            $table->date('order_date');
            $table->date('requested_delivery_date')->nullable()->comment('Tanggal pengiriman yang diminta customer');
            $table->date('actual_delivery_date')->nullable()->comment('Tanggal realisasi pengiriman');

            // Financial summary — dihitung otomatis dari order_items
            $table->decimal('subtotal', 15, 2)->default(0)->comment('Total sebelum diskon');
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('total_amount', 15, 2)->default(0)->comment('Total yang harus dibayar customer');

            // Profit estimation — diisi saat input order, belum final
            $table->decimal('estimated_cogs', 15, 2)->default(0)->comment('Estimasi HPP berdasarkan base_price produk');
            $table->decimal('estimated_profit', 15, 2)->default(0)->comment('Laba potensial = total_amount - estimated_cogs');

            // Profit realization — diisi setelah harga supplier masuk (supplier recap)
            $table->decimal('actual_cogs', 15, 2)->default(0)->comment('HPP aktual setelah rekap supplier');
            $table->decimal('actual_profit', 15, 2)->default(0)->comment('Laba terealisasi = total_amount - actual_cogs');

            $table->text('notes')->nullable();
            $table->text('cancellation_reason')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('order_number');
            $table->index(['customer_id', 'status']);
            $table->index(['status', 'order_date']);
            $table->index('order_date');
            $table->index('created_by');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
