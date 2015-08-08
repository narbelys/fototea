<?php

use Fototea\Models\User;
use Fototea\Util\UrlHelper;

$session = validaSession();

if($session != true){
    $app->redirect($app->getConfig()->getUrl('home'));
    return;
}

$currentUser = getCurrentUser();

if($currentUser->profile_completed == User::USER_COMPLETED_PROFILE){
    $app->redirect($app->getConfig()->getUrl('perfil'));
    return;
}

if ($currentUser->user_type == User::USER_TYPE_PHOTOGRAPHER && $currentUser->profile_completed == User::USER_PHOTOGRAPHER_LEFT_PREFERENCES){
    $app->redirect($app->getConfig()->getUrl('completarPreferencias'));
    return;
}

?>

<div class="content-container">
    <div class="content form-page complete-profile" id="completarRegistro">
        <h2>Completar informaci&oacute;n de perfil<a class="btn btn-alternative btn-mini pull-right skip-button skip-button-top">Omitir</a></h2>
        <blockquote>
            <p>Completa la informaci&oacute;n de tu perfil para que los otros miembros conozcan m&aacute;s sobre ti. Tus datos de contacto no ser&aacute;n revelados hasta que te adjudiquen un proyecto.</p>
        </blockquote>
        <div class="formError bold" id="formError"></div>
        <form action="actions/perfilAction.php" method="post" id="formCompletarRegistro">
            <input name="act" type="hidden" value="completarPerfil">

            <div class="row">
                <div class="col-sm-3">
                    <label for="user_dob" class="control-label required-after">Fecha de nacimiento</label>
                    <input type="text" placeholder="Fecha de nacimiento" name="user_dob"  id="user_dob" class="form-control date-field">
                </div>
            </div>

            <div class="form-group genero" id="tipo">
                <div class="row">
                    <div class="col-sm-9">
                        <label class="control-label required-after">Género</label>
                    </div>
                    <div class="col-sm-9">

                        <label class="radio-inline">

                            <input type="radio" name="user_gender" value="M" class="register-radio" checked>Mujer
                        </label>
                        <label class="radio-inline">
                            <input type="radio" name="user_gender" value="H" class="register-radio">Hombre
                        </label>
                    </div>
                </div>
            </div>
            
            <div class="row first form-group description-field">
                <div id="charNum" class="counter"></div>
            <div class=" col-sm-12">
             
             <label class="control-label ">Descripción de perfil</label>
             <textarea name="user_descripcion" id="user_descripcion" class="form-control" rows="3" placeholder="Descripci&oacute;n de perfil" title="Descripción de perfil"></textarea>
            </div>
            </div>
            

            <div class="row">
                <div class="col-sm-6">
                                      <div class="form-group">
                        <label for="inputEmail3" class="control-label required-after">Dirección</label>
                        <input type="text" name="user_direccion" id="user_direccion"  class="form-control" placeholder="Direcci&oacute;n" title="Direcci&oacute;n">
                    </div>
                </div>
                <div class="col-sm-6">
                                      <div class="form-group">
                        <label for="inputEmail3" class="control-label required-after">Ciudad</label>
                        <input type="text" name="user_city" id="user_city"  class="form-control"  placeholder="Ciudad" title="Ciudad">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputEmail3" class="control-label required-after">Código postal</label>
                        <input type="text" name="user_cp" id="user_cp"  class="form-control"  placeholder="Código postal" title="Código postal">
                    </div>
                </div>
                <div class="col-sm-6 form-group">
                        <label for="inputEmail3" class="control-label ">Pa&iacute;s</label>
                        <select name="user_pais" id="user_pais" class="form-control">
                            <option value="">Pa&iacute;s</option>
                            <?php
                            $pais_q = listAll("paises"," ORDER BY nombre ASC");
                            while($pais = mysql_fetch_object($pais_q)){?>
                                <option value="<?php echo $pais->iso;?>"><?php echo utf8_encode($pais->nombre);?></option>
                            <?php  } ?>
                        </select>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputEmail3" class="control-label required-after">Teléfono</label>
                        <input type="text" name="user_telefono" id="user_telefono"  class="form-control" placeholder="Teléfono" title="Teléfono">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputEmail3" class="control-label">Teléfono móvil</label>
                        <input type="text" name="user_movil" id="user_movil"  class="form-control"  placeholder="Teléfono móvil" title="Teléfono móvil">
                    </div>
                </div>
            </div>
            
            <div id="bGuardar" class="save-buttons">
                <a class="btn btn-primary btn-lg pull-right">Guardar</a>
            </div>
            <a class="btn btn-alternative btn-lg pull-right skip-button">Omitir</a>
        </form>
    </div>
</div>

<script>
    jQuery(document).ready(function() {

        jQuery( "#bGuardar" ).click(function() {
            jQuery("#formCompletarRegistro").submit();
        });

        jQuery(".skip-button").click(function() {
            jQuery('input[name=act]').val('skipCompleteProfile');
            jQuery("#formCompletarRegistro").data("validator").settings.rules = undefined;
            jQuery("#formCompletarRegistro").submit();
        });

        jQuery('#user_dob').datepicker({
            dateFormat: "dd/mm/yy",
            maxDate: '-10Y',
            defaultDate: '-20Y',
            changeMonth: true,
            changeYear: true
        }); 
        
        contador(140, 20, '#user_descripcion');
    

        $("#formCompletarRegistro").validate({
    
        // Specify the validation rules
        rules: {
            user_descripcion: {
                required: <?php echo ($currentUser->user_type == User::USER_TYPE_PHOTOGRAPHER) ? 'true' : 'false' ?>,
                minlength: 20,
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
                number: true,
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

            user_descripcion: "La descripción debe contener entre 20 y 140 caracteres ",
             user_direccion: "La dirección debe contener mínimo 6 caracteres ",
             user_city: "La ciudad debe contener mínimo 4 caracteres ",
            "user_cp": {
                    required: "El código postal debe contener mínimo 5 caracteres ",
                    minlength: "El código postal debe contener mínimo 5 caracteres ",
                   number: "El código postal debe ser un número ",
            }, 
             "user_telefono": {
                 required: "Introduce tu número de teléfono",
                 number: "El teléfono tiene que ser un número",
                 minlength: "El teléfono tiene que tener mínimo 11 números",
             },
             user_pais: "Seleccions un país ",
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

    }); // cierre de document
</script>