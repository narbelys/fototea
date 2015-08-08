  <?php 
  //validar que sea un usuario valido para ver esta pagina

  $pro_id = $_GET['id'];
  $pro = listAll("proyectos", "WHERE pro_id = '$pro_id'");
  $rs_pro = mysql_fetch_object($pro);
  $user_info = getUserInfo($_COOKIE['id']);
  if($_COOKIE['id'] != $rs_pro->user_id){  
  ?> <script>
   window.location="miHome";
   </script>
    
<?php }

$oferta = listAll("ofertas", "WHERE pro_id = $pro_id AND awarded= 'S'");
$rs_oferta = mysql_fetch_object($oferta);

$bid =  $rs_oferta->bid;
$comision = $bid * 0.15;
$total = $bid + $comision;

$user_oferta = getUserInfo($rs_oferta->user_id);

$trans = listAll("pro_transactions", "WHERE t_oferta_id = '$rs_oferta->id' AND t_pro_id = '$pro_id' AND t_status = 'L'");
$row_t = mysql_num_rows($trans);

if($row_t > 0){?>

<script>
   window.location="miHome";
   </script>
<?php }
?>

<script>
function sendForm(){

		setInterval('window.location="procesandoPago?id=<?php echo $pro_id;?>"',1000);
		$("#paypal").submit();
		
}

</script>
<div class="registroContainer">
	<h2>Confirmacion de datos de pago del proyecto</h2>
	 	
	 <div class="bkGreen mensajesHeader">
		 <div><?php echo $rs_pro->pro_tit;?></div>
	 </div>
	<div class="detalleConfirmCont">
		<div class="detalleConfirmList">
			<div class="detalleConfirmProyect left">
				<div>Proyecto adjudicado a <a href="perfil?us=<?php echo $user_oferta['cod_act']?>" class="txtAzul"><?php echo $user_oferta['name']." ".$user_oferta['lastname'];?></a> por el monto</div>
			</div>
			<div class="detalleConfirmMonto left">
				<div class="alignRight">$ <?php echo number_format($bid,2,",",".");?></div>
			</div>
			
		</div>
		<div class="detalleConfirmList">
			<div class="detalleConfirmProyect left">
							<div>Comision Fototea.com 10% del monto adjudicado</div>
						</div>
			<div class="detalleConfirmMonto left">
							<div  class="alignRight">$ <?php echo number_format($comision,2,",",".");?></div>
						</div>
			
		</div>
		<div class="detalleConfirmList">
			<div class="detalleConfirmProyect left">
					<div class="alignRight fontW400">Total</div>
			</div>
			<div class="detalleConfirmMonto left">
						<div class="alignRight"><strong>$ <?php echo number_format($total,2,",",".");?></strong></div>
			</div>
			
		</div>
		
		<div class="detalleForm">
			<form action="https://securepayments.paypal.com/cgi-bin/webscr" method="post" name="paypal" id="paypal" target="_blank">
			<!-- Pre Populate the Paypal Checkout Page With Customer Details, -->
			<input type="hidden" name="first_name" value="<?php echo $user_info['name'];?>">
			<input type="hidden" name="last_name" value="<?php echo $user_info['lastname']; ?>">
			<input type="hidden" name="email" value="<?php echo $user_info['email']; ?>">
			<input type="hidden" name="address1" value="<?php echo $user_info['direccion']; ?>">
			<input type="hidden" name="address2" value="">
			<input type="hidden" name="city" value="<?php echo $user_info['ciudad']; ?>">
			<input type="hidden" name="zip" value="<?php echo $user_info['cp']; ?>">
			<input type="hidden" name="day_phone_a" value="<?php echo $user_info['telefono']; ?>">
			<input type="hidden" name="day_phone_b" value="<?php echo $user_info['movil']; ?>">
			
			<input type="hidden" name="lc" value="ES">
			<input type="hidden" name="cmd" value="_xclick" />
			<input type="hidden" name="business" value="paulogoncalvesr@gmail.com" />
			<input type="hidden" name="cbt" value="Regresa a Fototea.com" />
			<input type="hidden" name="currency_code" value="EUR" />
			
			<!-- Allow customer to enter desired quantity -->
			<input type="hidden" name="quantity" value="1" />
			<input type="hidden" name="item_name" value="<?php  echo $rs_pro->pro_tit;?> + comision fototea.com 10%" />
			
			
			
			<input type="hidden" name="shipping" value="0" />
			<input type="hidden" name="invoice" value="<?php echo date("YdmHis");?>" />
			<input type="hidden" name="amount" value="<?php echo $total;?>" />
			<input type="hidden" name="return" value="<?php echo FConfig::getUrl('proyectoFinalizar?id='). $pro_id;?>"/>
			<input type="hidden" name="cancel_return" value="<?php echo FConfig::getUrl('confirmProyecto?id='). $pro_id;?>" />
			
			<!-- Where to send the paypal IPN to. -->
			<input type="hidden" name="notify_url" value="<?php echo FConfig::getUrl('actions/processAction.php?p='). $pro_id .'&of='. $rs_oferta->id; ?>" />
			<div class="btn_naranja"><a href="javascript:sendForm()">Pagar y Finalizar</a></div>
			</form>
		</div>
	</div>
</div>