<?
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");
echo $VodaMTVFilePath="/var/www/html/kmis/mis/activeBase/air_Aug.txt";

$getActiveBaseQ7="select * from mis_db.tbl_54646_calllog where date(call_date) between  '2013-08-01' and '2013-08-31'";  
$query7 = mysql_query($getActiveBaseQ7,$dbConnAirtel);
while($VodaMtvActbase = mysql_fetch_array($query7))
{
	$VodaMTVActiveBasedata= $VodaMtvActbase[0]."|".$VodaMtvActbase[1]."|".$VodaMtvActbase[2]."|".$VodaMtvActbase[3]."|".$VodaMtvActbase[4]."|".$VodaMtvActbase[5]."|".$VodaMtvActbase[6]."|".$VodaMtvActbase[7]."|".$VodaMtvActbase[8]."|".$VodaMtvActbase[9]."|".$VodaMtvActbase[10]."|".$VodaMtvActbase[11]."|".$VodaMtvActbase[12]."|".$VodaMtvActbase[13]."|".$VodaMtvActbase[14]."|".$VodaMtvActbase[15]."\r\n";
	error_log($VodaMTVActiveBasedata,3,$VodaMTVFilePath) ;

}

?>
