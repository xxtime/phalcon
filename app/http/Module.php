<?php


namespace App\Http;


use Phalcon\Loader;
use Phalcon\DiInterface;
use Phalcon\Mvc\Dispatcher;
use Phalcon\Mvc\View;
use Phalcon\Mvc\View\Engine\Volt;
use Phalcon\Mvc\ModuleDefinitionInterface;


class Module implements ModuleDefinitionInterface
{

    // the same to /ROOT/app/bootstrap/loader.php
    public function registerAutoloaders(DiInterface $di = null)
    {
        /*
        $loader = new Loader();
        $loader->registerNamespaces([
            'App\Http' => APP_DIR . '/http',
        ]);
        $loader->register();
        */
    }


    /**
     * https://docs.phalconphp.com/zh/3.2/volt
     * @param DiInterface $di
     */
    public function registerServices(DiInterface $di)
    {
        $di->set('dispatcher', function () use ($di) {
            $dispatcher = new Dispatcher();
            $dispatcher->setDefaultNamespace('App\Http\Controllers');
            $dispatcher->setEventsManager($di['eventsManager']);
            return $dispatcher;
        }, true);

        $di->set('view', function () use ($di) {
            $view = new View();
            $view->setViewsDir(ROOT_DIR . '/resources/views/');
            $view->registerEngines([
                '.phtml' => function ($view, $di) {
                    $volt = new Volt($view, $di);
                    $volt->setOptions(['compiledPath' => ROOT_DIR . '/storage/cache/']);
                    return $volt;
                }
            ]);
            return $view;
        }, true);
    }

}
