<?php
error_reporting(0);
include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
	if(!$dbConn)
	{
		die('could not connect: ' . mysql_error());
	}
$msisdn=trim($_REQUEST['Msisdn']);
$mode=$_REQUEST['Channel'];
$reqtype=1;
$planid=$_REQUEST['product_id'];
$subchannel =$_REQUEST['Channel'];

$query=mysql_query("SELECT s_id,iamount from master_db.tbl_plan_bank where plan_id=".$planid);
list($seviceId,$amount) = mysql_fetch_array($query);
//$seviceId=$_REQUEST['serviceid'];
$circle_id=$_REQUEST['circle_id'];
$ac=$_REQUEST['ac'];
$dnis = $_REQUEST['dnis'];
$lang = $_REQUEST['lang'];
$consentTime = $_REQUEST['consentTime'];
$curdate = date("Y-m-d");

/**************************Start logs here *********************/
$logDir="/var/www/html/airtel/ussdlogs/ussd/";
$logFile_dump="log_".date('Ymd');
$logPath=$logDir.$logFile_dump.".txt";
$filePointer1=fopen($logPath,'a+');
chmod($logPath,0777);
$arrCnt=sizeof($_REQUEST);
$str='';
for($i=0;$i<$arrCnt;$i++)
{
	$keys=array_keys($_REQUEST);
	
}
for($k=0;$k<$arrCnt;$k++)
{
	fwrite($filePointer1,$keys[$k].'=>'.$_REQUEST[$keys[$k]]."|");
}
fwrite($filePointer1,date('H:i:s')."\n");

//end here

					
/**************************logs here *********************/

if(isset($_REQUEST['flag'])) {
	$flag=$_REQUEST['flag'];
} else {
	$flag=1;
}


$langArray = array('TEL'=>'08','HIN'=>'01','TAM'=>'07','KAN'=>'10','ENG'=>'02','MAI'=>'21','MAL'=>'09','NEP'=>'19','ASS'=>'17', 'GUJ'=>'12','RAJ'=>'18','BHO'=>'04','PUN'=>'03','ORI'=>'13','MAR'=>'11','CHH'=>'16','HAR'=>'05','BEN'=>'06','HIM'=>'15','KAS'=>'14','KUM'=>'20');


if (!is_numeric("$planid") && $reqtype==1)
{
	echo '1003,FAILURE';
	$abc='1003,Invalid Product Id';
	$log_file_path="logs/airtel/subscription/".$seviceId."/subscription_".$curdate.".txt";
	$file=fopen($log_file_path,"a");
	fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#L:".$lang."#R:".$religion . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc . "\r\n" );
	fclose($file);
	exit;
}
function checkmsisdn($msisdn,$abc,$seviceId)
{
	if(strlen($msisdn)==12 || strlen($msisdn)==10 )
	{
		if(strlen($msisdn)==12)
		{
			if(substr($msisdn,0,2)==91)
			{
				$msisdn = substr($msisdn, -10);
			}else
			{
				echo '1001,FAILURE';
				$rcode='1001,Invalid MSISDN';
				if($reqtype==1)
				{
					$log_file_path="logs/airtel/subscription/".$seviceId."/subscription_".$curdate.".txt";
					$file=fopen($log_file_path,"a");
					fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#L:".$lang."#R:".$religion . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
					fclose($file);
				}
				
				exit;
			}
		}
	}
	elseif(strlen($msisdn)!=10)
	{ 
		echo '1001,FAILURE';
		$rcode='1001,Invalid MSISDN';
		if($reqtype==1)
		{
			$log_file_path="logs/airtel/subscription/".$seviceId."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#L:".$lang."#R:".$religion . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file);
		}
		exit;
	}
	return $msisdn;
}

if ($mode=="")
{
echo '1002,FAILURE';
exit;
}
else if($circle_id=="")
{
echo '1004,FAILURE';
exit;
}
$msisdn=checkmsisdn(trim($msisdn),$abc,$seviceId);



