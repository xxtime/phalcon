<?php
namespace MyApp\Services;

abstract class Services
{

    public static function pay($name)
    {
        $name = ucfirst($name);
        $className = "\\MyApp\\Services\\Pay\\{$name}";
        return new $className();
    }

    public static function app($name)
    {
        $name = ucfirst($name);
        $className = "\\MyApp\\Services\\App\\{$name}";
        return new $className();
    }

}
