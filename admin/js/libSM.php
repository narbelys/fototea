<?php

//funcion para validar session
function validaSession(){
	if(!isset($_COOKIE['id'])){
		header("location:index.php");
	}
}
//fin funcion

//funcion para validar acceso al modulo
function securityValidation($id,$level){
	
$level_sql = "SELECT * FROM security WHERE users_id = '$id' AND modules_id = '$level'";
$level_query = mysql_query($level_sql);
$row_level = mysql_num_rows($level_query);

if( $row_level == 1){
	$sec = 1;
}

if ($sec != 1){
	header("location:errorAcceso.php");
}
}
//fin funtion


//funcion para validar acceso al modulo
function moduleValidation($id,$level){
	
$level_sql = "SELECT * FROM security WHERE users_id = '$id' AND modules_id = '$level'";
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
function listAll($table,$where){
	
	$sql_all = "SELECT * FROM ".$table." ".$where;
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
  	if(is_uploaded_file($_FILES[$file]['tmp_name'])){
		    copy($_FILES[$file]['tmp_name'], $dir.$nombre_archivo_temp);
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
	
	
	$query_salt = mysql_query("SELECT salt FROM users WHERE user = '".$user."'");
	$num_salt = mysql_num_rows($query_salt);
	if($num_salt < 1 ){
		return false;
	}else{
		$rs_salt = mysql_fetch_array($query_salt);
		$pass_u = sha1($pass);
		$password = sha1($rs_salt[0].$pass_u);
		
		$query_login = mysql_query("SELECT * FROM users WHERE user = '".$user."' AND pass = '".$password."'");
		$num_login = mysql_num_rows ($query_login);
	if ($num_login < 1){
		return false;
	}else{
		$rs_user = mysql_fetch_object($query_login);
		$name = $rs_user->name." ".$rs_user->lastname;
		setcookie("user",$name,0);
		setcookie("id",$rs_user->id,0);
		return true;
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

//funcion generar salt
function salt(){
	
	$salt = sha1(time());
	return $salt;
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
// function para fecha en letras y dia en espanol
function dateSpanish($fdate){
	
	$f = explode(" ",$fdate);
	$d = explode("-",$f[0]);
	
	switch($d[1]){
		case 1:
		$mes = "Enero";
		break;
		case 2:
		$mes = "Febrero";
		break;
		case 3:
		$mes = "Marzo";
		break;
		case 4:
		$mes = "Abril";
		break;
		case 5:
		$mes = "Mayo";
		break;
		case 6:
		$mes = "Junio";
		break;
		case 7:
		$mes = "Julio";
		break;
		case 8:
		$mes = "Agosto";
		break;
		case 9:
		$mes = "Septiembre";
		break;
		case 10:
		$mes = "Octubre";
		break;
		case 11:
		$mes = "Noviembre";
		break;
		case 12:
		$mes = "Diciembre";
		break;
	}
	
	
	$date = $d[2]." de ".$mes." de ".$d[0];
	return $date;
}
//fin



//funcion generar contrasena
function RandomString($length=10,$uc=TRUE,$n=TRUE,$sc=FALSE){
    $source = 'abcdefghijklmnopqrstuvwxyz';
    if($uc==1) $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if($n==1) $source .= '1234567890';
    if($sc==1) $source .= '|@#~$%()=^*+[]{}-_';
    if($length>0){
        $rstr = "";
        $source = str_split($source,1);
        for($i=1; $i<=$length; $i++){
            mt_srand((double)microtime() * 1000000);
            $num = mt_rand(1,count($source));
            $rstr .= $source[$num-1];
        }
    }
    return $rstr;
}
// fin


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
	$fb = getUserData($id, "8");
	$tw = getUserData($id, "9");
	$exp = getUserData($id, "14");
	$cam = getUserData($id, "11");
	$lentes = getUserData($id, "12");
	$equip = getUserData($id, "13");
	$cover = getUserData($id, "16");
	$user_pago = getUserData($id, "17");

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
	$user['descripcion'] = $descripcion->description;
	$user['user_img']= $user_img->description;
	$user["name"] = $usr_info->name;
	$user['lastname'] = $usr_info->lastname;
	$user['dob']= dateSpanish($usr_info->dob);
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
	$user['fb'] = $fb->description;
	$user['tw'] = $tw->description;
	$user['exp'] = $exp->description;
	$user['cam'] = $cam->description;
	$user['lentes'] = $lentes->description;
	$user['equip'] = $equip->description;
	$user["act_code"] = $usr_info->act_code;
	$user['user_cover'] = $cover->description;
	$user['user_pago'] = $user_pago->description;



	return $user;
}
function getUserData($idUser,$idData){

	$usr_q = listAll("user_det", "WHERE id_user = '$idUser' AND id_data = '$idData'");
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


?>