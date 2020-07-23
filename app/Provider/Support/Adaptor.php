<?php

namespace App\Provider\Support;

/**
 * Class Adaptor
 * @package App\Provider\Support
 * @property \App\Provider\Support\HelpClass $help
 */
class Adaptor
{

    private $register;

    private $processId;

    public $di;

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
        $class                 = "\\App\\Provider\\Support\\{$name}Class";
        $this->register[$name] = new $class($this);
        return $this->register[$name];
    }

    public function getProcessId()
    {
        if ($this->processId != null) {
            return $this->processId;
        }
        return $this->processId = $this->help->randString(32);
    }

}
