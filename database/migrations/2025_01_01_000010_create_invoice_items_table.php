<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->constrained('invoices')->cascadeOnDelete();
            $table->foreignId('order_item_id')->constrained('order_items')->restrictOnDelete();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();

            $table->string('product_name', 150)->comment('Snapshot nama produk');
            $table->string('product_unit', 30);
            $table->decimal('quantity', 10, 2);
            $table->decimal('unit_price', 15, 2);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('subtotal', 15, 2);

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('invoice_id');
            $table->index('order_item_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoice_items');
    }
};
