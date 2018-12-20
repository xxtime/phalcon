<?php


namespace App\Http\Controllers;


use Phalcon\Mvc\Controller;

class ExceptionController extends Controller
{

    public function statusNotFoundAction()
    {
        $this->response->setStatusCode(404, 'Not Found');
        $this->view->pick("exception/StatusNotFound");
    }

}
