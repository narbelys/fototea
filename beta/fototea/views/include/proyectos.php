<?php

use Fototea\Models\User;
use Fototea\Models\Project_View;
use Fototea\Util\DateHelper;
use Fototea\Models\Project;
use Fototea\Models\Offer;
use Fototea\Util\UrlHelper;

?>

<?php

if ($current_user->user_type != User::USER_TYPE_PHOTOGRAPHER) {
    die('invalid tab');
}

$projects = Project_View::loadProjectsByStatus(array(Project::PROJECT_STATUS_ACTIVE));
$offers = Offer::getUserOffers($current_user->id, array());

$result = array();
foreach ($offers as $offer){
    if (isset($offer->pro_id)){
        $result[$offer->pro_id] = $offer;
    }
}

$offers = $result;
//var_dump($offers);

?>

<div class="containerPerfil projects-tab-photograph">
    <div class="list-container">
        <div class="list-header">
            <div class="col-xs-2">Proyectos Nuevos</div>
            <div class="col-xs-6">Descripción del proyecto</div>
            <div class="col-xs-2">Fecha del evento</div>
            <div class="col-xs-1 left-time-col">Falta</div>
        </div>
        <div class="list-content">
        <?php foreach ($projects as $rs_proN): ?>
            <div class="list-item">
                <div class="col-xs-2">
                    <?php if ($rs_proN->pro_type == 1): ?>                   
                          <span class="glyphicon glyphicon-camera icon-proyect"></span> &nbsp;&nbsp;
                     <?php endif ?>
                    <?php if ($rs_proN->pro_type == 2): ?>                   
                          <span class="glyphicon glyphicon-edit icon-proyect"></span> &nbsp;&nbsp;
                     <?php endif ?>
                    <?php if ($rs_proN->pro_type == 3): ?>                   
                          <span class="glyphicon glyphicon-facetime-video icon-proyect"></span> &nbsp;&nbsp;
                     <?php endif ?>

                    <a class="project-link" href="<?php echo UrlHelper::getProjectUrl($rs_proN->pro_id) ?>">
                        <?php echo $rs_proN->pro_tit ?>
                         
                    </a>
                </div>
                <div class="col-xs-6">
                    <p>
                    <?php echo substr($rs_proN->pro_descripcion, 0, 500);
                    if (strlen($rs_proN->pro_descripcion) > 500): ?>
                        ... <a class="see-more" href="<?php echo UrlHelper::getProjectUrl($rs_proN->pro_id) ?>">Ver más >></a>
                    <?php endif ?>
                    </p>
                </div>
                <div class="col-xs-2 text-center">
                    <?php echo DateHelper::getShortDate($rs_proN->pro_date) ?>
                    <br/>
                    <?php echo $rs_proN->pro_city ?>, <?php echo utf8_encode($rs_proN->pro_country_name) ?>
                </div>
                <div class="col-xs-1 text-center">
                    <?php echo DateHelper::getHoursLeft($rs_proN->pro_date_end) ?>
                </div>
                <div class="col-xs-1">

                    <?php if(!isset($offers[$rs_proN->pro_id])): ?>
                        <a class="btn btn-primary" href="<?php echo UrlHelper::getProjectUrl($rs_proN->pro_id) ?>">Oferta ya</a>
                    <?php else: ?>
                        <!-- TODO kill font18, fontW400, txtNaranja -->
                        <div class="alignCenter">Tu oferta <br><span class="font18 fontW400 txtNaranja">$ <?php echo $offers[$rs_proN->pro_id]->bid ?></span></div>
                    <?php endif ?>
                </div>
            </div>
        <?php endforeach ?>
        <?php if (count($projects) == 0): ?>
            <div class="list-item empty">
                <h3>No se encontró ningún resultado</h3>
            </div>
        <?php endif ?>
        </div>

    </div>
</div>