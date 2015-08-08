<?php include("connect/database.php"); 
validaSession();
//securityValidation($_COOKIE['id'],"1");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Inicio</title>
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
<script type="text/javascript" src="js/custom/general.js"></script>
<script type="text/javascript" src="js/custom/dashboard.js"></script>
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
                	<li class="current"><a href="dashboard">Inicio</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                	 <?php $tab = 0;
				$acc = moduleValidation($_COOKIE['id'],"14");
				if ($acc == true){
					$tab = $tab + 1;
				?>
                    
                    <div class="one_half">
                    
                    	<div class="widgetbox">
                        <div class="title">
                          <h2 class="buttons"><span>Banner principal</span></h2></div>
                        <div class="widgetcontent announcement">
                             <table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb" id="dyntable">
                    <colgroup>
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />         
                    </colgroup>
                    <thead>
                        <tr>
                           <th width="15%" class="head1">Order</th>
                          <th width="40%" class="head0">Imagen</th>
                         <th width="45%" align="left" class="head1">Titulo</th>
                        </tr>
                        
                    </thead>
                    <tbody>
                    <?php $not =  listAll("banners","ORDER BY orden ASC LIMIT 0,5");
					while($rs_not = mysql_fetch_object($not)){ ?>
                        <tr class="gradeX" id="reg<?php echo $rs_not->id;?>" onclick="window.location='banner-detalles.php?i=<?php echo $rs_not->id;?>'">
				<td align="center"><?php echo $rs_not->orden;?></td>
                         	<td align="center"><img src="<?php echo FConfig::getUrl('banners/'.$rs_not->img) ?>" width="200" /></td>
                            <td><?php echo $rs_not->titulo;?></td>
                        </tr>
                       <?php } ?>
                    </tbody>
                </table>
                   
                              
                               <p align="right"><a href="banner.php"> Ver todos >></a></p>
                        </div><!--widgetcontent-->
                    </div><!--widgetbox-->
                        
                    </div><!--one_half-->
                    
                     <?php } 
				
				$acc = moduleValidation($_COOKIE['id'],"1111");
				if ($acc == true){
					$tab = $tab + 1;
				?>
                    
                      <div class="one_half <?php if ($tab == 2 || $tab == 4){?>last<?php } ?>">
                    
                    	<div class="widgetbox">
                        <div class="title">
                          <h2 class="calendar"><span>Portafolio</span></h2></div>
                        <div class="widgetcontent announcement">
                             <table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb" id="dyntable">
                    <colgroup>
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                        <col class="con1" />         
                    </colgroup>
                    <thead>
                        <tr>
                           <th width="15%" class="head1">#</th>
                          <th width="40%" class="head0">Imagen</th>
                         <th width="45%" align="left" class="head1">Titulo</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody>
                    <?php $not =  listAll("portafolio","ORDER BY fecha DESC LIMIT 0,5");
					while($rs_not = mysql_fetch_object($not)){ 
					$imagen_not = listAll("galeria","WHERE not_id = '".$rs_not->id."' AND type = 'P' ORDER BY id ASC LIMIT 0,1");
			   		$rs_imagen = mysql_fetch_object($imagen_not);
					?>
                        <tr class="gradeX" id="reg<?php echo $rs_not->id;?>" onclick="window.location='portafolio-detalle.php?i=<?php echo $rs_not->id;?>'">
				<td align="center"><?php echo $rs_not->id;?></td>
                         	<td align="center"><img src="../portafolio/<?php echo $rs_imagen->img;?>" width="100"/></td>
                            <td><?php echo $rs_not->titulo;?></td>
                        </tr>
                       <?php } ?>
                    </tbody>
                </table>
                   
                              
                               <p align="right"><a href="portafolio.php"> Ver todos >></a></p>
                        </div><!--widgetcontent-->
                    </div><!--widgetbox-->
                        
                    </div><!--one_half-->
                    
                     <?php } ?>
			
					        <br clear="all" /><br />
                    
            </div><!--maincontentinner-->
            
            <div class="footer">
            	<?php include("footer.php"); ?>
            </div><!--footer-->
            
        </div><!--maincontent-->
        
       
                
     	</div><!--mainwrapperinner-->
    </div><!--mainwrapper-->
	<!-- END OF MAIN CONTENT -->
    </div>

</body>
</html>