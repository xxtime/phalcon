<?php
/**
 * Class DbListener
 * @package App\Providers\Listeners
 * @link https://docs.phalconphp.com/3.4/zh-cn/events#list
 *
 * public function boot(Event $event, $db)
 */

namespace App\Providers\Listeners;

use Phalcon\Mvc\User\Plugin;
use Phalcon\Events\Event;
use Phalcon\Db\Adapter\Pdo;
use Phalcon\DI;

class DbListener extends Plugin
{

    public function beforeQuery(Event $event, Pdo $pdo)
    {
        $di = DI::getDefault();
        if (preg_match('/drop|alter/i', $pdo->getSQLStatement())) {
            $di->get('logger', ['sql' . date('Ymd')])->error('DISABLE: ' . $pdo->getSQLStatement());
            // return false;
            $di['response']->redirect('error');
            $di['response']->send();
            exit(0);
        }
        if ($di['config']->path("app.debug")) {
            $di->get('logger', ['sql' . date('Ymd')])->log($pdo->getSQLStatement());
        }
    }

}
