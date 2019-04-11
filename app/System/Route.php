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
 *
 * USAGE:
 * $r = new \App\System\Route($router);
 * $r->addResource('/product', 'V1\Product','{id:[a-z0-9]{1,24}}')->only('show');
 * $r->addResource('/news', 'V1\News')->except('destroy');
 */

namespace App\System;

use Phalcon\Mvc\Router\Group;
use Exception;

class Route
{

    private $router;


    private $resource;


    private $idFormat = '{id:[a-z0-9]{1,24}}';


    private $allowAction = ['index', 'store', 'show', 'update', 'destroy'];


    private $_uri;


    public function __construct(&$router)
    {
        $this->router = $router;
    }


    public function __destruct()
    {
        $this->mountRoute();
    }


    public function setIdFormat($format = '')
    {
        if (!$format) {
            return false;
        }
        $this->idFormat = $format;
    }


    public function getIdFormat()
    {
        return $this->idFormat;
    }


    public function addResource($uri = '', $handle = null, $idFormat = null)
    {
        if (!$uri || !$handle) {
            throw new Exception('invalid resource');
        }
        $this->_uri = $uri;
        $this->resource[$uri] = [
            'regular' => $idFormat ? $idFormat : $this->getIdFormat(),
            'handle'  => ucfirst($handle),
        ];
        return $this;
    }


    public function only(...$action)
    {
        $this->resource[$this->_uri]['action'] = $action;
    }


    public function except(...$action)
    {
        $this->resource[$this->_uri]['action'] = array_diff($this->allowAction, $action);
    }


    private function mountRoute()
    {
        foreach ($this->resource as $uri => $value) {
            $group = new Group(['controller' => $value['handle']]);
            $group->setPrefix($uri);
            if (empty($value['action'])) {
                $value['action'] = $this->allowAction;
            }
            foreach ($value['action'] as $action) {
                switch ($action) {
                    case 'index':
                        $group->addGet('', ['action' => 'index']);
                        break;
                    case 'store':
                        $group->addPost('', ['action' => 'store']);
                        break;
                    case 'show':
                        $group->addGet('/' . $value['regular'], ['action' => 'show']);
                        break;
                    case 'update':
                        $group->addPut('/' . $value['regular'], ['action' => 'update']);
                        break;
                    case 'destroy':
                        $group->addDelete('/' . $value['regular'], ['action' => 'destroy']);
                        break;
                    default:
                        throw new Exception('invalid route action');
                        $group->add('/' . $value['regular'], ['action' => $action]);
                }
            }
            $this->router->mount($group);
        }
    }

}
