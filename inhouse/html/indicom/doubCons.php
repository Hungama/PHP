<?php
error_reporting(1);
$msisdn=$_REQUEST['MSISDN'];
$mode=$_REQUEST['mode'];
$CGPResult=$_REQUEST['Result'];
/*if(empty($mode))
{
$mode='IVR';
}*/
if(!isset($mode))
{
	$mode='IVR';
}

//log landing request for each request start here 
$logDir="/var/www/html/indicom/logs/indicom/dc/ivr/indicom/dump/";
$logFile_dump="ccgdump_".date('Ymd');
$logPath=$logDir.$logFile_dump.".txt";
$curdate = date("Ymd");
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
$TPCGID=$_REQUEST['TPCGID'];
$transID=$_REQUEST['transID'];
$productId =$_REQUEST['productId'];

/*if(strlen($msisdn)==10)
	{
		$msisdn='91'.$msisdn;
	}
	else
	{
		$msisdn=$msisdn;
	}
	*/
if(!isset($productId))
{
//echo "Invalid Request";
$logDir="/var/www/html/indicom/logs/indicom/dc/ivr/indicom/OTHERS_INVALID_REQUEST/";
$logFile="sdpResponse_".date('Ymd');
$logPath=$logDir.$logFile.".txt";
$curdate = date("Ymd");
$filePointer=fopen($logPath,'a+');
chmod($logPath,0777);
$arrCnt=sizeof($_REQUEST);
$str='';
for($i=0;$i<$arrCnt;$i++)
{
	$keys=array_keys($_REQUEST);
	
}
for($k=0;$k<$arrCnt;$k++)
{
	fwrite($filePointer,$keys[$k].'=>'.$_REQUEST[$keys[$k]]."|");
}
fwrite($filePointer,date('H:i:s')."\n");
	exit;
}
	
$logDir="/var/www/html/indicom/logs/indicom/dc/ivr/indicom/".trim($productId).'/';
//$logDir="/var/www/html/indicom/logs/indicom/dc/ivr/indicom/";
$logFile="sdpResponse_".date('Ymd');
$logPath=$logDir.$logFile.".txt";
$curdate = date("Ymd");
$logPath2 = $logDir."data_".$curdate.".txt";
	
$filePointer=fopen($logPath,'a+');
chmod($logPath,0777);
$arrCnt=sizeof($_REQUEST);
$str='';
for($i=0;$i<$arrCnt;$i++)
{
	$keys=array_keys($_REQUEST);
	
}
for($k=0;$k<$arrCnt;$k++)
{
	fwrite($filePointer,$keys[$k].'=>'.$_REQUEST[$keys[$k]]."|");
}
fwrite($filePointer,date('H:i:s')."\n");

