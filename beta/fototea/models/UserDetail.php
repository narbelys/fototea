<?php
/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 6/07/14
 * Time: 1:58 AM
 */

namespace Fototea\Models;

use \ORM;

class UserDetail {

    const USER_DETAIL_PROFILE_IMAGE = '1';
    const USER_DETAIL_DESCRIPTION = '2';
    const USER_DETAIL_ADDRESS = '3';
    const USER_DETAIL_ZIP_CODE = '4';
    const USER_DETAIL_COUNTRY = '5';
    const USER_DETAIL_PHONE = '6';
    const USER_DETAIL_MOBILE_PHONE = '7';
//    const USER_DETAIL_TWITTER_PROFILE = '8'; // No se esta
//    const USER_DETAIL_FACEBOOK_PROFILE = '9'; // No se esta
    const USER_DETAIL_CITY = '10';
    const USER_DETAIL_CAMERA = '11';
    const USER_DETAIL_GLASSES = '12';
    const USER_DETAIL_EQUIPMENT = '13';
//    const USER_DETAIL_EXPERIENCE_YEARS = '14'; // No se esta usando
    const USER_DETAIL_INTERESTS = '15'; // Este no se agrega en los arreglos por defecto (tiene trato especial)
    const USER_DETAIL_COVER_IMAGE = '16';
    const USER_DETAIL_PAYMENT_USER = '17';
    const USER_DETAIL_PHOTOGRAPHY_SCHOOL = '18';
    const USER_DETAIL_MORE_EDUCATION = '19';
    const USER_DETAIL_LABORAL_EXPERIENCE = '20';
    const USER_DETAIL_HABILITIES = '21';
    const USER_DETAIL_LANGUAGES = '22';
    const USER_DETAIL_RUT = '23';

    private static $table = 'user_det';

    private static $clientInfo = array(
        USER_DETAIL_PROFILE_IMAGE, USER_DETAIL_DESCRIPTION, USER_DETAIL_ADDRESS, USER_DETAIL_ZIP_CODE,
        USER_DETAIL_COUNTRY, USER_DETAIL_PHONE, USER_DETAIL_MOBILE_PHONE, USER_DETAIL_CITY, USER_DETAIL_COVER_IMAGE
    );

    private static $photographerInfo = array(
        USER_DETAIL_CAMERA, USER_DETAIL_GLASSES, USER_DETAIL_EQUIPMENT, USER_DETAIL_PAYMENT_USER,
        USER_DETAIL_PHOTOGRAPHY_SCHOOL, USER_DETAIL_MORE_EDUCATION, USER_DETAIL_LABORAL_EXPERIENCE,
        USER_DETAIL_HABILITIES, USER_DETAIL_LANGUAGES, USER_DETAIL_RUT
    );

    public static function init($userId, $userType){
        $data = array();

        foreach (self::$clientInfo as $info){
            $data[] = $info;
        }

        if ($userType == User::USER_TYPE_PHOTOGRAPHER){
            foreach (self::$photographerInfo as $info){
                $data[] = $info;
            }
        }

        foreach ($data as $info){
            $userDet = ORM::for_table(self::$table)->create();
            $userDet->id_user = $userId;
            $userDet->id_data = constant('self::'.$info);
            $userDet->description = '';
            $userDet->save();
        }

        return true;
    }

    public static function update($userId, $data){
        ORM::get_db()->beginTransaction();

        foreach ($data as $key => $value){
            $pdo = ORM::get_db();
            $raw_query = "UPDATE ".self::$table." SET description = :data WHERE id_user = :uid AND id_data = :iddata";
            $raw_parameters = array('data' => $value, 'uid' => $userId, 'iddata' => $key);
            $statement = $pdo->prepare($raw_query);
            $statement->execute($raw_parameters);
        }

        ORM::get_db()->commit();
    }

    public static function updateInterests($userId, $interests){
        ORM::get_db()->beginTransaction();

        // Delete old user's interests
        $pdo = ORM::get_db();
        $raw_query = "DELETE FROM ".self::$table." WHERE id_user = :uid AND id_data = ". self::USER_DETAIL_INTERESTS;
        $raw_parameters = array('uid' => $userId);
        $statement = $pdo->prepare($raw_query);
        $statement->execute($raw_parameters);

        foreach ($interests as $value){
            $userDetail = ORM::for_table(self::$table)->create();
            $userDetail->id_user = $userId;
            $userDetail->id_data = self::USER_DETAIL_INTERESTS;
            $userDetail->description = $value;
            $userDetail->save();
        }

        ORM::get_db()->commit();
    }

}

