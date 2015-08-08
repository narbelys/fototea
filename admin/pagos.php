<?php include("connect/database.php"); 
validaSession();
securityValidation($_COOKIE['id'],"10");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Pagos realizados</title>
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
		window.location="pagos.php?i="+id;
	
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
                	<li class="current"><a href="pagos.php">Pagos realizados</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                	<ul class="widgetlist">
                        <li><a href="pagos.php" class="list current">Lista</a></li>
                    	
                       
                    </ul>
                    
                    <br clear="all" /><br />
                   
                    <div class="contenttitle radiusbottom0">
                	<h2 class="calendar"><span>Listado de transacciones</span></h2>
                </div><!--contenttitle-->
                <table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb" id="dyntable">
                    <colgroup>
                        <col class="con0" />
                        <col class="con1" />
                        <col class="con0" />
                    </colgroup>
                    <thead>
                        <tr>
                           <th width="40%" class="head1">Proyecto</th>
                            <th width="20%" class="head0">Monto</th>
                            <th width="25%" class="head0">Fecha</th>
                            <th width="15%" class="head0">&nbsp;</th>
                        </tr>
                        </tr>
                    </thead>
                    <tbody>
                    <?
					$pro=  listAll("proyectos,pro_transactions","WHERE t_pro_id = pro_id AND t_status = 'P' ORDER BY t_pdate DESC");
					while($rs_pro= mysql_fetch_object($pro)){
					?>
                        <tr class="gradeX" id="reg<?=$rs_pro->pro_id;?>">
                         <td><?=$rs_pro->pro_tit;?></td>
                            <td align="center">$ <?=number_format($rs_pro->t_monto,2,",",".");?> </td>
                            <td align="center"><?=dateField($rs_pro->t_pdate);?>  </td>
                            <td class="center"><a href="pagos-detalles.php?i=<?=$rs_pro->t_id;?>" class="edit">Ver detalles</a></td>
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