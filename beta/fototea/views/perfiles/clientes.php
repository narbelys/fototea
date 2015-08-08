<?php
use Fototea\Util\DateHelper;

?>

<?php $session = validaSession();
if($session != true){?>
<script>
		window.location="home";
		</script>
		<?php } ?>
 <script>

function cancelarProyecto(id){

	var r=confirm("¿Estás seguro que desea cancelar este proyecto?");
	if(r == true){
	window.location="actions/proyectosAction.php?act=cancelar&id="+id;
	}
}
 </script>
 <div class="containerPerfil">

 <div class="perfil">
     <div class="containerInfoPerfil">

         <div class="left" style="position: absolute; z-index: 999; top: 64px; left: 54%;">
             <a href="javascript:notificaciones();"><img id="icon_not" src="images/icon_not.png"/></a>
             <?php
             $not = listAll("notificaciones"," WHERE user_id = $_COOKIE[id] ORDER BY cdate DESC");
             $notCount = listAll("notificaciones"," WHERE user_id = $_COOKIE[id] AND leido = 'N'");
             $countMens = mysql_num_rows($notCount);

             if($countMens > 0){?>
                 <div id="mensajeNot">
                     <div id="mensajeCont">
                         <span id="mensNum"><?php echo $countMens;?></span>
                     </div>
                     <div id="notList">
                         <img src="images/icon_mark_not.jpg" id="not_mark" />
                         <ul>
                             <?php while($rs_not = mysql_fetch_object($not)){?>

                                 <li <?php  if($rs_not->leido == "N"){ echo 'class="bkAzulC"';}?>><a href="<?php echo $rs_not->url;?>" onclick="javascript:notAct(<?php echo $rs_not->id;?>)"><img src="images/icon_notification.png"/><?php echo $rs_not->notificacion;?></a></li>
                             <?php }?>
                         </ul>

                     </div>
                 </div>
             <?php } ?>

         </div>


         <div class="coverPerfil">
             <?php

             $img_cover = "profiles/".sha1($user_info['id']). "/cover.jpg";
             //			}
             ?>

             <img id="coverMainImage" alt="" src="<?php  echo $img_cover;?>" width="1044" height="291">


         </div>

         <div class="infoPerfilCont">

             <div class="perfilNombre"><?php echo ucwords($user_info['name'])." ".ucwords($user_info['lastname']);?> <?php if($user_info['id'] == $_COOKIE['id']){?><a href="editarPerfil" class="txtNaranja font12">Editar Perfil</a><?php } ?></div>




             <div class="left perfilImg">
                 <div>
                     <?php

                     //	 		if(is_null($user_info['user_img'])){
                     //				$img_profile = "images/img_profile_default.jpg";
                     //			}else{
                     $img_profile = "profiles/".sha1($user_info['id'])."/profile.jpg"; //.$user_info['user_img'];
                     //			}
                     $review = ratings($user_info['id']);
                     ?>
                     <img id="profileMainImage" alt="Imagen de perfil" src="<?php echo 'thumb.php?w=130&h=130&url='.$img_profile;?>" width="106" height="106">
                 </div>
                 <div class="rating"> <!--<?php  echo $review['stars'];?>--></div>
             </div>


             <div class="left perfilDesc">
                 <p class="bold"><?php echo ucfirst($user_info['ciudad']); ?></p>

                 <p><?php echo substr(ucfirst($user_info['descripcion']),0,130); ?></p>
             </div>

             <?php if (getCurrentUser() != false): ?>
                 <div>
                     <button class="edit-my-picture profile btn_naranja" onclick="androbCrop.run('profile', '<?php echo 'thumb.php?w=400&h=400&url='.$img_profile;?>');">Editar imagen perfil</button>
                     <button class="edit-my-picture cover btn_naranja"  onclick="androbCrop.run('cover', '<?php echo 'thumb.php?w=400&h=400&url='.$img_cover;?>');">Editar cover</button>
                 </div>
             <?php endif ?>

             <div class="tab-box">
                 <div class="pestanaPerfil pestanaPerfilSelected left">Evaluaci&oacute;n</div>
             </div>

         </div>


         <?php /*if($_COOKIE['id']!= $user_info['id'] && $session == true){
	 	<div class="btnContactame">
	 		<div class="btn_naranja"><a href="javascript:messages(<?php echo $user_info['id'];?>,0)">Contactame</a></div>
	 	</div>
	 	 }*/ ?>
     </div>

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
                     <div class="left comentarioUserDet"><p><a href="perfil?us=<?php  echo $user_com['act_code'];?>" class="txtAzul fontW400"><?php  echo ucwords($user_com['name']." ".$user_com['lastname']); ?></a>
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

	 <div class="infoProyectos">
	 
	 <div class="headerListProyectos">
	 
	 <?php  
	 $misP = listAll("proyectos","WHERE user_id = '$_COOKIE[id]'");
	 $mp = mysql_num_rows($misP);
	 $borradores = listAll("proyectos","WHERE user_id = '$_COOKIE[id]' AND pro_status ='B'");
	 $b = mysql_num_rows($borradores);
	 $activos = listAll("proyectos","WHERE user_id = '$_COOKIE[id]' AND pro_status ='A'");
	 $a = mysql_num_rows($activos);
	 $adjudicados = listAll("proyectos","WHERE user_id = '$_COOKIE[id]' AND pro_status ='AD'");
	 $ad = mysql_num_rows($adjudicados);
	 $finalizados = listAll("proyectos","WHERE user_id = '$_COOKIE[id]' AND pro_status ='F' OR pro_status ='C' ");
	 $f = mysql_num_rows($finalizados);
	 $filtro = $_GET['filtro'];
	 
	 if($filtro =="borradores"){
	 	$campos = "AND pro_status = 'B'";
	 	$boSelected = 'class="filtroSelected"';
	 }elseif($filtro == "activos"){
	 	$campos = "AND pro_status = 'A'";
	 	$acSelected = 'class="filtroSelected"';
	 }elseif($filtro=="adjudicados"){
	 	$campos = "AND pro_status = 'AD'";
	 	$adSelected = 'class="filtroSelected"';
	 }elseif($filtro =="finalizados"){
	 	$campos = "AND pro_status = 'F' OR pro_status ='C'";
	 	$fiSelected = 'class="filtroSelected"';
	 }else{
	 	$campos = "";
	 	$mpSelected = 'class="filtroSelected"';
	 }
	 
	 
	 
	 ?>
	 <div class="left headerListTit"><a <?php echo $mpSelected;?>  href="miHome">Mis proyectos</a> <span><?php echo $mp;?></span></div>
	  <div class="left headerListTit"><a <?php echo $boSelected;?> href="miHome?filtro=borradores">Borradores</a> <span><?php echo $b;?></span></div>
	   <div class="left headerListTit"><a <?php echo $acSelected;?>  href="miHome?filtro=activos">Activos</a> <span><?php echo $a;?></span></div>
	    <div class="left headerListTit"><a <?php echo $adSelected;?> href="miHome?filtro=adjudicados">Adjudicados</a> <span><?php echo $ad;?></span></div>
	     <div class="left headerListTitlast"><a <?php echo $fiSelected;?> href="miHome?filtro=finalizados">Finalizados</a> <span><?php echo $f;?></span></div>
	 
	 </div>
	 
	 <?php  
	 
	 $projects = listAll("proyectos", "WHERE user_id = '$_COOKIE[id]' ".$campos." ORDER BY pro_date_end DESC");
	 $pro_n = mysql_num_rows($projects);
	 if($pro_n > 0){
	 while ($rs_proj = mysql_fetch_object($projects)){
			$adju="";
		if($rs_proj->pro_status=="B"){
		$estadoPro = "Borrador";
		$adju="Publica este proyecto ahora para recibir ofertas";
		}else if($rs_proj->pro_status=="AD"){
		$estadoPro = "Adjudicado";
		}else if($rs_proj->pro_status=="F"){
		$adju="";
		$estadoPro = "Finalizado";
		}else if($rs_proj->pro_status=="C"){
			$adju="";
			$estadoPro = "Cancelado";
		}else{
		$adju = "No has adjudicado el proyecto aún, ¡hazlo ya!";
		}
			
		$diasRest = diffDate(date("Y-m-d H:i:s"),$rs_proj->pro_date_end);
		
	 ?>
	 <div class="listProyectos">
			 <div class="left listProyectosLeft alignCenter">
			 	<div class="listProyectosOfertas">
				 	<div class="numOfertas"><?php echo getNumOfertas($rs_proj->pro_id);?></div>
				 	<div class="txtOfertas">Ofertas</div>
			 	</div>
			 	<div class="proStatus"> <?php if($rs_proj->pro_status == "A"){ echo $diasRest[2];?> d&iacute;as para adjudicar<?php }else{ echo $estadoPro;}?></div>
			 </div>
			 <div class="left listProyectosCenter">
			 <span class="txtAzul font18 titProyecto"><a class="txtAzul" href="proyecto?id=<?php echo $rs_proj->pro_id;?>"><?php echo ucfirst($rs_proj->pro_tit);?></a></span><br><span class=" font12"><?php if($rs_proj->pro_status != "A"){ echo DateHelper::getLongDate($rs_proj->pro_date);} ?></span>
			 <p align="justify"><?php echo substr($rs_proj->pro_descripcion, "0","350"); if(strlen($rs_proj->pro_descripcion) > 350){?>... <a class="see-more" href="proyecto?id=<?php echo $rs_proj->pro_id;?>">Ver más >></a><?php }?></p></div>
			 
			 <div class="left listProyectosRight">
			 <div><?php 
			 
			 $adjUs = listAll("ofertas", "WHERE pro_id = '$rs_proj->pro_id' AND awarded = 'S'");
			 $rs_adjUs = mysql_fetch_object($adjUs);
			 $val_ad = mysql_num_rows($adjUs);
			 if(($rs_proj->pro_status == "AD" || $rs_proj->pro_status == "F") && $val_ad > 0){?>
			 	<div class="proBoxUserContFot">
					<div class="left">
					<div>
					 	 <?php 
						
						$user_crea = getUserInfo($rs_adjUs->user_id);
						if(is_null($user_crea['user_img'])){
							$img_profile = "images/img_profile_default.jpg";
						}else{
							$img_profile = "thumb.php?w=60&h=60&url=profiles/".sha1($user_crea['id'])."/".$user_crea['user_img'];
						}
						$reviewO = ratings($user_crea['id']);
						?>
					 	 <img alt="Imagen de usuario" src="<?php echo $img_profile;?>" width="50" height="50">
					
					 	       </div>					
					</div>					
					<div class="left proBoxUser">					
						<div class="font12 fontW400">Adjudicado a:</div>					
						<div><a href="perfil?us=<?php  echo $user_crea['act_code'];?>" class="txtAzul fontW400"><?php  echo ucwords($user_crea['name']." ".$user_crea['lastname']); ?></a></div>					
						<div class="rating"><?php  echo $reviewO['stars'];?></div>					
					</div>													
					</div>
			 	</div>
			<?php  }else{ echo $adju; ?></div>
			<p class="alignCenter"> <?php if($rs_proj->pro_status == "A"){?><a href="javascript:cancelarProyecto(<?php echo $rs_proj->pro_id;?>);" class="txtNaranja">Cancelar proyecto</a><?php  }else{ echo "&nbsp;"; } ?></p>
			 <?php  } ?>
			 <?php
			 $calVal = validarCalificacion($_COOKIE['id'], $rs_proj->pro_id);
			 $pago = listAll("pro_transactions", "WHERE t_pro_id = '$rs_proj->pro_id' AND t_status = 'L'");
			 $row_pago = mysql_num_rows($pago);
			 
			 if($rs_proj->pro_status=="A" || $rs_proj->pro_status == "B" || $rs_proj->pro_status == "C"){?>
				 <div class="btn_naranja">
				 	<?php if($rs_proj->pro_status == "A"){?>
				 	<a href="proyecto?id=<?php echo $rs_proj->pro_id;?>">Ver ofertas ></a>
				 <?php }else if($rs_proj->pro_status == "B" || $rs_proj->pro_status == "C"){?>
				 	<a href="agregarProyecto?id=<?php echo $rs_proj->pro_id;?>">Editar proyecto</a>
				 <?php }?>
				 </div>
			 <?php }else if($rs_proj->pro_status == "AD" && $rs_proj->pro_date <= date("Y-m-d H:i:s") && $calVal == false && $row_pago < 1){ ?>
			  <div class="btn_naranja">
			  <a href="confirmProyecto?id=<?php echo $rs_proj->pro_id;?>">Finalizar proyecto</a>
			   </div>
			 <?php }else if($row_pago > 0 && $rs_proj->pro_status == "AD"){ ?>
			 <div class="btn_naranja">
			  <a href="proyectoFinalizar?id=<?php echo $rs_proj->pro_id;?>">Calificar proyecto</a>
			   </div>
			   <?php  } ?>
			 </div>
		 </div>
	 <?php }
		}else{
	 ?>
         <div class="listProyectos">
            <div class="listProyectosCenter">No se encontró ningún resultado</div>
         </div>
	 <?php  } ?>
		 
	 </div>
 </div>