<?php
/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 4/14/14
 * Time: 8:18 PM
 */

use Fototea\Config\FConfig;
?>

<script src="<?php echo FConfig::getUrl('js/jquery.simplemodal.1.4.4.min.js') ?>"></script>
<div id="crop_container" class="crop-container" style="display: none">

    <!-- # Modal Heading -->
    <div class="crop-container-heading">
        <h2 class="title">Cambiar imagen</h2>
    </div>

    <!-- # Step 0 - Upload file -->
    <div class="crop-div crop-profile step step-0">

        <!-- Display current cover/profile image (TODO improve quality) -->
        <div class="current-image-box">
            <div class="current-image">
                <img id="currentImage" src="" class="current-image-thumb"/>
            </div>
            <div class="current-image-label">Tu imagen actual</div>
        </div>

        <!-- Box to trigger upload progress -->
        <div class="uploading-box">
            <div id="uploadingCropLink" class="uploading-link">
                <span class="upload-instructions">
                    Haz click aquí para cargar una imagen<br/>
                    (Debe ser de al menos <b><span id="minWidthInfo"></span>x<span id="minHeightInfo"></span></b>)
                </span>
            </div>

            <!-- Uploading process div -->
            <div id="uploadingCropProgress" class="uploading-process" style="display: none">
                <div class="text">
                    Subiendo Imagen...
                </div>
            </div>
        </div>

        <div id="uploadResult" class="upload-result alert alert-danger" style="display: none">
        </div>

        <!-- Handler for upload -->
        <input class="upload-field" type="file" id="uploadCropImageField"/>

        <!-- Options for step 0 -->
        <div class="crop-container-options">
            <button type="button" class="btn btn-cancel cancel-change" href="#">Cancelar</button>
        </div>
    </div>
    <!-- End Step 0 -->

    <!-- # Step 1 - Crop file -->
    <div class="crop-div crop-crop step step-1">

        <!-- Jcrop area -->
        <div class="target-profile-container">
            <img id="targetProfile" src="" class="target-profile"/>
        </div>

        <div class="crop-instructions">
            Selecciona el área que quieres tomar de la imagen para tu cover
        </div>

        <!-- Jcrop crop coordinates -->
        <form id="coordProfile" class="coords" onsubmit="return false;">
            <div class="inline-labels">
                <input type="hidden" size="4" id="x1_profile" name="x1_profile" />
                <input type="hidden" size="4" id="y1_profile" name="y1_profile" />
                <input type="hidden" size="4" id="x2_profile" name="x2_profile" />
                <input type="hidden" size="4" id="y2_profile" name="y2_profile" />
                <input type="hidden" size="4" id="w_profile" name="w_profile" />
                <input type="hidden" size="4" id="h_profile" name="h_profile" />
            </div>
        </form>

        <!-- Options for step 1 -->
        <div class="crop-container-options">
                <button type="button" class="btn btn-cancel cancel-change" href="#">Cancelar</button>
                <button type="button" class="btn btn-primary" nohref id="confirm-crop">Aceptar</button>
        </div>
    </div>
    <!-- End Step 1 -->

    <!-- # Step 2 - Crop file -->
    <div class="crop-div crop-preview step step-2">
        <div class="preview-image-box">
            <img id="cropPreviewImage" class="preview-image" src="" alt="here the preview image" />
        </div>

        <div class="crop-instructions">
            Vista preliminar de la imagen (haz click en aplicar para guardar tu nueva imagen)
        </div>

        <!-- Options for step 2 -->
        <div class="crop-container-options">

                <button type="button" class="btn btn-cancel cancel-change" href="#">Cancelar</button>
                <button type="button" href="#" class="go-back btn btn-alternative">Atrás</button>
                <button type="button" class="btn btn-primary" nohref id="confirm-change">Aplicar</button>

            </div>
        </div>
    </div>

    <!-- Generic preloader display with showLoading(message) and hide with hideLoading() -->
    <div id="crop-loading" class="crop-loading" style="display:none">
        <div class="spinner"></div><span class="text"></span>
    </div>
    <!-- End Step 2 -->
</div>
<!-- End crop container -->

