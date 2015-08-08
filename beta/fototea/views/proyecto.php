<?php

use Fototea\Models\User;
use Fototea\Models\Project;
use Fototea\Models\Project_View;
use Fototea\Models\Offer;
use Fototea\Util\DateHelper;
use Fototea\Config\FConfig;
use Fototea\Util\UrlHelper;

$current_user = getCurrentUser();

if($current_user == false){
    $app->redirect(UrlHelper::getLoginUrl());
    return;
}
?>

<div class="content-container">
    <div class="content">
	 <?php
	 $id_pro = intval($_GET['id']);
//     $pro = listAll("proyectos","WHERE pro_id = '$id_pro'");
	 $rs_pro = Project_View::loadProjectById($id_pro);

     $projectDeadline = $app->getHelper('DateHelper')->getShortDate($rs_pro->pro_deadline, 'd-m-Y');

	 $diasRestN = diffDate(date("Y-m-d H:i:s"),$rs_pro->pro_date_end);
	 $user_crea = getUserInfo($rs_pro->user_id);
     $reviewCliente = ratings($rs_pro->user_id);
     $cat = getCategory($rs_pro->pro_category);
//     $same_user = false;
//
//     if ($rs_pro->user_id == $current_user->id):
//         $same_user = true;
//     endif;

	 //valida que el usuario que visita no haya hecho una oferta antes al proyecto
	 $oferta_user = listAll("ofertas","WHERE pro_id = '$id_pro' AND user_id = '$current_user->id'");
	 $rows_oferta = mysql_num_rows($oferta_user);

     if($rows_oferta > 0){
         $ofertas= "S";
	 }else{
         $ofertas = "N";
	 }
	 
	//busca la oferta bas baja
	$oferta_baja = listAll("ofertas","WHERE pro_id = '$id_pro' ORDER BY bid ASC LIMIT 0,1");
	$rows_ob = mysql_fetch_object($oferta_baja);

     $winnerOffer = null;
     $winnerOfferOwner = null;

     if ($rs_pro->oferta_adjudicada_id) {
         $winnerOffer = Offer::getOffer($rs_pro->oferta_adjudicada_id);
         $winnerOfferOwner = getUserInfo($rs_pro->oferta_user_id);
     }

     $currentUserOffer = listAll("ofertas","WHERE pro_id = '$id_pro' AND user_id = '$current_user->id'");
     $currentUserOffer = mysql_fetch_object($currentUserOffer);
     ?>

     <script src="<?php echo FConfig::getUrl('js/popModal.js') ?>"></script>

	 <div class="project-info clearfix">

         <h2 class="main-title">
                <?php if ($rs_pro->pro_type == 1): ?>                   
                  <span class="glyphicon glyphicon-camera icon-proyect icon-size"></span> &nbsp;
             <?php endif ?>
            <?php if ($rs_pro->pro_type == 2): ?>                   
                  <span class="glyphicon glyphicon-edit icon-proyect icon-size"></span> &nbsp;
             <?php endif ?>
            <?php if ($rs_pro->pro_type == 3): ?>                   
                  <span class="glyphicon glyphicon-facetime-video icon-proyect icon-size"></span> &nbsp;
             <?php endif ?>
                                 
             <?php echo $rs_pro->pro_tit;?>
         </h2>

         <div class="project-info-heading">
             <div class="col-xs-3">
                 <!-- Informacion del proyecto -->
                    <h4>Creado por:</h4>
                    <div>
                        <a href="perfil?us=<?php echo $user_crea['act_code'];?>" class="txtAzul fontW400">
                            <img alt="Imagen de usuario" class="img-circle" src="<?php echo FConfig::getThumbUrl($user_crea['profile_image_url'], 60, 60) ?>" />
                            <?php echo $user_crea['full_name'] ?>
                        </a>

                    </div>
                    <div>
                        <?php echo $reviewCliente['stars'] ?>
                        <a href="perfil?us=<?php  echo $user_crea['act_code'];?>&act=reviews" class="txtAzul font12 fontW400">
                            Comentarios <?php echo $reviewCliente['comentarios']?>
                        </a>
                    </div>
             </div>

             <div class="col-xs-7">
                 <!-- TODO check this double col-xs-7 -->
                 <div class="col-xs-7">
                     <h4>Tipo de proyecto:</h4>
                     <p class="project-category">
                         <?php echo $cat['category'].": ". $cat['subcategory'];?>
                     </p>

                     <h4>Cantidad de fotos/videos:</h4>
                     <p class="project-category">
                         <?php echo $rs_pro->pro_cant ?>
                     </p>

                     <h4>Fecha de producción:</h4>
                     <p>
                         <?php echo DateHelper::getShortDate($rs_pro->pro_date) ?>
                     </p>

                     <h4>Lugar del evento:</h4>
                     <p>
                         <?php echo $rs_pro->pro_state ?>, <?php echo $rs_pro->pro_city ?>
                     </p>

                     <?php if (!empty($rs_pro->pro_environment)): ?>
                         <h4>Ambiente del evento:</h4>
                         <p>
                             <?php echo Project::getEnvironmentsName($rs_pro->pro_environment) ?>
                         </p>
                     <?php endif ?>

                     <?php if (!empty($rs_pro->pro_moment)): ?>
                         <h4>Momento del evento:</h4>
                         <p>
                             <?php echo Project::getMomentsName($rs_pro->pro_moment) ?>
                         </p>
                     <?php endif ?>

                     <?php if (!empty($rs_pro->pro_deadline)): ?>
                         <h4>Deadline de la entrega:</h4>
                         <p>
                             <?php echo $projectDeadline ?>
                         </p>
                     <?php endif ?>
                 </div>
             </div>

             <div class="col-xs-2 ofertas-summary">
                 <div class="alert alert-success alert-ofertas">
                     Ofertas: <?php echo $rs_pro->total_ofertas ?>
                 </div>
                 <?php  if ($current_user->user_type == User::USER_TYPE_PHOTOGRAPHER && $ofertas == "N" && $rs_pro->pro_status == Project::PROJECT_STATUS_ACTIVE): ?>
                    <a class="btn btn-primary offer-form-trigger" href="#formOferta" id="oferta_ppal">Ofertar</a>
                 <?php  else: ?>
                     <div class="alert alert-project-status">
                         Proyecto <?php echo Project::getStatusName($rs_pro->pro_status) ?>
                     </div>
                 <?php endif ?>

                 <?php if($rs_pro->pro_status == Project::PROJECT_STATUS_ACTIVE ): ?>
                     <div class="text-center time-left">
                         Quedan <?php echo $diasRestN[2]."d ".$diasRestN[3]."h";?>
                     </div>
                 <?php endif ?>

                 <?php  if($rs_pro->user_id == $current_user->id && $rs_pro->pro_status == Project::PROJECT_STATUS_DRAFT):?>
                     <a class="btn btn-alternative" href="agregarProyecto?id=<?php echo $rs_pro->pro_id ?>">Editar este proyecto</a>
                 <?php endif ?>
             </div>

             <div class="col-xs-12">
                 <h4>Descripci&oacute;n del proyecto:</h4>
                 <p class="alignJustify">
                     <?php echo $rs_pro->pro_descripcion ?>
                 </p>
             </div>

             <?php if ($currentUser->id == $rs_pro->user_id): // si el usuario actual es dueño del proyecto ?>
                 <?php if ($rs_pro->oferta_adjudicada_id): // si el proyecto ha sido adjudicado ?>
                     <div class="col-xs-6">
                         <h3>Adjudicaste este proyecto a:</h3>
                         <hr/>
                         <h4>Creativo:</h4>
                         <p>
                             <a href="<?php echo UrlHelper::getProfileUrl($winnerOfferOwner['act_code']) ?>"><?php echo $winnerOfferOwner['full_name'] ?></a>
                         </p>

                         <?php if ($winnerOfferOwner['email']): ?>
                             <h4>Correo electr&oacute;nico:</h4>
                             <p>
                                 <?php echo $winnerOfferOwner['email'] ?>
                             </p>
                         <?php endif ?>

                         <?php if ($winnerOfferOwner['telefono']): ?>
                         <h4>Tel&eacute;fono:</h4>
                         <p>
                             <?php echo $winnerOfferOwner['telefono'] ?>
                         </p>
                         <?php endif ?>

                         <?php if ($winnerOfferOwner['movil']): ?>
                         <h4>Tel&eacute;fono m&oacute;vil:</h4>
                         <p>
                             <?php echo $winnerOfferOwner['movil'] ?>
                         </p>
                         <?php endif ?>
                     </div>
                     <div class="col-xs-6">
                         <h3>Detalles de la oferta:</h3>
                         <hr/>
                         <h4>Monto:</h4>
                         <p>
                             $ <?php echo $winnerOffer->bid; ?>
                         </p>
                         <h4>Descripci&oacute;n de la propuesta:</h4>
                         <p>
                             <?php echo $winnerOffer->mensaje; ?>
                         </p>
                     </div>
                 <?php endif ?>
             <?php endif ?>

             <?php if ($currentUser->id == $rs_pro->oferta_user_id): //si el usuario actual ganó el proyecto  ?>
                 <div class="col-xs-12">
                     <h3>Datos del cliente:</h3>
                     <hr/>

                     <?php if ($user_crea['email']): ?>
                         <h4>Correo electr&oacute;nico:</h4>
                         <p>
                             <?php echo $user_crea['email'] ?>
                         </p>
                     <?php endif ?>

                     <?php if ($user_crea['telefono']): ?>
                         <h4>Tel&eacute;fono:</h4>
                         <p>
                             <?php echo $user_crea['telefono'] ?>
                         </p>
                     <?php endif ?>

                     <?php if ($user_crea['movil']): ?>
                         <h4>Tel&eacute;fono m&oacute;vil:</h4>
                         <p>
                             <?php echo $user_crea['movil'] ?>
                         </p>
                     <?php endif ?>
                     <?php //TODO si piden la direccion del proyecto va aquí ?>
                 </div>
             <?php endif ?>
         </div>
	 </div><!-- End project-info -->
	 
     <div class="project-ofertas-list clearfix">
        <!--Dueno del proyecto ve las ofertas -->
        <?php if($rs_pro->user_id == $current_user->id): //Project Offers?>
            <!-- Ofertas table -->

            <div class="tab-title-brand clearfix">
                <div class="col-xs-8">Ofertas recibidas</div>
                <div class="col-xs-2 text-center"></div>
                <!--<div class="col-xs-2 text-left">Reputaci&oacute;n</div>-->
                <div class="col-xs-2 text-center">Oferta</div>
            </div>

        <?php  $of = listAll("ofertas","WHERE pro_id = '$id_pro'"); ?>
        <?php if (mysql_num_rows($of) > 0): ?>
        <?php while($rs_of = mysql_fetch_object($of)): $user_of = getUserInfo($rs_of->user_id); ?>
        <div class="current-offer-detail clearfix" id="oid_<?php echo $rs_of->id ?>">
            <div class="col-xs-2" style="padding-bottom:30px">
                <?php
                $reviewO = ratings($user_of['id']);
                ?>
            
                <a href="perfil?us=<?php  echo $user_of['act_code'];?>"> <img alt="<?php  echo ucwords($user_of['name']." ".$user_of['lastname']); ?>" class="img-circle" src="<?php echo FConfig::getThumbUrl($user_of['profile_image_url'], 60, 60) ?>" border="0"></a>
                    <br>
                                                          
                <?php echo $reviewO['stars']?><br><a href="perfil?us=<?php  echo $user_of['act_code'];?>&act=reviews" class="txtAzul font12 fontW400">Comentarios <?php echo $reviewO['comentarios']?></a>
             <br> <a class="txtNaranja font12 fontW400" href="perfil?us=<?php  echo $user_of['act_code'];?>&act=portafolio">Ver portafolio</a>
                                         
            </div>
            <div class="col-xs-6">
                
                <div class="left proOfertasPropuesta"><p><a href="perfil?us=<?php  echo $user_of['act_code'];?>" class="txtAzul fontW400"><?php  echo ucwords($user_of['name']." ".$user_of['lastname']); ?></a> <span class="font12">hace <?php echo timePast($rs_of->cdate);?></span></p><p class="font12 alignJustify"><?php echo $rs_of->mensaje; ?></div>
                
            </div>
            <div class="col-xs-2">
                
            </div>
            <div class="col-xs-2">
                <div class="text-center"><b class="offer-amount">$ <?php  echo number_format($rs_of->bid ,'0',',','.');?></b></div>
                <br/>
                <?php if($rs_pro->pro_status == "A"){?><div class="text-center"><a class="btn btn-primary" href="javascript:adjudicarProyecto(<?php echo $rs_of->id;?>, <?php echo $user_of['id']; ?>)">Aceptar oferta</a></div><?php }else if($rs_of->awarded == "S"){ ?><div class="btn_naranja">Adjudicado</div><?php } ?>
                <div id="btnContOfert" class="text-center"><a class="messages-toggler btn btn-alternative" id="btnComment_<?php echo $rs_of->id;?>" data-target-id="<?php echo $rs_of->id;?>" nohref>Mensajes</a></div>
                <div class="wizard-contact-creative"></div>
            </div>
            <div class="col-xs-12">
                <div class="comentariosOferta" id="comments_<?php echo $rs_of->id;?>">
                    <div class="comentariosTit">Mensajes</div>


                    <div class="comenta">
                        <textarea class="comentarioTxt" id="comentarioTxt<?php echo $rs_of->id ?>" name="comentarioTxt" onFocus="javascript:valueDef('comentarioTxt<?php echo $rs_of->id ?>','Escribe tu mensaje aquí')" onBlur="javascript:valueDef('comentarioTxt<?php echo $rs_of->id ?>','Escribe tu mensaje aquí')">Escribe tu mensaje aquí</textarea>
                    </div>
                    <div>
                        <div id="bComentar" class="comment-button"><a id="bComentar_btn" class="btn btn-primary" href="javascript:sendComment(<?php echo $rs_of->id ?>,<?php echo $id_pro;?>)">Enviar</a></div>
                    </div>
                    <div id="comentariosListCont">
                        <div id="listCont">
                            <?php
                            $i = 0;
                            $comentarios = listAll("oferta_comments", "WHERE oferta_id = $rs_of->id ORDER BY cdate DESC");
                            while($rs_comment = mysql_fetch_object($comentarios)){
                                if($i==0){
                                    $listClass = "list1";
                                }else{
                                    $listClass="list2";
                                }

                                $userComment = getUserInfo($rs_comment->user_id);

                                ?>
                                <div class="comentariosList <?php echo $listClass;?>" id="cid_<?php echo $rs_comment->id ?>">
                                    <div class="comentarioUser left font12"><a class="txtAzul font14" href="perfil?us=<?php  echo $userComment['act_code'];?>"><?php echo $userComment['name']." ".$userComment['lastname'];?></a> <br> <a nohref title="<?php echo DateHelper::getLongDate($rs_comment->cdate, true) ?>"><i class="time-since"><?php echo DateHelper::getTimeSince($rs_comment->cdate); ?></i></a></div>
                                    <div class="comentarioC left"><?php echo $rs_comment->comment;?></div>
                                </div>
                                <?php
                                $i++;
                                if($i > 1){
                                    $i = 0;
                                }
                            }?>
                        </div>
                    </div>

                </div>
            </div>
        </div>
         <?php endwhile ?>
         <?php else: ?>
         <div class="col-xs-12">
             <p class="text-center">
                 No has recibido ofertas hasta el momento
             </p>
         </div>
         <?php endif //offer list count > 0 ?>
            <!-- End Ofertas table -->
        <?php  endif // End Project Offers ?>
     </div>

    <?php if ($current_user->user_type == User::USER_TYPE_PHOTOGRAPHER): ?>
     <div class="make-offer-form clearfix" style="display: none">
         <?php  if($ofertas == "N"):?>
            <div id="boxOfertar">
                <div class="tab-title-brand page-title">
                    Enviar oferta
                </div>

                <div class="formError" id="formOferta">* Todos los campos son obligatorios</div>
                <form id="formError" name="formOferta" action="" method="post">

                    <input name="act" id="act" type="hidden" value="oferta" />

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label for="inputEmail3" class="control-label required-after">Descripci&oacute;n de la propuesta</label>
                                <textarea name="txt_propuesta" id="txt_propuesta" class="form-control" rows="3" placeholder="Descripci&oacute;n de la propuesta" title="Descripci&oacute;n de proyecto"></textarea>

                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <label for="inputEmail3" class="control-label required-after">Oferta ($)</label>
                                <input type="text" name="txt_bid" id="txt_bid" class="form-control" placeholder="Oferta ($)" title="Oferta ($)">
                            </div>
                        </div>
                    </div>



                    <div class="form-options">
                        <a href="#" id="btnCancelar" class="btn btn-cancel">Cancelar</a>
                        <a class="btn btn-primary" id="bOfertar" href="#">Ofertar</a>
                    </div>
                </form>
            </div>
         <?php endif ?>
     </div>
    <?php endif ?>

     <?php if ($ofertas == 'S'): ?>
     <div class="project-current-offer clearfix">
         <div class="proOfertas" id="proOfertas">
             <div class="tab-title-brand clearfix">
                 <div class="col-xs-8">Tu oferta enviada a este proyecto</div>
                 <div class="col-xs-2 text-center"></div>
                <!-- <div class="col-xs-2 text-center">Reputaci&oacute;n</div>-->
                 <div class="col-xs-2 text-center">Oferta</div>
             </div>

             <?php
             $rs_of = $currentUserOffer;
             $user_of = getUserInfo($rs_of->user_id);
             ?>

                 <div class="current-offer-detail clearfix" id="oid_<?php echo $rs_of->id ?>">
                     <div class="col-xs-2">
                         <?php
                         $reviewO = ratings($user_of['id']);
                         ?>
                         <a href="perfil?us=<?php  echo $user_of['act_code'];?>"> <img alt="<?php  echo ucwords($user_of['name']." ".$user_of['lastname']); ?>" src="<?php echo FConfig::getThumbUrl($user_of['profile_image_url'], 60, 60) ?>" border="0" class="img-circle"></a>
                            <br>
                            <?php echo $reviewO['stars']?><br><a href="perfil?us=<?php  echo $user_of['act_code'];?>&act=reviews" class="txtAzul font12 fontW400">Comentarios <?php echo $reviewO['comentarios']?></a>
                     </div>
                     <div class="col-xs-6">
                         <p>
                             <a href="perfil?us=<?php  echo $user_of['act_code'];?>" class="txtAzul fontW400">
                                 <?php echo $user_of['full_name'] ?>
                             </a>
                             <span class="font12">hace <?php echo timePast($rs_of->cdate);?></span>
                             <?php  if($rs_pro->pro_status == Project::PROJECT_STATUS_ACTIVE): ?>
