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

if (!function_exists('env')) {
    function env($key, $default = null)
    {
        $value = getenv($key);
        if ($value === false) {
            return $default;
        }
        switch (strtolower($value)) {
            case 'true':
            case '(true)':
                return true;
            case 'false':
            case '(false)':
                return false;
            case 'empty':
            case '(empty)':
                return '';
            case 'null':
            case '(null)':
                return;
        }
        if (($valueLength = strlen($value)) > 1 && $value[0] === '"' && $value[$valueLength - 1] === '"') {
            return substr($value, 1, -1);
        }
        return $value;
    }
}

if (!function_exists('loadEnv')) {
    function loadEnv($path = "")
    {
        $autodetect = ini_get('auto_detect_line_endings');
        ini_set('auto_detect_line_endings', '1');
        $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        ini_set('auto_detect_line_endings', $autodetect);
        foreach ($lines as $line) {
            list($name, $value) = explode('=', $line);
            putenv("{$name}={$value}");
        }
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
