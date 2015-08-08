<?php

/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 5/01/14
 * Time: 12:31 AM
 */

namespace Fototea\Models;

use \ORM;

//TODO Cache this
class Category {

    private static $table = 'categories';

    const PHOTO_PRODUCTION = 1;
    const PHOTO_EDITION = 2;
    const VIDEO_PRODUCTION_AND_EDITION = 3;

    /**
     * Load main categories from categories table
     *
     * @return array|\IdiormResultSet
     */
    public static function loadCategories() {
        $list = ORM::for_table(self::$table)->select('*');
        $list->order_by_asc('order');
        return $list->find_many();
    }

    /**
     * Load category by Id
     * @param $categoryId
     * @return bool|ORM
     */
    public static function loadCategoryById($categoryId){
        $category = ORM::for_table(self::$table)->find_one($categoryId);
        return $category;
    }

}

