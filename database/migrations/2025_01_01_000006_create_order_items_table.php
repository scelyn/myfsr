<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->cascadeOnDelete();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();

            $table->string('product_name', 150)->comment('Snapshot nama produk saat order dibuat');
            $table->string('product_unit', 30)->comment('Snapshot satuan saat order dibuat');

            $table->decimal('quantity', 10, 2);
            $table->decimal('unit_price', 15, 2)->comment('Harga jual ke customer per unit');
            $table->decimal('discount_amount', 15, 2)->default(0)->comment('Diskon per item');
            $table->decimal('subtotal', 15, 2)->comment('(quantity * unit_price) - discount_amount');

            // Profit per item
            $table->decimal('estimated_base_price', 15, 2)->default(0)->comment('Snapshot base_price saat order dibuat');
            $table->decimal('estimated_cogs', 15, 2)->default(0)->comment('quantity * estimated_base_price');
            $table->decimal('estimated_profit', 15, 2)->default(0)->comment('subtotal - estimated_cogs');

            // Diisi setelah rekap supplier masuk
            $table->decimal('actual_base_price', 15, 2)->nullable()->comment('Harga beli aktual dari rekap supplier');
            $table->decimal('actual_cogs', 15, 2)->nullable()->comment('quantity * actual_base_price');
            $table->decimal('actual_profit', 15, 2)->nullable()->comment('subtotal - actual_cogs');

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('order_id');
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
