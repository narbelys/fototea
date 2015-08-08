<?php

use Fototea\Util\UrlHelper;
use Fototea\Models\User;

$session = validaSession();

if($session != true){
    $app->redirect($app->getConfig()->getUrl('home'));
    return;
}

$currentUser = getCurrentUser();

if($currentUser->user_type == User::USER_TYPE_CLIENT || $currentUser->profile_completed == User::USER_COMPLETED_PROFILE){
    $app->redirect($app->getConfig()->getUrl('perfil'));
    return;
}

?>

<div class="content-container">
    <div class="content complete-preferences" style="width: 50%;" id="completarRegistro">
        <h2>Completar informaci&oacute;n t&eacute;cnica<a class="btn btn-alternative btn-mini pull-right skip-button skip-button-top">Omitir</a></h2>
        <blockquote>
            <p>Completa la informaci&oacute;n t&eacute;cnica de tu perfil para que tus clientes puedan saber m&aacute;s de ti.</p>
        </blockquote>
        <div class="formError bold" id="formError"></div>
        <form action="actions/perfilAction.php" method="post" id="formCompletarInteres">
            <div class="row">
                <div class="col-xs-12">
                    <div class="sub-title first">
                        <i class="glyphicon glyphicon-chevron-right"></i>Equipo
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="inputEmail3" class="control-label required-after">C&aacute;mara</label>
                        <div class="camara-real">
                            <div class="camara-block">
                                <input id="camara_first" class="form-control multiple-field" type="text" value="" placeholder="Cámara" name="user_camara[]">
                            </div>
                        </div>
                        <a class="plus" onclick="addProfileField('user_camara', 'camara-real');" title="Agregar">
                            <i class="plus glyphicon glyphicon-plus"></i><span>Agregar más</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-7">
                    <div class="form-group">
                        <label for="lentes-first" class="control-label">Lentes</label>
                        <div class="lentes-real">
                            <div class="lentes-block">
                                <input id="lentes-first" class="form-control multiple-field" type="text" value="" placeholder="Lentes" name="user_lentes[]">
                            </div>
                        </div>
                        <a class="plus" onclick="addProfileField('user_lentes', 'lentes-real');" title="Agregar">
                            <i class="plus glyphicon glyphicon-plus"></i><span>Agregar más</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-7">
                    <div class="form-group">
                        <label for="equipo-first" class="control-label">Equipo general</label>
                        <div class="equipo-real">
                            <div class="equipo-block">
                                <input id="equipo-first" class="form-control multiple-field" type="text" value="" placeholder="Equipo general" name="user_equipo[]">
                            </div>
                        </div>
                        <a class="plus" onclick="addProfileField('user_equipo', 'equipo-real');" title="Agregar">
                            <i class="plus glyphicon glyphicon-plus"></i><span>Agregar más</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="sub-title">
                        <i class="glyphicon glyphicon-chevron-right"></i>Datos del fotógrafo
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="inputEmail3" class="control-label">Escuela de fotografía</label>
                        <input type="text" name="user_escuela_fotografia" id="user_escuela_fotografia" class="form-control" placeholder="Escuela de fotografía" title="Escuela de fotografía">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="inputEmail3" class="control-label">Más educación</label>
                        <textarea name="user_mas_educacion" id="user_mas_educacion" class="form-control" rows="3" placeholder="Más educación" title="Más educación"></textarea>    
                       
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-7">
                    <div class="form-group experiencia-laboral">
                        <label for="experience-first" class="control-label">Experiencia y proyectos anteriores</label>
                        <div class="experience-laboral-real">
                            <div class="experience-block">
                                <input id="experience-first" class="form-control multiple-field" type="text" value="" placeholder="Empresa/Proyecto" name="user_experience_empresa[]">
                                <input class="form-control multiple-field" type="text" value="" placeholder="Localidad" name="user_experience_localidad[]">
                            </div>
                        </div>
                        <a class="plus" onclick="addProfileField('user_laboral_experience', 'experience-laboral-real');" title="Agregar">
                            <i class="glyphicon glyphicon-plus"></i><span>Agregar más</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-7">
                    <div class="form-group">
                        <label for="idiomas-first" class="control-label">Idiomas</label>
                        <div class="idiomas-real">
                            <div class="idiomas-block">
                                <input id="idiomas-first" class="form-control multiple-field" type="text" value="" placeholder="Idioma" name="user_idiomas[]">
                            </div>
                        </div>
                        <a class="plus" onclick="addProfileField('user_idiomas', 'idiomas-real');" title="Agregar">
                            <i class="plus glyphicon glyphicon-plus"></i><span>Agregar más</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-7">
                    <div class="form-group">
                        <label for="habilidades-first" class="control-label">Habilidades</label>
                        <div class="habilidades-real">
                            <div class="habilidades-block">
                                <input id="habilidades-first" class="form-control multiple-field" type="text" value="" placeholder="Habilidades" name="user_habilidades[]">
                            </div>
                        </div>
                        <a class="plus" onclick="addProfileField('user_habilidades', 'habilidades-real');" title="Agregar">
                            <i class="plus glyphicon glyphicon-plus"></i><span>Agregar más</span>
                        </a>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label class="control-label">RUT</label>
                        <input type="text" name="user_rut" id="user_rut" class="form-control rut" placeholder="RUT" title="RUT">
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="sub-title">
                        <i class="glyphicon glyphicon-chevron-right"></i>&Aacute;reas de especialidad
                    </div>
                </div>
            </div>
                <?php
            $list_cat = listAll("categories","ORDER BY categories.order ASC");

            while($rs_cat = mysql_fetch_object($list_cat)){
        ?>
            <p><?php echo $rs_cat->description;?></p>
            <ul class="categories-list-form">
                <?php $list_subCat = listAll("categories_event", "WHERE id_cat = '$rs_cat->id' ORDER BY description ASC");
                while ($rs_subCat = mysql_fetch_object($list_subCat)){
                    ?>
                    <li class="txtGris"><input name="user_interes[]" id="user_interes" class="user_interes" type="checkbox" value="<?php echo $rs_subCat->id; ?>"><?php echo $rs_subCat->description; ?></li>
                <?php  } ?>
            </ul>
        <?php }?>
        
            <input name="act" type="hidden" value="completarPreferencias">
            <div id="bGuardar" class="">
                <a class="btn btn-primary btn-lg pull-right">Guardar</a>
            </div>
            <a class="btn btn-alternative btn-lg pull-right skip-button">Omitir</a>
        </form>
    </div>
