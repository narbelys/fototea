<?php

use Fototea\Config\FConfig;
use Fototea\Models\User;
use Fototea\Models\Project_View;

/**
 *
 * @var $current_user (object) contains information about the current logged user or false
 * @var $user_info    (array) contains information about profile owner (the owner can be the same as the logged user)
 * @var $same_user    (boolean) tell if the current logged user is the current profile owner as well (useful to enable
 * user specific actions which a user can perform over his own profile (like edit my profile)
 * @var $current_tab  (string) the current profile tab (info, evaluacion, etc)
 * @var $user_balance (float) user pending wages
 */

$session = validaSession();
//if($session == true){

$loggedUser = getCurrentUser();

$usId = getUserId($_GET['us']);

if ((!$usId) && ($currentUser)) {
    $usId = $currentUser->id;
}

$user_info = getUserInfo($usId); //representa la informacion del perfil que se esta mostrando ( puede ser el mismo usuario logueado o no)
$same_user = false; //Used to enable profile actions

$current_user = getCurrentUser(); //the current user
if (!$current_user) {
    die('invalid user'); //TODO handle this
} else {
    if ($current_user->id == $user_info['id']) {
        $same_user = true;
    }
}

//REVIEWS TAB
$review = ratings($user_info['id']);

$img_cover = $user_info['cover_image_url'];
$img_profile = $user_info['profile_image_url'];

$cover_url = FConfig::getThumbUrl($img_cover, FConfig::getValue('cover_image_width'), FConfig::getValue('cover_image_height'));
$profile_url = FConfig::getThumbUrl($img_profile, FConfig::getValue('profile_image_width'), FConfig::getValue('profile_image_height'));

$cover_edit_url = FConfig::getThumbUrl($img_cover, 400, 400);
$profile_edit_url = FConfig::getThumbUrl($img_profile, 400, 400);

$user_info['ciudad'] = ucfirst($user_info['ciudad']);
$user_info['descripcion'] = substr(ucfirst($user_info['descripcion']),0,140);

$current_tab = $_GET['act'];

if (!$current_tab) {
    if ($same_user) {
        if ($user_info['user_type'] == User::USER_TYPE_PHOTOGRAPHER){
            $current_tab = 'proyectos';
        } else {
            //cliente
            $current_tab = 'misproyectos';
        }
    } else {
        $current_tab = "info";
    }
}

$user_balance = null;
if (($same_user) && ($user_info['user_type'] == User::USER_TYPE_PHOTOGRAPHER)){
    $user_balance = Project_View::getTotalProjectReceivableByUser($current_user->id);
}

if ($same_user) {
    $user_new_messages = mensajesNuevos($current_user->id);
}
?>

<!-- CAJA DE IMAGEN (Cover, Foto de perfil y tabs) -->
<?php include 'views/common/cover.php'; ?>
<!-- END CAJA DE IMAGEN -->

<!-- MENSAJES DE SISTEMA -->
<?php include_once 'views/common/messages.php'; ?>
<!-- END MENSAJES DE IMAGEN -->

<!-- CONTENIDO DEL PERFIL -->
<div class="content-container">
    <div class="content">
    <?php if($user_info['act'] == User::USER_STATUS_ACTIVE):
        if (file_exists('views/include/' . $current_tab . '.php')):
            include 'views/include/' . $current_tab . '.php';
        else:
            die('redirect home here');
        endif;
    else:
        die('redirect home here');
    endif ?>
    </div>
</div>
<!-- CONTENIDO DE PERFIL -->

<!-- CROP PROFILE -->
<?php include_once 'perfiles/cropProfile.php'; ?>
<script src="<?php echo FConfig::getUrl('js/perfil.js') ?>"></script>
<!-- END CROP PROFILE -->

