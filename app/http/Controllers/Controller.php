<?php


namespace App\Http\Controllers;


use Phalcon\Mvc\Controller as BaseController;
use Phalcon\Mvc\Dispatcher;

/**
 * Class Controller
 * @package App\Http\Controllers
 * @property \Phalcon\Config $config
 * @property \Redis $redis
 * @property \MongoDB\Client $mongodb
 * @property \App\Providers\System\Lang $lang
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
