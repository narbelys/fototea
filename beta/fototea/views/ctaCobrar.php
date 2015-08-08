<?php

use Fototea\Models\User;
use Fototea\Models\Project;
use Fototea\Models\Project_View;

$session = validaSession();
$userType = securityValidation($_COOKIE['id']);

if($session != true){
    $app->redirect($app->getConfig()->getUrl('home'));
    return;
} else if ($userType != User::USER_TYPE_PHOTOGRAPHER){
    $app->redirect($app->getConfig()->getUrl('perfil'));
    return;
}

$currentUser = getCurrentUser();
$projectsReceivable = Project_View::loadProjectsReceivableByUser($currentUser->id);
$total = 0;
?>

<div class="content-container">
    <div class="content" id="cuentaContainer">
        <h2>Proyectos por Cobrar</h2>
        <div class="list-container">
            <div class="list-header">
                <h3 class="col-xs-2">Fecha</h3>
                <h3 class="col-xs-6">Descripci&oacute;n del proyecto</h3>
                <h3 class="col-xs-2">Publicado por</h3>
                <h3 class="col-xs-2 text-center">Monto</h3>
            </div>
        </div>

        <div class="list-content">
            <?php if(count($projectsReceivable) == 0): ?>
                <div class="mensajeItem">No tiene proyectos pendientes por cobrar</div>
            <?php else: ?>
                <?php foreach($projectsReceivable as $project): ?>
                    <div class="list-item">
                        <div class="col-xs-2"><?php echo substr($project->pro_cdate, 0, 10) ?></div>
                        <div class="col-xs-6"><a href="proyecto?id=<?php echo $project->pro_id ?>"><?php echo $project->pro_tit;?></a></div>
                        <div class="col-xs-2"><a href="perfil?us=<?php  echo $project->user_id;?>"><?php echo $project->name .' '. $project->lastname;?></a></div>
                        <div class="col-xs-2 text-right"><?php echo number_format($project->oferta_bid,2,",",".");?></div>
                        <?php $total += $project->oferta_bid ?>
                    </div>
                <?php endforeach ?>

                <div class="list-item">
                    <div class="col-xs-8"></div>
                    <div class="col-xs-2 bold">Total</div>
                    <div class="col-xs-2 text-right">$ <?php echo number_format($total,2,",",".");?></div>
                </div>
            <?php endif ?>
        </div>
    </div>
</div>