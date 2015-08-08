<div class="loginContainer" id="loginContainer">
	<h2>&#191;Olvid&oacute; su contrase&ntilde;a?</h2>
	<p>Inserte su usuario para recuperar su contrase&ntilde;a</p>
	<form action="" id="formRecuperar" method="post" role="form">
		  <div class="form-group">
            <label>Usuario</label>
              <input type="text" name="user_user" class="form-control" id="user_user" placeholder="Email">
          </div>
          <!--<button type="submit" class="btn btn-primary btn-lg" id="bRecuperar">Recuperar contrase&ntilde;a</button>-->
        <div class="btn_verde bold row" id="bRecuperar"><a href="#">Recuperar contrase&ntilde;a</a></div>
	</form>
</div>

<script>
    $(document).ready(function() {

        $("#bRecuperar").click(function(){

            $.ajax({
                type: 'post',
                dataType: 'json',
                url: 'actions/recuperarAction.php',
                data: {user:$("#user_user").val().trim(),act:"recuperar"},
                success: function(json){
                    //funcion para llenar los datos del detalle
                    $("#loginContainer").html("<h2>&#191;Olvido su contrase&ntilde;a?</h2><p class='olvidoText'>Se le ha enviado un correo con los pasos para poder recuperar su contrase&ntilde;a.</p>");
                }
            });
        });

    });
</script>