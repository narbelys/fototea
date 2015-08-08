<?php
/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 5/01/14
 * Time: 12:31 AM
 */

namespace Fototea\Models;

use Fototea\Util\StringHelper;
use Fototea\Util\DateHelper;
use \ORM;
use Fototea\Config\FConfig;

class User {

    const USER_TYPE_PHOTOGRAPHER = '1';
    const USER_TYPE_CLIENT       = '2';

    const USER_STATUS_ACTIVE       = 'S';
    const USER_STATUS_INACTIVE     = 'N';

    const USER_CLIENT_UNCOMPLETED_PROFILE = 1;
    const USER_PHOTOGRAPHER_UNCOMPLETED_PROFILE = 2;
    const USER_PHOTOGRAPHER_LEFT_PREFERENCES = 1;
    const USER_COMPLETED_PROFILE = 0;

    const PROFILE_DIRECTION = 'direccion';
    const PROFILE_CITY = 'ciudad';
    const PROFILE_MOVIL = 'movil';

    private static $table = 'user';

    public static function getUserById($userId){
        $user = ORM::for_table(self::$table)->find_one($userId);

        return $user;
    }

    public static function getUserByEmail($email){
        $user = ORM::for_table(self::$table)
                        ->where('user', $email)
                        ->find_one();

        return $user;
    }

    public static function getUserToConfirmNewEmail($actCode, $newEmailCode){
        $user = ORM::for_table(self::$table)
            ->where('act_code', $actCode)
            ->where('new_email_code', $newEmailCode)
            ->find_one();

        return $user;
    }

    public static function getUserInfo($id, $fields = array()) {

        $usr_info = ORM::for_table(self::$table)->find_one($id);

        if ($usr_info == null) {
            return false;
        }

        $user = array();

        //User table fields
        $user['id'] = $usr_info->id;
        $user['user_type'] = $usr_info->user_type;
        $user['email'] = $usr_info->user;
        $user['new_email'] = $usr_info->new_email;
        $user['new_email_code'] = $usr_info->new_email_code;
        $user["name"] = $usr_info->name;
        $user['lastname'] = $usr_info->lastname;
        $user['user_dob'] = DateHelper::getShortDate($usr_info->dob, 'd/m/Y');
        $user['act']= $usr_info->act;
        $user["act_code"] = $usr_info->act_code;
        $user["profile_completed"] = $usr_info->profile_completed;
        $user["wizard_completed"] = $usr_info->wizard_completed;
        $user["wizard_contact_creative_completed"] = $usr_info->wizard_contact_creative_completed;
        $user['full_name'] = ucwords($user["name"] . " " . $user['lastname']);

        //Gender
        if($usr_info->gender == "H"){
            $gender = "Hombre";
        }else{
            $gender = "Mujer";
        }
        $user['sex']= $gender;

//        $user['dob']= DateHelper::getLongDate($usr_info->dob);

        //Process only desired fields
        if (in_array('*', $fields) || in_array('descripcion', $fields)) {
            $descripcion = self::getUserData($id, "2");
            $user['descripcion'] = $descripcion->description;
        }

        if (in_array('*', $fields) || in_array('user_img', $fields)) {
            $user_img = self::getUserData($id, "1");
            $user['user_img']= $user_img->description;
        }

        if (in_array('*', $fields) || in_array('direccion', $fields)) {
            $direccion = self::getUserData($id, "3");
            $user['direccion'] = $direccion->description;
        }

        if (in_array('*', $fields) || in_array('ciudad', $fields)) {
            $ciudad = self::getUserData($id, "10");
            $user['ciudad'] = $ciudad->description;
        }

        if (in_array('*', $fields) || in_array('cp', $fields)) {
            $cp = self::getUserData($id, "4");
            $user['cp'] = $cp->description;
        }

        if (in_array('*', $fields) || in_array('pais', $fields)) {
            $pais = self::getUserData($id, "5");
            $rs_paisf = Country::loadCountriesByIso($pais->description);
            $user['pais'] = utf8_encode($rs_paisf->nombre);
            $user['pais_ab'] = utf8_encode($rs_paisf->iso);
        }

        if (in_array('*', $fields) || in_array('telefono', $fields)) {
            $telefono = self::getUserData($id, "6");
            $user['telefono'] = $telefono->description;
        }

        if (in_array('*', $fields) || in_array('movil', $fields)) {
            $movil =self::getUserData($id, "7");
            $user['movil'] = $movil->description;

        }

        //Todocheck  if in use
//        if (in_array('*', $fields) || in_array('exp', $fields)) {
//            $exp = self::getUserData($id, "14");
//            $user['exp'] = $exp->description;
//        }

        if (in_array('*', $fields) || in_array('cam', $fields)) {
            $cam = self::getUserData($id, "11");
            $user['cam'] = json_decode($cam->description);
        }

        if (in_array('*', $fields) || in_array('rut', $fields)) {
            $rut = self::getUserData($id, "23");
            $user['rut'] = $rut->description;
        }

        if (in_array('*', $fields) || in_array('lentes', $fields)) {
            $lentes = self::getUserData($id, "12");
            $user['lentes'] = json_decode($lentes->description);
        }

        if (in_array('*', $fields) || in_array('', $fields)) {
            $equip = self::getUserData($id, "13");
            $user['equip'] = json_decode($equip->description);
        }

        //Deprecated
//        if (in_array('*', $fields) || in_array('user_cover', $fields)) {
//            $cover = self::getUserData($id, "16");
//            $user['user_cover'] = $cover->description;
//        }

        //TODO Used for paypal account, check if needed
        if (in_array('*', $fields) || in_array('user_pago', $fields)) {
            $user_pago = self::getUserData($id, "17");
            $user['user_pago'] = $user_pago->description;
        }

        if (in_array('*', $fields) || in_array('escuela-fotografia', $fields)) {
            $escuelaFotografia = self::getUserData($id, "18");
            $user['escuela-fotografia'] = $escuelaFotografia->description;
        }

        if (in_array('*', $fields) || in_array('mas-educacion', $fields)) {
            $masEducacion = self::getUserData($id, "19");
            $user['mas-educacion'] = $masEducacion->description;
        }

        if (in_array('*', $fields) || in_array('experiencia-laboral', $fields)) {
            $experienciaLaboral = self::getRecentUserData($id, "20");
            $user['experiencia-laboral'] = json_decode($experienciaLaboral->description);
        }

        if (in_array('*', $fields) || in_array('idiomas', $fields)) {
            $idiomas = self::getUserData($id, "22");
            $user['idiomas'] = json_decode($idiomas->description);
        }

        if (in_array('*', $fields) || in_array('habilidades', $fields)) {
            $habilidades = self::getUserData($id, "21");
            $user['habilidades'] = json_decode($habilidades->description);
        }

        //Cover and profile image fields
        if (file_exists(FConfig::getBasePath()."/profiles/".sha1($usr_info->id)."/profile.jpg")){
            $user['profile_image_url'] = "profiles/".sha1($usr_info->id)."/profile.jpg";
        } else {
            if ($user['user_type'] == User::USER_TYPE_PHOTOGRAPHER) {
                $user['profile_image_url'] = "images/profile_default_photographer.jpg";
            } else {
                $user['profile_image_url'] = "images/profile_default_client.jpg";
            }
        }

        if (file_exists(FConfig::getBasePath()."/profiles/".sha1($usr_info->id)."/cover.jpg")){
            $user['cover_image_url'] = "profiles/".sha1($usr_info->id)."/cover.jpg";
        } else {
            $user['cover_image_url'] = "images/cover_default.jpg";
        }

        return $user;

    }

