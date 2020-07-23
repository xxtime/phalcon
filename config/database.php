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
        'user'    => env("DB_USER"),
        'pass'    => env("DB_PASS"),
        'dbname'  => env("DB_NAME"),
        'charset' => env("DB_CHAR", 'utf8mb4')
    ],

    'redis' => [
        'host'   => env("REDIS_HOST", "127.0.0.1"),
        'port'   => env("REDIS_PORT", 6379),
        'pass'   => env("REDIS_PASS"),
        'dbname' => env("REDIS_NAME", 0)
    ],

    'mongodb' => [
        'host'   => env("MONGO_HOST", "127.0.0.1"),
        'port'   => env("MONGO_PORT", 27017),
        'user'   => env("MONGO_USER"),
        'pass'   => env("MONGO_PASS"),
        'dbname' => env("MONGO_NAME")
    ],

];
