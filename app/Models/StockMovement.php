<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StockMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'movement_type',
        'quantity',
        'reason',
    ];

    protected static function booted(): void
    {
        static::created(function (StockMovement $movement) {
            $product = $movement->product;

            if ($movement->movement_type === 'in') {
                $product->stock += $movement->quantity;
            } elseif ($movement->movement_type === 'out') {
                $product->stock -= $movement->quantity;
            }

            $product->save();
        });
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}