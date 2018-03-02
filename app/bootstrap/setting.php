<?php


use Phalcon\Logger;
use Phalcon\Dispatcher;
use Phalcon\Events\Event;
use Phalcon\Mvc\Dispatcher\Exception as DispatchException;


ini_set("date.timezone", $di['config']->setting->timezone);


switch ($di['config']->setting->sandbox) {
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


if ($di['config']->setting->logs) {
    $separator = strpos($_SERVER['REQUEST_URI'], '?') ? '&' : '?';
    $log = $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'];
    $log .= file_get_contents("php://input") ? $separator . file_get_contents("php://input") : '';
    $di->get('logger', [date('Ym')])->log($log, Logger::INFO);
}


$di['eventsManager']->attach('db', function ($event, $connection) use ($di) {
    if ($event->getType() == 'beforeQuery') {
        if ($di['config']->setting->logs) {
            $di->get('logger', ['SQL' . date('Ymd')])->log($connection->getSQLStatement());
        }
        if (preg_match('/drop|alter/i', $connection->getSQLStatement())) {
            return false;
        }
    }
});


$di['eventsManager']->attach(
    'dispatch:beforeException',
    function (Event $event, $dispatcher, Exception $exception) use ($di) {
        if ($di['config']->setting->sandbox) {
            return true;
        }
        if ($exception instanceof DispatchException) {
        }
        switch ($exception->getCode()) {
            case Dispatcher::EXCEPTION_HANDLER_NOT_FOUND:
            case Dispatcher::EXCEPTION_ACTION_NOT_FOUND:
                $dispatcher->forward([
                    'controller' => 'public',
                    'action'     => 'notFound',
                ]);
                return false;
        }
    }
);