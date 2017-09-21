<?php

/**
 * System Loader
 * @link: https://github.com/xxtime/phalcon
 * @link: https://docs.phalconphp.com
 * @link: https://github.com/phalcon/mvc
 */
use Phalcon\Loader;
use Phalcon\Mvc\Application;

if (!file_exists(BASE_DIR . '/vendor/autoload.php')) {
    die('Run Command: composer install');
}

include BASE_DIR . '/vendor/autoload.php';

include APP_DIR . "/bootstrap/services.php";

include APP_DIR . "/bootstrap/setting.php";

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