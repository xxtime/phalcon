<?php


namespace MyApp\V1\Controllers;


use Phalcon\Mvc\Controller;

class PublicController extends Controller
{

    public function show401Action()
    {
        return $this->response->setJsonContent(['code' => 1, 'msg' => _('no permission')])->send();
    }


    public function notFoundAction()
    {
        $this->view->pick("public/notFound");
    }

}