<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SupplierPayment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'payment_number',
        'supplier_recap_id',
        'supplier_id',
        'created_by',
        'payment_date',
        'amount',
        'payment_method',
        'reference_number',
        'bank_name',
        'notes',
        'recap_balance_before',
        'recap_balance_after',
    ];

    protected $casts = [
        'payment_date'         => 'date',
        'amount'               => 'decimal:2',
        'recap_balance_before' => 'decimal:2',
        'recap_balance_after'  => 'decimal:2',
    ];

    // ─── Relationships ─────────────────────────────────────────────────────────

    public function supplierRecap(): BelongsTo
    {
        return $this->belongsTo(SupplierRecap::class);
    }

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
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
            'cheque'        => 'Cek / Giro',
            default         => 'Lainnya',
        };
    }
}
