<?php


use Phalcon\Logger;


loadEnv();

ini_set("date.timezone", $di['config']->app->timezone);

switch ($di['config']->app->env != 'production') {
    case true:
        $whoops = new \Whoops\Run;
        $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
        $whoops->register();
        error_reporting(E_ALL);
        break;
    default:
        error_reporting(0);
};

if ($di['config']->app->debug) {
    $logs = $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'] . ' ' . $_SERVER['SERVER_PROTOCOL'] . "\n";
    foreach (getallheaders() as $key => $value) {
        $logs .= $key . ': ' . $value . "\n";
    }
    $logs .= "\n" . file_get_contents("php://input");
    $di->get('logger', [date('Ymd')])->log($logs, Logger::INFO);
}

if (count($di['config']->path('app.listeners')) > 0) {
    foreach ($di['config']->path('app.listeners') as $name => $listener) {
        $di['eventsManager']->attach($name, new $listener);
    }
}
