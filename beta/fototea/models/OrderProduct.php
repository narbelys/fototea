<?php

/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 6/14/14
 * Time: 12:06 PM
 */

namespace Fototea\Models;

use Fototea\Util\DateHelper;
use \ORM;

class OrderProduct {

    private static $table = 'order_product';

    /**
     * @param $id
     * @return bool|ORM
     */
    public static function getOrderProduct($id) {
        $list = ORM::for_table(self::$table)->select('*');
        return $list->find_one($id);
    }

    /**
     * @param $name
     */
    public static function create($orderId, $products){

        ORM::get_db()->beginTransaction();

        foreach ($products as $prod){
            $orderProduct = ORM::for_table(self::$table)->create();
            $orderProduct->subtotal = $prod->price;
//            $product->tax
            $orderProduct->order_id = $orderId;
            $orderProduct->product_id = $prod->id;
            $orderProduct->data = $prod->data;
            $orderProduct->save();
        }

        ORM::get_db()->commit();

//        return true;
    }

    public static function getProductsByOrderId($orderId){
        $orderProducts = ORM::for_table(self::$table)->select('*');
        $orderProducts->where('order_id', $orderId);
        return $orderProducts->find_many();
    }

    public static function getTable() {
        return self::$table;
    }

}