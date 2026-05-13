<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('code', 20)->unique()->comment('Kode unik supplier, contoh: SUP-001');
            $table->string('name', 150);
            $table->string('contact_name', 100)->nullable()->comment('Nama PIC supplier');
            $table->string('phone', 20)->nullable();
            $table->string('whatsapp', 20)->nullable();
            $table->text('address')->nullable();
            $table->string('bank_name', 50)->nullable();
            $table->string('bank_account_number', 50)->nullable();
            $table->string('bank_account_name', 100)->nullable();
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('is_active');
            $table->index('code');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
