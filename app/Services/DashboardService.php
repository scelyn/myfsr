<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Customer;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;

class DashboardService extends BaseService
{
    public function getDashboardData()
    {
        return Cache::remember('dashboard_data', 300, function () {
            return [
                'stats' => $this->getCoreStats(),
                'topProducts' => $this->getTopProducts(),
                'monthlySales' => $this->getMonthlySales(),
                'recentOrders' => $this->getRecentOrders(),
                'recentPayments' => $this->getRecentPayments(),
            ];
        });
    }

    private function getCoreStats()
    {
        $totalOrders = Order::count();
        $totalQty = OrderItem::sum('quantity');
        $activeCustomers = Customer::active()->count();
        
        $totalPiutang = \App\Models\Invoice::sum('remaining_amount');
        $unpaidCustomers = \App\Models\Invoice::where('remaining_amount', '>', 0)->distinct('customer_id')->count('customer_id');

        $totalOmzet = \App\Models\Invoice::sum('total_amount');
        $estimasiLaba = \App\Models\Order::sum('estimated_profit');

        return [
            'total_piutang' => $totalPiutang,
            'total_orders' => $totalOrders,
            'active_customers' => $activeCustomers,
            'unpaid_customers' => $unpaidCustomers,
            'total_qty' => $totalQty,
            'total_omzet' => $totalOmzet,
            'estimasi_laba' => $estimasiLaba,
        ];
    }

    private function getRecentPayments()
    {
        return \App\Models\CustomerPayment::with('customer:id,nama_toko')
            ->select('id', 'customer_id', 'payment_number', 'amount', 'payment_date')
            ->latest('id')
            ->take(5)
            ->get();
    }

    private function getTopProducts()
    {
        return OrderItem::select('product_name', 'product_unit', DB::raw('SUM(quantity) as total_qty'))
            ->groupBy('product_name', 'product_unit')
            ->orderBy('total_qty', 'desc')
            ->take(5)
            ->get();
    }

    private function getMonthlySales()
    {
        // Optimize: valid GROUP BY
        return Order::select(
                DB::raw('DATE_FORMAT(order_date, "%b") as month'),
                DB::raw('COUNT(id) as total')
            )
            ->where('order_date', '>=', now()->subMonths(6))
            ->groupBy(DB::raw('DATE_FORMAT(order_date, "%b"), MONTH(order_date)'))
            ->orderByRaw('MONTH(order_date) ASC')
            ->get();
    }

    private function getRecentOrders()
    {
        // Optimize: select specific columns to avoid memory bloat
        return Order::with('customer:id,nama_toko')
            ->select('id', 'order_number', 'customer_id', 'order_date')
            ->latest('id') // faster than order_date
            ->take(5)
            ->get();
    }
}
