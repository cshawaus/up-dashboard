<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Transaction extends Model
{
    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'cashback'  => 'array',
        'hold_info' => 'array',
        'round_up'  => 'array',
    ];

    /**
     * Account that this transaction is associated with.
     */
    public function account(): BelongsTo
    {
        return $this->belongsTo(Account::class);
    }
}
