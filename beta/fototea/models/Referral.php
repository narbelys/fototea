<?php

namespace Fototea\Models;

use Fototea\Config\FConfig;

include_once '../scripts/libSM.php';


/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 4/30/14
 * Time: 11:54 PM
 */

class Referral {

    const REFERRALS_TABLE = 'referrals';

    const MEDIA_FACEBOOK = 'facebook';
    const MEDIA_TWITTER = 'twitter';
    const MEDIA_GOOGLEPLUS = 'googleplus';
    const MEDIA_INSTAGRAM = 'instagram';
    const MEDIA_PINTEREST = 'pinterest';
    const MEDIA_EMAIL = 'email';
    const MEDIA_UNKNOWN = 'unknown';

    public $id;
    public $referringUser;
    public $referredUser;
    public $media;
    public $date;
    public $exchangeDate;
    public $exchanged = false;

    public static function checkAvailableReferral($userId){
        $sql = "SELECT id FROM ". self::REFERRALS_TABLE ." WHERE referring_user = ". $userId ." AND exchange_date IS NULL AND exchanged = false LIMIT ". FConfig::getValue('creditsByAlbum');
        $availableReferrals = mysql_query($sql);
        $qty = mysql_num_rows($availableReferrals);

        if ($qty == FConfig::getValue('creditsByAlbum')){
            $ids = array();

            while ($referral = mysql_fetch_object($availableReferrals)){
                $ids[] = $referral->id;
            }

            return $ids;
        } else {
            return false;
        }
    }

    public static function markReferralAsExchanged($userId){

        if ($userId == null){
            return false;
        }

        $creditIds = self::checkAvailableReferral($userId);

        if ($creditIds == false){
            return false;
        }

        $result = updateTable(self::REFERRALS_TABLE, 'exchange_date = \''. date('Y-m-d H:i:s') .'\', exchanged = true', 'id IN('.implode(',', $creditIds).')');

        return $result;
    }

    /**
     * Used to create a new referral.
     * @return bool|int
     */
    public function newReferral(){

        if ($this->referringUser == null || $this->referredUser == null || $this->media == null){
            return false;
        }

        $date = date('Y-m-d H:i:s');

        $insert = "INSERT INTO ".self::REFERRALS_TABLE." (referring_user, referred_user, media, date) VALUES (".$this->referringUser.",".$this->referredUser.",'".$this->media."','".$date."')";
        $insert_query = mysql_query($insert);

        if ($insert_query){
            $insert_id = mysql_insert_id();
            return $insert_id;
        } else {
            return false;
        }

    }

    public static function getReferralUrl($media){

    }

} 