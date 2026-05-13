<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained('categories')->restrictOnDelete();
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->nullOnDelete()
                ->comment('Supplier utama produk ini');
            $table->string('code', 30)->unique()->comment('SKU produk, contoh: PRD-001');
            $table->string('name', 150);
            $table->string('unit', 30)->comment('Satuan: kg, sak, karung, dus, dll');
            $table->text('description')->nullable();
            $table->decimal('base_price', 15, 2)->default(0)->comment('Harga beli estimasi dari supplier');
            $table->decimal('selling_price', 15, 2)->default(0)->comment('Harga jual default ke customer');
            $table->decimal('profit_margin', 8, 4)->default(0)->comment('Margin laba default dalam persen');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();

            $table->index(['category_id', 'is_active']);
            $table->index('supplier_id');
            $table->index('code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
