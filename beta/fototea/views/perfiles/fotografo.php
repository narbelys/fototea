 <?php $session = validaSession();
if($session != true || $userType != 1){?>
<script>
		window.location="home";
		</script>
		<?php } ?>
 <div class="containerPerfil">

     <div class="containerInfoPerfil">

         <div class="coverPerfil">
             <?php

             $img_cover = "profiles/".sha1($user_info['id']). "/cover.jpg";
             //}
             ?>

             <img id="coverMainImage" alt="" src="<?php  echo $img_cover;?>" height="291">
         </div>

         <div class="infoPerfilCont">

             <div class="profile-box left">

                 <div class="perfilNombre"><?php echo ucwords($user_info['name'])." ".ucwords($user_info['lastname']);?> <?php if($user_info['id'] == $_COOKIE['id']){?><a href="editarPerfil" class="txtNaranja font12">Editar Perfil</a><?php } ?></div>

                 <div class="left perfilImg">
                     <div>
                         <?php

                         //if(is_null($user_info['user_img'])){
                         //	$img_profile = "images/img_profile_default.jpg";
                         //}else{
                         $img_profile = "profiles/".sha1($user_info['id'])."/profile.jpg"; //.$user_info['user_img'];
                         //}
                         $review = ratings($user_info['id']);
                         ?>
                         <img id="profileMainImage" alt="Imagen de perfil" src="<?php echo 'thumb.php?w=130&h=130&url='.$img_profile;?>" width="106" height="106">
                     </div>
                     <div class="rating"><?php  echo $review['stars'];?></div>
                 </div>


                 <div class="left perfilDesc">
                     <p class="bold"><?php echo ucfirst($user_info['ciudad']); ?></p>

                     <p><?php  echo substr(ucfirst($user_info['descripcion']),0,130); ?></p>
                 </div>


                 <?php if (getCurrentUser() != false): ?>
                     <button class="edit-my-picture profile btn_naranja" onclick="androbCrop.run('profile', '<?php echo 'thumb.php?w=400&h=400&url='.$img_profile;?>');">Editar imagen perfil</button>
                     <button class="edit-my-picture cover btn_naranja"  onclick="androbCrop.run('cover', '<?php echo 'thumb.php?w=400&h=400&url='.$img_cover;?>');">Editar cover</button>
                 <?php endif ?>

                 <div class="tab-box">
                     <div class="pestanaPerfil <?php if($_GET['act'] !="portafolio" && $_GET['act'] !="reviews"){?>pestanaPerfilSelected<?php } ?> left"><a href="perfil?us=<?php echo $user_info['act_code'];?>">Info</a></div>
                     <div class="pestanaPerfil <?php if($_GET['act'] =="portafolio"){?>pestanaPerfilSelected<?php } ?> left"><a href="perfil?us=<?php echo $user_info['act_code'];?>&act=portafolio">Portafolio</a></div>
                     <div class="pestanaPerfil <?php if($_GET['act'] =="reviews"){?>pestanaPerfilSelected<?php } ?> left"><a href="perfil?us=<?php echo $user_info['act_code'];?>&act=reviews">Evaluaci&oacute;n</a></div>
                 </div>
             </div>
             <div class="left buscadorContainer">
                 <form action="resultados" method="post" class="left">
                     <input type="text" id="buscador" name="buscador" class="txt_buscador" autocomplete="off" title="buscador" placeholder="Buscar Proyecto...">
                     <input type="submit" name="button" id="button" value="" class="btn_buscador" />
                 </form>

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
         </div>


         <?php /*if($_COOKIE['id']!= $user_info['id'] && $session == true){
	 	<div class="btnContactame">
	 		<div class="btn_naranja"><a href="javascript:messages(<?php echo $user_info['id'];?>,0)">Contactame</a></div>
	 	</div>
	  }*/ ?>
     </div>

	 <div class="infoProyectos">

		 <div class="headerProyectosList">Proyectos destacados</div>
		 <?php  $projectsD = listAll("proyectos", "WHERE pro_status = 'A' ORDER BY pro_date_end DESC"); 
		 while($rs_proD = mysql_fetch_object($projectsD)){
		$diasRestD = diffDate(date("Y-m-d H:i:s"),$rs_proD->pro_date_end);
		$dateCreate = explode(" ",$rs_proD->pro_cdate);
		$oferta_user = getOferta($rs_proD->pro_id,$_COOKIE['id']);
		 ?>
		 <div class="proyectosListado">
		 <div class="left proyectosListadoTitulo"><a class="txtAzul" href="proyecto?id=<?php echo $rs_proD->pro_id;?>"><?php  echo ucfirst($rs_proD->pro_tit);?></a></div>
		 <div class="left proyectosListadoDesc"><?php  echo substr($rs_proD->pro_descripcion, "0","90"); if(strlen($rs_proD->pro_descripcion) > 90){?>... <a class="see-more" href="proyecto?id=<?php echo $rs_proD->pro_id;?>">Ver más >></a><?php }?></div>
		 <div class="left proyectosListadoFechas alignCenter"><?php echo dateField($dateCreate[0]);?></div>
		 <div class="left proyectosListadoFechas alignCenter"><?php echo $diasRestD[2]."d ".$diasRestD[3]."h";?></div>
		 <div class="left proyectosListadoBtn"><?php if($oferta_user == false){?><div class="btn_naranja"><a href="proyecto?id=<?php echo $rs_proD->pro_id;?>">Oferta ya</a></div><?php }else{ ?><div class="alignCenter">Tu ofertaste por<br><span class="font18 fontW400 txtNaranja">$ <?php echo $oferta_user['monto'];?></span></div><?php  } ?></div>
		 </div>
		 <?php } ?>
		 
		  <div class="headerProyectosList">Proyectos Nuevos</div>
		  <?php  $projectsN = listAll("proyectos", "WHERE pro_status = 'A' ORDER BY pro_date_end DESC"); 
		 while($rs_proN = mysql_fetch_object($projectsN)){
		$diasRestN = diffDate(date("Y-m-d H:i:s"),$rs_proN->pro_date_end);
		$dateCreate = explode(" ",$rs_proN->pro_cdate);
		$oferta_userN = getOferta($rs_proN->pro_id,$_COOKIE['id']);
		 ?>
		 <div class="proyectosListado">
		 <div class="left proyectosListadoTitulo"><a class="txtAzul" href="proyecto?id=<?php echo $rs_proN->pro_id;?>"><?php  echo ucfirst($rs_proN->pro_tit);?></a></div>
		 <div class="left proyectosListadoDesc"><?php  echo substr($rs_proN->pro_descripcion, "0","90"); if(strlen($rs_proN->pro_descripcion) > 90){?>... <a class="see-more" href="proyecto?id=<?php echo $rs_proN->pro_id;?>">Ver más >></a><?php }?></div>
		 <div class="left proyectosListadoFechas alignCenter"><?php echo dateField($dateCreate[0]);?></div>
		 <div class="left proyectosListadoFechas alignCenter"><?php echo $diasRestN[2]."d ".$diasRestN[3]."h";?></div>
		 <div class="left proyectosListadoBtn"><?php if($oferta_userN == false){?><div class="btn_naranja"><a href="proyecto?id=<?php echo $rs_proN->pro_id;?>">Oferta ya</a></div><?php }else{ ?><div class="alignCenter">Tu ofertaste por<br><span class="font18 fontW400 txtNaranja">$ <?php echo $oferta_userN['monto'];?></span></div><?php  } ?></div>
		 </div>
		 <?php } ?>
	 </div>
 </div>