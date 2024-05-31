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

use Phalcon\DI\FactoryDefault,
    Phalcon\Crypt,
    Phalcon\Config\Config,
    Phalcon\Db\Adapter\Pdo\Mysql,
    Phalcon\Cache\Frontend\Data as FrontData,
    Phalcon\Cache\Backend\File as FileCache,
    Phalcon\Cache\Backend\Redis as RedisCache,
    Phalcon\Session\Manager,
    Phalcon\Session\Adapter\Stream,
    Phalcon\Session\Adapter\Redis,
    Phalcon\Storage\AdapterFactory,
    Phalcon\Storage\SerializerFactory,
    Phalcon\Mvc\Dispatcher,
    Phalcon\Mvc\ViewBaseInterface,
    Phalcon\Mvc\View,
    Phalcon\Mvc\View\Engine\Volt,
    Laminas\Log\Logger,
    Laminas\Log\Writer\Stream as LogStream,
    MongoDB\Client as MongoDBClient,
    App\Provider,
    App\System;


$di = new FactoryDefault();


$di->set('config', function () {
    $config = new Config(['app' => include CONFIG_DIR . "app.php"]);
    $c      = [];
    foreach ($config->path("app.config") as $name => $item) {
        $c[$name] = include $item;
    }
    $config->merge(new Config($c));
    return $config;
}, true);


$di->set('lang', new System\Language(), true);


$di->set('router', function () use ($di) {
    $router = require ROOT_DIR . 'config/routes/web.php';
    $router->setEventsManager($di->get('eventsManager'));
    return $router;
}, true);


$di->set('logger', function () {
    // @docs https://docs.laminas.dev/laminas-log
    $wDef = new LogStream(DATA_DIR . 'log/main.log');

    $wErr = new LogStream(DATA_DIR . 'log/error.log');
    $wErr->addFilter(new \Laminas\Log\Filter\Priority(Logger::ERR));

    $wWar = new LogStream(DATA_DIR . 'log/warn.log');
    $wWar->addFilter(new \Laminas\Log\Filter\Priority(Logger::WARN, "="));

    $wInf = new LogStream(DATA_DIR . 'log/info.log');
    $wInf->addFilter(new \Laminas\Log\Filter\Priority(Logger::INFO, "="));

    $wDeb = new LogStream(DATA_DIR . 'log/debug.log');
    $wDeb->addFilter(new \Laminas\Log\Filter\Priority(Logger::DEBUG, "="));

    $logger = new Logger();
    $logger->addWriter($wDef);
    $logger->addWriter($wErr);
    $logger->addWriter($wWar);
    $logger->addWriter($wInf);
    $logger->addWriter($wDeb);

    return $logger;
}, true);


$di->set('crypt', function () use ($di) {
    $crypt = new Crypt();
    $crypt->setKey($di['config']->app->key);
    return $crypt;
}, true);


$di->set('session', function () use ($di) {
    $lifetime = $di["config"]->path("session.lifetime");
    switch ($di["config"]->path("session.driver")) {
        case  "redis":
            $options           = [
                'host'       => $di["config"]->path("database.redis.host"),
                'port'       => $di["config"]->path("database.redis.port"),
                'index'      => $di["config"]->path("database.redis.dbname"),
                "persistent" => false,
                "lifetime"   => $lifetime,
            ];
            $session           = new Manager();
            $serializerFactory = new SerializerFactory();
            $factory           = new AdapterFactory($serializerFactory);
            $redis             = new Redis($factory, $options);
            $session->setAdapter($redis)->start();
            break;

        case  "file":

        default:
            //ini_set('session.save_path', $di["config"]->path('session.files'));
            ini_set('session.gc_maxlifetime', $lifetime);
            ini_set("session.cookie_lifetime", $lifetime);
            ini_set('session.name', 'SID');
            $session = new Manager();
            $files   = new Stream(
                [
                    'savePath' => $di["config"]->path('session.files'),
                ]
            );
            $session->setAdapter($files)->start();
    }
    return $session;
}, true);


$di->set('dispatcher', function () use ($di) {
    $dispatcher = new Dispatcher();
    $dispatcher->setDefaultNamespace('App\Http\Controller');
    $dispatcher->setEventsManager($di['eventsManager']);
    return $dispatcher;
}, true);


$di->set('voltService', function (ViewBaseInterface $view) use ($di) {
    $volt = new Volt($view, $di);
    $volt->setOptions(
        [
            'always'    => true,
            'extension' => '.php',
            'separator' => '_',
            'stat'      => true,
            'path'      => DATA_DIR . 'cache/',
            'prefix'    => 'cache',
        ]
    );
    return $volt;
}, true);


$di->set('view', function () use ($di) {
    $view = new View();
    $view->setViewsDir(ROOT_DIR . 'templates/');
    $view->registerEngines([
        '.phtml' => 'voltService',
    ]);
    return $view;
}, true);


$di->set('modelsCache', function () use ($di) {
    $frontCache = new FrontData(["lifetime" => 60]);
    if ($di['config']->path("cache.driver") == 'redis') {
        return new RedisCache($frontCache, [
            "host"   => $di["config"]->path("cache.host"),
            "port"   => $di["config"]->path("cache.port"),
            'index'  => $di["config"]->path("cache.dbname"),
            'prefix' => 'cache|',
        ]);
    }
    return new FileCache($frontCache, ['cacheDir' => DATA_DIR . 'cache/', 'prefix' => 'cache_']);
}, true);


$di->set('cache', function () use ($di) {
    $redis = new \Redis();
    $redis->connect($di["config"]->path("cache.host"), $di["config"]->path("cache.port"));
    $redis->select($di["config"]->path("cache.dbname"));
    return $redis;
}, true);


$di->set('db', function () use ($di) {
    $connection = new Mysql([
        'host'     => $di["config"]->path("database.mysql.host"),
        'port'     => $di["config"]->path("database.mysql.port"),
        'username' => $di["config"]->path("database.mysql.user"),
        'password' => $di["config"]->path("database.mysql.pass"),
        'dbname'   => $di["config"]->path("database.mysql.dbname"),
        'charset'  => $di["config"]->path("database.mysql.charset"),
    ]);
    $connection->setEventsManager($di['eventsManager']);
    return $connection;
}, true);


$di->set('redis', function () use ($di) {
    $redis = new \Redis();
    $redis->connect($di["config"]->path("database.redis.host"), $di["config"]->path("database.redis.port"));
    $redis->select($di["config"]->path("database.redis.dbname"));
    return $redis;
}, true);


$di->set('mongodb', function () use ($di) {
    return new MongoDBClient(
        "mongodb://" . $di["config"]->path('database.mongodb.host') . ':' . $di["config"]->path('database.mongodb.port'),
        array_filter([
            'username'   => $di["config"]->path('database.mongodb.user'),
            'password'   => $di["config"]->path('database.mongodb.pass'),
            'authSource' => $di["config"]->path('database.mongodb.dbname')
        ]));
}, true);


$di->set('support', new Provider\Support\Adaptor($di), true);


$di->set('service', new Provider\Service\Adaptor($di), true);

return $di;
