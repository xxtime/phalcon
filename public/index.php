<?php

define('SYSTEM_START', microtime(true));

define('ROOT_DIR', dirname(__DIR__));

define('APP_DIR', ROOT_DIR . '/app');

define('CONFIG_DIR', ROOT_DIR . '/config');

include ROOT_DIR . "/bootstrap/loader.php";
