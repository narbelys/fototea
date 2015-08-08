<?php $session = validaSession();


$album = listAll("albumes", "WHERE a_id = '$_GET[a]' AND a_user_id = '$_COOKIE[id]'");
$rs_album = mysql_fetch_object($album);
$rows = mysql_num_rows($album);

if($session == true && $userType==1 && $rows > 0){

	
	
	
	?>

<script>

	function valForm(){
		$("#img_file").removeClass("inputError");
		 $("#file_text").append('<img src="images/loader.gif" class="loader"/>');
		if ($("#img_file").val() != ""){
			 var valAlbum = $("#img_file").val();
			var ff = valAlbum.substring(valAlbum.lastIndexOf('.') + 1).toLowerCase();
			   if( ff == "gif" || ff == "jpg" || ff=="png"){
				  
				   $("#formAlbum").submit();
			   }else{
				   alert("Recuerda que el formato de las imágenes debe ser JPG, GIF o PNG");
				   $(".loader").remove();
				   
				   }
		
		}else{
			 $("#img_file").addClass("inputError");
			 $(".loader").remove();
			}
		
		
	}
	
	  function handleFileSelect(evt) {
		    var files = evt.target.files; // FileList object
			$("#album_list").html("");
		    // Loop through the FileList and render image files as thumbnails.
		    for (var i = 0, f; f = files[i]; i++) {

		      // Only process image files.
		      if (!f.type.match('image.*')) {
		        continue;
		      }

		      var reader = new FileReader();

		      // Closure to capture the file information.
		      reader.onload = (function(theFile) {
		        return function(e) {
		          // Render thumbnail.
		          var span = document.createElement('span');
		          span.innerHTML = ['<img class="thumb" src="', e.target.result,
		                            '" title="', escape(theFile.name), '"/>'].join('');
		          document.getElementById('album_list').insertBefore(span, null);
		        };
		      })(f);

		      // Read in the image file as a data URL.
		      reader.readAsDataURL(f);
		    }
		  }
</script>



<div class="registroContainer" id="EditarPerfil">
<h2>Subir imagenes</h2>
 <p><a href="album?a=<?php echo $_GET['a'];?>" class="txtAzul font18">Ir al album</a></p>
	<div class="imgSubir">
		<form id="formAlbum" name="formAlbum" method="post" action="actions/albumAction.php" enctype="multipart/form-data" onsubmit="valForm();return false;">
		



		<div class="left" id="contImg">

				<p class="txtNaranja">Recuerda que la imagen debe ser en formato JPG, PNG o GIF.</p>
				<p class=" txtAzul font16">Selecciona las imágenes que desees agregar a tu álbum.</p>
				<div id="file_text">Arrastra tus fotos a esta zona o haz click para seleccionarlas</div>
				<input name="img_album[]" id="img_file"  type="file" class="txBoxRegistro" multiple>
				<output id="album_list"></output>
				<script> document.getElementById('img_file').addEventListener('change', handleFileSelect, false);</script>
				<input type="hidden" name="act" id="act" value="agregarFoto"/>
				<input type="hidden" name="album" id="album" value="<?php echo $_GET['a'];?>" />
				
			</div>
			
		<input type="submit" name="button" id="button" class="btn_naranja bold right" value="Subir" />
		
		</form>
	</div>
	<div class="albumTit">Album: <?php echo $rs_album->a_tit;?> <?php  if($rs_album->a_user_id == $_COOKIE['id']){?>- <a href="album?a=<?php echo $_GET['a'];?>" class="txtNaranja font12">Editar</a><?php  } ?></div>
	<div class="container_img">	
	<?php $fotos = listAll("albumes_det", "WHERE ad_a_id = '$_GET[a]' AND ad_status= 'S'");
	$rows_fotos = mysql_num_rows($fotos);
	
	if($rows_fotos>0){
	$i = 1;
	while($rs_fotos = mysql_fetch_object($fotos)){?>
	<div class="container_list_img left" id="img_<?php echo $rs_fotos->ad_id;?>">
	 <div class="deleteImg" onclick="deleteImg(<?php echo $rs_fotos->ad_id;?>,<?php echo $_GET['a'];?>)"><img alt="Eliminar foto" title="Eliminar foto" src="images/icon_close.png"/></div>
	 <img onclick="javascript=verFoto(<?php echo $i;?>,<?php echo $rs_fotos->ad_a_id;?>)" src="thumb.php?w=100&h=100&url=profiles/<?php echo sha1($_COOKIE['id'])."/".sha1($_GET['a'])."/".$rs_fotos->ad_url;?>" width="100" height="100"/>
	</div>
	<?php $i++; }
	}else{
	?>	
		
	<div class="albumList fontW400 font16">No se ha encontrado ninguna imagen en este álbum</div>
	<?php  }?>
	</div>
</div>
<?php }else{?>
	
		<script>
		window.location="home";
		</script>
<?php  }?>