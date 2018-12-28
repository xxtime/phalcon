<?php


namespace App\Http\Controllers;


use Phalcon\Mvc\Controller as BaseController;

/**
 * @property \App\Providers\System\Locale $locale
 */
class ExceptionController extends BaseController
{

    public function statusNotFoundAction()
    {
        $this->response->setStatusCode(404, 'Not Found');
        $this->view->pick("exception/StatusNotFound");
    }

}
