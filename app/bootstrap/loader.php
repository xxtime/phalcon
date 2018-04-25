<?php


use Phalcon\Loader;
use Phalcon\Mvc\Application;

$loader = new Loader();
$loader->registerNamespaces(array(
    'App\Bootstrap' => APP_DIR . '/bootstrap',
    'App\Http'      => APP_DIR . '/http',
    'App\Providers' => APP_DIR . '/providers',
))->register();

require ROOT_DIR . '/vendor/autoload.php';
require APP_DIR . '/providers/helpers.php';
require APP_DIR . "/bootstrap/services.php";
require APP_DIR . "/bootstrap/setting.php";

$application = new Application($di);
$application->setEventsManager($di['eventsManager']);
$application->registerModules([
    'v1' => ['className' => 'App\Http\Module', 'path' => APP_DIR . '/http/Module.php']
]);

if ($di['config']->env->disableView) {
    $application->useImplicitView(false);
}

$application->handle()->send();
