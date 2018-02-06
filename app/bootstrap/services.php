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
    Phalcon\Logger\Formatter\Line,
    Phalcon\Cache\Frontend\Data as FrontData,
    Phalcon\Cache\Backend\File as FileCache,
    Phalcon\Cache\Backend\Redis as RedisCache,
    MyApp\Services\Locale,
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
    $logger = new FileLogger(ROOT_DIR . '/storage/logs/' . ($file ? $file : date('Ymd')));
    $logger->setFormatter(new Line("[%date%][%type%] %message%", 'Y-m-d H:i:s O'));
    return $logger;
}, false);


$di->set('crypt', function () use ($di) {
    $crypt = new Crypt();
    $crypt->setKey($di['config']->setting->appKey);
    return $crypt;
}, true);


$di->set('session', function () {
    ini_set('session.save_path', ROOT_DIR . '/storage/sessions/');
    $session = new SessionAdapter();
    $session->start();
    return $session;
}, true);


$di->set('locale', function () {
    return new Locale();
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


$di->set('redis', function () use ($di) {
    $redis = new Redis();
    $redis->connect($di['config']->redis->host, $di['config']->redis->port);
    $redis->select($di['config']->redis->db);
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
