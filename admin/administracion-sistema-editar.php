<?php include("connect/database.php"); 
validaSession();
securityValidation($_COOKIE['id'],"1");

if ($_POST){
	$we = "name = '".$_POST['firstname']."', lastname = '".$_POST['lastname']."', email = '".$_POST['email']."', department = '".$_POST['dept']."', user = '".$_POST['user']."', udate = NOW(), act = '".$_POST['act']."'";
	 
	updateTable("users",$we,"id = ".$_GET[i]);
	
	if( strlen(trim($_POST['password']," ")) > 0){
		$salt_u = salt();
		$pass_u = sha1($_POST['password']);
		$pass_comb = sha1($salt_u.$pass_u);
		$wee = "salt = '".$salt_u."', pass = '".$pass_comb."'";
		updateTable("users",$wee,"id = ".$_GET['i']);
	}
	
	
	eliminarRegistro("security",'users_id',$_GET['i']); 
	$priv = $_POST['sec'];
	//insertTable("security","'','".$_GET['i']."','1'");
	foreach($priv as $sec){
		$values_sec = "'','".$_GET['i']."','".$sec."'";
		insertTable("security",$values_sec);
	}
	
	
}

$user = listAll("users","WHERE id = ".$_GET['i']);
$rs_user = mysql_fetch_object($user);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Administracion del Sistema</title>
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
			firstname: "required",
			lastname: "required",
			email: {
				required: true,
				email: true,
			},
			dept: "required",
			user: "required"
			
		},
		messages: {
			firstname: "Ingrese el nombre por favor",
			lastname: "Ingrese el apellido por favor",
			email: "Ingrese una direccion de email valida",
			dept: "Ingrese el departamento por favor",
			user: "Ingrese el usuario por favor"
			
			
		}
	});
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
                	<li class="current"><a href="administracion-sistema">Administracion del Sistema</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                	<ul class="widgetlist">
                    	<li><a href="administracion-sistema-agregar.php" class="add">Agregar</a></li>
                    	<li><a href="#" class="edit current">Editar</a></li>
                        <li><a href="administracion-sistema.php" class="list">Lista</a></li>
                    	
                       
                    </ul>
                    
                    <br clear="all" /><br />
                   
                    <div class="contenttitle radiusbottom0">
                	<h2 class="tool"><span>Datos del Usuario</span></h2>
                </div><!--contenttitle-->
                    
                    <br />
                    
                    <form id="form1" class="stdform" method="post" action="">
                    	<p>
                        	<label>Nombre:</label>
                            <span class="field"><input type="text" name="firstname" id="firstname" class="longinput" value="<?=$rs_user->name;?>" /></span>
                        </p>
                        
                        <p>
                        	<label>Apellido:</label>
                            <span class="field"><input type="text" name="lastname" id="lastname" class="longinput" value="<?=$rs_user->lastname;?>"/></span>
                        </p>
                        
                        <p>
                        	<label>Email:</label>
                            <span class="field"><input type="text" name="email" id="email" class="longinput" value="<?=$rs_user->email;?>"/></span>
                        </p>
                        
                      <p>
                       	<label>Departamento:</label>
                          <span class="field"><input type="text" name="dept" id="dept" class="longinput" value="<?=$rs_user->department;?>"/></span>
                        </p>
                        
                       
                        
                      <p>
                       	<label>Usuario:</label>
                         <span class="field"><input type="text" name="user" id="user" class="longinput" value="<?=$rs_user->user;?>"/></span>
                          
                        </p>
                      <p>
                       	<label>Password:</label>
                         <span class="field"><input type="text" name="password" id="password" class="longinput" /></span>
                          
                        </p>
                        
                         <p>
                       	<label>Activo:</label>
                         <span class="field"><input name="act" id="act" type="checkbox" value="S" <?php if ($rs_user->act == "S"){?> checked="checked" <?php } ?> /></span>
                        </p>

                        <br clear="all" />
                        
                         <div class="contenttitle radiusbottom0">
                	<h2 class="tool"><span>Privilegios de Usuario</span></h2>
                </div><!--contenttitle-->
                     
                      <br clear="all" />
                      
                       <div id="content-module">
                        	
                            
                            	<?php 
								
							    $modules = listAll("modules"," WHERE id != 1 ORDER BY description");
								while ($rs_modules = mysql_fetch_object($modules)){ ?>
                            	<div>
                                <strong> - &nbsp;&nbsp;<?=strtoupper($rs_modules->description);?> </strong><br /><br />
                                <?php $submodules = listAll("submodules","WHERE modules_id = $rs_modules->id ORDER BY description ASC");
								while ($rs_submod = mysql_fetch_object($submodules)){ 
								$security = listAll("security","WHERE users_id = $_GET[i] AND modules_id = ".$rs_submod->id);
								$rs_sec = mysql_num_rows($security);?>
                                 <input type="checkbox" name="sec[]" id="sec" value="<?=$rs_submod->id;?>" <?php if($rs_sec == "1"){ echo 'checked="checked"'; } ?>/>  &nbsp;&nbsp;<?=$rs_submod->description;?> <br /><br />
								<?php } ?>
								</div>
                                <?php } ?>
                                </div>
                          <br />
                        
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
