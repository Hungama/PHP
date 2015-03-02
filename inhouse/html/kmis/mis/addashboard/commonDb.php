<?php
//case 'VODAFONE':
$con_voda = mysql_connect('10.43.248.137', 'team_user','teamuser@voda#123'); //Voda
//case 'AIRTEL':
$con_airtel = mysql_connect('10.2.73.160', 'team_user','Te@m_us@r987'); //Airtel
//case 'MTS':
$con_mts = mysql_connect('database.master_mts', 'billing','billing'); //MTS
//case 'RELIANCE':
$con_212 = mysql_connect("192.168.100.224","webcc","webcc"); //RELIANCE

if (!$con_voda) {
    echo 'Could not connect Voda:' . mysql_error();
}
if (!$con_airtel) {
     echo 'Could not connect Airtel:' . mysql_error();
}
if (!$con_mts) {
     echo 'Could not connect MTS:' . mysql_error();
}
if (!$con_212) {
     echo 'Could not connect Inhouse:' . mysql_error();
}
?>