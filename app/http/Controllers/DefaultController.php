<?php


namespace App\Http\Controllers;


use Phalcon\Mvc\Controller;

/**
 * @property \App\Providers\Components\Locale $locale
 */
class DefaultController extends Controller
{

    public function indexAction()
    {
        $this->view->pick("default/index");
    }

}
