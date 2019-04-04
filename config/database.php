<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Database config files
    |--------------------------------------------------------------------------
    |
    */
    'mysql' => [
        'host'    => env("DB_HOST", "127.0.0.1"),
        'port'    => env("DB_PORT", 3306),
        'user'    => env("DB_USERNAME"),
        'pass'    => env("DB_PASSWORD"),
        'db'      => env("DB_DATABASE"),
        'charset' => env("DB_CHARSET", 'utf8mb4')
    ],

    'redis' => [
        'host' => env("REDIS_HOST", "127.0.0.1"),
        'port' => env("REDIS_PORT", 6379),
        'pass' => env("REDIS_PASSWORD"),
        'db'   => env("REDIS_DATABASE", 0)
    ],

    'mongodb' => [
        'host' => env("MONGO_HOST", "127.0.0.1"),
        'port' => env("MONGO_PORT", 27017),
        'user' => env("MONGO_USERNAME"),
        'pass' => env("MONGO_PASSWORD"),
        'db'   => env("MONGO_DATABASE")
    ],

];
