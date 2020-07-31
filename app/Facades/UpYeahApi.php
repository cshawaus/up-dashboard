<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static self setToken(string $token)
 * @method static mixed accounts()
 * @method static mixed ping()
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
