<?php
use Fototea\Config\FConfig;
use Fototea\Util\FMailer;
require '../vendor/autoload.php';

include_once '../scripts/libSM.php';

$variables = print_r($_REQUEST,true);

$pro_id = $_REQUEST['p'];
$oferta_id = $_REQUEST['of'];
$txn_id = $_REQUEST['txn_id'];
$monto = $_REQUEST['mc_gross'];
$payer_email = $_REQUEST['payer_email'];
$receiver_email = $_REQUEST['receiver_email'];
$payment_status = $_REQUEST['payment_status'];

insertTable("paypal","'$variables',NOW()");

$oferta = listAll("ofertas", "WHERE id = '$oferta_id' AND pro_id = '$pro_id'");
$row = mysql_num_rows($oferta);
$rs_oferta = mysql_fetch_object($oferta);
$user_oferta = getUserInfo($rs_oferta->user_id);

$proyecto = listAll("proyectos", "WHERE pro_id = '$pro_id'");
$rs_proyecto = mysql_fetch_object($proyecto);
$user_pro = getUserInfo($rs_proyecto->user_id);

if($row > 0 && $payment_status == "Completed" && $receiver_email == "paulogoncalvesr@gmail.com"){

    //update transacition log
    updateTable("pro_transactions", "t_status='L',t_pdate= NOW(),t_trans_id = '$txn_id', t_monto = '$monto', usuario_pago = '$payer_email'", "t_pro_id = '$pro_id' AND t_oferta_id = '$oferta_id'");

    $comision = $rs_oferta->bid * 0.15;

    //enviar correo al administrador notificandole los datos de transferencia del fotografo.
    $to = "pagos@fototea.com";
    //$to = "sharkam@gmail.com";
    $asunto= "Nuevo pago recibido";

    $params = array(
        'site_url' => FConfig::getUrl(),
        'logo_url' => FConfig::getUrl('images/logo_footer.png'),
        'project_title' => $rs_proyecto->pro_tit,
        'project_user_name' => $user_pro['name'].' '.$user_pro['lastname'],
        'amount' => number_format($rs_oferta->bid,2,',','.'),
        'comission' => number_format($comision,2,',','.'),
        'total' => number_format($monto,2,',','.'),
        'transaction_id' => $txn_id,
        'oferta_username' => $user_oferta['name'].' '.$user_oferta['lastname'],
        'user_paypal' => $user_oferta['user_pago'],
        'user_phone' => $user_oferta['telefono'].' / '.$user_oferta['movil'],
        'user_email' => $user_oferta['email'],
        'amount_to_transfer' => number_format($rs_oferta->bid,2,',','.'),
    );

    $body = FMailer::replaceParameters($params, file_get_contents('../views/emails/nuevoPagoRecibidoEmail.html'));

    $mailer = new FMailer();
    $receivers = array(
        array('email' => $to),
    );
    $mailer->setReceivers($receivers);
    $mailer->sendEmail($asunto, $body);

    //enviar correo de confirmacion al cliente que realizao el pago.
    $to = $user_pro['email'];

    $asunto= "Tu pago se ha realizado con éxito";

    $params = array(
        'site_url' => FConfig::getUrl(),
        'logo_url' => FConfig::getUrl('images/logo_footer.png'),
        'user_name' => $user_pro['name'].' '.$user_pro['lastname'],
        'project_title' => $rs_proyecto->pro_tit,
        'oferta_username' => $user_oferta['name'].' '.$user_oferta['lastname'],
        'amount' => number_format($rs_oferta->bid,2,',','.'),
        'comission' => number_format($comision,2,',','.'),
        'total' => number_format($monto,2,',','.'),
        'transaction_id' => $txn_id,
    );

    $body = FMailer::replaceParameters($params, file_get_contents('../views/emails/pagoRealizadoExitoEmail.html'));

    $mailer = new FMailer();
    $receivers = array(
        array('email' => $to),
    );
    $mailer->setReceivers($receivers);
    $mailer->sendEmail($asunto, $body);

    //enviar correo de notificacion al fotografo de procesamiento de pago.

    $not_user = insertTable("notificaciones", "'','$user_oferta[id]','Has recibido un pago por el proyecto ".$rs_proyecto->pro_tit."','cuentaEstado',NOW(),'N'");


    $to = $user_oferta['email'];

    $asunto= "Hemos recibido un pago para ti!";

    $params = array(
        'site_url' => FConfig::getUrl(),
        'logo_url' => FConfig::getUrl('images/logo_footer.png'),
        'user_name' => $user_oferta['name'].' '.$user_oferta['lastname'],
        'project_title' => $rs_proyecto->pro_tit,
        'project_username' => $user_pro['name'].' '.$user_pro['lastname'],
        'amount' => number_format($rs_oferta->bid,2,',','.'),
    );

    $body = FMailer::replaceParameters($params, file_get_contents('../views/emails/recibidoPagoEmail.html'));

    $mailer = new FMailer();
    $receivers = array(
        array('email' => $to),
    );
    $mailer->setReceivers($receivers);
    $mailer->sendEmail($asunto, $body);

}
?>