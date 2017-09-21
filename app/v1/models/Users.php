<?php

namespace MyApp\V1\Models;


use Phalcon\Mvc\Model;
use Phalcon\DI;
use Phalcon\Db;

class Users extends Model
{

    public function initialize()
    {
        $this->setConnectionService('data');
        $this->setSource("accounts");
    }

}