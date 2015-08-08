<?php

use Fototea\Config\FConfig;
use Fototea\Models\User;
use Fototea\Util\DateHelper;

$hostname_h = FConfig::getValue('db_hostname');
$database_h = FConfig::getValue('db_name');
$username_h = FConfig::getValue('db_user');
$password_h = FConfig::getValue('db_password');

$db = mysql_pconnect($hostname_h, $username_h, $password_h) or trigger_error(mysql_error(),E_USER_ERROR);
$db_select = mysql_select_db($database_h,$db);

//funcion para validar session
function validaSession(){
	if(!isset($_COOKIE['id'])){
		//@header("location:login");
		return false;
	}else{
		
		return true;
	}
}
//fin funcion
//funcion signOut
function signOut(){
	setcookie('user','',time()-3600);
	setcookie('id','',time()-3600);
    clearReferer();
	return true;
}
// fin funcion signOut
//funcion para validar acceso al modulo
function securityValidation($id){
	
$level_sql = "SELECT * FROM user WHERE id = '$id'";
$level_query = mysql_query($level_sql);
$row_level = mysql_num_rows($level_query);
$rs_level = mysql_fetch_object($level_query);

if( $row_level == 1){
	$sec = $rs_level->user_type;
}else{
$sec = false;	
}

return $sec;
}

function getCurrentUser() {
    if (!isset($_COOKIE['id'])) {
        return false;
    }

    //$user = new stdClass;
    //$user->id = $_COOKIE['id'];
    $user = (object) getUserInfo($_COOKIE['id']);

    if ($user->id == null) {
        return false;
    }

    return $user;
}

//fin funtion


//funcion para validar acceso al modulo
function moduleValidation($id,$level){
	
$level_sql = "SELECT * FROM security WHERE id = '$id' AND id = '$level'";
$level_query = mysql_query($level_sql);
$row_level = mysql_num_rows($level_query);

if( $row_level == 1){
	$sec = 1;
}

if ($sec != 1){
	return false;
}else{
	return true;
}
}
//fin funtion




// funcion para select a tablas
function listAll($table,$where, $select = "*"){
	
	$sql_all = "SELECT $select FROM ".$table." ".$where;
	return mysql_query($sql_all);
}

function dateField($fdate){
	
	$f = explode(" ",$fdate);
	$d = explode("-",$f[0]);
	
	$date = $d[2]."-".$d[1]."-".$d[0]." ".$f[1];
	
	return $date;
}
	// fin funcion
	//funcion para subir imagenes al servidor

function uploadFile($file,$dir,$plus){
	

  $archivo= $_FILES[$file]['name'];
  $tamano = $_FILES[$file]['size'];
  $ext = strtolower(substr($archivo, strlen($archivo)-3, 3));
  $name = md5(time() + $plus);
  $name2 = $name.".".$ext;
  if ($archivo != ""){
	  // --> validaciones del archivo a subir 
		
		 if (file_exists($dir.$name2)){ // -> si existe el archivo te lo vuelas
		 	@unlink($dir.$name2);
		 } 	
		   	  
    $nombre_archivo_temp=$name.".".$ext;  
	
    if($ext =="jpg" || $ext=="png" || $ext =="gif"){
    	$destination = $dir.$nombre_archivo_temp;
    	compress($_FILES[$file]['tmp_name'], $destination,70);
    }else{
  	if(is_uploaded_file($_FILES[$file]['tmp_name'])){
		    copy($_FILES[$file]['tmp_name'], $dir.$nombre_archivo_temp);
	}
  }
    return $nombre_archivo_temp;	
  }else{
	  return false;
  }
	
}
//fin funcion
//funcion eliminar foto
function deletePhoto($file,$dir){
	
	@unlink($dir.$file);
}

//fin funcion
// funcion para realizar login

function login($user,$pass){
	$query_salt = mysql_query("SELECT salt FROM user WHERE user = '".$user."'");
	$num_salt = mysql_num_rows($query_salt);
	if($num_salt < 1 ){
		return false;
	} else {
		$rs_salt = mysql_fetch_array($query_salt);
		$pass_u = sha1($pass);
		$password = sha1($rs_salt[0].$pass_u);
		
		$query_login = mysql_query("SELECT * FROM user WHERE user = '".$user."' AND password = '".$password."' AND act = 'S'");
		$num_login = mysql_num_rows ($query_login);

        if ($num_login < 1){
            return false;
        }else{
            $rs_user = mysql_fetch_object($query_login);
            $name = $rs_user->name." ".$rs_user->lastname;
            setcookie("user",$name,0);
            setcookie("id",$rs_user->id,0);

            $login_date = explode("-",$rs_user->last_login);

            if($login_date[0] == "0000"){
                $login_resp = "completarPerfil";
                return $login_resp;

            }else{
                updateTable("user", "last_login=NOW()", "id=$rs_user->id");

                if (getReferer() != null){
                    $login_resp = getReferer();
                    clearReferer();
                } else {
                    $login_resp = "perfil";
                }

                return $login_resp;
            }
        }
	}
}

