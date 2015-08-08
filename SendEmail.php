<?php
$hostname_h = FConfig::getValue('db_hostname');
$database_h = FConfig::getValue('db_name');
$username_h = FConfig::getValue('db_user');
$password_h = FConfig::getValue('db_password');

$db = mysql_pconnect($hostname_h, $username_h, $password_h) or trigger_error(mysql_error(),E_USER_ERROR); 
$db_select = mysql_select_db($database_h,$db);


$sql = "SELECT * FROM prelaunch_email ORDER BY cdate DESC";
$query = mysql_query($sql);
$num = mysql_num_rows($query);

 $to = FConfig::getValue('contacto_email');
   //$to = "rabricenog@gmail.com";
    $asunto= "Listado de correos registrados en Prelaunch";
   

    $text = '<table width="500" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="248" height="34">Este es el listado de correos registrados en Fototea hasta el dia '.date("d-m-Y").'</td>
  </tr>
  <tr>
    <td height="34"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="42%"><strong>Correo</strong></td>
        <td width="24%"><strong>Interes</strong></td>
        <td width="34%"><strong>Fecha de registro</strong></td>
      </tr>';
	  
	  while($rs_mail = mysql_fetch_object($query)){
  $text .= '<tr>
        <td>'.$rs_mail->email.'</td>
        <td>'.$rs_mail->interest.'</td>
        <td>'.$rs_mail->cdate.'</td>
      </tr>';
	  }
    $text .='</table></td>
  </tr>
  <tr>
    <td width="248" height="34">Total Email registrados <strong>'.$num.'</strong></td>
  </tr>
</table>';

    $mailer = new FMailer();
    $receivers = array(
        array('email' => $to),
    );
    $mailer->setReceivers($receivers);
    $mailer->sendEmail($asunto, $text);

?>