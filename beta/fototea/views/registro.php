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


        <!-----------------------------NUEVA MANERA DE REGISTRARSE, ANIMACION COOL --------------------------------->
        

            <div align="center" id="divAnimado" style="background: #fff url('images/22.jpg') no-repeat center ; ">
                    <a id="btn" class="btn btn-primary btn-lg">Soy Fotógrafo</a>
            </div>

            <div align="center" id="divAnimado2" style="background: #fff url('images/11.jpg') no-repeat center ; ">                        
                        <a id="btn2" class="btn btn-alternative btn-lg" >Busco Fotógrafo</a>
            </div>
        

                      
          <!-----------------------------FIN NUEVA MANERA DE REGISTRARSE, ANIMACION COOL --------------------------------->      

          
<div class="content-container register">
    <div class="content" style="" id="registroContainer" >

          
        <div class="row content-row" >
            <div class="col-sm-3"></div>
            <div class="col-sm-6 contenido-registro">
                    
                <div id="formError" style="display:none;"> <?php echo $error;?></div>
                    
                <h2>Registro</h2>
                 <blockquote>
                 <p class="register-message"><small>Publica eventos y encuentra fot&oacute;grafos.
                    Todo lo podr&aacute;s hacer en Fototea registr&aacute;ndote gratis.
                         ¿Ya tienes una cuenta? <a href="login" class="">Entra</a></small></p>
                </blockquote>

                <form action="" method="post" id="formRegistro" class="register-form">
                    <div class="form-row">
                        <div class="col-sm-6 input-ini">
                            <div class="row" id="nombre">
                                <label class="control-label">Nombre</label>
                                <input type="text" name="user_name" id="user_name"   class="form-control " title="Nombre" placeholder="Nombre">
                            </div>
                         </div>
                        <div class="col-sm-6 input-left" >

                            <div class="row" id="apellido">
                                <label class="control-label">Apellidos</label>
                                <input type="text" name="user_lastname" id="user_lastname" placeholder="Apellidos" title="Apellidos" class="form-control" >
                            </div>
                         </div>

                    </div>
                     <div class="form-row" >
                        <div class="col-sm-12" >
                            <div class="form-group row" id="correo">
                                <label class="control-label">Correo Electrónico</label>
                                <input  type="text" name="user_email" id="user_email" placeholder="Correo Electrónico" class="form-control" title="Correo Electrónico">
                            </div>
                        </div>
                    </div>

                    
                    <div class="form-row clearfix" >
                        <div class="col-sm-6 input-ini" >
                            <div class="row" id="contrasenia">
                                <label class="control-label">Contraseña</label>
                                <input type="password" name="user_password" id="user_password" placeholder="Contraseña" class="form-control" title="Confirmar Contrase&ntilde;a">
                            </div>
                         </div>
                         

                        <div class="col-sm-6 input-left">
                            <div class="row" id="contrasenia2">
                                <label class="control-label">Confirmar Contraseña</label>
                                <input  type="password" name="user_confirm" id="user_confirm" placeholder="Confirmar Contraseña" class="form-control" title="Confirmar Contrase&ntilde;a">
                            </div>
     
                         </div>

                    </div>
                    

                    
                    <div class="form-row" id="tipo" style="display:none;">

                            <input type="radio" name="user_type" value="<?php echo User::USER_TYPE_PHOTOGRAPHER ?>" class="register-radio">
                            <input type="radio" name="user_type" value="<?php echo User::USER_TYPE_CLIENT ?>" class="register-radio">
                    </div>
                    <input type="hidden" id="ru" name="ru" value="<?php echo $referringUserId ?>">
                    <input type="hidden" id="rm" name="rm" value="<?php echo $rm ?>">

                    <div class="form-row terms">
                        <center>
                            Al hacer click en reg&iacute;strarte confirmas que has le&iacute;do y aceptas los <br/><a href="terminos" class="opposite-a" target="_blank">T&eacute;rminos Generales y las Condiciones de Contrataci&oacute;n</a>
                        </center>
                    </div>

                    <div class="row" style="padding:20px 0">
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


