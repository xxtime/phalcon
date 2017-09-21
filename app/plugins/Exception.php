<?php
/**
 * whoops exception adapter
 * Created by PhpStorm.
 * User: joe
 * Date: 14/12/7
 * Time: 12:15
 * Link: http://filp.github.io/whoops/
 */
$whoops = new \Whoops\Run;
$whoops->pushHandler(new \Whoops\Handler\PrettyPageHandler);
$whoops->register();