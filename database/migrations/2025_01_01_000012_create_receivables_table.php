<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('receivables', function (Blueprint $table) {
            $table->id();
            $table->foreignId('invoice_id')->unique()->constrained('invoices')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->restrictOnDelete();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();

            // status: outstanding → partial → settled | written_off
            $table->enum('status', [
                'outstanding',  // belum dibayar sama sekali
                'partial',      // dibayar sebagian
                'settled',      // lunas
                'written_off',  // dihapusbukukan (piutang macet)
            ])->default('outstanding');

            $table->date('due_date');
            $table->decimal('original_amount', 15, 2)->comment('Total piutang awal');
            $table->decimal('paid_amount', 15, 2)->default(0)->comment('Total yang sudah dibayar');
            $table->decimal('remaining_amount', 15, 2)->comment('Sisa piutang = original - paid');

            // Risk scoring untuk SMART PROFIT ESTIMATION
            $table->integer('days_overdue')->default(0)->comment('Jumlah hari melewati jatuh tempo');
            $table->enum('risk_level', ['low', 'medium', 'high', 'critical'])->default('low')
                ->comment('low: < 7 hari, medium: 7-30 hari, high: 30-60 hari, critical: > 60 hari');

            $table->text('notes')->nullable();
            $table->timestamp('settled_at')->nullable();
            $table->timestamps();

            $table->index(['customer_id', 'status']);
            $table->index(['status', 'due_date']);
            $table->index('risk_level');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('receivables');
    }
};
