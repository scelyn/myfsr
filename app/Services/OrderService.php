<?php

namespace App\Services;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderService extends BaseService
{
    /**
     * Create a new order with items using database transaction
     */
    public function createOrder(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            // 1. Prepare Order Data
            $orderData = [
                'order_number' => $this->generateOrderNumber(),
                'customer_id' => $data['customer_id'],
                'created_by' => Auth::id(),
                'order_date' => $data['order_date'] ?? now(),
                'notes' => $data['notes'] ?? null,
            ];

            $order = Order::create($orderData);

            // 2. Process Items
            foreach ($data['items'] as $item) {
                $product = Product::findOrFail($item['product_id']);
                
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'product_name' => $product->nama_barang,
                    'product_unit' => $product->satuan,
                    'quantity' => $item['quantity'],
                    'notes' => $item['notes'] ?? null,
                ]);
            }

            return $order->load('items.product', 'customer');
        });
    }

    /**
     * Generate unique order number: ORD-YYYYMMDD-XXXX
     */
    private function generateOrderNumber(): string
    {
        $date = now()->format('Ymd');
        $prefix = "ORD-{$date}-";
        
        $latest = Order::where('order_number', 'like', "{$prefix}%")
            ->orderBy('order_number', 'desc')
            ->first();

        if (!$latest) {
            return "{$prefix}001";
        }

        $lastNumber = (int) substr($latest->order_number, -3);
        $newNumber = str_pad($lastNumber + 1, 3, '0', STR_PAD_LEFT);

        return "{$prefix}{$newNumber}";
    }

    /**
     * Get paginated orders with filters
     */
    public function getPaginated(array $filters = [], int $perPage = 10)
    {
        $query = Order::with('customer', 'createdBy')->latest();

        if (!empty($filters['search'])) {
            $query->where('order_number', 'like', "%{$filters['search']}%")
                ->orWhereHas('customer', function($q) use ($filters) {
                    $q->where('nama_toko', 'like', "%{$filters['search']}%");
                });
        }

        return $query->paginate($perPage)->withQueryString();
    }
}
