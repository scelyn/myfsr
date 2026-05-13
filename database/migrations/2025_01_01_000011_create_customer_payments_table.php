<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_payments', function (Blueprint $table) {
            $table->id();
            $table->string('payment_number', 30)->unique()->comment('Nomor pembayaran, contoh: PAY-CUST-001');
            $table->foreignId('invoice_id')->constrained('invoices')->restrictOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->restrictOnDelete();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();

            $table->date('payment_date');
            $table->decimal('amount', 15, 2)->comment('Jumlah yang dibayar dalam transaksi ini');

            $table->enum('payment_method', [
                'cash',
                'bank_transfer',
                'qris',
                'cheque',
                'other',
            ])->default('cash');

            $table->string('reference_number', 100)->nullable()->comment('Nomor referensi transfer / cek');
            $table->string('bank_name', 50)->nullable();
            $table->text('notes')->nullable();

            // Saldo sebelum dan sesudah pembayaran (untuk audit trail)
            $table->decimal('invoice_balance_before', 15, 2)->default(0)->comment('Sisa tagihan sebelum pembayaran ini');
            $table->decimal('invoice_balance_after', 15, 2)->default(0)->comment('Sisa tagihan setelah pembayaran ini');

            $table->timestamps();
            $table->softDeletes();

            $table->index('payment_number');
            $table->index(['customer_id', 'payment_date']);
            $table->index('invoice_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_payments');
    }
};