    public static function getUserData($userId, $dataId){
        $usrData = ORM::for_table('user_det')->where('id_user', $userId)->where('id_data', $dataId)->find_one();
        return $usrData;
    }

    public static function getRecentUserData($userId, $dataId){
//        $usr_q = listAll("user_det", "WHERE id_user = '$idUser' AND id_data = '$idData' ORDER BY id DESC LIMIT 1");
//
//        $usr_data = mysql_fetch_object($usr_q);
//        return $usr_data;
        $usrData = ORM::for_table('user_det')
            ->where('id_user', $userId)
            ->where('id_data', $dataId)
            ->order_by_desc('id')
            ->find_many();
        return $usrData;

    }

    public static function updateUser($userId, $data = array()){
        $user = ORM::for_table(self::$table)->find_one($userId);

        foreach($data as $key => $value){
            if ($key == 'password'){
                $encryptedNewPass = self::generatePass($value, $user->salt);
                $user->password = $encryptedNewPass;
            } else {
                $user->$key = $value;
            }
        }

        $user->save();
        return $user;
    }

    public static function create($name, $lastName, $email, $password, $userType){
        $userSalt = self::generateSalt();
        $userPass = self::generatePass($password, $userSalt);

        $user = ORM::for_table(self::$table)->create();
        $user->name = $name;
        $user->lastname = $lastName;
        $user->dob = '0000-00-00 00:00:00';
        $user->user = $email;
        $user->password = $userPass;
        $user->salt = $userSalt;
        $user->user_type = $userType;
        $user->set_expr('cdate', 'NOW()');
        $user->last_login = '0000-00-00 00:00:00'; // TODO: PENSAR SI DEJAR ASI
        $user->act = self::USER_STATUS_INACTIVE;
        $user->act_code = StringHelper::generateRandomString();
        if ($userType == self::USER_TYPE_PHOTOGRAPHER){
            $user->profile_completed = self::USER_PHOTOGRAPHER_UNCOMPLETED_PROFILE;
        } else {
            $user->profile_completed = self::USER_CLIENT_UNCOMPLETED_PROFILE;
        }

        $user->save();

        return $user;
    }

    public static function checkCurrentPassword($userId, $currentPassword){
        $user = self::getUserById($userId);
            $encryptedCurrentPass = self::generatePass($currentPassword, $user->salt);

        if ($encryptedCurrentPass == $user->password){
            return true;
        } else {
            return false;
        }
    }

    public static function checkEmailExists($email){
        $user = ORM::for_table(self::$table)
            ->where('user', $email)
            ->find_one();

        return $user;
    }

    private function generatePass($password, $userSalt){
        $passwordEnc = sha1($password);
        $userPass = sha1($userSalt.$passwordEnc);

        return $userPass;
    }

    private function generateSalt(){
        return sha1(time());
    }

}

