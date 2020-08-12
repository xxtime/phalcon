<?php

namespace App\Provider\Service;

use Phalcon\Di;

/**
 * Class Adaptor
 * @package App\Provider\Service
 * @property Di $di
 */
class Adaptor
{

    private $register;

    protected $di;

    public function __construct($di)
    {
        $this->di = $di;
    }

    public function __get($name)
    {
        $name = ucfirst($name);
        if (isset($this->register[$name])) {
            return $this->register[$name];
        }
        $class                 = "\\App\\Provider\\Service\\{$name}Class";
        $this->register[$name] = new $class($this->di);
        return $this->register[$name];
    }

}
