<?php

/**
 * @name    /ROOT/app/config/routes.php
 * @see     /ROOT/docs/examples/routes.php
 * @link    https://docs.phalconphp.com/zh/3.3/routing
 */

use Phalcon\Mvc\Router;


$router = new Router(false);
$router->removeExtraSlashes(true);

$router->notFound(['controller' => 'default', 'action' => 'notFound']);
$router->add('/', ['controller' => 'default', 'action' => 'index']);

$router->setDefaultModule('m1');
$router->setDefaultNamespace('App\Http\Controllers');
$router->setDefaultController('index');
$router->setDefaultAction('index');

return $router;
