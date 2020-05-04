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

use Phalcon\Translate\Adapter\NativeArray;
use Phalcon\Translate\InterpolatorFactory;
use Phalcon\Translate\TranslateFactory;

/**
 * Class Language
 * @property \Phalcon\Config $config
 */
class Language extends \Phalcon\Di\Injectable
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
        $path = ASSETS_DIR . 'lang/' . $this->getLang() . DIRECTORY_SEPARATOR . $file . '.php';

        if (file_exists($path)) {
            $messages = include $path;
        }
        else {
            $messages = include ASSETS_DIR . 'lang/' . $this->config->app->lang . DIRECTORY_SEPARATOR . $file . '.php';
        }

        return new NativeArray(new InterpolatorFactory(), [
            'content' => $messages,
        ]);
    }

}
