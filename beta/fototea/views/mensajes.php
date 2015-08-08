
<div class="registroContainer" id="mensajesContainer">
	<h2>Mensajes</h2>
	 <div class="bkGreen mensajesHeader">
		 <div class="left mensImg">&nbsp;</div>
		 <div class="left mensUsuario">Usuario</div>
		 <div class="left mensAsunto">Asunto</div>
		 <div class="left mensFecha">Fecha</div>
	 </div>
	 
	 <div class="mensajesList">
		<?php $mensajes = listAll("mensajes,mensajes_status", "WHERE (m_to = '$_COOKIE[id]' OR m_cuser = '$_COOKIE[id]') AND m_id = ms_m_id AND ms_user_id = '$_COOKIE[id]' AND ms_status !='B' ORDER BY m_cdate DESC");
		$rows = mysql_num_rows($mensajes);
		
		if($rows <1){
			echo ' <div class="mensajeItem">No tiene mensajes</div>';
		}else{
		while($rs_mens = mysql_fetch_object($mensajes)){
		
			
		if($rs_mens->m_to == $_COOKIE['id']){	
			$from = getUserInfo($rs_mens->m_cuser);
		}else if ($rs_mens->m_cuser ==  $_COOKIE['id']){
			$from = getUserInfo($rs_mens->m_to);
		}
		//$mensaje_status= listAll("mensajes_status", "WHERE ms_m_id ='$rs_mens->m_id' AND ms_user_id = '$_COOKIE[id]'");
		//$rs_ms = mysql_fetch_object($mensaje_status);
		
		if($rs_mens->ms_status == "N"){
			$status = "MensajeNuevo";
			}else{
			$status= "";
			}
			
			$mens_date = listAll("mensajes_det","WHERE md_m_id = '$rs_mens->m_id' AND (md_from = '$_COOKIE[id]' OR md_to = '$_COOKIE[id]') ORDER BY md_cdate DESC LIMIT 0,1");
			$rs_md = mysql_fetch_object($mens_date);
			$fechaMens = explode(" ",dateField($rs_md->md_cdate));
			if($fechaMens[0] == date("d-m-Y")){
				$fm = $fechaMens[1];
				}else{
				$fm = $fechaMens[0];
				}
			
				
				if(is_null($from['user_img'])){
					$img_profile = "images/img_profile_default.jpg";
				}else{
					$img_profile = "thumb.php?w=45&h=45&url=profiles/".sha1($from['id'])."/".$from['user_img'];
				}
			
			
?>
		 <div class="mensajeItem <?php echo $status;?>" id="mens_<?php echo $rs_mens->m_id;?>">
			<div class="mensDel"  onclick="javascript:deleteMensaje(<?php echo $rs_mens->m_id;?>);"><img alt="Cerrar" title="Cerrar" src="images/close_black.png" width="10" height="10"></div>
			<div class="mensajeItemContainer" onclick="javascript:verMensaje(<?php echo $rs_mens->m_id;?>)">
				<div class="left mensImg"><img alt="Imagen de usuario" src="<?php echo $img_profile;?>" width="45" height="45"></div>
				 <div class="left txtAzul mensUsuario"><?php echo ucwords($from['name'])." ".ucwords($from['lastname']);?></div>
				 <div class="left mensAsunto"><?php echo $rs_mens->m_subject;?></div>
				 <div class="left mensFecha"><?php echo $fm;?></div>
			 </div>
		 </div>
		  <?php  }} ?>
	 </div>
	
 
 </div>