<!--                                 -  <a href="ofertaEditar?pid=--><?php //echo $rs_pro->pro_id;?><!--&oid=--><?php //echo $rs_of->id;?><!--" class="font12 txtNaranja">Editar propuesta</a>-->
                             <?php endif ?>
                         </p>
                         <a id="offer_description_btn" class="edit-inline-link"><i class="glyphicon glyphicon-pencil"></i>Editar propuesta</a>
                         <p class="font12 alignJustify">
                            <p href="#" id="offer_description" class="inline-edit-field" data-type="textarea" data-name="offer_description" data-inputclass="offer-description" data-pk="<?php echo $rs_of->id ?>" data-url="<?php echo $app->getHelper('UrlHelper')->getUrl('actions/proyectosAction.php?act=editarOferta') ?>" data-title="Descripción">
                                <?php echo $rs_of->mensaje ?>
                            </p>
                     </div>


                     <div class="col-xs-2">

                     </div>


                     <div class="col-xs-2">
                         <div class="offer-amount-box" id="bid<?php echo $rs_of->id;?>">
<!--                             --><?php // if($rs_of->awarded == "N"){ ?>
<!--                                 <span class="txtAzul font12 editOferta" title="Editar monto de la oferta" onclick="javascript:editOferta(--><?php //echo $rs_of->bid;?><!--,--><?php //echo $rs_of->id;?><!--);">Click para editar el monto</span><br>-->
<!--                             --><?php //} ?>

                            <?php  if($rs_pro->pro_status == Project::PROJECT_STATUS_ACTIVE): ?>
