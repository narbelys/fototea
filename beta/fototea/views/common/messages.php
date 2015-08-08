<?php
//$app->addMessage('Este mensaje es patrocinado por <b>fototea boys</b>');
//$app->addError('Este error es patrocinado por <b>fototea boys</b>');
?>

<?php if ($app->hasErrors() || $app->hasMessages()): ?>
<div class="messages-container">
    <div class="content">

        <!-- Los feos no hay base de datos, errores de sistema -->
        <?php if ($app->hasErrors()): ?>
        
        <?php foreach ($app->getErrors() as $error): ?>
        <div class="alert alert-danger alert-dismissable" style="">
          <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
          <span class="glyphicon glyphicon glyphicon-ban-circle"></span> &nbsp; <strong>¡Error!</strong> <?php echo $error ?>
        </div>
        <?php endforeach ?>


        <?php endif ?>
        <!-- End los feos -->

        <!-- Los los bonitos success, mensajes de exito y esas cosas -->
        <?php if ($app->hasMessages()): ?>
            <?php foreach ($app->getMessages() as $error): ?>
            <div class="alert alert-success alert-dismissable" style="">
              <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
               <span class="glyphicon glyphicon-ok"></span>&nbsp;<strong> ¡Éxito!</strong> <?php echo $error ?>
            </div>

            <?php endforeach ?>
        <?php endif ?>
        <!-- End los bonitos -->

    </div>
</div>
<?php endif ?>
