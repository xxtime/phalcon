<?php

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
