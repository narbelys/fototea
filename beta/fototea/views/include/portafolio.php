<?php

use Fototea\Config\FConfig;
use Fototea\Models\Credit;
use Fototea\Models\Referral;
use Fototea\Models\User;
use Fototea\Util\UrlHelper;

if ($currentUser->user_type == User::USER_TYPE_CLIENT) { //SI soy cliente
    if ($currentUser->id == $user_info['id']){ //Si mi id como cliente === id del perfil viendo
        die('not_allowed');
    }
}

// same_user = mio
// user_type = tipo de usuario

//User::canDoSomething('create_album', $user_info['id']);

//PORTAFOLIO TAB

//Default public albums
$album_condition = "WHERE a_user_id = '". $user_info['id'] . "' AND a_id = ad_a_id AND a_status = 'S' GROUP BY ad_a_id";

//if($same_user){
    $album_condition = "WHERE a_user_id = '". $user_info['id'] . "'";
//}

$album = listAll("albumes", $album_condition);
$albums = array();

while ($rs_album = mysql_fetch_object($album)){
    $fotos = listAll("albumes_det", "WHERE ad_a_id = '$rs_album->a_id'AND ad_status = 'S' ORDER BY ad_is_principal, ad_id");

    $rs_album->fotos = array();
    $rs_album->base_url = 'profiles/' . sha1($user_info['id'])."/".sha1($rs_album->a_id)."/";
    $rs_album->total_fotos = 0;

    while ($rs_foto = mysql_fetch_object($fotos)) {

        //Prepare urls
        $rs_foto->base_url = $rs_album->base_url . $rs_foto->ad_url;

        //TODO fix magic numbers here
        $rs_foto->full_size_url = FConfig::getThumbUrl($rs_foto->base_url, 1440,900);
        $rs_foto->album_cover_thumb = UrlHelper::getAlbumThumbUrl($rs_foto->base_url, 440, 300, true);
        $rs_foto->album_thumb = UrlHelper::getAlbumThumbUrl($rs_foto->base_url, 223, 150, true);

        if ($rs_foto->ad_is_principal) {
            $rs_album->principal = $rs_foto;
        } else {
            $rs_album->fotos[] = $rs_foto;
        }
        $rs_album->total_fotos++;
    }

    //Si no hay principal , coloco a la primera
    if ($rs_album->principal == null) {
        $rs_album->principal = array_shift($rs_album->fotos);
    }

    $albums[] = $rs_album;
}

// Check available credit
$creditAvailable = Credit::getRealAvailableCredits($currentUser->id, count($albums));

