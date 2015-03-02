<?php
ob_start();
session_start();
//include("web_admin.js");
//include_once("main_header.php");

$fileDir="/var/www/html/kmis/mis/";
$fileName="test.xls";
$filePath=$fileDir.$fileName;
$fPointer=fopen($filePath,'a+');
chmod($filePath,0777);

//if($_SESSION['usrId']){

	include ("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
	 $circle_info=array('DEL'=>'Delhi','GUJ'=>'Gujarat','WBL'=>'WestBengal','BIH'=>'Bihar','RAJ'=>'Rajasthan','UPW'=>'UP WEST','MAH'=>'Maharashtra','APD'=>'Andhra Pradesh','UPE'=>'UP EAST','ASM'=>'Assam','TNU'=>'Tamil Nadu','KOL'=>'Kolkata','NES'=>'NE','CHN'=>'Chennai','ORI'=>'Orissa','KAR'=>'Karnataka','HAY'=>'Haryana','PUN'=>'Punjab','MUM'=>'Mumbai','MPD'=>'Madhya Pradesh','JNK'=>'Jammu-Kashmir','PUB'=>"Punjab",'KER'=>'Kerala','HPD'=>'Himachal Pradesh');
	
	$mis_array=array();
	$mis_data_query="select msisdn,call_date,dnis,duration_in_sec,circle,status from mis_db.tbl_radio_calllog where DATE(call_date) between date(date_add(now(),interval -4 day)) and date(date_add(now(),interval -1 day)) ";
	$mis_data = mysql_query($mis_data_query,$dbConn);
	//	$circle_info[strtoupper($mis_array[2])]
	while($mis_array=mysql_fetch_array($mis_data))
	{
		if($mis_array[5]==1)
			$status1='Active';
		else
			$status1='NotActive';
		
		fwrite($fPointer,$mis_array[0]."\t".$mis_array[1]."\t".$mis_array[2]."\t".$mis_array[3]."\t".$circle_info[strtoupper($mis_array[4])]."\t".$status1."\t"."\r\n");

	}
	fclose($fPointer);
	mysql_close($dbConn);
/*}
else
{
	echo "Please Do The Login First<Br>";
	echo "<a href='http://119.82.69.212/kmis/services/hungamacare'>Click Here to Login</a>";
}
*/

?>