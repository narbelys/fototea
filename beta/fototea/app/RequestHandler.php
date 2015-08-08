<?php

namespace Fototea\App;

use \Symfony\Component\HttpFoundation\Request;
use \Fototea\Util\Set;
use \Fototea\Util\Util;

class RequestHandler {

    const METHOD_GET = 'GET';
    const METHOD_POST = 'POST';
    const METHOD_HEAD = 'HEAD';

    private $request;

    public function __construct(){
        $this->request = Request::createFromGlobals();
    }

    public function get($key = '', $default = '') {
        if ($key == ''){
            return $this->request->query->all();
        } else {
            return $this->request->query->get($key, $default);
        }
    }

    public function post($key = '', $default = '') {
        if ($key == ''){
            return $this->request->request->all();
        } else {
            return $this->request->request->get($key, $default);
        }
    }

    public function cookie($key = '', $default = null){
        if ($key == ''){
            return $this->request->cookies->all();
        } else {
            return $this->request->cookies->get($key, $default);
        }
    }

    public function method(){
        return $this->request->getMethod();
    }

    public function file($key = ''){
        if ($key != ''){
            return $this->request->files->get($key, false);
        } else {
            return $this->request->files->all();
        }
    }

    public function headers($key = '') {
        if ($key != ''){
            return $this->request->headers->get($key, false);
        } else {
            return $this->request->headers->all();
        }
    }

    public function server($key = '') {
        if ($key != ''){
            return $this->request->server->get($key, false);
        }
        return $this->request->server->all();
    }
}