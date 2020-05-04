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

namespace App\Http\Controllers;

use Phalcon\Version;

class IndexController extends Controller
{

    public function indexAction()
    {
        $this->view->setVars([
            "pha_version" => Version::get(),
            "php_version" => phpversion(),
        ]);
        $this->view->pick("default/default");
    }

}
