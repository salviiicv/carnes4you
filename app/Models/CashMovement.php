<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CashMovement extends Model
{
    use HasFactory;

    protected $fillable = [
        'tpv_session_id',
        'user_id',
        'type',
        'amount',
        'description',
    ];

    public function tpvSession(): BelongsTo
    {
        return $this->belongsTo(TpvSession::class);
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}