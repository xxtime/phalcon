<?php

return [

    /*
    |--------------------------------------------------------------------------
    | App Name
    |--------------------------------------------------------------------------
    |
    | Default is zLab
    |
    */
    'name'      => env('APP_NAME', 'zLab'),

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
    'env'       => env('APP_ENV', 'prod'),

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
        'dispatch'    => 'App\Provider\Listen\DispatchListener',
        'application' => 'App\Provider\Listen\ApplicationListener',
        'router'      => 'App\Provider\Listen\RouterListener',
        'db'          => 'App\Provider\Listen\DbListener',
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