if (($msisdn == "") || ($mode=="") || ($reqtype=="") || ($planid=="" && $reqtype==1))
{
	echo "Please provide the complete parameter";
	if($reqtype==1)
		{
			$log_file_path="logs/airtel/subscription/".$seviceId."/subscription_".$curdate.".txt";
			$file=fopen($log_file_path,"a");
			fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#L:".$lang."#R:".$religion . "#" . $subchannel . "#" . date('H:i:s') . "#" . $abc[1] . "\r\n" );
			fclose($file);
		}
	
}
else
{
	
	//get circle here

$getCircle = "select master_db.getCircle(".trim($msisdn).") as circle"; 
$circle1=mysql_query($getCircle) or die( mysql_error() );
while($row = mysql_fetch_array($circle1)) {
	$circle = $row['circle'];
}
if(!$circle) { $circle='UND'; }
	switch($seviceId)
	{
		case '1507':
			$sc='55841';
			$s_id='1507';
			$db="airtel_vh1";
			$subscriptionTable="tbl_jbox_subscription";
			$subscriptionProcedure="JBOX_SUB";
			//$subscriptionProcedure="JBOX_SUBBULK";
			$unSubscriptionProcedure="JBOX_UNSUB";
			$unSubscriptionTable="tbl_jbox_unsub";
			$lang='01';
		break;
		case '1511':			
			$s_id='1511';
			if($planid == 30 || $planid == 48){
				if($dnis==1) $sc='54646169';
				else $sc='5500169';
				$db="airtel_manchala";
				$subscriptionTable="tbl_riya_subscription";
				$subscriptionProcedure="RIYA_SUB";
				//$subscriptionProcedure="RIYA_SUBBULK";
				$unSubscriptionProcedure="RIYA_UNSUB";
				$unSubscriptionTable="tbl_riya_unsub";
			} elseif($planid == 29 || $planid == 46) {
				$sc='55001';
				$db="airtel_rasoi";
				$subscriptionTable="tbl_rasoi_subscription";
				$subscriptionProcedure="RASOI_SUB";
				//$subscriptionProcedure="RASOI_SUBBULK";
				$unSubscriptionProcedure="RASOI_UNSUB";
				$unSubscriptionTable="tbl_rasoi_unsub";
			} elseif($planid == 34) {
				$sc='5500101';
				$db="airtel_rasoi";
				$subscriptionTable="tbl_storeatone_subscription";
				$subscriptionProcedure="STOREATONE_SUB";
				//$subscriptionProcedure="STOREATONE_SUBBULK";
				$unSubscriptionProcedure="STOREATONE_UNSUB";
				$unSubscriptionTable="tbl_storeatone_unsub";
			}
			$lang='01';
		break;
		case '1523':
			$sc='5500181';			
			$s_id='1523';
			$db="airtel_TINTUMON";
			$subscriptionTable="tbl_TINTUMON_subscription";
			//$subscriptionProcedure="ARM_SUB";
			$subscriptionProcedure="TINTUMON_SUB";
			$unSubscriptionProcedure="TINTUMON_UNSUB";
			$unSubscriptionTable="tbl_TINTUMON_unsub";
			$lang='01';
		break;
	}	
	
	function getReligion($religion) {
		$query = mysql_query("SELECT religion FROM airtel_devo.tbl_religion_detail WHERE religion like '%".$religion."%'");
		list($religionValue) = mysql_fetch_array($query);
		return $religionValue;
	}	

	if($_REQUEST['lang']) $lang=$_REQUEST['lang'];
	$langValue = $langArray[strtoupper($lang)];
	if(!$langValue) $langValue="01";

	if($reqtype == 1)
	{
		$amtquery="select iAmount from master_db.tbl_plan_bank where Plan_id='$planid' and S_id=$seviceId";
	
		$amt = mysql_query($amtquery);
		List($row1) = mysql_fetch_row($amt);
		$amount = $row1;

		
		
		$sub="select count(*) from ".$db.".".$subscriptionTable." where ANI='$msisdn'";
		$qry1=mysql_query($sub);
		$rows1 = mysql_fetch_row($qry1);
		if($rows1[0] <=0)
		{	
		$qry="call ".$db.".". $subscriptionProcedure." ('".$msisdn."','".$langValue."','".$mode."','".$sc."','".$amount."',".$s_id.",".$planid.")";
		
		if(mysql_query($qry))
		{			
		fwrite($filePointer1,$msisdn . "#" . $mode . "#".date('H:i:s') . "#SUCCESS#" . $qry . "\r\n" );	
		}
		else
		{
		$error=mysql_error();
		fwrite($filePointer1,$msisdn . "#" . $mode . "#" . date('H:i:s') . "#FAILURE#" . $error . "#" . $qry . "\r\n" );	
		}			
		$query2="select count(*) from ".$db.".".$subscriptionTable." where ANI='$msisdn'";
			$qry2=mysql_query($query2);
			$result2=mysql_fetch_row($qry2);
			if($result2[0]>=1)
				$result=0;
			else
				$result=1;
		}
		else
			$result=2;
			if($result==0)
			{
				echo $rcode = '0,SUCCESS';
				$log_file_path="logs/airtel/subscription/".$seviceId."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#L:".$lang."#R:".$religion . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode ."#". $qry. "\r\n" );
				fclose($file);
				mysql_close($dbConn);
				exit;
			}
				
			if($result==1)
			{
				echo $rcode = '0,SUCCESS';
				$log_file_path="logs/airtel/subscription/".$seviceId."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#L:".$lang."#R:".$religion . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode ."#". $qry. "\r\n" );
				fclose($file);
				mysql_close($dbConn);
				exit;
			}
			if($result==2)
			{
				echo $rcode = '0,SUCCESS';
				
				if(strlen($_REQUEST['lang'])<=3 && $_REQUEST['lang']) { 
					$lang = $_REQUEST['lang'];
					$langValue = $langArray[strtoupper($lang)];
					$updateLang="UPDATE ".$dbname.".".$subscriptionTable." SET def_lang='".$langValue."' WHERE ANI='".$msisdn."'";
					mysql_query($updateLang);
				}
				$log_file_path="logs/airtel/subscription/".$seviceId."/subscription_".$curdate.".txt";
				$file=fopen($log_file_path,"a");
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid."#L:".$lang."#R:".$religion . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode ."#". $qry. "\r\n" );
				fclose($file);
				mysql_close($dbConn);
				exit;
			}
		}

		
}
mysql_close($dbConn);
?>