<?php


use Phalcon\DI\FactoryDefault,
    Phalcon\Mvc\Url as UrlResolver,
    Phalcon\Crypt,
    Phalcon\Config,
    Phalcon\Config\Adapter\Yaml,
    Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter,
    Phalcon\Mvc\Model\Metadata\Memory as MetaDataAdapter,
    Phalcon\Session\Adapter\Files as SessionAdapter,
    Phalcon\Http\Response\Cookies,
    Phalcon\Events\Manager as EventsManager,
    Phalcon\Logger\Adapter\File as FileLogger,
    Phalcon\Cache\Frontend\Data as FrontData,
    Phalcon\Cache\Backend\File as FileCache,
    Phalcon\Cache\Backend\Redis as RedisCache,
    Symfony\Component\Yaml\Yaml as SFYaml,
    MongoDB\Client as MongoDBClient;


$di = new FactoryDefault();


$di->set('config', function () {
    if (function_exists('yaml_parse_file')) {
        return new Yaml(APP_DIR . "/config/app.yml");
    }
    return new Config(SFYaml::parse(file_get_contents(APP_DIR . "/config/app.yml")));
}, true);


$di->set('router', function () {
    return require APP_DIR . '/bootstrap/routes.php';
}, true);


$di->set('logger', function ($file = null) {
    $logger = new FileLogger(BASE_DIR . '/running/logs/' . ($file ? $file : date('Ymd')));
    return $logger;
}, false);


$di->set('crypt', function () use ($di) {
    $crypt = new Crypt();
    $crypt->setKey($di['config']->setting->appKey);
    return $crypt;
}, true);


$di->set('session', function () {
    $session = new SessionAdapter();
    $session->start();
    return $session;
}, true);


$di->set('url', function () {
    $url = new UrlResolver();
    $url->setBaseUri('/');
    return $url;
}, true);


$di->set('modelsMetadata', function () {
    return new MetaDataAdapter();
}, true);


$di->set('modelsCache', function () use ($di) {
    $frontCache = new FrontData(["lifetime" => $di['config']->setting->cacheTime]);
    if (isset($di['config']->redis)) {
        return new RedisCache($frontCache, [
            'host'   => $di['config']->redis->host,
            'port'   => $di['config']->redis->port,
            'index'  => $di['config']->redis->index,
            'prefix' => 'cache_',
        ]);
    }
    return new FileCache($frontCache, ['cacheDir' => BASE_DIR . '/running/cache/', 'prefix' => 'cache_']);
}, true);


$di['eventsManager']->attach('db', function ($event, $connection) use ($di) {
    if ($event->getType() == 'beforeQuery') {
        if ($di['config']->setting->logs) {
            $di->get('logger', ['SQL' . date('Ymd')])->log($connection->getSQLStatement());
        }
        if (preg_match('/drop|alter/i', $connection->getSQLStatement())) {
            return false;
        }
    }
});


$di->set('redis', function () use ($di) {
    $redis = new Redis();
    $redis->connect($di['config']->redis->host, $di['config']->redis->port);
    return $redis;
}, true);


$di->set('mongodb', function () use ($di) {
    return new MongoDBClient("mongodb://" . $di['config']->mongodb->host . ':' . $di['config']->mongodb->port, [
        'username'   => $di['config']->mongodb->user,
        'password'   => $di['config']->mongodb->pass,
        'authSource' => $di['config']->mongodb->db
    ]);
}, true);


foreach ($di['config']['database'] as $db => $value) {
    $di->set($db, function () use ($di, $value) {
        $connection = new DbAdapter([
            'host'     => $value['host'],
            'port'     => $value['port'],
            'username' => $value['user'],
            'password' => $value['pass'],
            'dbname'   => $value['db'],
            'charset'  => $value['charset']
        ]);
        $connection->setEventsManager($di['eventsManager']);
        return $connection;
    }, true);
}