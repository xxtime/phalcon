<?php


use Phalcon\DI\FactoryDefault,
    Phalcon\Crypt,
    Phalcon\Config,
    Phalcon\Db\Adapter\Pdo\Mysql,
    Phalcon\Logger\Adapter\File as FileLogger,
    Phalcon\Logger\Formatter\Line,
    Phalcon\Cache\Frontend\Data as FrontData,
    Phalcon\Cache\Backend\File as FileCache,
    Phalcon\Cache\Backend\Redis as RedisCache,
    App\Providers,
    MongoDB\Client as MongoDBClient;


$di = new FactoryDefault();


$di->set('config', function () {
    $config = new Config(include CONFIG_DIR . "/app.php");
    if ($config->path("app.include")) {
        foreach ($config->path("app.include") as $item) {
            $config->merge(new Config(include CONFIG_DIR . '/' . $item . '.php'));
        }
    }
    return $config;
}, true);


$di->set('locale', function () {
    return new Providers\System\Locale();
}, true);


$di->set('router', function () {
    return require APP_DIR . '/routes.php';
}, true);


$di->set('logger', function ($file = null) {
    $logger = new FileLogger(ROOT_DIR . '/storage/logs/' . ($file ? $file : date('Ymd')));
    $logger->setFormatter(new Line("[%date%][%type%] %message%", 'Y-m-d H:i:s O'));
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
