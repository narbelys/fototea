<?php

use Fototea\Util\UrlHelper;
use Fototea\Models\CategoriesEvent;
use Fototea\Models\Category;
use Fototea\Models\Country;
use Fototea\Models\Project;
use Fototea\Models\User;

$currentUser = getCurrentUser();

if($currentUser && $currentUser->user_type == User::USER_TYPE_PHOTOGRAPHER){
    $app->redirect(UrlHelper::getProfileUrl());
    return;
}

$id = $app->getRequest()->get('id', false);

$isEdit = false;
$project = new stdClass();

if ($id) {
    //Editar proyecto mode on
    $isEdit = true;

    //Verificar que el proyecto sea mio
    /** @var \Fototea\Models\Project  $projectModel */
    $projectModel = $app->getModel('Project');
    $project = $projectModel->loadById($id);

    //Validate conditions
    if (!$project || !$projectModel->canBeModified($project, $currentUser)){
        //Invalid project
        $isEdit = false;
    }

    if ($isEdit) {
        //prepare fields
        $project->pro_date = $app->getHelper('DateHelper')->getShortDate($project->pro_date, 'd/m/Y');
        $project->pro_deadline = (!empty($project->pro_deadline)) ? $app->getHelper('DateHelper')->getShortDate($project->pro_deadline, 'd/m/Y') : '';
    }

}

//TODO validate categoria del proyecto client side
$mainCategories = Category::loadCategories();

foreach ($mainCategories as $category) {
    $category->events = CategoriesEvent::getListByCategory($category->id);
}

$countries = Country::loadCountries();
$session = validaSession();

$project->pro_type = '2';

?>

