<?php $to = $_POST['data_to'];
$pro_id = $_POST['data_proid'];
if($pro_id != 0){
	$pro = listAll("proyectos", "WHERE pro_id = '$pro_id'");
	$rs_pro = mysql_fetch_object($pro);
	$asunto = "Proyecto: ".$rs_pro->pro_tit;
}else{
	$asunto = "";
}
$user_to= getUserInfo($to);
?>
<div id="mensajesCrear">
<div id="modalClose" onclick="javascript:closeModal();"><img alt="Cerrar" title="Cerrar" src="images/close.png"></div>
<h2>Enviar mensaje</h2>
<div id="error"></div>
<form id="formMensajes" method="post" action="">
<input type="hidden" id="to" name="to" value="<?php echo $user_to['id']?>"/>
<input type="hidden" id="pro_id" name="pro_id" value="<?php echo $pro_id;?>"/>
<p>Para: <input type="text" id="m_to" name="m_to" disabled="disabled" value="<?php echo $user_to['name']." ".$user_to['lastname']?>"/></p>
<p>Asunto: <input type="text" id="m_subject" name="m_subject" value="<?php echo $asunto;?>"/></p>
<p>Mensaje: <textarea rows="3" cols="3" id="m_mensaje" name="m_mensaje"></textarea></p>
<div class="btn_naranja bold" id="bEnviar"><a href="javascript:sendMessage();">Enviar</a></div> 
</form>
</div>