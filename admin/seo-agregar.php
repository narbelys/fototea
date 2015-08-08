<?php include("connect/database.php"); 
validaSession();
securityValidation($_COOKIE['id'],"11");


if($_POST){

	$values = "'','".$_POST['page']."','".$_POST['title']."','".$_POST['description']."','".$_POST['keyword']."'";
	$glosarioIn = insertTable("seo",$values);
	if($glosarioIn != false){
	
	?>
<script>
	alert("Se ha agregado la pagina correctamente.");
	window.location="seo.php";
	</script>
    <?
	}else{ ?>
    <script>
	alert("No se ha  podido agregar la pagina correctamente.");
	window.history.back();
	</script>
    <?
	}
	
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>SEO</title>
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
<script type="text/javascript" src="js/plugins/wysiwyg/jquery.wysiwyg.js"></script>
<script type="text/javascript" src="js/plugins/wysiwyg/wysiwyg.image.js"></script>
<script type="text/javascript" src="js/plugins/wysiwyg/wysiwyg.link.js"></script>
<script type="text/javascript" src="js/plugins/wysiwyg/wysiwyg.table.js"></script>
<script type="text/javascript" src="js/plugins/jquery-ui-1.8.2.custom.min.js"></script> 
<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
<script>

jQuery(document).ready(function(){
//FORM VALIDATION
	jQuery("#form1").validate({
		rules: {
			page: "required",
			title: "required",
			description: "required",
			
			
			
		},
		messages: {
			page: "Este campo es requerido",
			title: "Este campo es requerido",
			description: "Este campo es requerido",
			
			
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
                	<li class="current"><a href="seo.php">SEO</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                	<ul class="widgetlist">
                    	<li><a href="#" class="add current">Agregar</a></li>
                        <li><a href="seo.php" class="list">Lista</a></li>
                    	
                       
                    </ul>
                    
                    <br clear="all" /><br />
                   
                    <div class="contenttitle radiusbottom0">
                	<h2 class="tag"><span>Datos de la pag&Iacute;na</span></h2>
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
                        	<label>Pag&iacute;na:</label>
                            <span class="field"><input type="text" name="page" id="page" class="longinput" /></span>
                        </p>
                        <p>
                        	<label>Titulo:</label>
                            <span class="field"><input type="text" name="title" id="title" class="longinput"  maxlength="70" /></span>
                        </p>
                        <p>
                        	<label>Descripci&oacute;n:</label>
                            <span class="field"><input type="text" name="description" id="description" class="longinput"  maxlength="150" /></span>
                        </p>
                        <p>
                        	<label>Keywords:</label>
                            <span class="field"><input type="text" name="keyword" id="keyword" class="longinput"  maxlength="120"/></span>
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
