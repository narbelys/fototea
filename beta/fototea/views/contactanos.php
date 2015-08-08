<script>
$(document).ready(function() {
	
	
	
    $( "#bContacto" ).click(function() {
         $("#formContacto").submit();
    });

    $("#formContacto").validate({
    
        // Specify the validation rules
        rules: {
            txt_name: {
                required: true,
            },
            txt_email: {
                required: true,
                email: true
            },
            txt_asunto: {
                required: true,
            },
            
            txt_mensaje: {
                required: true,
            },
                     

        },
        
        // Specify the validation error messages
        messages: {
            txt_name: "Introduzca su nombre",
            txt_email: "Introduzca su corre",
            txt_asunto: "Introduzca un asunto",
            txt_mensaje: "Introduzca un mensaje",

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
        
        


	$("#formContacto").submit(function(){
		$("#formError").html("");
		var error = 0;

		
		if(error == 0){
			$.ajax({
				type: 'get',
				dataType: 'json',
				url: 'actions/contactoAction.php',
				data: {email:$("#txt_email").val(),name:$("#txt_name").val(),asunto:$("#txt_asunto").val(),mensaje:$("#txt_mensaje").val()},
				success: function(json){
					//funcion para llenar los datos del detalle
						$("#registroContainer").html("<h2>Contacto Fototea</h2><p>&#33;Muchas gracias por ponerte en contacto con nosotros! <br><br> Hemos recibido tu consulta, nuestro equipo la evaluara y te dara respuesta lo mas pronto posible.<br><br> Si quieres saber m&aacute;s, s&iacute;guenos en nuestro <a href='https://www.facebook.com/Fototea' target = '_blank' class='txtAzul bold'>Facebook</a>.</p>");
				}
		});
		}
			return false;
		});
	
}); // cierre de document 


</script>

<div class="content-container">
    <div class="content" style="width: 50%;" id="registroContainer">
        <div class="row">
            <div class="col-sm-2"></div>
            <div class="col-sm-8">
                    <h2>Contacto Fototea</h2>
                <blockquote>
                    <p>Envíanos las preguntas o sugerencias que tengas</p>
                </blockquote>
                
                
                <form action="" method="post" id="formContacto">
                    <div class="form-group" id="nombre">
                        <label class="control-label required-after">Nombre</label>
                        <input type="text" name="txt_name" id="txt_name"   class="form-control " title="Nombre" placeholder="Nombre">
                    </div>
                 <div class="form-group" id="correo">
                        <label class="control-label required-after">Correo Electrónico</label>
                        <input type="text" name="txt_email" id="txt_email" placeholder="Correo Electrónico" class="form-control" title="Correo Electrónico">
                    </div>
                    
                    <div class="form-group" id="apellido">
                        <label class="control-label required-after">Asunto</label>
                        <input type="text" name="txt_asunto" id="txt_asunto" placeholder="Asunto" title="Asunto" class="form-control">
                    </div>
                    
                    <div class="form-group">
                         <label class="control-label required-after">Mensaje</label>
                         <textarea name="txt_mensaje" id="txt_mensaje" class="form-control" rows="3" placeholder="Mensaje" title="Mensaje"></textarea>
                    </div>
   



                    <div class="form-group">
                        <p><b class="obligatorio">*</b> Campos requeridos</p>
                    </div>
                    <div class="formError bold" id="formError" style="display:none; margin-top:20px">
                        <?php echo $error;?>
                    </div>


                    <div class="row" style="padding-top:20px">
                        <center>
                            <a class="btn btn-primary" id="bContacto" >Enviar</a>

                        </center>

                    </div>


                </form>



            </div>
            <div class="col-sm-2"></div>
        </div>
    </div>
</div>
                
                