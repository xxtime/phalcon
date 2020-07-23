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

define('SYSTEM_START', microtime(true));

define('ROOT_DIR', dirname(__DIR__) . DIRECTORY_SEPARATOR);

define('APP_DIR', ROOT_DIR . 'app' . DIRECTORY_SEPARATOR);

define('CONFIG_DIR', ROOT_DIR . 'config' . DIRECTORY_SEPARATOR);

define('DATA_DIR', ROOT_DIR . 'var' . DIRECTORY_SEPARATOR);

define('ASSETS_DIR', DATA_DIR . 'assets' . DIRECTORY_SEPARATOR);

$app = require_once APP_DIR . "kernel.php";

$app->boot();
