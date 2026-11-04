<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id',
        'tpv_session_id',
        'shipping_address_id',
        'order_number',
        'type',
        'status',
        'payment_method',
        'payment_status',
        'subtotal',
        'shipping_cost',
        'total',
        'notes',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function tpvSession(): BelongsTo
    {
        return $this->belongsTo(TpvSession::class);
    }
    public function shippingAddress(): BelongsTo
    {
        return $this->belongsTo(Address::class, 'shipping_address_id');
    }
    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }
}