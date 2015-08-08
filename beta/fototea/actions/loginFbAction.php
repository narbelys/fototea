<?

use Fototea\Config\FConfig;
require '../vendor/autoload.php';

require '../scripts/facebook-php-sdk/src/facebook.php';
include_once '../scripts/libSM.php';

$script_url = FConfig::getUrl('actions/loginFbAction.php');
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
            // obtenemos la respuesta y la interpretamos  
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
            	
			
				$user  = $fbme['email'];
				
				$query_login = mysql_query("SELECT * FROM user WHERE user = '".$user."'");
				$num_login = mysql_num_rows ($query_login);
				if ($num_login < 1){
					$login_resp = 'window.location="../login";';
					
				}else{
					$rs_user = mysql_fetch_object($query_login);
					$name = $rs_user->name." ".$rs_user->lastname;
					
				
					$login_date = explode("-",$rs_user->last_login);
				
					if($login_date[0] == "0000"){
						$login_resp = 'window.location="../completarPerfil";';
						setcookie("user",$name,0);
						setcookie("id",$rs_user->id,0);
							
					}else{
						updateTable("user", "last_login=NOW()", "id=$rs_user->id");
						$login_resp = 'window.location="../perfil";';
						setcookie("user",$name,0);
						setcookie("id",$rs_user->id,0);
						
					}
				}
				
				//echo("<script>".$login_resp."</script>");  
            }   
  }  

?>

