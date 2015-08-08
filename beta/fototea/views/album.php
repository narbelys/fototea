<?php
use Fototea\Config\FConfig;
use Fototea\Models\User;

//$session = validaSession();
//
//if ($session == false){
//    die('protected page');
//}

$currentUser = getCurrentUser();

$albumId = (isset($_REQUEST['a']) && is_numeric($_REQUEST['a'])) ? $_REQUEST['a'] : null;

if ($albumId == null){
    if ($currentUser->user_type != User::USER_TYPE_PHOTOGRAPHER){
        die('not allowed');
    }

    $mode = 'create';
} else {
    $album = listAll("albumes", "WHERE a_id = '$albumId'");
    $rs_album = mysql_fetch_object($album);
    $rows = mysql_num_rows($album);

    if ($rows == 0){
        die('invalid album');
    }

    // Current images
    $fotos = listAll("albumes_det", "WHERE ad_a_id = '$albumId' AND ad_status='S'");
    $rows_fotos = mysql_num_rows($fotos);

    $same_user = ($currentUser->id == $rs_album->a_user_id) ? true : false ;

    if ($same_user && $currentUser->user_type == User::USER_TYPE_PHOTOGRAPHER) {
        $mode = 'edit';
    }
}

?>

<link href="<?php echo FConfig::getUrl('css/dropzone/dropzone.css') ?>" rel="stylesheet" type="text/css" />

<div class="content-container">
    <div class="content">
        <div id="album_page" class="album-page">

            <h2 class="main-title">
                <?php echo ($mode == 'create') ? 'Crear nuevo álbum' : $rs_album->a_tit ; ?>
            </h2>

            <?php if ($mode == 'create' || $mode == 'edit'): ?>
                <div class="col-xs-12">
                    <div class="formError bold" id="formError"></div>
                    <form id="album_form" class="album-form col-xs-5" role="form">
                        <div class="form-group">
                            <label for="a_tit">T&iacute;tulo:</label>
                            <input type="text" name="a_tit" id="a_tit" value="<?php echo $rs_album->a_tit ?>" class="form-control" /><br>
                        </div>
                        <div class="form-group">
                            <label for="a_license">
                                Tipo de licencia Creative Commons:
                                <a href="http://creativecommons.org/licenses/" target="_blank" title="Click para más información">
                                    <img class="information-icon" src="images/information_icon.png">
                                </a>
                            </label>
                            <select id="a_license" name="a_license" class="form-control">
                                <option value="">Seleccionar una licencia...</option>
                                <option value="Attribution (CC BY)">Attribution (CC BY)</option>
                                <option value="Attribution-ShareAlike (CC BY-SA)">Attribution-ShareAlike (CC BY-SA)</option>
                                <option value="Attribution-NoDerivs (CC BY-ND)">Attribution-NoDerivs (CC BY-ND)</option>
                                <option value="Attribution-NonCommercial (CC BY-NC)">Attribution-NonCommercial (CC BY-NC)</option>
                                <option value="Attribution-NonCommercial-ShareAlike (CC BY-NC-SA)">Attribution-NonCommercial-ShareAlike (CC BY-NC-SA)</option>
                                <option value="Attribution-NonCommercial-NoDerivs (CC BY-NC-ND)">Attribution-NonCommercial-NoDerivs (CC BY-NC-ND)</option>
                            </select>
                        </div>
                        <div class=" form-group">
                            <input type="checkbox" id="a_status" <?php if($mode == 'create' || $rs_album->a_status == "S"){ echo 'checked="checked"';}?> />
                            <label for="a_status">&Aacute;lbum visible</label>
                        </div>
                        <input id="album-id" type="hidden" value="<?php echo $albumId ?>" >
                    </form>
                </div>
            <?php endif ?>

            <div class="col-xs-12 photos-section" <?php echo ($mode == 'create') ? 'style="display: none;"' : '' ; ?>>
                <p class="alert alert-warning">Selecciona las im&aacute;genes que desees agregar a tu &aacute;lbum. Recuerda que son hasta <b>9</b> imágenes por álbum y deben tener formato <b>JPG, PNG o GIF</b>.</p>
                <div id="dropzone" class="dropzone col-xs-12 album-<?php echo $albumId;?>">
                </div>
            </div>

            <div class="col-xs-12 album-button <?php echo ($mode == 'create') ? 'text-left' : 'text-center' ;?>">
                <button id="album_save" type="button" class="btn btn-primary">
                    <?php echo ($mode == 'create') ? 'Crear' : 'Guardar' ;?>
                </button>
            </div>

        </div>
    </div>
