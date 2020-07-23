<?php
/**
 * Powered by ZLab
 *  ____ _           _             _
 * |_  /| |    __ _ | |__       __| | ___ __ __
 *  / / | |__ / _` || '_ \  _  / _` |/ -_)\ V /
 * /___||____|\__,_||_.__/ (_) \__,_|\___| \_/
 *
 * @link https://zlab.dev
 * @link https://github.com/xxtime/phalcon
 */

namespace App\Http\Controller;

use Phalcon\Mvc\Controller as BaseController;
use Phalcon\Mvc\Dispatcher;

/**
 * Class Controller
 * @package App\Http\Controller
 * @property \Phalcon\Config $config
 * @property \Redis $cache
 * @property \Redis $redis
 * @property \MongoDB\Client $mongodb
 * @property \App\System\Language $lang
 * @property \App\Provider\Support\Adaptor $support
 * @property \Laminas\Log\Logger $logger
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
