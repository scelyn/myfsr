<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Supplier extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'contact_name',
        'phone',
        'whatsapp',
        'address',
        'bank_name',
        'bank_account_number',
        'bank_account_name',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function supplierRecaps(): HasMany
    {
        return $this->hasMany(SupplierRecap::class);
    }

    public function supplierPayments(): HasMany
    {
        return $this->hasMany(SupplierPayment::class);
    }

    // ─── Scopes ────────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ─── Accessors ─────────────────────────────────────────────────────────────

    public function getTotalOutstandingAttribute(): float
    {
        return $this->supplierRecaps()
            ->whereNotIn('status', ['paid'])
            ->sum('total_actual_cost');
    }
}
