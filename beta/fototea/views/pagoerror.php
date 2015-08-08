<?php
/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 6/13/14
 * Time: 1:44 AM
 */

use Fototea\Util\UrlHelper;

$file = 'pagoerror.txt';

$content = "-----------------------------------------------------------------------------------------";
$content .= "\nGET\n";
$content .= json_encode($_GET);

$content .= "\n\nPOST\n";
$content .= json_encode($_POST);
$content .= "\n\n";

//file_put_contents($file, $content, FILE_APPEND);

?>

<div class="content-container">
    <div class="content form-page" id="metodo-pago-container">
        <h2>Lo sentimos, su pago no ha podido ser procesado</h2>
        <form action="actions/paymentAction.php" method="post" id="metodo-pago-form" class="metodo-pago-form">
            <p>Lamentable su pago no ha podido ser procesado, si desea mas información contactenos a traves de la sección
            de contacto o intente nuevamente</p>

            <p><a href="<?php echo UrlHelper::getProfileUrl(); ?>">Volver a mi perfil</a></p>
</form>
</div>
</div>