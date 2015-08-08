<?php
use Fototea\Config\FConfig;
use Fototea\Models\Credit;
use Fototea\Models\User;
use Fototea\Util\FAnalytics;

require '../vendor/autoload.php';

include_once '../scripts/libSM.php';

$session = validaSession();
$act = $_REQUEST['act'];
$userType = securityValidation($_COOKIE['id']);

if($session == true){
    if($userType == User::USER_TYPE_PHOTOGRAPHER){
        //agregar album
        if ($act == "agregarAlbum"){
            $userInfo = getCurrentUser();

            if ($userInfo->user_type == User::USER_TYPE_PHOTOGRAPHER){
                $previousAlbumList = listAll("albumes", "WHERE a_user_id = '$userInfo->id'");
                $previousAlbumQty = mysql_num_rows($previousAlbumList);

                // Check credits of user
                $availableCredits = Credit::getRealAvailableCredits($userInfo->id, $previousAlbumQty);
                if ($availableCredits == 0){
                    return false;
                }

                $album = insertTable("albumes", "'','$_REQUEST[a_tit]','$_REQUEST[a_license]','$_COOKIE[id]','F','".(($_REQUEST['status']==='true')?'S':'N')."',NOW()");
                $folder_id = sha1($_COOKIE['id']);
                $dir = "../profiles/".$folder_id;
                $dirAlbum = $dir."/".sha1($album);
                mkdir($dirAlbum,0777);

                // Discount credit if album's qty is more than limit
                if ($previousAlbumQty >= FConfig::getValue('defaultAlbumsByPhotographer')){
                    Credit::markCreditUsed($userInfo->id, $album);
                }

                // Event: Crear album
                $eventData = new stdClass();
                $eventData->user_id = $userInfo->id;
                $eventData->album_id = $album;
                $events = FAnalytics::getInstance();
                $events->trackEvent('Album', 'Crear álbum', json_encode($eventData));

                $arreglo[] = array('album' => "$album",'img'=>$dirAlbum);
                echo json_encode($arreglo);

            } else {
                $userInfo = getUserInfo($_COOKIE['id']);
                $app->redirect($app->getConfig()->getUrl("perfil?us=". $userInfo->act_code));
            }

            return;
        }

        if($act == "editarAlbum"){
            $result = updateTable("albumes", "a_tit = '$_REQUEST[a_tit]', a_license = '$_REQUEST[a_license]', a_status =  '".(($_REQUEST['status']=='true')?'S':'N')."'", "a_id = '$_REQUEST[a_id]' AND a_user_id = '$_COOKIE[id]'");

            $arreglo[] = array('album' => "$_REQUEST[a_id]");
            echo json_encode($arreglo);
        }

        // Esto se usar con Album visible/no visible
        if($act == "borrarAlbum"){
            updateTable("albumes", "a_status = 'N'", "a_id = '$_REQUEST[a_id]' AND a_user_id = '$_COOKIE[id]'");
            $arreglo[] = array('resp' => "Se ha enviado la información");
            echo json_encode($arreglo);
        }

        if($act == "deleteAlbum"){

            $userInfo = getCurrentUser();

            $currentUser = $userInfo->id;

            $albumToDelete = listAll("albumes", "WHERE a_id = ".$_REQUEST['a']);
            $albumToDelete = mysql_fetch_object($albumToDelete);

            if ($albumToDelete->a_user_id == $currentUser){
                // Delete images
                $albumPath = 'profiles/'. sha1($currentUser) .'/'. sha1($albumToDelete->a_id);

                if (file_exists('../'.$albumPath)){
                    $deletedDirectory = delete_directory($albumPath);
                } else {
                    $deletedDirectory = true;
                }

                if ($deletedDirectory){
                    // Delete db album's photos
                    eliminarRegistro('albumes_det', 'ad_a_id', $albumToDelete->a_id);

                    // Delete album
                    eliminarRegistro('albumes', 'a_id', $albumToDelete->a_id);

                    // Reactive referrals' credit if exists
                    $newCredit = Credit::renewCredit($userInfo->id, $albumToDelete->a_id);

                    $userInfo = getUserInfo($_COOKIE['id']);

                    $app->redirect($app->getConfig()->getUrl("perfil?us=". $userInfo->act_code ."&act=portafolio"));
                }
            }

        }

        if($act == "activarAlbum"){
            updateTable("albumes", "a_status = 'S'", "a_id = '$_REQUEST[a_id]' AND a_user_id = '$_COOKIE[id]'");
            $arreglo[] = array('resp' => "Se ha enviado la información");
            echo json_encode($arreglo);
        }

        if($act == "borrarfoto"){
            updateTable("albumes_det", "ad_status = 'N'", "ad_a_id = '$_REQUEST[a_id]' AND ad_id = '$_REQUEST[ad_id]' AND ad_user_id = '$_COOKIE[id]'");

            //        $perfilSha1 = sha1($_COOKIE['id']);
            //        $albumSha1 = sha1($_REQUEST['a_id']);
            //        $fileName = $_REQUEST['file_name'];
            //
            //        $pathFile = '../profiles/'. $perfilSha1 .'/'. $albumSha1 .'/'. $fileName;
            //
            //        @unlink($pathFile);

        }

        //	if($act == "agregarFoto"){
        //		$count = count($_FILES['img_album']['name']);
        //
        //		for($i=0;$i <= $count; $i++){
        //			$foto = $_FILES['img_album'][$i];
        //			//print_r($foto);
        //			$descr = " ";
        //
        //			$folder_id = sha1($_COOKIE['id']);
        //			$dir = "../profiles/".$folder_id;
        //			$dirAlbum = $dir."/".sha1($_REQUEST[album])."/";
        //			$plus = 10 * $i;
        //			$archivo= $_FILES['img_album']['name'][$i];
        //			$tamano = $_FILES['img_album']['size'][$i];
        //			$ext = strtolower(substr($archivo, strlen($archivo)-3, 3));
        //			$name = md5(time() + $plus);
        //			$name2 = $name.".".$ext;
        //			if ($archivo != ""){
        //				// --> validaciones del archivo a subir
        //
        //				if (file_exists($dirAlbum.$name2)){ // -> si existe el archivo te lo vuelas
        //					@unlink($dirAlbum.$name2);
        //				}
        //
        //				$nombre_archivo_temp=$name.".".$ext;
        //
        //				if($ext =="jpg" || $ext=="png" || $ext =="gif"){
        //					$destination = $dirAlbum.$nombre_archivo_temp;
        //					compress($_FILES['img_album']['tmp_name'][$i], $destination,70);
        //				}
        //				updateTable("albumes", "a_status = 'S'", "a_id = '$_REQUEST[album]'");
        //				insertTable("albumes_det", "'','$_REQUEST[album]','$name2','$_COOKIE[id]','$descr','S',NOW(),0");
        //
        //			}
        //
        //		}
        //
        //		header("location:../subirImagen?a=".$_REQUEST['album']);
        //
        //	}

        if($act == "addFoto"){
            $file = $_FILES['file'];

            if($file['size'] > 0){

                $albumId = $_REQUEST['album'];

                // Validar cantidad maxima de fotos
                $fotos = listAll("albumes_det", "WHERE ad_a_id = '".$albumId."' AND ad_status='S'");
                $rows_fotos = mysql_num_rows($fotos);

                if ($rows_fotos >= FConfig::getValue('maxFilesByAlbum')){
                    return "error";
                }

                $fileNameComplete = $file['name'];
                $fileNameArray = explode(".", $fileNameComplete);
                $fileName = $fileNameArray[0];
                $extension = end($fileNameArray);

                //            if (file_exists($pathFile)){
                //                return 'error';
                //            }

                $user = getCurrentUser();

                $perfilSha1 = sha1($user->id);

                $albumSha1 = sha1($albumId);

                updateTable("albumes", "a_status = 'S'", "a_id = '".$albumId."'");
                $photo_id = insertTable("albumes_det", "'','".$albumId."','".$fileNameComplete."','".$user->id."','','S',NOW(),0");

                $fileNameUnique = $fileName ."_". $photo_id .".". $extension;

                updateTable("albumes_det", "ad_url = '". $fileNameUnique ."'", "ad_id = ". $photo_id);

                $pathFile = '../profiles/'. $perfilSha1 .'/'. $albumSha1 .'/'. $fileNameUnique;

                move_uploaded_file($file['tmp_name'], $pathFile);

                // Event: Fotos subidas álbumes
                $events = FAnalytics::getInstance();
                $events->trackEvent('Album - Fotos subidas', 'Foto subida al album '.$albumId, $user->id);

                return 'success';

            } else {
                return 'error';
            }

        }

        if($act == "principalFoto"){
            $foto = $_REQUEST['ad_id'];

            updateTable("albumes_det", "ad_is_principal = false", "ad_a_id = '$_REQUEST[album]'");
            updateTable("albumes_det", "ad_is_principal = true", "ad_a_id = '$_REQUEST[album]' AND ad_id = '$foto'");
        }

    }
    if($act == "buscarFoto"){
        $foto = $_REQUEST['foto'];
        $limit = $foto - 1;

        $foto = listAll("albumes_det", "WHERE ad_a_id = '$_REQUEST[a_id]' AND ad_status='S' LIMIT $limit,$foto");
        $rs_foto = mysql_fetch_object($foto);
        $url_img = "profiles/".sha1($rs_foto->ad_user_id)."/".sha1($rs_foto->ad_a_id)."/".$rs_foto->ad_url;
        $fecha = explode(" ",dateField($rs_foto->ad_cdate));
        $desc = $fecha[0];

        $arreglo[] = array('img' => $url_img,'desc'=>$desc);
        echo json_encode($arreglo);

    }


} else {
    $app->redirect($app->getConfig()->getUrl('perfil'));
}
