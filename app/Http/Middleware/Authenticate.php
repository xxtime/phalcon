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
