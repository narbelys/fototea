<div class="perfil">
    <div class="contPerfil">
        <div class="punt_glob_cf bkGreen">
            <div class="left punt_glob_tit">Puntuación Global</div>
            <div class="left rating"><?php for($i=1;$i<=$review['global'];$i++){ echo '<img src="images/starc.png"/>';}?></div>
            <div class="left bkNaranja glob_punt"><?php echo number_format($review['global'],1,'.',',');?></div>
            <div class="punt_glob_cont">
                <?php if($review['comentarios'] != 0){?>
                    Basado en <?php echo $review['comentarios'];?> comentarios de los usuarios que fueron contratados por <strong><?php echo ucwords($user_info['name'])." ".ucwords($user_info['lastname']); ?></strong> para proyectos
                <?php }else{?>
                    El usuario <strong><?php echo ucwords($user_info['name'])." ".ucwords($user_info['lastname']); ?></strong> no ha recibido comentarios hasta el momento
                <?php  } ?>
            </div>
        </div>
        <div class="comentarios_perfil">
            <div class="proOfertasHeader">Comentarios</div>

            <?php  $com = listAll("reviews","WHERE r_user_id = '$user_info[id]' AND r_type = 'CO' ORDER BY r_cdate ASC");
            while($rs_com = mysql_fetch_object($com)){
                $user_com = getUserInfo($rs_com->r_user_eval);

                ?>
                <div class="comentario_list">
                    <div class="left comentarioImgUser">
                        <?php

                        if(is_null($user_com['user_img'])){
                            $img_profile = "images/img_profile_default.jpg";
                        }else{
                            $img_profile = "thumb.php?w=60&h=60&url=profiles/".sha1($user_com['id'])."/".$user_com['user_img'];
                        }
                        $reviewO = ratings($user_com['id']);

                        ?>
                        <a href="perfil?us=<?php  echo $user_com['act_code'];?>"> <img alt="<?php  echo ucwords($user_com['name']." ".$user_com['lastname']); ?>" src="<?php echo $img_profile;?>" width="60" height="60" border="0"></a>
                    </div>
                    <div class="left comentarioUserDet"><p><a href="perfil?us=<?php  echo $user_com['act_code'];?>" class="fontW400"><?php  echo ucwords($user_com['name']." ".$user_com['lastname']); ?></a>
                            <br><?php echo $reviewO['stars'];?>
                            <br><span class="font12"><?php echo $user_com['ciudad'];?>, <?php echo $user_com['pais'];?> </span>
                            <br><span class="font12">hace <?php echo timePast($rs_com->r_cdate);?></span></p></div>
                    <div class="left comentarioTxt"><?php echo $rs_com->r_value; ?></div>
                    <div class="left comentario_punt"><div class="left bkNaranja glob_punt"><?php echo number_format($reviewO['global'],1,'.',',');?></div></div>


                </div>
            <?php } ?>
        </div>

    </div>
</div>