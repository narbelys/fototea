<?php
/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 6/15/14
 * Time: 11:17 PM
 */

namespace Fototea\Models;

interface IPaymentMethod {

    const GATEWAY_RESPONSE_OK = 'ok';
    const GATEWAY_RESPONSE_ERROR = 'error';

    public function createTransaction($orderId, $amount);

    public function getTransaction($token, $orderId, $amount);

    public function getType();

}
