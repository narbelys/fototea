<?php
/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 6/12/14
 * Time: 1:59 PM
 */

namespace Fototea\Models;

use \Fototea\Models\IPaymentMethod;

class Transfer implements IPaymentMethod {

    const PAYMENT_METHOD_TYPE = 'Transfer';

    public function createTransaction($orderId, $amount){

    }

    public function getTransaction($token, $orderId, $amount){

    }

    public function getType(){
        return self::PAYMENT_METHOD_TYPE;
    }

}
