<?php
use Fototea\Config\FConfig;
use Fototea\Models\User;
use Fototea\Models\UserDetail;
use Fototea\Util\FAnalytics;
use Fototea\Util\FMailer;

require '../vendor/autoload.php';

include_once '../scripts/libSM.php';

$user_name = $app->getRequest()->get('name');
$user_lastname = $app->getRequest()->get('lastname');
$user_email = $app->getRequest()->get('email');
$user_pass = $app->getRequest()->get('pass');
$user_type = $app->getRequest()->get('userType');

$ru = $app->getRequest()->get('ru');
$rm = $app->getRequest()->get('rm');
if (!empty($ru) && !empty($rm)){
    $isReferred = true;
} else {
    $isReferred = false;
}

// Create user
$user = $app->getModel('User')->create($user_name, $user_lastname, $user_email, $user_pass, $user_type);

if(isset($user->id)){
    // Initialize user detail
    UserDetail::init($user->id, $user->user_type);

    $to = $user_email;
    $toName = $user_name.' '.$user_lastname;
    $confirmUrl = FConfig::getUrl('confirmacion').'?c='.$user->act_code;

    if ($isReferred){
        $confirmUrl .= '&ru='.$ru.'&rm='.$rm;
    }

    $asunto= "Confirmación de registro";

    $params = array(
        'site_url' => FConfig::getUrl(),
        'logo_url' => FConfig::getUrl('images/logo_footer.png'),
        'nombre' => $toName,
        'confirmacion_url' => $confirmUrl,
    );

    $body = FMailer::replaceParameters($params, file_get_contents('../views/emails/registroEmail.html'));

    $mailer = new FMailer();
    $receivers = array(
        array('email' => $to, 'name' => $toName),
    );
    $mailer->setReceivers($receivers);
    $mailer->sendEmail($asunto, $body);

    // Event: Creación de perfil
    $events = FAnalytics::getInstance();
    if ($user_type == User::USER_TYPE_PHOTOGRAPHER){
        $events->trackEvent('Usuario - Creaciones de perfil', 'Creación de fotógrafo', $user->id);
    } elseif ($user_type == User::USER_TYPE_CLIENT){
        $events->trackEvent('Usuario - Creaciones de perfil', 'Creación de cliente', $user->id);
    }

    if ($isReferred){
        if ($user_type == User::USER_TYPE_PHOTOGRAPHER){
            $events->trackEvent('Referidos - Creaciones de perfil', 'Creación de fotógrafo referido desde '.$rm, $ru);
        } elseif ($user_type == User::USER_TYPE_CLIENT){
            $events->trackEvent('Referidos - Creaciones de perfil', 'Creación de cliente referido desde '.$rm, $ru);
        }
    }

    $arreglo[] = array('resp' => "Se ha enviado la información", 'user_id' => $user_insert);
    echo json_encode($arreglo);
}
?>