<?php

/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 6/14/14
 * Time: 11:22 PM
 */

namespace Fototea\Models;

use Fototea\Util\DateHelper;
use \ORM;

class Payment {

    private static $table = 'payment';

    const PAYMENT_STATUS_PENDING = 'Pending';
    const PAYMENT_STATUS_REJECTED = 'Rejected';
    const PAYMENT_STATUS_APPROVED = 'Approved';
    const PAYMENT_STATUS_INCOMPLETED = 'Incompleted';

    /**
     * @param $id
     * @return bool|ORM
     */
    public static function getPayment($id) {
        $payment = ORM::for_table(self::$table)->select('*');
        return $payment->find_one($id);
    }

    /**
     * @param $gatewayId
     * @return bool|ORM
     */
    public static function getPaymentByGatewayId($gatewayId) {
        $payment = ORM::for_table(self::$table)->select('*');
        $payment->where('gateway_id', $gatewayId);
        return $payment->find_one();
    }


    /**
     * @param $userId
     * @param $totalAmount
     * @return $this
     */
    public static function create($orderId, $gatewayId, $paymentMethod){
        $payment = ORM::for_table(self::$table)->create();
        $payment->type = $paymentMethod;
        $payment->date = DateHelper::getCurrentDateTime();
        $payment->status = self::PAYMENT_STATUS_PENDING;
        $payment->gateway_id = $gatewayId;
        $payment->order_id = $orderId;
        $payment->save();

        return $payment;
    }

    public static function getTable() {
        return self::$table;
    }

}