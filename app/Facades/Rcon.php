<?php

namespace App\Facades;

use Illuminate\Support\Facades\Facade as BaseFacade;

class Rcon extends BaseFacade
{
    /**
     * Return Laravel Framework facade accessor name.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'Rcon';
    }
}
