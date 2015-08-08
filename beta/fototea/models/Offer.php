<?php

/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 5/01/14
 * Time: 12:31 AM
 */

namespace Fototea\Models;

use \ORM;

class Offer {

    const STATUS_AWARDED = 'S';
    const STATUS_NOT_AWARDED = 'N';

    private static $table = 'ofertas';

    public static function getUserOffers($userId, $status, $extraConditions = '') {
        $list = ORM::for_table(self::$table)->select('*');
        $list->where('user_id', $userId);

        if (is_array($status) && (count($status) > 0)){
            $list->where_in('pro_status', $status);
        }

        //Beware of sql inyection
        if (!empty($extraConditions)) {
            $list->where_raw($extraConditions);
        }

        return $list->find_many();
    }

    public static function getOfferByProjectId($projectId, $awarded = '') {
        $list = ORM::for_table(self::$table)->select('*');
        $list->where('pro_id', $projectId);

        if (!empty($awarded)) {
            $list->where('awarded', $awarded);
        }

        return $list->find_many();
    }

    /**
     * @param $id
     * @return bool|ORM
     */
    public static function getOffer($id) {
        return ORM::for_table(self::$table)->find_one($id);
    }

    public static function save($id, $data) {
        $offer = ORM::for_table(self::$table)->find_one($id);
        $offer->set($data);
        $offer->save();
        return $offer;
    }

    public static function updateOffer($id, $data) {
        self::save($id, $data);
    }

    public static function getTable() {
        return self::$table;
    }

}