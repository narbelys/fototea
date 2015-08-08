<?php
    use Fototea\Models\User;
    use Fototea\Config\FConfig;
    use Fototea\Util\UrlHelper;
?>

<script src="<?php echo FConfig::getUrl('js/popModal.js') ?>"></script>

<div class="profile-container">
    <div class="cover-perfil under-header">
        <img id="coverMainImage" class="cover-image" alt="" src="<?php echo $cover_url ?>"/>
    </div>

    <div class="info-perfil-container">
        <div class="profile-box">
            <div class="wizard-step1"></div>
            <div class="perfil-name">
                <?php echo $user_info['full_name'] ?> <?php if($same_user): ?>
                    <a href="editarPerfil" class="btn btn-primary btn-xs profile-edit-options">Editar Perfil</a>
                <?php endif ?>
            </div>

            <div class="perfil-image-box ">
                <div>
                    <img class="img-circle" id="profileMainImage" alt="Imagen de perfil" src="<?php echo $profile_url ?>" width="106" height="106">
                </div>
                <div class="rating-n"><!--<?php  echo $review['stars'] ?>--></div>
                
            </div>

            <div class="perfil-desc <?php echo (empty($user_info['descripcion']) ? 'empty' : '') ?>">
                <?php if (!empty($user_info['descripcion'])): ?>
                    <b><?php echo $user_info['ciudad'] ?></b>
                    <p><?php echo $user_info['descripcion'] ?></p>
                <?php endif ?>
            </div>
        </div>
        <?php if ($current_user->user_type == User::USER_TYPE_PHOTOGRAPHER): ?>
            <div class="search-box">
                <form action="resultados" method="post" class="search-form">
                    <input type="submit" name="button" id="button" value="" class="search-btn" />
                    <input type="text" id="buscador" name="buscador" class="search-input" autocomplete="off" title="buscador" placeholder="Buscar Proyecto...">
                </form>
            </div>
        <?php endif ?>
    </div>

    <div class="info-tabs-container">
        <!-- TABS -->
        <div class="tab-box">
            <?php if ($same_user): ?>
                <?php if ($user_info['user_type'] == User::USER_TYPE_PHOTOGRAPHER): ?>
                    <div class="tab <?php if($current_tab =="proyectos"): ?>selected<?php endif ?> left"><a href="perfil?us=<?php echo $user_info['act_code'];?>&act=proyectos">Proyectos</a></div>
                <?php endif ?>
                <div class="tab <?php if($current_tab =="misproyectos"): ?>selected<?php endif ?> left"><a href="perfil?us=<?php echo $user_info['act_code'];?>&act=misproyectos">Mis Proyectos</a></div>
            <?php endif ?>
            <?php if ($user_info['user_type'] == User::USER_TYPE_PHOTOGRAPHER): ?>
                <div class="tab <?php if($current_tab =="portafolio"): ?>selected<?php endif ?> left"><a href="perfil?us=<?php echo $user_info['act_code'];?>&act=portafolio">Portafolio</a></div>
            <?php endif ?>
            <div class="tab <?php if($current_tab =="info"): ?>selected<?php endif ?> left"><a href="perfil?us=<?php echo $user_info['act_code'];?>&act=info">Info</a></div>
            <div class="tab <?php if($current_tab =="reviews"): ?>selected<?php endif ?> left"><a href="perfil?us=<?php echo $user_info['act_code'];?>&act=reviews">Evaluaci&oacute;n</a></div>
            <?php if ($same_user): ?>
                <?php if ($user_info['user_type'] == User::USER_TYPE_PHOTOGRAPHER): ?>
                    <div class="tab <?php if($current_tab =="finanzas"): ?>selected<?php endif ?> left"><a href="perfil?us=<?php echo $user_info['act_code'];?>&act=finanzas">Finanzas</a></div>
                <?php endif ?>
            <?php endif ?>
        </div>
        <!-- END TABS -->
    </div>

    <?php if ($same_user): ?>
        <?php if ($current_user->user_type == User::USER_TYPE_PHOTOGRAPHER): ?>
            <div class="user-balance-options">
                <span class="arrow-left"></span>
                <a class="show-my-balance" href="<?php echo UrlHelper::getUrl('perfil?act=finanzas') ?>"><span class="balance-amount">$ <?php echo number_format($user_balance,2,",",".");?></span> por cobrar</a>
            </div>
        <?php endif ?>

        <?php if ($current_user->user_type == User::USER_TYPE_CLIENT): ?>
            <div class="user-balance-options">
                <span class="arrow-left"></span>
                <a class="create-new-project wizard-step4" href="<?php echo FConfig::getUrl('agregarProyecto') ?>">Publicar un proyecto</a>
            </div>
        <?php endif ?>

        <div class="profile-image-options">
            <div class="wizard-step2"></div>
            <button class="edit-my-picture profile btn btn-primary" onclick="androbCrop.run('profile', '<?php echo $profile_edit_url ?>')">Editar imagen perfil</button>
            <button class="edit-my-picture cover btn btn-primary"  onclick="androbCrop.run('cover', '<?php echo $cover_edit_url ?>')">Editar cover</button>
            <div class="wizard-step3"></div>
        </div>
    <?php endif ?>
