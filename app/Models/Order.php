<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'order_number',
        'customer_id',
        'created_by',
        'status',
        'order_source',
        'order_date',
        'requested_delivery_date',
        'actual_delivery_date',
        'subtotal',
        'discount_amount',
        'total_amount',
        'estimated_cogs',
        'estimated_profit',
        'actual_cogs',
        'actual_profit',
        'notes',
        'cancellation_reason',
    ];

    protected $casts = [
        'order_date'               => 'date',
        'requested_delivery_date'  => 'date',
        'actual_delivery_date'     => 'date',
        'subtotal'                 => 'decimal:2',
        'discount_amount'          => 'decimal:2',
        'total_amount'             => 'decimal:2',
        'estimated_cogs'           => 'decimal:2',
        'estimated_profit'         => 'decimal:2',
        'actual_cogs'              => 'decimal:2',
        'actual_profit'            => 'decimal:2',
    ];

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function invoice(): HasOne
    {
        return $this->hasOne(Invoice::class);
    }

    public function supplierRecaps(): HasMany
    {
        return $this->hasMany(SupplierRecap::class);
    }

    // ─── Scopes ────────────────────────────────────────────────────────────────

    public function scopeByStatus($query, string $status)
    {
        return $query->where('status', $status);
    }

    public function scopeActive($query)
    {
        return $query->whereNotIn('status', ['cancelled']);
    }

    // ─── Accessors (Smart Profit Estimation) ───────────────────────────────────

    /** Laba potensial (sebelum harga supplier masuk) */
    public function getEstimatedProfitMarginAttribute(): float
    {
        if ($this->total_amount == 0) return 0;
        return ($this->estimated_profit / $this->total_amount) * 100;
    }

    /** Laba terealisasi (setelah harga supplier aktual masuk) */
    public function getActualProfitMarginAttribute(): float
    {
        if ($this->total_amount == 0) return 0;
        return ($this->actual_profit / $this->total_amount) * 100;
    }

    /** Apakah harga aktual sudah diinput (rekap supplier sudah masuk) */
    public function getIsCostFinalizedAttribute(): bool
    {
        return $this->actual_cogs > 0;
    }

    // ─── Status Helpers ────────────────────────────────────────────────────────

    public function isDraft(): bool        { return $this->status === 'draft'; }
    public function isConfirmed(): bool    { return $this->status === 'confirmed'; }
    public function isCompleted(): bool    { return $this->status === 'completed'; }
    public function isCancelled(): bool    { return $this->status === 'cancelled'; }
}
