<?php

$session = validaSession();
if($session == true){
	$userType = securityValidation($_COOKIE['id']);
	$user_info = getUserInfo($_COOKIE['id']);
	
	
	
	if($userType=="1"){
	include_once 'perfiles/fotografo.php';	
	}elseif($userType=="2"){
	include_once 'perfiles/clientes.php';	
	}
}else{?>
<script>
window.location="home";
</script>
<?php

}

include_once 'perfiles/cropProfile.php';