function loginFb($user){


		$query_login = mysql_query("SELECT * FROM user WHERE user = '".$user."'");
		$num_login = mysql_num_rows ($query_login);
		if ($num_login < 1){
			$login_resp = 'window.location="../login";';
				return $login_resp;
		}else{
			$rs_user = mysql_fetch_object($query_login);
			$name = $rs_user->name." ".$rs_user->lastname;
			setcookie("user",$name,0);
			setcookie("id",$rs_user->id,0);

			$login_date = explode("-",$rs_user->last_login);

			if($login_date[0] == "0000"){
				$login_resp = 'window.location="../completarPerfil";';
				return $login_resp;
					
			}else{
				updateTable("user", "last_login=NOW()", "id=$rs_user->id");
				$login_resp = 'window.location="../miHome";';
				return $login_resp;
			}
		}
	
}


// fin funcion

//funcion insert

function insertTable($table, $values){
	
	$insert = "INSERT INTO ".$table." VALUES (".$values.")";
	$insert_query = mysql_query($insert);
	if($insert_query){
		$insert_id = mysql_insert_id();
		return $insert_id;
	}else{
		return false;
	}
}
//fin funcion
//funcion update

function updateTable($table, $values, $where){
	
	$update = "UPDATE ".$table." SET ".$values." WHERE ".$where;

    $update_query = mysql_query($update);

	if($update_query){
		return true;
	}else{
		return false;
	}
}
//fin funcion

//funcion permisos de acceso
function validaAcceso($idUs,$idMod){
$sec = mysql_query("SELECT * FROM security WHERE users_id = '$idUs' AND modules_id = '$idMod'");
$sec_val = mysql_num_rows($sec);

if ($sec_val == 1){
	return true;
}else{
	return false;
}
}
//fin funcion

// function para eliminar registros
function eliminarRegistro($table,$camp,$dato){
	$q = "DELETE FROM ".$table." WHERE ".$camp." = ".$dato;
	
	mysql_query($q);

}

//funcion para obtener la url actual completa
function urlComplete(){
$url="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
return $url;
}

//doferencia de 2 fechas
function diffDate($date1 ,$date2){
	$diff = abs(strtotime($date2) - strtotime($date1));
	$years   = floor($diff / (365*60*60*24));
	$months  = floor(($diff - $years * 365*60*60*24) / (30*60*60*24));
	$days    = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
	$hours   = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24)/ (60*60));
	$minuts  = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60);
	$seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minuts*60));
	$result [0]= $years;
	$result [1]= $months;
	$result [2]= $days;
	$result [3]= $hours;
	$result [4]= $minuts;
	$result [5]= $seconds;
	return $result;
}
//fin funcion

//funcion get data

function getUserData($idUser,$idData){

    $usr_q = listAll("user_det", "WHERE id_user = '$idUser' AND id_data = '$idData'");

    $usr_data = mysql_fetch_object($usr_q);
    return $usr_data;
	
}
//end fuctnion

//funcion get recent data

function getRecentUserData($idUser, $idData){

    $usr_q = listAll("user_det", "WHERE id_user = '$idUser' AND id_data = '$idData' ORDER BY id DESC LIMIT 1");

    $usr_data = mysql_fetch_object($usr_q);
    return $usr_data;

}
//end fuctnion

//function getUserInterest
function getUserInterest($idUs,$idCat){
	$usr_q = listAll("user_det", "WHERE id_user = '$idUs' AND id_data = '15' AND description = '$idCat'");
	$usr_data = mysql_num_rows($usr_q);
	if($usr_data > 0){
		return true;
	}else{
		return false;
	}
	
}


