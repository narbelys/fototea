<div class="content-container">

    <div class="content form-page">
        <div class="row">
            <div class="col-sm-6" style="border-right:solid 1px #eee ; padding-right:50px">
                <div class="row" style="padding-top:20px">
                    <h2>Iniciar sesión</h2>
                </div>

                <form action="" method="post" id="formLogin" class="login-form" role="form">
                    <div class="form-group row">
                        <label for="inputEmail3" class="control-label required-after">Correo Electrónico</label>
                        <input type="email" name="user_user" value="<?php echo $app->getInput()->old('user_user', '') ?>"  class="form-control" id="user_user" placeholder="ejemplo@mail.com">
                    </div>
                    <div class="form-group row">
                        <label for="inputEmail3" class="control-label required-after">Contraseña</label>
                        <input type="password" class="form-control" name="user_password" id="user_password" placeholder="eg. sd35fs">
                    </div>
                    
                    <div class="row">
                        <p><b class="obligatorio">*</b> Campos requeridos</p>
                    </div>

                    <div class="row text-center">
                        <a class="" href="olvido-contrasena">¿Olvidaste tu contraseña?</a>
                    </div>

                    <div class="row text-center" style="padding-top:20px">
                        <button type="submit" class="btn btn-primary btn-lg" id="bLogin">Iniciar sesión</button>
                    </div>
                </form>
            </div>

            <div class="col-sm-6" style="padding-left:50px">
                <div class="row text-center" style="padding-top:20px">
                    <h2>¿Aún no estás registrado?</h2>

                    <p>Crea una cuenta gratis y disfruta de nuestros servicios</p>
                    <a class="btn btn-alternative btn-lg" href="registro">Regístrate</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    // The androb way
    (function($){
        $(document).ready(function() {

            $( "#bLogin" ).click(function() {
                $( "#formLogin" ).submit();
            });

            $("#formLogin").validate({

                // Specify the validation rules
                rules: {
                    user_password: {
                        required: true,
                        minlength: 8
                    },

                    user_user: {
                        required: true,
                        email: true
                    }

                },

                // Specify the validation error messages
                messages: {
                    user_password: "Introduce una contraseña",
                    user_user: "Introduce una dirección de correo válida"
                },

                highlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                },
                unhighlight: function (element) {
                    $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                },
                errorElement: 'span',
                errorClass: 'help-block '
            });
        });
    }(jQuery))
</script>
