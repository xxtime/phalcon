<?php

namespace App\Http;

class Mapping
{

    /**
     * 全局中间件
     * @var array
     */
    public $middleware = [
        //\App\Http\Middleware\Authenticate::class,
        //\App\Http\Middleware\FilterParameter::class,
        //\App\Http\Middleware\CsrfToken::class,
    ];

    /**
     * 路由中间件组
     * @var array
     */
    public $middlewareGroups = [
    ];

    /**
     * 路由中间件组
     * @var array
     */
    public $routeMiddleware = [
    ];

}