?>
<div class="col-xs-12">
    <h2 class="portafolio main-title">
        Portafolio
    </h2>

    <?php if($same_user): ?>
        <a <?php echo ($creditAvailable > 0) ? "href='album'" : '' ?> class="btn btn-primary pull-right <?php echo ($creditAvailable > 0) ? '' : 'trigger-share' ?>">
            Crear nuevo álbum
        </a>

        <div class="col-xs-12 alert alert-info alert-referrals">
            Actualmente tienes <?php echo $creditAvailable ?> cupo(s) disponibles para crear un &aacute;lbum, puedes obtener m&aacute;s cupos invitando a tus amigos a Fototea <a class="trigger-share"><b>Invitar amigos</b>.</a>
        </div>

    <?php endif ?>
    <div class="album-list">
        <?php /* foreach ($albums as $rs_album): ?>
            <div class="album-section album-<?php echo $rs_album->a_id;?>">
                <!-- Foto principal -->
                <div class="container_album_list left">
                    <div class="principal-box">
                        <div class="principal-image container_list_img">
                            <img src="<?php echo $rs_album->principal->album_cover_thumb ?>" />
                        </div>
                        <div class="container_album_tit">
                            <div class="album-title">
                                <?php if ($current_user->user_type == User::USER_TYPE_PHOTOGRAPHER): ?>
                                <a href="album?a=<?php echo $rs_album->a_id;?>">
                                    <?php endif ?>
                                    <?php echo ucwords($rs_album->a_tit);?>
                                    <?php if ($current_user->user_type == User::USER_TYPE_PHOTOGRAPHER): ?>
                                </a>
                            <?php endif ?>
                            </div>
                            <div class="photos-number">
                                <?php echo $rs_album->total_fotos;?> fotos
                            </div>
                            <div class="album-actions">
                                <?php if ($rs_album->total_fotos): ?>
                                    <a class="album-<?php echo $rs_album->a_id;?>-photo photo-principal" data-gallery-target="album-<?php echo $rs_album->a_id;?>-photo" href="<?php echo $rs_album->principal->full_size_url ?>">
                                        <div class="album-action album-view">
                                        </div>
                                    </a>
                                <?php else: ?>
                                    <a class="album-<?php echo $rs_album->a_id;?>-photo">
                                        <div class="album-action album-view">
                                        </div>
                                    </a>
                                <?php endif ?>
                                <?php if ($same_user): ?>
                                <a href="album?a=<?php echo $rs_album->a_id;?>">
                                    <div class="album-action album-edit">
                                    </div>
                                </a>
                                <a onclick="deleteAlbum(<?php echo $rs_album->a_id;?>)">
                                    <div class="album-action album-remove">
                                    </div>
                                </a>
                                <?php endif ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- End foto principal -->
                <div class="others left">
                    <?php $i = 2; ?>
                    <?php foreach($rs_album->fotos as $photoTemp): ?>
                        <div class="wrapper-photo">
                            <a class="album-<?php echo $rs_album->a_id;?>-photo photo-<?php echo $photoTemp->ad_id ?>" href="<?php echo $photoTemp->full_size_url ?>">
                                <div class="particular-photo container_list_img" style="background: url('<?php echo $photoTemp->album_thumb ?>') no-repeat center center"></div>
                            </a>
                        </div>
                        <?php $i++; endforeach; ?>
                </div>
            </div>
        <?php endforeach; */ ?>

        <?php foreach ($albums as $rs_album): ?>
            <div class="sub-title">
                <?php echo ucwords($rs_album->a_tit);?>
            </div>
            <div class="album-section clearfix album-<?php echo $rs_album->a_id;?>">
                <div class="pull-left album-principal-container">
                    <div class="container_album_list left">
                        <div class="principal-box">
                            <div class="principal-image container_list_img">
                                <img src="<?php echo ($rs_album->principal->album_cover_thumb) ? $rs_album->principal->album_cover_thumb : FConfig::getUrl('images/album_default.jpg') ; ?>" />
                            </div>
                            <div class="container_album_tit text-center">
                                <div class="album-title">
                                    <?php if ($current_user->user_type == User::USER_TYPE_PHOTOGRAPHER): ?>
                                    <a href="album?a=<?php echo $rs_album->a_id;?>">
                                        <?php endif ?>
                                        <?php echo ucwords($rs_album->a_tit);?>
                                        <?php if ($current_user->user_type == User::USER_TYPE_PHOTOGRAPHER): ?>
                                    </a>
                                <?php endif ?>
                                </div>
                                <div class="photos-number">
                                    <?php echo $rs_album->total_fotos;?> fotos
                                </div>
                                <div class="album-actions">
                                    <?php if ($rs_album->total_fotos): ?>
                                        <a class="album-<?php echo $rs_album->a_id;?>-photo photo-principal" data-gallery-target="album-<?php echo $rs_album->a_id;?>-photo" href="<?php echo $rs_album->principal->full_size_url ?>">
                                            <div class="album-action album-view">
                                            </div>
                                        </a>
                                    <?php else: ?>
                                        <a class="album-<?php echo $rs_album->a_id;?>-photo">
                                            <div class="album-action album-view">
                                            </div>
                                        </a>
                                    <?php endif ?>
                                    <?php if ($same_user): ?>
                                        <a href="album?a=<?php echo $rs_album->a_id;?>">
                                            <div class="album-action album-edit">
                                            </div>
                                        </a>
                                        <a onclick="deleteAlbum(<?php echo $rs_album->a_id;?>)">
                                            <div class="album-action album-remove">
                                            </div>
                                        </a>
                                    <?php endif ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- End foto principal -->
                <div class="pull-left album-thumbs-box" style="width:67%; height:300px">
                    <?php $i = 2; ?>
                    <?php foreach($rs_album->fotos as $photoTemp): ?>
                        <a class="album-<?php echo $rs_album->a_id;?>-photo photo-<?php echo $photoTemp->ad_id ?>" href="<?php echo $photoTemp->full_size_url ?>">
                            <div class="col-xs-3 album-thumb" style="height:50%; background-image: url('<?php echo $photoTemp->album_thumb ?>')"></div>
                        </a>
                        <?php if ($i > 8) { break; } ; $i++; endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>

        <?php if($same_user): ?>
            <div class="more-albums-info">
                <a class="trigger-share more-albums-link btn btn-primary">
                    Quiero m&aacute;s &aacute;lbumes
                </a>
            </div>
        <?php endif ?>

        <div id="referrals_modal" class="referrals-modal" style="display: none">
            <h2>¡Gana &aacute;lbumes por referir!</h2>
            <p>Puedes incrementar tu cuota de &aacute;lbumes f&aacute;cilmente invitando a tus amigos a Fototea a trav&eacute;s de las redes sociales o por correo.</p>
            <p>¡Por cada amigo que traigas a Fototea podr&aacute;s crear un nuevo &aacute;lbum y puedes compartir la invitación tantas veces como quieras!</p>
            <!-- AddThis Button BEGIN -->
            <div class="addthis_toolbox addthis_default_style addthis_32x32_style">
                <!-- AddThis Button BEGIN -->
                <a class="addthis_button_facebook" addthis:url="<?php echo FConfig::getUrl('registro?ru='.$user_info['act_code'].'&rm='.Referral::MEDIA_FACEBOOK) ?>"></a>
                <a class="addthis_button_twitter" addthis:url="<?php echo FConfig::getUrl('registro?ru='.$user_info['act_code'].'&rm='.Referral::MEDIA_TWITTER) ?>"></a>
                <a class="addthis_button_google_plusone_share" addthis:url="<?php echo FConfig::getUrl('registro?ru='.$user_info['act_code'].'&rm='.Referral::MEDIA_GOOGLEPLUS) ?>"></a>
                <a class="addthis_button_email" addthis:url="<?php echo FConfig::getUrl('registro?ru='.$user_info['act_code'].'&rm='.Referral::MEDIA_EMAIL) ?>"></a>
            </div>
            <script type="text/javascript">var addthis_config = {"data_track_addressbar":true, ui_language: "es"};</script>
            <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-538174716ff4d2f6"></script>
            <!-- AddThis Button END -->
        </div>
    </div>
