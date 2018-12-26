<?php


namespace App\Http\Controllers;


use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

/**
 * @property \App\Providers\Components\Locale $locale
 */
class ControllerBase extends Controller
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
