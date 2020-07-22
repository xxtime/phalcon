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

/**
 * Add RESTFUL Resource
 * $resource = new \App\System\Route($router);
 * $resource->addResource('/products', 'V1\Products');
 * $resource->addResource('/news', 'V1\News', '{id:[0-9]{1,10}}')->only('get');
 * @docs https://docs.phalconphp.com/zh/3.3/routing
 */

use Phalcon\Mvc\Router;

$router = new Router(false);
$router->removeExtraSlashes(true);

$router->notFound(['controller' => 'exception', 'action' => 'statusNotFound']);
$router->add('/', ['controller' => 'index', 'action' => 'index']);

$router->setDefaultNamespace('App\Http\Controller');
$router->setDefaultController('index');
$router->setDefaultAction('index');

return $router;
