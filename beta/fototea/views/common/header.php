<?php
/** DEPRECATED NOT IN USE */
/**
 * Created by PhpStorm.
 * User: Jose Troconis
 * Date: 3/30/14
 * Time: 11:40 PM
 */
?>

<div class="headerContainer">
    <div class="header">
        <div class="logo">
            <a href="<?php if($session == true){ echo "miHome"; } else { echo "home";}?>">
                <img alt="Fototea" src="<?php echo FConfig::getUrl('images/logo_fototea.png'); ?>" border="0" title="Fototea" height="39">
            </a>
        </div>
        <div class="containerMenuInicio">
            <div class="menuInicio"><a href="contratar">Contratar</a></div>
            <span>|</span>
            <div class="menuInicio"><a href="trabajar">Trabajar</a></div>
            <span>|</span>
            <div class="menuInicio"><a href="faq">FAQ</a></div>
        </div>
        <div class="containerLogin">
            <?php if($session == false){ ?>
                <div class="btn_naranja"> <a href="login">Login</a></div>
                <div class="btn_azulOscuro"><a href="registro">Registrarse</a></div>
            <?php } else {?>
                <div class="containerLogingIn ">Bienvenido <a href="miHome"><?php echo ucwords($_COOKIE['user']);?></a> <span>|</span> <a href="signOut">Salir</a></div>
            <?php } ?>
        </div>

    </div><!-- /header -->
</div><!-- /headeContainerr -->