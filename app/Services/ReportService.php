<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;

class ReportService extends BaseService
{
    /**
     * Get aggregated supplier rekap for a specific date
     */
    public function getSupplierRekap(string $date)
    {
        return OrderItem::query()
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->whereDate('orders.order_date', $date)
            ->select(
                'products.nama_barang as product_name',
                'products.satuan as product_unit',
                DB::raw('MAX(products.harga_beli_default) as estimated_base_price'),
                DB::raw('MAX(products.margin_default) as estimated_margin'),
                DB::raw('SUM(order_items.quantity) as total_qty'),
                DB::raw('SUM(order_items.quantity * products.harga_beli_default) as total_modal'),
                DB::raw('SUM(order_items.quantity * products.margin_default) as total_laba')
            )
            ->groupBy(
                'order_items.product_id',
                'products.nama_barang',
                'products.satuan'
            )
            ->orderBy('products.nama_barang')
            ->get();
    }

    /**
     * Get summary for a specific date
     */
    public function getDailySummary(string $date, $rekaps = null)
    {
        $rekap = $rekaps ?? $this->getSupplierRekap($date);
        $totalTransaksi = Order::whereDate('order_date', $date)->count();

        return (object) [
            'total_transaksi' => $totalTransaksi,
            'total_qty' => $rekap->sum('total_qty'),
            'total_modal' => $rekap->sum('total_modal'),
            'total_laba' => $rekap->sum('total_laba')
        ];
    }
}
