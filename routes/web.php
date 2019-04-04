<?php

/**
 * @name    /ROOT/routes/web.php
 * @see     /ROOT/docs/examples/routes.php
 * @link    https://docs.phalconphp.com/zh/3.3/routing
 *
 * Add RESTFUL Resource
 * $resource = new \App\System\Route($router);
 * $resource->addResource('/products', 'V1\Products');
 * $resource->addResource('/news', 'V1\News', '{id:[0-9]{1,10}}')->only('show');
 */

use Phalcon\Mvc\Router;


$router = new Router(false);
$router->removeExtraSlashes(true);

$router->notFound(['controller' => 'exception', 'action' => 'statusNotFound']);
$router->add('/', ['controller' => 'default', 'action' => 'index']);

$router->setDefaultNamespace('App\Http\Controllers');
$router->setDefaultController('index');
$router->setDefaultAction('index');

return $router;
