   <script>
   $(document).ready(function() {
	 
	  
	   scroll();
	     

		function scroll(){
			document.getElementById('final').scrollIntoView(true);
		}
	}
   </script>
    
<?php 
updateTable("mensajes_status", "ms_status='L'", "ms_m_id='$_GET[i]' AND ms_user_id = '$_COOKIE[id]'");

$mensaje = listAll("mensajes", "WHERE m_id = '$_GET[i]' AND (m_to = '$_COOKIE[id]' OR m_cuser = '$_COOKIE[id]')");
$rs_mens = mysql_fetch_object($mensaje);

if($_COOKIE['id'] == $rs_mens->m_to){
	$destino = $rs_mens->m_cuser;
}else{
	$destino = $rs_mens->m_to;
}


?>
<div class="registroContainer" id="mensajesContainer">
	<h2>Mensajes</h2>
	<?php if($rs_mens->pro_id > 0){
	 $pro = listAll("proyectos", "WHERE pro_id = $rs_mens->pro_id");
	 $rs_pro = mysql_fetch_object($pro);
	 	?>
	 <div><a href="proyecto?id=<?php  echo $rs_pro->pro_id;?>" class="txtAzul fontW400 font18"><?php echo $rs_pro->pro_tit;?></a></div>
	 <?php } ?>
	
	 <div class="bkGreen mensajesHeader">
		 <div><?php echo $rs_mens->m_subject;?></div>
	 </div>
	 
	 <div id="msnCont">
	 <div id="msnList">
	 <?php $mensaje_txt = listAll("mensajes_det", "WHERE md_m_id = '$rs_mens->m_id' ORDER BY md_cdate DESC");
		while($rs_mt = mysql_fetch_object($mensaje_txt)){

		
			$from = getUserInfo($rs_mt->md_from);
		
		
		$fechaMens = explode(" ",dateField($rs_mt->md_cdate));
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
	 <div class="mensajeTxtCont">
	 <div class="mjs_info">
		 <div class="left"><a href="perfil?us=<?php  echo $from['act_code'];?>" class="txtAzul"><img alt="Imagen de usuario" src="<?php echo $img_profile;?>" width="45" height="45" border="0"><?php echo ucwords($from['name'])." ".ucwords($from['lastname']);?></a></div>
		 <div class="left alignRight txtNaranja"><?php echo $fm;?></div>
	 </div>
	 <div class="mensajeTxt alignJustify"><?php echo $rs_mt->md_txt;?></div>
	 </div>
	 <?php } ?>
	 <span id="final"></span>
	 </div></div>
	 <div class="replayMsj">
	 Responder mensaje:
		 <form id="replay" name="replay" action="" method="post">
		 	<textarea rows="" cols="" id="m_replay" name="m_replay"></textarea>
		 	<div><div class="btn_naranja bold" id="bEnviar"><a href="javascript:replayMessage(<?php echo $_GET[i];?>,<?php echo $destino;?>,<?php echo $_COOKIE['id'];?>);">Enviar</a></div> </div>
		 </form>
	 </div>
	 
</div>