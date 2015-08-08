<?php

use Fototea\config\FConfig;
use Fototea\Models\Notification;
use Fototea\Models\Project;
use Fototea\Models\TmpProject;
use Fototea\Models\User;
use Fototea\Util\FAnalytics;
use Fototea\App\App;

ini_set('display_errors', 1);
error_reporting(E_ERROR);

// Auto-load
require 'vendor/autoload.php';

$app = new App();

include('scripts/libSM.php');


//unset($_SESSION['shopping-cart']);

//use Fototea\Models\PuntoPagos;
//$pp = new PuntoPagos();
//
////$pp->createTransaction('1111100000001', 10000);
//$pp->getTransaction('N756GCCQT93EHUMA', '1111100000001', 10000);
//
//die('fin');



$request = $app->getRequest()->get('q');
$section_name= '';
if (isset($request)) {
	$_items = explode('/',$request);
//	print_r($_items);
	$section_name = $_items[0];
	//unset($_items[0]);
}

if(!empty($_items[0]) && file_exists("views/".$_items[0].".php")){
	$section_name =$_items[0];
}else{
	$section_name = "home";
}

$actError = "";
if($section_name =="login"){

	if($_GET['code']){
		require 'scripts/facebook-php-sdk/src/facebook.php';

		$script_url = FConfig::getUrl('login');
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
					$login_resp = 'window.location="registroFacebook";';

				}else{
					$rs_user = mysql_fetch_object($query_login);
					$name = $rs_user->name." ".$rs_user->lastname;


					$login_date = explode("-",$rs_user->last_login);

					if($login_date[0] == "0000"){
						$login_resp = 'window.location="completarPerfil";';
						setcookie("user",$name,0);
						setcookie("id",$rs_user->id,0);

					}else{
						updateTable("user", "last_login=NOW()", "id=$rs_user->id");
						$login_resp = 'window.location="perfil";';
						setcookie("user",$name,0);
						setcookie("id",$rs_user->id,0);

					}
				}
				echo("<script>".$login_resp."</script>");
			}
		}
	}

	if($_POST){
		$user_user = $_REQUEST['user_user'];
		$user_pass = $_REQUEST['user_password'];

		$login = login($user_user, $user_pass);
		if ($login == false){
            $app->addError("La combinación de Correo y Contrase&ntilde;a son incorrectos.");

            $app->getInput()->save();
            $app->redirect($app->getHelper('UrlHelper')->getUrl('login'));
            /* Mientras esto se mueve a donde debe estar */
            $app->shutdown();
            die();

			//$error = "La combinación de Correo y Contrase&ntilde;a son incorrectos.";
            //$actError = '$("#formError").slideDown("slow");
            //$actError = '$("#formError").css("display", "")';
		} else {
            // TODO: SACAR ESTA LOGICA DE AQUI JUNTO CON EL REFACTOR DE LOGIN
            if ($app->getRequest()->cookie('guest_project')){
                // TODO: CAMBIAR ESTE QUERY CUANDO SE CAMBIE EL LOGIN, AHORA ES NECESARIO PORQ EN ESTE PUNTO LA COOKIE AUN NO EXISTE (MISMO REQUERT QUE CUANDO SE CREA Y NO SIRVE getCurrentUser())
                $currentUser = User::getUserByEmail($user_user);

                if($currentUser->user_type == User::USER_TYPE_CLIENT){
                    $tmpProjectId = $app->getRequest()->cookie('guest_project');
                    $tmpProject = TmpProject::getTmpProjectByTmpId($tmpProjectId);
                    if ($tmpProject){
                        $project = Project::createProjectFromTmp($tmpProject, $currentUser->id);
                        TmpProject::assignTmpProjectToUser($tmpProject->pro_id, $currentUser->id);

                        // Event: Proyectos subidos
                        $eventData = new stdClass();
                        $eventData->user_id = $currentUser->id;
                        $eventData->project_id = $project->id();
                        $eventData->project_name = $project->get('pro_tit');
                        $events = FAnalytics::getInstance();
                        $events->trackEvent('Proyecto', 'Proyectos subidos', json_encode($eventData));
                    }

                    // Delete cookie
                    $app->getResponse()->removeCookie('guest_project');
                }
            }

            $app->redirect($app->getHelper('UrlHelper')->getUrl($login));
		}
	}
}

