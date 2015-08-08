<?php

include '../scripts/libSM.php';

$proj = listAll("proyectos", "WHERE pro_status = 'A' AND pro_date_end < NOW()");
while($rs_proj = mysql_fetch_object($proj)){
	$end_pro = $rs_proj->por_date_end;
	$today = date("Y-m-d H:i:s");
	
	if($today > $end_pro){
		updateTable("proyectos", "pro_status = 'F'", "pro_id = '$rs_proj->pro_id'");
	}
}

?>