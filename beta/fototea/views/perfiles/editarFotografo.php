<?php
$session = validaSession();
 
if($session != true){
    $app->redirect($app->getConfig()->getUrl('home'));
    return;
}
?>

<div class="content-container">
    <div class="content form-page">

         <h2>Editar informaci&oacute;n de perfil</h2>

         <div class="formError bold" id="formError"></div>
         <form action="actions/perfilAction.php" method="post" id="formEditarPerfil" enctype="multipart/form-data">
            <input name="act" type="hidden" value="editarPerfil">

            <div class="row first">
                <div class="col-xs-12">
                    <div class="sub-title first">
                        <i class="glyphicon glyphicon-chevron-right"></i>Informaci&oacute;n general
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-6">
                    <label class="control-label required-after">Nombre</label>
                    <input type="text" name="user_name" id="user_name" value="<?php echo $userInfo['name'];?>"    class="form-control " title="Nombre" placeholder="Nombre">
                </div>
                <div class="form-group col-sm-6">
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
                <div class=" form-group col-sm-3">
                    <label for="user_dob" class="control-label required-after">Fecha de nacimiento</label>
                    <input  type="text" name="user_dob" placeholder="Fecha de nacimiento" value="<?php echo $userInfo['user_dob'] ?>"  id="user_dob" class="form-control">
                </div>
            </div>

            <div class="row description-field">
                <div id="charNum" class="counter"></div>
                <div class="form-group col-sm-12">
                    <label class="control-label ">Descripción de perfil</label>
                    <textarea name="user_descripcion" id="user_descripcion" class="form-control" rows="3" placeholder="Descripci&oacute;n de perfil" title="Descripción de perfil"><?php echo $userInfo['descripcion'];?></textarea>
                    
                </div>
            </div>
        
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label ">Dirección</label>
                        <input type="text" name="user_direccion" id="user_direccion" value="<?php echo $userInfo['direccion'];?>"  class="form-control" placeholder="Direcci&oacute;n" title="Direcci&oacute;n">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="control-label ">Ciudad</label>
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
                        <input type="text" name="user_movil" id="user_movil" value="<?php echo $userInfo['movil']; ?>"  class="form-control"  placeholder="Teléfono móvil" title="Teléfono móvil">
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
                        <label for="inputEmail3" class="control-label ">Escuela de fotografía</label>
                        <input type="text" name="user_escuela_fotografia" id="user_escuela_fotografia" placeholder="Escuela de fotografía" value="<?php echo $userInfo['escuela-fotografia'];?>" class="form-control" title="Escuela de fotografía">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="inputEmail3" class="control-label ">Más educación</label>
                        <textarea name="user_mas_educacion" id="user_mas_educacion" class="form-control" rows="3" placeholder="Más educación" title="Más educación"><?php echo $userInfo['mas-educacion'];?></textarea>
                    </div>
                </div>
            </div>

             <div class="row">
                 <div class="col-sm-7">
                     <div class="form-group experiencia-laboral">
                         <label for="experience-first" class="control-label">Experiencia y proyectos anteriores</label>
                         <div class="experience-laboral-real">
                             <?php foreach($userInfo['experiencia-laboral'] as $key => $exp): ?>
                                 <div class="experience-block">
                                     <input id="<?php if ($key == 0): ?>experience-first<?php endif ?>" class="form-control multiple-field" type="text" value="<?php echo $exp->empresa ?>" placeholder="Empresa/Proyecto" name="user_experience_empresa[]">
                                     <input class="form-control multiple-field" type="text" value="<?php echo $exp->localidad ?>" placeholder="Localidad" name="user_experience_localidad[]">
                                     <?php if ($key > 0): ?>
                                         <a class='multiple-field-remove' id='multiple-field-remove' onclick='removeProfileField(this);'></a>
                                     <?php endif ?>
                                 </div>
                             <?php endforeach ?>
                             <?php if ($userInfo['experiencia-laboral'] == ''): ?>
                                 <div class="experience-block">
                                     <input id="experience-first" class="form-control multiple-field" type="text" value="" placeholder="Empresa/Proyecto" name="user_experience_empresa[]">
                                     <input class="form-control multiple-field" type="text" value="" placeholder="Localidad" name="user_experience_localidad[]">
                                 </div>
                             <?php endif ?>
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
                            <?php foreach($userInfo['idiomas'] as $key => $idiomas): ?>
                                <div class="idiomas-block">
                                    <input id="<?php if ($key == 0): ?>idiomas-first<?php endif ?>" class="form-control multiple-field" type="text" value="<?php echo $idiomas ?>" placeholder="Idioma" name="user_idiomas[]">
                                    <?php if ($key > 0): ?>
                                        <a class='multiple-field-remove' id='multiple-field-remove' onclick='removeProfileField(this);'></a>
                                    <?php endif ?>
                                </div>
                            <?php endforeach ?>
                            <?php if (count($userInfo['idiomas']) == 0): ?>
                                <div class="idiomas-block">
                                    <input id="idiomas-first" class="form-control multiple-field" type="text" value="" placeholder="Idioma" name="user_idiomas[]">
                                </div>
                            <?php endif ?>
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
                            <?php foreach($userInfo['habilidades'] as $key => $habilidades): ?>
                                <div class="habilidades-block">
                                    <input id="<?php if ($key == 0): ?>habilidades-first<?php endif ?>" class="form-control multiple-field" type="text" value="<?php echo $habilidades ?>" placeholder="Habilidades" name="user_habilidades[]">
                                    <?php if ($key > 0): ?>
                                        <a class='multiple-field-remove' id='multiple-field-remove' onclick='removeProfileField(this);'></a>
                                    <?php endif ?>
                                </div>
                            <?php endforeach ?>
                            <?php if (count($userInfo['habilidades']) == 0): ?>
                                <div class="habilidades-block">
                                    <input id="habilidades-first" class="form-control multiple-field" type="text" value="" placeholder="Habilidades" name="user_habilidades[]">
                                </div>
                            <?php endif ?>
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
                        <input type="text" name="user_rut" id="user_rut" value="<?php echo $userInfo['rut'];?>" class="form-control rut" placeholder="RUT" title="RUT">
                        
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="sub-title">
                        <i class="glyphicon glyphicon-chevron-right"></i>Informaci&oacute;n t&eacute;cnica
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="sub-section">Equipo</div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group">
<!--                        <label class="control-label ">C&aacute;mara</label>-->
<!--                        <input type="text" name="user_camara" id="user_camara" value="--><?php //echo $userInfo['cam'] ?><!--" class="form-control" placeholder="C&aacute;mara" title="C&aacute;mara">-->
                        <label for="camara-first" class="control-label">Cámara</label>
                        <div class="camara-real">
                            <?php foreach($userInfo['cam'] as $key => $camara): ?>
                                <div class="camara-block">
                                    <input id="<?php if ($key == 0): ?>camara-first<?php endif ?>" class="form-control multiple-field" type="text" value="<?php echo $camara ?>" placeholder="Cámaras" name="user_camara[]">
                                    <?php if ($key > 0): ?>
                                        <a class='multiple-field-remove' id='multiple-field-remove' onclick='removeProfileField(this);'></a>
                                    <?php endif ?>
                                </div>
                            <?php endforeach ?>
                            <?php if (count($userInfo['cam']) == 0): ?>
                                <div class="camara-block">
                                    <input id="camara-first" class="form-control multiple-field" type="text" value="" placeholder="Cámara" name="user_camara[]">
                                </div>
                            <?php endif ?>
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
                            <?php foreach($userInfo['lentes'] as $key => $lentes): ?>
                                <div class="lentes-block">
                                    <input id="<?php if ($key == 0): ?>lentes-first<?php endif ?>" class="form-control multiple-field" type="text" value="<?php echo $lentes ?>" placeholder="Lentes" name="user_lentes[]">
                                    <?php if ($key > 0): ?>
                                        <a class='multiple-field-remove' id='multiple-field-remove' onclick='removeProfileField(this);'></a>
                                    <?php endif ?>
                                </div>
                            <?php endforeach ?>
                            <?php if (count($userInfo['lentes']) == 0): ?>
                            <div class="lentes-block">
                                <input id="lentes-first" class="form-control multiple-field" type="text" value="" placeholder="Lentes" name="user_lentes[]">
                            </div>
                            <?php endif ?>
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
                            <?php foreach($userInfo['equip'] as $key => $equipo): ?>
                                <div class="equipo-block">
                                    <input id="<?php if ($key == 0): ?>equipo-first<?php endif ?>" class="form-control multiple-field" type="text" value="<?php echo $equipo ?>" placeholder="Equipo general" name="user_equipo[]">
                                    <?php if ($key > 0): ?>
                                        <a class='multiple-field-remove' id='multiple-field-remove' onclick='removeProfileField(this);'></a>
                                    <?php endif ?>
                                </div>
                            <?php endforeach ?>
                            <?php if (count($userInfo['equip']) == 0): ?>
                                <div class="equipo-block">
                                    <input id="equipo-first" class="form-control multiple-field" type="text" value="" placeholder="Equipo general" name="user_equipo[]">
                                </div>
                            <?php endif ?>
                        </div>
                        <a class="plus" onclick="addProfileField('user_equipo', 'equipo-real');" title="Agregar">
                            <i class="plus glyphicon glyphicon-plus"></i><span>Agregar más</span>
                        </a>
                    </div>
                </div>
            </div>
            <br/>
            <div class="row">
                <div class="col-xs-12">
                    <div class="sub-section">&Aacute;reas de especialidad</div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <?php
                            $list_cat = listAll("categories","ORDER BY categories.order ASC");

                            while($rs_cat = mysql_fetch_object($list_cat)){
                            ?>
                            <p><?php echo $rs_cat->description;?></p>
                            <ul class="categories-list-form">
                                <?php $list_subCat = listAll("categories_event", "WHERE id_cat = '$rs_cat->id' ORDER BY description ASC");
                                while ($rs_subCat = mysql_fetch_object($list_subCat)){
                                    $userCat = getUserInterest($userInfo['id'],$rs_subCat->id);
                                    ?>
                                    <li class="txtGris"><input name="user_interes[]" id="user_interes" class="user_interes" type="checkbox" value="<?php echo $rs_subCat->id; ?>" <?php if($userCat == true){ echo 'checked="checked"';} ?>><?php echo $rs_subCat->description; ?></li>
                                <?php  } ?>
                            </ul>
                        <?php }?>

                        <div class="row">
                            <div class="col-xs-12">
                                <div class="sub-title">
                                    <i class="glyphicon glyphicon-chevron-right"></i>Datos de pago
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <p>Ingrese sus usuario de Paypal para poder recibir los pagos por sus proyectos finalizados.</p>
                                <input type="text" name="user_pago" id="user_pago" value="<?php echo $userInfo['user_pago'];?>" class="form-control">
                            </div>
                         </div>
                    </div>
                </div>
            </div>
            <div class="row save-buttons">
                <div>
                <button type="button" id="bGuardar" class="btn btn-lg btn-primary pull-right">Guardar</button>
                </div>
                <a class="btn btn-alternative btn-lg pull-right skip-button" href="perfil">Cancelar</a>
            </div>
         </form>
    </div>
