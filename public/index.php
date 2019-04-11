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

define('ROOT_DIR', dirname(__DIR__));

define('APP_DIR', ROOT_DIR . '/app');

define('CONFIG_DIR', ROOT_DIR . '/config');

$app = require_once ROOT_DIR . "/bootstrap/kernel.php";

$app->boot();
