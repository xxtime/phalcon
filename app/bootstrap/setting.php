<?php


use Phalcon\Logger;


loadEnv(ROOT_DIR . '/.env');

ini_set("date.timezone", $di['config']->app->timezone);

switch ($di['config']->app->env != 'production') {
    case true:
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
        error_reporting(E_ALL);
        break;
    default:
        header_remove('X-Powered-By');
        error_reporting(0);
};

if ($di['config']->app->debug) {
    $separator = strpos($_SERVER['REQUEST_URI'], '?') ? '&' : '?';
    $log = $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'];
    $log .= file_get_contents("php://input") ? $separator . file_get_contents("php://input") : '';
    $di->get('logger', [date('Ym')])->log($log, Logger::INFO);
}

if (count($di['config']->path('providers.listeners')) > 0) {
    foreach ($di['config']->path('providers.listeners') as $name => $listener) {
        $di['eventsManager']->attach($name, new $listener);
    }
}
