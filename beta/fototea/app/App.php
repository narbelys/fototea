<?php


namespace Fototea\App;

use Fototea\Config\FConfig;
use \Symfony\Component\HttpFoundation\Request;
use Fototea\Util\StringHelper;
use Fototea\Models\Cart;

class App {

    private static $request; //request handler
    private static $response; //response handler
    private static $session; //session handler
    private static $input; //flash implementation for input validation
    private static $config;
    private static $cart; //flash implementation for input validation
    private $currentEnv = 'dev';
    private $env = array(
        'dev' => array('dev.fototea.com', 'localhost'),
        'test' => array('fototea.androb.com')
    );

    private $messages;

    public function __construct() {
        ob_start(); //buffer on

        //Load messages from flash bag
        $this->messages['info'] = array_merge(array(), $this->getSession()->getFlash('info'));
        $this->messages['error'] = array_merge(array(), $this->getSession()->getFlash('error'));

        $serverName = $this->getRequest()->server('SERVER_NAME');

        foreach ($this->env as $key => $list){
            if (in_array($serverName, $this->env[$key])){
                $this->currentEnv = $key;
            }
        }

    }

    public function getCurrentEnv() {
        return $this->currentEnv;
    }

    public static function getCart() {
        if (!isset(self::$cart)){
            self::$cart = new Cart(self::getSession());
        }
        return self::$cart;
    }

    public static function getRequest(){
        if (!isset(self::$request)){
            self::$request = new RequestHandler();
        }
        return self::$request;
    }

    public static function getSession(){
        if (!isset(self::$session)){
            self::$session = new SessionHandler();
        }
        return self::$session;
    }

    public static function getInput(){
        if (!isset(self::$input)){
            self::$input = new InputHandler(self::getSession(), self::getRequest());
        }
        return self::$input;
    }

    public static function getConfig() {
        if (!isset(self::$config)) {
            self::$config = new FConfig();
        }
        return self::$config;
    }

    public static function getResponse() {
        if (!isset(self::$response)) {
            self::$response = new ResponseHandler();
        }
        return self::$response;
    }

    /**
     * @param $model
     * @return (object)
     */
    public static function getModel($model) {
        $className = '\Fototea\Models\\' . ucfirst($model);
        return new $className;
    }

    public static function getHelper($model) {
        $className = '\Fototea\Util\\' . ucfirst($model);
        return new $className;
    }

    public function redirect($url, $code = 302){
        self::getResponse()->setRedirect(true);
        self::getResponse()->setStatus($code);
        self::getResponse()->header('Location', $url);
    }

    public static function shutdown(){

        $status = self::getResponse()->getStatus();

        if (!self::getResponse()->isRedirect()) {
            if (self::getResponse()->getBody() == ''){
                self::getResponse()->setBody(ob_get_clean());
            } else {
                ob_clean();
            }
        } else {
            ob_clean();
        }

        // Prepare response
        if (in_array($status, array(204, 304))) {
            self::getResponse()->removeHeader('Content-Type');
            self::getResponse()->removeHeader('Content-Length');
            self::getResponse()->setBody('');
        }

        //Send headers
        if (headers_sent() === false) {
            //Send status
            if (strpos(PHP_SAPI, 'cgi') === 0) {
                header(sprintf('Status: %s', $status, self::getResponse()->getStatusMessage($status)));
            } else {
                header(sprintf('HTTP/%s %s', '1.1', $status, self::getResponse()->getStatusMessage($status)));
            }

            foreach (self::getResponse()->getCookies() as $key => $cookie) {
                setcookie($key, $cookie['value'], $cookie['expires'], $cookie['path'], $cookie['domain'], $cookie['secure'], $cookie['httponly']);
            }

            //Send headers
            foreach (self::getResponse()->getHeaders() as $name => $value) {
                $hValues = explode("\n", $value);
                foreach ($hValues as $hVal) {
                    header("$name: $hVal", false);
                }
            }
        }

        //Send body, but only if it isn't a HEAD request
        if (self::getRequest()->method() != RequestHandler::METHOD_HEAD) {
            echo self::getResponse()->getBody();
        }

    }

    public function getMessages(){
        return $this->messages['info'];
    }

    public function hasMessages(){
        return (count($this->messages['info']) > 0);
    }

    public function addMessage($message, $params = array()) {

        if (!empty($params)) {
            $message = StringHelper::replaceParams($message, $params);
        }

        $this->getSession()->flash('info', $message);
    }

    public function getErrors(){
        return $this->messages['error'];
    }

    public function hasErrors(){
        return (count($this->messages['error']) > 0);
    }

    public function addError($message, $params = array()) {

        if (!empty($params)) {
            $message = StringHelper::replaceParams($message, $params);
        }

        $this->getSession()->flash('error', $message);
    }

    public function preRender($view) {
        echo '<div class="" onmouseover="jQuery(this).find(\'.view-name\').show()" onmouseout="jQuery(this).find(\'.view-name\').hide()" style="border:2px solid #ff0000; position:relative">';
    }

    public function postRender($view) {
        echo '<div class="view-name"  style="width:300px; height:150px; background:rgba(0,0,0,0.2); position:absolute; top:0; left:; display:none">' . $view . '</div>';
        echo '</div>';
    }
}