<?php

//Comentarios
use Fototea\Config\FConfig;
use Fototea\Models\User;

$comments = array();
$com = listAll("reviews","WHERE r_user_id = '$user_info[id]' AND r_type = 'CO' ORDER BY r_cdate ASC");

while($rs_com = mysql_fetch_object($com)) {
    $rs_com->user = getUserInfo($rs_com->r_user_eval);
    $rs_com->rate = ratingByPro($rs_com->r_pro_id, $rs_com->r_user_eval);
    $rs_com->reviewO = ratings($rs_com->user['id']);
    $comments[] = $rs_com;
}

?>
    <div class="review-summary">
        <?php if($review['comentarios'] != 0): ?>
            <div class="col-xs-12">
                <h2>Puntuación Global</h2>
            </div>
            <div class="col-xs-7">
                <p>Basada en <?php echo $review['comentarios'] ?> comentario(s) de usuarios de la comunidad Fototea</p>
            </div>
            <div class="col-xs-5">
                <div class="review-details-box">
                    <?php if($user_info['user_type'] == User::USER_TYPE_PHOTOGRAPHER): ?>
                        <div class="rating_det_fot_tit">Detalle de puntuaci&oacute;n</div>
                        <div class="pull-left rating_det_fot_item">Trato:</div> <div class="rating_det_fot_rate"><?php echo $review['trato_star'];?> (<?php echo number_format($review['trato'],1,'.',',');?>)</div>
                        <div class="pull-left rating_det_fot_item">Calidad:</div> <div class="rating_det_fot_rate"> <?php echo $review['cal_star'];?> (<?php echo number_format($review['calidad'],1,'.',',');?>)</div>
                        <div class="pull-left rating_det_fot_item">Puntuadidad:</div> <div class="rating_det_fot_rate"> <?php echo $review['punt_star'];?> (<?php echo number_format($review['punt'],1,'.',',');?>)</div>
                        <div class="pull-left rating_det_fot_item">Responsabilidad:</div> <div class="rating_det_fot_rate"> <?php echo $review['resp_star'];?> (<?php echo number_format($review['resp'],1,'.',',');?>)</div>
                        <div class="pull-left rating_det_fot_item">Profesionalismo:</div> <div class="rating_det_fot_rate"> <?php echo $review['prof_star'];?> (<?php echo number_format($review['prof'],1,'.',',');?>)</div>
                    <?php endif ?>

<!--                <div class="review-details-box">-->
<!--                    <div class="rating_det_fot_tit">Review mas favorable</div>-->
<!--                    <p>-->
<!--                        <a href="perfil?us=--><?php // echo $comments[0]->user['act_code'];?><!--" class=" fontW400">--><?php //echo $comments[0]->user['full_name'] ?><!--</a>-->
<!--                        <br><span class="font12">hace --><?php //echo timePast($comments[0]->r_cdate);?><!--</span>-->
<!--                    </p>-->
<!--                    <p>-->
<!--                        Comentario: --><?php //echo $comments[0]->r_value ?>
<!--                    </p>-->
<!--                    Puntuacion: --><?php //echo number_format($comments[0]->rate['global'],1,'.',',');?>
<!--                </div>-->

<!--                <div class="alert alert-info">-->
<!--                    Basado en --><?php //echo $review['comentarios'];?><!-- comentarios de los usuarios que fueron contratados por <strong>--><?php //echo $user_info['full_name'] ?><!--</strong> para proyectos-->
<!--                </div>-->
                </div>
                <div class="alert alert-brand alert-global-review"><?php echo number_format($review['global'],1,'.',',');?></div>
            </div>
        <?php  endif ?>
    </div>
    <div class="col-xs-12">
        <div class="sub-title first">
            <i class="glyphicon glyphicon-chevron-right"></i>Comentarios
        </div>
    </div>
    <div class="col-xs-12 list-container">
        <div class="list-content">
        <?php foreach ($comments as $rs_com): ?>
            <div class="list-item">
                <div class="col-xs-1">
                    <a href="perfil?us=<?php  echo $rs_com->user['act_code'];?>"> <img alt="<?php echo $rs_com->user['full_name'] ?>" src="<?php echo FConfig::getThumbUrl($rs_com->user['profile_image_url'], 60, 60) ?>" width="60" height="60" border="0" class="img-circle"></a>
                </div>
                <div class="col-xs-2">
                    <p><a href="perfil?us=<?php  echo $rs_com->user['act_code'];?>" class=" fontW400"><?php echo $rs_com->user['full_name'] ?></a>
                        <br><?php echo $rs_com->reviewO['stars'];?>
<!--                        <br><span class="font12">--><?php //echo $rs_com->user['ciudad'];?><!--, --><?php //echo $rs_com->user['pais'];?><!-- </span>-->
                        <br><span class="font12">hace <?php echo timePast($rs_com->r_cdate);?></span></p></div>
                <div class="col-xs-8">
                    <p>
                        <?php echo $rs_com->r_value ?>
                    </p>
                </div>
                <div class="col-xs-1">
                    <div class="alert alert-brand text-center"><?php echo number_format($rs_com->rate['global'],1,'.',',');?></div>
                </div>
            </div>
        <?php endforeach ?>
            <?php if($review['comentarios'] == 0): ?>
            <div class="list-item empty">
                El usuario <strong><?php echo $user_info['full_name'] ?></strong> no ha recibido comentarios hasta el momento.
            </div>

            <?php  endif ?>
        </div>
    </div>
<!-- END REVIEWS TAB -->