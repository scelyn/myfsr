<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique()->comment('Kode unik customer, contoh: CUST-001');
            $table->string('name', 150);
            $table->string('phone', 20)->nullable();
            $table->string('whatsapp', 20)->nullable();
            $table->text('address')->nullable();
            $table->enum('customer_type', ['retail', 'wholesaler', 'regular'])->default('regular');
            $table->decimal('credit_limit', 15, 2)->default(0)->comment('Batas piutang yang diizinkan');
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_active');
            $table->index('customer_type');
            $table->index('code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
