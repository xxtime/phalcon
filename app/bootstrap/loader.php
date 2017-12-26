<?php

/**
 * System Loader
 * @link: https://github.com/xxtime/phalcon
 * @link: https://docs.phalconphp.com
 * @link: https://github.com/phalcon/mvc
 */
use Phalcon\Loader;
use Phalcon\Mvc\Application;

require ROOT_DIR . '/vendor/autoload.php';

require APP_DIR . "/bootstrap/services.php";

require APP_DIR . "/bootstrap/setting.php";

$loader = new Loader();
$loader->registerNamespaces(array(
    'MyApp\Services'  => APP_DIR . '/services/',
    'MyApp\Plugins'   => APP_DIR . '/plugins/',
    'MyApp\Libraries' => APP_DIR . '/libraries/',
))->register();

$application = new Application($di);

$application->registerModules([
    'v1' => ['className' => 'MyApp\V1\Module', 'path' => APP_DIR . '/v1/Module.php']
]);

echo $application->handle()->getContent();
