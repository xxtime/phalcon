<?php
/**
 * @link https://docs.phalconphp.com/3.4/zh-cn/routing
 *
 * 备注:
 * 作用在每条路由配置   beforeCheckRoute matchedRoute notMatchedRoute
 * 作用在整个路由组前后 beforeCheckRoutes afterCheckRoutes
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
use App\Http\Mapping;

class RouterListener extends Plugin
{

    public function afterCheckRoutes(Event $event, Router $router)
    {

        // 全局中间件
        $mapping = new Mapping();
        foreach ($mapping->middleware as $value) {
            $class = new $value($this->getDI());
            if ($class->handle($this->request) !== true) {
                exit(0);
            }
        }

    }

}
