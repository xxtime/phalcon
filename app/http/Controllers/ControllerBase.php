<?php


namespace App\Http\Controllers;


use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

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
