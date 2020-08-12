<?php

namespace App\Provider\Service;

use Phalcon\Di;

abstract class AbstractClass
{

    protected $di;

    public function __construct(Di $di)
    {
        $this->di = $di;
    }

}
