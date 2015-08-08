<?php

use Fototea\Models\User;
use Fototea\Models\Project;
use Fototea\Models\Project_View;
use Fototea\Config\FConfig;
use Fototea\Util\DateHelper;
use Fototea\Util\UrlHelper;
use \ORM;

if (!$same_user) {
    die('not allowed');
}
?>

<?php

if ($current_user->user_type == User::USER_TYPE_PHOTOGRAPHER) {
    // FILTROS
    //TODO better to use count here to mysql
    $my_projects = listAll(" ofertas","WHERE ofertas.user_id = '$current_user->id'");
    $my_projects_count = mysql_num_rows($my_projects);

    //Mis propuestas enviadas
    $opened_projects_query = "WHERE ofertas.user_id = '$current_user->id' AND proyectos.pro_id = ofertas.pro_id"
                           . " AND pro_status = '" . Project::PROJECT_STATUS_ACTIVE . "' AND awarded = 'N'"
                           . " ORDER BY pro_date_end DESC";
    $opened_projects = listAll("proyectos, ofertas", $opened_projects_query);
    $opened_projects_count = intval(mysql_num_rows($opened_projects));

    //Mis propuestas rechazadas
    $rejected_projects_query = "WHERE ofertas.user_id = '$current_user->id' AND proyectos.pro_id = ofertas.pro_id"
                           . " AND (pro_status = '" . Project::PROJECT_STATUS_CLOSED_CLIENT . "' OR pro_status = '" . Project::PROJECT_STATUS_CLOSED_PHOTOGRAPHER . "' OR pro_status = '" . Project::PROJECT_STATUS_CLOSED_FOTOTEA . "' OR pro_status = '" . Project::PROJECT_STATUS_CANCELLED . "') AND awarded = 'N'"
                           . " ORDER BY pro_date_end DESC";

    $rejected_projects = listAll("proyectos, ofertas", $rejected_projects_query);
    $rejected_projects_count = intval(mysql_num_rows($closed_projects));

    //Projectos adjudicados
    $adjudicated_projects_query = "WHERE ofertas.user_id = '$current_user->id' AND proyectos.pro_id = ofertas.pro_id"
        . " AND pro_status = '" . Project::PROJECT_STATUS_ADJUDICATED . "' AND awarded = 'S'"
        . " ORDER BY pro_date_end DESC";


    $adjudicated_projects = listAll("proyectos, ofertas", $adjudicated_projects_query);
    $adjudicated_projects_count = intval(mysql_num_rows($adjudicated_projects));

    //Projectos finalizados
    $closed_projects_query = "WHERE ofertas.user_id = '$current_user->id' AND proyectos.pro_id = ofertas.pro_id"
        . " AND (pro_status = '" . Project::PROJECT_STATUS_CLOSED_PHOTOGRAPHER . "' OR pro_status = '" . Project::PROJECT_STATUS_CLOSED_CLIENT . "' OR pro_status = '" . Project::PROJECT_STATUS_CLOSED_FOTOTEA . "') AND awarded = 'S'"
        . " ORDER BY pro_date_end DESC";

    $closed_projects = listAll("proyectos, ofertas", $closed_projects_query);
    $closed_projects_count = intval(mysql_num_rows($closed_projects));

    $filter = $_GET['filtro'];
    $campos = "";

    if($filter == "rechazadas"){
        $projects = $rejected_projects;
    }elseif($filter == "adjudicados"){
        $projects = $adjudicated_projects;
    }elseif($filter == "finalizados"){
        $projects = $closed_projects;
    }else{
        //$projects = $my_projects;  //TODO aclarar esta parte con paulo ofertas o proyectos??
        $projects = $opened_projects;
        $filter = "enviadas";
    }

    $project_list = array();
    while ($rs_proj = mysql_fetch_object($projects)){

        $rs_proj->days_left = diffDate(date("Y-m-d H:i:s"),$rs_proj->pro_date_end); //$diasRest
        $rs_proj->pro_tit = ucfirst($rs_proj->pro_tit);

        $rs_proj->mensaje = substr($rs_proj->mensaje, "0","1000");

        //Get proyect owner
        $pro_user = listAll("proyectos","WHERE pro_id = '$rs_proj->pro_id'");
        $pro_user = mysql_fetch_object($pro_user); //$rs_pro_user
        $rs_proj->project_owner = getUserInfo($pro_user->user_id); //$user_crea
        $rs_proj->project_owner_ratings = ratings($pro_user->user_id);

        //TODO mejorar esto, al ejecutar los queries de arriba sobre project view no hay necesidad de hacer esto
        $proView =  Project_View::loadProjectById($rs_proj->pro_id);
        $rs_proj->total_ofertas = $proView->total_ofertas;
        $project_list[] = $rs_proj;
    }
}
?>

