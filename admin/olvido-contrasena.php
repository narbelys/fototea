<?php include("connect/database.php"); 
require_once('../PHPMailer/class.phpmailer.php');
if(isset($_COOKIE['user'])){?>
<script>
window.location="dashboard.php";
</script>
<?php }

if ($_POST){

	$val = listAll("users","WHERE user = '$_POST[username]' AND email = '$_POST[email]'");
	$rs_num = mysql_num_rows($val);
	
	
if ($rs_num > 0){
	$rs_user = mysql_fetch_object($val);
	$salt = salt();
	$passNew = RandomString("8",TRUE,TRUE,FALSE);
	$passEn = sha1($passNew);
	$pass_comb = sha1($salt.$passEn);
	$wee = "salt = '".$salt."', pass = '".$pass_comb."'";
	updateTable("users",$wee,"user = '".$_POST['username']."'");
	

	
	$to = $_POST['email'];
	
		
			$text = '<table width="650" border="0" cellspacing="0" cellpadding="0">
		  <tr>
			<td height="52" colspan="2">Estimado Sr/a <b>'.$rs_user->name.' '.$rs_user->lastname.'</b>, respondiendo a su solicitud de contrase&ntilde;a, le indicamos a continuacion sus datos de acceso al sistema.<br /></td>
		  </tr>
		  <tr>
			<td height="31">Usuario: '.$rs_user->user.'. </td>
			 <td width="252" >&nbsp;</td>
		  </tr>
		  <tr>
			<td width="248" height="28" bgcolor="#CCCCCC">Contrase&ntilde;a: '.$passNew.'</td>
			<td width="252" bgcolor="#CCCCCC">&nbsp;</td>
		  </tr>
		  <tr>
			<td width="248" height="35" bgcolor="#CCCCCC">El equipo de Fototea</td>
			<td width="252" bgcolor="#CCCCCC">&nbsp;</td>
		  </tr>
		</table>';
			$header = 'MIME-Version: 1.0' . "\r\n";
			$header .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
			$header .= 'From: Fototea Admin<no-replay@fototea.com>' . "\r\n";
			$asunto    = "Olvido su contraseña";
			

	$error = "jQuery('.loginerror').slideDown();";
		




if(mail($to,$asunto,$text, $header)){	
	$error_act = "¡Se le han enviado sus datos por email con éxito!.";
		}else{
			$error_act = "No se ha podido ennviar sus datos, por favor intente de nuevo.";
		}	
}else{
	$error = "jQuery('.loginerror').slideDown();";
	$error_act = "Usuario o Email invalidos";
}
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Login</title>
<link rel="stylesheet" href="css/style.css" type="text/css" />
<script type="text/javascript" src="js/plugins/jquery-1.7.min.js"></script>
<script type="text/javascript" src="js/plugins/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$('.loginform button').hover(function(){
		$(this).stop().switchClass('default','hover');
	},function(){
		$(this).stop().switchClass('hover','default');
	});
	
	/*$('#login').submit(function(){
		var u = jQuery(this).find('#username');
		var p = jQuery(this).find("#password");

		
		var act = 0;
		if(u.val() == '') {
			jQuery('.loginerror').slideDown();
			u.focus();
			return false;	
		}
	});*/
	
	<?php print($error);?>
	
	$('#username').keypress(function(){
		jQuery('.loginerror').slideUp();
	});
});
</script>
<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
</head>

<body class="login">

<div class="loginbox radius3">
	<div class="loginboxinner radius3">
    	<div class="loginheader">
    		<h2 class="bebas">&nbsp;</h2>
        	<div class="logo"><img src="images/logoAdmin.png" height="60" alt="" /></div>
    	</div><!--loginheader-->
        
        <div class="loginform">
        	<div class="loginerror"><p><?php echo $error_act;?></p></div>
        	<form id="login" action="" method="post">
            	
                <p>Ingrese su usuario y email registrados en el sistema para recuperar su contraseña</p>
<p>
                	<label for="username" class="bebas">Usuario</label>
                    <input type="text" id="username" name="username" class="radius2" />
                </p>
                <p>
               	  <label for="email" class="bebas">Email</label>
                    <input type="text" id="email" name="email" class="radius2" />
                </p>
                <p>
                	<button class="radius3 bebas">Recuperar</button>
                </p>
                <p><a href="index.php" class="whitelink small"><< Volver</a></p>
            </form>
        </div><!--loginform-->
    </div><!--loginboxinner-->
</div><!--loginbox-->

</body>
</html>
