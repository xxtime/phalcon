<?php


use Phalcon\Loader;
use Phalcon\Mvc\Application;

$loader = new Loader();
$loader->registerNamespaces(array(
    'App' => APP_DIR,
))->register();

require ROOT_DIR . '/vendor/autoload.php';
require ROOT_DIR . '/bootstrap/helpers.php';
require ROOT_DIR . '/bootstrap/service.php';
require ROOT_DIR . '/bootstrap/setting.php';

$application = new Application($di);
$application->setEventsManager($di['eventsManager']);

if ($di['config']->path('app.disableView')) {
    $application->useImplicitView(false);
}

$application->handle()->send();
