<?php include("connect/database.php"); 
validaSession();
securityValidation($_COOKIE['id'],"13");


if($_POST){
	$user_act = $_REQUEST['act'];
	$name = $_REQUEST['name'];
	$gender = $_REQUEST['gender'];
	$lastname = $_REQUEST['lastname'];
	$dob = $_REQUEST['user_year']."-".$_REQUEST['user_month']."-".$_REQUEST['user_day'];
	
	$desc = $_REQUEST['user_descripcion'];
	$direccion = $_REQUEST['address'];
	$cp = $_REQUEST['zip'];
	$pais = $_REQUEST['user_pais'];
	$tel = $_REQUEST['phone'];
	$movil = $_REQUEST['mobile'];
	$city = $_REQUEST['city'];
	$id_user = $_GET['i'];
	
	$user_data = updateTable("user", "name = '$name',lastname= '$lastname',dob='$dob',act='$user_act',gender='$gender'", "id = '$_GET[i]'");
	
	updateTable("user_det", "description = '$desc'", "id_user = '$id_user' AND id_data = '2'");
	updateTable("user_det", "description = '$direccion'", "id_user = '$id_user' AND id_data = '3'");
	updateTable("user_det", "description = '$cp'", "id_user = '$id_user' AND id_data = '4'");
	updateTable("user_det", "description = '$pais'", "id_user = '$id_user' AND id_data = '5'");
	updateTable("user_det", "description = '$tel'", "id_user = '$id_user' AND id_data = '6'");
	updateTable("user_det", "description = '$city'", "id_user = '$id_user' AND id_data = '10'");
	$md = getUserData($id_user,"7");
	if(empty($md)){
		insertTable("user_det", "'',$id_user,'7','$movil'");
	}else{
		updateTable("user_det", "description = '$movil'", "id_user = '$id_user' AND id_data = '7'");
	}
	
	if($user_data != false){
	
	
	?>
<script>
	alert("Se ha modificado el usuario correctamente.");
	window.location="usuarios.php";
	</script>
    <?php }else{ ?>
    <script>
	alert("No se ha  podido modificar el usuario correctamente.");
	window.history.back();
	</script>
    <?php }
	
}

$user =  getUserInfo($_GET['i']);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Usuarios Registrados</title>
<link rel="stylesheet" href="css/style.css" type="text/css" />
<!--[if IE 9]>
    <link rel="stylesheet" media="screen" href="css/ie9.css"/>
<![endif]-->

<!--[if IE 8]>
    <link rel="stylesheet" media="screen" href="css/ie8.css"/>
<![endif]-->

<!--[if IE 7]>
    <link rel="stylesheet" media="screen" href="css/ie7.css"/>
<![endif]-->
<script type="text/javascript" src="js/plugins/jquery-1.7.min.js"></script>
<script type="text/javascript" src="js/plugins/jquery.flot.min.js"></script>
<script type="text/javascript" src="js/plugins/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="js/plugins/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/custom/general.js"></script>
<script type="text/javascript" src="js/custom/tables.js"></script>
<script type="text/javascript" src="js/plugins/jquery.validate.min.js"></script>
<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
<script>
jQuery(document).ready(function(){
//FORM VALIDATION
	jQuery("#form1").validate({
		rules: {
			
			orden: "required",
			
			
			
		},
		messages: {
			
			orden: "Este campo es requerido",
			
		},
	})
	     
		 
	<?php print($error); ?>	 
		 
});
$(document).ready(function(){
	<?php print($error); ?>
});
  
</script>
</head>

<body class="loggedin">

	<!-- START OF HEADER -->
