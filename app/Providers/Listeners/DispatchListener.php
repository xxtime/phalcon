<?php
/**
 * Class DispatchListener
 * @package App\Providers\Listeners
 * @link https://docs.phalconphp.com/3.4/zh-cn/events#list
 * @link https://docs.phalconphp.com/3.4/zh-cn/dispatcher#dispatch-loop-events
 *
 * public function beforeDispatchLoop()
 * public function beforeDispatch()
 * public function beforeExecuteRoute()
 * public function afterInitialize()
 * public function afterExecuteRoute()
 * public function afterDispatch()
 * public function afterDispatchLoop()
 * public function beforeException()
 * public function beforeForward()
 * public function beforeNotFoundAction()
 *
 * Not Found In docs /3.4/zh-cn/dispatcher#dispatch-loop-events
 * afterInitialize beforeForward
 */

namespace App\Providers\Listeners;


use Phalcon\Mvc\User\Plugin;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;

class DispatchListener extends Plugin
{

    // public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher) {}

}
