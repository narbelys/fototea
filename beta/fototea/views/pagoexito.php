<?php
/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 6/13/14
 * Time: 1:44 AM
 */

use Fototea\Models\PaymentManager;
use Fototea\Models\Payment;
use Fototea\Models\Product;
use Fototea\Models\PuntoPagos;
use Fototea\Models\OrderProduct;
use Fototea\Util\UrlHelper;

$file = 'pagoexito.txt';

$content = "-----------------------------------------------------------------------------------------";
$content .= "\nGET\n";
$content .= json_encode($_GET);

$content .= "\n\nPOST\n";
$content .= json_encode($_POST);
$content .= "\n\n";

//file_put_contents($file, $content, FILE_APPEND);

$token = $app->getRequest()->get('token');

$paymentMethod = new PaymentManager($app, PuntoPagos::PAYMENT_METHOD_TYPE);
$paymentMethod->loadByGatewayId($token);

if ($paymentMethod->getStatus() === Payment::PAYMENT_STATUS_APPROVED) {

    $products = OrderProduct::getProductsByOrderId($paymentMethod->getOrderId());
    if (empty($products)){
        //TODO correo aqui
        //TODO log
        $processResult = 99;
    }

    foreach ($products as $product){
        //Aplicar cambios segun cada producto
        if ($product->id == Product::PRODUCT_ADJUDICAR_ID) {
            $productData = json_decode($product->data);
            $msg = 'El proyecto ha sido adjudicado de forma exitosa. <a href="' . UrlHelper::getProjectUrl($productData->project_id) . '">Ir al proyecto</a>';
        }
    }
}
?>

<div class="content-container">
    <div class="content form-page" id="metodo-pago-container">

        <h2>Confirmación del pago</h2>
        <form action="actions/paymentAction.php" method="post" id="metodo-pago-form" class="metodo-pago-form">
            <p><b>¡Hemos recibido tu pago!</b></p>

            <p>Mas instrucciones aqui</p>

            <p><?php echo $msg ?></p>
        </form>
    </div>
</div>