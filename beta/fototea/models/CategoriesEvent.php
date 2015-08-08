<?php

/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 5/01/14
 * Time: 12:31 AM
 */

namespace Fototea\Models;

use \ORM;

class CategoriesEvent {

    private static $table = 'categories_event';

    public static function getListByCategory($categoryId) {
        $list = ORM::for_table(self::$table)->select('*');
        $list->where('id_cat', $categoryId);
        $list->order_by_asc('description');
        return $list->find_many();
    }

    /**
     * @param $id
     * @return bool|ORM
     */
    public static function getOffer($id) {
        $list = ORM::for_table(self::$table)->select('*');
        return $list->find_one($id);
    }

    public static function getTable() {
        return self::$table;
    }

}

