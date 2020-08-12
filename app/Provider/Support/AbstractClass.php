<?php

namespace App\Provider\Support;

use Phalcon\Di;

abstract class AbstractClass
{

    protected $di;

    public function __construct(Di $di)
    {
        $this->di = $di;
    }

}
