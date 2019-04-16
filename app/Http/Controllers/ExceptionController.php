<?php
/**
 * High performance, PHP framework
 *    ___    __          __
 *   / _ \  / /  ___ _  / / ____ ___   ___
 *  / ___/ / _ \/ _ `/ / / / __// _ \ / _ \
 * /_/    /_//_/\_,_/ /_/  \__/ \___//_//_/
 *
 * @link https://www.xxtime.com
 * @link https://github.com/xxtime/phalcon
 */

namespace App\Http\Controllers;

use Phalcon\Mvc\Controller as BaseController;

class ExceptionController extends BaseController
{

    public function statusNotFoundAction()
    {
        $this->response->setStatusCode(404, 'Not Found');
        $this->view->pick("default/statusNotFound");
    }

}
