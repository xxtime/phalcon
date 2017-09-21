<?php


use Phalcon\Logger;


ini_set("date.timezone", $di['config']->setting->timezone);


switch ($di['config']->setting->sandbox) {
    case true:
        include APP_DIR . '/plugins/' . 'Exception.php';
        error_reporting(E_ALL);
        break;
    default:
        header_remove('X-Powered-By');
        error_reporting(0);
};


if ($di['config']->setting->logs) {
    if (!isset($_REQUEST['_url'])) {
        $_REQUEST['_url'] = '/';
    }
    $_url = $_REQUEST['_url'];
    unset($_REQUEST['_url']);
    $log = $_SERVER['REQUEST_METHOD'] . ' ';
    $log .= empty($_REQUEST) ? $_url : ($_url . '?' . urldecode(http_build_query($_REQUEST)));
    $di->get('logger', [date('Ym')])->log($log, Logger::INFO);
}