<?php

namespace Fototea\App;

class InputHandler {

    private $session;
    private $old;
    private $errors;
    private $errorCount = 0;

    public function __construct(SessionHandler $session, RequestHandler $request){
        $this->session = $session;
        $this->request = $request;
    }

    public function old($key = '', $default = '') {

        if (!isset($this->old)) {
            $this->old = $this->session->getFlash('input');
        }

        return (isset($this->old[$key]))? $this->old[$key] : $default;
    }

    public function save() {
        $this->session->getFlashBag()->set('input', $this->request->post());
    }

    public function errors($key = '', $default = '') {
        if (!isset($this->errors)) {
            $this->errors = $this->session->getFlash('validation_errors');
        }

        if ($key != '') {
            return (isset($this->errors[$key]))? $this->errors[$key] : $default;
        } else {
            return $this->errors;
        }
    }

    public function addError($field, $message) {
        $this->errorCount++;
        $errors = $this->session->getFlashBag()->get('validation_errors', array());
        $errors[$field] = $message;
        $this->session->getFlashBag()->set('validation_errors', $errors);
    }

}