</div>

<?php if ($loggedUser->wizard_completed == false): ?>
    <div class="wizard-step1-content" style="display: none;">
        <b>¡Bienvenido a Fototea!</b>
        <p>En esta sección se mostrará la información de tu perfil que puedes personalizar cuando quieras haciendo click en el botón "Editar perfil". Es muy importante que completes tu perfil para disfrutar los beneficios de Fototea.</p>
    </div>
    <div class="wizard-step2-content" style="display: none;">
        <b>Personaliza tu imagen de perfil</b>
        <p>Para personalizar tu imagen de perfil haz click en "Editar imagen perfil" y podrás subir una nueva imagen.</p>
    </div>
    <div class="wizard-step3-content" style="display: none;">
        <b>Personaliza tu imagen de cover</b>
        <p>Para cambiar la imagen que se muestra de fondo en tu perfil haz click en "Editar cover" y podrás subir una nueva imagen de fondo.</p>
    </div>
    <div class="wizard-step4-content" style="display: none;">
        <b>Publica tus proyectos</b>
        <p>Puedes publicar tus proyectos haciendo click en este enlace.</p>
    </div>

    <script type="text/javascript">
        var welcomeWizard = {
            step1: function(){
                var element = jQuery('.wizard-step1');
                jQuery('.profile-edit-options').addClass('visible');
                welcomeWizard.drawPopModal(element, jQuery('.wizard-step1-content').html(), 'rightTop', 2);
            },

            step2: function(){
                var element = jQuery('.wizard-step2');
                jQuery('.profile-image-options').addClass('visible');
                welcomeWizard.drawPopModal(element, jQuery('.wizard-step2-content').html(), 'leftBottom', 3);
            },

            step3: function(){
                var element = jQuery('.wizard-step3');
                jQuery('.profile-image-options').addClass('visible');
                welcomeWizard.drawPopModal(element, jQuery('.wizard-step3-content').html(), 'bottomRight', <?php echo ($current_user->user_type == User::USER_TYPE_CLIENT) ? 4 : 0 ?>);
            },

            step4: function(){
                var element = jQuery('.wizard-step4');
                welcomeWizard.drawPopModal(element, jQuery('.wizard-step4-content').html(), 'rightCenter', 0);
            },

            addLink: function(elem, msg){
                msg += '<a class="wizard-step-link" onclick="jQuery(\''+ elem.selector +'\').popModal(\'hide\')">Entendido</a>';

                return msg;
            },

            wizardCompleted: function(){
                jQuery('.profile-edit-options').removeClass('visible');
                jQuery('.profile-image-options').removeClass('visible');
                jQuery.ajax({
                    type: 'get',
                    dataType: 'json',
                    url: "<?php echo FConfig::getUrl('actions/perfilAction.php?act=wizardCompleted&act-code=') ?>",
                    data: {'act-code':'<?php echo $loggedUser->act_code; ?>', act:"wizardCompleted"},
                    success: function(json){
                        if (json.status == 'success'){
                            console.log('success');
                        } else {
                            console.log('error');
                        }
                    }
                });
            },

            drawPopModal: function(elem, msg, placement, nextStep){
                msg = welcomeWizard.addLink(elem, msg);

                jQuery(elem).popModal({
                    html : msg,
                    placement : placement,
                    showCloseBut : true,
                    onDocumentClickClose : false,
                    onOkBut : function(){},
                    onCancelBut : function(){},
                    onLoad : function(){},
                    onClose : function(){
                        switch (nextStep){
                            case 2:
                                setTimeout(function() { welcomeWizard.step2(); },700);
                                break;
                            case 3:
                                setTimeout(function() { welcomeWizard.step3(); },700);
                                break;
                            case 4:
                                setTimeout(function() { welcomeWizard.step4(); },700);
                                break;
                            case 0:
                                welcomeWizard.wizardCompleted();
                                break;
                        }
                    }
                });
                jQuery(elem).trigger('click');
            }
        };

        jQuery(document).ready(function(){
            
            setTimeout(function() { welcomeWizard.step1(); },1250);
        });
        
        
                
                

    </script>
<?php endif ?>