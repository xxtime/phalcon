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

namespace App\System;

use Phalcon\Mvc\User\Component;
use Phalcon\Translate\Adapter\NativeArray;

/**
 * Class Language
 * @property \Phalcon\Config $config
 */
class Language extends Component
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
