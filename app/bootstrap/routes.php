<?php

/**
 * @name    routes .php
 * @author  joe@xxtime.com
 * @link    https://docs.phalconphp.com/zh/3.2/routing
 *
 * Not Found
 * $router->notFound([
 *     'controller' => 'public',
 *     'action'     => 'show404',
 * ]);
 *
 */
use Phalcon\Mvc\Router;


$router = new Router(false);
$router->removeExtraSlashes(true);


// 通用路由
$router->add(
    '/:controller/:action/:params',
    [
        'controller' => 1,
        'action'     => 2,
        'argv'       => 3
    ]
);

$router->add(
    '/:controller',
    [
        'controller' => 1
    ]
);


// 多模块
$router->add(
    '/(v[0-9]+)/:controller/:action/:params',
    [
        'module'     => 1,
        'controller' => 2,
        'action'     => 3,
        'argv'       => 4,
    ]
);

$router->add(
    '/(v[0-9]+)/:controller',
    [
        'module'     => 1,
        'controller' => 2,
    ]
);


$router->setDefaultModule('v1');


return $router;