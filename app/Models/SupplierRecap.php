<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SupplierRecap extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'recap_number',
        'supplier_id',
        'created_by',
        'status',
        'recap_date',
        'expected_delivery_date',
        'actual_delivery_date',
        'total_estimated_cost',
        'total_actual_cost',
        'supplier_invoice_number',
        'supplier_invoice_date',
        'notes',
    ];

    protected $casts = [
        'recap_date'              => 'date',
        'expected_delivery_date'  => 'date',
        'actual_delivery_date'    => 'date',
        'supplier_invoice_date'   => 'date',
        'total_estimated_cost'    => 'decimal:2',
        'total_actual_cost'       => 'decimal:2',
    ];

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items(): HasMany
    {
        return $this->hasMany(SupplierRecapItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(SupplierPayment::class);
    }

    // ─── Accessors ─────────────────────────────────────────────────────────────

    public function getTotalPaidAttribute(): float
    {
        return $this->payments()->sum('amount');
    }

    public function getRemainingAmountAttribute(): float
    {
        return $this->total_actual_cost - $this->total_paid;
    }

    public function getIsFullyPaidAttribute(): bool
    {
        return $this->remaining_amount <= 0;
    }

    public function getHasActualCostAttribute(): bool
    {
        return $this->total_actual_cost > 0;
    }

    // ─── Scopes ────────────────────────────────────────────────────────────────

    public function scopeUnpaid($query)
    {
        return $query->whereNotIn('status', ['paid']);
    }
}
