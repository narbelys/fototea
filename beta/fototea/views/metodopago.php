<?php
/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 6/14/14
 * Time: 5:00 PM
 */

use Fototea\Models\Deposit;
use Fototea\Models\PuntoPagos;
use Fototea\Models\Transfer;

$cart = $app->getCart();

//If cart is empty, dont show this screen
if ($cart->isEmpty()) {
    $app->redirect($app->getHelper('UrlHelper')->getProfileUrl($currentUser->act_code));
}

/** @var \Fototea\Models\Offer $offerModel */
$offerModel = $app->getModel('Offer');

/** @var \Fototea\Models\Project $projectModel */
$projectModel = $app->getModel('Project');

/** @var \Fototea\Models\User $userModel */
$userModel = $app->getModel('User');

$items = $cart->getItems();
$total = $cart->getSubtotal();

$product = array_shift($items);
$productData = json_decode($product->data);

$offer = $offerModel->getOffer($productData->offer_id);
$project = $projectModel->loadById($productData->project_id);
$winner = $userModel->getUserInfo($offer->user_id, array($userModel::PROFILE_DIRECTION));

?>

<div class="content-container">
    <div class="content form-page" id="metodo-pago-container">

        <h2>Adjudicar Proyecto</h2>
        <form action="actions/paymentAction.php" method="post" id="metodo-pago-form" class="metodo-pago-form">

            <p>Breve descripción de como funciona el proceso de adjudicación de Fototea aquí</p>

            <div class="sub-title">
                <i class="glyphicon glyphicon-chevron-right"></i>Detalle de la adjudicaci&oacute;n
            </div>

            <p>Tu proyecto: <b><?php echo $project->pro_tit ?></b></p>
            <p>Creativo seleccionado: <b><?php echo $winner['full_name'] ?></b></p>
            <p>Monto de la adjudicaci&oacute;n <b>$<?php echo $product->price ?></b></p>

            <div class="sub-title">
                <i class="glyphicon glyphicon-chevron-right"></i>Selecciona el m&eacute;todo de pago
            </div>
            <div class="form-group">
                <div class="radio">
                    <label>
                        <input type="radio" name="payment_method" id="payment_method" value="<?php echo PuntoPagos::PAYMENT_METHOD_TYPE ?>">
                        WebPay
                    </label>
                </div>

                <div class="box-bd box-bdr pal">
                    <fieldset class="ui-fieldset">
                        <div style="display: none;" class="s-error msgBox" id="PaymentMethodError"></div>
                        <div id="checkout-payment"><div id="paymentContainer">
                                <input type="hidden" value="1" name="PaymentMethod[empty]">

                                <input type="hidden" name="mainPaymentMethod" value="WebPayPayment" id="mainPaymentMethod"><input type="hidden" name="mainPaymentOption" id="mainPaymentOption"><input type="hidden" name="mainPaymentType" value="creditcard" id="mainPaymentType">    <div class="ui-formRow payment-method ">
                                    <div class="collection h4 pbs ui-borderBottom hasTooltip">
                                        <input type="radio" name="PaymentMethodForm[payment_method]" id="redcompra" class="payment-method-option ui-inputRadio lfloat" value="WebPayPayment">            <label for="redcompra">
                                            Redcompra
                                            <div title="More Information" class="rfloat tooltipIcon"></div>
                                        </label>
                                        <div class="hidefirst checkoutTooltip txtLight normal" style="left: 285px; display: none;">
                                            <div class="checkoutTooltipArrow"></div>
                                            Al hacer click en Finalizar Compra, te redirigirás al sitio de Webpay, y se abrirá en una ventana emergente. Debes tener tu tarjeta a mano y el generador de claves de internet.            </div>
                                    </div>

                                    <div class="ui-formRow payment-method-form payment-method-redcompra hidefirst">
                                        <div class="desc">
                                            <p><img alt="Webpay Logo" src="https://secure.footprint.net/dafiticl/images/dafiti/payment-methods/webpay-redcompra.png"></p>
                                            Al hacer click en Finalizar Compra, te redirigirás al sitio de Webpay, y se abrirá en una ventana emergente. Debes tener tu tarjeta a mano y el generador de claves de internet.
                                        </div>
                                    </div>
                                </div>
                                <div class="ui-formRow payment-method ">
                                    <div class="collection h4 pbs ui-borderBottom hasTooltip">
                                        <input type="radio" name="PaymentMethodForm[payment_method]" checked="checked" id="creditcard" class="payment-method-option ui-inputRadio lfloat" value="WebPayPayment">            <label for="creditcard">
                                            Tarjetas de Crédito <div title="More Information" class="rfloat tooltipIcon"></div>
                                        </label>
                                        <div class="hidefirst checkoutTooltip txtLight normal" style="left: 285px; display: none;">
                                            <div class="checkoutTooltipArrow"></div>
                                            Al hacer click en Finalizar Compra, te redirigirás al sitio de Webpay, y se abrirá en una ventana emergente. Debes tener tu tarjeta a mano y el generador de claves de internet.            </div>
                                    </div>

                                    <div class="ui-formRow payment-method-form payment-method-creditcard">
                                        <div class="desc">
                                            <p><img alt="Webpay Logo" src="https://secure.footprint.net/dafiticl/images/dafiti/payment-methods/webpay-cards.png"></p>
                                            Al hacer click en Finalizar Compra, te redirigirás al sitio de Webpay, y se abrirá en una ventana emergente. Debes tener tu tarjeta a mano y el generador de claves de internet.            </div>
                                    </div>
                                </div>

                                <div class="ui-formRow payment-method ">

                                    <div class="collection h4 pbs ui-borderBottom hasTooltip">
                                        <input type="radio" name="PaymentMethodForm[payment_method]" value="CcPayment" class="payment-method-option ui-inputRadio lfloat" id="storecard">                <label for="storecard">
                                            Tarjetas de Casas Comerciales
                                            <div title="More Information" class="rfloat tooltipIcon"></div>
                                        </label>
                                        <div class="hidefirst checkoutTooltip txtLight normal" style="left: 285px; display: none;">
                                            <div class="checkoutTooltipArrow"></div>
                                            Pago con tarjetas Cencosud, CMR, Presto y Ripley. Debes tener habilitada previamente tu tarjeta para comprar en internet y contar con tu clave.                </div>
                                    </div>


                                    <div class="ui-formRow payment-method-form payment-method-storecard hidefirst">
                                        <div class="desc">


                                            <ul>
                                                <li>
                                                    <input type="radio" value="10" class="puntopagos" name="paymentsCreditCard">
                                                    <img alt="Ripley" src="https://secure.footprint.net/dafiticl/images/dafiti/icons/mp10.png">
                                                </li>

                                            </ul>
                                            Pago con tarjetas Ripley. Debes tener habilitada previamente tu tarjeta para comprar en internet y contar con tu clave.            </div>
                                        </div>
                                    </div>
                                </div>

                         </div>
                    </fieldset>
                </div>


<!--                <div class="radio">-->
<!--                    <label>-->
<!--                        <input type="radio" name="payment_method" id="payment_method" value="--><?php //echo Deposit::PAYMENT_METHOD_TYPE ?><!--" disabled>-->
<!--                        Deposito-->
<!--                    </label>-->
<!--                </div>-->
<!---->
<!--                <div class="radio">-->
<!--                    <label>-->
<!--                        <input type="radio" name="payment_method" id="payment_method" value="--><?php //echo Transfer::PAYMENT_METHOD_TYPE ?><!--" disabled>-->
<!--                        Transferencia-->
<!--                    </label>-->
<!--                </div>-->
            </div>
            <input type="hidden" name="act" value="processPaymentMethod">

            <div class="form-buttons">
                <input type="submit" class="btn btn-alternative" id="btn-payment-method" value="Continuar">
            </div>
        </form>
    </div>
</div>