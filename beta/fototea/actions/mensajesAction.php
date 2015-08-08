<?php
use Fototea\Config\FConfig;
use Fototea\Util\FMailer;
require '../vendor/autoload.php';

include_once '../scripts/libSM.php';

$session = validaSession();
$act = $_REQUEST['act'];
if($session == true){

	//new message
	if($act == "nuevoMensaje"){
		
		$to = $_REQUEST['to'];
		$from = $_COOKIE['id'];
		$subject = $_REQUEST['subject'];
		$message = preg_replace("/\n/","<br/>",$_REQUEST['mensaje']);		
	
		if($_REQUEST['pro_id'] != "" || $_REQUEST['pro_id'] != "0"){
			$pro_id = $_REQUEST['pro_id'];
		}
		$mensaje_ins = insertTable("mensajes", "'','$to','$from','$subject','$pro_id',NOW()");
		
		//message detail
		insertTable("mensajes_det", "'','$mensaje_ins','$to','$from','$message',NOW()");	
		//status sender
		insertTable("mensajes_status", "'','$mensaje_ins','$from','L'");
		//status recipient
		insertTable("mensajes_status", "'','$mensaje_ins','$to','N'");
		
		$user = listAll("user", "WHERE id = '$to'");
		$rs_mensaje = mysql_fetch_object($user);
		$to_m = $rs_mensaje->user;
        $toName = $rs_mensaje->name.' '.$rs_mensaje->lastname;
		
		$userFrom = listAll("user", "WHERE id = '$from'");
		$rs_from = mysql_fetch_object($userFrom);
		
		$asunto= "Mensaje privado!";
		
        $params = array(
            'site_url' => FConfig::getUrl(),
            'logo_url' => FConfig::getUrl('images/logo_footer.png'),
            'nombre' => $toName,
            'from_name' => $rs_from->name.' '.$rs_from->lastname,
        );

        $body = FMailer::replaceParameters($params, file_get_contents('../views/emails/mensajeEmail.html'));

        $mailer = new FMailer();
        $receivers = array(
            array('email' => $to_m, 'name' => $toName),
        );
        $mailer->setReceivers($receivers);
        $mailer->sendEmail($asunto, $text);
		
		$arreglo[] = array('resp' => "Se ha enviado la información");
		echo json_encode($arreglo);
	}
	
	/*marcar como leido
	if($act == "leido"){
		$m_id = $_REQUEST['mensaje_id'];
		$user_id = $_COOKIE['id'];
		
		$arreglo[] = array('resp' => "Se ha enviado la información");
		echo json_encode($arreglo);
	}*/
	
	if($act == "borrarMensaje"){
		$m_id = $_REQUEST['mensaje_id'];
		$user_id = $_COOKIE['id'];
		updateTable("mensajes_status", "ms_status='B'", "ms_m_id='$m_id' AND ms_user_id = '$user_id'");
		$arreglo[] = array('resp' => "Se ha enviado la información");
		echo json_encode($arreglo);
	}
	
	if($act == "replayMensaje"){
		
		$m_id = $_REQUEST['m_id'];
		$from = $_REQUEST['m_from'];
		$to = $_REQUEST['m_to'];
		$txt = preg_replace("/\n/","<br/>",$_REQUEST['mensaje']);
		
		//marcar como nuevo
		updateTable("mensajes_status", "ms_status='N'", "ms_m_id='$m_id' AND ms_user_id = '$to'");
		//guardar mensaje
		insertTable("mensajes_det", "'','$m_id','$to','$from','$txt',NOW()");
		
		$user = listAll("user", "WHERE id = '$to'");
		$rs_mensaje = mysql_fetch_object($user);
		$to_m = $rs_mensaje->user;
        $toName = $rs_mensaje->name.' '.$rs_mensaje->lastname;
		
		$userFrom = listAll("user", "WHERE id = '$from'");
		$rs_from = mysql_fetch_object($userFrom);
		
		$asunto= "Mensaje privado!";
		
        $params = array(
            'site_url' => FConfig::getUrl(),
            'logo_url' => FConfig::getUrl('images/logo_footer.png'),
            'nombre' => $toName,
            'from_name' => $rs_from->name.' '.$rs_from->lastname,
        );

        $body = FMailer::replaceParameters($params, file_get_contents('../views/emails/mensajeEmail.html'));

        $mailer = new FMailer();
        $receivers = array(
            array('email' => $to_m, 'name' => $toName),
        );
        $mailer->setReceivers($receivers);
        $mailer->sendEmail($asunto, $text);
		
		$arreglo[] = array('resp' => "Se ha enviado la información");
		echo json_encode($arreglo);
	}
	
	
}
?>