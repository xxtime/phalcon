<?php

define('SYSTEM_START', microtime(true));

define('ROOT_DIR', dirname(__DIR__));

define('APP_DIR', ROOT_DIR . '/app');

include APP_DIR . "/bootstrap/loader.php";
