<?php

/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 6/14/14
 * Time: 10:02 PM
 */

namespace Fototea\Models;

use Fototea\Util\DateHelper;
use \ORM;

class Order {

    private static $table = 'order';

    const ORDER_STATUS_IN_PROGRESS = 'In_Progress';
    const ORDER_STATUS_COMPLETED = 'Completed';
    const ORDER_STATUS_FAILED = 'Failed';

    /**
     * @param $id
     * @return bool|ORM
     */
    public static function getOrder($id) {
        $list = ORM::for_table(self::$table)->select('*');
        return $list->find_one($id);
    }

    /**
     * @param $name
     */
    public static function create($userId, $totalAmount){
        $order = ORM::for_table(self::$table)->create();
        $order->user_id = $userId;
        $order->status = self::ORDER_STATUS_IN_PROGRESS;
        $order->date = DateHelper::getCurrentDateTime();
        $order->total = $totalAmount;
        $order->save();

        return $order;
    }

    public static function getTable() {
        return self::$table;
    }

}