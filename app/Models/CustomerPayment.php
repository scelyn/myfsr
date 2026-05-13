<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'payment_number',
        'invoice_id',
        'customer_id',
        'created_by',
        'payment_date',
        'amount',
        'payment_method',
        'reference_number',
        'bank_name',
        'notes',
        'invoice_balance_before',
        'invoice_balance_after',
    ];

    protected $casts = [
        'payment_date'           => 'date',
        'amount'                 => 'decimal:2',
        'invoice_balance_before' => 'decimal:2',
        'invoice_balance_after'  => 'decimal:2',
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

    // ─── Accessors ─────────────────────────────────────────────────────────────

    public function getPaymentMethodLabelAttribute(): string
    {
        return match ($this->payment_method) {
            'cash'          => 'Tunai',
            'bank_transfer' => 'Transfer Bank',
            'qris'          => 'QRIS',
            'cheque'        => 'Cek / Giro',
            default         => 'Lainnya',
        };
    }
}
