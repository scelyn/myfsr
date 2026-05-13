<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierRecapItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_recap_id',
        'order_item_id',
        'product_id',
        'product_name',
        'product_unit',
        'quantity',
        'estimated_unit_price',
        'estimated_subtotal',
        'actual_unit_price',
        'actual_subtotal',
        'notes',
    ];

    protected $casts = [
        'quantity'               => 'decimal:2',
        'estimated_unit_price'   => 'decimal:2',
        'estimated_subtotal'     => 'decimal:2',
        'actual_unit_price'      => 'decimal:2',
        'actual_subtotal'        => 'decimal:2',
    ];

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function supplierRecap(): BelongsTo
    {
        return $this->belongsTo(SupplierRecap::class);
    }

    public function orderItem(): BelongsTo
    {
        return $this->belongsTo(OrderItem::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    // ─── Accessors ─────────────────────────────────────────────────────────────

    /** Selisih estimasi vs aktual per item */
    public function getCostVarianceAttribute(): ?float
    {
        if ($this->actual_subtotal === null) return null;
        return $this->actual_subtotal - $this->estimated_subtotal;
    }
}
