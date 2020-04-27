<?php


namespace App\Providers\Supports;

use Zend\Math\Rand;

class HelpClass
{
    /**
     * 生成随机字符串
     * @param int $size
     * @return string
     */
    public function randString($size = 32)
    {
        $charList = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
        return Rand::getString($size, $charList);
    }
}
