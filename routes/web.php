<?php
/**
 * High performance, PHP framework
 *    ___    __          __
 *   / _ \  / /  ___ _  / / ____ ___   ___
 *  / ___/ / _ \/ _ `/ / / / __// _ \ / _ \
 * /_/    /_//_/\_,_/ /_/  \__/ \___//_//_/
 *
 * @link https://www.xxtime.com
 * @link https://github.com/xxtime/phalcon
 */

/**
 * Add RESTFUL Resource
 * $resource = new \App\System\Route($router);
 * $resource->addResource('/products', 'V1\Products');
 * $resource->addResource('/news', 'V1\News', '{id:[0-9]{1,10}}')->only('show');
 * @docs https://docs.phalconphp.com/zh/3.3/routing
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
