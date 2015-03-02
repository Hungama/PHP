<?php
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
$msisdn=trim($_REQUEST['msisdn']);
$chrgAmount=trim($_REQUEST['amount']);
$operator=strtolower(trim($_REQUEST['operator']));
$tId=trim($_REQUEST['tid']);
$conntype=strtolower(trim($_REQUEST['conntype']));

//default mode will pe prepaid
if($conntype!='postpaid')
$conntype='prepaid';

//&conntype=postpaid/prepaid
//$tId = date("HmyHis");

//Logs all request header  start here 
$dumplogFile = "/var/www/html/Recharge/log/dumpAllRequest_".date("Ymd").".txt";
$filePointerDump=fopen($dumplogFile,'a+');
chmod($dumplogFile,0777);
$arrCnt=sizeof($_REQUEST);
for($i=0;$i<$arrCnt;$i++)
{
	$keys=array_keys($_REQUEST);
}
for($k=0;$k<$arrCnt;$k++)
{
   fwrite($filePointerDump,$keys[$k].'=>'.$_REQUEST[$keys[$k]]."|");
}
fwrite($filePointerDump,date('Y-m-d H:i:s')."\n");
//Logs all request header end here 

$operator_name_id=array('1'=>'Airtel','2'=>'Vodafone','3'=>'BSNL','4'=>'Reliance CDMA','5'=>'Reliance GSM','6'=>'Aircel','7'=>'MTNL','8'=>'Idea','9'=>'Tata Indicom','10'=>'Loop Mobile','11'=>'Tata Docomo','12'=>'Virgin CDMA','13'=>'MTS','14'=>'Virgin GSM','15'=>'S Tel','16'=>'Uninor');
$operator_circle_map=array('APD'=>'1','ASM'=>'2','BIH'=>'3','PUB'=>'18','KAR'=>'10','MAH'=>'13','TNU'=>'20','WBL'=>'23','DEL'=>'5','MPD'=>'14','CHN'=>'4','UPE'=>'21','GUJ'=>'6','HPD'=>'8','HAY'=>'7','JNK'=>'9','KER'=>'11','KOL'=>'12','MUM'=>'15','NES'=>'16','ORI'=>'17','RAJ'=>'19','UPW'=>'12','HAR'=>'7');

switch($operator)
{
	case 'aircel':
		$oid=6;
	break;
	case 'airtel':
		$oid=1;
	break;
	case 'loop':
		$oid=10;
	break;
	case 'bsnl':
		$oid=3;
	break;
	case 'vodafone':
		$oid=2;
	break;
	case 'idea':
		$oid=8;
	break;
	case 'mtnl':
		$oid=7;
	break;
	case 'mts':
		$oid=13;
	break;
	case 'reliance':
		$oid=5;
	break;
	case 'reliancecdma':
		$oid=4;
	break;
	case 'tataindicom':
		$oid=9;
	break;
	case 'tatadocomo':
		$oid=11;
	break;
	case 'uninor':
		$oid=16;
	break;
	case 'uninor':
		$oid=16;
	break;
	case 'virgin':
		$oid=14;
	break;
	case 'virgincdma':
		$oid=12;
	break;
	/*case 'tatadocomovmi':
		$oid=24;
	break;*/
	
}
$logPath = "/var/www/html/Recharge/log/mobikwikrecharge_".date("Ymd").".txt";

if(is_numeric($msisdn) && (strlen($msisdn)==10 || strlen($msisdn)==12) && $chrgAmount!="" && $tId!="") {
	//$msisdn=int($msisdn);

					$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle";
					$circle1=mysql_query($getCircle);
					list($circle)=mysql_fetch_array($circle1);
					
					if(!$circle)
					{ 
					$circle='UND';
					$logData=$msisdn."#".$chrgAmount."#".$tId."#".$oid."#".date("Y-m-d H:i:s")."#".'INVALID CIRCLE'."\n";
					//echo "Error: INVALID CIRCLE";
					$apiResponse="CIRCLE NOT FOUND: ".$tId;					
					$logData=$msisdn."#".$chrgAmount."#".$tId."#".$oid."#".date("Y-m-d H:i:s")."#".$query."#".$circle."#".$operator."#".$queryResponse."#".$apiResponse."\n";
					echo $apiResponse;
					}
					else if($circle=='UND')
					{ 
					$logData=$msisdn."#".$chrgAmount."#".$tId."#".$oid."#".date("Y-m-d H:i:s")."#".'INVALID CIRCLE'."\n";
					//echo "Error: INVALID CIRCLE";
					$apiResponse="CIRCLE NOT FOUND: ".$tId;					
					$logData=$msisdn."#".$chrgAmount."#".$tId."#".$oid."#".date("Y-m-d H:i:s")."#".$query."#".$circle."#".$operator."#".$queryResponse."#".$apiResponse."\n";
					echo $apiResponse;
					}
					else
					{
					$cid=$operator_circle_map[$circle];
					//check for transactionId
				$checkDuplicateData = "select count(*) from master_db.tbl_recharged nolock where msisdn=" . $msisdn." and transactionId='".$tId."'";
					$resultDuplicate = mysql_query($checkDuplicateData);
					list($isDuplicate) = mysql_fetch_array($resultDuplicate);
	if (!$isDuplicate) 
	{
					$query="insert into master_db.tbl_recharged(msisdn,amount,request_time,transactionId,status,operator_id,circle_id,conntype) values (".$msisdn.",'".$chrgAmount."',now(),'".$tId."',0,$oid,$cid,'".$conntype."')";
					$queryResponse='';					
					if($oid!='')
					{
						if(mysql_query($query))
						$queryResponse='SUCCESS';
						else
						$queryResponse=mysql_error();
						
						$apiResponse="Success: ".$tId;
						echo $apiResponse;
					}
					else
					{
					$apiResponse="OPERATOR NOT FOUND: ".$tId;
					echo $apiResponse;
					}
	}
	else
	{
		$apiResponse="Duplicate Entry Found: ".$tId;
		echo $apiResponse;
	}				
					$logData=$msisdn."#".$chrgAmount."#".$tId."#".$oid."#".date("Y-m-d H:i:s")."#".$query."#".$circle."#".$operator."#".$queryResponse."#".$apiResponse."\n";
					
					}
	error_log($logData,3,$logPath);
} else {
	echo "Error in Parameter.";
}
mysql_close($dbConn);

?>