<!--
<div class="content-container">
    <div class="content" style="width: 50%;" id="registroContainer">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                    <h2>Registro</h2>
                <p>¿Ya tienes una cuenta? <a href="login" class="">Entra</a>
                </p>
                <blockquote>
                    <p>Publica eventos, encuentra fot&oacute;grafos, busca nuevos clientes. Todo lo podr&aacute;s hacer en Fototea registr&aacute;ndote gratis.</p>
                </blockquote>
                <form action="" method="post" id="formRegistro" class="register-form">
                    <div class="form-group row" id="nombre">
                        <label class="control-label required-after">Nombre</label>
                        <input type="text" name="user_name" id="user_name"   class="form-control " title="Nombre" placeholder="Nombre">
                    </div>
                    <div class="form-group row" id="apellido">
                        <label class="control-label required-after">Apellidos</label>
                        <input type="text" name="user_lastname" id="user_lastname" placeholder="Apellidos" title="Apellidos" class="form-control">
                    </div>
                    <div class="form-group row" id="correo">
                        <label class="control-label required-after">Correo Electrónico</label>
                        <input type="text" name="user_email" id="user_email" placeholder="Correo Electrónico" class="form-control" title="Correo Electrónico">
                    </div>
                    <div class="form-group row" id="contrasenia">
                        <label class="control-label required-after">Contraseña</label>
                        <input type="password" name="user_password" id="user_password" placeholder="Contraseña" class="form-control" title="Confirmar Contrase&ntilde;a">
                    </div>
                    <div class="form-group row" id="contrasenia2">
                        <label class="control-label required-after">Confirmar Contraseña</label>
                        <input type="password" name="user_confirm" id="user_confirm" placeholder="Confirmar Contraseña" class="form-control" title="Confirmar Contrase&ntilde;a">
                    </div>
                    <div class="form-group row" id="tipo">
                        <label class="control-label required-after">Tipo de usuario</label>&nbsp;&nbsp;
                        <label>
                            <input type="radio" name="user_type" value="<?php echo User::USER_TYPE_PHOTOGRAPHER ?>" class="register-radio" checked>Creativo
                        </label>
                        <label>
                            <input type="radio" name="user_type" value="<?php echo User::USER_TYPE_CLIENT ?>" class="register-radio" checked>Cliente
                        </label>
                    </div>
                    <input type="hidden" id="ru" name="ru" value="<?php echo $referringUserId ?>">
                    <input type="hidden" id="rm" name="rm" value="<?php echo $rm ?>">

                    <div class="form-group">
                        <p><b class="obligatorio">*</b> Campos requeridos</p>
                    </div>
                    <div class="formError bold row" id="formError" style="display:none; margin-top:20px">
                        <?php echo $error;?>
                    </div>

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
                    <div class="row" style="padding-top:20px">
                        <center>
                            <p>¿Ya tienes una cuenta? <a href="login">Entra aqu&iacute;</a>
                            </p>
                        </center>
                    </div>

                </form>



            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</div>
                
-->