<div class="header radius3">
    	<?php include("top.php"); ?>
	</div><!--header-->
    <!-- END OF HEADER -->
        
    <!-- START OF MAIN CONTENT -->
    <div class="mainwrapper">
     	<div class="mainwrapperinner">
         	
        <div class="mainleft">
          	<?php include("menu.php"); ?>
        </div><!--mainleft-->
        
        <div class="maincontent noright">
        	<div class="maincontentinner">
            	
                <ul class="maintabmenu">
                	<li class="current"><a href="clientes">Usuarios Registrados</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                	<ul class="widgetlist">
                    	
                        <li><a href="usuarios.php" class="list">Lista</a></li>
                    	
                       
                    </ul>
                    
                    <br clear="all" /><br />
                   
                    <div class="contenttitle radiusbottom0">
                	<h2 class="users"><span>Datos del usuario</span></h2>
                </div><!--contenttitle-->
                      <div id="msgSuccess" class="notification msgsuccess" style="display:none">
                        <a class="close"></a>
                        <p>Se agregó el cliente con éxito.</p>
                    </div><!-- notification msgsuccess -->
                    
                    <div id="msgAlert" class="notification msgalert" style="display:none">
                        <a class="close"></a>
                        <p>No se pudo agregar el cliente, por favor vuelva a intentar.</p>
                    </div><!-- notification msgalert -->
                    <br />
                    
                    <form id="form1" name="form1" class="stdform" method="post" action="" enctype="multipart/form-data">
                    	
 						 <p>
                        	<label>Tipo de usuario:</label>
                            <span class="field">
	                            <select name="user_type" id="user_type" disabled="disabled" class="disabled">
	   
							    	<option value="1" <?php if($user['user_type'] == "1") echo 'selected="selected"';?>>Fotografo</option>    
							    	<option value="2" <?php if($user['user_type'] == "2") echo 'selected="selected"';?>>Cliente</option>    	
							  
							  </select>
                            </span>
                        </p>
                        <p>
                        	<label>Activo:</label>
                            <span class="field"><input name="act" id="act" type="checkbox" value="S" <?php if ($user['act'] == "S"){?> checked="checked" <?php } ?> /></span>
                        </p>
                        <p>
                        	<label>Nombre:</label>
                            <span class="field"><input type="text" name="name" id="name" value="<?php echo $user['name'];?>"  class="longinput"/></span>
                        </p>
                         <p>
                        	<label>Apellidos:</label>
                            <span class="field"><input type="text" name="lastname" id="lastname" value="<?php echo $user['lastname'];?>"  class="longinput"/></span>
                        </p>
                        <p>
                        	<label>Sexo:</label>
                            <span class="field"><select name="gender" id="gender">
   
    	<option value="F" <?php if($user['sex'] == "Mujer") echo 'selected="selected"';?>>Mujer</option>    
    	<option value="H" <?php if($user['sex'] == "Hombre") echo 'selected="selected"';?>>Hombre</option>    	
  
  </select></span>
                        </p>
                         <p>
                        	<label>Fecha de Nacimiento:</label>
                            <span class="field">
                            	<select name="user_day" id="user_day" class="cmBoxRegistro">
    <option value="-1">Día</option>
    <?php  for($i=1;$i<32;$i++){?>
    	<option value="<?php echo $i;?>" <?php if($user['dia'] == $i) echo 'selected="selected"';?>><?php echo $i;?></option>    	
   <?php  } ?>
  </select>
   <select name="user_month" id="user_month" class="cmBoxRegistro">
     <option value="-1">Mes</option>
    <option value="1" <?php if($user['mes'] == "1" ) echo 'selected="selected"';?>>Enero</option>
     <option value="2"  <?php if($user['mes'] == "2" ) echo 'selected="selected"';?>>Febrero</option>
      <option value="3"  <?php if($user['mes'] == "3" ) echo 'selected="selected"';?>>Marzo</option>
       <option value="4"  <?php if($user['mes'] == "4" ) echo 'selected="selected"';?>>Abril</option>
        <option value="5"  <?php if($user['mes'] == "5" ) echo 'selected="selected"';?>>Mayo</option>
         <option value="6"  <?php if($user['mes'] == "6" ) echo 'selected="selected"';?>>Junio</option>
          <option value="7"  <?php if($user['mes'] == "7" ) echo 'selected="selected"';?>>Julio</option>
           <option value="8"  <?php if($user['mes'] == "8" ) echo 'selected="selected"';?>>Agosto</option>
            <option value="9"  <?php if($user['mes'] == "9" ) echo 'selected="selected"';?>>Septiembre</option>
             <option value="10"  <?php if($user['mes'] == "10" ) echo 'selected="selected"';?>>Octubre</option>
              <option value="11"  <?php if($user['mes'] == "11" ) echo 'selected="selected"';?>>Noviembre</option>
               <option value="12"  <?php if($user['mes'] == "12" ) echo 'selected="selected"';?>>Diciembre</option>
  </select>
   <select name="user_year" id="user_year" class="cmBoxRegistro">
    <option value="-1">A&ntilde;o</option>
     <?php  for($i=date("Y");$i>=1905;$i--){?>
    	<option value="<?php echo $i;?>" <?php if($user['ano'] == $i) echo 'selected="selected"';?>><?php echo $i;?></option>    	
   <?php  } ?>
  </select>
	</span>
                        </p>
                         <p>
                        	<label>Descripci&oacute;n del perfil:</label>
                            <span class="field"><textarea name="user_descripcion" id="user_descripcion" class="longinput" maxlength="130"><?php echo $user['descripcion'];?></textarea></span>
                        </p>
                         <p>
                        	<label>Direcci&oacute;n:</label>
                            <span class="field"><input type="text" name="address" id="address" value="<?php echo $user['direccion'];?>"  class="longinput"/></span>
                        </p>
                         <p>
                        	<label>Ciudad:</label>
                            <span class="field"><input type="text" name="city" id="city" value="<?php echo $user['ciudad'];?>"  class="longinput"/></span>
                        </p>
                        
                         <p>
                        	<label>Codigo postal:</label>
                            <span class="field"><input type="text" name="zip" id="zip" value="<?php echo $user['cp'];?>"  class="longinput"/></span>
                        </p>
                         <p>
                        	<label>Pa&iacute;s:</label>
	                            <span class="field"><select name="user_pais" id="user_pais" class="cmBoxRegistro">
							     <option value="-1">Pa&iacute;s</option>
								    <?php 
								    $pais_q = listAll("paises"," ORDER BY nombre ASC");
								    	while($pais = mysql_fetch_object($pais_q)){?>
								    	<option value="<?php echo $pais->iso;?>" <?php if($user['pais_ab'] == $pais->iso) echo 'selected="selected"';?>><?php echo utf8_encode($pais->nombre);?></option>    	
								   <?php  } ?>
							  </select></span>
                        </p>
                         <p>
                        	<label>Tel&eacute;fono:</label>
                            <span class="field"><input type="text" name="phone" id="phone" value="<?php echo $user['telefono'];?>"  class="longinput"/></span>
                        </p>
                         <p>
                        	<label>Movil:</label>
                            <span class="field"><input type="text" name="mobile" id="mobile" value="<?php echo $user['movil'];?>"  class="longinput"/></span>
                        </p>
                        
                       
                        <br clear="all" />

                        <p class="stdformbutton" align="right">
                        	<button class="submit radius2">Modificar</button>
                        </p>
                    </form>
                    
                    <br clear="all" /><br />
                   </div> <!--content-->
            </div><!--maincontentinner-->
            
            <div class="footer">
            	<?php include("footer.php"); ?>
            </div><!--footer-->
            
        </div><!--maincontent-->
        
       
                
     	</div><!--mainwrapperinner-->
    </div><!--mainwrapper-->
	<!-- END OF MAIN CONTENT -->
   

</body>
</html>
