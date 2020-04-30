<?php
/**
 * Class DbListener
 * @package App\Providers\Listeners
 * @link https://docs.phalconphp.com/3.4/zh-cn/events#list
 *
 * public function boot(Event $event, $db)
 */

namespace App\Providers\Listeners;

use App\Http\Exceptions\ErrorException;
use Phalcon\Events\Event;
use Phalcon\Db\Adapter\Pdo;
use Phalcon\DI;

class DbListener extends \Phalcon\Di\Injectable
{

    public function beforeQuery(Event $event, Pdo $pdo)
    {
        $di = DI::getDefault();
        if (preg_match('/drop|alter/i', $pdo->getSQLStatement())) {
            $di->get('logger')->warn('DISABLE: ' . $pdo->getSQLStatement());
            throw new ErrorException("Disable SQL Statement");
        }
        if ($di['config']->path("app.debug")) {
            $di->get('logger')->debug($pdo->getSQLStatement());
        }
    }

}
