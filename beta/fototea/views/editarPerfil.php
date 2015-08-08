<?php

use Fototea\Models\User;
use Fototea\Util\UrlHelper;

$session = validaSession();

if($session == true){
	$userInfo = getUserInfo($_COOKIE['id']);
	if($userType == User::USER_TYPE_PHOTOGRAPHER){
		include_once 'perfiles/editarFotografo.php';
	}elseif($userType == User::USER_TYPE_CLIENT){
		include_once 'perfiles/editarCliente.php';
	}
} else {
    $app->redirect(UrlHelper::getUrl('home'));
}

?>

<script type="text/javascript">
    function cancelNewEmail(userId){
        jQuery.ajax({
            type: 'get',
            dataType: 'json',
            url: 'actions/perfilAction.php',
            data: { user_id: userId ,act:"cancel_new_email"},
            success: function(response){
                if (response.status == 'success'){
                    jQuery('.new-email-alert').remove();
                }
            }
        });
    }
</script>