<!--                                 <span class="editOferta" title="Editar monto de la oferta" onclick="javascript:editOferta(--><?php //echo $rs_of->bid;?><!--,--><?php //echo $rs_of->id;?><!--);">-->
<!--                                     <b class="offer-amount">$ --><?php // echo number_format($rs_of->bid ,'0',',','.');?><!--</b> (Editar monto)-->
<!--                                 </span>-->
                                <b>$</b> <b href="#" id="offer_amount" class="offer-amount" data-type="text" data-name="offer_bid" data-inputclass="offer-amount-input" data-pk="<?php echo $rs_of->id ?>" data-url="<?php echo $app->getHelper('UrlHelper')->getUrl('actions/proyectosAction.php?act=editarOferta') ?>" data-title="Monto">
                                    <?php  echo number_format($rs_of->bid ,'0',',','');?>
                                </b>
                                <a id="offer_amount_btn" class="edit-inline-link"><i class="glyphicon glyphicon-pencil"></i>Editar</a>

                            <?php else: ?>
                                <b class="offer-amount">$ <?php  echo number_format($rs_of->bid ,'0',',','');?></b>
                            <?php endif ?>

                         </div>
                         <?php  if($rs_of->awarded == "S"): ?>
                             <div class="alert alert-success text-center">Oferta Ganadora</div>
                         <?php endif ?>
                         <a class="btn btn-alternative btn-wide" id="btnComment_<?php echo $rs_of->id;?>" href="javascript:showComments(<?php echo $rs_of->id;?>)">Mensajes</a>
                     </div>


                     <div class="col-xs-12" id="comments_<?php echo $rs_of->id;?>">
                         <div class="comentariosTit">Mensajes</div>
                         <div class="comenta">
                                <div class="row" style="padding-bottom:20px">
                                    
                                <div class="col-sm-10" >
                                    
                                <textarea id="comentarioTxt<?php echo $rs_of->id ?>" name="comentarioTxt"  class="form-control" rows="3" placeholder="Escribe tu mensaje aquí" title="Escribe tu mensaje aquí"></textarea>  
                                </div>
                                                     
                                <div class="col-sm-2" style="padding-top:20px">
                             <div class="right">
                                 <div id="bComentar"><a id="bComentar_btn" class="btn btn-primary btn-lg" href="javascript:sendComment(<?php echo $rs_of->id ?>,<?php echo $id_pro;?>)">Enviar</a></div>
                             </div>
                                 </div>
                             </div>
                         </div>
                         <div id="comentariosListCont">
                             <div id="listCont">
                                 <?php
                                 $i = 0;
                                 $comentarios = listAll("oferta_comments", "WHERE oferta_id = $rs_of->id ORDER BY cdate DESC");
                                 while($rs_comment = mysql_fetch_object($comentarios)){
                                     if($i==0){
                                         $listClass = "list1";
                                     }else{
                                         $listClass="list2";
                                     }

                                     $userComment = getUserInfo($rs_comment->user_id);

                                     ?>
                                     <div class="comentariosList <?php echo $listClass;?>" id="cid_<?php echo $rs_comment->id ?>">
                                         <div class="comentarioUser left font12"><a class="txtAzul font14" href="perfil?us=<?php  echo $userComment['act_code'];?>"><?php echo $userComment['name']." ".$userComment['lastname'];?></a> <br> <a nohref title="<?php echo DateHelper::getLongDate($rs_comment->cdate, true) ?>"><i class="time-since"><?php echo DateHelper::getTimeSince($rs_comment->cdate); ?></i></a></div>
                                         <div class="comentarioC left"><?php echo $rs_comment->comment;?></div>
                                     </div>
                                     <?php
                                     $i++;
                                     if($i > 1){
                                         $i = 0;
                                     }
                                 }?>
                             </div>
                         </div>
                     </div>

                 </div>
         </div>
     </div>
     <?php endif //Fotografo options ?>
    </div>
