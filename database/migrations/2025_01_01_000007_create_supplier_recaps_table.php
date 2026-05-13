<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('supplier_recaps', function (Blueprint $table) {
            $table->id();
            $table->string('recap_number', 30)->unique()->comment('Nomor rekap, contoh: RKP-2025-001');
            $table->foreignId('supplier_id')->constrained('suppliers')->restrictOnDelete();
            $table->foreignId('created_by')->constrained('users')->restrictOnDelete();

            // status: draft → sent → received → invoiced → paid
            $table->enum('status', [
                'draft',     // baru dibuat
                'sent',      // sudah dikirim ke supplier
                'received',  // barang sudah diterima
                'invoiced',  // bon dari supplier sudah masuk
                'paid',      // sudah dibayar ke supplier
            ])->default('draft');

            $table->date('recap_date');
            $table->date('expected_delivery_date')->nullable();
            $table->date('actual_delivery_date')->nullable();

            // Totals (dihitung dari supplier_recap_items)
            $table->decimal('total_estimated_cost', 15, 2)->default(0)->comment('Total estimasi biaya ke supplier');
            $table->decimal('total_actual_cost', 15, 2)->default(0)->comment('Total biaya aktual dari bon supplier');

            $table->string('supplier_invoice_number', 100)->nullable()->comment('Nomor bon / faktur dari supplier');
            $table->date('supplier_invoice_date')->nullable();

            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index(['supplier_id', 'status']);
            $table->index('recap_date');
            $table->index('recap_number');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('supplier_recaps');
    }
};
