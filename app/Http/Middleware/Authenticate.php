<?php

namespace App\Http\Middleware;


use Phalcon\Http\RequestInterface;

class Authenticate
{

    public $except = [
    ];

    public function handle(RequestInterface $request)
    {
    }

}
