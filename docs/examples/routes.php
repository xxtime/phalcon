<?php

/**
 * @name    /ROOT/app/config/routes.php
 * @link    https://docs.phalconphp.com/zh/3.3/routing
 */

use Phalcon\Mvc\Router;


$router = new Router(false);
$router->removeExtraSlashes(true);

$router->notFound(['controller' => 'exception', 'action' => 'statusNotFound']);
$router->add('/', ['controller' => 'default', 'action' => 'index']);

$router->add('/:controller', ['controller' => 1]);
$router->add('/:controller/:action/:params', ['controller' => 1, 'action' => 2, 'params' => 3]);

$router->add('/(v[0-9]+)/:controller/:action/:params', ['module' => 1, 'controller' => 2, 'action' => 3, 'params' => 4]);
$router->add('/(v[0-9]+)/:controller', ['module' => 1, 'controller' => 2]);

$router->setDefaultModule('v1');
$router->setDefaultNamespace('App\Http\Controllers');
$router->setDefaultController('index');
$router->setDefaultAction('index');

return $router;
