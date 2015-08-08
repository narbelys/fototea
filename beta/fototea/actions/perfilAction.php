<?php
use Fototea\Config\FConfig;
use Fototea\Models\User;
use Fototea\Models\UserDetail;
use Fototea\Util\ImageHelper;
use Fototea\Util\FAnalytics;
use Fototea\Util\FMailer;
use Fototea\Util\StringHelper;
use Fototea\Util\UrlHelper;

require '../vendor/autoload.php';

include_once '../scripts/libSM.php';

define('DS', DIRECTORY_SEPARATOR);
error_reporting(E_ERROR);

$session = validaSession();

$action = $_REQUEST['act'];

if($action == "val_mail"){
    $mail = listAll("user","WHERE user = '".$_REQUEST['email']."'");
    $row = mysql_num_rows($mail);

    if($row > 0){
        $ee = 1;
    }else{
        $ee = 0;
    }
    $arreglo[] = array('resp' => $ee);
    echo json_encode($arreglo);
}

if($session == true){
	$userType = securityValidation($_COOKIE['id']);

    //TODO server side validations
    //TODO Use ORM here to avoid sql injection and improve code

	if ($action == "completarPerfil") {
        $user_gender = $_REQUEST['user_gender'];

        //Validate date
        $user_dob = str_replace('/', '-', $_POST['user_dob']);
        $user_dob = date('Y-m-d', strtotime($user_dob));

        $desc = $_REQUEST['user_descripcion'];
        $direccion = $_REQUEST['user_direccion'];
        $cp = $_REQUEST['user_cp'];
        $pais = $_REQUEST['user_pais'];
        $tel = $_REQUEST['user_telefono'];
        $movil = $_REQUEST['user_movil'];
        $city = $_REQUEST['user_city'];

        $id_user = getCurrentUser()->id;

        // Update detail user info
        $dataProfile = array(
            UserDetail::USER_DETAIL_PROFILE_IMAGE => null,
            UserDetail::USER_DETAIL_COVER_IMAGE => null,
            UserDetail::USER_DETAIL_DESCRIPTION => $desc,
            UserDetail::USER_DETAIL_ADDRESS => $direccion,
            UserDetail::USER_DETAIL_ZIP_CODE => $cp,
            UserDetail::USER_DETAIL_COUNTRY => $pais,
            UserDetail::USER_DETAIL_PHONE => $tel,
            UserDetail::USER_DETAIL_CITY => $city,
            UserDetail::USER_DETAIL_MOBILE_PHONE => $movil,
        );
        UserDetail::update($id_user, $dataProfile);

        // TODO: Usar ORM en la tabla user
        updateTable("user", "dob='$user_dob', gender='$user_gender', profile_completed=".(($userType == User::USER_TYPE_PHOTOGRAPHER)?User::USER_PHOTOGRAPHER_LEFT_PREFERENCES:User::USER_COMPLETED_PROFILE).", last_login=NOW()", "id=$id_user");
	
		if ($userType == User::USER_TYPE_PHOTOGRAPHER){
            $app->redirect($app->getHelper('UrlHelper')->getUrl('completarPreferencias'));
		} elseif($userType == User::USER_TYPE_CLIENT){
            // Event: Completar perfil y Completar perfil cliente
            $eventData = new stdClass();
            $eventData->user_id = $id_user;
            $eventData->user_type = $userType;
            $events = FAnalytics::getInstance();
            $events->trackEvent('Usuario', 'Completar perfil', json_encode($eventData));
            $events->trackEvent('Usuario', 'Completar perfil cliente', json_encode($eventData));

            $app->redirect($app->getHelper('UrlHelper')->getUrl('perfil'));
		}
	}
	
	if($action=="completarPreferencias"){
		if($userType == User::USER_TYPE_PHOTOGRAPHER){
            $camaraArray = $_REQUEST['user_camara'];
            $lentesArray = $_REQUEST['user_lentes'];
            $equipoArray = $_REQUEST['user_equipo'];
            $interes = $_REQUEST['user_interes'];
            $experiencia = $_REQUEST['user_experiencia'];
            $escuelaFotografia = $_REQUEST['user_escuela_fotografia'];
            $masEducacion = $_REQUEST['user_mas_educacion'];
            $experienciaLaboralEmpresa = $_REQUEST['user_experience_empresa'];
            $experienciaLaboralUbicacion = $_REQUEST['user_experience_localidad'];
            $idiomasArray = $_REQUEST['user_idiomas'];
            $habilidadesArray = $_REQUEST['user_habilidades'];
            $rut = $_REQUEST['user_rut'];

            $id_user = getCurrentUser()->id;

            $camara = array();
            foreach ($camaraArray as $i => $ele){
                if ($ele != ""){
                    $camara[] = $ele;
                }
            }

            $lentes = array();
            foreach ($lentesArray as $i => $ele){
                if ($ele != ""){
                    $lentes[] = $ele;
                }
            }

            $equipo = array();
            foreach ($equipoArray as $ele){
                if ($ele != ""){
                    $equipo[] = $ele;
                }
            }

            $experienciaLaboral = array();
            foreach ($experienciaLaboralEmpresa as $i => $ele){
                if ($ele != ""){
                    $experienciaLaboral[] = array('empresa' => $ele, 'localidad' => $experienciaLaboralUbicacion[$i]);
                }
            }

            $idiomas = array();
            foreach ($idiomasArray as $ele){
                if ($ele != ""){
                    $idiomas[] = $ele;
                }
            }

            $habilidades = array();
            foreach ($habilidadesArray as $ele){
                if ($ele != ""){
                    $habilidades[] = $ele;
                }
            }

            // Update detail user info
            $dataPreferences = array(
                UserDetail::USER_DETAIL_CAMERA => json_encode($camara),
                UserDetail::USER_DETAIL_GLASSES => json_encode($lentes),
                UserDetail::USER_DETAIL_EQUIPMENT => json_encode($equipo),
                UserDetail::USER_DETAIL_PHOTOGRAPHY_SCHOOL => $escuelaFotografia,
                UserDetail::USER_DETAIL_MORE_EDUCATION => $masEducacion,
                UserDetail::USER_DETAIL_LABORAL_EXPERIENCE => json_encode($experienciaLaboral),
                UserDetail::USER_DETAIL_LANGUAGES => json_encode($idiomas),
                UserDetail::USER_DETAIL_HABILITIES => json_encode($habilidades),
                UserDetail::USER_DETAIL_RUT => $rut,
            );
            UserDetail::update($id_user, $dataPreferences);

            // Update interests
            UserDetail::updateInterests($id_user, $interes);

            // TODO: Usar ORM en la tabla user
            updateTable("user", "profile_completed=".User::USER_COMPLETED_PROFILE, "id=$id_user");

            // Event: Completar perfil y Completar perfil fotografo
            $eventData = new stdClass();
            $eventData->user_id = $id_user;
            $eventData->user_type = $userType;
            $events = FAnalytics::getInstance();
            $events->trackEvent('Usuario', 'Completar perfil', json_encode($eventData));
            $events->trackEvent('Usuario', 'Completar perfil fotógrafo', json_encode($eventData));

            $app->redirect(UrlHelper::getPortfolioUrl());
		}
	}

	if ($action == 'skipCompleteProfile'){

        $currentUser = getCurrentUser();
        $profileCompleted = $currentUser->profile_completed - 1;

        updateTable("user", "profile_completed=".$profileCompleted, "id=$currentUser->id");

        if ($currentUser->user_type == User::USER_TYPE_PHOTOGRAPHER && $profileCompleted == User::USER_PHOTOGRAPHER_LEFT_PREFERENCES){
            $app->redirect($app->getConfig()->getUrl('completarPreferencias'));
        } elseif ($currentUser->user_type == User::USER_TYPE_PHOTOGRAPHER && $profileCompleted == User::USER_COMPLETED_PROFILE){
            $app->redirect(UrlHelper::getPortfolioUrl());
        } else {
            $app->redirect(UrlHelper::getProfileUrl());
        }

    }

    if($action == "editarPerfil"){
		$name = $_REQUEST['user_name'];
		$lastname = $_REQUEST['user_apellido'];
        $email = trim($_REQUEST['user_email']);
		$desc = $_REQUEST['user_descripcion'];
		$direccion = $_REQUEST['user_direccion'];
		$cp = $_REQUEST['user_cp'];
		$pais = $_REQUEST['user_pais'];
		$tel = $_REQUEST['user_telefono'];
		$movil = $_REQUEST['user_movil'];
		$city = $_REQUEST['user_city'];
        $currentPass = $_REQUEST['user_current_pass'];
        $newPass = $_REQUEST['user_new_pass'];
        $confirmPass = $_REQUEST['user_confirm_pass'];

        //TODO Validate date
        $dob = str_replace('/', '-', $_POST['user_dob']);
        $dob = date('Y-m-d', strtotime($dob));

        $currentUser = getCurrentUser();

        // Validate password if was changed
        if (!empty($currentPass) && !empty($newPass) && !empty($confirmPass)){
            $error = false;
            $validNewPass = false;

            // Validate current pass
            if (!User::checkCurrentPassword($currentUser->id, $currentPass)){
                $app->addError("La contraseña actual no es correcta");
                $app->getInput()->save(); //flash form data
                $app->redirect($app->getHelper('UrlHelper')->getUrl('editarPerfil'));
                return;
            }

            // Validate new password
            if ($newPass != $confirmPass){
                $app->addError("La nueva contraseña y la confirmación no coinciden.");
                $app->getInput()->save(); //flash form data
                $app->redirect($app->getHelper('UrlHelper')->getUrl('editarPerfil'));
                return;
            }

            $validNewPass = true;
        }

        // Validate new email
        $validNewEmail = false;
        if (!empty($email) && StringHelper::validateEmail($email) && $email != $currentUser->email){
            // Validate new email is not registered yet
            $existUser = User::checkEmailExists($email);

            if ($existUser){
                $app->addError("El correo electrónico indicado ya está en uso.");
                $app->getInput()->save(); //flash form data
                $app->redirect($app->getHelper('UrlHelper')->getUrl('editarPerfil'));
                return;
            }

            $validNewEmail = true;

        }

        // Update user info
        $dataUser = array('name' => $name, 'lastname' => $lastname, 'dob' => $dob);
        if ($validNewPass){
            $dataUser['password'] = $newPass;
        }
        if ($validNewEmail){
            $dataUser['new_email'] = $email;
            $dataUser['new_email_code'] = StringHelper::generateRandomString();
        }
        $user = User::updateUser($currentUser->id, $dataUser);

        // Update detail user info
        $dataProfile = array(
            UserDetail::USER_DETAIL_DESCRIPTION => $desc,
            UserDetail::USER_DETAIL_ADDRESS => $direccion,
            UserDetail::USER_DETAIL_ZIP_CODE => $cp,
            UserDetail::USER_DETAIL_COUNTRY => $pais,
            UserDetail::USER_DETAIL_PHONE => $tel,
            UserDetail::USER_DETAIL_CITY => $city,
            UserDetail::USER_DETAIL_MOBILE_PHONE => $movil,
        );

		$folder_id = sha1($currentUser->id);
		$dir = "../profiles/".$folder_id;

		//si es fotografo
		if($userType == User::USER_TYPE_PHOTOGRAPHER){
			$camaraArray = $_REQUEST['user_camara'];
			$lentesArray = $_REQUEST['user_lentes'];
			$equipoArray = $_REQUEST['user_equipo'];
            $escuelaFotografia = $_REQUEST['user_escuela_fotografia'];
            $masEducacion = $_REQUEST['user_mas_educacion'];
            $experienciaLaboralEmpresa = $_REQUEST['user_experience_empresa'];
            $experienciaLaboralUbicacion = $_REQUEST['user_experience_localidad'];
            $idiomasArray = $_REQUEST['user_idiomas'];
            $habilidadesArray = $_REQUEST['user_habilidades'];
            $rut = $_REQUEST['user_rut'];
			$user_pago = $_REQUEST['user_pago'];
            $interes = $_REQUEST['user_interes'];

            foreach ($camaraArray as $i => $ele){
                if ($ele != ""){
                    $camara[] = $ele;
                }
            }

            foreach ($lentesArray as $i => $ele){
                if ($ele != ""){
                    $lentes[] = $ele;
                }
            }

            foreach ($equipoArray as $i => $ele){
                if ($ele != ""){
                    $equipo[] = $ele;
                }
            }

            $experienciaLaboral = array();
            foreach ($experienciaLaboralEmpresa as $i => $ele){
                if ($ele != ""){
                    $experienciaLaboral[] = array('empresa' => $ele, 'localidad' => $experienciaLaboralUbicacion[$i]);
                }
            }

            foreach ($idiomasArray as $i => $ele){
                if ($ele != ""){
                    $idiomas[] = $ele;
                }
            }

            $habilidades = array();
            foreach ($habilidadesArray as $i => $ele){
                if ($ele != ""){
                    $habilidades[] = $ele;
                }
            }

            $dataProfile[UserDetail::USER_DETAIL_CAMERA] = json_encode($camara);
            $dataProfile[UserDetail::USER_DETAIL_GLASSES] = json_encode($lentes);
            $dataProfile[UserDetail::USER_DETAIL_EQUIPMENT] = json_encode($equipo);
            $dataProfile[UserDetail::USER_DETAIL_PHOTOGRAPHY_SCHOOL] = $escuelaFotografia;
            $dataProfile[UserDetail::USER_DETAIL_MORE_EDUCATION] = $masEducacion;
            $dataProfile[UserDetail::USER_DETAIL_LABORAL_EXPERIENCE] = json_encode($experienciaLaboral);
            $dataProfile[UserDetail::USER_DETAIL_LANGUAGES] = json_encode($idiomas);
            $dataProfile[UserDetail::USER_DETAIL_HABILITIES] = json_encode($habilidades);
            $dataProfile[UserDetail::USER_DETAIL_RUT] = $rut;
            $dataProfile[UserDetail::USER_DETAIL_PAYMENT_USER] = $user_pago;

            // Update interests
            UserDetail::updateInterests($currentUser->id, $interes);
		}

        // Update detail user info
        UserDetail::update($currentUser->id, $dataProfile);

        if ($validNewEmail){
            // Send email with link to activate new email
            $confirmUrl = UrlHelper::getUrl('actions/perfilAction.php').'?act_code='.$user->act_code.'&new_email_code='.$user->new_email_code.'&act=new_email_confirmation';
            $asunto= "Confirmación de cambio de correo electrónico";

            $params = array(
                'site_url' => FConfig::getUrl(),
                'logo_url' => FConfig::getUrl('images/logo_footer.png'),
                'fullname' => $currentUser->full_name,
                'confirmation_url' => $confirmUrl,
            );

            $body = FMailer::replaceParameters($params, file_get_contents('../views/emails/newEmailConfirmation.html'));

            $mailer = new FMailer();
            $receivers = array(
                array('email' => $currentUser->email, 'name' => $currentUser->full_name),
            );
            $mailer->setReceivers($receivers);
            $mailer->sendEmail($asunto, $body);

            $app->addMessage("Un correo electrónico te ha sido enviado a la dirección <b>".$email."</b> para confirmarla.");
            $app->redirect($app->getHelper('UrlHelper')->getUrl('editarPerfil'));
        } else {
            $app->redirect($app->getHelper('UrlHelper')->getUrl('perfil'));
        }

        return;
	}

    // Cancel new email
    if ($action == 'cancel_new_email'){
        $userId = intval($app->getRequest()->get('user_id'));

        $data = array('new_email' => null, 'new_email_code' => null);

        $user = User::updateUser($userId, $data);

        $response = new stdClass();
        if ($user){
            $response->status = 'success';
        } else {
            $response->status = 'error';
        }

        echo json_encode($response);
        die;
    }

    // New email confirmation
    if ($action == 'new_email_confirmation'){
        $actCode = $app->getRequest()->get('act_code');
        $newEmailCode = $app->getRequest()->get('new_email_code');

        $user = User::getUserToConfirmNewEmail($actCode, $newEmailCode);

        if (!$user){
            $app->addError("Ha ocurrido un error intentando confirmar un cambio de correo electrónico.");
        } else {
            $user->user = $user->new_email;
            $user->new_email = null;
            $user->new_email_code = null;
            $user->save();

            $app->addMessage("Tu correo electrónico ha sido cambiado exitosamente. Tu nueva cuenta de correo electrónico es <b>". $user->user ."</b>");
        }

        $app->redirect(UrlHelper::getUrl('editarPerfil'));
        return;
    }

	//marcar notificaciones como leidas
	if($action == "notificationAct"){
        $id = intval($_REQUEST['id']);

        //Update nice version
//        $notificacion = \ORM::for_table('notificaciones')->find_one($id);
//        $notificacion->set('leido', 'S');
//        $notificacion->save();

        //Update old version
        updateTable("notificaciones", "leido='S'", "id = $id");

        $redirectUrl = $_REQUEST['url'];
//        $redirectUrl = FConfig::getUrl($redirectUrl);

        header('Location: '.$redirectUrl);
        die;
	}

    /**
     * Crop the temp image and generate the preview
     */
    if ($action == "cropImage") {
        $response = new stdClass;

        //TODO validate user, if there is an error append to json response
        //TODO validate login
        $user = getCurrentUser();
        $folder_id = sha1($user->id);
        $baseProfileUrl = 'profiles' . '/' . $folder_id . '/';
        $baseProfileDir = '..' . DS . $baseProfileUrl;

        // validate if profile folder is create, if not do so TODO test directory creation
        if (!file_exists($baseProfileDir)) {
            $old = umask(0);
            mkdir($dir, 0777, true);
            umask($old);
        }

        //TODO validate type here (private function for it)
        $type = $_GET['type'];

        $fileNameMain = $type . '.jpg';


        $fileTempName = $type . "_temp.jpg";
        $fileTempPath = $baseProfileDir . $fileTempName;

        if (!file_exists($fileTempPath)) {
            //No se subió una imagen nueva, se esta cortando la existente
        }


        //TODO validate fileTempPath existence

        $filePreviewName = $type . "_preview.jpg";
        $filePreviewPath = $baseProfileDir . $filePreviewName;

        //TODO validate crop coords (complex validation)
        //$tempFile = $baseProfileDir . DS . $fileName;
        getimagesize($fileTempPath);
        $result = ImageHelper::cropImage($fileTempPath, $filePreviewPath, $_REQUEST['x1_profile'], $_REQUEST['y1_profile'], $_REQUEST['w_profile'], $_REQUEST['h_profile'], $_REQUEST['s']);

        if ($result === false) {
            $response->status =  'error';
            $response->message = 'could not create the image';
        } else {
            $response->status = "success";
            $response->img_url = FConfig::getUrl($baseProfileUrl . $filePreviewName, true);
            $response->message = "temp image created successfully";
        }

        echo json_encode($response);
        die;
    }


    /**
     * Set the cropped image as the final image
     */
    if ($action == 'confirmImage') {
        $response = new stdClass;

        //TODO validate user, if there is an error append to json response
        //TODO validate login

        $user = getCurrentUser();
        $folder_id = sha1($user->id);
        $baseProfileUrl = 'profiles' . '/' . $folder_id . '/';
        $baseProfileDir = '..' . DS . $baseProfileUrl;
        $cacheDir = '..' . DS . 'profiles' . DS . 'cache' . DS;

        if (!file_exists($baseProfileDir)) {
            $old = umask(0);
            mkdir($dir, 0777, true);
            umask($old);
        }

        //TODO validate type here (private function for it)
        $type = $_GET['type'];

        //GENERATE NAMES
        $targetImage = $baseProfileDir . $type . '.jpg';
        $targetImageUrl = $baseProfileUrl . $type . '.jpg';
        $targetImageTemp = $baseProfileDir . $type . '_temp.jpg';
        $sourceImage = $baseProfileDir . $type . '_preview.jpg';
        $result = copy($sourceImage, $targetImage);
        $result = copy($sourceImage, $targetImage);

        unlink($targetImageTemp);

        //error_get_last()
        if ($result) {
            //Get type sizes
            $width = FConfig::getValue($type . "_image_width");
            $height = FConfig::getValue($type . "_image_height");

            //Clear cache
            $cacheFileName =  'profiles_' . $folder_id . "_" . $type . ".jpg";
            $cacheImage = $cacheDir . $width . 'x' . $height . DS . $cacheFileName;

            //TODO revisar la carpeta cache de las imagenes y volar las que apliquen
            //$result = unlink($cacheImage);
            ImageHelper::clearImageCache($cacheDir, $cacheFileName);

            //TODO Clear temp images
            $response->status = "success";
            $response->message = "$type image changed";
            $response->img_url = FConfig::getThumbUrl($targetImageUrl, $width, $height, true);
        } else {
            $response->status = "error";
            $response->message = "$type image could not be changed";
        }

        //echo ()

        header('Content-type: application/json');
        echo json_encode($response);
        die;
    }


    /**
     * Handle upload to candidate image, ( the image to be cropped)
     */
    if ($action == 'uploadImage') {
        $response = new stdClass;

        //TODO validate user, if there is an error append to json response
        //TODO validate login

        $user = getCurrentUser();
        $folder_id = sha1($user->id);
        $baseProfileUrl = 'profiles' . '/' . $folder_id . '/';
        $baseProfileDir = '..' . DS . $baseProfileUrl;

        if (!file_exists($baseProfileDir)) {
            $old = umask(0);
            mkdir($baseProfileDir, 0777, true);
            umask($old);
        }


        $file = $_FILES['file'];

        //Due to client side compress, this validation probably won't execute
        if (($file['size'] == 0) || (($file['size']/1024) > FConfig::getValue('maxUploadSize'))){
            $response->status = 'error';
            $response->message = 'invalid file';
            echo json_encode($response);
            die();
        }

        $validTypes = array('image/png', 'image/jpeg', 'image/jpg', 'image/gif');
        if (!in_array($file['type'], $validTypes)) {
            $response->status = 'error';
            $response->message = 'invalid file';
            echo json_encode($response);
            die();
        }

        $fileInfo = getimagesize($file['tmp_name']);
        $tmpImageWidth = $fileInfo[0];
        $tmpImageHeight = $fileInfo[1];
        $tmpImageType = $fileInfo[2];

        //TODO validate type , if not valid type (profile or cover) return error
        $type = $_GET['type'];
        $aspectRatio = $_GET['cropRatio'] | 1;

        //if ($type == 'profile') {
        if (($tmpImageWidth < FConfig::getValue($type . '_image_width')) || ($tmpImageHeight < FConfig::getValue($type . '_image_height'))) {
            $response->status = 'error';
            $response->message = 'invalid image size';
            echo json_encode($response);
            die();
        }
        //}

//        if ($type == 'cover') {
//            if (($source_image_width < FConfig::getValue('cover_image_width')) || ($source_image_height < FConfig::getValue('cover_image_height'))) {
//                $response->status = 'error';
//                $response->message = 'invalid image size';
//                echo json_encode($response);
//                die();
//            }
//        }

        //TODO validate image size
        $fileName = $type . '_temp.jpg';
        $filePath = $baseProfileDir . $fileName;
        $fileUrl = $baseProfileUrl . $fileName;

//        $cropWidth = min(ceil($tmpImageWidth * 0.7), ceil($tmpImageHeight * 0.7));
//        $cropHeight = ceil($cropWidth / $aspectRatio);
//
//        $x1Crop = 0;
//        $y1Crop = 0;
//        $x2Crop = $cropWidth;
//        $y2Crop = $cropHeight;

        //75,336,775,528

        //Center it

        //Save as jpeg
        $resultSave = ImageHelper::saveImageAsJPG($file['tmp_name'], $file['type'], $filePath);
        //error_get_last()
        if ($resultSave) {
            $response->status = 'success';
            $response->img_url = FConfig::getUrl($fileUrl, true);
            $response->width = $tmpImageWidth;
            $response->height = $tmpImageHeight;
        } else {
            $response->status = 'error';
            $response->message = "crop image could not be created";
        }

        echo json_encode($response);
        die;
    }

    /**
     * Mark wizard completed to the current user after the first login in the site
     */
    if ($action == 'wizardCompleted') {
        $actCode = $_REQUEST['act-code'];

        $result = mysql_query("UPDATE user SET wizard_completed = true WHERE act_code = '". $actCode ."'");

        $response = new stdClass();
        if ($result){
            $response->status = 'success';
        } else {
            $response->status = 'error';
        }

        echo json_encode($response);
        die;
    }

    /**
     * Mark wizard completed to the current user after view the project page when has an offer.
     */
    if ($action == 'wizardContactCreativeCompleted') {
        $actCode = $_REQUEST['act-code'];

        $result = mysql_query("UPDATE user SET wizard_contact_creative_completed = true WHERE act_code = '". $actCode ."'");

        $response = new stdClass();
        if ($result){
            $response->status = 'success';
        } else {
            $response->status = 'error';
        }

        echo json_encode($response);
        die;
    }
	
}else{
	//header("location:../home");
}