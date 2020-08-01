<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static self setToken(string $token)
 * @method static mixed ping()
 * @method static mixed accounts()
 * @method static mixed account(string $uuid)
 * @method static mixed transactions()
 * @method static mixed transactionsById(string $uuid)
 * @method static mixed transactionsByAccount(string $uuid)
 *
 * @see \App\Services\UpYeahApi
 */
class UpYeahApi extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'up.yeah.api';
    }
}
