<?php

namespace MyApp\Services\Pay;

use Phalcon\Mvc\Controller;

class Paypal extends Controller
{

    public function notice()
    {
        return time();
    }

}
