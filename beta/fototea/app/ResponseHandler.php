<?php

namespace Fototea\App;

use Fototea\App\Cookies;

class ResponseHandler {

    private $status = 200;
    private $redirect = false;
    private $body = '';
    private $headers = array();
    private $cookies;

    /**
     * @var array HTTP response codes and messages
     */
    protected static $messages = array(
        //Informational 1xx
        100 => '100 Continue',
        101 => '101 Switching Protocols',
        //Successful 2xx
        200 => '200 OK',
        201 => '201 Created',
        202 => '202 Accepted',
        203 => '203 Non-Authoritative Information',
        204 => '204 No Content',
        205 => '205 Reset Content',
        206 => '206 Partial Content',
        //Redirection 3xx
        300 => '300 Multiple Choices',
        301 => '301 Moved Permanently',
        302 => '302 Found',
        303 => '303 See Other',
        304 => '304 Not Modified',
        305 => '305 Use Proxy',
        306 => '306 (Unused)',
        307 => '307 Temporary Redirect',
        //Client Error 4xx
        400 => '400 Bad Request',
        401 => '401 Unauthorized',
        402 => '402 Payment Required',
        403 => '403 Forbidden',
        404 => '404 Not Found',
        405 => '405 Method Not Allowed',
        406 => '406 Not Acceptable',
        407 => '407 Proxy Authentication Required',
        408 => '408 Request Timeout',
        409 => '409 Conflict',
        410 => '410 Gone',
        411 => '411 Length Required',
        412 => '412 Precondition Failed',
        413 => '413 Request Entity Too Large',
        414 => '414 Request-URI Too Long',
        415 => '415 Unsupported Media Type',
        416 => '416 Requested Range Not Satisfiable',
        417 => '417 Expectation Failed',
        418 => '418 I\'m a teapot',
        422 => '422 Unprocessable Entity',
        423 => '423 Locked',
        //Server Error 5xx
        500 => '500 Internal Server Error',
        501 => '501 Not Implemented',
        502 => '502 Bad Gateway',
        503 => '503 Service Unavailable',
        504 => '504 Gateway Timeout',
        505 => '505 HTTP Version Not Supported'
    );

    public function __construct(){
        $this->cookies = new Cookies();
    }

    /**
     * Set a response header
     *
     * @param $header
     * @param $value
     *
     */
    public function header($header, $value){
        $this->headers[$header] = $value;
    }

    /**
     * Remove a response header
     *
     * @param $header
     */
    public function removeHeader($header){
        if (isset($this->headers[$header])){
            unset($this->headers[$header]);
        }
    }

    public function getStatusMessage($status){
        return self::$messages[$status];
    }

    /**
     * Return list of headers
     *
     * @return array
     */
    public function getHeaders(){
        return $this->headers;
    }

    /**
     * Set response code
     *
     * @param $status
     * @return $this
     */
    public function setStatus($status){
        $this->status = $status;
        return $this;
    }

    /**
     * Retrieve current response status code
     *
     * @return int
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set if response is a redirect
     *
     * @param $isRedirect
     * @return $this
     */
    public function setRedirect($isRedirect){
        $this->redirect = $isRedirect;
        return $this;
    }

    /**
     * Return current redirect flag
     *
     */
    public function isRedirect() {
        return $this->redirect;
    }

    /**
     * Set response body
     *
     * @param $body
     */
    public function setBody($body) {
        $this->body = $body;
    }

    public function getBody() {
        return $this->body;
    }

    /**
     * Set the response as a json response
     *
     * @param $jsonData
     */
    public function jsonResponse($jsonData, $httpStatusCode = 200) {
        $this->setStatus($httpStatusCode);
        $this->header('Content-type', 'application/json');
        $this->setBody(json_encode($jsonData));
    }

    /**
     * Set cookie
     *
     * The second argument may be a single scalar value, in which case
     * it will be merged with the default settings and considered the `value`
     * of the merged result.
     *
     * The second argument may also be an array containing any or all of
     * the keys shown in the default settings above. This array will be
     * merged with the defaults shown above.
     *
     * @param string $name   Cookie name
     * @param mixed  $value Optional cookie setting
     */
    public function setCookie($name, $value) {
        $this->cookies->set($name, $value);
    }

    /**
     * Remove cookie
     *
     * Unlike \Slim\Helper\Set, this will actually *set* a cookie with
     * an expiration date in the past. This expiration date will force
     * the client-side cache to remove its cookie with the given name
     * and settings.
     *
     * @param  string $name      Cookie name
     * @param  array  $settings Optional cookie settings @see Fototea\App\Cookies $default
     */
    public function removeCookie($name, $settings = array()) {
        $this->cookies->remove($name, $settings);
    }

    public function getCookies() {
        return $this->cookies->getIterator();
    }
}