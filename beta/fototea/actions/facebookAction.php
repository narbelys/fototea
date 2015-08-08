<?php
use Fototea\Config\FConfig;
use Fototea\Util\FMailer;
use Fototea\Util\StringHelper;

require '../vendor/autoload.php';

include_once '../scripts/libSM.php';
require '../scripts/facebook-php-sdk/src/facebook.php';

$facebook = new Facebook(array(
		'appId'  => '1439029029658789',
		'secret' => '7d2b3d38d73c4f61aa0bae0f6f09177c',
));

$signed_request = $facebook->getSignedRequest();

$data = $signed_request['registration'];

$bday=  explode("/",$data['birthday']);
$gender = "";
$g = $data['gender'];
if($g == "male"){
	$gender = "H";
}else if($g == "female"){
	$gender = "M";
}

$user_name = utf8_decode($data['first_name']);
$user_lastname = utf8_decode($data['last_name']);
$user_gender = $gender;
$user_email = $data['email'];
$user_pass = sha1($data['password']);
$user_dob = $bday[2]."-".$bday[0]."-".$bday[1];
$user_type = $data['user_type'];
$user_salt = salt(); // TODO: ESTA FUNCION SE MIGRO AL MODELO DE USER
$user_act = "N";
$user_act_code = StringHelper::generateRandomString();
$passEnc = sha1($user_salt.$user_pass);
$reg = listAll("user", "WHERE user = '$user_email'");
$reg_num = mysql_num_rows($reg);

if($reg_num < 1){
	$user_insert = insertTable("user", "'','$user_name','$user_lastname','$user_dob','$user_gender','$user_email','$passEnc','$user_salt','$user_type',NOW(),'0000-00-00 00:00:00','$user_act','$user_act_code', false, false");
	
    if($user_insert > 0){

        $to = $user_email;
        $toName = $user_name.' '.$user_lastname;

        $asunto= "Confirmación de registro";

        $params = array(
            'site_url' => FConfig::getUrl(),
            'logo_url' => FConfig::getUrl('images/logo_footer.png'),
            'nombre' => $toName,
            'confirmacion_url' => FConfig::getUrl('confirmacion').'?c='.$user_act_code.'&e='.$user_email,
        );

        $body = FMailer::replaceParameters($params, file_get_contents('../views/emails/registroEmail.html'));

        $mailer = new FMailer();
        $receivers = array(
            array('email' => $to, 'name' => $toName),
        );
        $mailer->setReceivers($receivers);
        $mailer->sendEmail($asunto, $body);

        header("location:../confirmacionRegistro");
    }
}else{
    header("location:../confirmacionRegistro?e=error");

}
?>