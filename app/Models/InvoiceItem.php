<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InvoiceItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'order_item_id',
        'product_id',
        'product_name',
        'product_unit',
        'quantity',
        'unit_price',
        'discount_amount',
        'subtotal',
        'notes',
    ];

    protected $casts = [
        'quantity'        => 'decimal:2',
        'unit_price'      => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'subtotal'        => 'decimal:2',
    ];

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
