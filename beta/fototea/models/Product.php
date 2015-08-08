<?php

/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 6/14/14
 * Time: 09:36 PM
 */

namespace Fototea\Models;

use \ORM;

class Product {

    const PRODUCT_ADJUDICAR_ID = 1;

    private static $table = 'product';


    /**
     * @param $id
     * @return bool|ORM
     */
    public static function getProduct($id) {
        $list = ORM::for_table(self::$table)->select('*');
        return $list->find_one($id);
    }

    /**
     * @param $ids
     * @return bool|ORM
     */
    public static function getProducts($ids) {
        $list = ORM::for_table(self::$table)->select('*');
        $list->where_in('id', $ids);
        return $list->find_many();
    }

    /**
     * @param $name
     */
    public static function create($name){
        $product = ORM::for_table(self::$table)->create();
        $product->name = $name;
        $product->save();

        return $product;
    }

    public static function getTable() {
        return self::$table;
    }

}