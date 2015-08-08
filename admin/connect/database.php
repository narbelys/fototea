<?
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_h = FConfig::getValue('db_hostname');
$database_h = FConfig::getValue('db_name');
$username_h = FConfig::getValue('db_user');
$password_h = FConfig::getValue('db_password');

$db = mysql_pconnect($hostname_h, $username_h, $password_h) or trigger_error(mysql_error(),E_USER_ERROR); 
$db_select = mysql_select_db($database_h,$db);


include("js/libSM.php");
?>