if($section_name =="signOut"){
    $salir = signOut();
}

$session = validaSession();
$currentUser = getCurrentUser();
$loggedUser = getUserInfo($user->id);

$defaultLogoLink = ($currentUser)? 'perfil':'home';
$defaultLogoLink = FConfig::getUrl($defaultLogoLink);

$notList = array();

if ($currentUser) {
    //NOTIFICACIONES
//    $not = listAll("notificaciones"," WHERE user_id = $currentUser->id  AND leido = 'N' ORDER BY cdate DESC");
//    while($rs_not = mysql_fetch_object($not)){
//        $notList[] = $rs_not;
//    }

    $notList = Notification::getUserNotifications($currentUser->id);
}

//TODO:  eliminar esto algun dia FALLBACK OLD STYLES HERE
$skipLegacy = array('perfil', 'login', 'registro', 'agregarProyecto', 'contactanos', 'metodopago', 'pagoexito', 'pagoerror', 'bodas');
?>
<!DOCTYPE HTML>
<html lang="es">
    <head>
    	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
       <?php
       $seo = listAll("seo","WHERE page='%$_items[0]'");
       $rs_seo = mysql_fetch_object($seo);

       if(empty($rs_seo->page)){
       ?>
        <title>Fototea: Mercado de fot&oacute;grafos y editores independientes</title>
        <meta name="description" content="Fototea es la única plataforma en donde podrás contratar  Fotógrafos, Cineastas, Editores y Creativos audiovisuales para tus proyectos y eventos">
		<meta name="keywords" content="Fotografia,Fotografo,Audiovisual,Productor,Barcelona,Madrid,España,Evento,Freelance,Retratos,Campaña, Publicidad,Promocion,Modelos,Fotos,Sesion,Promocion,Corporativo">
       <?php }else{ ?>
       <title><?php echo $rs_seo->title;?></title>
        <meta name="description" content="<?php echo $rs_seo->description;?>">
		<meta name="keywords" content="<?php echo $rs_seo->keywords;?>">

       <?php  } ?>
        <meta name="p:domain_verify" content="249dc2b0f5e8e8ba64dece2e416d1316"/>
        <!-- Le styles -->
        <?php if (!in_array($section_name, $skipLegacy)): ?>
            <link href="css/legacy.css" rel="stylesheet" type="text/css" />
        <?php endif ?>

        <!-- X-Editable Plugin -->
<!--        <link href="--><?php //echo FConfig::getUrl('css/xeditable/editable.css') ?><!--" rel="stylesheet"/>-->
        <link href="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/css/jquery-editable.css" rel="stylesheet"/>

        <link href="dist/css/style.css" rel="stylesheet" type="text/css" />
		<link rel="shortcut icon" href="images/favicon.ico">

        <!-- Scripts-->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

        <script src="js/AnalyticsCarousel.js"></script>
          <!-- Load jQuery and the validate plugin   descargar y poner en carpeta-->
<!--           <script src="https://code.jquery.com/jquery-1.9.1.js"></script>-->
           <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.9/jquery.validate.min.js"></script>
            <script src="http://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
        <script src="<?php echo FConfig::getUrl('less/bootstrap-3.1.1/js/alert.js') ?>"></script>
        <link rel="stylesheet" href="//code.jquery.com/ui/1.10.4/themes/flick/jquery-ui.css">
             <script src="js/jquery.Rut.js"></script>
             <!--<scripts src="js/jquery.raty-fa.js" type="text/javascript"></scripts>-->
               <script type="text/javascript" src="js/jquery.raty.min.js"></script>
               <script src="js/contador-palabras.js"></script>
               <script src="js/jquery.stellar.js" ></script>

        <!-- X-Editable Plugin -->
        <script src="//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jquery-editable/js/jquery-editable-poshytip.min.js"></script>

        <script src="js/fncts.js"></script>
