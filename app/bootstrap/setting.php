<?php


use Phalcon\Logger;


ini_set("date.timezone", $di['config']->setting->timezone);


switch ($di['config']->setting->sandbox) {
    case true:
        include APP_DIR . '/plugins/' . 'Exception.php';
        error_reporting(E_ALL);
        break;
    default:
        header_remove('X-Powered-By');
        error_reporting(0);
};


if ($di['config']->setting->logs) {
    $separator = strpos($_SERVER['REQUEST_URI'], '?') ? '&' : '?';
    $log = $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'];
    $log .= file_get_contents("php://input") ? $separator . file_get_contents("php://input") : '';
    $di->get('logger', [date('Ym')])->log($log, Logger::INFO);
}