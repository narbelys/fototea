<?php
use Fototea\Models\User;
use Fototea\Util\FAnalytics;

$referringUserId = '';
$rm = '';

// Si vendo de referidos
if (isset($_GET['ru']) && isset($_GET['rm'])){
    $ru = $_GET['ru'];
    $rm = $_GET['rm'];

    $referringUserId = getUserId($_GET['ru']);

    // Event = Referidos - Click a url de referido
    $eventData = new stdClass();
    $eventData->referring_id = $referringUserId;
    $eventData->media = $_GET['rm'];
    $events = FAnalytics::getInstance();
    $events->trackEvent('Referidos - Clicks a invitaciones', 'Click a invitación desde '.$rm, $referringUserId);
}

?>


        <!-----------------------------NUEVA MANERA DE REGISTRARSE, ANIMACION COOL ---------------------------------


            <div align="center" id="divAnimado" style=" width:50%; position:absolute; background: #fff  url('images/22.jpg') no-repeat center ; height:700px; border-right:1px solid #ccc; z-index:100">
                    <a id="btn" class="btn btn-primary btn-lg" style=" margin-top: 500px; ">Soy Fotografo</a>
            </div>

            <div align="center" id="divAnimado2" style=" width:50%; margin-left:50%; position:absolute; background: #fff url('images/11.jpg') no-repeat center ; height:700px; border-left:1px solid #ccc; z-index:100">                        
                        <a id="btn2" class="btn btn-alternative btn-lg" style="margin-top: 500px; ">Busco Fotografo</a>
            </div>
        

                      
          -----------------------------FIN NUEVA MANERA DE REGISTRARSE, ANIMACION COOL --------------------------------->      

    <!--   
<div class="content-container">
    <div class="content" style="" id="registroContainer">

          
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-5 contenido-registro">
                <div class="formError bold row" id="formError" style="display:none; margin-top:20px">
                    
                </div>
                    
                <div id="formError" style="display:none;" class='alert alert-danger alert-dismissable'> <?php echo $error;?></div>
                    
                <h2>Registro</h2>
                 <blockquote>
                 <p ><small>Publica eventos, encuentra fot&oacute;grafos, busca nuevos clientes.
                    Todo lo podr&aacute;s hacer en Fototea registr&aacute;ndote gratis. </small></p>
                     <footer>¿Ya tienes una cuenta? <a href="login" class="">Entra</a></footer>
                </blockquote>

                <form action="" method="post" id="formRegistro" class="register-form" style=" ">
                    <div class="row" style="padding-top: 0px; margin-top:0px">
                        <div class="col-sm-4">
                            <div class="form-group row" id="nombre">
                                <label class="control-label">Nombre</label>
                                <input type="text" name="user_name" id="user_name"   class="form-control " title="Nombre" placeholder="Nombre" style="height:20px">
                            </div>
                         </div>
                        <div class="col-sm-4" style="padding-left:50px">
                            <div class="form-group row" id="apellido">
                                <label class="control-label">Apellidos</label>
                                <input type="text" name="user_lastname" id="user_lastname" placeholder="Apellidos" title="Apellidos" class="form-control" style="height:20px">
                            </div>
                         </div>

                    </div>
                     <div class="row" style="padding-top: 0px; margin-top:0px">
                        <div class="col-sm-9" >
                            <div class="form-group row" id="correo">
                                <label class="control-label">Correo Electrónico</label>
                                <input style="height:20px" type="text" name="user_email" id="user_email" placeholder="Correo Electrónico" class="form-control" title="Correo Electrónico">
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-sm-4" >
                            <div class="form-group row" id="contrasenia">
                                <label class="control-label">Contraseña</label>
                                <input style="height:20px" type="password" name="user_password" id="user_password" placeholder="Contraseña" class="form-control" title="Confirmar Contrase&ntilde;a">
                            </div>
                         </div>
                         
                        <div class="col-sm-4" style="padding-left:50px">
                            <div class="form-group row" id="contrasenia2">
                                <label class="control-label">Confirmar Contraseña</label>
                                <input style="height:20px" type="password" name="user_confirm" id="user_confirm" placeholder="Confirmar Contraseña" class="form-control" title="Confirmar Contrase&ntilde;a">
                            </div>
     
                         </div>

                    </div>
                    

                    
                    <div class="form-group row" id="tipo" style="display:none">
                            <input type="radio" name="user_type" value="<?php echo User::USER_TYPE_PHOTOGRAPHER ?>" class="register-radio">
                            <input type="radio" name="user_type" value="<?php echo User::USER_TYPE_CLIENT ?>" class="register-radio">
                    </div>
                    <input type="hidden" id="ru" name="ru" value="<?php echo $referringUserId ?>">
                    <input type="hidden" id="rm" name="rm" value="<?php echo $rm ?>">


 
                  

                    <div class="row" style="padding-top:20px">
                        <center>
                            Al hacer click en reg&iacute;strarte confirmas que has le&iacute;do y aceptas los <br/><a href="terminos" class="opposite-a" target="_blank">T&eacute;rminos Generales y las Condiciones de Contrataci&oacute;n</a>
                        </center>
                    </div>

                    <div class="row" style="padding-top:20px">
                        <center>
                            <a class="btn btn-alternative btn-lg" id="bRegistrar" >Regístrate</a>

                        </center>

                    </div>

                </form>
            </div>
            
            <div class="col-sm-2"></div>
        </div>


    </div>
