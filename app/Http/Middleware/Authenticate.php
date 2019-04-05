<?php

namespace App\Http\Middleware;

use App\System\Middleware;
use Phalcon\Http\RequestInterface;

class Authenticate extends Middleware
{

    public $except = [
    ];

    public function handle(RequestInterface $request)
    {
    }

}
