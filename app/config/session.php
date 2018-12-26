<?php

return [
    "session" => [

        /*
        |--------------------------------------------------------------------------
        | Default Session Driver
        |--------------------------------------------------------------------------
        |
        | Supported: "file", "redis"
        |
        */

        'driver' => env('SESSION_DRIVER', 'file'),

        /*
        |--------------------------------------------------------------------------
        | Session Lifetime
        |--------------------------------------------------------------------------
        |
        | Here you may specify the number of seconds that you wish the session
        | to be allowed to remain idle before it expires.
        |
        */

        'lifetime' => env('SESSION_LIFETIME', 7200),

        /*
        |--------------------------------------------------------------------------
        | Session File Location
        |--------------------------------------------------------------------------
        |
        | When using the native session driver, we need a location where session
        | files may be stored. A default has been set for you but a different
        | location may be specified. This is only needed for file sessions.
        |
        */

        'files' => ROOT_DIR . '/storage/sessions',

    ]
];
