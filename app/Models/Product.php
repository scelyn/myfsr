<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'supplier_id',
        'code',
        'name',
        'unit',
        'description',
        'base_price',
        'selling_price',
        'profit_margin',
        'is_active',
    ];

    protected $casts = [
        'base_price'    => 'decimal:2',
        'selling_price' => 'decimal:2',
        'profit_margin' => 'decimal:4',
        'is_active'     => 'boolean',
    ];

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function supplierRecapItems(): HasMany
    {
        return $this->hasMany(SupplierRecapItem::class);
    }

    public function invoiceItems(): HasMany
    {
        return $this->hasMany(InvoiceItem::class);
    }

    // ─── Scopes ────────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ─── Accessors ─────────────────────────────────────────────────────────────

    /** Margin laba dalam rupiah */
    public function getProfitAmountAttribute(): float
    {
        return $this->selling_price - $this->base_price;
    }

    /** Margin laba dalam persen */
    public function getProfitPercentageAttribute(): float
    {
        if ($this->base_price == 0) return 0;
        return (($this->selling_price - $this->base_price) / $this->base_price) * 100;
    }
}
