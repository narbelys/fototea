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
class Country {

    private static $table = 'paises';

    /**
     * Load list of countres
     *
     * @return array|\IdiormResultSet
     */
    public static function loadCountries() {
        $list = ORM::for_table(self::$table)->select('*');
        $list->order_by_asc('nombre');
        return $list->find_many();
    }

    public static function loadCountriesByIso($iso) {
        $list = ORM::for_table(self::$table)->select('*');
        $list->where('iso', $iso);
        return $list->find_one();
    }

}

