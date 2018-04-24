<?php


use Phalcon\Logger;


ini_set("date.timezone", $di['config']->env->timezone);


switch ($di['config']->env->sandbox) {
    case true:
        $whoops = new \Whoops\Run;
        $whoops->pushHandler($di['config']['env']['api'] ? new \Whoops\Handler\JsonResponseHandler : new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
        error_reporting(E_ALL);
        break;
    default:
        header_remove('X-Powered-By');
        error_reporting(0);
};


if ($di['config']->env->logs) {
    $separator = strpos($_SERVER['REQUEST_URI'], '?') ? '&' : '?';
    $log = $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'];
    $log .= file_get_contents("php://input") ? $separator . file_get_contents("php://input") : '';
    $di->get('logger', [date('Ym')])->log($log, Logger::INFO);
}


if (count($di['config']['providers']['listeners']) > 0) {
    foreach ($di['config']['providers']['listeners'] as $name => $listener) {
        $di['eventsManager']->attach($name, new $listener);
    }
}
