<?php include("connect/database.php"); 
validaSession();


if ($_POST){
	$we = "name = '".$_POST['firstname']."', lastname = '".$_POST['lastname']."', email = '".$_POST['email']."', udate = NOW()";
	 
	updateTable("users",$we,"id = ".$_COOKIE['id']);
	
	if( strlen(trim($_POST['password']," ")) > 0){
		$salt_u = salt();
		$pass_u = sha1($_POST['password']);
		$pass_comb = sha1($salt_u.$pass_u);
		$wee = "salt = '".$salt_u."', pass = '".$pass_comb."'";
		updateTable("users",$wee,"id = ".$_COOKIE['id']);
	}
	
	
	
	
}

$user = listAll("users","WHERE id = ".$_COOKIE['id']);
$rs_user = mysql_fetch_object($user);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Mi Perfil</title>
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
                	<li class="current"><a href="mi-perfil">Mi Perfil</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                	
                    
                   
                   
                  <div class="contenttitle radiusbottom0">
                	<h2 class="tool"><span>Datos de Mi Perfil</span></h2>
                </div><!--contenttitle-->
                    
                    <br />
                    
                    <form id="form1" class="stdform" method="post" action="">
                    	<p>
                        	<label>Nombre:</label>
                            <span class="field"><input name="firstname" type="text" class="longinput" id="firstname" value="<?php echo $rs_user->name;?>" /></span>
                        </p>
                        
                        <p>
                        	<label>Apellido:</label>
                            <span class="field"><input name="lastname" type="text" class="longinput" id="lastname" value="<?php echo $rs_user->lastname;?>"/></span>
                        </p>
                        
                        <p>
                        	<label>Email:</label>
                            <span class="field"><input name="email" type="text" class="longinput" id="email" value="<?php echo $rs_user->email;?>"/></span>
                        </p>
                        
                      <p>
                       	<label>Departamento:</label>
                          <span class="field"><input name="dept" type="text" disabled="disabled" class="longinput" id="dept" value="<?php echo $rs_user->department;?>" readonly="readonly"/></span>
                        </p>
                        
                      <p>
                       	<label>Usuario:</label>
                         <span class="field"><input name="user" type="text" disabled="disabled" class="longinput" id="user" value="<?php echo $rs_user->user;?>" readonly="readonly"/></span>
                          </span>
                        </p>
                      <p>
                       	<label>Password:</label>
                         <span class="field"><input type="text" name="password" id="password" class="longinput" /></span>
                          </span>
                        </p>

                        <br clear="all" /><!--contenttitle-->
                     
                   
                        
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
