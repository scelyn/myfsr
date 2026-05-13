<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_number', 30)->unique()->comment('Nomor pembayaran, contoh: PAY-SUP-001');
            $table->foreignId('supplier_recap_id')->constrained('supplier_recaps')->restrictOnDelete();
            $table->foreignId('supplier_id')->constrained('suppliers')->restrictOnDelete();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();

            $table->date('payment_date');
            $table->decimal('amount', 15, 2)->comment('Jumlah yang dibayar ke supplier');

            $table->enum('payment_method', [
                'cash',
                'bank_transfer',
                'cheque',
                'other',
            ])->default('bank_transfer');

            $table->string('reference_number', 100)->nullable()->comment('Nomor referensi transfer');
            $table->string('bank_name', 50)->nullable();
            $table->text('notes')->nullable();

            $table->decimal('recap_balance_before', 15, 2)->default(0)->comment('Sisa hutang ke supplier sebelum pembayaran');
            $table->decimal('recap_balance_after', 15, 2)->default(0)->comment('Sisa hutang ke supplier setelah pembayaran');

            $table->timestamps();
            $table->softDeletes();

            $table->index('payment_number');
            $table->index(['supplier_id', 'payment_date']);
            $table->index('supplier_recap_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_payments');
    }
};