switch($productId)
		{
		case 'CDMAArtistAloudVoice':
				$dbname="indicom_hungama";
				$subscriptionProcedure_ccg="JBOX_DC_SUBREQUEST";
				break;
		case 'CDMAFMJ30':
				$dbname="indicom_starclub";
				$subscriptionProcedure_ccg="FMJ_DC_SUBREQUEST";
				break;
		case 'CDMAMND':
		case 'CDMAPKP':
		case 'CDMAPKP50':
				$dbname="indicom_mnd";
				$subscriptionProcedure_ccg="MND_DC_SUBREQUEST";
				break;
		case 'CDMAGSMMTVDJD30':
				$dbname="indicom_hungama";
				$subscriptionProcedure_ccg="MTV_DC_SUBREQUEST";
				break;
		case 'CDMAGSMMISSRIYA30':
				$dbname="indicom_manchala";
				$subscriptionProcedure_ccg="RIYA_DC_SUBREQUEST";
				break;
		case 'CDMAGSMHMP30':
				$dbname="indicom_hungama";
				$sc='546460';
				$s_id='1602';
				$subscriptionProcedure="JBOX_SUB_WAP";
				$planid=24;
				$lang='01';
				$subscriptionProcedure_ccg="JBOX_DC_SUBREQUEST";
				break;
		case 'CDMAGSMENDLESS60':
				$dbname="indicom_radio";
				$subscriptionProcedure_ccg="CDMARADIO_DC_SUBREQUEST";
				break;
		case 'CDMAGSMENDLESSWEEKLY14':
				$dbname="indicom_radio";
				$subscriptionProcedure_ccg="CDMARADIO_DC_SUBREQUEST";
				break;
		case 'CDMAGSMENDLESSDAILY2':
				$dbname="indicom_radio";
				$subscriptionProcedure_ccg="CDMARADIO_DC_SUBREQUEST";
				break;
		case 'CDMAGSMENDLESS10':
				$dbname="indicom_radio";
				$subscriptionProcedure_ccg="CDMARADIO_DC_SUBREQUEST";
				break;
		case 'CDMAENDLESS30':
				$dbname="indicom_radio";
				$subscriptionProcedure_ccg="CDMARADIO_DC_SUBREQUEST";
				break;
		case 'CDMAENDLESS36':
				$dbname="indicom_radio";
				$subscriptionProcedure_ccg="CDMARADIO_DC_SUBREQUEST";
				break;
		case 'CDMAENDLESS01':
				$dbname="indicom_radio";
				//$subscriptionProcedure_ccg="CDMARADIO_DC_SUBREQUEST";
				$subscriptionProcedure_ccg="CDMACRBT_DC_SUBREQUEST";
				break;				
		case 'CDMAGSMREDFM10':
				$dbname="indicom_redfm";
				$sc='55935';
				$s_id='1010';
				$subscriptionProcedure="REDFM_SUB_WAP";
				$planid=38;
				$lang='01';
				$subscriptionProcedure_ccg="REDFM_DC_SUBREQUEST";
				break;
		case 'CDMAMissriacontent10':
				$dbname="Celebrity_ChatRoom";   //Hungama_RaginiMMS
				$subscriptionProcedure_ccg="CHAT_DC_SUBREQUEST";
				$op='TATC';
				break;				
				
		}
		
			//db connect
		$con = mysql_connect("192.168.100.224","webcc","webcc");
		
		if(!$con)
		{
		$logData="#DB-Status-NotConnected#".date("Y-m-d H:i:s")."\n";
			die('could not connect1: ' . mysql_error());
		}
		else
		{
		$logData="#DB-Status-Connected#".date("Y-m-d H:i:s")."\n";
		}
		error_log($logData,3,$logPath2);
			//added only for WAP start here
			if($mode=='WAP')
			{
			$amt = mysql_query("select iAmount from master_db.tbl_plan_bank where Plan_id='$planid'" );
			List($row1) = mysql_fetch_row($amt);
			$amount = $row1;
			$call="call ".$dbname.".".$subscriptionProcedure."('$msisdn','$lang','$mode','$sc','$amount',$s_id,$planid,'$TPCGID')";
			/*if($productId=='CDMAGSMREDFM10')
			{
			$call="call ".$dbname.".".$subscriptionProcedure."('$msisdn','$lang','$mode','$sc','$amount',$s_id,$planid,'$transID')";
			}
			else
			{
			$call="call ".$dbname.".".$subscriptionProcedure."('$msisdn','$lang','$mode','$sc','$amount',$s_id,$planid,'$TPCGID')";
			}*/
			if($CGPResult=='SUCCESS')
			{
			$result =mysql_query($call,$con);
			if($result)
			{
			$logData="#query-WAP#".$call."#Success#".date("Y-m-d H:i:s")."\n";
			}
			else
			{
			$logData="#query-WAP#".$call."#Failure#".date("Y-m-d H:i:s")."\n";
			}
			}
			else
			{
			$logData="#query-WAP_notcall#".$call."#".$CGPResult."#".date("Y-m-d H:i:s")."\n";
			}
			error_log($logData,3,$logPath2);
			echo 'SUCCESS';
			exit;
	
			}
			//added only for WAP end here
		sleep(2);
		if($productId=='CDMAMissriacontent10')
		$call="call ".$dbname.".".$subscriptionProcedure_ccg."('$msisdn','$transID','$TPCGID','$mode','$op')";
		else
		$call="call ".$dbname.".".$subscriptionProcedure_ccg."('$msisdn','$transID','$TPCGID','$mode')";
		
		if($CGPResult=='SUCCESS')
		{
		$result =mysql_query($call,$con);
		if($result)
		{
		$logData="#query#".$call."#Success#".date("Y-m-d H:i:s")."\n";
		}
		else
		{
		$logData="#query#".$call."#Failure".date("Y-m-d H:i:s")."\n";
		}
		}
		else
		{
		$logData="#query_notcall#".$call."#".$CGPResult."#".date("Y-m-d H:i:s")."\n";
		}
		error_log($logData,3,$logPath2);
		sleep(2);
		mysql_close($con);
				
		
echo "SUCCESS";
//echo $CGPResult;
exit;
?>