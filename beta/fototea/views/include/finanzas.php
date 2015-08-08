<?php

use Fototea\Models\User;
use Fototea\Models\Project;
use Fototea\Models\Project_View;

$session = validaSession();
$userType = securityValidation($_COOKIE['id']);

if($userType != User::USER_TYPE_PHOTOGRAPHER && $session != true){
    ?>
    <script>
        window.location="home";
    </script>
<?php }?>

<?php
$currentUser = getCurrentUser();
$projectsReceivable = Project_View::loadProjectsReceivableByUser($currentUser->id);
$total = 0;
?>

<h2>Proyectos por Cobrar</h2>
<div class="list-container">
    <div class="list-header">
        <div class="col-xs-2">Fecha</div>
        <div class="col-xs-6">Descripci&oacute;n del proyecto</div>
        <div class="col-xs-2">Publicado por</div>
        <div class="col-xs-2 text-center">Monto</div>
    </div>
</div>
<div class="list-content">
    <?php if(count($projectsReceivable) == 0): ?>
        <div class="list-item empty">
            <h3>No tienes proyectos por cobrar</h3>
        </div>
    <?php else: ?>
        <?php foreach($projectsReceivable as $project): ?>
            <div class="list-item">
                <div class="col-xs-2"><?php echo substr($project->pro_cdate, 0, 10) ?></div>
                <div class="col-xs-6">
                        <?php if ($project->pro_type == 1): ?>                   
                                  <span class="glyphicon glyphicon-camera icon-proyect"></span> &nbsp;&nbsp;
                         <?php endif ?>
                        <?php if ($project->pro_type == 2): ?>                   
                              <span class="glyphicon glyphicon-edit icon-proyect"></span> &nbsp;&nbsp;
                         <?php endif ?>
                        <?php if ($project->pro_type == 3): ?>                   
                              <span class="glyphicon glyphicon-facetime-video icon-proyect"></span> &nbsp;&nbsp;
                         <?php endif ?>
                                 
                    <a href="proyecto?id=<?php echo $project->pro_id ?>"><?php echo $project->pro_tit;?></a>
                </div>
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
