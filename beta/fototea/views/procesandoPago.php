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

?>

<script>
$(document).ready(function() {
setInterval(function() {
	  $.ajax({
				type: 'get',
				dataType: 'json',
				url: 'actions/proyectosAction.php',
				data: {act:"validarPago",pro_id:<?php echo $pro_id?>,oferta_id:<?php  echo $rs_oferta->id;?>},
				success: function(msg){
					//funcion para llenar los datos del detalle
					var resp = msg[0]['resp'];
					if(resp == "true"){
						window.location.href="proyectoFinalizar?id=<?php echo $pro_id;?>";
					}
				}
		});
}, 2000);
});

</script>
<div class="registroContainer">
	<h2>Confirmacion de datos de pago del proyecto</h2>
	 	
	 <div class="bkGreen mensajesHeader">
		 <div><?php echo $rs_pro->pro_tit;?></div>
	 </div>
	<p>Estamos procesando su pago, usted sera redireccionado automaticamente una vez hayamos validado su pago.</p>
	<p class="alignCenter"><img src="images/loading.gif" alt="Cargando"/></p>
</div>