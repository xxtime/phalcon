<?php

/**
 * Class ApplicationListener
 * @package App\Providers\Listeners
 * @link https://docs.phalconphp.com/3.4/zh-cn/events#list
 *
 * public function boot(Event $event, Application $app)
 * public function beforeStartModule(Event $event, Application $app)
 * public function afterStartModule(Event $event, Application $app)
 * public function beforeHandleRequest(Event $event, Application $app)
 * public function afterHandleRequest(Event $event, Application $app)
 * public function viewRender(Event $event, Application $app)
 * public function beforeSendResponse(Event $event, Application $app)
 */

namespace App\Providers\Listeners;


use Phalcon\Mvc\User\Plugin;
use Phalcon\Events\Event;
use Phalcon\Mvc\Application;

class ApplicationListener extends Plugin
{


}
