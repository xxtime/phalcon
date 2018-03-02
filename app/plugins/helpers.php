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