</div>    
        

<script>
    jQuery(document).ready(function() {
        jQuery('#user_rut').Rut({
          //on_error: function(){alert('Rut incorrecto');  $('#user_rut').closest('.form-group').removeClass('has-success').addClass('has-error').addClass('has-feedback'); },
          //on_success: function(){ $('#user_rut').closest('.form-group').removeClass('has-error').addClass('has-success'); },
          format_on: 'keyup',
          validation: true
        });
        
       // jQuery( "#user_rut" ).keyup(function() {
        //   var parts = $( "#user_rut" ).split("-"),
        //   if (parts[1]=="k"){alert("holaaaaaaaaaa")}
        //});
        

        jQuery('#user_dob').datepicker({
            dateFormat: "dd/mm/yy",
            maxDate: '-10Y',
            defaultDate: '-20Y',
            changeMonth: true,
            changeYear: true
        });
        
        $.validator.addMethod("rut", function(value, element) {
          return this.optional(element) || $.Rut.validar(value);
            });
        
        contador(140, 20, '#user_descripcion');
        
        jQuery("#formEditarPerfil").validate({
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
                    required: true,
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
                 user_name: "Introduce tu nombre",
                user_lastname: "Introduce tu apellido",
                user_email: "Introduce tu correo electrónico",

                user_descripcion: "La descripción debe contener entre 20 y 140 caracteres ",
                 user_direccion: "La dirección debe contener mínimo 6 caracteres ",
                 user_city: "La ciudad debe contener mínimo 4 caracteres ",
                 "user_cp": {
                        required: "El código postal debe contener mínimo 5 caracteres ",
                        minlength: "El código postal debe contener mínimo 5 caracteres ",
                       number: "El código postal debe ser un número ",
                },

                 user_pais: "Selecciona un país ",
                "user_telefono": {
                     required: "Introduce tu número de teléfono",
                     number: "El teléfono tiene que ser un número",
                     minlength: "El teléfono tiene que tener mínimo 11 números",
                 },


                'user_camara[]': "Introduce una cámara ",
                 user_lentes: "Introduce un lente",
                 user_interes: "Debes seleccionar al menos una área de especialidad ",
                 "user_rut": {
                     maxlength: "El RUT no debe exceder los 13 caracteres",
                     rut: "El RUT es incorrecto"
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

        jQuery("#bGuardar").click(function(){
            jQuery("#formEditarPerfil").submit();
        });

<!--        --><?php //foreach($userInfo['lentes'] as $lentes): ?>
<!--            addProfileField('user_lentes', 'lentes-real','--><?php //echo $lentes   ?><!--')-->
<!--        --><?php //endforeach ?>

<!--        --><?php //foreach($userInfo['equip'] as $equipo): ?>
<!--        addProfileField('user_equipo', 'equipo-real','<?php echo $equipo ?>')-->
<!--        --><?php //endforeach ?>

<!--        --><?php //foreach($userInfo['experiencia-laboral'] as $exp): ?>
<!--             addProfileField('user_laboral_experience', 'experiencia-laboral-real','<?php echo $exp->empresa ?>', '<?php echo $exp->localidad ?>')-->
<!--        --><?php //endforeach ?>

<!--        --><?php //foreach($userInfo['idiomas'] as $idioma): ?>
<!--            addProfileField('user_idiomas', 'idiomas-real','<?php echo $idioma   ?>')-->
<!--        --><?php //endforeach ?>

<!--        --><?php //foreach($userInfo['habilidades'] as $hab): ?>
<!--            addProfileField('user_habilidades', 'habilidades-real','<?php echo $hab ?>')-->
<!--        --><?php //endforeach ?>

    }); // cierre de document
</script>