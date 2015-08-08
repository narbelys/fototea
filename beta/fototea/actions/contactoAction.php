<?php
use Fototea\Config\FConfig;
use Fototea\Util\FMailer;
require '../vendor/autoload.php';

    $name = $_REQUEST['name'];
    $mensaje = $_REQUEST['mensaje'];
    $email = $_REQUEST['email'];

	$asunto = $_REQUEST['asunto'];

    $params = array(
        'site_url' => FConfig::getUrl(),
        'logo_url' => FConfig::getUrl('images/logo_footer.png'),
        'nombre' => $name,
        'email' => $email,
        'asunto' => $asunto,
        'mensaje' => $mensaje,
    );

    $body = FMailer::replaceParameters($params, file_get_contents('../views/emails/contactoEmail.html'));

    $mailer = new FMailer();
    $receivers = array(
        array('email' => FConfig::getValue('contacto_email'), 'name' => FConfig::getValue('contacto_name')),
    );
    $mailer->setReceivers($receivers);
    $mailer->sendEmail($asunto, $body);

    $arreglo[] = array('resp' => "Se ha enviado la información");
    echo json_encode($arreglo);

?>