<?php


namespace MyApp\V1\Controllers;


use Phalcon\Mvc\Controller;
use Phalcon\Mvc\Dispatcher;

class ControllerBase extends Controller
{

    public function beforeExecuteRoute(Dispatcher $dispatcher)
    {
        // $this->locale->setLocale('en_US');
    }


    public function initialize()
    {
    }


    public function afterExecuteRoute(Dispatcher $dispatcher)
    {
    }

}