</div>
    
   --> 
    

    
<div class="width100 divRotator under-header">
    <div id="slides">

        <?php $banner = listAll("banners","ORDER BY orden ASC");
        $i = 1;
        $banner_num = mysql_num_rows($banner);
        while($rs_banner = mysql_fetch_object($banner)){
        ?>

        <div id="d_<?php echo $i;?>" class="rotatorBkContent <?php if($i==1){ echo 'rotatorActive';}?>" style="background:url('banners/<?php echo $rs_banner->img;?>') center no-repeat;">
            <div class="widthPage marginAuto">
                <div class="rotatorContent">
                    <div class="rotatorItem">
                        <div class="rotator-title"><?php echo $rs_banner->titulo ?></div>
                        <div class="rotator-text"><?php echo $rs_banner->texto ?></div>

                        <div class="rotatorBtn"><div class="btn_verde"><a href="<?php echo $app->getHelper('UrlHelper')->getUrl('agregarProyecto'); ?>"  >Publica tu evento. &iexcl;Es gratis!</a></div></div>
                        <div class="rotator-text-bottom">&#191;Quieres m&aacute;s trabajo? <a href="registro" >&iexcl;Reg&iacute;strate como un Creativo!</a></div>
                        <img alt="" src="images/iconRotator.png" class="rotatorIcon">
                    </div>
                </div>
             </div>
        </div>
        <?php $i++; } ?>

        <div class="rotatorNav widthPage marginAuto">
            <div class="contentnav">
                   <!-- links a otros div -->
                        <?php for($i=1;$i<=$banner_num;$i++){?>
                          <a href='#' rel='<?=$i;?>' ><div> </div></a>
                          <?php  } ?>
            </div>
        </div>
    </div>
</div>





<div class="width100 ">
    
    
    <div class="widthPage marginAuto height432">
    <div class="divTipoUser left">
        <div class="divTipoUserTitle alignCenter">&iexcl;Busca un creativo!</div>
        <div class="divTipoUserDesc left">Encuentra fot&oacute;grafos y productores audiovisuales para tus pr&oacute;ximos eventos</div>
        <div class=" divTipoUserIcon left"><img alt="" src="images/icon_buscaCreativo.png" width="200"></div>
        <div class="btn_naranja_round"><a href="login">Publica tu evento. &iexcl;Es gratis!<span>&nbsp;</span></a></div>
    </div>
     <div class="divTipoUser left">
        <div class="divTipoUserTitle alignCenter">&iexcl;S&eacute; un creativo!</div>
        <div class="divTipoUserDesc left">Descubre en tiempo real nuevos eventos, clientes y  proyectos interesantes</div>
        <div class=" divTipoUserIcon left"><img alt="" src="images/icon_creativo.png" width="200"></div>
        <div class="btn_naranja_round"><a href="registro">Reg&iacute;strate como creativo </a></div>
    </div>
    </div>
