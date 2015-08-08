<?php include("connect/database.php"); 
validaSession();
securityValidation($_COOKIE['id'],"10");


$pro =  listAll("proyectos,pro_transactions,user","WHERE t_id = '$_GET[i]' AND t_pro_id = pro_id AND t_status = 'P' AND user_id = id ORDER BY t_pdate DESC");
$rs_pro= mysql_fetch_object($pro);


$oferta = listAll("ofertas","WHERE id='$rs_pro->t_oferta_id' AND awarded='S'");
$rs_oferta = mysql_fetch_object($oferta);

$oferta_user = listAll("user","WHERE id='$rs_oferta->user_id'");
$rs_oferta_user = mysql_fetch_object($oferta_user);

$paypal_user = listAll("user_det","WHERE id_user='$rs_oferta->user_id' AND id_data='17'");
$rs_paypal = mysql_fetch_object($paypal_user);

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
<script type="text/javascript" src="js/plugins/jquery.validate.min.js"></script> 
<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
<script>
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
                	<li class="current"><a href="pagos.php">Pagos realizados</a></li>
                </ul><!--maintabmenu-->
                
                <div class="content">
                	<ul class="widgetlist">
                    	
                        <li><a href="pagos.php" class="list">Lista</a></li>
                    	
                       
                    </ul>
                    
                    <br clear="all" /><br />
                   
                    <div class="contenttitle radiusbottom0">
                	<h2 class="calendar"><span>Datos del pago</span></h2>
                </div><!--contenttitle-->
                      
                   
                    
                    <form id="form1" name="form1" class="stdform" method="post" action="" enctype="multipart/form-data">
                    	<p>
                        	<label><strong>Proyecto:</strong></label>
                            <span class="field"><?=$rs_pro->pro_tit;?></span>
                        </p>
                        
                        <p>
                        	<label><strong>Monto:</strong></label>
                            <span class="field">$  <?=number_format($rs_pro->t_monto,2,",",".");?> </span>
                        </p>
                         <p>
                        	<label><strong>Id de la transaccion:</strong></label>
                            <span class="field">  <?=$rs_pro->t_trans_id;?></span>
                        </p>
                          <p>
                        	<label><strong>Fecha del pago:</strong></label>
                            <span class="field"><?=dateField($rs_pro->t_pdate);?></span>
                        </p>
                         <p>
                        	<label><strong>Nombre del usuario:</strong></label>
                            <span class="field">  <?=$rs_pro->name." ".$rs_pro->lastname;?></span>
                        </p>
                         <p>
                        	<label><strong>Email:</strong></label>
                            <span class="field">  <?=$rs_pro->user;?></span>
                        </p>
                        

                    
                        <div class="contenttitle radiusbottom0">
                    <h2 class="calendar"><span>Datos del usuario que recibe el pago</span></h2>
                        </div>
                       <p>
                        	<label><strong>Nombre del usuario:</strong></label>
                            <span class="field">  <?=$rs_oferta_user->name." ".$rs_oferta_user->lastname;?></span>
                        </p>
                         <p>
                        	<label><strong>usuario Paypal:</strong></label>
                            <span class="field">  <?=$rs_paypal->description;?></span>
                        </p>
                         <p>
                        	<label><strong>Email:</strong></label>
                            <span class="field">  <?=$rs_oferta_user->user;?></span>
                        </p>
                        
                       
                      <br clear="all" />

                        <p class="stdformbutton" align="right">
                        	
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
