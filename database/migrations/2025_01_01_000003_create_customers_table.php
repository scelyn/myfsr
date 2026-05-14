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
            $table->string('nama_toko', 150);
            $table->string('nama_pemilik', 150);
            $table->string('no_whatsapp', 20);
            $table->text('alamat_pasar')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('nama_toko');
            $table->index('nama_pemilik');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
