<?php

/**
 * @name    routes .php
 * @author  joe@xxtime.com
 * @link    https://docs.phalconphp.com/zh/3.2/routing
 */
use Phalcon\Mvc\Router;


$router = new Router(false);
$router->removeExtraSlashes(true);

// Not Found
$router->notFound([
    'controller' => 'public',
    'action'     => 'notFound',
]);

// 通用路由
$router->add(
    '/:controller/:action/:params',
    [
        'controller' => 1,
        'action'     => 2,
        'params'     => 3
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
        'params'     => 4,
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
