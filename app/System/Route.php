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
 *
 * USAGE:
 * $r = new \App\System\Route($router);
 * $r->addResource('/product', 'V1\Product','{id:[a-z0-9]{1,24}}')->only('get');
 * $r->addResource('/news', 'V1\News')->except('delete');
 */

namespace App\System;

use Phalcon\Mvc\Router\Group;
use Exception;

class Route
{

    private $router;


    private $resource;


    private $idFormat = '{id:[a-z0-9]{1,24}}';


    private $allowAction = ['index', 'get', 'post', 'put', 'delete'];


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
        $this->_uri           = $uri;
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
                    case 'post':
                        $group->addPost('', ['action' => 'post']);
                        break;
                    case 'get':
                        $group->addGet('/' . $value['regular'], ['action' => 'get']);
                        break;
                    case 'put':
                        $group->addPut('', ['action' => 'put']);
                        $group->addPut('/' . $value['regular'], ['action' => 'put']);
                        break;
                    case 'delete':
                        $group->addDelete('', ['action' => 'delete']);
                        $group->addDelete('/' . $value['regular'], ['action' => 'delete']);
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
