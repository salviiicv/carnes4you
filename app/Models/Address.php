<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Address extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'address_line',
        'country',
        'state',
        'province',
        'city',
        'zip',
        'street_number',
        'floor',
        'door',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'shipping_address_id');
    }
}