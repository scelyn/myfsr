<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Invoice extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'invoice_number',
        'order_id',
        'customer_id',
        'created_by',
        'status',
        'invoice_date',
        'due_date',
        'subtotal',
        'discount_amount',
        'tax_amount',
        'total_amount',
        'paid_amount',
        'remaining_amount',
        'notes',
        'terms_and_conditions',
    ];

    protected $casts = [
        'invoice_date'    => 'date',
        'due_date'        => 'date',
        'subtotal'        => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'tax_amount'      => 'decimal:2',
        'total_amount'    => 'decimal:2',
        'paid_amount'     => 'decimal:2',
        'remaining_amount' => 'decimal:2',
    ];

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }

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
        return $this->hasMany(InvoiceItem::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(CustomerPayment::class);
    }

    public function receivable(): HasOne
    {
        return $this->hasOne(Receivable::class);
    }

    // ─── Scopes ────────────────────────────────────────────────────────────────

    public function scopeUnpaid($query)
    {
        return $query->whereNotIn('status', ['paid', 'cancelled']);
    }

    public function scopeOverdue($query)
    {
        return $query->where('status', 'overdue')
                     ->orWhere(fn($q) => $q->whereNotIn('status', ['paid', 'cancelled'])
                         ->where('due_date', '<', now()->toDateString()));
    }

    // ─── Accessors ─────────────────────────────────────────────────────────────

    public function getIsOverdueAttribute(): bool
    {
        return !in_array($this->status, ['paid', 'cancelled'])
            && $this->due_date->isPast();
    }

    public function getDaysOverdueAttribute(): int
    {
        if (!$this->is_overdue) return 0;
        return $this->due_date->diffInDays(now());
    }

    public function getPaymentPercentageAttribute(): float
    {
        if ($this->total_amount == 0) return 0;
        return ($this->paid_amount / $this->total_amount) * 100;
    }

    // ─── Status Helpers ────────────────────────────────────────────────────────

    public function isPaid(): bool        { return $this->status === 'paid'; }
    public function isPartialPaid(): bool { return $this->status === 'partial_paid'; }
    public function isIssued(): bool      { return $this->status === 'issued'; }
}
