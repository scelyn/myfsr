<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'code',
        'name',
        'phone',
        'whatsapp',
        'address',
        'customer_type',
        'credit_limit',
        'is_active',
        'notes',
    ];

    protected $casts = [
        'is_active'    => 'boolean',
        'credit_limit' => 'decimal:2',
    ];

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    public function invoices(): HasMany
    {
        return $this->hasMany(Invoice::class);
    }

    public function customerPayments(): HasMany
    {
        return $this->hasMany(CustomerPayment::class);
    }

    public function receivables(): HasMany
    {
        return $this->hasMany(Receivable::class);
    }

    // ─── Scopes ────────────────────────────────────────────────────────────────

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    // ─── Accessors (Smart Profit Estimation - Receivable Risk) ─────────────────

    /** Total piutang belum lunas */
    public function getTotalReceivableAttribute(): float
    {
        return $this->receivables()
            ->whereIn('status', ['outstanding', 'partial'])
            ->sum('remaining_amount');
    }

    /** Apakah melebihi credit limit */
    public function getIsOverCreditLimitAttribute(): bool
    {
        return $this->total_receivable > $this->credit_limit;
    }

    /** Risk level customer berdasarkan piutang tertua */
    public function getReceivableRiskLevelAttribute(): string
    {
        $maxDaysOverdue = $this->receivables()
            ->whereIn('status', ['outstanding', 'partial'])
            ->max('days_overdue') ?? 0;

        return match (true) {
            $maxDaysOverdue > 60  => 'critical',
            $maxDaysOverdue > 30  => 'high',
            $maxDaysOverdue > 7   => 'medium',
            default               => 'low',
        };
    }
}
