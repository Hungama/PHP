<?php
//delete from airtel DB
include("/var/www/html/kmis/services/hungamacare/config/db_airtel.php");
error_reporting(1);
$view_date= date("Y-m-d",mktime(0,0,0,date("m"),date("d")-1,date("Y")));
$insquery = "INSERT INTO airtel_rasoi.tbl_rasoi_subscriptionWAP_BACKUP  SELECT * FROM airtel_rasoi.tbl_rasoi_subscriptionWAP WHERE status=0 and date(sub_date)<='".$view_date."'";
    if(mysql_query($insquery,$dbConnAirtel))
	{
	$deleteqry = "delete from airtel_rasoi.tbl_rasoi_subscriptionWAP where date(sub_date)<='".$view_date."' and status=0";
	mysql_query($deleteqry,$dbConnAirtel);
	echo "SUCCESS";
	}
else
{
echo $error=mysql_error();
echo "Failure";
}
mysql_close($dbConnAirtel);

sleep(2);
//delete from Inhouse DB
include("/var/www/html/kmis/services/hungamacare/config/dbConnect212.php");
$insquery = "INSERT INTO airtel_rasoi.tbl_rasoi_subscriptionWAP_BACKUP  SELECT * FROM airtel_rasoi.tbl_rasoi_subscriptionWAP WHERE status=0 and date(sub_date)<='".$view_date."'";
    if(mysql_query($insquery,$dbConn212))
	{
	$deleteqry = "delete from airtel_rasoi.tbl_rasoi_subscriptionWAP where date(sub_date)<='".$view_date."' and status=0";
	mysql_query($deleteqry,$dbConn212);
	echo "SUCCESS";
	}
	else
	{
	echo $error=mysql_error();
	echo "Failure";
	}

//Uninor LDR 	

$insquery = "INSERT INTO uninor_ldr.tbl_ldr_subscription_backup  SELECT * FROM uninor_ldr.tbl_ldr_subscription WHERE status=0 and date(sub_date)<='".$view_date."'";
    if(mysql_query($insquery,$dbConn212))
	{
	$deleteqry = "delete from uninor_ldr.tbl_ldr_subscription where date(sub_date)<='".$view_date."' and status=0";
	mysql_query($deleteqry,$dbConn212);
	echo "SUCCESS";
	}
	else
	{
	echo $error=mysql_error();
	echo "Failure";
	}
	
mysql_close($dbConn212);
?>
