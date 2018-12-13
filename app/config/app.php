<?php

return [

    // App Name
    'name'     => env('APP_NAME', 'XT'),

    // dev production
    'env'      => env('APP_ENV', 'production'),

    // true | false
    'debug'    => env('APP_DEBUG', false),

    // timezone, default UTC
    "timezone" => env("APP_TIMEZONE", "UTC"),

    // locale
    'locale'   => 'en',

    // url address
    'url'      => env('APP_URL'),

    // key
    'key'      => env('APP_KEY'),

    // cipher
    'cipher'   => 'AES-256-CFB',

    // include
    'include'  => [
        "session",
        "database",
        "providers"
    ]

];
