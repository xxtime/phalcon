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