</div>

<div class="width100 bkCBlanco ">
    <div class="divSteps marginAuto">
        <div class="divStepsTitle">Mejores fotos &nbsp;&nbsp;&nbsp; Mejores videos &nbsp;&nbsp;&nbsp;  M&aacute;s recuerdos</div>
        <div class="divStepsContainer left">
            <div class="left"><img alt="" src="images/icon_monitor1.png"></div>
            <div class="divStepsSubTitle left"><span class="fucsia">Publica</span><br/> tu proyecto</div>
            <div class="step-desc left">Especifica el tipo de evento para el que deseas contratar servicios de fotograf&iacute;a, producci&oacute;n de video o edici&oacute;n</div>
        </div>
        <div class="divStepsContainer left">
            <div class="left"><img alt="" src="images/icon_monitor2.png"></div>
            <div class="divStepsSubTitle left"><span class="fucsia">Selecciona</span><br/> un creativo</div>
            <div class="step-desc left">Compara los portafolios y las ofertas recibidas de los creativos interesados en participar en tu evento o proyecto</div>
        </div>
        <div class="divStepsContainer left">
            <div class="left"><img alt="" src="images/icon_monitor3.png"></div>
            <div class="divStepsSubTitle left"><span class="fucsia">Paga</span><br/> por resultados</div>
            <div class="step-desc left">Libera el pago una vez hayas recibido satisfactoriamente el servicio. ¡Eval&uacute;a al creativo y Fototea!</div>
        </div>
    </div>
</div>
<div class="width100 ">
    <div class="services widthPage marginAuto">
        <div class="title">Un fot&oacute;grafo especial para cada ocasi&oacute;n. Todos en Fototea.</div>
        <div class="carrousel" data-pos="0">
            <a href="#" class="carrousel_right right_inactive"></a>
            <div class="carrousel_inner">
                <ul>
                    <li><img src="images/Bodas.jpg" width="233px" height="233px"/><div>Bodas</div></li>
                    <li><img src="images/Catalogo.jpg" width="233px" height="233px"/><div>Catálogo</div></li>
                    <li><img src="images/Comida.jpg" width="233px" height="233px"/><div>Comida</div></li>
                    <li><img src="images/Compromisos.jpg" width="233px" height="233px"/><div>Compromisos</div></li>
                    <li><img src="images/Corporativo.jpg" width="233px" height="233px"/><div>Corporativo</div></li>
                    <li><img src="images/E-commerce.jpg" width="233x" height="233px"/><div>E-commerce</div></li>
                    <li><img src="images/Embarazos.jpg" width="233px" height="233px"/><div>Embarazos</div></li>
                    <li><img src="images/Eventos.jpg" width="233px" height="233px"/><div>Eventos</div></li>
                    <li><img src="images/Familia.jpg" width="233px" height="233px"/><div>Familia</div></li>
                    <li><img src="images/Fiestas.jpg" width="233px" height="233px"/><div>Fiestas</div></li>
                    <li><img src="images/Hosteleria.jpg" width="233px" height="233px"/><div>Hostelería</div></li>
                    <li><img src="images/Inmobiliario.jpg" width="233x" height="233px"/><div>Inmobiliario</div></li>
                    <li><img src="images/Mascotas.jpg" width="233px" height="233px"/><div>Mascotas</div></li>
                    <li><img src="images/Modelaje.jpg" width="233x" height="233px"/><div>Modelaje</div></li>
                    <li><img src="images/Ninos.jpg" width="233px" height="233px"/><div>Niños</div></li>
                    <li><img src="images/Retratos.jpg" width="233x" height="233px"/><div>Retratos</div></li>
                </ul>
            </div>
            <a href="#" class="carrousel_left"></a>
        </div>
    </div>
</div>
