<?php
/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 6/15/14
 * Time: 2:24 PM
 */

namespace Fototea\Models;

use Fototea\Models\IPaymentMethod;

class PaymentMethod {

    private $paymentMethod;

    public function setPaymentMethod(IPaymentMethod $paymentMethod){
        $this->paymentMethod = $paymentMethod;
    }
//
//    public function createTransaction($orderId, $amount){
//        return $this->paymentMethod->createTransaction($orderId, $amount);
//    }

    public function getPaymentMethod(){
        return $this->paymentMethod;
    }

} 