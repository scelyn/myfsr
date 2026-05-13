<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Receivable extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_id',
        'customer_id',
        'created_by',
        'status',
        'due_date',
        'original_amount',
        'paid_amount',
        'remaining_amount',
        'days_overdue',
        'risk_level',
        'notes',
        'settled_at',
    ];

    protected $casts = [
        'due_date'        => 'date',
        'original_amount' => 'decimal:2',
        'paid_amount'     => 'decimal:2',
        'remaining_amount'=> 'decimal:2',
        'days_overdue'    => 'integer',
        'settled_at'      => 'datetime',
    ];

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // ─── Scopes ────────────────────────────────────────────────────────────────

    public function scopeOutstanding($query)
    {
        return $query->whereIn('status', ['outstanding', 'partial']);
    }

    public function scopeByRisk($query, string $level)
    {
        return $query->where('risk_level', $level);
    }

    public function scopeHighRisk($query)
    {
        return $query->whereIn('risk_level', ['high', 'critical']);
    }

    // ─── Accessors (Smart Profit Estimation – Receivable Risk) ─────────────────

    public function getRiskLabelAttribute(): string
    {
        return match ($this->risk_level) {
            'low'      => 'Aman',
            'medium'   => 'Perlu Perhatian',
            'high'     => 'Berisiko',
            'critical' => 'Kritis',
            default    => '-',
        };
    }

    public function getRiskColorAttribute(): string
    {
        return match ($this->risk_level) {
            'low'      => 'green',
            'medium'   => 'yellow',
            'high'     => 'orange',
            'critical' => 'red',
            default    => 'gray',
        };
    }

    /** Persentase recovery: sudah dibayar berapa persen dari total */
    public function getRecoveryPercentageAttribute(): float
    {
        if ($this->original_amount == 0) return 0;
        return ($this->paid_amount / $this->original_amount) * 100;
    }

    /** Update risk level berdasarkan days_overdue */
    public function recalculateRisk(): void
    {
        $this->days_overdue = $this->due_date->isPast()
            ? $this->due_date->diffInDays(now())
            : 0;

        $this->risk_level = match (true) {
            $this->days_overdue > 60 => 'critical',
            $this->days_overdue > 30 => 'high',
            $this->days_overdue > 7  => 'medium',
            default                  => 'low',
        };

        $this->save();
    }
}
