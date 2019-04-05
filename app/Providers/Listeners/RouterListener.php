<?php
/**
 * @link https://docs.phalconphp.com/3.4/zh-cn/routing
 *
 * public function beforeCheckRoutes()
 * public function beforeCheckRoute()
 * public function matchedRoute()
 * public function notMatchedRoute()
 * public function afterCheckRoutes()
 * public function beforeMount()
 */

namespace App\Providers\Listeners;

use Phalcon\Mvc\User\Plugin;
use Phalcon\Events\Event;
use Phalcon\Mvc\Router;

class RouterListener extends Plugin
{

    // public function afterCheckRoutes(Event $event, Router $router) {}

}
