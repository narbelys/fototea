
<div class="containerPerfil" id="cuentaContainer">
	<h2>Estado de Cuenta</h2>
	 <div class="bkGreen mensajesHeader">
		 <div class="left ctaId alignCenter">Id</div>
		 <div class="left ctaFecha alignCenter">Fecha</div>
		 <div class="left ctaProyecto">Descripci&oacute;n</div>
		 <div class="left ctaUser alignCenter">Adjudicado a</div>
		 <div class="left ctaMonto alignCenter">Monto</div>
		 
	 </div>
	 
	 <div class="mensajesList">
		<?php $mov = listAll("proyectos,pro_transactions", "WHERE user_id = '$_COOKIE[id]' AND t_pro_id = pro_id AND t_status ='L' ORDER BY t_pdate DESC");
		$rows = mysql_num_rows($mov);
		
		if($rows <1){
			echo ' <div class="mensajeItem">No tiene movimientos en su cuenta</div>';
		}else{
		while($rs_mov = mysql_fetch_object($mov)){
			
			$oferta =listAll("ofertas", "WHERE pro_id = '$rs_mov->pro_id' AND awarded='S'");
			$rs_oferta = mysql_fetch_object($oferta);
		
			$from = getUserInfo($rs_oferta->user_id);

			$fechaMens = explode(" ",dateField($rs_mov->t_pdate));
			
			if($fechaMens[0] == date("d-m-Y")){
				$fm = $fechaMens[1];
				}else{
				$fm = $fechaMens[0];
				}
			$comision = $rs_oferta->bid * 0.1;
			$total = $total + $rs_oferta->bid + $comision;
?>
		 <div class="ctaItem " id="mov_<?php echo $rs_mens->m_id;?>">
				<div class="mensajeItemContainer">
				<div class="left ctaFecha alignCenter"><?php echo $rs_mov->t_trans_id;?></div>
				<div class="left ctaFecha alignCenter"><?php echo $fm;?></div>
				 <div class="left txtAzul ctaProyecto"><a href="proyecto?id=<?php echo $rs_mov->pro_id;?>" class="txtAzul"><?php echo ucwords($rs_mov->pro_tit);?></a></div>
				 <div class="left ctaUser alignCenter"><a href="perfil?us=<?php  echo $from['act_code'];?>" class="txtNaranja"><?php echo ucwords($from['name'])." ".ucwords($from['lastname']);?></a></div>
				 <div class="left ctaMonto alignRight"><?php echo number_format($rs_oferta->bid,2,",",".");?></div>
			 </div>
		 </div>
		 <div class="ctaItem " id="mov_<?php echo $rs_mens->m_id;?>">
				<div class="mensajeItemContainer">
				<div class="left ctaFecha alignCenter"><?php echo $rs_mov->t_trans_id;?>-1</div>
				<div class="left ctaFecha alignCenter"><?php echo $fm;?></div>
				 <div class="left txtAzul ctaProyecto">Comision</div>
				 <div class="left ctaUser alignCenter"><?php echo "Fototea.com";?></div>
				 <div class="left ctaMonto alignRight"><?php echo number_format($comision,2,",",".");?></div>
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