</div>

<script src="<?php echo FConfig::getUrl('js/dropzone.custom.js') ?>"></script>

<script type="text/javascript">
    //    (function(jQuery){

    var albumId = '<?php echo $albumId; ?>';

    // Dropzone class:
    var myDropzone = new Dropzone("div#dropzone", {
        paramName: "file",
        url: "<?php echo FConfig::getUrl('actions/albumAction.php?act=addFoto&album='.$_GET[a]); ?>",
        addRemoveLinks: true,
        dictRemoveFile: "Eliminar imagen",
        addPrincipalLinks: true,
        dictPrincipalFile: "Marcar principal",
        dictCancelUpload: 'Cancelar',
        dictDefaultMessage: "Arrastra tus fotos a esta zona o haz click para seleccionarlas.",
        dictInvalidFileType: "No puede subir archivos de este tipo.",
        acceptedFiles: '.jpeg,.jpg,.png,.gif,.JPEG,.JPG,.PNG,.GIF',
        maxFilesize: 15,
        maxFiles: <?php echo FConfig::getValue('maxFilesByAlbum') ?>,
        previewTemplate: function(page, album){
            var template = '<div class=\"dz-preview dz-file-preview\">\n  <div class=\"dz-details container_list_img\">\n    <div class=\"dz-filename\"><span data-dz-name></span></div>\n    <div class=\"dz-size\" data-dz-size></div>\n    <img data-dz-thumbnail />\n  </div>\n  <div class=\"dz-progress\"><span class=\"dz-upload\" data-dz-uploadprogress></span></div>\n  <div class=\"dz-success-mark\"><span>✔</span></div>\n  <div class=\"dz-error-mark\"><span>✘</span></div>\n  <div class=\"dz-error-message\"><span data-dz-errormessage></span></div>\n</div>';
            return template;
        },
        accept: function(file, done) {
            done();
        }
    });

    /** Add current images to dropzone */
    (function(){
        var i = 1;
        <?php while($rs_fotos = mysql_fetch_object($fotos)){?>

        var mockFile = { name: "<?php echo $rs_fotos->ad_url ?>", size: 0, server_id: <?php echo $rs_fotos->ad_id; ?>,
            album: '<?php echo $_GET['a'] ?>', photo: '<?php echo $rs_fotos->ad_id ?>', is_principal: '<?php echo $rs_fotos->ad_is_principal ?>', page: i++};

        // Call the default addedfile event handler
        myDropzone.options.addedfile.call(myDropzone, mockFile);

        // And optionally show the thumbnail of the file:
        myDropzone.options.thumbnail.call(myDropzone, mockFile, "<?php echo FConfig::getUrl('profiles/'.sha1($_COOKIE['id']).'/'.sha1($_GET[a]).'/'.$rs_fotos->ad_url); ?>");
        <?php $i++; } ?>

        // Show span message in the bottom of the dropzone div
        if (myDropzone.element.classList.contains("dropzone") && !myDropzone.element.querySelector(".dz-message")) {
            myDropzone.element.appendChild(Dropzone.createElement("<div class=\"dz-default dz-message\"><span>" + myDropzone.options.dictDefaultMessage + "</span></div>"));
        }
    }());

    myDropzone.on("success", function(file, fileServerId) {
//        console.log('success');
        //        file.server_id = fileServerId;
        jQuery('.dropzone .dz-message').hide();
    });

    myDropzone.on("error", function(file, errorMessage) {
//        console.log('error');
        //        this.removeFile(file);
    });

    myDropzone.on("removedfile", function(file) {

        /* File may not be accepted based on validations so it never get uploaded */
        if (file.server_id != undefined) {
            var url = "<?php echo FConfig::getUrl('actions/albumAction.php?act=borrarfoto&a_id='. $_REQUEST['a']) ?>";
            url += "&ad_id=" + file.server_id + '&file_name=' + file.name;

            jQuery.ajax({
                url: url,
                type: 'DELETE',
                success: function(result) {
                    checkAddAble();
                    console.log('Deleted file');
                },
                error: function(result) {
                    alert('Error deleting file');
                }
            });
        }
    });

    myDropzone.on("complete", function (file) {
        if (this.getUploadingFiles().length === 0 && this.getQueuedFiles().length === 0) {
            jQuery('.dropzone .dz-message').hide();
            checkAddAble();
            location.reload();
        }
    });

    jQuery('.dz-principal').click(function(){
        var elem = jQuery(this);
        var album = elem.attr('dz-principal-album');
        var photo = elem.attr('dz-principal-photo');

        var url = '<?php echo FConfig::getUrl('actions/albumAction.php?act=principalFoto') ?>';
        url += '&album=' + album + '&ad_id=' + photo;

        jQuery.ajax({
            url: url,
            success: function(result) {
                refreshPrincipal(photo);
            },
            error: function(result) {
                console.log('Error deleting file');
            }
        });
    });

    // Eliminar album
    function deleteAlbum(){
        var conf = confirm("¿Está seguro que desea eliminar el álbum?");

        if(conf == true){
            document.getElementById('deleteAlbumForm').submit();
        }
    }

    function checkAddAble(){
        var currentQtyFiles = jQuery('.dropzone .dz-preview.dz-image-preview').length;

        if (currentQtyFiles < <?php echo FConfig::getValue('maxFilesByAlbum') ?>){
            myDropzone.enable();
            jQuery('.dropzone .dz-message').show();
        } else {
            myDropzone.disable();
            jQuery('.dropzone .dz-message').hide();
        }
    }

    jQuery(document).ready(function(){
        // Fill license field
        var license="<?php  echo $rs_album->a_license;?>";
        if(license != ""){
            jQuery("#a_license").val(license);
        }

        jQuery("#album_save").click(function(){
            var error = 0;
            jQuery("#formError").html("");
            jQuery('div.form-group').removeClass('has-error');
            jQuery("#formError").slideDown('slow');

            jQuery("#a_tit").removeClass("inputError");

            if(jQuery("#a_tit").val() == "" || jQuery("#a_tit").val().length < 3){
                jQuery("#a_tit").parents("div.form-group").addClass('has-error');
                jQuery("#formError").append("<p>- Debes indicar un título para el álbum </p>");
                jQuery("#formError").slideDown('slow');
                error++;
            }

            if(jQuery("#a_license").val() == ""){
                jQuery("#a_license").parents("div.form-group").addClass('has-error');
                jQuery("#formError").append("<p>- Debes seleccionar un tipo de licencia </p>");
                jQuery("#formError").slideDown('slow');
                error++;
            }

            if(error == 0){
                var action = '<?php echo ($mode == 'create') ? 'agregarAlbum' : 'editarAlbum' ;?>';

                jQuery.ajax({
                    type: 'get',
                    dataType: 'json',
                    url: 'actions/albumAction.php',
                    data: {a_tit:jQuery("#a_tit").val(), a_license:jQuery("#a_license").val(), status:jQuery("#a_status").prop('checked'), a_id:'<?php echo $albumId;?>', act:action},
                    success: function(json){
                        <?php if($mode == 'create'): ?>
                            window.location="album?a="+json[0]['album'];
                        <?php else: ?>
                            window.location="perfil?us=<?php  echo $currentUser->act_code;?>&act=portafolio";
                        <?php endif ?>
                    }
                });
            }else{
                return false;
            }
        });

        jQuery('.dz-message').removeClass('dz-default');

        refreshPrincipal(jQuery('.dz-principal[dz-is-principal=1]').attr('dz-principal-photo'))

        checkAddAble();
    });
    //    }(jQuery));
</script>








