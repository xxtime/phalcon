<?php

namespace App\System;


use Phalcon\Mvc\User\Component;
use Phalcon\Translate\Adapter\NativeArray;

class Lang extends Component
{

    private $lang = null;


    private $translator = null;


    public function getLang()
    {
        if ($this->lang) {
            return $this->lang;
        }
        return $this->config->app->lang;
    }


    public function setLang($lang = 'en_US')
    {
        $this->lang = $lang;
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
        $path = ROOT_DIR . '/resources/lang/' . $this->getLang() . DIRECTORY_SEPARATOR . $file . '.php';

        if (file_exists($path)) {
            $messages = include $path;
        }
        else {
            $messages = include ROOT_DIR . '/resources/lang/' . $this->config->app->lang . DIRECTORY_SEPARATOR . $file . '.php';
        }

        return new NativeArray(['content' => $messages]);
    }

}
