<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id',
        'product_id',
        'preparation_type_id',
        'product_name',
        'unit_price',
        'quantity',
        'subtotal',
    ];

    protected static function booted(): void
    {
        static::creating(function (OrderItem $item) {
            $item->subtotal = round($item->quantity * $item->unit_price, 2);
        });

        static::updating(function (OrderItem $item) {
            $item->subtotal = round($item->quantity * $item->unit_price, 2);
        });
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function preparationType(): BelongsTo
    {
        return $this->belongsTo(PreparationType::class);
    }
}