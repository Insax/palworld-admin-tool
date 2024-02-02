<?php

namespace App\PalWorld\RCON\Facades;

use Illuminate\Support\Facades\Facade as BaseFacade;

final class Facade extends BaseFacade
{
    /**
     * Return Laravel Framework facade accessor name.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'RCON';
    }
}