<div class="content-container">
    <div class="content form-page">

        <?php //var_dump($app->getInput()->errors()); ?>

        <?php if ($isEdit): ?>
        <h2>Editar Proyecto</h2>
        <?php else: ?>
        <h2>Publicar Proyecto</h2>
        <?php endif ?>

        <blockquote>
            <p>Completa la informaci&oacute;n de tu proyecto en el siguiente formulario.</p>
        </blockquote>
        <div class="formError bold" id="formError"></div>
        <form action="<?php echo UrlHelper::getUrl('actions/proyectosAction.php') ?>" method="post" id="project_form" enctype="multipart/form-data">

            <input name="pro_status" id="pro_status" type="hidden" value="B">

            <?php if ($isEdit): ?>
                <input name="act" id="act" type="hidden" value="editarProyecto">
                <input name="pro_id" id="act" type="hidden" value="<?php echo $id ?>">
            <?php else: ?>
                <input name="act" id="id" type="hidden" value="agregarProyecto">
            <?php endif ?>


            <div class="row">
                <div class="col-xs-12">
                    <div class="sub-title first">
                        <i class="glyphicon glyphicon-chevron-right"></i>Informaci&oacute;n general
                    </div>
                </div>

                <div class="form-group col-sm-4">
                    <label for="pro_type" class="control-label ">Tipo de proyecto</label>
                    <select name="pro_type" id="pro_type" class="form-control" value="<?php echo $app->getInput()->old('pro_type', $project->pro_type) ?>">
                        <option value="">Tipo de proyecto</option>
                        <?php foreach ($mainCategories as $cat): ?>
                            <option value="<?php echo $cat->id ?>" <?php echo ($app->getInput()->old('pro_type', $project->pro_type) == $cat->id)? 'selected':'' ?>><?php echo $cat->description ?></option>
                        <?php endforeach ?>
                    </select>
                </div>

                <div class="form-group col-sm-8">
                    <label for="pro_title" class="control-label ">Título de proyecto</label>
                    <input type="text" name="pro_title" id="pro_title"  class="form-control" value="<?php echo $app->getInput()->old('pro_title', $project->pro_tit) ?>"  placeholder="Título de proyecto" title="Título de proyecto">
                </div>
            </div>

            <div class="row description-field">
                <div id="charNum" class="counter"></div>
                <div class="form-group col-sm-12">
                    <label for="pro_descripcion" class="control-label">Descripci&oacute;n de proyecto</label>
                    <textarea name="pro_descripcion" id="pro_descripcion" class="form-control" rows="3" placeholder="Descripci&oacute;n de proyecto" title="Descripci&oacute;n de proyecto"><?php echo $app->getInput()->old('pro_descripcion', $project->pro_descripcion) ?></textarea>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-12">
                    <label for="pro_quant" class="control-label">Cantidad fotos/videos</label>
                    <input type="text" name="pro_quant" id="pro_quant" class="form-control" value="<?php echo $app->getInput()->old('pro_quant', $project->pro_cant) ?>" placeholder="Cantidad fotos/videos" title="Cantidad fotos/videos">
                </div>
            </div>
            <?php foreach($mainCategories as $mainCategory): ?>
                <div id="event_list_<?php echo $mainCategory->id ?>" data-list-type="project-event-list" style="display: none">

                    <?php if ($mainCategory->id == Category::VIDEO_PRODUCTION_AND_EDITION): ?>
                        <div class="row">
                            <div class="form-group col-sm-12">
                                <label for="pro_length" class="control-label">Duraci&oacute;n del video</label>
                                <input type="text" name="pro_length" id="pro_length" class="form-control"
                                       placeholder="Duraci&oacute;n del video" title="Duraci&oacute;n del video">
                            </div>
                        </div>
                    <?php endif ?>

                    <?php if ($mainCategory->id == Category::PHOTO_EDITION): ?>
                        <div class="row">
                            <div class="form-group col-xs-12">
                                <label for="pro_length" class="control-label">Imagen de muestra</label><br/>
                                <input type="text" id="muestraFileLabel" class="form-control file-upload-preview" style="width:150px"/>
                                <div class="file-upload btn btn-primary">
                                    <span>Subir archivo</span>
                                    <input id="uploadBtn" type="file" name="pro_sample" class="upload" />
                                </div>

                            </div>
                        </div>
                    <?php endif ?>

                    <div class="row">
                        <div class="col-xs-12">
                            <div class="sub-title">
                                <i class="glyphicon glyphicon-chevron-right"></i>
                                Categor&iacute;a del proyecto
                            </div>
                            <ul class="categories-list-form">
                                <?php foreach ($mainCategory->events as $event): ?>
                                    <li>
                                        <label for="pro_category_<?php echo $event->id ?>">
                                            <input name="pro_category" data-category-id="<?php echo $mainCategory->id ?>" id="pro_category_<?php echo $event->id ?>" type="radio"
                                                   value="<?php echo $event->id; ?>"  <?php echo ($app->getInput()->old('pro_category', $project->pro_category) == $event->id)? 'checked="checked"':'' ?> ><?php echo $event->description; ?>
                                        </label>
                                    </li>
                                <?php endforeach ?>
                            </ul>
                        </div>
                    </div>
                </div>
            <?php endforeach ?>

            <div class="row">
                <div class="col-xs-12">
                    <div class="sub-title">
                        <i class="glyphicon glyphicon-chevron-right"></i>Lugar y fecha del proyecto
                    </div>
                </div>

                <div class="form-group col-xs-12">
                    <label for="project_date" class="control-label">Fecha de proyecto</label>
                    <input  type="text" placeholder="dd/mm/yyyy" name="project_date" value="<?php echo $app->getInput()->old('project_date', $project->pro_date) ?>" id="project_date" class="form-control date-field" required>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="pro_direccion" class="control-label ">Dirección</label>
                    <input type="text" name="pro_direccion" id="pro_direccion" class="form-control" value="<?php echo $app->getInput()->old('pro_direccion', $project->pro_address) ?>" placeholder="Direcci&oacute;n" title="Direcci&oacute;n">
                </div>
                <div class="form-group col-sm-6">
                    <label for="pro_city" class="control-label ">Ciudad</label>
                    <input type="text" name="pro_city" id="pro_city"  class="form-control" value="<?php echo $app->getInput()->old('pro_city', $project->pro_city) ?>" placeholder="Ciudad" title="Ciudad">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="pro_estado" class="control-label ">Estado/Provincia</label>
                    <input type="text" name="pro_estado" id="pro_estado" class="form-control" value="<?php echo $app->getInput()->old('pro_estado', $project->pro_state) ?>" placeholder="Estado/Provincia" title="Estado/Provincia">
                </div>
                <div class="form-group col-sm-6">
                    <label for="pro_cp" class="control-label ">Código postal</label>
                    <input type="text" name="pro_cp" id="pro_cp" class="form-control" value="<?php echo $app->getInput()->old('pro_cp', $project->pro_cp) ?>" placeholder="Código postal" title="Código postal">
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="user_pais" class="control-label ">Pa&iacute;s</label>
                    <select name="user_pais" id="user_pais" class="form-control">
                        <option value="">Pa&iacute;s</option>
                        <?php foreach ($countries as $country): ?>
                            <option value="<?php echo $country->iso ?>" <?php echo ($app->getInput()->old('user_pais', $project->pro_country) == $country->iso)? 'selected':'' ?>><?php echo utf8_encode($country->nombre) //Wtf? ?></option>
                        <?php endforeach ?>
                    </select>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-sm-6">
                    <label for="pro_environment" class="control-label ">¿En qué tipo de ambiente se llevará a cabo el evento?</label>
                    <div>
                        <input id="pro_environment" name="pro_environment" type="radio" value="<?php echo Project::PROJECT_ENVIRONMENT_INSIDE ?>"
                            <?php echo ($app->getInput()->old('pro_environment', $project->pro_environment) == Project::PROJECT_ENVIRONMENT_INSIDE) ? 'checked' : '' ?>><?php echo Project::getEnvironmentsName(Project::PROJECT_ENVIRONMENT_INSIDE) ?>
                        <input id="pro_environment" name="pro_environment" type="radio" value="<?php echo Project::PROJECT_ENVIRONMENT_OUTSIDE ?>"
                            <?php echo ($app->getInput()->old('pro_environment', $project->pro_environment) == Project::PROJECT_ENVIRONMENT_OUTSIDE) ? 'checked' : '' ?>><?php echo Project::getEnvironmentsName(Project::PROJECT_ENVIRONMENT_OUTSIDE) ?>
                    </div>
                </div>
                <div class="form-group col-sm-6">
                    <label for="pro_moment" class="control-label ">¿En qué momento del día se llevará a cabo el evento?</label>
                    <div>
                        <input id="pro_moment" name="pro_moment" type="radio" value="<?php echo Project::PROJECT_MOMENT_DAY ?>"
                            <?php echo ($app->getInput()->old('pro_moment', $project->pro_moment) == Project::PROJECT_MOMENT_DAY) ? 'checked' : '' ?>><?php echo Project::getMomentsName(Project::PROJECT_MOMENT_DAY) ?>
                        <input id="pro_moment" name="pro_moment" type="radio" value="<?php echo Project::PROJECT_MOMENT_NIGHT ?>"
                            <?php echo ($app->getInput()->old('pro_moment', $project->pro_moment) == Project::PROJECT_MOMENT_NIGHT) ? 'checked' : '' ?>><?php echo Project::getMomentsName(Project::PROJECT_MOMENT_NIGHT) ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="form-group col-xs-12">
                    <label for="pro_deadline" class="control-label">Deadline de la entrega</label>
                    <input  type="text" placeholder="dd/mm/yyyy" name="pro_deadline" value="<?php echo $app->getInput()->old('pro_deadline', $project->pro_deadline) ?>" id="pro_deadline" class="form-control date-field">
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <div class="form-buttons">
                        <a class="btn btn-cancel" href="<?php echo UrlHelper::getProfileUrl() ?>">Cancelar</a>
                        <?php if ($session): ?>
                            <button type="button" id="create_draft_btn" class="btn btn-alternative">Borrador</button>
                            <button type="button" id="create_active_btn" class="btn btn-primary">Publicar</button>
                        <?php else: ?>
                            <button type="button" id="create_draft_btn" class="btn btn-primary">Crear</button>
                        <?php endif ?>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>

