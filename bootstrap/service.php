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

use Phalcon\DI\FactoryDefault,
    Phalcon\Crypt,
    Phalcon\Config,
    Phalcon\Db\Adapter\Pdo\Mysql,
    Phalcon\Logger\Adapter\File as FileLogger,
    Phalcon\Cache\Frontend\Data as FrontData,
    Phalcon\Cache\Backend\File as FileCache,
    Phalcon\Cache\Backend\Redis as RedisCache,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Mvc\View,
    Phalcon\Mvc\View\Engine\Volt,
    MongoDB\Client as MongoDBClient,
    App\System;


$di = new FactoryDefault();


$di->set('config', function () {
    $config = new Config(['app' => include CONFIG_DIR . "/app.php"]);
    $c = [];
    foreach ($config->path("app.config") as $name => $item) {
        $c[$name] = include $item;
    }
    $config->merge(new Config($c));
    return $config;
}, true);


$di->set('lang', function () {
    return new System\Language();
}, true);


$di->set('router', function () use ($di) {
    $router = require ROOT_DIR . '/routes/web.php';
    $router->setEventsManager($di->get('eventsManager'));
    return $router;
}, true);


$di->set('logger', function ($file = null) {
    $logger = new FileLogger(ROOT_DIR . '/storage/logs/' . ($file ? $file : date('Ymd')));
    return $logger;
}, false);


$di->set('crypt', function () use ($di) {
    $crypt = new Crypt();
    $crypt->setKey($di['config']->app->key);
    return $crypt;
}, true);


$di->set('session', function () use ($di) {
    $lifetime = $di["config"]->path("session.lifetime");
    switch ($di["config"]->path("session.driver")) {
        case  "redis":
            $session = new Phalcon\Session\Adapter\Redis([
                "host"       => $di["config"]->path("database.redis.host"),
                "port"       => $di["config"]->path("database.redis.port"),
                "persistent" => false,
                "lifetime"   => $lifetime,
                "index"      => 0,
            ]);
        case  "file":
        default:
            ini_set('session.save_path', $di["config"]->path('session.files'));
            ini_set('session.gc_maxlifetime', $lifetime);
            ini_set("session.cookie_lifetime", $lifetime);
            ini_set('session.name', 'SID');
            $session = new Phalcon\Session\Adapter\Files();
    }
    $session->start();
    return $session;
}, true);


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


$di->set('modelsCache', function () use ($di) {
    $frontCache = new FrontData(["lifetime" => 60]);
    if ($di['config']->path("cache.driver") == 'redis') {
        return new RedisCache($frontCache, [
            "host"   => $di["config"]->path("cache.host"),
            "port"   => $di["config"]->path("cache.port"),
            'index'  => $di["config"]->path("cache.db"),
            'prefix' => 'cache|',
        ]);
    }
    return new FileCache($frontCache, ['cacheDir' => ROOT_DIR . '/storage/cache/', 'prefix' => 'cache_']);
}, true);


$di->set('cache', function () use ($di) {
    $redis = new Redis();
    $redis->connect($di["config"]->path("cache.host"), $di["config"]->path("cache.port"));
    $redis->select($di["config"]->path("cache.db"));
    return $redis;
}, true);


$di->set('db', function () use ($di) {
    $connection = new Mysql([
        'host'     => $di["config"]->path("database.mysql.host"),
        'port'     => $di["config"]->path("database.mysql.port"),
        'username' => $di["config"]->path("database.mysql.user"),
        'password' => $di["config"]->path("database.mysql.pass"),
        'dbname'   => $di["config"]->path("database.mysql.db"),
        'charset'  => $di["config"]->path("database.mysql.charset"),
    ]);
    $connection->setEventsManager($di['eventsManager']);
    return $connection;
}, true);


$di->set('redis', function () use ($di) {
    $redis = new Redis();
    $redis->connect($di["config"]->path("database.redis.host"), $di["config"]->path("database.redis.port"));
    $redis->select($di["config"]->path("database.redis.db"));
    return $redis;
}, true);


$di->set('mongodb', function () use ($di) {
    return new MongoDBClient(
        "mongodb://" . $di["config"]->path('database.mongodb.host') . ':' . $di["config"]->path('database.mongodb.port'),
        array_filter([
            'username'   => $di["config"]->path('database.mongodb.user'),
            'password'   => $di["config"]->path('database.mongodb.pass'),
            'authSource' => $di["config"]->path('database.mongodb.db')
        ]));
}, true);


return $di;
