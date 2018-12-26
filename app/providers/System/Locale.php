<?php

namespace App\Providers\System;


use Phalcon\Mvc\User\Component;
use Phalcon\Translate\Adapter\NativeArray;

class Locale extends Component
{

    private $locale = null;


    private $translator = null;


    public function getLocale()
    {
        if ($this->locale) {
            return $this->locale;
        }
        return $this->config->app->locale;
    }


    public function setLocale($locale = 'en_US')
    {
        $this->locale = $locale;
    }


    public function t($translateKey, array $placeholders = null)
    {
        if (!$this->translator) {
            $this->translator = $this->getTranslator();
        }
        return $this->translator->_($translateKey, $placeholders);
    }


    public function _($translateKey, array $placeholders = null)
    {
        return $this->t($translateKey, $placeholders);
    }


    private function getTranslator($file = 'message')
    {
        $path = APP_DIR . '/locale/' . $this->getLocale() . DIRECTORY_SEPARATOR . $file . '.php';

        if (file_exists($path)) {
            $messages = include $path;
        }
        else {
            $messages = include APP_DIR . '/locale/' . $this->config->app->locale . DIRECTORY_SEPARATOR . $file . '.php';
        }

        return new NativeArray(['content' => $messages]);
    }

}