<script type="text/javascript">
    (function($){
        function agregarPro(action){
            $("#pro_status").val(action);
            $("#project_form").submit();
        };

        $(document).ready(function () {
            $('#project_date').datepicker({
                dateFormat: "dd/mm/yy",
                maxDate: '+2Y',
                minDate: '+1D',
                changeMonth: true,
                changeYear: true
            });

            $('#pro_deadline').datepicker({
                dateFormat: "dd/mm/yy",
                maxDate: '+2Y',
                minDate: '+1D',
                changeMonth: true,
                changeYear: true
            });
            
            contador(500, 150, '#pro_descripcion');

            $("#project_form").validate({
                // Specify the validation rules
                rules: {
                    pro_type: {
                        required: true

                    },
                    pro_title: {
                        required: true,
                        minlength: 4,
                        maxlength: 50

                    },

                    pro_descripcion: {
                        required: true,
                        minlength: 150,
                        maxlength: 500

                    },
                    pro_direccion: {
                        required: true,
                        minlength: 6

                    },
                    pro_city: {
                        required: true,
                        minlength: 4

                    },
                    pro_estado: {
                        required: true,
                        minlength: 2

                    },
                    user_pais: {
                        required: true

                    },
                    pro_cp: {
                        number: true,
                        required: true,
                        minlength: 5

                    }//,
//                    pro_category: {
//                        required:true
//                    }
                },

                // Specify the validation error messages
                messages: {
                     pro_type: "Selecciona un tipo de proyecto",
                     pro_title: "Escribe el nombre del proyecto",
                     pro_descripcion:"La descripción debe contener entre 150 y 500 caracteres ",
                     pro_direccion: "La dirección debe contener mínimo 6 caracteres ",
                     pro_city: "La ciudad debe contener mínimo 4 caracteres ",
                     user_pais: "Selecciona un país ",
                     pro_estado: "El estado/provincia debe contener mínimo 2 caracteres ",
                     pro_cp: "El código debe contener mínimo 5 caracteres",
                     project_date: {
                         required:"Selecciona la fecha en la que se llevará a cabo el proyecto"
                     }
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

            $('#create_draft_btn').click(function() {
                agregarPro('B');
            });

            $('#create_active_btn').click(function() {
                agregarPro('A');
            });

            $("#pro_type").change(function() {
                var id = $("#pro_type").val();
                $('div[data-list-type="project-event-list"]').hide();

                //Disable all fields
                $('div[data-list-type="project-event-list"] input').attr('disabled', true);

                if (id > 0) {
                    $("#event_list_" + id).show();
                    //Enable fields for current project type/category
                    $("#event_list_" + id + " input").attr('disabled', false);
                }
            });

            $("#pro_type").trigger('change');
        }); // cierre de document

    }(jQuery));
</script>
