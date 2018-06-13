<?php

/**
 * Class DispatchListener
 * @package App\Providers\Listeners
 * @link https://docs.phalconphp.com/zh/3.3/events#list
 * @link https://docs.phalconphp.com/zh/3.3/dispatcher#dispatch-loop-events
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
 */

namespace App\Providers\Listeners;


use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher;

class DispatchListener
{

    // public function beforeExecuteRoute(Event $event, Dispatcher $dispatcher) {}

}