<?php if ($current_user->user_type == User::USER_TYPE_PHOTOGRAPHER): ?>
<div class="containerPerfil">
    <div class="list-container">
        <div class="list-header">
            <div class="col-xs-3">
                <?php if ($filter == "enviadas"): ?>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                <?php endif ?>
                <?php $actUrl = FConfig::getUrl('perfil?act=' . $current_tab) ?>
                <a class="<?php echo ($filter == "enviadas")? 'selected':'' ?>" href="<?php echo $actUrl ?>">
                    Propuestas Activas
                </a>
                <span><?php echo $opened_projects_count ?></span>
            </div>
            <div class="col-xs-3">
                <?php if ($filter == "rechazadas"): ?>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                <?php endif ?>
                <?php $rejectUrl = FConfig::getUrl('perfil?act=' . $current_tab . '&filtro=rechazadas') ?>
                <a class="<?php echo ($filter == "rechazadas")? 'selected':'' ?>" href="<?php echo $rejectUrl ?>">
                    Propuestas Rechazadas
                </a>
                <span><?php echo $rejected_projects_count ?></span></div>
            <div class="col-xs-3">
                <?php if ($filter == "adjudicados"): ?>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                <?php endif ?>
                <?php $adjudUrl = FConfig::getUrl('perfil?act=' . $current_tab . '&filtro=adjudicados') ?>
                <a class="<?php echo ($filter == "adjudicados")? 'selected':'' ?>" href="<?php echo $adjudUrl ?>">
                    Proyectos Adjudicados
                </a>
                <span><?php echo $adjudicated_projects_count ?></span>
            </div>
            <div class="col-xs-3 last">
                <?php if ($filter == "finalizados"): ?>
                    <span class="glyphicon glyphicon-chevron-right"></span>
                <?php endif ?>
                <?php $adjudUrl = FConfig::getUrl('perfil?act=' . $current_tab . '&filtro=finalizados') ?>
                <a class="<?php echo ($filter == "finalizados")? 'selected':'' ?>" href="<?php echo $adjudUrl ?>">
                    Proyectos Finalizados
                </a>
                <span><?php echo $closed_projects_count ?></span>
            </div>
        </div>

        <div class="list-content">
        <?php

        if(count($project_list) > 0):

            foreach ($project_list as $rs_proj): ?>
                <div class="list-item">
                    <div class="col-xs-2">
                                                        <?php if ($rs_proj->pro_type == 1): ?>                   
                                      <span class="glyphicon glyphicon-camera icon-proyect"></span> &nbsp;&nbsp;
                                 <?php endif ?>
                                <?php if ($rs_proj->pro_type == 2): ?>                   
                                      <span class="glyphicon glyphicon-edit icon-proyect"></span> &nbsp;&nbsp;
                                 <?php endif ?>
                                <?php if ($rs_proj->pro_type == 3): ?>                   
                                      <span class="glyphicon glyphicon-facetime-video icon-proyect"></span> &nbsp;&nbsp;
                                 <?php endif ?>
                                 
                        <span class="txtAzul font18 titProyecto">
                            <a class="project-link" href="<?php echo UrlHelper::getProjectUrl($rs_proj->pro_id) ?>"><?php echo $rs_proj->pro_tit ?></a>
                        </span><br/>
                        <span class="font12">
                            <?php echo $rs_proj->pro_city ?>
                            <br/>
                            <?php if($rs_proj->pro_status == Project::PROJECT_STATUS_ACTIVE): ?>
                                <?php echo $rs_proj->days_left[2] ?> d&iacute;as para adjudicar
                            <?php else:
                                echo DateHelper::getLongDate($rs_proj->pro_date);
                            endif ?>
                        </span>
                        <div class="alert alert-info text-center" style="margin-top:1em;">
                            Ofertas: <?php echo $rs_proj->total_ofertas ?>
                        </div>
                    </div>
                    <div class="col-xs-8 offer-detail">
                        <h4>Mi oferta</h4>
                        <p>
                            <?php echo substr($rs_proj->mensaje, 0, 500);
                            if (strlen($rs_proj->mensaje) > 500): ?>
                                ... <a class="see-more" href="<?php echo UrlHelper::getProjectUrl($rs_proj->pro_id) ?>">Ver más >></a>
                            <?php endif ?>
                        </p>
                        <b>Monto: <?php echo number_format($rs_proj->bid,'2',',','.');?></b>
