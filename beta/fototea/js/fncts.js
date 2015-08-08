function messages(to,pro_id){
	
	
	$('.wrapper').before('<div id="modal"><div id="mensajes"><div id="contentMensaje">&nbsp;</div></div></div>');
	$("#contentMensaje").load("/beta/fototea/mensajesCrear #mensajesCrear", {data_to: to,data_proid:pro_id});
	$("#modal").fadeIn();
	
	
}


function closeModal(){
	$("#modal").fadeOut("slow",function() {
		$('#modal').remove();
	});
}

function sendMessage(){
	$("#error").html("");
	var error = 0;
	if($("#m_mensaje").val() == ""){
		$("#error").append("- Recuerde ingresar su mensaje<br>");
		error++;
	}
	if($("#m_subject").val() == ""){
		$("#error").append("- Recuerde ingresar el asunto<br>");
		error++;
	}
	if(error == 0){
		
		$.ajax({
			type: 'get',
			dataType: 'json',
			url: 'actions/mensajesAction.php',
			data: {mensaje:$("#m_mensaje").val(),to:$("#to").val(),subject:$("#m_subject").val(),act:"nuevoMensaje",pro_id:$("#pro_id").val()},
			success: function(json){
				//funcion para llenar los datos del detalle
				$("#formMensajes").html("Se ha enviado tu mensaje con éxito");
			}
		});
	}
	
	
}

function deleteMensaje(mensaje){
	$("#mens_"+mensaje).slideUp('fast');
	$.ajax({
		type: 'get',
		dataType: 'json',
		url: 'actions/mensajesAction.php',
		data: {mensaje_id:mensaje,act:"borrarMensaje"},
		success: function(json){
			//funcion para llenar los datos del detalle
			
		}
	});
}

function verMensaje(mensaje){
	window.location="verMensaje?i="+mensaje;
}

function replayMessage(id,to,from){
	if($("#m_replay").val() != ""){
		
		$.ajax({
			type: 'get',
			dataType: 'json',
			url: 'actions/mensajesAction.php',
			data: {mensaje:$("#m_replay").val(),m_to:to,m_from:from,act:"replayMensaje",m_id:id},
			success: function(json){
				//funcion para llenar los datos del detalle
				$("#m_replay").val("");
				$("#msnCont").load("/beta/fototea/verMensaje?i="+id+" #msnList");
			}
		});
	}

}



function verFoto(page,album,container){

//    if (container == undefined){
//        container = '';
//    } else {
//        container = container + ' .';
//    }

	var next;
	var prev;
	var count = $("." + container + " .container_list_img").length;
	
	if(page + 1 <= count){
		next = page + 1;
	}else{
		next = 1;
	}
	
	if(page - 1 <= 0){
		prev = count;
	}else{
		prev = page - 1;
	}
	
	
	$.ajax({
		type: 'get',
		dataType: 'json',
		url: 'actions/albumAction.php',
		data: {a_id:album,foto:page,act:"buscarFoto"},
		success: function(json){
			$('.wrapper').before('<div id="modal"><div id="mensajes"><div id="contentAlbum"><div id="modalClose" onclick="javascript:closeModal();"><img alt="Cerrar" title="Cerrar" src="images/close.png"></div></div></div></div>');
			$("#contentAlbum").append('<div id="img_prev" onclick="javascript:changeImg('+prev+','+album+',\''+container+'\')"><img src="images/arrow-left.png"/></div>');
			$("#contentAlbum").append('<div id="img_next" onclick="javascript:changeImg('+next+','+album+',\''+container+'\')"><img src="images/arrow-right.png"/></div>');
			$("#contentAlbum").append('<div id="albumImg" oncontextmenu="return false" ondragstart="return false" onmousedown="return false" onselectstart="return false"><img src="' + json[0]['img'] + '" /></div>');
			$("#modal").fadeIn();
	}
		});
}

