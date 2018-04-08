<?php

/**
 * 自定义日志适配器
 * 用于分布式部署单独日志服务器记录日志
 * @link https://docs.phalconphp.com/zh/latest/reference/logging.html#implementing-your-own-adapters
 * @link https://docs.phalconphp.com/zh/latest/api/Phalcon_Logger_AdapterInterface.html
 */
namespace App\Providers\Components;


use Phalcon\Logger\AdapterInterface;
use Phalcon\Logger\FormatterInterface;

class LogsComponent implements AdapterInterface
{

    public function setFormatter(FormatterInterface $formatter)
    {
    }


    public function getFormatter()
    {
    }


    public function setLogLevel($level)
    {
    }


    public function getLogLevel()
    {
    }


    public function log($type, $message = null, array $context = null)
    {
    }


    public function begin()
    {
    }


    public function commit()
    {
    }


    public function rollback()
    {
    }


    public function close()
    {
    }


    public function debug($message, array $context = null)
    {
    }


    public function error($message, array $context = null)
    {
    }


    public function info($message, array $context = null)
    {
    }


    public function notice($message, array $context = null)
    {
    }


    public function warning($message, array $context = null)
    {
    }


    public function alert($message, array $context = null)
    {
    }


    public function emergency($message, array $context = null)
    {
    }

}