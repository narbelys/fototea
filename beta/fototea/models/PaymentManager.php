<?php
/**
 * Created by PhpStorm.
 * User: jose
 * Date: 6/15/14
 * Time: 10:21 PM
 */

namespace Fototea\Models;

use Fototea\Models\Order;
use Fototea\Models\Payment;
use Fototea\Models\PuntoPagos;

class PaymentManager {

    const GATEWAY_TRANSACTION_STATUS_OK = 1;
    const GATEWAY_TRANSACTION_STATUS_ERROR = 0;

    private $app;
    private $method; //Instancia de PuntoPago
    private $payment;

    public function __construct($app, $type) {
        $this->app = $app;

        if ($type == PuntoPagos::PAYMENT_METHOD_TYPE) {
            $this->method = new PuntoPagos();
        }
    }

    public function createPayment($order) {
        $result = $this->method->createTransaction($order->id, $order->total);

        if ($result->success == false){
            return $result;
        }

        //Crear un registro en payment basado en status
        $paymentMethod = $this->method->getType();
        $payment = Payment::create($order->id, $result->gateway_id, $paymentMethod);

        $this->payment = $payment;

        //Retorna el resultado true | false
        return $result;
    }

    public function loadByGatewayId($id) {
        $this->payment = $this->app->getModel('Payment')->getPaymentByGatewayId($id);
    }

    public function updateStatus() {
        if (!$this->payment) {
            return false;
        }

        $order = Order::getOrder($this->payment->order_id);

        // Retrieve transaction from gateway
        $result = $this->method->getTransaction($this->payment->gateway_id, $this->payment->order_id, $order->total);

        if ($result->success) {
            $this->payment->set('status', Payment::PAYMENT_STATUS_APPROVED);
        } else {
            if ($result->status == 'incompleted'){
                $this->payment->set('status', Payment::PAYMENT_STATUS_INCOMPLETED);
            } else {
                $this->payment->set('status', Payment::PAYMENT_STATUS_REJECTED);
            }
        }

        $this->payment->save();
    }

//    public function getRedirectUrl() {
//        $this->method->getRedirectUrl();
//    }

    public function getStatus() {
        if (!$this->payment) {
            return false;
        }

        return $this->payment->get('status');
    }

    public function getOrderId() {
        return $this->payment->order_id;
    }

} 