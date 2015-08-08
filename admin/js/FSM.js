// JavaScript Document
// Funciones de JavaScripts By SharkamMahal.com


function textboxValue(id,value){

	textbox = document.getElementById(id);
	textValue = value;
	
	
	if (textbox.value == textValue){
		
		textbox.value = "";
	
	}else if (textbox.value == ""){
		textbox.value = textValue;
	}
	
}
//function end

function textboxValPass(id,value){

	textbox = document.getElementById(id);
	textValue = value;
	
	
	if (textbox.value == textValue){
		
		textbox.value = "";
		textbox.type="password";
	}else if (textbox.value == ""){
		textbox.value = textValue;
		textbox.type="text";
	}
	
}
//function end
var nav4 = window.Event ? true : false;

//--------------------------------------------------------------------------------
function acceptNum(evt)
// Se llama con : onKeyPress="return acceptNum(event)"	
{	
	// NOTE: Backspace = 8, Enter = 13, '0' = 48, '9' = 57	
	var key = nav4 ? evt.which : evt.keyCode;	
	return (key <= 13 || (key >= 47 && key <= 57) || (key == 46) || (key == 45));
}
//--------------------------------------------------------------------------------
function validarEmailNecesario(field)
// Se llama con : onBlur="validarEmailNecesario(this);"
// No pasa hasta que no teclea una direccion correcta
{
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(field.value)){

  } else {
    alert("Error, por favor ingrese una dirección de correo electronico valida!");
	field.focus();
	field.value="";
  }
}

//--------------------------------------------------------------------------------
function validarEmail(field)
// Se llama con : onChange="validarEmail(this);"
// Solo valida la direccion de correo, permite en blanco
{
  if (/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test(field.value)){

  } else {
   
	//document.getElementById('errores').innerHTML = "Error, debe ingresar una direccion de correo electronico valida<br />";
	window.alert("Debes ingresar una dirección de correo válida");
	document.getElementById(field).value="";
	document.getElementById(field).focus();
  }
}

//--------------------------------------------------------------------------------
function acceptLetters(field)
// Se llama con : onChange=" return acceptLetters(this);"
{
var str = field.value;
if (str == "") {
alert("\nError, el campo está vacío.\n\nPor favor, debes teclear algún valor.")
field.focus();
return false;
}
for (var i = 0; i < str.length; i++) {
var ch = str.substring(i, i + 1);
if (((ch < "a" || "z" < ch) && (ch < "A" || "Z" < ch)) && ch != ' ') 
{
alert("\nEste campo solo acepta letras y espacios.\n\nPor favor, teclee los datos correctos.");
field.select();
field.focus();
return false;
   }
}
return true;
}		

//--------------------------------------------------------------------------------
function acceptLettersNoBlank(field)
// Se llama con : onChange=" return acceptLettersNoBlank(this);"
{
var str = field.value;
for (var i = 0; i < str.length; i++) {
var ch = str.substring(i, i + 1);
if (((ch < "a" || "z" < ch) && (ch < "A" || "Z" < ch))) 
{
alert("\nEste campo solo acepta letras (sin espacios).\n\nPor favor, teclee los datos correctos.");
field.select();
field.focus();
return false;
   }
}
return true;
}
//-------------------------------------------------------------------------------
		function autoC(id){
				$('#cod' + id).autocomplete({
					source : 'prods.php',
					minLength : 2,
					select : function(event, ui) {
						$.getJSON("prods_detail.php", {							
							label : ui.item.value
						}, function(data) {
							$("#desc" + id).val(data[0]['description']);
							$("#cant" + id).val(data[0]['quantity']);
							$("#precio" + id).val(data[0]['price']);
							$("#total" + id).val(data[0]['quantity']*data[0]['price']);
							totalCalc();
						});
					}
				}); }

//-------------------------------------------------------------------------------
		function autoD(id){
				$('#desc' + id).autocomplete({
					source : 'prods2.php',
					minLength : 2,
					select : function(event, ui) {
						$.getJSON("prods_detail2.php", {							
							label : ui.item.value
						}, function(data) {
							$("#cod" + id).val(data[0]['code']);
							$("#cant" + id).val(data[0]['quantity']);
							$("#precio" + id).val(data[0]['price']);
							$("#total" + id).val(data[0]['quantity']*data[0]['price']);
							totalCalc();
						});
					}
				}); }

//--------------------------------------------------------------------------------------------- 
//--------------------------------------------------------------------------------------------- 

		function addMore(){
		 num = parseInt($("#rows").val()) + 1;
		 $("#rows").val(num);
		 $('#tabla_prod > tbody:last').append('<tr><td><input name="cod[]" id="cod'+num+'" type="text" class="longinput" style="width:50px" onKeyDown="autoC('+num+')" /></td><td><input name="desc[]" id="desc'+num+'" type="text" class="longinput" style="width:95%" onKeyDown="autoD('+num+')""/></td><td><input name="cant[]" id="cant'+num+'" type="text" class="longinput"  style="width:50px" maxlength="5" onChange="amountCalc('+num+')"/></td><td><input name="precio[]" id="precio'+num+'" type="text" class="longinput" style="width:75%" readonly="readonly"/></td><td><input name="total[]" id="total'+num+'" type="text" class="longinput" style="width:75%" readonly="readonly"/></td></tr>');
		}
		
//--------------------------------------------------------------------------------------------- 

		function addMoreV(){
		 num = parseInt($("#rows").val()) + 1;
		 $("#rows").val(num);
		 $('#tabla_prod > tbody:last').append('<tr><td><input name="fecha_det[]" id="fecha_det'+num+'" type="text" class="longinput" style="width:70px" /></td><td><input name="concepto[]" id="concepto'+num+'" type="text" class="longinput" style="width:220px" /></td><td><input name="prov[]" id="prov'+num+'" type="text" class="longinput"  style="width:220px"  /></td><td><input name="rif[]" id="rif'+num+'" type="text" class="longinput" style="width:95px" /></td><td><input name="fact[]" type="text" class="longinput" id="fact'+num+'" style="width:95px" /></td><td><input name="mont[]" type="text" class="longinput" id="mont'+num+'" style="width:95px" /></td></tr>');
		}
		
		
//-------------------------------------------------------------------		
		function amountCalc(id){
			total = parseInt($("#cant" + id).val()) * parseInt($("#precio" + id).val());
			$("#total" + id).val(total);
			totalCalc();
			
		}
//-------------------------------------------------------------------	
		
		function totalCalc(){
			subtotal = 0;
			for(i=1;i<=$("#rows").val();i++){
				if ($("#total" + i).val() != null){
			subtotal += +$("#total" + i).val();	
				}
			}
			$("#subt").val(subtotal.toFixed(2));
			
			if($("#disc").val()!=null && $("#disc").val()!="%"){
			descuento = 0;
			totalGral = 0;
			
			descuento = ($("#disc").val()*subtotal.toFixed(2))/100;
			totalGral = subtotal.toFixed(2) - descuento;
			$("#tot_disc").val(descuento.toFixed(2));
			$("#tot_gen").val(totalGral.toFixed(2));
			}else{
			$("#tot_gen").val(subtotal.toFixed(2));
			}
			
			iva = 0;
			totalTotal = parseFloat($("#tot_gen").val());
			iva = ($("#tot_gen").val()*12)/100;
			totalTotal += +iva.toFixed(2);
			$("#iva").val(iva.toFixed(2));
			$("#tot_pre").val(totalTotal.toFixed(2));
			
			
			
		}
//-------------------------------------------------------------------	