//end function
//function getUserInfo
function getUserInfo($id){
	
	$usr_info = mysql_fetch_object(listAll("user", "WHERE id = '$id'"));
	$descripcion = getUserData($id, "2");
	$user_img = getUserData($id, "1");
	$direccion = getUserData($id, "3");
	$ciudad = getUserData($id, "10");
	$cp = getUserData($id, "4");
	$pais = getUserData($id, "5");
	$telefono = getUserData($id, "6");
	$movil =getUserData($id, "7");
	$exp = getUserData($id, "14");
	$cam = getUserData($id, "11");
	$lentes = getUserData($id, "12");
	$equip = getUserData($id, "13");
	$cover = getUserData($id, "16");
	$user_pago = getUserData($id, "17");
    $escuelaFotografia = getUserData($id, "18");
    $masEducacion = getUserData($id, "19");
    $experienciaLaboral = getRecentUserData($id, "20");
    $idiomas = getUserData($id, "22");
    $habilidades = getUserData($id, "21");
    $rut = getUserData($id, "23");
	
	if($usr_info->gender == "H"){
		$gender = "Hombre";
	}else{
		$gender = "Mujer";
	}

	$paisf = listAll("paises","WHERE iso = '$pais->description'");
	$rs_paisf = mysql_fetch_object($paisf);
	
	$user['id'] = $usr_info->id;
	$user['user_type'] = $usr_info->user_type;
	$user['email'] = $usr_info->user;
    $user['new_email'] = $usr_info->new_email;
    $user['new_email_code'] = $usr_info->new_email_code;
	$user['descripcion'] = $descripcion->description;
	$user['user_img']= $user_img->description;
	$user["name"] = $usr_info->name;
	$user['lastname'] = $usr_info->lastname;
	$user['dob']= DateHelper::getLongDate($usr_info->dob);
    $user['user_dob'] = DateHelper::getShortDate($usr_info->dob, 'd/m/Y');
	$user['sex']= $gender;
	$user['act']= $usr_info->act;
	$dob = explode("-",$usr_info->dob);
	$user['ano'] = $dob[0];
	$user['mes'] = $dob[1];
	$user['dia'] = $dob[2];
	$user['direccion'] = $direccion->description;
	$user['ciudad'] = $ciudad->description;
	$user['cp'] = $cp->description;
	$user['pais'] = utf8_encode($rs_paisf->nombre);
	$user['pais_ab'] = utf8_encode($rs_paisf->iso);
	$user['telefono'] = $telefono->description;
	$user['movil'] = $movil->description;
	$user['exp'] = $exp->description;
    $user['escuela-fotografia'] = $escuelaFotografia->description;
    $user['mas-educacion'] = $masEducacion->description;
    $user['experiencia-laboral'] = json_decode($experienciaLaboral->description);
    $user['idiomas'] = json_decode($idiomas->description);
    $user['habilidades'] = json_decode($habilidades->description);
    $user['rut'] = $rut->description;
	$user['cam'] = json_decode($cam->description);
	$user['lentes'] = json_decode($lentes->description);
	$user['equip'] = json_decode($equip->description);
	$user["act_code"] = $usr_info->act_code;
    $user["profile_completed"] = $usr_info->profile_completed;
    $user["wizard_completed"] = $usr_info->wizard_completed;
    $user["wizard_contact_creative_completed"] = $usr_info->wizard_contact_creative_completed;
	$user['user_cover'] = $cover->description;
	$user['user_pago'] = $user_pago->description;
	$user['full_name'] = ucwords($user["name"] . " " . $user['lastname']);
    //TODO make it an external function
    //TODO set a default image if file does not exists
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
//end function
//function getuserid

function getUserId($act_code){
	
	$us = mysql_fetch_object(listAll("user", "WHERE act_code = '$act_code'"));
	
	return $us->id;
	
}
//function sumar dias a una fecha
function sumDayToDate($date,$days){
	$date = date_create($date);
	date_add($date, date_interval_create_from_date_string($days));
	
	return  date_format($date, 'Y-m-d H:i:s');
}

function showStatusProject($status){
	if($status=="A"){
		$stat = "Activo";
	}else if($status=="B"){
		$stat = "Borrador";
	}else if($status=="F"){
		$stat = "Finalizado";
	}else if($status=="AD"){
		$stat = "Adjudicado";
	}else{
		return false;
	}
	return $stat;
}

function getCategory($id){
	$scat = listAll("categories_event", "WHERE id = '$id'");
	$rs_scat = mysql_fetch_object($scat);
	
	$cat = listAll("categories","WHERE id = '$rs_scat->id_cat'");
	$rs_cat = mysql_fetch_object($cat);
	$category = array("category" => $rs_cat->description,"subcategory"=>$rs_scat->description);
	return $category;
}

function getNumOfertas($id){
	$of = listAll("ofertas","WHERE pro_id = '$id'");
	$rows_of = mysql_num_rows($of);
	return $rows_of;
}

function timePast($date){
	$timePast = diffDate($date,date("Y-m-d H:i:s"));
	
	$tiempo = "";
	
	if($timePast[2]>29){
		$t = explode(" ",dateField($date));
		$tiempo = $t[0];
	}else{
		if($timePast[2]>0){
			$tiempo.= $timePast[2]."d ";
		}
		
			$tiempo.= $timePast[3]."h ";
		
			$tiempo.= $timePast[4]."m ";
		
	}
	return $tiempo;
}

//mensajes nuevos

function mensajesNuevos($userId){
	$mens = listAll("mensajes_status", "WHERE ms_user_id = '$userId' AND ms_status = 'N'");
	$count = mysql_num_rows($mens);
	return $count;
	
}

//validar calificacion realizada
function validarCalificacion($id,$pro_id){
	
	$pro = listAll("proyectos p,ofertas o", "WHERE p.pro_id = '$pro_id' AND p.pro_id = o.pro_id AND awarded = 'S' AND (p.user_id = '$_COOKIE[id]' OR o.user_id = '$_COOKIE[id]')");
	$rs_pro = mysql_num_rows($pro);
	if($rs_pro >= 1){
		$cal = listAll("proyecto_fin", "WHERE pf_pro_id = '$pro_id' AND pf_user_id = '$id' AND pf_status='S'");
		$rows = mysql_num_rows($cal);
		
		if($rows > 0 ){
			return true;
			
		}else{
			return false;
		}
	
	}else{
		return true;
	}
}


// calcular rating de user

function ratings($id_us){
	
	$val = listAll("reviews", "WHERE r_user_id = '$id_us' GROUP BY  r_pro_id");
	$rows_val = mysql_num_rows($val);
	
	if($rows_val > 0){
	
        $user = getUserInfo($id_us);

        //usuario creativo/fotografo
        if($user['user_type'] == User::USER_TYPE_PHOTOGRAPHER){
            $rev = listAll("reviews", "WHERE r_user_id = '$id_us' AND r_type!='CO' AND r_type != 'F'");
            $rev_rows = mysql_num_rows($rev);
            $calification = 0;
            $trato = 0;
            $calidad = 0;
            $prof = 0;
            $resp = 0;
            $punt = 0;
            $t=0;
            $p=0;
            $r=0;
            $pr=0;
            $ca =0;
            while ($rs_rev = mysql_fetch_object($rev)){
                $calification = $calification + $rs_rev->r_value;
                if($rs_rev->r_type == "CA"){
                    $calidad = $calidad + $rs_rev->r_value;
                    $ca++;
                }else if($rs_rev->r_type == "T"){
                    $trato = $trato + $rs_rev->r_value;
                    $t++;
                }else if($rs_rev->r_type == "P"){
                    $punt = $punt + $rs_rev->r_value;
                    $p++;
                }else if($rs_rev->r_type == "R"){
                    $resp = $resp + $rs_rev->r_value;
                    $r++;
                }else if($rs_rev->r_type == "PR"){
                    $prof = $prof + $rs_rev->r_value;
                    $pr++;
                }

            }
            //totales
            $global = $calification/$rev_rows;
            $trato_fin = $trato/$t;
            $calidad_fin = $calidad/$ca;
            $punt_fin = $punt/$p;
            $resp_fin = $resp/$r;
            $prof_fin = $prof/$pr;

            //global
            if($global < 2){
                $review['stars'] = '<img src="images/rating_1.jpg" title="Calificacion '.number_format($global,1,'.',',').'" alt="Calificacion '.number_format($global,1,'.',',').'"/>';
                $review['starsP']=1;
            }else if(round($global) == 2){
                $review['stars'] = '<img src="images/rating_2.jpg" title="Calificacion '.number_format($global,1,'.',',').'" alt="Calificacion '.number_format($global,1,'.',',').'"/>';
                $review['starsP']=2;
            }else if(round($global) == 3){
                $review['stars'] = '<img src="images/rating_3.jpg" title="Calificacion '.number_format($global,1,'.',',').'" alt="Calificacion '.number_format($global,1,'.',',').'"/>';
                $review['starsP']=3;
            }else if(round($global) == 4){
                $review['stars'] = '<img src="images/rating_4.jpg" title="Calificacion '.number_format($global,1,'.',',').'" alt="Calificacion '.number_format($global,1,'.',',').'"/>';
                $review['starsP']=4;
            }else if(round($global) == 5){
                $review['stars'] = '<img src="images/rating_5.jpg" title="Calificacion '.number_format($global,1,'.',',').'" alt="Calificacion '.number_format($global,1,'.',',').'"/>';
                $review['starsP']=5;
            }

            //trato
            if($trato_fin < 2){
                $review['trato_star'] = '<img src="images/rating_1.jpg" title="Calificacion '.number_format($trato_fin,1,'.',',').'" alt="Calificacion '.number_format($trato_fin,1,'.',',').'"/>';
            }else if(round($trato_fin) == 2){
                $review['trato_star'] = '<img src="images/rating_2.jpg" title="Calificacion '.number_format($trato_fin,1,'.',',').'" alt="Calificacion '.number_format($trato_fin,1,'.',',').'"/>';
            }else if(round($trato_fin) == 3){
                $review['trato_star'] = '<img src="images/rating_3.jpg" title="Calificacion '.number_format($trato_fin,1,'.',',').'" alt="Calificacion '.number_format($trato_fin,1,'.',',').'"/>';
            }else if(round($trato_fin) == 4){
                $review['trato_star'] = '<img src="images/rating_4.jpg" title="Calificacion '.number_format($trato_fin,1,'.',',').'" alt="Calificacion '.number_format($trato_fin,1,'.',',').'"/>';
            }else if(round($trato_fin) == 5){
                $review['trato_star'] = '<img src="images/rating_5.jpg" title="Calificacion '.number_format($trato_fin,1,'.',',').'" alt="Calificacion '.number_format($trato_fin,1,'.',',').'"/>';
            }

            //calidad
            if($calidad_fin < 2){
                $review['cal_star'] = '<img src="images/rating_1.jpg" title="Calificacion '.number_format($calidad_fin,1,'.',',').'" alt="Calificacion '.number_format($calidad_fin,1,'.',',').'"/>';
            }else if(round($calidad_fin) == 2){
                $review['cal_star'] = '<img src="images/rating_2.jpg" title="Calificacion '.number_format($calidad_fin,1,'.',',').'" alt="Calificacion '.number_format($calidad_fin,1,'.',',').'"/>';
            }else if(round($calidad_fin) == 3){
                $review['cal_star'] = '<img src="images/rating_3.jpg" title="Calificacion '.number_format($calidad_fin,1,'.',',').'" alt="Calificacion '.number_format($calidad_fin,1,'.',',').'"/>';
            }else if(round($calidad_fin) == 4){
                $review['cal_star'] = '<img src="images/rating_4.jpg" title="Calificacion '.number_format($calidad_fin,1,'.',',').'" alt="Calificacion '.number_format($calidad_fin,1,'.',',').'"/>';
            }else if(round($calidad_fin) == 5){
                $review['cal_star'] = '<img src="images/rating_5.jpg" title="Calificacion '.number_format($calidad_fin,1,'.',',').'" alt="Calificacion '.number_format($calidad_fin,1,'.',',').'"/>';
            }

            //puntualidad
            if($punt_fin < 2){
                $review['punt_star'] = '<img src="images/rating_1.jpg" title="Calificacion '.number_format($punt_fin,1,'.',',').'" alt="Calificacion '.number_format($punt_fin,1,'.',',').'"/>';
            }else if(round($punt_fin) == 2){
                $review['punt_star'] = '<img src="images/rating_2.jpg" title="Calificacion '.number_format($punt_fin,1,'.',',').'" alt="Calificacion '.number_format($punt_fin,1,'.',',').'"/>';
            }else if(round($punt_fin) == 3){
                $review['punt_star'] = '<img src="images/rating_3.jpg" title="Calificacion '.number_format($punt_fin,1,'.',',').'" alt="Calificacion '.number_format($punt_fin,1,'.',',').'"/>';
            }else if(round($punt_fin) == 4){
                $review['punt_star'] = '<img src="images/rating_4.jpg" title="Calificacion '.number_format($punt_fin,1,'.',',').'" alt="Calificacion '.number_format($punt_fin,1,'.',',').'"/>';
            }else if(round($punt_fin) == 5){
                $review['punt_star'] = '<img src="images/rating_5.jpg" title="Calificacion '.number_format($punt_fin,1,'.',',').'" alt="Calificacion '.number_format($punt_fin,1,'.',',').'"/>';
            }

            //responsabilidad

            if($resp_fin < 2){
                $review['resp_star'] = '<img src="images/rating_1.jpg" title="Calificacion '.number_format($resp_fin,1,'.',',').'" alt="Calificacion '.number_format($resp_fin,1,'.',',').'"/>';
            }else if(round($resp_fin) == 2){
                $review['resp_star'] = '<img src="images/rating_2.jpg" title="Calificacion '.number_format($resp_fin,1,'.',',').'" alt="Calificacion '.number_format($resp_fin,1,'.',',').'"/>';
            }else if(round($resp_fin) == 3){
                $review['resp_star'] = '<img src="images/rating_3.jpg" title="Calificacion '.number_format($resp_fin,1,'.',',').'" alt="Calificacion '.number_format($resp_fin,1,'.',',').'"/>';
            }else if(round($resp_fin) == 4){
                $review['resp_star'] = '<img src="images/rating_4.jpg" title="Calificacion '.number_format($resp_fin,1,'.',',').'" alt="Calificacion '.number_format($resp_fin,1,'.',',').'"/>';
            }else if(round($resp_fin) == 5){
                $review['resp_star'] = '<img src="images/rating_5.jpg" title="Calificacion '.number_format($resp_fin,1,'.',',').'" alt="Calificacion '.number_format($resp_fin,1,'.',',').'"/>';
            }
            //profesionalismo

            if($prof_fin < 2){
                $review['prof_star'] = '<img src="images/rating_1.jpg" title="Calificacion '.number_format($prof_fin,1,'.',',').'" alt="Calificacion '.number_format($prof_fin,1,'.',',').'"/>';
            }else if(round($prof_fin) == 2){
                $review['prof_star'] = '<img src="images/rating_2.jpg" title="Calificacion '.number_format($prof_fin,1,'.',',').'" alt="Calificacion '.number_format($prof_fin,1,'.',',').'"/>';
            }else if(round($prof_fin) == 3){
                $review['prof_star'] = '<img src="images/rating_3.jpg" title="Calificacion '.number_format($prof_fin,1,'.',',').'" alt="Calificacion '.number_format($prof_fin,1,'.',',').'"/>';
            }else if(round($prof_fin) == 4){
                $review['prof_star'] = '<img src="images/rating_4.jpg" title="Calificacion '.number_format($prof_fin,1,'.',',').'" alt="Calificacion '.number_format($prof_fin,1,'.',',').'"/>';
            }else if(round($prof_fin) == 5){
                $review['prof_star'] = '<img src="images/rating_5.jpg" title="Calificacion '.number_format($prof_fin,1,'.',',').'" alt="Calificacion '.number_format($prof_fin,1,'.',',').'"/>';
            }


            $com = listAll("reviews", "WHERE r_user_id = '$id_us' AND r_type='CO' GROUP BY r_pro_id");
            $com_rows = mysql_num_rows($com);
            $review['comentarios'] = $com_rows;
            $review['global'] = $global;
            $review['trato'] = $trato_fin ;
            $review['calidad'] = $calidad_fin;
            $review['punt'] = $punt_fin;
            $review['resp'] =  $resp_fin;
            $review['prof'] = $prof_fin;


            //usuario cliente
        } else if($user['user_type'] == User::USER_TYPE_CLIENT){
            $rev = listAll("reviews", "WHERE r_user_id = '$id_us' AND r_type='C'");
            $rev_rows = mysql_num_rows($rev);
            $calification = 0;
            while ($rs_rev = mysql_fetch_object($rev)){
                $calification = $calification + $rs_rev->r_value;
            }
            $cal_final = $calification/$rev_rows;

            if($cal_final < 2){
                $review['stars'] = '<img src="images/rating_1.jpg" title="Calificacion '.number_format($cal_final,1,'.',',').' " alt="Calificacion '.number_format($cal_final,1,'.',',').'"/>';
            }else if(round($cal_final) == 2){
                $review['stars'] = '<img src="images/rating_2.jpg" title="Calificacion '.number_format($cal_final,1,'.',',').'" alt="Calificacion '.number_format($cal_final,1,'.',',').'"/>';
            }else if(round($cal_final) == 3){
                $review['stars'] = '<img src="images/rating_3.jpg" title="Calificacion '.number_format($cal_final,1,'.',',').'" alt="Calificacion '.number_format($cal_final,1,'.',',').'"/>';
            }else if(round($cal_final) == 4){
                $review['stars'] = '<img src="images/rating_4.jpg" title="Calificacion '.number_format($cal_final,1,'.',',').'" alt="Calificacion '.number_format($cal_final,1,'.',',').'"/>';
            }else if(round($cal_final) == 5){
                $review['stars'] = '<img src="images/rating_5.jpg" title="Calificacion '.number_format($cal_final,1,'.',',').'" alt="Calificacion '.number_format($cal_final,1,'.',',').'"/>';
            }
            $com = listAll("reviews", "WHERE r_user_id = '$id_us' AND r_type='CO' GROUP BY r_pro_id");
            $com_rows = mysql_num_rows($com);
            $review['comentarios'] = $com_rows;
            $review['global'] = $cal_final;

        }
	// sino tiene ningun review
	} else {
		$review['stars'] = '<img src="images/rating_0.jpg" title="Calificacion 0" alt="Calificacion 0"/>';
		$review['starsP']=0;
		$review['cal_star'] = '<img src="images/rating_0.jpg" title="Calificacion 0" alt="Calificacion 0"/>';
		$review['resp_star'] = '<img src="images/rating_0.jpg" title="Calificacion 0" alt="Calificacion 0"/>';
		$review['punt_star'] = '<img src="images/rating_0.jpg" title="Calificacion 0" alt="Calificacion 0"/>';
		$review['trato_star'] = '<img src="images/rating_0.jpg" title="Calificacion 0" alt="Calificacion 0"/>';
		$review['prof_star'] = '<img src="images/rating_0.jpg" title="Calificacion 0" alt="Calificacion 0"/>';
		$review['comentarios'] = 0;
		$review['global'] = 0;
		$review['trato'] = 0;
		$review['calidad'] = 0;
		$review['punt'] = 0;
		$review['resp'] =  0;
		$review['prof'] = 0;
	}
	
	return $review;
	
}

//funcion rating por proyecto realizado
function ratingByPro($id_pro,$id_user){
	
	$val = listAll("reviews", "WHERE r_user_eval = '$id_user' AND r_pro_id = '$id_pro'");
	$rows_val = mysql_num_rows($val);
	
	if($rows_val > 0){
	
			$calification = 0;
			$trato = 0;
			$calidad = 0;
			$prof = 0;
			$resp = 0;
			$punt = 0;
			$t=0;
			$p=0;
			$r=0;
			$pr=0;
			$ca =0;
			while ($rs_rev = mysql_fetch_object($val)){
				if($rs_rev->r_type != "CO" && $rs_rev->r_type != "F"){
				$calification = $calification + $rs_rev->r_value;
				$t++;
				}
				if($rs_rev->r_type == "CA"){
					$calidad_fin = $rs_rev->r_value;
					
				}else if($rs_rev->r_type == "T"){
					$trato_fin = $rs_rev->r_value;
					
				}else if($rs_rev->r_type == "P"){
					$punt_fin = $rs_rev->r_value;
					
				}else if($rs_rev->r_type == "R"){
					$resp_fin = $rs_rev->r_value;
					
				}else if($rs_rev->r_type == "PR"){
					$prof_fin = $rs_rev->r_value;

				}else if($rs_rev->r_type == "CO"){
					$comentario = $rs_rev->r_value;
				}
					
			}
			//totales
			$global = $calification/$t;
	
			//global
			if($global < 2){
				$review['stars'] = '<img src="images/rating_1.jpg" title="Calificacion '.number_format($global,1,'.',',').'" alt="Calificacion '.number_format($global,1,'.',',').'"/>';
			}else if(round($global) == 2){
				$review['stars'] = '<img src="images/rating_2.jpg" title="Calificacion '.number_format($global,1,'.',',').'" alt="Calificacion '.number_format($global,1,'.',',').'"/>';
			}else if(round($global) == 3){
				$review['stars'] = '<img src="images/rating_3.jpg" title="Calificacion '.number_format($global,1,'.',',').'" alt="Calificacion '.number_format($global,1,'.',',').'"/>';
			}else if(round($global) == 4){
				$review['stars'] = '<img src="images/rating_4.jpg" title="Calificacion '.number_format($global,1,'.',',').'" alt="Calificacion '.number_format($global,1,'.',',').'"/>';
			}else if(round($global) == 5){
				$review['stars'] = '<img src="images/rating_5.jpg" title="Calificacion '.number_format($global,1,'.',',').'" alt="Calificacion '.number_format($global,1,'.',',').'"/>';
			}
	
			//trato
			if($trato_fin < 2){
				$review['trato_star'] = '<img src="images/rating_1.jpg" title="Calificacion '.number_format($trato_fin,1,'.',',').'" alt="Calificacion '.number_format($trato_fin,1,'.',',').'"/>';
			}else if(round($trato_fin) == 2){
				$review['trato_star'] = '<img src="images/rating_2.jpg" title="Calificacion '.number_format($trato_fin,1,'.',',').'" alt="Calificacion '.number_format($trato_fin,1,'.',',').'"/>';
			}else if(round($trato_fin) == 3){
				$review['trato_star'] = '<img src="images/rating_3.jpg" title="Calificacion '.number_format($trato_fin,1,'.',',').'" alt="Calificacion '.number_format($trato_fin,1,'.',',').'"/>';
			}else if(round($trato_fin) == 4){
				$review['trato_star'] = '<img src="images/rating_4.jpg" title="Calificacion '.number_format($trato_fin,1,'.',',').'" alt="Calificacion '.number_format($trato_fin,1,'.',',').'"/>';
			}else if(round($trato_fin) == 5){
				$review['trato_star'] = '<img src="images/rating_5.jpg" title="Calificacion '.number_format($trato_fin,1,'.',',').'" alt="Calificacion '.number_format($trato_fin,1,'.',',').'"/>';
			}
	
			//calidad
			if($calidad_fin < 2){
				$review['cal_star'] = '<img src="images/rating_1.jpg" title="Calificacion '.number_format($calidad_fin,1,'.',',').'" alt="Calificacion '.number_format($calidad_fin,1,'.',',').'"/>';
			}else if(round($calidad_fin) == 2){
				$review['cal_star'] = '<img src="images/rating_2.jpg" title="Calificacion '.number_format($calidad_fin,1,'.',',').'" alt="Calificacion '.number_format($calidad_fin,1,'.',',').'"/>';
			}else if(round($calidad_fin) == 3){
				$review['cal_star'] = '<img src="images/rating_3.jpg" title="Calificacion '.number_format($calidad_fin,1,'.',',').'" alt="Calificacion '.number_format($calidad_fin,1,'.',',').'"/>';
			}else if(round($calidad_fin) == 4){
				$review['cal_star'] = '<img src="images/rating_4.jpg" title="Calificacion '.number_format($calidad_fin,1,'.',',').'" alt="Calificacion '.number_format($calidad_fin,1,'.',',').'"/>';
			}else if(round($calidad_fin) == 5){
				$review['cal_star'] = '<img src="images/rating_5.jpg" title="Calificacion '.number_format($calidad_fin,1,'.',',').'" alt="Calificacion '.number_format($calidad_fin,1,'.',',').'"/>';
			}
	
			//puntualidad
			if($punt_fin < 2){
				$review['punt_star'] = '<img src="images/rating_1.jpg" title="Calificacion '.number_format($punt_fin,1,'.',',').'" alt="Calificacion '.number_format($punt_fin,1,'.',',').'"/>';
			}else if(round($punt_fin) == 2){
				$review['punt_star'] = '<img src="images/rating_2.jpg" title="Calificacion '.number_format($punt_fin,1,'.',',').'" alt="Calificacion '.number_format($punt_fin,1,'.',',').'"/>';
			}else if(round($punt_fin) == 3){
				$review['punt_star'] = '<img src="images/rating_3.jpg" title="Calificacion '.number_format($punt_fin,1,'.',',').'" alt="Calificacion '.number_format($punt_fin,1,'.',',').'"/>';
			}else if(round($punt_fin) == 4){
				$review['punt_star'] = '<img src="images/rating_4.jpg" title="Calificacion '.number_format($punt_fin,1,'.',',').'" alt="Calificacion '.number_format($punt_fin,1,'.',',').'"/>';
			}else if(round($punt_fin) == 5){
				$review['punt_star'] = '<img src="images/rating_5.jpg" title="Calificacion '.number_format($punt_fin,1,'.',',').'" alt="Calificacion '.number_format($punt_fin,1,'.',',').'"/>';
			}
	
			//responsabilidad
	
			if($resp_fin < 2){
				$review['resp_star'] = '<img src="images/rating_1.jpg" title="Calificacion '.number_format($resp_fin,1,'.',',').'" alt="Calificacion '.number_format($resp_fin,1,'.',',').'"/>';
			}else if(round($resp_fin) == 2){
				$review['resp_star'] = '<img src="images/rating_2.jpg" title="Calificacion '.number_format($resp_fin,1,'.',',').'" alt="Calificacion '.number_format($resp_fin,1,'.',',').'"/>';
			}else if(round($resp_fin) == 3){
				$review['resp_star'] = '<img src="images/rating_3.jpg" title="Calificacion '.number_format($resp_fin,1,'.',',').'" alt="Calificacion '.number_format($resp_fin,1,'.',',').'"/>';
			}else if(round($resp_fin) == 4){
				$review['resp_star'] = '<img src="images/rating_4.jpg" title="Calificacion '.number_format($resp_fin,1,'.',',').'" alt="Calificacion '.number_format($resp_fin,1,'.',',').'"/>';
			}else if(round($resp_fin) == 5){
				$review['resp_star'] = '<img src="images/rating_5.jpg" title="Calificacion '.number_format($resp_fin,1,'.',',').'" alt="Calificacion '.number_format($resp_fin,1,'.',',').'"/>';
			}
			//profesionalismo
	
			if($prof_fin < 2){
				$review['prof_star'] = '<img src="images/rating_1.jpg" title="Calificacion '.number_format($prof_fin,1,'.',',').'" alt="Calificacion '.number_format($prof_fin,1,'.',',').'"/>';
			}else if(round($prof_fin) == 2){
				$review['prof_star'] = '<img src="images/rating_2.jpg" title="Calificacion '.number_format($prof_fin,1,'.',',').'" alt="Calificacion '.number_format($prof_fin,1,'.',',').'"/>';
			}else if(round($prof_fin) == 3){
				$review['prof_star'] = '<img src="images/rating_3.jpg" title="Calificacion '.number_format($prof_fin,1,'.',',').'" alt="Calificacion '.number_format($prof_fin,1,'.',',').'"/>';
			}else if(round($prof_fin) == 4){
				$review['prof_star'] = '<img src="images/rating_4.jpg" title="Calificacion '.number_format($prof_fin,1,'.',',').'" alt="Calificacion '.number_format($prof_fin,1,'.',',').'"/>';
			}else if(round($prof_fin) == 5){
				$review['prof_star'] = '<img src="images/rating_5.jpg" title="Calificacion '.number_format($prof_fin,1,'.',',').'" alt="Calificacion '.number_format($prof_fin,1,'.',',').'"/>';
			}
	
	
			
			
			$review['comentario'] = $comentario;
			$review['global'] = $global;
			$review['trato'] = $trato_fin ;
			$review['calidad'] = $calidad_fin;
			$review['punt'] = $punt_fin;
			$review['resp'] =  $resp_fin;
			$review['prof'] = $prof_fin;
			}else{
				$review['stars'] = '<img src="images/rating_1.jpg" title="Calificacion 0" alt="Calificacion 0"/>';
				$review['resp_star'] = '<img src="images/rating_1.jpg" title="Calificacion 0" alt="Calificacion 0"/>';
				$review['punt_star'] = '<img src="images/rating_1.jpg" title="Calificacion 0" alt="Calificacion 0"/>';
				$review['trato_star'] = '<img src="images/rating_1.jpg" title="Calificacion 0" alt="Calificacion 0"/>';
				$review['prof_star'] = '<img src="images/rating_1.jpg" title="Calificacion 0" alt="Calificacion 0"/>';
				$review['comentarios'] = "";
				$review['global'] = 1;
				$review['trato'] = 1 ;
				$review['calidad'] = 1;
				$review['punt'] = 1;
				$review['resp'] =  1;
				$review['prof'] = 1;
			}
			
			return $review;
	
}

function compress($source, $destination, $quality) { 
	$info = getimagesize($source); 
	if ($info['mime'] == 'image/jpeg') 
		$image = imagecreatefromjpeg($source); 
	elseif ($info['mime'] == 'image/gif') 
		$image = imagecreatefromgif($source); 
	elseif ($info['mime'] == 'image/png') 
		$image = imagecreatefrompng($source); 
	
	imagejpeg($image, $destination, $quality); 
	return $destination; 
}
	

function porPagar($userId){
	$mov = listAll("proyectos,pro_transactions", "WHERE user_id = '$_COOKIE[id]' AND t_pro_id = pro_id AND t_status ='P' ORDER BY t_pdate DESC");
	$total = 0;
	while($rs_mov = mysql_fetch_object($mov)){
		$oferta =listAll("ofertas", "WHERE pro_id = '$rs_mov->pro_id' AND awarded='S'");
		$rs_oferta = mysql_fetch_object($oferta);
		$total = $total + $rs_oferta->bid;
	}
	return $total;
	
}

function getOferta($pro_id, $user_id){
	$oferta_user = listAll("ofertas","WHERE pro_id = '$pro_id' AND user_id = '$user_id'");
	$rows_oferta = mysql_num_rows($oferta_user);
	$rs_oferta = mysql_fetch_object($oferta_user);
	if($rows_oferta > 0){
		$oferta['monto'] = $rs_oferta->bid;
		$oferta['propuesta'] = $rs_oferta->mensaje;
		$oferta['fecha'] = $rs_oferta-> cdate;
		$oferta['awarded'] = $rs_oferta->awarded;
		$oferta['id'] = $rs_oferta->id;
		return $oferta;
	}else{
		return false;
	}
}

function delete_directory($dirname) {
    define('DS', DIRECTORY_SEPARATOR);
    $basePath = __DIR__ . DS;

    $dirname = $basePath.'../'.$dirname;

    $dir_handle = false;

    if (is_dir($dirname)){
        $dir_handle = opendir($dirname);
    }
    if (!$dir_handle){
        return false;
    }
    while($file = readdir($dir_handle)) {
        if ($file != "." && $file != "..") {
            if (!is_dir($dirname."/".$file))
                unlink($dirname."/".$file);
            else
                delete_directory($dirname.'/'.$file);
        }
    }
    closedir($dir_handle);
    rmdir($dirname);
    return true;
}

function setReferer($uri = null){
    $finalUri = ($uri != null) ? $uri : $_SERVER['REQUEST_URI'];
    setcookie('referer', $finalUri, 0);
}

function clearReferer(){
    setcookie("referer", "", time()-3600);
}

function getReferer(){
    if (isset($_COOKIE['referer'])){
        return $_COOKIE['referer'];
    } else {
        return null;
    }
}