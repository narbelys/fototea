<?php 

$userVal = mysql_num_rows(listAll("user", "WHERE act_code = '$_REQUEST[c]'"));
if($userVal < 1){?>
	<script type="text/javascript">
	    window.location="home";
	</script>
<?php } ?>

<div class="loginContainer" id="loginContainer">
	<h2>Reinicia tu contrase&ntilde;a</h2>
	<p>Inserte su nueva contrase&ntilde;a</p>
	<div class="formError bold" id="formError"></div>
	<form action="" id="formRecuperar" method="post">
		<input type="text" name="user_password" id="user_password" placeholder="Nueva contrasena" class="txtbox-forget" autocomplete="off"/>
		<input type="text" name="user_confirm" id="user_confirm" placeholder="Confirmar contrasena" class="txtbox-forget" autocomplete="off"/>
			<div class="btn_verde bold" id="bRecuperar"><a href="#">Recuperar contrase&ntilde;a</a></div>
	</form>
</div>

<script>
    $(document).ready(function() {

        $('#user_password').focus(function() {
            $(this).get(0).type = 'password';
            $("#user_password").val("");
        });
        $('#user_confirm').focus(function() {
            $(this).get(0).type = 'password';
            $("#user_confirm").val("");
        });
        $("#user_password").blur(function() {
            if ($("#user_password").val() == ""){
                $(this).get(0).type = 'text';
                $("#user_password").val("Nueva contrasena");
            }
        });
        $("#user_confirm").blur(function() {
            if ($("#user_confirm").val() == ""){
                $(this).get(0).type = 'text';
                $("#user_confirm").val("Confirmar contrasena");
            }
        });

        $("#bRecuperar").click(function(){
            $("#formError").html("");
            var error = 0;
            if ($("#user_password").val().length < 8 ){
                $("#formError").append("<p>- Debes ingresar una contrase&ntilde;a con más de 8 caracteres alfanuméricos </p>");
                $("#formError").slideDown('slow');
                error++;
            }
            if($("#user_confirm").val() != $("#user_password").val()){
                $("#formError").append("<p>- Los campos deben coincidir </p>");
                $("#formError").slideDown('slow');
                error++;
            }


            if(error == 0){
                $.ajax({
                    type: 'get',
                    dataType: 'json',
                    url: 'actions/recuperarAction.php',
                    data: {'act-code':"<?php echo $_REQUEST[c] ?>",act:"reset",pass:$("#user_password").val()},
                    success: function(json){
                        //funcion para llenar los datos del detalle
                        $("#loginContainer").html('<h2>Reinicia tu contrase&ntilde;a</h2><p>Se ha recuperado tu contrase&ntilde;a con éxito.<br><br> <a href="login" class="txtAzul bold">Entrar a tu cuenta</a></p>');
                    }
                });
            }
        });

    });
</script>