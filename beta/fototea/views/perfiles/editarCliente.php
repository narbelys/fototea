<?php

use Fototea\Util\UrlHelper;

$session = validaSession();
if($session != true){
    $app->redirect($app->getConfig()->getUrl('home'));
    return;
}
?>

<div class="content-container">
    <div class="content" style="width: 50%;" id="completarRegistro">
        <h2>Editar informaci&oacute;n de perfil</h2>
        <div class="formError bold" id="formError"></div>
        <form action="actions/perfilAction.php" method="post" id="formEditarPerfil" enctype="multipart/form-data">
            <input name="act" type="hidden" value="editarPerfil">

            <div class="row">
                <div class="form-group col-sm-6" id="nombre">
                    <label class="control-label required-after">Nombre</label>
                    <input type="text" name="user_name" id="user_name" value="<?php echo $userInfo['name'];?>"    class="form-control " title="Nombre" placeholder="Nombre">
                </div>
                <div class="form-group col-sm-6" id="apellido">
                    <label class="control-label required-after">Apellidos</label>
                    <input type="text" name="user_apellido" id="user_apellido" value="<?php  echo $userInfo['lastname'];?>" placeholder="Apellidos" title="Apellidos" class="form-control">
                </div>
            </div>

            <div class="row">
                <div class=" form-group col-sm-6">
                    <label for="user_email" class="control-label required-after">Correo electrónico</label>
                    <input  type="text" name="user_email" placeholder="Correo electrónico" value="<?php echo $userInfo['email'] ?>"  id="user_email" class="form-control">
                </div>
                <?php if(!is_null($userInfo['new_email'])): ?>
                    <div class="alert alert-warning new-email-alert">
                        Revisa tu correo electrónico (<b><?php echo $userInfo['new_email'] ?></b>) para confirmar tu nueva dirección. Hasta que la confirmes, las notificaciones continuarán siendo enviadas a tu dirección actual de correo electrónico.<br/>
                        <a onclick="cancelNewEmail(<?php echo $userInfo['id'] ?>)">Cancelar este cambio</a>
                    </div>
                <?php endif ?>
            </div>

            <div class="edit-password-container">
                <div class="toggle">
                    <a class="plus toggleEditPassword" onclick="toggleEditPassword();" title="Editar contraseña">
                        <i class="glyphicon glyphicon-plus"></i>
                        <span>Editar contraseña</span>
                    </a>
                </div>

                <div class="buttons" style="display: none;">
                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="control-label required-after">Contraseña actual</label>
                            <input type="password" name="user_current_pass" id="user_current_pass" class="form-control" title="Contraseña actual" placeholder="Contraseña actual">
                        </div>
                    </div>

                    <div class="row">
                        <div class="form-group col-sm-6">
                            <label class="control-label required-after">Nueva contraseña</label>
                            <input type="password" name="user_new_pass" id="user_new_pass" class="form-control " title="Nueva contraseña" placeholder="Nueva contraseña">
                        </div>
                        <div class="form-group col-sm-6">
                            <label class="control-label required-after">Confirmación de contraseña</label>
                            <input type="password" name="user_confirm_pass" id="user_confirm_pass" placeholder="Confirmación de contraseña" title="Confirmación de contraseña" class="form-control">
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-3">
                    <label for="user_dob" class="control-label required-after">Fecha de nacimiento</label>
                    <input type="text" placeholder="Fecha de nacimiento" value="<?php echo $userInfo['user_dob'] ?>" name="user_dob" id="user_dob" class="form-control"/>
                </div>
            </div>

            <div class="row description-field">
                <div id="charNum" class="counter"></div>
                <div class="col-sm-12 form-group">
            <label for="inputEmail3" class="control-label ">Descripción de perfil</label>
                <textarea name="user_descripcion" id="user_descripcion" class="form-control" rows="3" placeholder="Descripci&oacute;n de perfil" title="Descripción de perfil"><?php echo $userInfo['descripcion'];?></textarea>
                </div>
            </div>

            <div class="row" style="padding-top:10px">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputEmail3" class="control-label ">Dirección</label>
                        <input type="text" name="user_direccion" id="user_direccion" value="<?php echo $userInfo['direccion'];?>"  class="form-control" placeholder="Direcci&oacute;n" title="Direcci&oacute;n">
                    </div>
                </div>
                <div class="col-sm-6">
                                      <div class="form-group">
                        <label for="inputEmail3" class="control-label ">Ciudad</label>
                        <input type="text" name="user_city" id="user_city" value="<?php echo $userInfo['ciudad'];?>"  class="form-control"  placeholder="Ciudad" title="Ciudad">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputEmail3" class="control-label ">Código postal</label>
                        <input type="text" name="user_cp" id="user_cp" value="<?php echo $userInfo['cp'];?>" class="form-control"  placeholder="Código postal" title="Código postal">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputEmail3" class="control-label ">Pa&iacute;s</label>
                        <select name="user_pais" id="user_pais" class="form-control">
                            <option value="">Pa&iacute;s</option>
                            <?php
                            $pais_q = listAll("paises"," ORDER BY nombre ASC");
                            while($pais = mysql_fetch_object($pais_q)){?>
                                <option value="<?php echo $pais->iso;?>" <?php if($userInfo['pais_ab'] == $pais->iso) echo 'selected="selected"';?>><?php echo utf8_encode($pais->nombre);?></option>
                            <?php  } ?>
                        </select>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                  <div class="form-group">
                        <label for="inputEmail3" class="control-label ">Teléfono</label>
                        <input type="text" name="user_telefono" id="user_telefono" value="<?php echo $userInfo['telefono'];?>"  class="form-control" placeholder="Teléfono" title="Teléfono">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputEmail3" class="control-label">Teléfono móvil</label>
                        <input type="text" name="user_movil" id="user_movil" value="<?php echo $userInfo['movil'] ?>"  class="form-control"  placeholder="Teléfono móvil" title="Teléfono móvil">
                    </div>
                </div>
            </div>
            <div>
            <button type="button" id="bGuardar" class="btn  btn-lg btn-primary clearfix pull-right">Guardar</button>
            </div>
            <a class="btn btn-alternative btn-lg pull-right skip-button" href="<?php echo UrlHelper::getProfileUrl() ?>">Cancelar</a>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {

        $('#user_dob').datepicker({
            dateFormat: "dd/mm/yy",
            maxDate: '-10Y',
            defaultDate: '-20Y',
            changeMonth: true,
            changeYear: true
        });

        contador(140, 0, '#user_descripcion');

        $("#formEditarPerfil").validate({
            // Specify the validation rules
            rules: {
                user_camara: {
                    required: true,

                },
                user_lentes: {
                    required: true,

                },
                user_interes: {
                    required: true,

                },
                user_name: {
                    required: true,
                },
                user_lastname: {
                    required: true,
                },
                user_email: {
                    required: true,
                    email: true,
                },
                user_current_pass: {
                    required: true,
                },
                user_new_pass: {
                    required: true,
                },
                user_confirm_pass: {
                    required: true,
                },
                user_descripcion: {
                    minlength: 0,
                    maxlength: 140,
                },
                user_direccion: {
                    required: true,
                    minlength: 6,

                },
                user_city: {
                    required: true,
                    minlength: 4,

                },
                user_cp: {
                    required: true,
                    minlength: 5,

                },
                user_pais: {
                    required: true,

                },
                user_telefono: {
                    required: true,
                    number: true,
                    minlength: 11,
                },
                user_movil: {
                    number: true,
                    minlength: 11,
                },
            },

            // Specify the validation error messages
            messages: {
                user_name: "Introduce tu nombre",
                user_lastname: "Introduce tu apellido",
                user_email: "Introduce tu correo electrónico",
                user_descripcion: "La descripción debe contener entre 20 y 140 caracteres",
                user_direccion: "La dirección debe contener mínimo 6 caracteres",
                user_city: "La ciudad debe contener mínimo 4 caracteres ",
                user_cp: "El código debe contener mínimo 5 caracteres numéricos",
                user_pais: "Selecciona un país",
                "user_telefono": {
                    required: "Introduce tu número de teléfono",
                    number: "El teléfono tiene que ser un número",
                    minlength: "El teléfono tiene que tener mínimo 11 números",
                },
                "user_movil": {
                    number: "El teléfono tiene que ser un número",
                    minlength: "El teléfono tiene que tener mínimo 11 números",
                },
            },

            highlight: function (element) {
                $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
            },
            unhighlight: function (element) {
                $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
            },
            errorElement: 'span',
            errorClass: 'help-block ',
        });


        $("#bGuardar").click(function(){
            $("#formEditarPerfil").submit();
            /*$("#formEditarPerfil").hide();

             $("#formError").html("");
             var error = 0;

             if ($("#user_name").val() == "Nombre" || $("#user_name").val().length < 3){
             $("#formError").append("<p>- Debes ingresar tu nombre </p>");
             $("#formError").slideDown('slow');
             error++;
             }

             if ($("#user_apellido").val() == "Apellidos" || $("#user_apellido").val().length < 3){
             $("#formError").append("<p>- Debes ingresar tus apellidos</p>");
             $("#formError").slideDown('slow');
             error++;
             }

             if ($("#user_descripcion").val() == "Descripción de perfil" || $("#user_descripcion").val().length < 5){
             $("#formError").append("<p>- Debes ingresar tu descripción de perfil </p>");
             $("#formError").slideDown('slow');
             error++;
             }

             if ($("#user_direccion").val() == "Dirección" || $("#user_direccion").val().length < 10){
             $("#formError").append("<p>- Debes ingresar tu dirección </p>");
             $("#formError").slideDown('slow');
             error++;
             }
             if ($("#user_city").val() == "Ciudad" || $("#user_city").val().length < 3){
             $("#formError").append("<p>- Debes ingresar tu ciudad </p>");
             $("#formError").slideDown('slow');
             error++;
             }

             if ($("#user_cp").val() == "Código postal" || $("#user_cp").val().length < 5){
             $("#formError").append("<p>- Debes ingresar tu código postal </p>");
             $("#formError").slideDown('slow');
             error++;
             }

             if ($("#user_pais").val() == "-1"){
             $("#formError").append("<p>- Debes seleccionar un país </p>");
             $("#formError").slideDown('slow');
             ror++;
             }
             if ($("#user_telefono").val() == "Telefono" || $("#user_telefono").val().length < 8){
             $("#formError").append("<p>- Debes ingresar su número de teléfono </p>");
             $("#formError").slideDown('slow');
             error++;
             }

             if(error == 0){
             $("#formEditarPerfil").submit();
             }else{
             $("#formEditarPerfil").show();
             }*/
        });

    }); // cierre de document
</script>