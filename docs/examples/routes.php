<?php

/**
 * @name    /ROOT/app/routes.php
 * @see     /ROOT/docs/examples/routes.php
 * @link    https://docs.phalconphp.com/zh/3.3/routing
 *
 * Add RESTFUL Resource
 * $resource = new Providers\System\Route($router);
 * $resource->addResource('/products', 'V1\Products');
 * $resource->addResource('/news', 'V1\News', '{id:[0-9]{1,10}}')->only('show');
 */

use Phalcon\Mvc\Router;
use App\Providers;


$router = new Router(false);
$router->removeExtraSlashes(true);

$router->notFound(['controller' => 'exception', 'action' => 'statusNotFound']);
$router->add('/', ['controller' => 'default', 'action' => 'index']);

$router->add('/:controller', ['controller' => 1]);
$router->add('/:controller/:action/:params', ['controller' => 1, 'action' => 2, 'params' => 3]);

$router->add('/(v[0-9]+)/:controller/:action/:params', ['module' => 1, 'controller' => 2, 'action' => 3, 'params' => 4]);
$router->add('/(v[0-9]+)/:controller', ['module' => 1, 'controller' => 2]);

$router->setDefaultModule('http');
$router->setDefaultNamespace('App\Http\Controllers');
$router->setDefaultController('index');
$router->setDefaultAction('index');

return $router;
