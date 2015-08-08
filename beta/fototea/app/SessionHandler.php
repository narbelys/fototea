<?php


namespace Fototea\App;

use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SessionHandler extends Session implements SessionInterface {

    public function flash($type, $value) {
        parent::getFlashBag()->add($type, $value);
    }

    public function getFlash($type = null) {
        if ($type != null){
            return parent::getFlashBag()->get($type, array());
        }
        return parent::getFlashBag()->all();
    }

}