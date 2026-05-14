<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->decimal('total_amount', 15, 2)->default(0)->after('order_date');
            $table->decimal('estimated_cogs', 15, 2)->default(0)->after('total_amount');
            $table->decimal('estimated_profit', 15, 2)->default(0)->after('estimated_cogs');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->decimal('unit_price', 15, 2)->default(0)->after('quantity');
            $table->decimal('subtotal', 15, 2)->default(0)->after('unit_price');
            $table->decimal('estimated_base_price', 15, 2)->default(0)->after('subtotal');
            $table->decimal('estimated_profit', 15, 2)->default(0)->after('estimated_base_price');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropColumn(['unit_price', 'subtotal', 'estimated_base_price', 'estimated_profit']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['total_amount', 'estimated_cogs', 'estimated_profit']);
        });
    }
};
