<?php
session_start();
//if($_SESSION['usrId']){
	include ("config/dbConnect.php");
	$circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');
	$view_date1=$_REQUEST['view_date1'];
	$view_date2=$_REQUEST['view_date2'];
	if($view_date1>$view_date2)
	{
		header("location:http://119.82.69.212/kmis/services/hungamacare/callingLog.php?error=1");
		exit;
	}
	
	$mis_array=array();
	$mis_data_query="select msisdn,call_date,dnis,duration_in_sec,circle,status from mis_db.tbl_radio_calllog where DATE(call_date) between '$view_date1' and '$view_date2'";
	$mis_data = mysql_query($mis_data_query,$dbConn);
	$result_row=mysql_num_rows($mis_data);
	
	//$excellDirPath="/var/www/html/kmis/services/hungamacare/csv/";
	$excellFile=date("Ymd").".csv";
	$excellFilePath=$excellDirPath.$excellFile;
	
	header("Content-type: application/octet-stream");
	header("Content-Disposition: attachment; filename=$excellFile");
	echo "Report Date,Msisdn,DNIS,Duration In Sec,Circle,Status"."\r\n";

	while($mis_array=mysql_fetch_array($mis_data))
	{
		if($mis_array[5]==1)
			$status1='Active';
		else
			$status1='NotActive';
		echo $mis_array[1].",".$mis_array[0].",".$mis_array[2].",".$mis_array[3].",".$circle_info[strtoupper($mis_array[4])].",".$status1."\r\n";
	}
//}

//echo 'file create1d' ;
header("Pragma: no-cache");
header("Expires: 0");

?>