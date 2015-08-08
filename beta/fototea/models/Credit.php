<?php

/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 5/01/14
 * Time: 12:31 AM
 */

namespace Fototea\Models;
use Fototea\Util\DateHelper;
use Fototea\Config\FConfig;
use \ORM;

include_once '../scripts/libSM.php';

class Credit {

    const CREDIT_TABLE = 'credits';

    /**
     * Check if there is an available credit and returns the next available credit
     *
     * @param $userId
     * @return bool | next available credit id
     */
    public static function checkNextAvailableCredit($userId){
        $credit = ORM::for_table(self::CREDIT_TABLE)
            ->where('user_id', $userId)
            ->where_null('used_date')
            ->where_null('album_id')
            ->limit(1)
            ->find_one();

        if ($credit == false){
            return false;
        } else {
            return $credit->id;
        }
    }

    /**
     * Return qty of available credits assigned to the user.
     * @param $userId
     * @return int
     */
    public static function getAvailableCredits($userId) {
        $list = ORM::for_table(self::CREDIT_TABLE);
        $list->where('user_id', $userId);
        $list->where_null('used_date');
        $list->where_null('album_id');
        return $list->count();
    }

    /**
     * Return quantity of granted credits (without the reassigned ones) to the user including the used credits.
     * @param $userId
     * @return int
     */
    public static function getOriginalCredit($userId) {
        $list = ORM::for_table(self::CREDIT_TABLE);
        $list->where('user_id', $userId);
        $list->where_null('reasigned_credit_id');
        return $list->count();
    }

    /**
     * Mark the use of one credit
     *
     * @param $userId
     * @param $albumId
     * @return bool
     */
    public static function markCreditUsed($userId, $albumId){

        if ($userId == null || $albumId == null){
            return false;
        }

        $creditId = self::checkNextAvailableCredit($userId);

        if ($creditId == false){
            return false;
        }

        $credit = ORM::for_table(self::CREDIT_TABLE)->find_one($creditId);
        $credit->used_date = DateHelper::getCurrentDateTime();
        $credit->album_id = $albumId;
        $credit->save();

        return $credit;
    }

    /**
     * Used to create a new credit.
     * @return bool|int
     */
    public static function newCredit($userId, $reasignedCreditId = null){

        if ($userId == null){
            return false;
        }

        $credit = ORM::for_table(self::CREDIT_TABLE)->create();
        $credit->user_id = $userId;
        $credit->date = DateHelper::getCurrentDateTime();
        $credit->reasigned_credit_id = $reasignedCreditId;
        $credit->save();

        if ($credit->id){
            return $credit->id;
        } else {
            return false;
        }

    }

    /**
     * Reassign credit to be available again.
     * @param $userId
     * @param $albumId
     * @return bool|int
     */
    public static function renewCredit($userId, $albumId){

        if ($userId == null || $albumId == null){
            return false;
        }

        $credit = ORM::for_table(self::CREDIT_TABLE)
            ->where('user_id', $userId)
            ->where('album_id', $albumId)
            ->find_one();

        if ($credit == false){
            return false;
        } else {
            $creditId = self::newCredit($userId, $credit->id);

            return $creditId;
        }

    }

    public static function getRealAvailableCredits($userId, $qtyAlbums){

        if ($userId == null || $qtyAlbums === null){
            return false;
        }

        $originalCredit = self::getOriginalCredit($userId);
        $creditAvailable = max(0, (FConfig::getValue('defaultAlbumsByPhotographer') + $originalCredit) - $qtyAlbums);

        return $creditAvailable;
    }

} 