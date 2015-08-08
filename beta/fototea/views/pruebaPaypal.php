<form action="https://securepayments.sandbox.paypal.com/cgi-bin/webscr" method="post" name="paypal" id="paypal">
<!-- Pre Populate the Paypal Checkout Page With Customer Details, -->
<input type="hidden" name="first_name" value="alex">
<input type="hidden" name="last_name" value="bri">
<input type="hidden" name="email" value="personal@fototea.com">
<input type="hidden" name="address1" value="ergergre">
<input type="hidden" name="address2" value="ergerg">
<input type="hidden" name="city" value="Madrid">
<input type="hidden" name="zip" value="28924">
<input type="hidden" name="day_phone_a" value="">
<input type="hidden" name="day_phone_b" value="678254940">

<input type="hidden" name="lc" value="ES">
<input type="hidden" name="cmd" value="_xclick" />
<input type="hidden" name="business" value="fototea@fototea.com " />
<input type="hidden" name="cbt" value="Regresa a Fototea" />
<input type="hidden" name="currency_code" value="EUR" />

<!-- Allow customer to enter desired quantity -->
<input type="hidden" name="quantity" value="1" />
<input type="hidden" name="item_name" value="Proyecto" />



<input type="hidden" name="shipping" value="0" />
<input type="hidden" name="invoice" value="<?php echo date("YdmHis");?>" />
<input type="hidden" name="amount" value="50" />
<input type="hidden" name="return" value="<?php echo FConfig::getUrl('shop/paypal/thankyou') ?>"/>
<input type="hidden" name="cancel_return" value="<?php echo FConfig::getUrl('shop/paypal/cancelled'); ?>" />

<!-- Where to send the paypal IPN to. -->
<input type="hidden" name="notify_url" value="<?php echo FConfig::getUrl('actions/processAction.php'); ?>" />
<input type="submit" name="METHOD" value="Pay">
</form>