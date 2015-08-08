<?php 
if($session == true){
	 $id_pro = $_GET['pid'];
	 $id_of = $_GET['oid'];
	 
	 $projects = listAll("proyectos, ofertas", "WHERE ofertas.id = '$id_of' AND proyectos.pro_id = '$id_pro' AND ofertas.user_id = '$_COOKIE[id]' AND proyectos.pro_id = ofertas.pro_id");
	 $rs_pro = mysql_fetch_object($projects);
	 
	$diasRest = diffDate(date("Y-m-d H:i:s"),$rs_pro->pro_date_end);
?>
<script>
$(document).ready(function() {

	
	$("#pro_propuesta").blur(function() {
		if ($("#pro_propuesta").val() == ""){
		$("#pro_propuesta").val("Propuesta");
		}
		});
	$("#pro_oferta").blur(function() {
		if ($("#pro_oferta").val() == ""){
		$("#pro_oferta").val("Oferta");
		}
		});
	
	$("#bGuardar").click(function(){
		$("#formProyecto").hide();

		$("#formError").html("");
		var error = 0;
		
		
		if ($("#pro_propuesta").val() == "Propuesta" || $("#pro_propuesta").val().length < 3){
			$("#formError").append("<p>- Debes ingresar la propuesta para el proyecto </p>");
			$("#formError").slideDown('slow');
			error++;
		}

		if ($("#pro_oferta").val() == "Oferta" || $("#pro_oferta").val().length < 2){
			$("#formError").append("<p>- Debes ingresar la oferta para el proyecto</p>");
			$("#formError").slideDown('slow');
			error++;
		}

		if(error == 0){
			$("#formProyecto").submit();
		}else{
			$("#formProyecto").show();
			}
	});
	
}); // cierre de document 


</script>

<div class="registroContainer" id="EditarPerfil">
<h2>Editar Propuesta</h2>
	<div class="formError bold" id="formError"></div>
	<p class="txtAzul font18"><?php echo $rs_pro->pro_tit?> - <span class="proStatus txtNaranja font12"><?php  echo $diasRest[2];?> d&iacute;as para adjudicar</span></p>
	<p><?php echo $rs_pro->pro_descripcion;?></p>
	<form action="actions/proyectosAction.php" method="post" id="formProyecto" enctype="multipart/form-data">
	Propuesta
	<textarea name="pro_propuesta" id="pro_propuesta" class="txAreaLogin"><?php echo str_replace("<br/>","\n",$rs_pro->mensaje)?></textarea>
	Oferta
	<input type="text" name="pro_oferta" id="pro_oferta" value="<?php echo $rs_pro->bid?>" class="txBoxRegistro" autocomplete="off"/>
	<input name="pro" id="pro" type="hidden" value="<?php echo $rs_pro->pro_id;?>">
	<input name="ofert" id="ofert" type="hidden" value="<?php echo $rs_pro->id;?>">
	<input name="act" id="act" type="hidden" value="editarOferta">
  	<div class="btn_naranja bold" id="bGuardar"><a href="#">Guardar</a></div>
	
	</form>
</div>
	<?php 
}else{?>
<script>
window.location="home";
</script>
<?php

}
?>
