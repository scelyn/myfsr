<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Invoice;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class PricingService extends BaseService
{
    /**
     * Finalize daily pricing for products.
     * $data format:
     * [
     *    'date' => '2026-05-14',
     *    'prices' => [
     *         product_id => [
     *             'harga_beli' => 10000,
     *             'harga_jual' => 12000
     *         ],
     *         ...
     *    ]
     * ]
     */
    public function finalizeDailyPricing(array $data)
    {
        $date = Carbon::parse($data['date'])->format('Y-m-d');
        $prices = $data['prices'];

        return DB::transaction(function () use ($date, $prices) {
            $updatedOrders = [];

            // 1. Update order items based on product id
            foreach ($prices as $productId => $priceInfo) {
                $hargaBeli = $priceInfo['harga_beli'];
                $hargaJual = $priceInfo['harga_jual'];

                // Update default price in master product
                Product::where('id', $productId)->update([
                    'harga_beli_default' => $hargaBeli,
                    // If margin is maintained, you could update margin_default too, but we just want to apply today's prices
                ]);

                // Find all order items for this product on this date
                $items = OrderItem::whereHas('order', function ($q) use ($date) {
                        $q->whereDate('order_date', $date)->whereNull('deleted_at');
                    })
                    ->where('product_id', $productId)
                    ->get();

                foreach ($items as $item) {
                    $quantity = $item->quantity;
                    $subtotal = $quantity * $hargaJual;
                    $estimatedBasePrice = $quantity * $hargaBeli;
                    $estimatedProfit = $subtotal - $estimatedBasePrice;

                    $item->update([
                        'unit_price' => $hargaJual,
                        'subtotal' => $subtotal,
                        'estimated_base_price' => $hargaBeli,
                        'estimated_profit' => $estimatedProfit,
                    ]);

                    $updatedOrders[$item->order_id] = true;
                }
            }

            // 2. Recalculate orders and generate/update invoices
            foreach (array_keys($updatedOrders) as $orderId) {
                $order = Order::with('items')->find($orderId);
                
                $totalAmount = $order->items->sum('subtotal');
                $totalCogs = $order->items->sum(function($item) {
                    return $item->quantity * $item->estimated_base_price;
                });
                $totalProfit = $order->items->sum('estimated_profit');

                $order->update([
                    'total_amount' => $totalAmount,
                    'estimated_cogs' => $totalCogs,
                    'estimated_profit' => $totalProfit
                ]);

                // Generate or update invoice
                $invoice = Invoice::where('order_id', $order->id)->first();
                if ($invoice) {
                    $invoice->update([
                        'total_amount' => $totalAmount,
                        'remaining_amount' => $totalAmount - $invoice->paid_amount
                    ]);
                } else {
                    // Get all previous UNPAID invoices for this customer to display as visual piutang
                    $previousInvoices = Invoice::where('customer_id', $order->customer_id)
                        ->where('status', '!=', 'paid')
                        ->get();
                    
                    $totalPiutang = $previousInvoices->sum('remaining_amount');

                    Invoice::create([
                        'order_id' => $order->id,
                        'invoice_number' => str_replace('ORD', 'INV', $order->order_number),
                        'customer_id' => $order->customer_id,
                        'invoice_date' => $order->order_date,
                        'due_date' => \Carbon\Carbon::parse($order->order_date)->addDays(7),
                        'total_amount' => $totalAmount,
                        'previous_piutang' => $totalPiutang, // Only for visual injection
                        'paid_amount' => 0,
                        'remaining_amount' => $totalAmount, // Do not double count in database
                        'status' => 'unpaid'
                    ]);
                }
            }

            return true;
        });
    }

    /**
     * Get aggregate products for a given date to show in pricing form
     */
    public function getProductsForPricing(string $date)
    {
        return OrderItem::query()
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->join('products', 'products.id', '=', 'order_items.product_id')
            ->whereNull('orders.deleted_at')
            ->whereDate('orders.order_date', $date)
            ->select(
                'products.id',
                'products.nama_barang',
                'products.satuan',
                'products.harga_beli_default',
                'products.margin_default',
                DB::raw('SUM(order_items.quantity) as total_qty')
            )
            ->groupBy(
                'products.id',
                'products.nama_barang',
                'products.satuan',
                'products.harga_beli_default',
                'products.margin_default'
            )
            ->orderBy('products.nama_barang')
            ->get();
    }
}
