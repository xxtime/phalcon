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

namespace App\Http\Middleware;

use App\System\Middleware;
use Phalcon\Http\RequestInterface;

/**
 * Class Authenticate
 * @package App\Http\Middleware
 * @property \Phalcon\Mvc\RouterInterface $router
 * @property \Phalcon\Http\ResponseInterface $response
 */
class Authenticate extends Middleware
{

    private $except = [
    ];

    /**
     * If not return true this will throw a MiddlewareException
     * @param RequestInterface $request
     * @return bool
     */
    public function handle(RequestInterface $request)
    {
        $this->router   = $this->di->get('router');
        $controllerName = $this->router->getControllerName();
        if (in_array($controllerName, $this->except)) {
            return true;
        }

        // do something check authenticate
        return true;
    }

}
