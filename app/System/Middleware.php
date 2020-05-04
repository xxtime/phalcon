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
