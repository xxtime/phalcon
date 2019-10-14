<?php
/**
 * High performance, PHP framework
 *    ___    __          __
 *   / _ \  / /  ___ _  / / ____ ___   ___
 *  / ___/ / _ \/ _ `/ / / / __// _ \ / _ \
 * /_/    /_//_/\_,_/ /_/  \__/ \___//_//_/
 *
 * @link https://www.xxtime.com
 * @link https://github.com/xxtime/phalcon
 */

use Phalcon\Loader;
use Phalcon\Logger;
use Phalcon\Mvc\Application;

/**
 * Class Framework
 * @property \Phalcon\Di|\Phalcon\DiInterface $di
 */
class Framework
{


    public $di;


    public function boot()
    {
        $this->loader();

        $this->setting();

        $this->kernel();
    }


    public function loader()
    {
        $loader = new Loader();
        $loader->registerNamespaces(array(
            'App' => APP_DIR,
        ))->register();

        require_once ROOT_DIR . 'vendor/autoload.php';
        require_once ROOT_DIR . 'bootstrap/helpers.php';
        $this->di = require_once ROOT_DIR . 'bootstrap/service.php';

        loadEnv();
    }


    public function setting()
    {

        ini_set("date.timezone", $this->di['config']->app->timezone);

        /*
        | Setting ENV
        |------------------------------------------------------------------
        */
        switch ($this->di['config']->app->env != 'production') {
            case true:
                $whoops = new \Whoops\Run;
                $whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
                $whoops->register();
                error_reporting(E_ALL);
                break;
            default:
                error_reporting(0);
        };

        /*
        | Setting Debug Logs
        |------------------------------------------------------------------
        */
        if ($this->di['config']->app->debug) {
            $logs = $_SERVER['REQUEST_METHOD'] . ' ' . $_SERVER['REQUEST_URI'] . ' ' . $_SERVER['SERVER_PROTOCOL'] . "\n";
            foreach (getAllHeaders() as $key => $value) {
                $logs .= $key . ': ' . $value . "\n";
            }
            $logs .= "\n" . file_get_contents("php://input");
            $this->di->get('logger', [date('Ymd')])->log($logs, Logger::INFO);
        }

        /*
        | Setting Listeners
        |------------------------------------------------------------------
        |
        | config/app.php listeners
        |
        */
        foreach ($this->di['config']->path('app.listeners') as $name => $listener) {
            $this->di['eventsManager']->attach($name, new $listener);
        }

    }


    public function kernel()
    {
        $application = new Application($this->di);
        $application->setEventsManager($this->di['eventsManager']);
        if ($this->di['config']->path('app.disableView')) {
            $application->useImplicitView(false);
        }
        $application->handle()->send();
    }


}


$app = new Framework;

return $app;
