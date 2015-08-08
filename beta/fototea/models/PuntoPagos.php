<?php
/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 6/12/14
 * Time: 1:59 PM
 */

namespace Fototea\Models;

use \Fototea\Models\IPaymentMethod;
use \Httpful\Request;

class PuntoPagos implements IPaymentMethod {

    const PAYMENT_METHOD_TYPE = 'PuntoPagos';

    private $gatewayUrl = 'https://sandbox.puntopagos.com/';
    private $gatewayKey = '0PKOkAqSx8KW5t725Mu1';
    private $gatewaySecret = 'bBtrhIiNGKslV5K0sV0KkmSMFGPstPxT3iqo5ssD';
    private $gatewayToken = '';

    private $actions = array(
        'createTrx' => 'transaccion/crear', // Paso 1
        'payment' => 'transaccion/procesar/', // Paso 3
        'getTrx' => 'transaccion/',
    );

    public function createTransaction($orderId, $amount){

        $date = $this->getDate();

        $body = new \stdClass();
        $body->trx_id = $orderId;
        //$body->medio_pago = "999";
        $body->monto = number_format($amount, 2,'.','');
        $body->descripcion = "Pago de prueba";

        // Mensaje
        $message = $this->actions['createTrx']."\n$body->trx_id\n$body->monto\n$date";

        //Firmar
        $signature = $this->getSignature($message);

        // Header
        $header = $this->getHeader($signature);


        $url = $this->gatewayUrl.$this->actions['createTrx'];

        $response = $this->sendRequest($url, $date, $header, $body);

        $result = new \stdClass();

        if ($response->body->respuesta == '00'){
            $result->success = true;
            $result->gateway_id = $response->body->token;
            $url = $this->gatewayUrl.$this->actions['payment'].$result->gateway_id;
            $result->redirectUrl = $url;
        } else {
            $result->success = false;
            $result->error = $response->body->error;
        }

        return $result;
    }

    public function getTransaction($token, $orderId, $amount){

        $date = $this->getDate();

        $body = new \stdClass();
        $body->token = $token;
        $body->trx_id = $orderId;
        //$body->medio_pago = "999";
        $body->monto = number_format($amount, 2,'.','');
        $body->descripcion = "Pago de prueba";

        // Mensaje
        $message = $this->actions['getTrx']."traer\n$body->token\n$body->trx_id\n$body->monto\n$date";

        //Firmar
        $signature = $this->getSignature($message);

        // Header
        $header = $this->getHeader($signature);

        $url = $this->gatewayUrl.$this->actions['getTrx'].$token;

        $response = $this->sendRequest($url, $date, $header, $body, 'get');

        $result = new \stdClass();
        if ($response->body->respuesta == '00'){
            $result->success = true;
        } else {
            $result->success = false;
            if ($response->body->respuesta == '6'){
                $result->status = 'incompleted';
                $result->message = $response->body->error;
            } else {
                $result->status = 'rejected'; // respuesta = 99
                $result->message = $response->body->error;
            }
        }

        return $result;

    }

    private function getDate(){
        $date = gmdate("D, d M Y H:i:s", time())." GMT";
        return $date;
    }

    private function getSignature($message){
        $signature = hash_hmac('sha1', $message, $this->gatewaySecret, true);
        $encodedSignature = base64_encode($signature);

        return $encodedSignature;
    }

    private function getHeader($signedMessage){
        $header = "PP " . $this->gatewayKey . ":" . $signedMessage;
        return $header;
    }

    private function sendRequest($url, $date, $header, $body, $method = 'post'){
        if ($method == 'post'){
            $response = Request::post($url);
        } else {
            $response = Request::get($url);
        }

        $response = $response->addHeader('Fecha', $date)    // Or use the addHeader method
                             ->addHeader('Autorizacion', $header)
                             ->addHeader('Accept', 'application/json')
                             ->body(json_encode($body))
                             ->sendsJson()
                             ->send();

        return $response;
    }

    public function getType(){
        return self::PAYMENT_METHOD_TYPE;
    }

}