<script type="text/javascript">

    //Maybe a module here its not the best?
    var androbCrop = (function (jQuery) {

        var crop = {}, validFormats = ['image/png','image/jpg','image/jpeg','image/gif'];

        crop.imageType = 'profile'; //TODO or cover :)
        crop.targetImageId = '#profileMainImage'; //image to be refreshed at the end

        crop.currentImageId = '#currentImage';
        crop.cropImageId = '#targetProfile';    //image to be
        crop.previewImageId = '#cropPreviewImage';
        crop.inputFileId = '#uploadCropImageField';
        crop.loadingDiv = '#crop-loading';
        crop.uploadResultDiv = '#uploadResult';
        crop.uploadSizeInfoDiv = '#uploadSizeInfo';
        crop.started = false;
        crop.currentStep = 0;
        crop.circularCrop = false;

        crop.uploadingCropLink = '#uploadingCropLink';
        crop.uploadingCropProgress = '#uploadingCropProgress';

        crop.jcropApiProfile = null;
        crop.modal = null;
        crop.files = [];



        crop.messages = [];
        crop.messages['invalid image size'] = 'El tamaño de la imagen no es válido';


        crop.uploadingText = 'Subiendo imagen...';

        // Simple event handler, called from onChange and onSelect
        // event handlers, as per the Jcrop invocation above
        function showCoords(c)
        {
            jQuery('#x1_profile').val(c.x);
            jQuery('#y1_profile').val(c.y);
            jQuery('#x2_profile').val(c.x2);
            jQuery('#y2_profile').val(c.y2);
            jQuery('#w_profile').val(c.w);
            jQuery('#h_profile').val(c.h);
        };

        function clearCoords()
        {
            jQuery('#coordProfile input').val('');
        };

        function getUploadUrl() {
            return '<?php echo FConfig::getUrl('actions/perfilAction.php?act=uploadImage&type=') ?>'  + crop.imageType + '&cropRatio=' + crop.aspectRatio;
        };

        function isValidFormat(file){
            console.log(file.type);
            return (validFormats.indexOf(file.type) >= 0);
        }

        function isValidSize(file){
            console.log(file.size);
            return ((file.size !== 0) && ((file.size/1024) <= 15360));
        }

        function resizeAndUpload(file, resizeMaxWidth, quality, output_format) {

            jQuery(this.uploadingCropLink).hide();
            jQuery(this.uploadingCropProgress).show();

            var reader = new FileReader();
            reader.onload = function(e){
                var source_img_obj = new Image();
                source_img_obj.onload = function(){
                    var mime_type, canvasWidth, canvasHeight,cvs,ctx,data,boundary,xhr;
                    mime_type = file.type;
//                    if(output_format!=undefined && output_format=="png"){
//                        mime_type = "image/png";
//                    }

                    if ((quality == undefined) || isNaN(parseInt(quality))) {
                        quality = 80;
                    }

                    canvasWidth = source_img_obj.naturalWidth;
                    canvasHeight = source_img_obj.naturalHeight;

                    if (!isNaN(resizeMaxWidth)) {
                        if(canvasWidth > resizeMaxWidth) {
                            canvasHeight *= resizeMaxWidth / canvasWidth;
                            canvasWidth = resizeMaxWidth;
                        }
                    }

                    cvs = document.createElement('canvas');
                    cvs.width = canvasWidth;
                    cvs.height = canvasHeight;
                    ctx = cvs.getContext("2d").drawImage(source_img_obj, 0, 0, canvasWidth, canvasHeight);
                    data = cvs.toDataURL(mime_type, quality/100);

                    //var data = cvs.toDataURL(type);
                    data = data.replace('data:' + mime_type + ';base64,', '');

                    xhr = new XMLHttpRequest();
                    xhr.open('POST', getUploadUrl(), true);
                    boundary = 'someboundary';

                    if (XMLHttpRequest.prototype.sendAsBinary === undefined) {
                        XMLHttpRequest.prototype.sendAsBinary = function(string) {
                            var bytes = Array.prototype.map.call(string, function(c) {
                                return c.charCodeAt(0) & 0xff;
                            });
                            this.send(new Uint8Array(bytes).buffer);
                        };
                    }

                    xhr.setRequestHeader('Content-Type', 'multipart/form-data; boundary=' + boundary);
                    xhr.sendAsBinary(['--' + boundary, 'Content-Disposition: form-data; name="' + 'file' + '"; filename="' + file.name + '"', 'Content-Type: ' + file.type, '', atob(data), '--' + boundary + '--'].join('\r\n'));
                    xhr.onload = function(e) {
                        var message;
                        if (xhr.readyState === 4) {
                            if (xhr.status === 200) {
                                var data = JSON.parse(xhr.responseText);
                                if (data.status == 'success') {
                                    //reload preview image
                                    jQuery('.target-profile-container').hide();
                                    crop.reloadCropImage(data.img_url);
                                    crop.enableCrop(data.img_url, data.width, data.height, function(){
                                        crop.showStep(1);
                                        if (crop.circularCrop) {
                                            jQuery('.jcrop-holder > div > div').first().addClass('img-circle');
                                        }
                                        jQuery('.target-profile-container').fadeIn(1000);
                                    });
                                    crop.cleanInputFile();
                                    //jQuery(this.cropImageId).fadeIn();
                                } else {

                                    jQuery(crop.uploadResultDiv).html(data.message);
                                    if (data.message == 'invalid image size'){
                                        message = 'La imagen debe tener como tamaño mínimo ' + crop.minRequiredWidth + 'x' + crop.minRequiredHeight + ' píxeles';
                                    } else if (data.message == 'invalid image') {
                                        message = 'El archivo no es válido';
                                    }
                                    jQuery(crop.uploadResultDiv).html(message);
                                    jQuery(crop.uploadResultDiv).show();
                                    jQuery(crop.uploadingCropLink).show();
                                    jQuery(crop.uploadingCropProgress).hide();
                                }
                            } else {
                                //TODO handle error here
                                console.error(xhr.statusText);
                            }
                        }

                        jQuery(this.uploadingCropProgress).hide();
                        jQuery(this.uploadingCropLink).show();
                    };

                    xhr.onerror = function() {
                        console.log('xhr error');
                        console.log(xhr.statusText);
                        //TODO handle server error here

                        //TODO Show error message

                        //Restore uplad field state
                        jQuery(this.uploadingCropProgress).hide();
                        jQuery(this.uploadingCropLink).show();
                    }
                };

                //Trigger Load
                source_img_obj.src = e.target.result;
            };

            //Trigger readFIle
            return reader.readAsDataURL(file);
        }

        /* Creates main events */
        crop.init = function () {

            //Verify jQuery
            if (jQuery == undefined) {
                console.log('jQuery is required');
                return false;
            }

            //Clear any jcrop instance to start fresh
            jQuery('.jcrop-holder').remove();

            //Prepare upload form
            // Add events
            jQuery('input#uploadCropImageField').on('change', function(event){
                crop.files = event.target.files;

                //Clear validation message
                jQuery(crop.uploadResultDiv).hide();
                jQuery(crop.uploadResultDiv).html('');

                if (!isValidFormat(crop.files[0])){
                    jQuery(crop.uploadResultDiv).html('El formato del archivo no es válido, los formatos permitidos son gif, jpg y png.');
                    jQuery(crop.uploadResultDiv).show();
                    return false;
                }

                if (!isValidSize(crop.files[0])){
                    jQuery(crop.uploadResultDiv).html('El tamaño del archivo excede el máximo de 15mb.');
                    jQuery(crop.uploadResultDiv).show();
                    return false;
                }
                
                
                
                resizeAndUpload(crop.files[0], crop.maxImageWidth);
                 
            });

            jQuery('#confirm-crop').bind('click', function(){
                
                androbCrop.cropImage();
            });

            jQuery('#confirm-change').bind('click', function(){
                androbCrop.confirmImage(function(){
                    crop.close();
                });
            });

            jQuery('.uploading-link').click(function(){
                jQuery('#uploadCropImageField').trigger('click');
            });

            jQuery('.cancel-change').click(function(e){
                e.preventDefault();
                crop.close();
            });

            jQuery('.go-back').click(function(e) {
                e.preventDefault();
                crop.previousStep();
            });

            crop.started = true;
        };


        crop.cleanInputFile = function(){
            jQuery(this.inputFileId).val('');
        }

        /* Reloads crop image, usually used after uploads */
        crop.reloadCropImage = function(imgUrl) {
            //jQuery(this.cropImageId).attr('src', imgUrl);
            //console.log(data.img_url);
            //change values of variables to resize the crop
//            if (crop.jcropApiProfile != null) {
//                crop.jcropApiProfile.setImage(imgUrl);
//            }
        }

        crop.loadCurrentImage = function(imageUrl) {
            jQuery(this.currentImageId).attr('src', imageUrl);
        }

//        crop.reloadPreviewImage = function(imgUrl) {
//            jQuery(this.previewImageId).attr('src', imgUrl);
//        }

        /* Send the coordinates to to server to crop the image, receives json data with the new image */
        crop.cropImage = function(callback){
            var imageWidth = jQuery('#targetProfile').prop('width');
            var scaleFactor = 1;
            if (imageWidth > this.maxWidthGrid){
                scaleFactor = imageWidth / this.maxWidthGrid;
            }

            jQuery.ajax({
                url: '<?php echo FConfig::getUrl('actions/perfilAction.php?act=cropImage&s=') ?>' + scaleFactor + '&type=' + crop.imageType + '&' + jQuery('#coordProfile').serialize(),
                cache: false,
                type: 'post',
                dataType: 'json',
                success: function(data){
                    //console.log(data);
//                  jQuery(target).children('.modal-body').html(html);
//                  jQuery(target).modal('show');
                    //json here
                    if (data.status == 'success') {
                        //go to the next step
                        if (callback != undefined) {
                            callback();
                        }

                        crop.displayConfirm(data.img_url);
                        crop.showStep(2);
                    }
                    //validate json
                }
            });
        };

        /* Activate crop on the required imaged */
        crop.enableCrop = function(imageUrl, width, height, callback) {
            //setImage here
            var imageObj = new Image();
            imageObj.src = imageUrl;
            imageObj.onload= (function(imageObj, width, height, callback){
                jQuery(crop.cropImageId).attr('src', imageObj.src);

                if (crop.jcropApiProfile != null) {
                    crop.jcropApiProfile.destroy();
                    crop.jcropApiProfile = null;
                }

                jQuery(crop.cropImageId).Jcrop({
                    boxHeight:   crop.maxWidthGrid,
                    boxWidth: 880,
                    onChange:   showCoords,
                    onSelect:   showCoords,
                    onRelease:  clearCoords,
                    aspectRatio: crop.aspectRatio,
                    setSelect: crop.initialSelect,
                    setImage: imageUrl
                },function(){
                    crop.jcropApiProfile = this;
                    callback();

                    //Center crop area
                    var cropW = Math.min(width * 0.85,height * 0.85);
                    var cropH = (cropW) / crop.aspectRatio;

                    var cx = width/2;
                    var cy = height/2;


                    var x = 0 + (cx - cropW/2);
                    var x2 = cropW + (cx - cropW/2);
                    var y = 0 + (cy - cropH/2);
                    var y2 = cropH + (cy - cropH/2);

                    crop.jcropApiProfile.setSelect([x,y,x2,y2]);

                    //This is for set the default cords?
                    jQuery('#coordProfile').on('change','input',function(e){
                        var x1_profile = $('#x1_profile').val(),
                            x2_profile = $('#x2_profile').val(),
                            y1_profile = $('#y1_profile').val(),
                            y2_profile = $('#y2_profile').val();
                        crop.jcropApiProfile.setSelect([x1_profile,y1_profile,x2_profile,y2_profile]);
                    });
                });
            })(imageObj, width, height, callback);
        }

        crop.hideSteps = function(){
            jQuery('.step').hide();
        }

        crop.showStep = function (step){
            crop.currentStep = step;
            jQuery('.current-step').removeClass('current-step').hide();
            jQuery('.step-' + step).addClass('current-step').show();
        }

        crop.previousStep = function (){
            crop.showStep(crop.currentStep - 1);
        }

        /* Reload the croped image */
        crop.reloadTargetImage = function(imgUrl) {
            //be careful with apache cache here
            console.log('changing image to' + imgUrl);
            jQuery(crop.targetImageId).attr('src', imgUrl);
        }

        /* Reset the styles of the image used for crop */
        crop.resetCropImage = function() {
            jQuery(crop.cropImageId).attr('style', '');
        }

        /* Set the preview image */
        crop.displayConfirm = function(imgUrl) {
            jQuery(crop.previewImageId).attr('src', imgUrl);
        };

        /* Set the cropped image as the final image (final step) */
        crop.confirmImage = function(callback) {
            //ajax request to move the final image
            //json to decide to close de modal

            //TODO LOADING HERE

            jQuery.getJSON('<?php echo FConfig::getUrl('actions/perfilAction.php?act=confirmImage&type=') ?>' + crop.imageType, null, function(data){
                 if (data.status == "success") {
                     /* reload image */
                     crop.reloadTargetImage(data.img_url);
                     callback() //TODO CLOSE MODAL HERE USING A CALLBACK
                 } else {
                     alert(data.message);
                 }
            });
        };

        crop.uploadLoading = function(message) {
            
            if ((message != undefined) && (message != '')) {
                console.log(message);
                jQuery(this.loadingDiv + ' .text').html(message);
            }

            jQuery(this.loadingDiv).show();
        }

        crop.hideLoading = function() {
            jQuery(this.loadingDiv).hide();
        }


        /* Shutdown the change image process (callback) */
        crop.close = function() {
            //Delete jcrop instance
            if (crop.jcropApiProfile != null) {
                crop.jcropApiProfile.destroy();
                crop.jcropApiProfile = null;
            }

            crop.cleanInputFile();

            //Reset style of crop image area
            crop.resetCropImage();

            crop.modal.close();
            crop.modal = null;

        };

        /* Run the process with selected image (click event for edit buttons) */
        crop.run = function(imageType, currentImageUrl) {
            
            //TODO validate imageType

            if (!crop.started){
                crop.init();
            }

            crop.currentStep = 1;

            //Configure based on image type
            crop.imageType = imageType;

            if (crop.imageType == "profile") {
                crop.maxWidthGrid = 450;
                crop.maxImageWidth = 1440;

                //Required image size
                crop.minRequiredWidth = 130;
                crop.minRequiredHeight = 130;

                crop.targetImageId = '#profileMainImage';
                crop.circularCrop = true;
                crop.aspectRatio = 1;
                crop.initialSelect = [20,20,100,100];
            }

            if (crop.imageType == "cover") {
                crop.maxWidthGrid = 450;
                crop.maxImageWidth = 1440;

                //Required image size
                crop.minRequiredWidth = 1440;
                crop.minRequiredHeight = 450;

                crop.targetImageId = '#coverMainImage';
                crop.circularCrop = false;
                crop.aspectRatio = 3.2;
                crop.initialSelect = [30,30,300,120];
            }

            //Set instructions

            jQuery('#crop_container').attr('role',crop.imageType);
            jQuery('#minWidthInfo').html(crop.minRequiredWidth);
            jQuery('#minHeightInfo').html(crop.minRequiredHeight);

            // make image circle select
            if (crop.circularCrop) {
                //Maybe here is better to apply a custom inline style?? img-circle relies on bootstrap
                jQuery(crop.previewImageId).addClass('img-circle');
                jQuery(crop.currentImageId).addClass('img-circle');
            } else {
                //just in case
                jQuery(crop.previewImageId).removeClass('img-circle');
                jQuery(crop.currentImageId).removeClass('img-circle');
            }

            //crop.setCurrentImage(currentImageUrl);

            //Reset preloaders
            crop.hideLoading();

            //Reset style of crop image area
            crop.resetCropImage();

            //Clean input file
            crop.cleanInputFile();

            //Destroy any instances of jcropApiProfile
            if (crop.jcropApiProfile != null) {
                crop.jcropApiProfile.destroy();
                crop.jcropApiProfile = null;
            }

            /* Load current image */
            crop.loadCurrentImage(currentImageUrl);
            crop.hideSteps();
            crop.showStep(0);

            //jQuery('#crop_container').addClass(crop.imageType);

            //Launch modal
            crop.modal = jQuery('#crop_container').modal({
                minHeight:590,
                minWidth: 900,
                autoResize: true,
                onOpen: function (dialog) {
                    dialog.overlay.fadeIn('fast', function () {
                        dialog.data.hide();
                        dialog.container.fadeIn('fast', function () {
                            dialog.data.fadeIn('fast');
                        });
                    });
                }
            });
        }

        return crop;
    }(jQuery));

    jQuery(function(){
        androbCrop.init();
    });

    jQuery(document).ready(function(){
        $.fn.raty.defaults.path = 'images';
        $('.rating-n').raty({ readOnly: true, score: <?php  echo $review['starsP'] ?>});
    });

</script>