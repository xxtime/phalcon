<?php

return [

    /*
    |--------------------------------------------------------------------------
    | App Name
    |--------------------------------------------------------------------------
    |
    | Default is XT
    |
    */
    'name'      => env('APP_NAME', 'Phalcon'),

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
    'env'       => env('APP_ENV', 'production'),

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
    'debug'     => env('APP_DEBUG', false),

    /*
    |--------------------------------------------------------------------------
    | Timezone
    |--------------------------------------------------------------------------
    |
    | Default 'UTC'. EXP: 'PRC', 'Asia/Shanghai'
    |
    */
    'timezone'  => env('APP_TIMEZONE', 'UTC'),

    /*
    |--------------------------------------------------------------------------
    | Language
    |--------------------------------------------------------------------------
    |
    | Default 'en_US'
    |
    */
    'lang'      => env('APP_LANG', 'en_US'),

    /*
    |--------------------------------------------------------------------------
    | URL
    |--------------------------------------------------------------------------
    |
    | http://localhost
    |
    */
    'url'       => env('APP_URL'),

    /*
    |--------------------------------------------------------------------------
    | App Key
    |--------------------------------------------------------------------------
    |
    */
    'key'       => env('APP_KEY'),

    /*
    |--------------------------------------------------------------------------
    | App Cipher
    |--------------------------------------------------------------------------
    |
    | Default 'AES-256-CFB'
    |
    */
    'cipher'    => env('APP_CIPHER', 'AES-256-CFB'),

    /*
    |--------------------------------------------------------------------------
    | System Providers
    |--------------------------------------------------------------------------
    |
    | Providers list
    |
    */
    'providers' => [
    ],

    /*
    |--------------------------------------------------------------------------
    | Events Listeners
    |--------------------------------------------------------------------------
    |
    | Events Listener
    |
    */
    'listeners' => [
        'dispatch'    => 'App\Providers\Listeners\DispatchListener',
        'application' => 'App\Providers\Listeners\ApplicationListener',
        'router'      => 'App\Providers\Listeners\RouterListener',
        'db'          => 'App\Providers\Listeners\DbListener',
    ],

    /*
    |--------------------------------------------------------------------------
    | Config Files
    |--------------------------------------------------------------------------
    |
    | Put files in config dir
    |
    */
    'config'    => [
        'session'  => CONFIG_DIR . 'session.php',
        'database' => CONFIG_DIR . 'database.php',
        'cache'    => CONFIG_DIR . 'cache.php',
    ]

];
