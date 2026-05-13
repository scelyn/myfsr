<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'product_unit',
        'quantity',
        'unit_price',
        'discount_amount',
        'subtotal',
        'estimated_base_price',
        'estimated_cogs',
        'estimated_profit',
        'actual_base_price',
        'actual_cogs',
        'actual_profit',
        'notes',
    ];

    protected $casts = [
        'quantity'              => 'decimal:2',
        'unit_price'            => 'decimal:2',
        'discount_amount'       => 'decimal:2',
        'subtotal'              => 'decimal:2',
        'estimated_base_price'  => 'decimal:2',
        'estimated_cogs'        => 'decimal:2',
        'estimated_profit'      => 'decimal:2',
        'actual_base_price'     => 'decimal:2',
        'actual_cogs'           => 'decimal:2',
        'actual_profit'         => 'decimal:2',
    ];

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function supplierRecapItem(): HasOne
    {
        return $this->hasOne(SupplierRecapItem::class);
    }

    public function invoiceItem(): HasOne
    {
        return $this->hasOne(InvoiceItem::class);
    }

    // ─── Accessors ─────────────────────────────────────────────────────────────

    public function getEstimatedProfitMarginAttribute(): float
    {
        if ($this->subtotal == 0) return 0;
        return ($this->estimated_profit / $this->subtotal) * 100;
    }

    public function getActualProfitMarginAttribute(): ?float
    {
        if (!$this->actual_profit || $this->subtotal == 0) return null;
        return ($this->actual_profit / $this->subtotal) * 100;
    }
}
