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

class ExceptionController extends BaseController
{

    public function statusNotFoundAction()
    {
        $this->response->setStatusCode(404, 'Not Found');
        $this->view->pick("default/statusNotFound");
    }

}
