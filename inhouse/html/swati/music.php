<?php
error_reporting(0);
include_once './dbconnect.php';
$msisdn1=$_REQUEST['msisdn'];
$mode=$_REQUEST['mode'];
$reqtype=$_REQUEST['reqtype'];
$planid=$_REQUEST['planid'];
$amount=10;
$subchannel =$_REQUEST['subchannel'];
$serviceid=$_REQUEST['serviceid'];
$rcode =$_REQUEST['rcode'];
$dateformat = date("Ymd");

$logpath="/var/www/html/swati/logs/subsribe_".$dateformat.".txt";
$errorString=$msisdn."|".$mode."|".$reqtype."|".$planid."|".$subchannel."|".$serviceid."|".$rcode."|";
error_log($errorString,3,$logpath);

function checkparameter($msisdn1,$mode1,$reqtype1,$planid1,$subchannel1,$serviceid1,$rcode1)
{
 	if ($msisdn1=='' || $mode1=='' || $reqtype1=='' || $planid1=='' || $subchannel1=='' || $serviceid1=='')
	{
    		throw new Exception("parameters value should not be blank");
	}
  	return true;
}
try
{
  checkparameter($msisdn1,$mode,$reqtype,$planid,$subchannel,$serviceid,$rcode);
  echo "working"; 
}
catch(Exception $e)
{
  echo 'Message: ' .$e->getMessage();
}
	
function checkmsisdn($msisdn1)
{
	if((strlen($msisdn1)==10 || strlen($msisdn1)==12) && is_numeric($msisdn1)) 
	{
		if(strlen($msisdn1)==12)
		{
	
			if(substr($msisdn1,0,-10)!='91')
			{
			 	$msisdn1 ='f';
			}
			else 
			{
				$msisdn1 = substr($msisdn1,-10);
			}		
		}
	return $msisdn1;
	}
	else
	{
		echo "Invalid Number";
	}
}
$msisdn=checkmsisdn($msisdn1);

switch ($serviceid) 
{
	case '1402':
	
		$dbname="uninor_hungama";
		$tblname="tbl_jbox_subscription";
		break;
	case '1401':
		$dbname="uninor_hungama";
		$tblname="tbl_jbox_subscription";
		break;
	
	
}
	$query="select count(*) from $dbname.$tblname where ani='$msisdn'";
	$queryresult=mysql_query($query);
	$row = mysql_fetch_row($queryresult);
	//echo "<pre>";
	//print_r($row[0]);

	if($row[0]>0)
		echo "already subscribed";
		
	else
		echo "new user";		

		
?>



