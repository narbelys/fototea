<?php

$session = validaSession();
	$userType = securityValidation($_COOKIE['id']);
	$user_info = getUserInfo($_COOKIE['id']);
	
	if($userType!="2" && $session != true){
		?>
		<script>
window.location="home";
</script>
	<?php }?>
<div class="containerPerfil" id="cuentaContainer">
	<h2>Proyectos por Pagar</h2>
	 <div class="bkGreen mensajesHeader">
		 <div class="left ctaFecha alignCenter">Fecha</div>
		 <div class="left ctaProyecto2">Descripci&oacute;n</div>
		 <div class="left ctaUser alignCenter">Adjudicado a</div>
		 <div class="left ctaMonto alignCenter">Monto</div>
		 
	 </div>
	 
	 <div class="mensajesList">
		<?php $mov = listAll("proyectos,pro_transactions", "WHERE user_id = '$_COOKIE[id]' AND t_pro_id = pro_id AND t_status ='P' ORDER BY t_pdate DESC");
		$rows = mysql_num_rows($mov);
		
		if($rows <1){
			echo ' <div class="mensajeItem">No tiene proyectos por pagar</div>';
		}else{
		while($rs_mov = mysql_fetch_object($mov)){
			
			$oferta =listAll("ofertas", "WHERE pro_id = '$rs_mov->pro_id' AND awarded='S'");
			$rs_oferta = mysql_fetch_object($oferta);
		
			$from = getUserInfo($rs_oferta->user_id);

			$fechaMens = explode(" ",dateField($rs_mov->t_cdate));
			
			if($fechaMens[0] == date("d-m-Y")){
				$fm = $fechaMens[1];
				}else{
				$fm = $fechaMens[0];
				}
			
			$total = $total + $rs_oferta->bid ;
?>
		 <div class="ctaItem " id="mov_<?php echo $rs_mens->m_id;?>">
				<div class="mensajeItemContainer">
				<div class="left ctaFecha alignCenter"><?php echo $fm;?></div>
				 <div class="left txtAzul ctaProyecto2"><a href="proyecto?id=<?php echo $rs_mov->pro_id;?>" class="txtAzul"><?php echo ucwords($rs_mov->pro_tit);?></a></div>
				 <div class="left ctaUser alignCenter"><a href="perfil?us=<?php  echo $from['act_code'];?>" class="txtNaranja"><?php echo ucwords($from['name'])." ".ucwords($from['lastname']);?></a></div>
				 <div class="left ctaMonto alignRight"><?php echo number_format($rs_oferta->bid,2,",",".");?></div>
			 </div>
		 </div>
	
		  <?php  } ?>
		   <div class="ctaItem " id="mov_<?php echo $rs_mens->m_id;?>">
				<div class="mensajeItemContainer">
				 <div class="left ctaTotal fontW400">Total</div>
				 <div class="left ctaMonto fontW400 alignRight"><?php echo number_format($total,2,",",".");?></div>
			 </div>
		 </div>
		 <?php  } ?>
	 </div>
	
 
 </div>