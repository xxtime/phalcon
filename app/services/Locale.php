<?php

namespace MyApp\Services;


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
        return $this->config->translate->default;
    }


    public function setLocale($locale = 'en_US')
    {
        if (!$locale || !file_exists(APP_DIR . '/locale/' . $locale)) {
            return false;
        }
        $this->locale = $locale;
    }


    public function t(string $translateKey, array $placeholders = null)
    {
        if (!$this->translator) {
            $this->translator = $this->getTranslator();
        }
        return $this->translator->_($translateKey, $placeholders);
    }


    public function _(string $translateKey, array $placeholders = null)
    {
        return $this->t($translateKey, $placeholders);
    }


    private function getTranslator(string $file = 'message')
    {
        $path = APP_DIR . '/locale/' . $this->getLocale() . DIRECTORY_SEPARATOR . $file . '.php';

        if (file_exists($path)) {
            $messages = require $path;
        }
        else {
            $messages = require APP_DIR . '/locale/en_US/' . $file . '.php';
        }

        return new NativeArray(['content' => $messages]);
    }

}
