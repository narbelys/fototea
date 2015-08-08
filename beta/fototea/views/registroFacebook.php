<div id="facebookBox">
<h2>Registro</h2> Ya tienes una cuenta? <a href="login" class="txtAzul bold">Entra</a>
      <div id="fb-root"></div>
      <script src="http://connect.facebook.net/en_US/all.js">
      </script>
      <script>
         FB.init({ 
            appId:'1439029029658789', cookie:true, 
            status:true, xfbml:true 
         });
      </script>
         <fb:registration
            fields="[
            {'name':'name'},
            {'name':'first_name'},
            {'name':'last_name'}, 
            {'name':'email'},
            {'name':'gender'},
            {'name':'birthday'},
            {'name':'password'},
            {'name':'user_type',    'description':'Tipo de usuario',             'type':'select',    'options':{'1':'Creativo','2':'Cliente'}},
            ]" redirect-uri="<?php echo FConfig::getUrl('actions/facebookAction.php'); ?>">
    </fb:registration>
</div>