<!--                        --><?php // if($rs_proj->pro_status == Project::PROJECT_STATUS_ACTIVE):?>
<!--                            -  <a href="ofertaEditar?pid=--><?php //echo $rs_proj->pro_id ?><!--&oid=--><?php //echo $rs_proj->id ?><!--" class="font12 txtNaranja">Editar propuesta</a>-->
<!--                        --><?php //endif ?>
                    </div>

                    <div class="col-xs-2">
                        <div class="proBoxUserContFot">
                            <div class="left">
                                <div>
                                    <img alt="Imagen de usuario" src="<?php echo FConfig::getThumbUrl($rs_proj->project_owner['profile_image_url'], FConfig::getValue('profile_image_width'), FConfig::getValue('profile_image_height')) ?>" width="60" height="60" class="img-circle">
                                </div>
                            </div>
                            <div class="left proBoxUser">
                                <div class="font12 fontW400">Publicado por:</div>
                                <div><a href="perfil?us=<?php  echo $rs_proj->project_owner['act_code'];?>" class="third-link fontW400"><?php  echo $rs_proj->project_owner['full_name'] ?></a></div>
                                <div class="rating"> <!--<?php echo $rs_proj->project_owner_ratings['stars'];?>--></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-xs-12 list-item-options text-right">
                        <?php if($rs_proj->pro_status == Project::PROJECT_STATUS_ACTIVE || $rs_proj->pro_status == Project::PROJECT_STATUS_ADJUDICATED): ?>
                            <a class="btn btn-primary" href="<?php echo UrlHelper::getProjectUrl($rs_proj->pro_id) ?>">Enviar mensaje</a>
                        <?php endif ?>

                        <?php if (Project::canBeQualified($rs_proj, $currentUser)): ?>
                            <a class="btn btn-primary" href="<?php echo UrlHelper::getUrl("proyectoFinalizar?id=" . $rs_proj->pro_id) ?>">Finalizar proyecto</a>
                        <?php endif ?>
                    </div>
                </div>
            <?php endforeach; //End while
        else :
            ?>
            <div class="list-item empty">
                <h3>No se encontró ningún resultado</h3>
            </div>
        <?php endif ?>
        </div> <!-- End list-container -->
    </div>
</div>
<?php endif //End If user_type ?>

<?php
    /* Client */
if ($current_user->user_type == User::USER_TYPE_CLIENT):

    ini_set('display_errors', 1);
    error_reporting(E_ERROR);

    $totals = Project_View::loadTotalsByStatus($current_user->id);

    $filter = isset($_GET['filtro']) ? $_GET['filtro'] : '';

    $status = array();
    switch ($filter) {
        case 'borradores':
            $status[] = Project::PROJECT_STATUS_DRAFT;
            break;
        case 'adjudicados':
            $status[] = Project::PROJECT_STATUS_ADJUDICATED;
            $status[] = Project::PROJECT_STATUS_CLOSED_PHOTOGRAPHER;
            break;
        case 'finalizados':
            $status[] = Project::PROJECT_STATUS_CLOSED_CLIENT;
            $status[] = Project::PROJECT_STATUS_CLOSED_FOTOTEA;
            $status[] = Project::PROJECT_STATUS_CANCELLED;
            break;
        default: //activos
            $status[] = Project::PROJECT_STATUS_ACTIVE;
            break;
    }

    if (empty($filter)) {
        $filter = 'activos';
        $status[] = Project::PROJECT_STATUS_ACTIVE;
    }

    $projects = Project_View::loadUserProjects($current_user->id, $status);

    $total_active = intval($totals[Project::PROJECT_STATUS_ACTIVE]);
    $total_draft = intval($totals[Project::PROJECT_STATUS_DRAFT]);
    $total_adjudicated = intval($totals[Project::PROJECT_STATUS_ADJUDICATED] + $totals[Project::PROJECT_STATUS_CLOSED_PHOTOGRAPHER]);
    $total_finished = intval($totals[Project::PROJECT_STATUS_CLOSED_CLIENT] + $totals[Project::PROJECT_STATUS_CLOSED_FOTOTEA] + $totals[Project::PROJECT_STATUS_CANCELLED]);

    foreach ($projects as $project){
        $project->days_left = DateHelper::getHoursLeft($project->pro_date_end);

        if($project->pro_status == Project::PROJECT_STATUS_DRAFT){
            $project->advice = "Publica este proyecto ahora para recibir ofertas";
        }
        if($project->pro_status == Project::PROJECT_STATUS_ACTIVE){
            if ($project->total_ofertas > 0){
                $project->advice = "No has adjudicado el proyecto, ¡hazlo ya!";
            }
        }
    }