<!--        <link rel="stylesheet" type="text/css" href="--><?php //echo FConfig::getUrl('css/jcrop/jquery.Jcrop.css') ?><!--" />-->
<!--        <link rel="stylesheet" type="text/css" href="--><?php //echo FConfig::getUrl('css/colorbox/colorbox.css') ?><!--" />-->
        <script src="<?php echo FConfig::getUrl('js/jquery.Jcrop.min.js') ?>"></script>
        <script src="<?php echo FConfig::getUrl('js/jquery.colorbox.js') ?>"></script>
   	 	<script>
   	 $(document).ready(function() {

   	         //------------------------------------------REGISTRO-----------------------------------------------------
                $( "#bRegistrar" ).click(function() {
                    $("#formRegistro").submit();
                });
        
                $("#formRegistro").validate({

                    // Specify the validation rules
                    rules: {
                        user_name: {
                            required: true,
                        },
                        user_lastname: {
                            required: true,
                        },
                        user_password: {
                            required: true,
                            minlength: 8,
                        },

                        user_confirm: {
                            required: true,
                            minlength: 8,
                             equalTo: "#user_password"
                        },

                        user_email: {
                            required: true,
                            email: true
                        },

                    },

                    // Specify the validation error messages
                    messages: {
                        user_name: "Introduce tu nombre",
                        user_lastname: "Introduce tu apellido",
                        user_password: "Introduce una contraseña, tiene que tener mínimo 8 caracteres",
                        user_user: "Introduce una dirección dSelecciona las imágenes que desees agregar a tu álbum. e correo válida",
                        user_confirm: "La contraseñas tienen que coincidir ",

                    },

                    highlight: function (element) {
                        $(element).closest('.form-group').removeClass('has-success').addClass('has-error');
                    },
                    unhighlight: function (element) {
                        $(element).closest('.form-group').removeClass('has-error').addClass('has-success');
                    },
                    errorElement: 'span',
                    errorClass: 'help-block ',

                });
        


                $("#formRegistro").submit(function(){
                    var error = 0;
                    $("#formError").html("")
                    $( "#bRegistrar" ).html("Cargando...");
                    $( "#bRegistrar" ).addClass("disabled");

                    $.ajax({
                            type: 'get',
                            dataType: 'json',
                            url: 'actions/perfilAction.php',
                            data: {email:$("#user_email").val(),act:"val_mail"},
                            success: function(resp){

                                if(resp[0]['resp'] == "1"){
                                    $("#correo").addClass("has-error has-feedback")
                                    //cambiar por un error desde el servidor 
                                    $("#formError").append(" Su dirección de correo electrónico ya ha sido registrada en Fototea, intente ingresando una diferente");
                                    $("#formError").slideDown('slow');
                                    error++;
                                    $( "#bRegistrar" ).html("Regístrate");
                                    $( "#bRegistrar" ).removeClass("disabled");
                                }else{

                                }
                            }
                        });

                    if(error == 0){
                        $.ajax({
                            type: 'get',
                            dataType: 'json',
                            url: 'actions/registroAction.php',
                            data:
                                                {email:$("#user_email").val(),userType:$('input:radio[name=user_type]:checked').val(),name:$("#user_name").val(),lastname:$("#user_lastname").val(),pass:$("#user_password").val(), ru: $('#ru').val(), rm: $('#rm').val() },
                            success: function(json){
                                //funcion para llenar los datos del detalle
                                $(".contenido-registro").html("<div><h2 class='main-title'>Registro</h2><p>¡Muchas gracias por registrarte con nosotros! En los pr&oacute;ximos minutos recibir&aacute;s un correo de confirmaci&oacute;n.<br><br> Si quieres saber m&aacute;s, s&iacute;guenos en nuestro <a href='https://www.facebook.com/Fototea' target = '_blank' class='txtAzul bold'>Facebook</a>.</p></div>");
                            }
                        });
                    }
                    return false;});
   	         
   	         
   	         //------------------------------------------FIN REGISTRO----------------------------------
   	 
             //--------------------------------------------ANIMACION DE REGISTRO---------------------------------------------               
               /* $('#divAnimado').hover( 
                    function () {
                        //$("#btn2").css('display', 'none'); 
                        $("#btn").show("slow"); 
                        
                        $('#divAnimado').css('background', ' #fff url("images/2.jpg") no-repeat center') 
                    }, 
                    function () { 
                         //$("#btn").css('display', '');
                        $("#btn").hide("fast"); 
                       
                        $('#divAnimado').css('background', ' #fff url("images/22.jpg") no-repeat center') 
                    } ); 
                $('#divAnimado2').hover( 
                    function () { 
                        $("#btn2").show("slow"); 
                       // $("#btn2").css('display', '');
                        $('#divAnimado2').css('background', ' #fff url("images/1.jpg") no-repeat center') 
                    }, 
                    function () { 
                        $('#divAnimado2').css('background', '#fff url("images/11.jpg") no-repeat center') 
                        $("#btn2").hide("fast"); 
                        // $("#btn2").css('display', 'none');
                    } ); 

                $( "#btn" ).click(
                    function() { 
                         $('#divAnimado').unbind("mouseenter mouseleave");
                        $("#btn").hide("fast"); 
                        $('#divAnimado2').unbind("mouseenter mouseleave");
                        $("#btn2").hide("fast"); 
                        $('#divAnimado2').css('background', '#fff url("images/1.jpg") no-repeat center') 
                        $('#divAnimado').css('background', ' #fff url("images/2.jpg") no-repeat center') 
                        $('input:radio[name=user_type][value=1]').attr('checked', true);
                        $('#divAnimado').animate({ 'margin-left':'-25%' },1500); 
                        $('#divAnimado2').animate({ 'margin-left':'75%' },1500); 
                    }); 
                $( "#btn2" ).click(
                    function() { 
                         $('#divAnimado').unbind("mouseenter mouseleave");
                        $("#btn").hide("fast"); 
                        $('#divAnimado2').unbind("mouseenter mouseleave");
                        $("#btn2").hide("fast"); 
                        $('#divAnimado2').css('background', '#fff url("images/1.jpg") no-repeat center') 
                        $('#divAnimado').css('background', ' #fff url("images/2.jpg") no-repeat center') 
                        $('input:radio[name=user_type][value=2]').attr('checked', true);
                        $('#divAnimado').animate({ 'margin-left':'-25%' },1500); 
                        $('#divAnimado2').animate({ 'margin-left':'75%' },1500); 
                    }); 
                    
                     
                      

                $("#btn").hide("fast");
                $("#btn2").hide("fast");*/



         //TODO Move from here
         //Init editable


        
        //----------------------------------------FIN ANIMACION DE REGISTRO----------------------------------------------
        
        $(".facebook").hover(function() {
               $(this).removeClass('bounce' + ' animated').addClass('bounce' + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
          $(this).removeClass('bounce' + ' animated');
              });

        });
        $(".twitter").hover(function() {
               $(this).removeClass('bounce' + ' animated').addClass('bounce' + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
          $(this).removeClass('bounce' + ' animated');
              });

        });
        $(".instagram").hover(function() {
               $(this).removeClass('bounce' + ' animated').addClass('bounce' + ' animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
          $(this).removeClass('bounce' + ' animated');
              });

        });
            
            
            
            

   		$('.menuUsuarioP').hover(
   				function(){
   				$('.menuUsuarioS',this).stop(true,true).slideDown('fast');
   				},
   				function(){
   				$('.menuUsuarioS',this).slideUp('fast');
   				}
   			);

   		//setInterval(function() {
   	   		//$("#mensajeNot").load("/beta/fototea/index.php #mensajeCont");
   		//},5000);

      <?php if($section_name == "home"){?>

            // activa el primer valor
          $(".contentnav a:first").addClass("active");
          if($("#slides .rotatorBkContent").length > 1){
            rotate = function(){
            //Remove active class
            $(".contentnav a").removeClass('active');

            //Add Active Class
            $active.addClass('active');
            act = $active.attr("rel");


            //imagen actual y siguiente
             $activeI = $('#slides .rotatorBkContent.rotatorActive');
             if ( $activeI.length == 0 ) $activeI = $('#slides .rotatorBkContent:last');
             $nextI = $("#d_"+act);

            //animacion de imagen
             $activeI.addClass('last-active');
             $nextI.css({opacity: 0.0})
          .addClass('rotatorActive')
          .animate({opacity: 1.0}, 1000, function() {
              $activeI.removeClass('rotatorActive last-active');
          });

            };
            };

            //Set Time for Rotation of slide
            rotation = function(){
            play = setInterval(function(){
            //Next slide nav
            $active = $('.contentnav a.active').next();
            rel = $active.attr("rel");



            if ( $active.length === 0) {
            //Move to first slide nav
            $active = $('.contentnav a:first');
            //$activeI = $('#slides IMG:first');
            }

            rotate();
            //Timer speed 5 sec
            }, 7000);
            };

            rotation();
            $(".contentnav a").click(function() {
            $active = $(this);
            clearInterval(play);
            rotate();
            rotation();
            return false;
            });


        <?php } ?>
	});
   	$(document).mouseup(function (e)
   			{
   			    var container = $("#notList");

   			    if (!container.is(e.target) // if the target of the click isn't the container...
   			        && container.has(e.target).length === 0) // ... nor a descendant of the container
   			    {
   			        container.hide();
   			    }
   			});
   	</script>

        <?php if ($_GET['debug'] == 1) : ?>
        <style type="text/css">
            .debug {
                border:1px solid #ff0000;
            }

            .debug2 {
                border:1px solid #ff00DD;
            }

            .debug3 {
                border:1px solid #00ff00;
            }

        </style>
        <?php endif; ?>
    </head>

    <body class="<?php echo $section_name ?> ">
    <script>
        (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
        (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
        m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
        })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

        ga('create', '<?php echo FConfig::getValue('trackingID') ?>', '<?php echo FConfig::getValue('analytics_site_url') ?>');
        ga('send', 'pageview');
    </script>

    <script type="text/javascript">
        var fototeaTracking = {

            trackEnabled: true,

            sendEvent: function(category, action, label, value){
                if (fototeaTracking.trackEnabled == true){
                    if (value){
                        ga('send', 'event', category, action, label, value);
                    } else {
                        ga('send', 'event', category, action, label);
                    }
                }
            }
        };
    </script>

    <div class="wrapper <?php echo $section_name ?>">
        <div class="header-container">
            <div class="header debug2">
                <div class="logo"><a href="<?php echo $defaultLogoLink ?>"><img alt="Fototea" src="images/logo_fototea.png" border="0" title="Fototea" height="39"></a></div>

                <?php if(!$currentUser): ?>
                <div class="header-unregistered">
                    <a class="btn btn-primary btn-lg" href="login">Login</a>
                    <a class="btn btn-alternative btn-lg" href="registro">Registrarse</a>
                </div>
                <?php else: ?>
                <div class="header-user">
                    <ul class="links">
                        <li><span class="header-welcome-msg">Bienvenido</span><a href="<?php echo $defaultLogoLink ?>"><?php echo $currentUser->full_name ?></a></li>
                        <li>
                            <!-- Notificaciones -->
                            <div class="notification-box">
                                <a class="notification-trigger" nohref onclick="jQuery('.notification-box .notification-list').fadeToggle('fast');">
                                    <img id="icon_not" src="images/icon_not.png"/>
                                    <div id="mensajeNot" class="notification-status">
                                        <?php echo count($notList);?>
                                    </div>
                                </a>
                                <?php if(count($notList) > 0):?>
                                    <div id="notList2" class="notification-list" style="display: none;">
                                        <div class="arrow-up"></div>
                                        <ul>
                                            <?php foreach ($notList as $rs_not): ?>
                                                <li>
                                                    <a data-url="<?php echo $rs_not->smart_url ?>" data-id="<?php echo $rs_not->id ?>" onclick="javascript:notAct(this)"><img src="images/icon_notification.png"/><?php echo $rs_not->notificacion ?></a>
                                                </li>
                                            <?php endforeach ?>
                                        </ul>
                                        <!-- TODO limit here -->
                                    </div>
                                <?php endif; ?>
                            </div>
                            <!-- End Notificaciones -->
                        </li>
                        <li>
                            <span class="link-separator">|</span>
                        </li>
                        <li>
                            <a href="<?php echo FConfig::getUrl('signOut') ?>">Salir</a>
                        </li>
                    </ul>
                    <!-- Init Notification form-->
                    <div class="notification-form" style="display: none;">
                        <form id="notification-form" class="notification-form" method="post" action="actions/perfilAction.php">
                            <input type="hidden" name="act" value="notificationAct">
                            <input type="hidden" name="id">
                            <input type="hidden" name="url">
                        </form>
                    </div>
                    <!-- End Notification form-->
                </div>
                <?php  endif ?>

                <div class="header-links">
                    <a class="link" href="contratar">Contratar</a>
                    <span class="link-separator">|</span>
                    <a class="link" href="trabajar">Trabajar</a>
                    <span class="link-separator">|</span>
                    <a class="link" href="faq">FAQ</a>
                </div>
           </div><!-- /header -->
      </div><!-- /header-container -->

        <div class="main-container">
                 

            <?php
            if($session == true){
				$user_code = getUserInfo($_COOKIE['id']);
				$userType = securityValidation($_COOKIE['id']);
				//creativo
				if($userType==1){
?>
            <?php /* <div class="menuContainer">
            <div class="menuUsuario" style="display:none">
            	<div class="left">
            	<div class="menuUsuarioP menufirst menuPBorder">
					<a href="miHome">Home</a>

				</div>
            	<div class="menuUsuarioP  menuPBorder">
					<a href="#">Proyectos</a>
						<div class="menuUsuarioS">
							<div class="menuSBorder"><a href="resultados">Buscar proyecto</a></div>
							<div class="menuSBorder"><a href="misProyectos?filtro=abiertos">Mis proyectos</a></div>
							<!--<div ><a href="misProyectos">Mis propuestas</a></div>-->
						</div>
				</div>
				<div class="menuUsuarioP menuPBorder">
					<a href="#">Cuenta</a>
						<div class="menuUsuarioS">
							<div class="menuSBorder"><a href="perfil?us=<?php echo $user_code['act_code'];?>">Perfil</a></div>

						</div>
				</div>
				<div class="menuUsuarioP menuPBorder">
					<a href="#">Cobro</a>
						<div class="menuUsuarioS">
							<div class="menuSBorder"><a href="cuentaEstado">Estado de cuenta</a></div>
							<div class="menuSBorder"><a href="ctaCobrar">Proyectos por cobrar</a></div>
							<div><a href="ctaFinalizados">Proyectos finalizados</a></div>
						</div>
				</div>
				<div class="menuUsuarioP menuPBorder">
					<a href="#">Invita</a>

				</div>
				<div class="menuUsuarioP">
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
            	<div class="left buscadorContainer">
            	<form action="resultados" method="post">
					<input type="text" id="buscador" name="buscador" class="txt_buscador" autocomplete="off" title="buscador">
					<input type="submit" name="button" id="button" value="Buscar" class="btn_buscador" />
            	</form>
            	</div>
             </div>
             </div> <!-- End menu container -->
            <?php }elseif($userType==2){?>
                   <div class="menuContainer">
            <div class="menuUsuario">
            	<div class="left">
            	<div class="menuUsuarioP menufirst menuPBorder">
					<a href="miHome">Home</a>

				</div>

            	<div class="menuUsuarioP  menuPBorder">
					<a href="#">Proyectos</a>
						<div class="menuUsuarioS">
							<div class="menuSBorder"><a href="agregarProyecto">Agregar proyecto</a></div>
							<div class="menuSBorder"><a href="miHome">Mis proyectos</a></div>
						</div>
				</div>
				<div class="menuUsuarioP menuPBorder">
					<a href="#">Cuenta</a>
						<div class="menuUsuarioS">
							<div class="menuSBorder"><a href="perfil?us=<?php echo $user_code['act_code'];?>">Perfil</a></div>

						</div>
				</div>
				<div class="menuUsuarioP menuPBorder">
					<a href="#">Pagar</a>
						<div class="menuUsuarioS">
							<div class="menuSBorder"><a href="cuentaEstado">Estado de cuenta</a></div>
							<div class="menuSBorder"><a href="ctaPagar">Proyectos por pagar</a></div>
							<div><a href="ctaFinalizados">Proyectos finalizados</a></div>
						</div>
				</div>
				<div class="menuUsuarioP menuPBorder">
					<a href="#">Invita</a>

				</div>
<!--				<div class="menuUsuarioP">-->
<!--					<a href="javascript:notificaciones();"><img id="icon_not" src="images/icon_not.png"/></a>-->
<!--					--><?php
//					$not = listAll("notificaciones"," WHERE user_id = $_COOKIE[id] ORDER BY cdate DESC");
//					$notCount = listAll("notificaciones"," WHERE user_id = $_COOKIE[id] AND leido = 'N'");
//					$countMens = mysql_num_rows($notCount);
//
//	 		 		if($countMens > 0){?>
<!--					<div id="mensajeNot">-->
<!--						<div id="mensajeCont">-->
<!--							<span id="mensNum">--><?php //echo $countMens;?><!--</span>-->
<!--						</div>-->
<!--						<div id="notList">-->
<!--						<img src="images/icon_mark_not.jpg" id="not_mark" />-->
<!--							<ul>-->
<!--								--><?php //while($rs_not = mysql_fetch_object($not)){?>
<!---->
<!--								<li --><?php // if($rs_not->leido == "N"){ echo 'class="bkAzulC"';}?><!--><a href="--><?php //echo $rs_not->url;?><!--" onclick="javascript:notAct(--><?php //echo $rs_not->id;?><!--)"><img src="images/icon_notification.png"/>--><?php //echo $rs_not->notificacion;?><!--</a></li>-->
<!--								--><?php //}?>
<!--							</ul>-->
<!---->
<!--						</div>-->
<!--					</div>-->
<!--					--><?php //} ?>
<!--				</div>-->
          	</div>

             </div>
             </div>*/ ?>

            <?php  }} ?>
                <?php

                    // TODO : esto no es feo, es horrible, sacar el cover a esta seccion */
                    if ($section_name != 'perfil') {
                       // $app->preRender('common/messages');
                        include_once 'views/common/messages.php';
                       // $app->preRender('common/messages');
                    }

                    //$app->preRender($section_name);
                    include_once 'views/'.$section_name.'.php';
                    //$app->postRender($section_name);
                ?>

        </div> <!-- /container -->
         <!-- footer-->
         <?php include_once 'views/common/footer.php'; ?>

    </div><!-- /wrapper -->
    <script type="text/javascript">
        adroll_adv_id = "HZXSOEQPDZFZLKPDWVHKFE";
        adroll_pix_id = "BCKZJADZ7BBB5LWD3VJ5NE";
                

        
        (function () {
            var oldonload = window.onload;
            window.onload = function(){
                __adroll_loaded=true;
                var scr = document.createElement("script");
                var host = (("https:" == document.location.protocol) ? "https://s.adroll.com" : "http://a.adroll.com");
                scr.setAttribute('async', 'true');
                scr.type = "text/javascript";
                scr.src = host + "/j/roundtrip.js";
                ((document.getElementsByTagName('head') || [null])[0] ||
                    document.getElementsByTagName('script')[0].parentNode).appendChild(scr);
                if(oldonload){oldonload()}};
        }());
    </script>
    </body>
</html>

<?php

$app->shutdown();
