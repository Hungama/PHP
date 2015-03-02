<?php
 $DB_HOST_M224     = '192.168.100.224'; //'172.28.106.4'; //DB HOST
 $DB_USERNAME_M224 = 'webcc';  //DB Username
 $DB_PASSWORD_M224 = 'webcc';  //DB Password 'Te@m_us@r987';
 $DB_DATABASE_M224 = 'master_db';  //Datbase Name  hul_hungama
 $db_m224 = $DB_DATABASE_M224;

 $con = mysql_connect($DB_HOST_M224,$DB_USERNAME_M224,$DB_PASSWORD_M224);
if (!$con)
 {
  die('Could not connect: ' . mysql_error("could not connect to Local"));
 }
 
function curPageName() {
 return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1);
}
$cpage=curPageName();
$setstyle="style='font-weight:bold'";
?>