function deleteImg(img,album){
	var div = "img_" + img;
	
	$.ajax({
		type: 'get',
		dataType: 'json',
		url: 'actions/albumAction.php',
		data: {a_id:album,ad_id:img,act:"borrarfoto"},
		success: function(json){
			$("#"+div).fadeOut("slow");
	}
		});
	
}

function changeImg(page,album,container){

	var next;
	var prev;
	var count = $("." + container + " .container_list_img").length;
	
	if(page + 1 <= count){
		next = page + 1;
	}else{
		next = 1;
	}
	
	if(page - 1 <= 0){
		prev = count;
	}else{
		prev = page - 1;
	}
	
	$.ajax({
		type: 'get',
		dataType: 'json',
		url: 'actions/albumAction.php',
		data: {a_id:album,foto:page,act:"buscarFoto"},
		success: function(json){
			$("#albumImg").html('<img src="' + json[0]['img'] + '" />');
			$(".imgTxt").html(json[0]['desc']);
			$("#img_prev").attr("onClick","changeImg("+prev+","+album+",'"+container+"')");
			$("#img_next").attr("onClick","changeImg("+next+","+album+",'"+container+"')");
	}
		});
	
}

function editOferta(bid,id){
	
	
	$("#bid"+id).html('<input type="text" id="bid_txt" value="'+bid+'" maxlenght="6" onblur="javascript:saveOferta(this,'+id+')" />');
	$("#bid_txt").focus();
	
}

function saveOferta(txt,id){
	
	
	$("#bid_txt").attr("disabled", "disabled"); 
	$("#bid_txt").attr("readonly"); 
	
	$.ajax({
		type: 'get',
		dataType: 'json',
		url: 'actions/proyectosAction.php',
		data: {o_id:id,bid:txt.value,act:"upt_bid"},
		success: function(json){
				$("#bid"+id).html('<span class="txtAzul font12 editOferta" title="Editar monto de la oferta" onclick="javascript:editOferta('+txt.value+','+id+');">Click para editar el monto</span><br><span class="editOferta" title="Editar monto de la oferta" onclick="javascript:editOferta('+txt.value+','+id+');" >'+'$ '+number_format(txt.value)+'</span>');
		}
	});
}

//number format
function number_format(nStr){
	nStr += '';
	x = nStr.split('.');
	x1 = x[0];
	x2 = x.length > 1 ? '.' + x[1] : '';
	var rgx = /(\d+)(\d{3})/;
	while (rgx.test(x1)) {
	x1 = x1.replace(rgx, '$1' + ',' + '$2');
	}
	return x1 + x2;
}


function categoriesPro(txt){
	var tp = txt.value;
	$(".catFotosCont").fadeIn();
	
	if(tp =="1"){
		$("#catVideos").hide();
		$("#catFotos").show();
	}else if(tp == "2"){
		$("#catVideos").show();
		$("#catFotos").hide();
	}else{
		$("#catVideos").hide();
		$("#catFotos").hide();
		$(".catFotosCont").fadeOut();
	}
	
}

function showComments(ofertaId){
	
	if ($("#comments_"+ofertaId).css('display') == 'none') {
		$("#comments_"+ofertaId).slideDown();
		$("#btnComment_"+ofertaId).html("- Mensajes");
	}else{
		$("#btnComment_"+ofertaId).html("+ Mensajes");
		$("#comments_"+ofertaId).slideUp();
	
	}
}

function sendComment(id,pro_id){
    $( "#bComentar_btn" ).html("Cargando...");
    $( "#bComentar_btn" ).addClass("disabled");	
	var txt = $("#comentarioTxt"+id).val();
	
	if(txt == "" || txt.lenght < 4){
		alert("Recuerde ingresar su mensaje");
		return false;
	}else{
		$("#comentarioTxt"+id).val("");
		$.ajax({
			type: 'get',
			dataType: 'json',
			url: 'actions/proyectosAction.php',
			data: {o_id:id,comment:txt,act:"comentarioOferta"},
			success: function(json){
                $( "#bComentar_btn" ).html("Enviar");
                $( "#bComentar_btn" ).removeClass("disabled");
				$("#comments_"+id+" #comentariosListCont").load("/beta/fototea/proyecto?id="+pro_id+" #comments_"+id+" #comentariosListCont #listCont");
			console.log("aqui");
			}
		});
	}
	
}


