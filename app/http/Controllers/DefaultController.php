<?php


namespace App\Http\Controllers;


class DefaultController extends Controller
{

    public function indexAction()
    {
        $this->view->pick("default/index");
    }

}
