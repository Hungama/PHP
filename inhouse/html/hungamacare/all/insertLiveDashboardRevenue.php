<?php
error_reporting(1);
include ("/var/www/html/kmis/services/hungamacare/config/dbConnectLive.php");
include ("base_218.php");
//INSERT INTO dashboard_revenue(date, service,circle,revenue)  SELECT DATE,service,circle,SUM(revenue) FROM misdata.dailymis WHERE DATE = '2013-06-01'
//GROUP BY service,circle,date

$lastMonthFirstDate = date('Y-m-01', strtotime('-1 Month'));
$selectDataQuery = "SELECT DATE,service,circle,SUM(revenue) as revenue FROM misdata.dailymis WHERE DATE >= '".$lastMonthFirstDate."' GROUP BY service,circle,date";
//$selectDataQuery = "SELECT DATE,service,circle,SUM(revenue) as revenue FROM misdata.dailymis WHERE DATE >= '2013-04-01' GROUP BY service,circle,date";
$Revenuedata = mysql_query($selectDataQuery,$LivdbConn);
$totalRevenueData = mysql_num_rows($Revenuedata);

if($totalRevenueData) {
	//$deleteQuery = "delete from misdata.dashboard_revenue where DATE>='".$lastMonthFirstDate."'";
	//$deleteQuery = "truncate misdata.dashboard_revenue";
//	mysql_query($deleteQuery,$LivdbConn);

	while($row = mysql_fetch_array($Revenuedata)) { 
	       // $mainservicearray = $Service_DESC[$row['service']];
		 // $sname=$row['service'];
		 //$op=$mainservicearray['Operator'];
		 $sname= strtolower($row['service']);
		$Service_DESC=array_change_key_case($Service_DESC, CASE_LOWER);
		//echo $Service_DESC[$sname]['Operator'];
		$op=$Service_DESC[$sname]['Operator'];
		echo $op."---".$sname."<br>";
		//$insertQuery="INSERT INTO misdata.dashboard_revenue (date, service, circle,revenue,operator) VALUES ('".$row['DATE']."','".$row['service']."','".$row['circle']."','".$row['revenue']."','".$op."')";
		// $insertdata = mysql_query($insertQuery,$LivdbConn);
	}
	echo "Data updated successfully";
} else {
	echo "No Records found";
}
echo "done";
mysql_close($LivdbConn);
exit;
?>