?>

    <div class="containerPerfil">
        <div class="list-container">
            <div class="list-header">
                <!-- Activos -->
                <div class="col-xs-3">
                    <?php if ($filter == "activos"): ?>
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    <?php endif ?>
                    <?php $actUrl = FConfig::getUrl('perfil?act=' . $current_tab . '&filtro=activos') ?>
                    <a class="<?php echo ($filter == "activos")? 'selected':'' ?>" href="<?php echo $actUrl ?>">
                        Activos
                    </a>
                    <span><?php echo $total_active ?></span>
                </div>
                <!-- Borradores -->
                <div class="col-xs-3">
                    <?php if ($filter == "borradores"): ?>
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    <?php endif ?>
                    <?php $draftUrl = FConfig::getUrl('perfil?act=' . $current_tab . '&filtro=borradores') ?>
                    <a class="<?php echo ($filter == "borradores")? 'selected':'' ?>" href="<?php echo $draftUrl ?>">
                        Borradores
                    </a>
                    <span><?php echo $total_draft ?></span>
                </div>
                <!-- Adjudicados -->
                <div class="col-xs-3">
                    <?php if ($filter == "adjudicados"): ?>
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    <?php endif ?>
                    <?php $adjudUrl = FConfig::getUrl('perfil?act=' . $current_tab . '&filtro=adjudicados') ?>
                    <a class="<?php echo ($filter == "adjudicados")? 'selected':'' ?>" href="<?php echo $adjudUrl ?>">
                        Adjudicados
                    </a>
                    <span><?php echo $total_adjudicated ?></span>
                </div>

                <div class="col-xs-3 last">
                    <?php if ($filter == "finalizados"): ?>
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    <?php endif ?>
                    <?php $endedUrl = FConfig::getUrl('perfil?act=' . $current_tab . '&filtro=finalizados') ?>
                    <a class="<?php echo ($filter == "finalizados")? 'selected':'' ?>" href="<?php echo $endedUrl ?>">
                        Finalizados
                    </a>
                    <span><?php echo $total_finished ?></span>
                </div>
            </div>

            <div class="list-content">
                <?php if(count($projects) > 0): ?>
                    <?php foreach ($projects as $rs_proj): ?>
