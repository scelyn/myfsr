<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_recap_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('supplier_recap_id')->constrained('supplier_recaps')->cascadeOnDelete();
            $table->foreignId('order_item_id')->constrained('order_items')->restrictOnDelete();
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();

            $table->string('product_name', 150)->comment('Snapshot nama produk');
            $table->string('product_unit', 30);
            $table->decimal('quantity', 10, 2);

            $table->decimal('estimated_unit_price', 15, 2)->default(0)->comment('Estimasi harga beli ke supplier');
            $table->decimal('estimated_subtotal', 15, 2)->default(0);

            // Diisi admin setelah menerima bon supplier
            $table->decimal('actual_unit_price', 15, 2)->nullable()->comment('Harga aktual dari bon supplier');
            $table->decimal('actual_subtotal', 15, 2)->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('supplier_recap_id');
            $table->index('order_item_id');
            $table->index('product_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_recap_items');
    }
};
