<?php
error_reporting(1);
$msisdn=$_GET['msisdn'];
$religion=$_REQUEST['religion'];

$remoteAdd=trim($_SERVER['REMOTE_ADDR']);

$logPath="/var/www/html/MTS/logs/DevoOBD/devo_OBD_".date("Y-m-d").".txt";

function RelValue($relId) {
	switch($relId) {
		case 1 : $religionValue="Hinduism"; break;
		case 2 : $religionValue="Muslim"; break;
		case 3 : $religionValue="Sikhism"; break;
		case 4 : $religionValue="Christianity"; break;
		case 5 : $religionValue="Jainism"; break;
		case 6 : $religionValue="Buddhism"; break;
	}
	return $religionValue;
}

function checkmsisdn($msisdn)
{
	if(strlen($msisdn)==12 || strlen($msisdn)==10 )
	{
		if(strlen($msisdn)==12)
		{
			if(substr($msisdn,0,2)==91)
			{
				$msisdn = substr($msisdn, -10);
			}
		}
	}
	return $msisdn;
}
$msisdn=checkmsisdn(trim($msisdn));

if ($msisdn == "" || $religion=="")
{
	echo "Please provide the complete parameter";
} else {
	$dbConn = mysql_connect("database.master_mts","billing","billing");
	if(!$dbConn) {
		die('could not connect1: ' . mysql_error());
	}
	
	$selectQuery = "SELECT count(*) FROM dm_radio.tbl_religion_profile WHERE ANI='".$msisdn."'";
	$result = mysql_query($selectQuery);
	list($count) = mysql_fetch_array($result);
	//echo $count;
	
	$religionValue = RelValue($religion);	

	if($count) {
		$query="UPDATE dm_radio.tbl_religion_profile SET lastreligion_cat='".$religionValue."' WHERE ANI='".$msisdn."'";
		error_log($msisdn."#".$religion."#".$religionValue."#UPDATE#".$remoteAdd."#".date("Y-m-d H:i:s"),3,$logPath);
	} else {
		$query="INSERT INTO dm_radio.tbl_religion_profile VALUES ('".$msisdn."','".$religionValue."','01')";
		error_log($msisdn."#".$religion."#".$religionValue."#INSERT#".$remoteAdd."#".date("Y-m-d H:i:s"),3,$logPath);
	}
	mysql_query($query);
	
}


echo "Done";
mysql_close($dbConn); 
exit;

?>