<!--                        --><?php //var_dump($rs_proj); ?>
                        <div class="list-item">
                            <div class="col-xs-2 project-offers">
                                <a class="offer-link" href="<?php echo UrlHelper::getProjectUrl($rs_proj->pro_id) ?>">
                                    <p class="offer-number">
                                        <?php echo $rs_proj->total_ofertas ?>
                                    </p>
                                    <p class="offer-text">
                                        Ofertas
                                    </p>
                                </a>
                                <div class="time-left">
                                    <?php if($rs_proj->pro_status == Project::PROJECT_STATUS_ACTIVE): ?>
                                        <?php echo $rs_proj->days_left ?> para adjudicar
                                    <?php else : ?>
                                        <?php echo Project::getStatusName($rs_proj->pro_status); ?>
                                    <?php endif ?>
                                </div>
                            </div>
                            <div class="col-xs-7">
                                    <?php if ($rs_proj->pro_type == 1): ?>                   
                                          <span class="glyphicon glyphicon-camera icon-proyect"></span> &nbsp;&nbsp;
                                 <?php endif ?>
                                <?php if ($rs_proj->pro_type == 2): ?>                   
                                      <span class="glyphicon glyphicon-edit icon-proyect"></span> &nbsp;&nbsp;
                                 <?php endif ?>
                                <?php if ($rs_proj->pro_type == 3): ?>                   
                                      <span class="glyphicon glyphicon-facetime-video icon-proyect"></span> &nbsp;&nbsp;
                                 <?php endif ?>
                                <span class="txtAzul font18 titProyecto">
                                    <a class="project-link" href="<?php echo UrlHelper::getProjectUrl($rs_proj->pro_id) ?>"><?php echo $rs_proj->pro_tit ?></a>
                                </span>
                                <br>
                                <span class=" font12">
                                        <?php echo $rs_proj->pro_city ?>, <?php echo utf8_encode($rs_proj->pro_country_name) ?>
                                        <br/>
    <!--                                --><?php //if($rs_proj->pro_status = Project::PROJECT_STATUS_ACTIVE): ?>
                                        <?php echo DateHelper::getLongDate($rs_proj->pro_date) ?>
    <!--                                --><?php //endif ?>
                                </span>
                                <p>
                                    <?php echo substr($rs_proj->pro_descripcion, 0, 500);
                                    if (strlen($rs_proj->pro_descripcion) > 500): ?>
                                        ... <a class="see-more" href="<?php echo UrlHelper::getProjectUrl($rs_proj->pro_id) ?>">Ver más >></a>
                                    <?php endif ?>
                                </p>
                            </div><!-- End desc -->
                            <div class="options col-xs-3">
                                <?php if ($rs_proj->oferta_adjudicada_id): ?>
                                    <div class="proBoxUserContFot">
                                        <div class="left">
                                            <div>
                                                <?php
                                                $user_crea = getUserInfo($rs_proj->oferta_user_id);
    //
    //                                            if(is_null($user_crea['user_img'])){
    //                                                $img_profile = "images/img_profile_default.jpg";
    //                                            }else{
    //                                                $img_profile = "thumb.php?w=60&h=60&url=profiles/".sha1($user_crea['id'])."/".$user_crea['user_img'];
    //                                            }
                                                $reviewO = ratings($user_crea['id']);
                                                ?>
                                                <img alt="Imagen de usuario" src="<?php echo FConfig::getThumbUrl($user_crea['profile_image_url'], 50, 50) ?>" width="50" height="50" class="img-circle"/>
                                            </div>
                                        </div><!-- End left -->
                                        <div class="left proBoxUser">
                                            <div class="font12 fontW400">Adjudicado a:</div>
                                            <div>
                                                <a href="perfil?us=<?php  echo $user_crea['act_code'];?>" class="project-link fontW400"><?php echo $user_crea['full_name'] ?></a>
                                            </div>
                                            <div class="rating">
                                               <?php  echo $reviewO['stars'];?>
                                            </div>
                                        </div><!-- End proBoxUser -->
                                    </div><!-- End proBoxUserContFot -->
                                <?php  else: ?>
                                    <?php echo $rs_proj->advice; ?>
                                <?php endif ?>

<!--                                <div class="alert alert-info text-center">--><?php //echo Project::getStatusName($rs_proj->pro_status) ?><!--</div>-->
                            </div><!-- End leftOptions -->

                            <div class="col-xs-12 list-item-options text-right">
                                <?php if (Project::canBeCancelled($rs_proj)): ?>
                                    <a class="btn btn-cancel" href="javascript:cancelarProyecto(<?php echo $rs_proj->pro_id ?>);">Cancelar proyecto</a>
                                <?php endif ?>
                                <?php if($rs_proj->pro_status == Project::PROJECT_STATUS_ACTIVE): ?>
                                    <a class="btn btn-primary" href="<?php echo UrlHelper::getProjectUrl($rs_proj->pro_id) ?>">Ver ofertas</a>
                                <?php endif ?>
                                <?php if($rs_proj->pro_status == Project::PROJECT_STATUS_DRAFT): ?>
                                    <a class="btn btn-primary" href="agregarProyecto?id=<?php echo $rs_proj->pro_id;?>">Editar proyecto</a>
                                <?php endif ?>

                                <?php if (Project::canBeQualified($rs_proj, $currentUser)): ?>
                                    <a class="btn btn-primary" href="<?php echo UrlHelper::getUrl("proyectoFinalizar?id=" . $rs_proj->pro_id) ?>">Calificar proyecto</a>
                                <?php endif ?>
                            </div>
                        </div>
                    <?php endforeach ?>
                <?php else: ?>
                    <div class="list-item empty">
                        <h3>No se encontraron proyectos</h3>
                        <?php if ($filter == 'activos'): ?>
                        <p>Publica un proyecto ahora en fototea y contrata a los mejores fotógrafos</p>
                        <p>
                            <a class="btn btn-primary" href="<?php echo FConfig::getUrl('agregarProyecto') ?>">Publicar un proyecto</a>
                        </p>
                        <?php endif ?>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
    <!-- TODO feo feo -->
    <script type="text/javascript">
        function cancelarProyecto(id){

            var r=confirm("¿Estás seguro que desea cancelar este proyecto?");
            if(r == true){
                window.location="actions/proyectosAction.php?act=cancelar&id="+id;
            }
        }
    </script>
<?php endif ?>