<script>
    $(document).ready(function() {
       
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
        
        /*
        
        $('input:radio[name=user_type]')[0].checked = true;*/

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
                            //$("#correo").append("<span class='glyphicon glyphicon-remove form-control-feedback'></span>");
                            //$("#formError").append("<div class='alert alert-danger '> Su dirección de correo electrónico ya ha sido registrada en Fototea, intente ingresando una diferente </p>");
                            //$("#formError").slideDown('slow');
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
//{email:$("#user_email").val(),userType:$('input:radio[name=user_type]:checked').val(),name:$("#user_name").val(),lastname:$("#user_lastname").val(),pass:$("#user_password").val()},
                                        {email:$("#user_email").val(),userType:$('input:radio[name=user_type]:checked').val(),name:$("#user_name").val(),lastname:$("#user_lastname").val(),pass:$("#user_password").val(), ru: $('#ru').val(), rm: $('#rm').val() },
                    success: function(json){
                        //funcion para llenar los datos del detalle
                        $(".contenido-registro").html("<div><h2 class='main-title'>Registro</h2><p>¡Muchas gracias por registrarte con nosotros! En los pr&oacute;ximos minutos recibir&aacute;s un correo de confirmaci&oacute;n.<br><br> Si quieres saber m&aacute;s, s&iacute;guenos en nuestro <a href='https://www.facebook.com/Fototea' target = '_blank' class='txtAzul bold'>Facebook</a>.</p></div>");
                    }
                });
            }
            return false;});
            
            
            
         //--------------------------------------------ANIMACION DE REGISTRO---------------------------------------------               
                $('#divAnimado').hover( 
                    function () {
                        //$("#btn2").css('display', 'none'); 
                        //$("#btn").show(800); 
                        
                        //$('#divAnimado').css('background', ' #fff url("images/2.jpg") no-repeat center')
                    }, 
                    function () { 
                         //$("#btn").css('display', '');
                      //  $("#btn").hide("fast"); 
                       
                        //$('#divAnimado').css('background', ' #fff url("images/22.jpg") no-repeat center')
                    } ); 
                $('#divAnimado2').hover( 
                    function () { 
                        //$("#btn2").show(800); 
                       // $("#btn2").css('display', '');
                        //$('#divAnimado2').css('background', ' #fff url("images/1.jpg") no-repeat center')
                    }, 
                    function () { 
                        //$('#divAnimado2').css('background', '#fff url("images/11.jpg") no-repeat center')
                       // $("#btn2").hide("fast"); 
                        // $("#btn2").css('display', 'none');
                    } ); 

                $( "#btn" ).click(
                    function() {
                        var speed = 1200;
                        var easing = 'easeOutQuart';

                        $('#divAnimado').unbind("mouseenter mouseleave");
                       // $("#btn").hide("fast"); 
                        $('#divAnimado2').unbind("mouseenter mouseleave");
                        //$("#btn2").hide("fast"); 
                        $('#divAnimado2').css('background', '#fff url("images/1.jpg") no-repeat center')
                        $('#divAnimado').css('background', ' #fff url("images/22.jpg") no-repeat center')

                        $('input:radio[name=user_type][value=1]').prop( "checked", true );

                        $('#divAnimado').animate({ 'margin-left':'-25%' },speed, easing);
                        $('#divAnimado2').animate({ 'margin-left':'75%' },speed, easing);
                        $('.registro').css('overflow-x', 'hidden');
                        $('h2').replaceWith('<h2>Registro fotógrafo</h2>');
                        $('.register-message').replaceWith('<p class="register-message"><small>Busca nuevos clientes. Todo lo podr&aacute;s hacer en Fototea registr&aacute;ndote gratis. ¿Ya tienes una cuenta? <a href="login" class="">Entra</a></small></p>');
                        $('#btn').animate({ 'margin-left':'50%' },1000);
                        $('#btn2').animate({ 'margin-right':'50%' },1000);
                    }); 
                $( "#btn2" ).click(
                    function() { 
                         $('#divAnimado').unbind("mouseenter mouseleave");
                        //$("#btn").hide("fast"); 
                        $('#divAnimado2').unbind("mouseenter mouseleave");
                        //$("#btn2").hide("fast");
                        $('#divAnimado2').css('background', '#fff url("images/11.jpg") no-repeat center')
                        $('#divAnimado').css('background', ' #fff url("images/2.jpg") no-repeat center') 
                        
                        $('input:radio[name=user_type][value=2]').prop( "checked", true );
                        $('#divAnimado').animate({ 'margin-left':'-25%' },1000); 
                        $('#divAnimado2').animate({ 'margin-left':'75%' },1000);
                        $('.registro').css('overflow-x', 'hidden');
                        $('h2').replaceWith('<h2>Registro cliente</h2>');
                        $('.register-message').replaceWith('<p class="register-message"><small>Publica eventos y encuentra fot&oacute;grafos. Todo lo podr&aacute;s hacer en Fototea registr&aacute;ndote gratis. ¿Ya tienes una cuenta? <a href="login" class="">Entra</a></small></p>');
                        $('#btn').animate({ 'margin-left':'50%' },1000);
                        $('#btn2').animate({ 'margin-right':'50%' },1000);
                    }); 
                    
                     
                      

               // $("#btn").hide("fast");
            //    $("#btn2").hide("fast");

        var preselectedUserType = '<?php echo $app->getRequest()->get('user_type') ?>';

        if(preselectedUserType && preselectedUserType == 1){
            $("#btn").trigger('click');
        } else if(preselectedUserType && preselectedUserType == 2){
            $("#btn2").trigger('click');
        }
        
        //----------------------------------------FIN ANIMACION DE REGISTRO----------------------------------------------

    }); // cierre de document
</script>