</div>

<div class="wizard-contact-creative-content" style="display: none;">
    <b>Contacta al creativo</b>
    <p>Puedes contactar al creativo y enviarle mensajes directos a través de esta opción.</p>
</div>

<script type="text/javascript">
    jQuery.fn.editable.defaults.mode = 'inline';
    jQuery.fn.editableform.buttons = '<button type="submit" class="editable-submit"></button><button type="button" class="editable-cancel"></button>';

    jQuery.fn.scrollView = function (vOffset) {
        return this.each(function () {
            var position = jQuery(this).offset().top - vOffset;
            jQuery('html, body').animate({ scrollTop: position }, 500);
        })
    };

    (function(jQuery){

        var currentOfferId = '<?php echo $currentUserOffer->id ?>';
        var currentOfferMessage = "<?php echo $app->getHelper('StringHelper')->brToLn($currentUserOffer->mensaje) ?>";

        jQuery('.messages-toggler').bind('click', function(){
            //alert('hola');
            var id = jQuery(this).attr('data-target-id');
            jQuery('#comments_' + id).toggle();
        });

        function setPosition() {
            var params, i, param, options;
            params = window.location.hash.replace('#','').split(';');
            options = [];

            for (i = 0; i < params.length; i++) {
                param = params[i].split(":");
                options[param[0]] = param[1];
            }

            //Mensages
//            if (options['cid']) {
//                jQuery('#comments_' + options['cid']).show();
//                jQuery('#comments_' + options['cid']).scrollView(0);
//                return;
//            }

            //Ofertas
            if (options['oid']) {
                jQuery('#comments_' + options['oid']).show();
                jQuery('#oid_' + options['oid']).scrollView(55);
                return;
            }
        }

        setPosition();

        /** Offer functions */

        jQuery(document).ready(function() {

            if (parseInt(currentOfferId) > 0) {
                jQuery('#offer_amount').editable();

                jQuery('#offer_description').editable({
                    showbuttons: 'bottom',
                    onblur: 'ignore',
                    value: currentOfferMessage,
                    display: function(value, response) {
                        //render response into element
                        if (response != undefined) {
                            jQuery(this).html(response.mensaje);
                        }
                    }
                });

//            jQuery('#offer_description').on('shown', function(e, editable) {
//                console.log('editable shown');
//               var newValue = editable.value;
//                console.log(newValue);
//                newValue = newValue.replace('<br/>', '\n');
//
//                console.log(newValue);
//                //console.log(editable.value);
//                editable.value  = '12312312';
//            });

                jQuery("#offer_description_btn").click(function(e) {
                    e.stopPropagation();
                    jQuery("#offer_description").editable("toggle");
                });

                jQuery("#offer_amount_btn").click(function(e) {
                    e.stopPropagation();
                    jQuery("#offer_amount").editable("toggle");
                });
            }
        });

        function saveOferta(txt,id){
            $("#bid_txt").attr("disabled", "disabled");
            $("#bid_txt").attr("readonly");

            $.ajax({
                type: 'get',
                dataType: 'json',
                url: 'actions/proyectosAction.php',
                data: {o_id:id,bid:txt.value,act:"upt_bid"},
                success: function(json){
                    $("#bid"+id).html('<span class="txtAzul font12 editOferta" title="Editar monto de la oferta" onclick="javascript:editOferta('+txt.value+','+id+');">Click para editar el monto</span><br><span class="editOferta" title="Editar monto de la oferta" onclick="javascript:editOferta('+txt.value+','+id+');" >'+'$ '+number_format(txt.value)+'</span>');
                }
            });
        }

    }(jQuery));


    /* End Androb */

    function showComments(ofertaId){

        if ($("#comments_"+ofertaId).css('display') == 'none') {
            $("#comments_"+ofertaId).slideDown();
            $("#btnComment_"+ofertaId).html("- Mensajes");
        }else{
            $("#btnComment_"+ofertaId).html("+ Mensajes");
            $("#comments_"+ofertaId).slideUp();

        }
    }

    $(document).ready(function() {
        <?php  if($current_user->user_type == "1"){?>
        $(".offer-form-trigger").click(function(){
            jQuery('.make-offer-form').slideDown();
        });

        $(".offer-form-cancel").click(function(){
            $(".make-offer-form").slideUp();
        });

        $("#txt_bid").keydown(function(event) {
            if(event.shiftKey)
            {
                event.preventDefault();
            }

            if (event.keyCode == 46 || event.keyCode == 8)    {
            }
            else {
                if (event.keyCode < 95) {
                    if (event.keyCode < 48 || event.keyCode > 57) {
                        event.preventDefault();
                    }
                }
                else {
                    if (event.keyCode < 96 || event.keyCode > 105) {
                        event.preventDefault();
                    }
                }
            }
        });

        $("#bOfertar").click(function(){
            $("#formError").slideUp();
            var error = 0;
            $( "#bOfertar" ).html("Cargando...");
            $( "#bOfertar" ).addClass("disabled");

            if ($("#txt_propuesta").val() == "" || $("#txt_propuesta").val().length < 3){
                error++;
                $( "#bOfertar" ).html("Ofertar");
                $( "#bOfertar" ).removeClass("disabled");
            }

            if ($("#txt_bid").val() < 1){
                error++;
                $( "#bOfertar" ).html("Ofertar");
                $( "#bOfertar" ).removeClass("disabled");
            }

            if(error == 0){
                $( "#oferta_ppal" ).html("Cargando...");
                $( "#oferta_ppal" ).addClass("disabled");
                $.ajax({
                    type: 'get',
                    dataType: 'json',
                    url: 'actions/proyectosAction.php',
                    data: {bid:$("#txt_bid").val(),propuesta:$("#txt_propuesta").val(),act:$("#act").val(),pro:<?php echo $_GET['id'];?>},
                    success: function(json){
                        //funcion para llenar los datos del detalle
                        $( "#oferta_ppal" ).html("Ofertar");
                        $( "#oferta_ppal" ).removeClass("disabled");
                        $("#boxOfertar").html("<div class='tab-title-brand clearfix'><h2>Enviar oferta</h2></div><p>¡Se ha enviado tu oferta con éxito!</p>");
                        setTimeout('document.location.reload()',1000);
                    }
                });

            } else {
                $("#formError").slideDown('slow');
                return false;
            }
        });
        <?php  } ?>
    }); // cierre de document

    function adjudicarProyecto(id){
        var r = confirm("¿Estás seguro que quieres aceptar esta propuesta?");

        if(r == true){
            $.ajax({
                type: 'get',
                dataType: 'json',
                url: 'actions/proyectosAction.php',
                data: {prop:id,act:"adjudicar",pro:<?php echo $_GET['id'] ?>},
                success: function(data){
                    if (data.redirect_url != null) {
                        window.location.href = data.redirect_url;
                    } else {
                        //TODO handle error here
                    }
                },
                error: function(){
                    //TODO handle error here
                    alert('error');
                }
            });
        }
    }

    <?php if ($currentUser->wizard_contact_creative_completed == false && mysql_num_rows($of) == 1): ?>
        var contactCreativeWizard = {
            stepContactCreative: function(){
                var element = jQuery('.wizard-contact-creative');
                this.drawPopModal(element, jQuery('.wizard-contact-creative-content').html(), 'leftCenter', 0);
            },

            addLink: function(elem, msg){
                msg += '<a class="wizard-step-link" onclick="jQuery(\''+ elem.selector +'\').popModal(\'hide\')">Entendido</a>';

                return msg;
            },

            wizardCompleted: function(){
                jQuery.ajax({
                    type: 'get',
                    dataType: 'json',
                    url: "<?php echo FConfig::getUrl('actions/perfilAction.php?act=wizardContactCreativeCompleted&act-code=') ?>",
                    data: {'act-code':'<?php echo $current_user->act_code; ?>', act:"wizardContactCreativeCompleted"},
                    success: function(json){
                        if (json.status == 'success'){
                            console.log('success');
                        } else {
                            console.log('error');
                        }
                    }
                });
            },

            drawPopModal: function(elem, msg, placement, nextStep){
                msg = this.addLink(elem, msg);

                jQuery(elem).popModal({
                    html : msg,
                    placement : placement,
                    showCloseBut : true,
                    onDocumentClickClose : false,
                    onOkBut : function(){},
                    onCancelBut : function(){},
                    onLoad : function(){},
                    onClose : function(){
                        switch (nextStep){
                            case 0:
                                contactCreativeWizard.wizardCompleted();
                                break;
                        }
                    }
                });
                jQuery(elem).trigger('click');
            }
        };

        jQuery(document).ready(function(){
            setTimeout(function() { contactCreativeWizard.stepContactCreative(); },1250);
        });
    <?php endif ?>
</script>