<div class="registroContainer" id="registroContainer">
	<h2>Registro</h2>
	<?php if($_GET['e'] == "error"){?>
	<p> No se pudo completar su registro. El correo electronico ingresado ya esta registrado en nuestra base de datos. Si olvido su contrase&ntilde;a puede recuperarla haciendo click <a class="txtAzul" href="olvido-contrasena">aqu&iacute;!</a></p>
	<?php }else{?>
	<p>&#33;Muchas gracias por registrarte con nosotros! En los pr&oacute;ximos minutos recibir&aacute;s un correo de confirmaci&oacute;n.<br><br>
	Si quieres saber m&aacute;s, s&iacute;guenos en nuestro <a href='https://www.facebook.com/Fototea' target = '_blank' class='txtAzul bold'>Facebook</a>.</p>
<?php }?>
	</div>
