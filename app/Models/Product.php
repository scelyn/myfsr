<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nama_barang',
        'satuan',
        'harga_beli_default',
        'margin_default',
    ];

    protected $casts = [
        'harga_beli_default' => 'float',
        'margin_default' => 'float',
    ];

    /** Smart Profit Calculation */
    public function getEstimasiKeuntunganAttribute(): float
    {
        return $this->margin_default;
    }

    /** Relationships */
    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}
