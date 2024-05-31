<?php
/**
 * Powered by ZLab
 *  ____ _           _             _
 * |_  /| |    __ _ | |__       __| | ___ __ __
 *  / / | |__ / _` || '_ \  _  / _` |/ -_)\ V /
 * /___||____|\__,_||_.__/ (_) \__,_|\___| \_/
 *
 * @link https://zlab.dev
 * @link https://github.com/xxtime/phalcon
 */

use App\System\ErrorHandler;
use Phalcon\Autoload\Loader;
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
        $loader->setNamespaces(array(
            'App' => APP_DIR,
        ))->register();

        require_once ROOT_DIR . 'vendor/autoload.php';
        require_once APP_DIR . 'helper.php';
        $this->di = require_once APP_DIR . 'service.php';

        loadEnv();
    }


    public function setting()
    {

        ini_set("date.timezone", $this->di['config']->app->timezone);

        /*
        | Setting ENV
        |------------------------------------------------------------------
        */
        switch ($this->di['config']->app->env != 'prod') {
            case true:
                $whoops = new \Whoops\Run;
                $whoops->appendHandler(new \Whoops\Handler\PrettyPageHandler);
                $whoops->register();
                break;
            default:
                $handler = new ErrorHandler();
                $handler->setTemplate("html/defaultHandler.html");
                $handler->register();
        };

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
        $application->handle($_SERVER["REQUEST_URI"])->send();
    }


}


$app = new Framework;

return $app;
