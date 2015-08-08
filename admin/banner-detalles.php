<?php include("connect/database.php"); 
validaSession();
securityValidation($_COOKIE['id'],"14");



$ban = listAll("banners","WHERE	id = $_GET[i]");
$rs_ban = mysql_fetch_object($ban);


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
                    	<li><a href="banner-agregar.php" class="add">Agregar</a></li>
                        <li><a href="banner.php" class="list">Lista</a></li>
                    	
                       
                    </ul>
                    
                    <br clear="all" /><br />
                   
                    <div class="contenttitle radiusbottom0">
                	<h2 class="button"><span>Datos del banner</span></h2>
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
                        	<label>Imagen Actual:</label>
                            <span class="field"><img src="<?php echo FConfig::getUrl('banners/'.$rs_ban->img) ?>" width="600" /></span>
                        </p>

                        <p>
                        	<label>Titulo:</label>
                            <span class="field"><?php echo $rs_ban->titulo;?></span>
                        </p>
                         <p>
                        	<label>Texto:</label>
                            <span class="field"><?php echo $rs_ban->texto;?></span>
                        </p>
                        <p>
                        	<label>Orden:</label>
                            <span class="field"><?php echo $rs_ban->orden;?></span>
                        </p>
                        
                       
                        <br clear="all" />

                       
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
