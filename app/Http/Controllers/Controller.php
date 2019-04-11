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

namespace App\Http\Controllers;

use Phalcon\Mvc\Controller as BaseController;
use Phalcon\Mvc\Dispatcher;

/**
 * Class Controller
 * @package App\Http\Controllers
 * @property \Phalcon\Config $config
 * @property \Redis $cache
 * @property \Redis $redis
 * @property \MongoDB\Client $mongodb
 * @property \App\System\Lang $lang
 */
class Controller extends BaseController
{

    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
    }

    public function initialize()
    {
    }

    public function afterExecuteRoute(Dispatcher $dispatcher)
    {
    }

}
