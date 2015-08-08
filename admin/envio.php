<?php include("connect/database.php"); 
validaSession();
securityValidation($_COOKIE['id'],"20");

if ($_POST){
	$we = "value = '".$_POST['price']."'";
	 
	updateTable("varios",$we,"id = 1");
	
	
	
	
}

$varios = listAll("varios","WHERE id = 1");
$rs_var = mysql_fetch_object($varios);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Envio | Vaodesign</title>
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
			price: "required",
			
			
		},
		messages: {
			price: "Este campo es requerido",
			
			
			
		}
	});
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
                	<li class="current"><a href="mi-perfil">Envio</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                	
                    
                   
                   
                  <div class="contenttitle radiusbottom0">
                	<h2 class="widgets"><span>Precio del envio</span></h2>
                </div><!--contenttitle-->
                    
                    <br />
                    
                    <form id="form1" class="stdform" method="post" action="">
                    	<p>
                        	<label>Precio:</label>
                            <span class="field"><input name="price" type="text" class="longinput" id="price" value="<?php echo $rs_var->value;?>" /></span>
                        </p>
                        
                        
                    <br clear="all" /><!--contenttitle-->
                     
                   
                        
                        <p class="stdformbutton" align="right">
                        	<button class="submit radius2">Modificar</button>
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
