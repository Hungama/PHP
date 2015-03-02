<?php
$con = mysql_connect("192.168.100.218","php","php");
//$con = mysql_connect("192.168.100.218","amit.khurana","hungama");
echo $con;
if (!$con)
  {
  die('Could not connect: ' . mysql_error());
  }
//mysql_select_db("misdata", $con);
echo $q="INSERT INTO misdata.tbl_browsing_wap2 (zoneid,datetime,msisdn,remoteaddress,useragent,chargingurlfired,response,planid,mode,service,hitip) VALUES ('0','2012-12-04 00:15:44','919792292757','1.38.16.254','Videocon_V1545_Maui Wap Browser','http://119.82.69.212/reliance/RelianceWap.php?msisdn=919792292757&reqtype=1&planid=6&serviceid=MM&mode=','please try later','6','','MM','202.87.41.147')";

$data= mysql_query($q,$con) or die(" Error: ".mysql_error());
echo "<br/>Data".$data;
echo "<br/>";
//echo $queryString="INSERT INTO misdata.livemis VALUES (now(),'sataytesting','DL','test','NA','0000')";
 //mysql_query($queryString,$con);
$result = mysql_query("SELECT * FROM misdata.tbl_browsing_wap2",$con);

while($row = mysql_fetch_array($result))
  {
  echo $row['zoneid'] . " " . $row['remoteaddress'];
  echo "<br />";
  }

mysql_close($con);
?>