</div>

<script>

    jQuery(document).ready(function() {
        jQuery("#bGuardar").click(function(){
            jQuery("#formCompletarInteres").submit();
        });

        jQuery(".skip-button").click(function() {
            jQuery('input[name=act]').val('skipCompleteProfile');
            jQuery("#formCompletarInteres").data("validator").settings.rules = undefined;
            jQuery("#formCompletarInteres").submit();
        });

        jQuery('#user_rut').Rut({
          //on_error: function(){alert('Rut incorrecto');  $('#user_rut').closest('.form-group').removeClass('has-success').addClass('has-error').addClass('has-feedback'); },
          //on_success: function(){ $('#user_rut').closest('.form-group').removeClass('has-error').addClass('has-success'); },
          format_on: 'keyup',
          validation: true
        });


        $.validator.addMethod("rut", function(value, element) {
          return this.optional(element) || $.Rut.validar(value);
            });

        jQuery("#formCompletarInteres").validate({
            // Specify the validation rules
            rules: {
                'user_camara[]': {
                    required: true,
                },
                user_lentes: {
                    required: true,
                },
                user_interes: {
                    required: true,
                },
                user_rut: {
                    maxlength: 13
                },
            },

            // Specify the validation error messages
            messages: {
                'user_camara[]': "Introduzca una cámara ",
                 user_lentes: "Introduzca un lente",
                 user_interes: "ebe seleccionar al menos una área de especialidad ",
                "user_rut": {
                     maxlength: "El RUT no debe exceder los 13 caracteres",
                     rut: "El RUT es incorrecto"
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