<?php

/**
 * Class DbListener
 * @package App\Providers\Listeners
 * @link https://docs.phalconphp.com/zh/3.3/events#list
 *
 * public function boot(Event $event, $db)
 */

namespace App\Providers\Listeners;


use Phalcon\Events\Event;
use Phalcon\Db\Adapter\Pdo;
use Phalcon\DI;

class DbListener
{

    public function beforeQuery(Event $event, Pdo $pdo)
    {
        $di = DI::getDefault();
        if ($di['config']['env']['logs']) {
            $di->get('logger', ['sql-' . date('Ymd') . '.log'])->log($pdo->getSQLStatement());
        }
        if (preg_match('/drop|alter/i', $pdo->getSQLStatement())) {
            $di->get('logger', ['sql-' . date('Ymd') . '.log'])->log('disable: ' . $pdo->getSQLStatement());
            // return false;
            $di['response']->redirect('error');
            $di['response']->send();
            exit();
        }
    }

}
