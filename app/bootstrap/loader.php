<?php


use Phalcon\Loader;
use Phalcon\Mvc\Application;

$loader = new Loader();
$loader->registerNamespaces(array(
    'App\Bootstrap' => APP_DIR . '/bootstrap',
    'App\Providers' => APP_DIR . '/providers',
    'App\Http'      => APP_DIR . '/http',
))->register();

require ROOT_DIR . '/vendor/autoload.php';
require APP_DIR . '/providers/helpers.php';
require APP_DIR . "/bootstrap/service.php";
require APP_DIR . "/bootstrap/setting.php";

$application = new Application($di);
$application->setEventsManager($di['eventsManager']);
$application->registerModules([
    'http' => ['className' => 'App\Http\Module', 'path' => APP_DIR . '/http/Module.php']
]);

if ($di['config']->path('app.disableView')) {
    $application->useImplicitView(false);
}

$application->handle()->send();
