<?php
    use Fototea\Models\Referral;
    use Fototea\Models\User;
    use Fototea\Models\Credit;
    use Fototea\Util\FAnalytics;

    $user_code = $_REQUEST['c'];

    $list = listAll("user", "WHERE act_code='$user_code'");
    @$val = mysql_num_rows($list);

    if($val > 0){

        $user = mysql_fetch_object($list);

        $user_update = updateTable("user", "act='S'", "act_code='$user_code'");
        $mss = '&iexcl;Tu cuenta ha sido activada con &eacute;xito!<br><br><a href="login" class="txtAzul">Entrar a tu cuenta</a>.';

        // Create user profile folder
        $folder_id = sha1($user->id);
        $dir = "../profiles/".$folder_id;
        $dir2 = $dir."/";
        @mkdir($dir2, 0777, true);

        // Event = Confirmacion de registro
        $events = FAnalytics::getInstance();
        if ($user->user_type == User::USER_TYPE_PHOTOGRAPHER){
            $events->trackEvent('Usuario - Confirmaciones de registro', 'Confirmación de fotógrafo', $user->user_type);
        } else {
            $events->trackEvent('Usuario - Confirmaciones de registro', 'Confirmación de cliente', $user->user_type);
        }

        // Add referral to referring user if exists
        if (isset($_GET['ru']) && isset($_GET['ru'])){
            $referringUserId = $_GET['ru'];
            $media = $_GET['rm'];

            if ($referringUserId != null){
                $referral = new Referral();
                $referral->referringUser = $referringUserId;
                $referral->referredUser = $user->id;
                $referral->media = $media;
                $referral->newReferral();

                // Si tiene cantidad de referrals suficiente, convertir en credits
                $idsRefToCred = Referral::checkAvailableReferral($referringUserId);

                if ($idsRefToCred != false){
                    Credit::newCredit($referringUserId);
                    Referral::markReferralAsExchanged($referringUserId);
                }

                // Event: Referidos - Registrados totales
                $eventData = new stdClass();
                $eventData->referring_user = $referringUserId;
                $eventData->referred_user = $user->id;

                if ($user->user_type == User::USER_TYPE_PHOTOGRAPHER){
                    $events->trackEvent('Referido - Registros confirmados', 'Confirmación fotógrafo', $user->id);
                } else {
                    $events->trackEvent('Referido - Registros confirmados', 'Confirmación cliente', $user->id);
                }
            }
        }
    }else{
        $mss = "No se ha encontrado una cuenta que concuerde con los datos suministrados. Si cree que esto es un error por favor p&oacute;ngase en contacto con nosotros.";
    }
?>

<div class="registroContainer">
    <h2 class="main-title">Confirmaci&oacute;n</h2>
    <p><?php echo $mss;?></p>
</div>