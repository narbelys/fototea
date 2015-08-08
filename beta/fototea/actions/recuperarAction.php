<?php
use Fototea\Config\FConfig;
use Fototea\Util\FMailer;
require '../vendor/autoload.php';

include_once '../scripts/libSM.php';
$user_email = $_REQUEST['user'];
$act_code = $_REQUEST['act-code'];

//action recover password
if($_REQUEST['act']=="recuperar"){
    $rs_user = mysql_fetch_object(listAll("user", "WHERE user = '$user_email'"));

    $to = $rs_user->user;
    $toName = $rs_user->name.' '.$rs_user->lastname;

    $asunto= "Recuperar contraseña";

    $params = array(
        'site_url' => FConfig::getUrl(),
        'logo_url' => FConfig::getUrl('images/logo_footer.png'),
        'nombre' => $toName,
        'recuperar_url'=> FConfig::getUrl('reinicia-contrasena').'?c='.$rs_user->act_code,
    );

    $body = FMailer::replaceParameters($params, file_get_contents('../views/emails/recuperarContrasenaEmail.html'));

    $mailer = new FMailer();
    $receivers = array(
        array('email' => $to, 'name' => $toName),
    );
    $mailer->setReceivers($receivers);
    $mailer->sendEmail($asunto, $body);

    $arreglo[] = array('resp' => "Se ha enviado la información");
    echo json_encode($arreglo);

}


//action rest password
if($_REQUEST['act']=="reset"){
	
	$pass = sha1($_REQUEST['pass']);
	$rs_user2 = mysql_fetch_object(listAll("user", "WHERE act_code = '$act_code'"));
	$salt = $rs_user2->salt;
	$newPass = sha1($salt.$pass);
	updateTable("user", "password = '$newPass'", "act_code = '$act_code'");
	$arreglo[] = array('resp' => "Se ha enviado la información");
	echo json_encode($arreglo);
}

?>