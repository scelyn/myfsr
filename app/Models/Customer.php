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
        'nama_toko',
        'nama_pemilik',
        'no_whatsapp',
        'alamat_pasar',
    ];

    protected $casts = [];

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

    /** Simple scope for search */
    public function scopeActive($query)
    {
        return $query->whereNotNull('id');
    }

    public function scopeSearch($query, $term)
    {
        return $query->where(function ($q) use ($term) {
            $q->where('nama_toko', 'like', "%{$term}%")
              ->orWhere('nama_pemilik', 'like', "%{$term}%");
        });
    }

    // ─── Accessors (Smart Profit Estimation - Receivable Risk) ─────────────────

    /** Total piutang belum lunas */
    public function getTotalReceivableAttribute(): float
    {
        return (float) $this->receivables()
            ->whereIn('status', ['unpaid', 'partial'])
            ->sum('remaining_amount');
    }

    /** Total Transaksi (Total Order Selesai) */
    public function getTotalTransactionsAttribute(): float
    {
        return (float) $this->orders()->sum('total_amount');
    }

    /** Risk level customer berdasarkan piutang tertua */
    public function getReceivableRiskLevelAttribute(): string
    {
        $oldestReceivable = $this->receivables()
            ->whereIn('status', ['unpaid', 'partial'])
            ->where('due_date', '<', now())
            ->orderBy('due_date', 'asc')
            ->first();

        if (!$oldestReceivable) return 'low';

        $maxDaysOverdue = $oldestReceivable->days_overdue;

        return match (true) {
            $maxDaysOverdue > 60  => 'critical',
            $maxDaysOverdue > 30  => 'high',
            $maxDaysOverdue > 7   => 'medium',
            default               => 'low',
        };
    }
}
