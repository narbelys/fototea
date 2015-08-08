<?php include("connect/database.php"); 
validaSession();
securityValidation($_COOKIE['id'],"14");

if (isset($_GET['i'])){
	$rs_banDel = mysql_fetch_object(listAll("banners","WHERE id = $_GET[i]"));
	deletePhoto($rs_banDel->img,"../../www/beta/fototea/banners/");
	eliminarRegistro('banners', 'id',$_GET['i']); 
    
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
<script type="text/javascript" src="js/custom/dashboard.js"></script>
<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
<script>	
function eliminar(id){
	
	
	var c = confirm('Esta seguro que quiere eliminar el registro');
	var cc = '#reg' + id;
		if(c){
			 jQuery(cc).fadeOut('slow');
		window.location="banner.php?i="+id;
	
		}
	
	
}

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
                	<li class="current"><a href="banner.php">Banner</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                	<ul class="widgetlist">
                    	<li><a href="banner-agregar.php" class="add">Agregar</a></li>
                        <li><a href="banner.php" class="list current">Lista</a></li>
                    	
                       
                    </ul>
                    
                    <br clear="all" /><br />
                   
                    <div class="contenttitle radiusbottom0">
                	<h2 class="button"><span>Listado de Banner de pagina principal</span></h2>
                </div><!--contenttitle-->
                <table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb" id="dyntable">
                    <colgroup>
                       <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                    </colgroup>
                    <thead>
                        <tr>
                           <th width="10%" class="head1">Orden</th>
                           <th width="35%" class="head0">Imagen</th>
                            <th width="30%" class="head1">titulo</th>
                            <th width="25%" class="head0">&nbsp;</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $banner=  listAll("banners"," ORDER BY orden ASC");
					while($rs_banner = mysql_fetch_object($banner)){
					?>
                        <tr class="gradeX" id="reg<?php echo $rs_banner->id;?>">
                         <td align="center"><?php echo $rs_banner->orden;?>  </td>
                         <td align="center"><img src="<?php echo FConfig::getUrl('banners/'.$rs_banner->img) ?>" width="200" /> </td>
                            <td><?php echo $rs_banner->titulo;?>  </td>
                            <td class="center"><a href="banner-detalles.php?i=<?php echo $rs_banner->id;?>" class="edit">Ver detalles </a>&nbsp; <a href="banner-editar.php?i=<?php echo $rs_banner->id;?>" class="edit">Editar </a>&nbsp; <a href="#" class="delete" onclick="eliminar('<?php echo $rs_banner->id;?>')">Eliminar</a></td>
                        </tr>
                       <?php } ?>
                    </tbody>
                </table>
                   
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