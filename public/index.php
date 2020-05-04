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

define('SYSTEM_START', microtime(true));

define('ROOT_DIR', dirname(__DIR__) . DIRECTORY_SEPARATOR);

define('APP_DIR', ROOT_DIR . 'app' . DIRECTORY_SEPARATOR);

define('CONFIG_DIR', ROOT_DIR . 'config' . DIRECTORY_SEPARATOR);

define('DATA_DIR', ROOT_DIR . 'var' . DIRECTORY_SEPARATOR);

define('ASSETS_DIR', DATA_DIR . 'assets' . DIRECTORY_SEPARATOR);

$app = require_once APP_DIR . "Boot/kernel.php";

$app->boot();
