<?php
use Fototea\Util\DateHelper;

?>

<?php $session = validaSession();
if($session != true || $userType != 1){?>
<script>
		window.location="home";
		</script>
		<?php } 

 $b = $_POST['buscador'];
 $type_p = $_POST['pro_type'];
 $cat_p = $_POST['pro_category'];

	if(!empty($b)){
		$tt = "AND (pro_tit LIKE '%".$b."%' OR pro_descripcion LIKE '%".$b."%') ";
	}else{
		$tt="";
	}	
 
	
	if($type_p != "-1" && $type_p!=""){
 
		$tp = "AND pro_type = '$type_p' ";
	}else{
		$tp="";
	}
	
	if(!is_null($cat_p) && $type_p != "-1"){
		foreach($cat_p as $ccp){
			$cp .= "pro_category = '$ccp' OR ";  
		}
	
		$sql_cp = "AND (".substr($cp,0,-3).")";
	}else{
		$sql_cp = "";
	}
		
		echo $tt.$tp.$sql_cp;
 	$buscador=listAll("proyectos", "WHERE pro_status='A'".$tt.$tp.$sql_cp." ORDER BY pro_date");
	

$session = validaSession();
if($session != true){?>
<script>
		window.location="home";
		</script>
		<?php } 
		$userType = securityValidation($_COOKIE['id']);
		$user_info = getUserInfo($_COOKIE['id']);
		?>
		
 <div class="containerPerfil">
		<h2 class="titPage">Resultados de la busqueda</h2>
		<div class="buscador">
			<form id="formBuscador" action="resultados" method="post">
				<div><p>Buscar en proyectos:<br> <input type="text" id="buscador" name="buscador"  class="txBoxRegistro" value="<?php  echo $b?>"/></p></div>
				<div class="left"  id="proTypeCont">Tipo:<br>
						<select name="pro_type" id="pro_type" class="cmBoxRegistro" onchange="javascript:categoriesPro(this);">
				     <option value="-1">Tipo de proyecto</option>
					    <?php 
					    $cat_q = listAll("categories","WHERE id !='3' AND id !='4' ORDER BY categories.order ASC");
					    	while($cat = mysql_fetch_object($cat_q)){?>
					    	<option value="<?php echo $cat->id;?>" <?php if($type_p == $cat->id){ echo 'selected="selected"';}?>><?php echo utf8_encode($cat->description);?></option>    	
					   <?php  } ?>
				  </select>
				</div>
				<div  class="categoriasBuscador left <?php if(!is_null($cat_p) && $type_p != "-1"){ echo "cat-active"; }else{ echo "catFotosCont";}?>" >Categor&iacute;as:<br>
				
					<ul class="listCat  <?php if($type_p == "2"){ echo "cat-active"; }else{ echo "catFotosCont";}?>" id="catVideos">
					 <?php $list_subCat = listAll("categories_event", "WHERE id_cat = '2' ORDER BY description ASC");
					while ($rs_subCat = mysql_fetch_object($list_subCat)){
						if(@in_array($rs_subCat->id,$cat_p)){
							$cc = 'checked="cheked"';
						}else{
							$cc= "";
							}
					 ?>
					 <li class="txtGris"><input name="pro_category[]" id="pro_category" type="checkbox" value="<?php echo $rs_subCat->id; ?>" <?php echo $cc; ?>><?php echo $rs_subCat->description; ?></li>
					 <?php  } ?>
				 </ul>
				<ul class="listCat  <?php if($type_p == "1"){ echo "cat-active"; }else{ echo "catFotosCont";}?>" id="catFotos">
					 <?php $list_subCat = listAll("categories_event", "WHERE id_cat = '1' ORDER BY description ASC");
					while ($rs_subCat = mysql_fetch_object($list_subCat)){
						if(@in_array($rs_subCat->id,$cat_p)){
							$ccc = 'checked="cheked"';
						}else{
							$ccc= "";
						}
					 ?>
					 <li class="txtGris"><input name="pro_category[]" id="pro_category" type="checkbox" value="<?php echo $rs_subCat->id; ?>" <?php echo $ccc;?>><?php echo $rs_subCat->description; ?></li>
					 <?php  } ?>
				 </ul>
					
				</div>
				<div class="div_btn_buscar"> <input type="submit" value="Buscar" class="btn_buscador"/></div>
			</form>
		
		</div>
	 <div class="infoProyectos">
	 <div class="header-list-proyects">
	 
	 <?php  
	 ?>
	
	 <div class="left tituloPro">Proyecto</div>
	 	<div class="left ofertasPro">Ofertas</div>
	 	<div class="left pubPro ">Publicado</div>
	 	<!--  <div class="left desdePro">Oferta desde</div>-->
	 
	  </div>
	
	 <?php  
	 
	 $projects = listAll("proyectos, ofertas", "WHERE ofertas.user_id = '$_COOKIE[id]' AND proyectos.pro_id = ofertas.pro_id ".$campos." ORDER BY pro_date_end DESC");
	 $pro_n = mysql_num_rows($buscador);
	 if($pro_n > 0){
	 while ($rs_proj = mysql_fetch_object($buscador)){
		$oferta_baja = listAll("ofertas","WHERE pro_id = '$rs_proj->pro_id' ORDER BY bid ASC LIMIT 0,1");
		$rows_ob = mysql_fetch_object($oferta_baja);
		$diasRest = diffDate(date("Y-m-d H:i:s"),$rs_proj->pro_date_end);
		$oferta_user = getOferta($rs_proj->pro_id,$_COOKIE['id']);
	 ?>
	 
	 <div class="listProyectos">
			
			<div class="left tituloPro"> <a class="txtAzul " href="proyecto?id=<?php echo $rs_proj->pro_id;?>"><?php echo ucfirst($rs_proj->pro_tit);?></a></div>
			 <div class="left ofertasPro">		
			 
			 <?php 
			 $ads = listAll("ofertas", "WHERE pro_id ='$rs_proj->pro_id'");
			 $ad = mysql_num_rows($ads);
			 
			 
			
			
			?>
			 
			 
			 </div>
			 <div class=" left font12 pubPro ">
			<?php echo DateHelper::getLongDate($rs_proj->pro_cdate)."<br>";
			   echo '<span class="txtNaranja">'.$diasRest[2];?> d&iacute;as para adjudicar</span></div>
			<div class="left desdePro alignCenter"><?php if($oferta_user == false){?><div class="btn_naranja"><a href="proyecto?id=<?php echo $rs_proj->pro_id;?>">Oferta ya</a></div><?php }else{ ?><div class="alignCenter">Tu ofertaste por<br><span class="font18 fontW400 txtNaranja">$ <?php echo $oferta_user['monto'];?></span></div><?php  } ?><?php //echo number_format($rows_ob->bid,'2',',','.');?><!-- $--></div>
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