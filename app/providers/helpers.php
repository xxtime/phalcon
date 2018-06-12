<?php

if (!function_exists('dd')) {
    function dd(...$args)
    {
        foreach ($args as $x) {
            dump($x);
        }
        die(1);
    }
}


function config($string)
{
    $parts = explode('.', $string);
    $file = array_shift($parts);
    if ($GLOBALS['di']['config'][$file] instanceof Closure) {
        $result = $GLOBALS['di']['config'][$file]();
    }
    else {
        $result = $GLOBALS['di']['config'][$file];
    }
    foreach ($parts as $v) {
        $result = $result[$v];
    }
    return $result;
}
