<?php
/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 6/13/14
 * Time: 1:44 AM
 */

use Fototea\Util\DateHelper;
use Fototea\Models\Order;
use Fototea\Models\OrderProduct;
use Fototea\Models\Payment;
use Fototea\Models\PaymentManager;
use Fototea\Models\Product;
use Fototea\Models\Project;
use Fototea\Models\PuntoPagos;
use Fototea\Models\AdjudicationManager;
//var_dump($app->getRequest()->server());

//var_dump($app->getRequest()->headers('cache-control'));

//TODO Importante blindar este método!!!!! varias fugas

//die();

// INIT - ONLY FOR TEST PURPOSES
$file = 'puntopago.txt';

$content = "-----------------------------------------------------------------------------------------\n";
$content .= DateHelper::getCurrentDateTime();
$content .= "-----------------------------------------------------------------------------------------\n";
$content .= "\nGET\n";
$content .= json_encode($_GET);

$content .= "\n\nPOST\n";
$content .= json_encode($_POST);
$content .= "\n\n";

//file_put_contents($file, $content, FILE_APPEND);

// END - ONLY FOR TEST PURPOSES

$token = $app->getRequest()->get('token');
$processResult = 00;

if (empty($token)){
    $processResult = 99;
} else {
    //TODO falta validar la firma....

    $paymentMethod = new PaymentManager($app, PuntoPagos::PAYMENT_METHOD_TYPE);
    $paymentMethod->loadByGatewayId($token);
    $paymentMethod->updateStatus();

    $orderId = $paymentMethod->getOrderId();

    $order = Order::getOrder($orderId);

    if ($paymentMethod->getStatus() == Payment::PAYMENT_STATUS_APPROVED) {
        $order->set('status', Order::ORDER_STATUS_COMPLETED);
    } else {
        $order->set('status', Order::ORDER_STATUS_FAILED);
    }

    $order->save();

    if ($paymentMethod->getStatus() == Payment::PAYMENT_STATUS_APPROVED) {
        //Sacar order products
        $products = OrderProduct::getProductsByOrderId($order->id);

        if (empty($products)){
            //TODO correo aqui
            //TODO log
            $processResult = 99;
        }

        foreach ($products as $product){
            //Aplicar cambios segun cada producto
            if ($product->id == Product::PRODUCT_ADJUDICAR_ID) {
                //TODO validar offer id  y project id
                $result = AdjudicationManager::adjudicateProject($data->project_id, $data->offer_id);

                if (!$result) {
                    //Falló adjudicacion
                    //TODO notificar a paulo
                }
            }
        }
    } else {
        $processResult = 99;
    }
}

// Notificar al gateway (mandar la respuesta que ellos esperan)
$response = new \stdClass();
$response->respuesta = $processResult;
$response->token = $token;

$app->getResponse()->jsonResponse($response);