<?php 
require_once("/var/www/html/kmis/services/hungamacare/config/db_218.php");
$msisdn = $_REQUEST['msisdn'];
$modeQuery = "SELECT useragent FROM misdata.tbl_browsing_wap nolock WHERE msisdn='".$msisdn."' order by datetime desc limit 1";
$modeResult = mysql_query($modeQuery,$LivdbConn);
$numRow = mysql_num_rows($modeResult);
if($numRow>=1)
{
	while($row = mysql_fetch_array($modeResult)) 
	{
	echo $row['useragent'];
	}
}
else
{
echo 'UNKNOWN';
}
mysql_close($LivdbConn);
?>