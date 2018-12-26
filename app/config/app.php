<?php

return [
    "app" => [

        /*
        |--------------------------------------------------------------------------
        | App Name
        |--------------------------------------------------------------------------
        |
        | Default is XT
        |
        */
        'name'     => env('APP_NAME', 'XT'),

        /*
        |--------------------------------------------------------------------------
        | Application Environment
        |--------------------------------------------------------------------------
        |
        | This value determines the "environment" your application is currently
        | running in. This may determine how you prefer to configure various
        | services your application utilizes. Set this in your ".env" file.
        |
        */
        'env'      => env('APP_ENV', 'production'),

        /*
        |--------------------------------------------------------------------------
        | Application Debug Mode
        |--------------------------------------------------------------------------
        |
        | When your application is in debug mode, detailed error messages with
        | stack traces will be shown on every error that occurs within your
        | application. If disabled, a simple generic error page is shown.
        |
        */
        'debug'    => env('APP_DEBUG', false),

        /*
        |--------------------------------------------------------------------------
        | Timezone
        |--------------------------------------------------------------------------
        |
        | Default 'UTC'. EXP: 'PRC', 'Asia/Shanghai'
        |
        */
        "timezone" => env("APP_TIMEZONE", "UTC"),

        /*
        |--------------------------------------------------------------------------
        | Language
        |--------------------------------------------------------------------------
        |
        | Default 'en'
        |
        */
        'locale'   => 'en',

        /*
        |--------------------------------------------------------------------------
        | URL
        |--------------------------------------------------------------------------
        |
        | http://localhost
        |
        */
        'url'      => env('APP_URL'),

        /*
        |--------------------------------------------------------------------------
        | App Key
        |--------------------------------------------------------------------------
        |
        */
        'key'      => env('APP_KEY'),

        /*
        |--------------------------------------------------------------------------
        | App Key
        |--------------------------------------------------------------------------
        |
        | Default 'AES-256-CFB'
        |
        */
        'cipher'   => 'AES-256-CFB',

        /*
        |--------------------------------------------------------------------------
        | Include files
        |--------------------------------------------------------------------------
        |
        | Put files in config dir
        |
        */
        'include'  => [
            "session",
            "database",
            "providers"
        ]

    ]
];
