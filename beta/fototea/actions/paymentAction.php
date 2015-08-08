<?php
use Fototea\Models\Order;
use Fototea\Models\OrderProduct;
use Fototea\Models\Payment;
use Fototea\Models\Product;
use Fototea\Models\PuntoPagos;
use Fototea\Models\Deposit;
use Fototea\Models\Transfer;
use Fototea\Models\IPaymentMethod;
use Fototea\Models\PaymentMethod;
use Fototea\Models\PaymentManager;
use Fototea\Util\UrlHelper;

require '../vendor/autoload.php';

include_once '../scripts/libSM.php';

$session = validaSession();

if($session == true){

    $act = $_REQUEST['act'];
    $currentUser = getCurrentUser();

    /*if($act == "paymentMethod"){
        // Validate product exists
        $productId = $app->getRequest()->get('product-id');
        $product = Product::getProduct($productId);
        if (!$product){
            $app->addError("Ha ocurrido un error con el producto intentando realizar un pago");
            $app->redirect($app->getConfig()->getUrl('perfil'));
            return;
        }

        // Validate price for the product
        $price = $app->getRequest()->get('price');
        $productPrice = 0.00;
        if (!is_numeric($price) && !is_numeric($product->price)){
            $app->addError("Ha ocurrido un error con el precio intentando realizar un pago");
            $app->redirect($app->getConfig()->getUrl('perfil'));
            return;
        } elseif (is_numeric($price)){
            $productPrice = floatval($price);
        } elseif (is_numeric($product->price)){
            $productPrice = floatval($product->price);
        }

        // Check shopping cart in session
        $shoppingCart = $app->getSession()->get('shopping-cart');

        if (!$shoppingCart){
            $cart = array('products' => array());

            $app->getSession()->set('shopping-cart', $cart);
            $shoppingCart = $app->getSession()->get('shopping-cart');
        }

        // Add new product to shopping cart
        $shoppingCart['products'][] = array('id' => $productId, 'price' => $productPrice);
        $app->getSession()->set('shopping-cart', $shoppingCart);

        $app->redirect(UrlHelper::getUrl('metodopago'));
        return;
    }*/

    if($act == "processPaymentMethod"){

        $cart = $app->getCart();
        $items = $cart->getItems();
        $total = $cart->getSubtotal();

        // Validate products
        if (empty($items)){
            $app->addError("Ha ocurrido un error con los productos intentando procesar su método de pago");
            $app->redirect($app->getConfig()->getUrl('metodopago'));
            return;
        }

        // Validate payment method selected
        $paymentMethod = $app->getRequest()->post('payment_method');

        if ($paymentMethod != PuntoPagos::PAYMENT_METHOD_TYPE && $paymentMethod != Deposit::PAYMENT_METHOD_TYPE && $paymentMethod != Transfer::PAYMENT_METHOD_TYPE){
            $app->addError("Debe seleccionar un método de pago válido");
            $app->redirect($app->getConfig()->getUrl('metodopago'));
            return;
        }

        // Create Order
        $order = Order::create($currentUser->id, $total);

        // Create OrderProduct
        OrderProduct::create($order->id, $items);

        // Create Payment
        $paymentManager = new PaymentManager($app, $paymentMethod);
        $result = $paymentManager->createPayment($order);

        if ($result->success == false){
            $app->addError("Ha ocurrido un error intentando procesar la transacción con el método de pago");
            $app->redirect($app->getConfig()->getUrl('metodopago'));
            return;
        }

        // TODO: Clear cart
        $app->getCart()->clear();

        $app->redirect($result->redirectUrl);
        return;
    }


} else {
    $app->redirect($app->getConfig()->getUrl('perfil'));
}
