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

namespace App\System;

/**
 * Class Middleware
 * @package App\System
 * @property \Phalcon\DI\FactoryDefault $di
 */
class Middleware
{

    protected $di;

    public function __construct($di)
    {
        $this->di = $di;
    }

}
