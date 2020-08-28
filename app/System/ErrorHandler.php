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

namespace App\System;

class ErrorHandler
{

    const EXCEPTION_HANDLER = "handleException";
    const ERROR_HANDLER     = "handleError";
    const SHUTDOWN_HANDLER  = "handleShutdown";

    private $path = "";

    public function setTemplate(string $path)
    {
        $this->path = $path;
    }

    public function register()
    {
        $this->setErrorHandler([$this, self::ERROR_HANDLER]);
        $this->setExceptionHandler([$this, self::EXCEPTION_HANDLER]);
        $this->registerShutdownFunction([$this, self::SHUTDOWN_HANDLER]);
    }

    public function setErrorHandler(callable $handler, $types = 'use-php-defaults')
    {
        if ($types === 'use-php-defaults') {
            $types = E_ALL;
        }
        return set_error_handler($handler, $types);
    }

    public function setExceptionHandler(callable $handler)
    {
        return set_exception_handler($handler);
    }

    public function registerShutdownFunction(callable $function)
    {
        register_shutdown_function($function);
    }

    public function handleException($exception)
    {
        exit(file_get_contents(ROOT_DIR . "templates/" . $this->path));
    }

    public function handleError($level, $message, $file = null, $line = null)
    {
        exit(file_get_contents(ROOT_DIR . "templates/" . $this->path));
    }

    public function handleShutdown()
    {
    }

}

