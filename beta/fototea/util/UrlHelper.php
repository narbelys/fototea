<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rreimi
 * Date: 5/26/14
 * Time: 2:44 AM
 * To change this template use File | Settings | File Templates.
 */

namespace Fototea\Util;
use Fototea\Config\FConfig;
use Fototea\Models\Notification;

class UrlHelper {

    /**
     * Get project url
     *
     * @param $projectId
     * @return string
     */
    public static function getProjectUrl($projectId){
        return self::getUrl('proyecto?id=' . $projectId);
    }

    public static function getLoginUrl(){
        return self::getUrl('login');
    }

    public static function getProfileUrl($userActCode = ''){
        if ($userActCode != ''){
            return self::getUrl('perfil?us=' . $userActCode);
        }
        return self::getUrl('perfil');
    }

    public static function getPortfolioUrl($userActCode = ''){
        if ($userActCode != ''){
            return self::getUrl('perfil?us='. $userActCode .'&act=portafolio');
        }
        return self::getUrl('perfil?act=portafolio');
    }

    /**
     * Get notification url base on type and data
     *
     * @param $type
     * @param $data
     * @return string
     */
    public static function getNotificationUrl($type, $data) {

        switch($type){
            case Notification::TYPE_COMMENT:
                $data = json_decode($data);
                $hash = '#';
                $hash .= 'oid:'.$data->offer_id;
                $url = self::getProjectUrl($data->project_id) . $hash;

                //http://dev.fototea.com/beta/fototea/proyecto?id=1#oid:5

                break;
            case Notification::TYPE_OFFER:
            case Notification::TYPE_MODIFIED_OFFER:
                $data = json_decode($data);
                $hash = '#';
                $hash .= 'oid:'.$data->offer_id;
                $url = self::getProjectUrl($data->project_id) . $hash;
                break;

            case Notification::TYPE_PROJECT_AWARDED:
            case Notification::TYPE_DENIED_OFFER:
                $data = json_decode($data);
                $url = self::getProjectUrl($data->project_id);
                break;

            default:
                $url = '';
                break;
        }
        return $url;

    }

    /**
     * Get full url to path
     *
     * @param null $path
     * @param bool $refreshCache
     * @return string
     */
    public static function getUrl($path = null, $refreshCache = false) {
        return FConfig::getUrl($path, $refreshCache);
    }

    public static function getThumbUrl($imgBaseUrl, $width, $height, $refreshCache = false){
        FConfig::getThumbUrl($imgBaseUrl, $width, $height, $refreshCache);
    }

    public static function getAlbumThumbUrl($imgBaseUrl, $width, $height, $refreshCache = false){
        $url = 'thumb.php?w='.$width . '&h=' . $height . '&url=' . $imgBaseUrl . '&mode=' . ImageHelper::MODE_CROP_CENTER ;

        if ($refreshCache) {
            $url .= '&refresh=true';
        }
        return self::getUrl($url, $refreshCache);
    }

    public static function getBasePath() {
        return FConfig::getBasePath();
    }

    public static function getUserProfilePath($userId) {
        return FConfig::getBasePath('/profiles/' . sha1($userId) . "/");
    }
}