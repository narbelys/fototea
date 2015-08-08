<?php include("connect/database.php"); 
if(isset($_COOKIE['user'])){?>
<script>
window.location="dashboard.php";
</script>
<?php }

if ($_POST){
$rr = login($_POST['username'],$_POST['password']);
if ($rr == false){
$error = "jQuery('.loginerror').slideDown();";
	
}else{?>

<script>
window.location="dashboard.php";
</script>
<?php }
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
    		<h1 class="bebas">&nbsp;</h1>
        	<div class="logo"><img src="images/logoAdmin.png" height="60" alt="" /></div>
    	</div><!--loginheader-->
        
        <div class="loginform">
        	<div class="loginerror"><p>Usuario o password invalidos</p></div>
        	<form id="login" action="" method="post">
            	<p>
                	<label for="username" class="bebas">Usuario</label>
                    <input type="text" id="username" name="username" class="radius2" />
                </p>
                <p>
                	<label for="password" class="bebas">Password</label>
                    <input type="password" id="password" name="password" class="radius2" />
                </p>
                <p>
                	<button class="radius3 bebas">Entrar</button>
                </p>
                <p><a href="olvido-contrasena.php" class="whitelink small">Olvido su contraseña</a></p>
            </form>
        </div><!--loginform-->
    </div><!--loginboxinner-->
</div><!--loginbox-->

</body>
</html>
