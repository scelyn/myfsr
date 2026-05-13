<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_number', 30)->unique()->comment('Nomor invoice, contoh: INV-2025-001');
            $table->foreignId('order_id')->constrained('orders')->restrictOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->restrictOnDelete();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();

            // status: draft → issued → partial_paid → paid → overdue | cancelled
            $table->enum('status', [
                'draft',        // belum diterbitkan
                'issued',       // sudah diterbitkan ke customer
                'partial_paid', // dibayar sebagian
                'paid',         // lunas
                'overdue',      // melewati jatuh tempo
                'cancelled',    // dibatalkan
            ])->default('draft');

            $table->date('invoice_date');
            $table->date('due_date')->comment('Tanggal jatuh tempo');

            $table->decimal('subtotal', 15, 2)->default(0);
            $table->decimal('discount_amount', 15, 2)->default(0);
            $table->decimal('tax_amount', 15, 2)->default(0)->comment('PPN jika ada');
            $table->decimal('total_amount', 15, 2)->default(0);
            $table->decimal('paid_amount', 15, 2)->default(0)->comment('Total yang sudah dibayar');
            $table->decimal('remaining_amount', 15, 2)->default(0)->comment('Sisa yang belum dibayar = piutang');

            $table->text('notes')->nullable();
            $table->text('terms_and_conditions')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('invoice_number');
            $table->index(['customer_id', 'status']);
            $table->index(['status', 'due_date']);
            $table->index('order_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
