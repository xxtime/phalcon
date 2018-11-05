<?php


return [

    'middleware' => [
        'finish' => 'App\Providers\Middleware\FinishMiddleware'
    ],

    'listeners' => [
        'application' => 'App\Providers\Listeners\ApplicationListener',
        'db'          => 'App\Providers\Listeners\DbListener',
    ]

];
