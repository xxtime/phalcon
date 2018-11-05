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
    if ($config['include']) {
        foreach ($config['include'] as $item) {
            $config[$item] = function () use ($item) {
                return include CONFIG_DIR . '/' . $item . '.php';
            };
        }
    }
    return $config;
}, true);


$di->set('locale', function () {
    return new Providers\Components\Locale();
}, true);


$di->set('router', function () {
    return require CONFIG_DIR . '/routes.php';
}, true);


$di->set('logger', function ($file = null) {
    $logger = new FileLogger(ROOT_DIR . '/storage/logs/' . ($file ? $file : date('Ymd')));
    $logger->setFormatter(new Line("[%date%][%type%] %message%", 'Y-m-d H:i:s O'));
    return $logger;
}, false);


$di->set('crypt', function () use ($di) {
    $crypt = new Crypt();
    $crypt->setKey($di['config']->key);
    return $crypt;
}, true);


$di->set('session', function () use ($di) {
    ini_set('session.save_path', ROOT_DIR . '/storage/sessions/');
    ini_set('session.gc_maxlifetime', 86400 * 30);
    ini_set("session.cookie_lifetime", 86400 * 30);
    ini_set('session.name', 'SID');
    $session = new Phalcon\Session\Adapter\Files();
    /*$session = new Phalcon\Session\Adapter\Redis([
        "host"       => config('database.redis.host'),
        "port"       => config('database.redis.port'),
        "persistent" => false,
        "lifetime"   => 86400 * 30,
        "index"      => 0,
    ]);*/
    $session->start();
    return $session;
}, true);


$di->set('modelsCache', function () use ($di) {
    $frontCache = new FrontData(["lifetime" => 60]);
    if (isset($di['config']->cache)) {
        return new RedisCache($frontCache, [
            'host'   => $di['config']->cache->host,
            'port'   => $di['config']->cache->port,
            'index'  => $di['config']->cache->db,
            'prefix' => 'cache|',
        ]);
    }
    return new FileCache($frontCache, ['cacheDir' => ROOT_DIR . '/storage/cache/', 'prefix' => 'cache_']);
}, true);


$di->set('cache', function () use ($di) {
    $redis = new Redis();
    $redis->connect($di['config']->cache->host, $di['config']->cache->port);
    $redis->select($di['config']->cache->db);
    return $redis;
}, true);


$di->set('db', function () use ($di) {
    $connection = new Mysql([
        'host'     => config('database.mysql.host'),
        'port'     => config('database.mysql.port'),
        'username' => config('database.mysql.user'),
        'password' => config('database.mysql.pass'),
        'dbname'   => config('database.mysql.db'),
        'charset'  => config('database.mysql.charset')
    ]);
    $connection->setEventsManager($di['eventsManager']);
    return $connection;
}, true);


$di->set('redis', function () use ($di) {
    $redis = new Redis();
    $redis->connect(config('database.redis.host'), config('database.redis.port'));
    $redis->select(config('database.redis.db'));
    return $redis;
}, true);


$di->set('mongodb', function () use ($di) {
    return new MongoDBClient(
        "mongodb://" . config('database.mongodb.host') . ':' . config('database.mongodb.port'),
        array_filter([
            'username'   => config('database.mongodb.user'),
            'password'   => config('database.mongodb.pass'),
            'authSource' => config('database.mongodb.db')
        ]));
}, true);