</div>
<div>

<!--    <div class="pull-left" style="width:33%">-->
<!--        ASDASDAS-->
<!--    </div>-->
<!---->
<!--    <div class="pull-left" style="width:67%">-->
<!--        <div class="col-xs-3 debug" style="background: url('--><?php //echo $photoTemp->album_thumb ?><!--') no-repeat center center">1</div>-->
<!--        <div class="col-xs-3 debug">2</div>-->
<!--        <div class="col-xs-3 debug">3</div>-->
<!--        <div class="col-xs-3 debug">4</div>-->
<!--        <div class="col-xs-3 debug">1</div>-->
<!--        <div class="col-xs-3 debug">2</div>-->
<!--        <div class="col-xs-3 debug">3</div>-->
<!--        <div class="col-xs-3 debug">4</div>-->
<!--    </div>-->

</div>

<script type="text/javascript">
    // Eliminar album
    function deleteAlbum(album){
        var conf = confirm("¿Está seguro que desea eliminar el álbum?");

        if(conf == true){
            window.location = '<?php echo FConfig::getUrl() ?>actions/albumAction.php?a=' + album + '&act=deleteAlbum';
        }
    }

    /* The androb way */
    (function(jQuery){
        jQuery('.trigger-share').colorbox({
            inline:true,
            href:'#referrals_modal',
            width:'50%',
            onOpen: function(){
                jQuery('#referrals_modal').show();
            },
            onClosed: function() {
                jQuery('#referrals_modal').hide();
            }
        });

        jQuery('.photo-principal').each(function(){
            var target = jQuery(this).attr('data-gallery-target');
            jQuery('.' + target).colorbox({
                rel: target,
                photo:true,
                maxHeight: '97%',
                current: '',
                fixed:true
            });
        });

    }(jQuery));

    jQuery('#referrals_modal .addthis_toolbox a').click(function(){
        // Event: Referidos - Invitar amigo
        var media = '';
        var classMedia = jQuery(this).attr('class');
        if (classMedia.indexOf("addthis_button_facebook") > -1){
            media = 'facebook';
        } else if (classMedia.indexOf("addthis_button_twitter") > -1){
            media = 'twitter';
        } else if (classMedia.indexOf("addthis_button_google_plusone_share") > -1){
            media = 'googleplus';
        } else if (classMedia.indexOf("addthis_button_email") > -1){
            media = 'email';
        }

        fototeaTracking.sendEvent('Referidos - Invitaciones', 'Invitación desde ' + media, <?php echo $currentUser->id; ?>);
    });

</script>
