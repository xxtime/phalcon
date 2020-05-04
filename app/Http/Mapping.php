<?php
/**
 * Powered by ZLab
 *  ____ _           _             _
 * |_  /| |    __ _ | |__       __| | ___ __ __
 *  / / | |__ / _` || '_ \  _  / _` |/ -_)\ V /
 * /___||____|\__,_||_.__/ (_) \__,_|\___| \_/
 *
 * @link https://zlab.dev
 * @link https://github.com/xxtime/phalcon
 */

namespace App\Http;

class Mapping
{

    /**
     * 全局中间件
     * @var array
     */
    public $middleware = [
        \App\Http\Middleware\Authenticate::class,
        \App\Http\Middleware\FilterParameter::class,
        \App\Http\Middleware\CsrfToken::class,
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
