<?php
$hostname_h = FConfig::getValue('db_hostname');
$database_h = FConfig::getValue('db_name');
$username_h = FConfig::getValue('db_user');
$password_h = FConfig::getValue('db_password');

$db = mysql_pconnect($hostname_h, $username_h, $password_h) or trigger_error(mysql_error(),E_USER_ERROR); 
$db_select = mysql_select_db($database_h,$db);

$email = $_GET['email'];
$int = $_GET['interest'];
mysql_query("INSERT INTO prelaunch_email VALUES ('','$email','$int',NOW())");

$arreglo[] = array('resp' => "No se ha enviado la información");
echo json_encode($arreglo);
?>