/* onLoad Actions */

$(document).ready(function() {
	$('#privacidad').click( function() {
	box("privacidad.html", "400","400");
	} );
	
	$('#btn_img').click( function() {
	saveEmail();
	} );
	
	
	$("#email").click(function() {
	$("#email").val("");
	});
	
	$("#email").blur(function() {
	if ($("#email").val() == ""){
	$("#email").val("Correo Electrónico");
	}
	});
	
	$('input:radio[name=typeUser]')[0].checked = true;
});
 


	

/*Functions*/

function saveEmail(){
	if($('#email').val() != "Correo Electrónico"){
	$.ajax({
			type: 'get',
			dataType: 'json',
			url: 'saveEmail.php',
			data: {email:$("#email").val(),interest:$('input:radio[name=typeUser]:checked').val()},
			success: function(json){
				//funcion para llenar los datos del detalle
					$("#box").html("<p>¡Muchas gracias por registrarte con nosotros! Muy pronto serás el primero en descubrir la nueva conexión entre fotógrafos y clientes. Si quieres saber más, consíguenos en nuestro Facebook <a href='https://www.facebook.com/Fototea' target = '_blank'>https://www.facebook.com/Fototea</a>.<br /><a href='https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fwww.fototea.com' target='_blank'>Compartir en Facebook</a></p>");
			}
	});
	}
}

/* Alert Box */
function box(urlLoad,width,height){
		$contWidth = width;
		$contHeight = height;
		$contLeft = ($contWidth / 2)*(-1);
		$contTop = ($contHeight / 2)*(-1);
		$closeLeft = ($contLeft + 10)*(-1);
		$closeTop = $contTop + 10;
		$('body').append('<div id="boxAlert"><div id="boxCont"></div></div>');
		$('#boxCont').css("margin-top", $contTop);
		$('#boxCont').css("margin-left", $contLeft);
		$('#boxCont').css("width", $contWidth);
		$('#boxCont').css("height", $contHeight);
		$('#boxCont').load(urlLoad);
		$('#boxCont').after('<div id="boxClose"></div>');
		$('#boxClose').attr("onClick","closeBox()");
		$('#boxClose').css("margin-top", $closeTop);
		$('#boxClose').css("margin-left", $closeLeft);
		$("#boxAlert").fadeIn("slow");
}

function closeBox(){
	$('#boxAlert').remove();
}
/* end Alert Box*/



function txtBoxClick(){
	$("#email").removeClass('txt_buscar');
	$("#email").addClass("txt_buscar-act");
}
	
function txtBoxBlur(){
	
	if($("#email").val() == ""){ 
	$("#email").removeClass('txt_buscar-act');
	$("#email").addClass("txt_buscar");
	}
}

/* end functions */