function valueDef(inputId,txt){
	
	if($("#"+inputId).val() == txt){
		$("#"+inputId).val("");
		
	}else if($("#"+inputId).val() == ""){
		$("#"+inputId).val(txt);
	}
}

function notificaciones(){
    $('#notList').fadeToggle('fast');
//	if ($('#notList').is(':visible')){
//		$("#notList").hide();
//	}
//
//	if ($('#notList').is(':hidden')){
//		$("#notList").show();
//	}
}

function notAct(elem){
    var notificationId = jQuery(elem).attr('data-id');
    var notificationUrl = jQuery(elem).attr('data-url');
    jQuery('#notification-form input[name=id]').val(notificationId);
    jQuery('#notification-form input[name=url]').val(notificationUrl);
    jQuery('#notification-form').submit();
}

function refreshPrincipal(photo){
    jQuery('.dz-principal-message').each(function(){
        jQuery(this).remove();
    });
    jQuery('.dz-principal').show();
    jQuery('.dz-principal-' + photo).hide();
    jQuery('.dz-principal-' + photo).after("<span class='dz-principal-message'>Principal</span>");
}

function removeExperience(elem){
    jQuery(elem).parent().remove();
}

function addProfileField(field, locationClass, value1, value2){
    if (!field){
        return;
    }
    if (!locationClass){
        return;
    }
    if (!value1){
        value1 = '';
    }
    if (!value2){
        value2 = '';
    }

    switch (field){
        case "user_camara":
            var html = "<div class='camara-block'><input type='text' name=user_camara[] placeholder='Cámara' class='form-control multiple-field' value='" + value1 + "' >";
            break;
        case "user_lentes":
            var html = "<div class='lentes-block'><input type='text' name=user_lentes[] placeholder='Lentes' class='form-control multiple-field' value='" + value1 + "' >";
            break;
        case "user_equipo":
            var html = "<div class='equipo-block'><input type='text' name=user_equipo[] placeholder='Equipo general' class='form-control multiple-field' value='" + value1 + "' >";
            break;
        case "user_laboral_experience":
            var html = "<div class='experience-block form-inline'><input type='text' name=user_experience_empresa[] placeholder='Empresa/Proyecto' class='form-control multiple-field' value='" + value1 + "' >" +
                "<input type='text' name=user_experience_localidad[] placeholder='Localidad' class='form-control multiple-field' value='" + value2 + "' >";
            break;
        case "user_habilidades":
            var html = "<div class='habilidades-block'><input type='text' name=user_habilidades[] placeholder='Habilidades' class='form-control multiple-field' value='" + value1 + "' >";
            break;
        case "user_idiomas":
            var html = "<div class='idiomas-block'><input type='text' name=user_idiomas[] placeholder='Idioma' class='form-control multiple-field' value='" + value1 + "' >";
            break;
    }

    html += "<a class='multiple-field-remove new' id='multiple-field-remove' onclick='removeProfileField(this);'></a></div>";
    jQuery('.' + locationClass).append(html);
}

function removeProfileField(elem){
    jQuery(elem).parent().remove();
}

function toggleEditPassword(){
    var container = jQuery('.edit-password-container');
    var toggle = jQuery('.edit-password-container .toggle i');
    var buttons = jQuery('.edit-password-container .buttons');

    if (jQuery(buttons).hasClass('extended')){
        jQuery(toggle).removeClass('glyphicon-minus');
        jQuery(toggle).addClass('glyphicon-plus');
        jQuery(buttons).removeClass('extended').hide();
        jQuery(buttons).find('input').each(function(){
            jQuery(this).val('');
        });
    } else {
        jQuery(toggle).removeClass('glyphicon-plus');
        jQuery(toggle).addClass('glyphicon-minus');
        jQuery(buttons).addClass('extended').show();
    }
}