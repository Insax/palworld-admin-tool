<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default RCON Connection Name
    |--------------------------------------------------------------------------
    |
    | Here you may specify which of the RCON connections below you wish
    | to use as your default connection for all RCON work.
    |
    */

    'default' => 'default',

    /*
    |--------------------------------------------------------------------------
    | RCON Connections
    |--------------------------------------------------------------------------
    |
    | Here are each of the RCON connections setup for your application.
    |
    */

    'connections' => [
        'default' => [
            'host' => 'someHost',
            'port' => 123,
            'password' => 'SuperSafePassword',
            'timeout' => 60
        ],
        'default2' => [
            'host' => 'someHost',
            'port' => 123,
            'password' => 'SuperSafePassword',
            'timeout' => 60
        ],
    ]

];
