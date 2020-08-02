<?php

namespace App\Models;

use Spatie\Permission\Traits\HasRoles;

use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasRoles,
        MustVerifyEmail,
        Notifiable;

    /**
     * The attributes that are guarded.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'up_yeah_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Retrieve the up yeah API token.
     */
    public function getToken(): string
    {
        return decrypt($this->up_yeah_token);
    }

    /**
     * Get all of the up accounts associated to the user.
     */
    public function accounts(): HasMany
    {
        return $this->HasMany(Account::class);
    }

    /**
     * Get all of the transactions associated with the user.
     */
    public function transactions(): HasManyThrough
    {
        return $this->hasManyThrough(Transaction::class, Account::class);
    }
}
