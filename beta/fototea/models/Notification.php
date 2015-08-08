<?php
/**
 * Created by JetBrains PhpStorm.
 * User: rreimi
 * Date: 5/25/14
 * Time: 10:34 PM
 * To change this template use File | Settings | File Templates.
 */

namespace Fototea\Models;

use Fototea\Config\FConfig;
use Fototea\Util\UrlHelper;
use \ORM;

class Notification {

    //Types
    const TYPE_COMMENT = 'C';
    const TYPE_OFFER   = 'O';
    const TYPE_PROJECT_AWARDED   = 'PA';
    const TYPE_DENIED_OFFER   = 'DO';
    const TYPE_MODIFIED_OFFER = 'MO';

    //Statuses
    const STATUS_READ  = 'S';
    const STATUS_UNREAD  = 'N';

    private static $table = 'notificaciones';

    public static function getStatusName($status){
        switch($status){
            case self::TYPE_COMMENT:
                return 'Comentario';
            case self::TYPE_OFFER:
                return 'Oferta';
            case self::TYPE_PROJECT_AWARDED:
                return 'Proyecto Adjudicado';
            case self::TYPE_DENIED_OFFER:
                return 'Oferta No Seleccionada';
            case self::TYPE_MODIFIED_OFFER:
                return 'Oferta Modificada';
        }
    }

    public static function markAsRead($id){
        $notificacion = \ORM::for_table('notificaciones')->find_one($id);
        $notificacion->set('leido', 'S');
        $notificacion->save();
    }

    public static function getUserNotifications($userId, $includeRead = false) {
        $list = ORM::for_table(self::$table)->select('*');
        $list->where('user_id', $userId);
        if ($includeRead == false){
            $list->where('leido', self::STATUS_UNREAD);
        }

        $list = $list->find_many();

        foreach ($list as $item) {
            $item->smart_url = UrlHelper::getNotificationUrl($item->type, $item->data);
        }
        return $list;
    }

    public static function create($userId, $notificationText, $notificationType, $data = null){
        $notification = ORM::for_table(self::$table)->create();

        $notification->user_id = $userId;
        $notification->notificacion = $notificationText;
        $notification->cdate = date("Y-m-d H:i:s");
        $notification->leido = 'N';
        $notification->type = $notificationType;
        $notification->data = $data;

        return $notification->save();
    }

}