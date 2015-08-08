<?php include("connect/database.php"); 
validaSession();
securityValidation($_COOKIE['id'],"14");


if($_POST){
	
	$imagen = uploadFile("imagen","../../www/beta/fototea/banners/","50");
	
	$values = "'','".$_POST['titulo']."','".$_POST['texto']."','$imagen','".$_POST['orden']."'";
	$bannerIn = insertTable("banners",$values);
	if($bannerIn != false){
	
	
	?>
<script>
	alert("Se ha agregado el banner correctamente.");
	window.location="banner.php";
	</script>
    <?php }else{ ?>
    <script>
	alert("No se ha  podido agregar el banner correctamente.");
	window.history.back();
	</script>
    <?php }
	
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Banner</title>
<link rel="stylesheet" href="css/style.css" type="text/css" />
<!--[if IE 9]>
    <link rel="stylesheet" media="screen" href="css/ie9.css"/>
<![endif]-->

<!--[if IE 8]>
    <link rel="stylesheet" media="screen" href="css/ie8.css"/>
<![endif]-->

<!--[if IE 7]>
    <link rel="stylesheet" media="screen" href="css/ie7.css"/>
<![endif]-->
<script type="text/javascript" src="js/plugins/jquery-1.7.min.js"></script>
<script type="text/javascript" src="js/plugins/jquery.flot.min.js"></script>
<script type="text/javascript" src="js/plugins/jquery.flot.resize.min.js"></script>
<script type="text/javascript" src="js/plugins/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="js/custom/general.js"></script>
<script type="text/javascript" src="js/custom/tables.js"></script>
<script type="text/javascript" src="js/plugins/jquery.validate.min.js"></script>
<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
<script>
jQuery(document).ready(function(){
//FORM VALIDATION
	jQuery("#form1").validate({
		rules: {
			titulo: "required",
			texto: "required",
			imagen: "required",
			orden: "required",
			
			
			
		},
		messages: {
			titulo: "Este campo es requerido",
			texto: "Este campo es requerido",
			imagen: "Este campo es requerido",
			orden: "Este campo es requerido",
			
		},
	})
	     
		 
	<?php print($error); ?>	 
		 
});
$(document).ready(function(){
	<?php print($error); ?>
});
  
</script>
</head>

<body class="loggedin">

	<!-- START OF HEADER -->
<div class="header radius3">
    	<?php include("top.php"); ?>
	</div><!--header-->
    <!-- END OF HEADER -->
        
    <!-- START OF MAIN CONTENT -->
    <div class="mainwrapper">
     	<div class="mainwrapperinner">
         	
        <div class="mainleft">
          	<?php include("menu.php"); ?>
        </div><!--mainleft-->
        
        <div class="maincontent noright">
        	<div class="maincontentinner">
            	
                <ul class="maintabmenu">
                	<li class="current"><a href="banner">Banner</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                	<ul class="widgetlist">
                    	<li><a href="#" class="add current">Agregar</a></li>
                        <li><a href="banner.php" class="list">Lista</a></li>
                    	
                       
                    </ul>
                    
                    <br clear="all" /><br />
                   
                    <div class="contenttitle radiusbottom0">
                	<h2 class="button"><span>Datos de el banner</span></h2>
                </div><!--contenttitle-->
                      <div id="msgSuccess" class="notification msgsuccess" style="display:none">
                        <a class="close"></a>
                        <p>Se agregó el cliente con éxito.</p>
                    </div><!-- notification msgsuccess -->
                    
                    <div id="msgAlert" class="notification msgalert" style="display:none">
                        <a class="close"></a>
                        <p>No se pudo agregar el cliente, por favor vuelva a intentar.</p>
                    </div><!-- notification msgalert -->
                    <br />
                    
                    <form id="form1" name="form1" class="stdform" method="post" action="" enctype="multipart/form-data">
                    	
                    	 <p>
                        	<label>Titulo:</label>
                            <span class="field"><input type="text" name="titulo" id="titulo"   class="longinput"/></span>
                        </p>
                         <p>
                        	<label>Texto:</label>
                            <span class="field"><input type="text" name="texto" id="texto"   class="longinput"/></span>
                        </p>
                    	<p>
                        	<label>Imagen:</label>
                            <span class="field"><input type="file" name="imagen" id="imagen" class="longinput" />
                            <br /> 
                            Dimensiones recomendadas: 2000px X 470px</span>
                        </p>
                        
                       
                        <p>
                        	<label>Orden:</label>
                            <span class="field"><input type="text" name="orden" id="orden"  class="longinput"/></span>
                        </p>
                        
                       
                        <br clear="all" />

                        <p class="stdformbutton" align="right">
                        	<button class="submit radius2">Agregar</button>
                        </p>
                    </form>
                    
                    <br clear="all" /><br />
                   </div> <!--content-->
            </div><!--maincontentinner-->
            
            <div class="footer">
            	<?php include("footer.php"); ?>
            </div><!--footer-->
            
        </div><!--maincontent-->
        
       
                
     	</div><!--mainwrapperinner-->
    </div><!--mainwrapper-->
	<!-- END OF MAIN CONTENT -->
   

</body>
</html>
