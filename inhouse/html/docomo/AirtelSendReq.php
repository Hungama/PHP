<?php

include ("/var/www/html/kmis/services/hungamacare/config/dbConnectAirtel.php");
$curdate = date("Y-m-d");

$cirArray=array('APD'=>'Andhra Pradesh','ASM'=>'Assam','BIH'=>'Bihar','CHN'=>'Chennai','DEL'=>'Delhi','GUJ'=>'Gujarat','HAY'=>'Haryana','HPD'=>'Himachal Pradesh','JNK'=>'Jammu-Kashmir','KAR'=>'Karnataka','KER'=>'Kerala','KOL'=>'Kolkata','MPD'=>'Madhya Pradesh','MAH'=>'Maharashtra','MUM'=>'Mumbai','NES'=>'NE',
'ORI'=>'Orissa','PUB'=>'Punjab','RAJ'=>'Rajasthan','TNU'=>'Tamil Nadu','UPE'=>'UP EAST','UPW'=>'UP WEST','WBL'=>'WestBengal');

echo $select="select * from master_db.tbl_vh1_MCoupons where date(date_time)=date(now()) and status=0";
$query = mysql_query($select,$dbConnAirtel) or die(mysql_error());
while($coupenRecord=mysql_fetch_row($query))
{
	if($coupenRecord[4]=='HPD')
	{
		$CampaignID='200001';
		$AuthCode='9238139';
	}
	if($coupenRecord[4]=='MPD')
	{
		$CampaignID='200002';
		$AuthCode='1039029';
	}
	if($coupenRecord[4]=='PUB')
	{
		$CampaignID='200004';
		$AuthCode='8292019';
	}

	$HitUrl="http://192.168.100.218/MIS/API/API.Coupon.php?CampaignID=".$CampaignID."&AuthCode=".$AuthCode."&Circle=".urlencode($cirArray[$coupenRecord[4]])."&MSISDN=".$coupenRecord[0];
	
	$ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$HitUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
    echo $response = curl_exec($ch);
	
	$log_file_path="logs/docomo/Recharge/AirtelSendMcoupen_".$curdate.".txt";
	$file=fopen($log_file_path,"a");
	fwrite($file,$coupenRecord[0]."#".$response."#".$CampaignID."#".$AuthCode."#".urlencode($cirArray[$coupenRecord[4]])."#".date('H:i:s')."\r\n" );
	fclose($file);

	echo $update="update master_db.tbl_vh1_MCoupons set status=1 where date(date_time)=date(now()) and status=0 and msisdn=".$coupenRecord[0];
	$Uquery = mysql_query($update,$dbConnAirtel) or die(mysql_error());
}

?>   