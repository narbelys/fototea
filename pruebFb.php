<?php session_start();

require 'beta/fototea/scripts/facebook-php-sdk/src/facebook.php';

//include_once '../scripts/libSM.php';
$script_url = FConfig::getValue('base_url', 'pruebFb.php');
$facebook = new Facebook(array(
		'appId'  => '1439029029658789',
		'secret' => '7d2b3d38d73c4f61aa0bae0f6f09177c',
));

 // obtener el codigo de respuesta  
  $code = $_REQUEST["code"];  
  // construir el URL de login de Facebook  
  $fbLoginUrl = $facebook->getLoginUrl(array(  
       'scope' => 'email',  
       'display' => 'popup',  
       'redirect_uri' => $script_url  
  ));  
  // si no existe codigo de retorno de facebook, enviarmos al usuario al formulario  
  // de login de Facebook  
  if(empty($code)) {  
       echo("<script> top.location.href='$fbLoginUrl'</script>");  
       exit;  
  } else {  
            // obtener el token de autenticacion a partir de Facebook Graph  
            $token_url = "https://graph.facebook.com/oauth/access_token?"  
              . "client_id=1439029029658789&redirect_uri=" . urlencode($script_url)  
              . "&client_secret=7d2b3d38d73c4f61aa0bae0f6f09177c&code=" . $code;  
            // obteenemos la respuesta y la interpretamos  
            $response = @file_get_contents($token_url);  
            $params = null;  
            parse_str($response, $params);  
            // asignamos al objecto Facebook el token para proceder a realizar  
            // llamadas al API posteriormente  

            $facebook->setAccessToken($params['access_token']);  
            $fbme = $facebook->api('/me', 'GET');  
            if ($fbme) {  
                 // teniendo el objeto Facebook ME (datos del usuario) procedemos  
        // a realizar nuestro proceso ya sea de login o registro.                 
               
				echo $fbme['email'];
            }   
  }  

?>

