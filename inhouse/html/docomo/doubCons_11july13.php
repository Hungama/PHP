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
$logDir="/var/www/html/docomo/logs/docomo/dc/ivr/docomo/dump/";
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

if(!isset($productId))
{
//echo "Invalid Request";
$logDir="/var/www/html/docomo/logs/docomo/dc/ivr/docomo/OTHERS_INVALID_REQUEST/";
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
if(strtolower($mode)=='wap')
$logDir="/var/www/html/docomo/logs/docomo/dc/ivr/docomo/".trim($productId).'/wap/';
else
$logDir="/var/www/html/docomo/logs/docomo/dc/ivr/docomo/".trim($productId).'/';

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
		case 'ArtistAloudVoice':
				$dbname="docomo_hungama";
				$subscriptionProcedure_ccg="ARTIST_ALOUD_DC_SUBREQUEST";
				break;
		case 'VMIENDLESSDAILY2':
				$dbname="docomo_radio";
				$subscriptionProcedure_ccg="VIRMRADIO_DC_SUBREQUEST";
				break;
		case 'BPLGSMHMP30':
				$dbname="docomo_bpl";
				$subscriptionProcedure_ccg="BPL_DC_SUBREQUEST";
				break;
		case 'GSMMND':
				$dbname="docomo_mnd";
				$subscriptionProcedure_ccg="MND_DC_SUBREQUEST";
				break;
		case 'GSMMTVDJD30':
				$dbname="docomo_hungama";
				$subscriptionProcedure_ccg="MTV_DC_SUBREQUEST";
				break;
		case 'GSMMISSRIYA30':
				$dbname="docomo_manchala";
				$sc='5464626';
				$s_id='1009';
				$subscriptionProcedure="RIYA_SUB_WAP";
				$planid=99;
				$lang='01';
				$subscriptionProcedure_ccg="RIYA_DC_SUBREQUEST";
				break;
		case 'GSMHMP30':
				$dbname="docomo_hungama";
				$sc='546460';
				$s_id='1002';
				$subscriptionProcedure="JBOX_SUB_WAP";
				$planid=8;
				$lang='01';
				$subscriptionProcedure_ccg="JBOX_DC_SUBREQUEST";
				break;
		case 'GSMFMJ30':
				$dbname="docomo_starclub";
				$subscriptionProcedure_ccg="FMJ_DC_SUBREQUEST";
				break;
		case 'GSMENDLESSMONTHLY60':
				$dbname="docomo_radio";
				$sc='590906';
				$s_id='1001';
				$subscriptionProcedure="RADIO_SUB_WAP";
				$planid=3;
				$lang='01';
				$subscriptionProcedure_ccg="RADIO_DC_SUBREQUEST";
				break;
		case 'GSMENDLESSWEEKLY14':
				$dbname="docomo_radio";
				$sc='590907';
				$s_id='1001';
				$subscriptionProcedure="RADIO_SUB_WAP";
				$planid=2;
				$lang='01';
				$subscriptionProcedure_ccg="RADIO_DC_SUBREQUEST";
				break;
		case 'ENDLESS01':
				$dbname="docomo_radio";
				$sc='5909011';
				$s_id='1001';
				$subscriptionProcedure="RADIO_SUB_WAP";
				$planid=88;
				$lang='01';
				//$subscriptionProcedure_ccg="RADIO_DC_SUBREQUEST";
				$subscriptionProcedure_ccg="CRBT_DC_SUBREQUEST";
				break;
		case 'GSMENDLESS10':
				$dbname="docomo_radio";
				$sc='590909';
				$s_id='1001';
				$subscriptionProcedure="RADIO_SUB_WAP";
				$planid=12;
				$lang='01';
				$subscriptionProcedure_ccg="RADIO_DC_SUBREQUEST";
				break;
		case 'GSMENDLESS45':
				$dbname="docomo_radio";
				$sc='5909060';
				$s_id='1001';
				$subscriptionProcedure="RADIO_SUB_WAP";
				$planid=46;
				$lang='01';				
				$subscriptionProcedure_ccg="RADIO_DC_SUBREQUEST";
				break;
		case 'GSMENDLESS75':
				$dbname="docomo_radio";
				$sc='5909075';
				$s_id='1001';
				$subscriptionProcedure="RADIO_SUB_WAP";
				$planid=44;
				$lang='01';
				$subscriptionProcedure_ccg="RADIO_DC_SUBREQUEST";
				break;
		case 'ENDLESS30':
				$dbname="docomo_radio";
				$sc='5909030';
				$s_id='1001';
				$subscriptionProcedure="RADIO_SUB_WAP";
				$planid=14;
				$lang='01';
				$subscriptionProcedure_ccg="RADIO_DC_SUBREQUEST";
				break;
		case 'GSMENDLESSDAILY2':
				$dbname="docomo_radio";
				$sc='59090';
				$s_id='1001';
				$subscriptionProcedure="RADIO_SUB_WAP";
				$planid=1;
				$lang='01';
				$subscriptionProcedure_ccg="RADIO_DC_SUBREQUEST";
				break;
		case 'VMIENDLESSDAILY2':
				$dbname="docomo_radio";
				$sc='59090';
				$s_id='1801';
				$subscriptionProcedure="RADIO_SUB_WAP";
				$planid=40;
				$lang='01';
				$subscriptionProcedure_ccg="RADIO_DC_SUBREQUEST";
				break;
		case 'VMIGSMREDFM10':
				$dbname="docomo_redfm";				
				$subscriptionProcedure_ccg="REDFM_VIRM_DC_SUBREQUEST";
				break;
		case 'VMIGSMMISSRIYA30':
				$dbname="docomo_manchala";
				$sc='5464626';
				$s_id='1809';
				$subscriptionProcedure="RIYA_SUB_WAP";
				$planid=73;
				$lang='01';
				$subscriptionProcedure_ccg="RIYA_VIRM_DC_SUBREQUEST";
				break;
		case 'GSMREDFM10':
				$dbname="docomo_redfm";
				$sc='55935';
				$s_id='1010';
				$subscriptionProcedure="REDFM_SUB_DC";
				$planid=38;
				$lang='01';
				$subscriptionProcedure_ccg="REDFM_DC_SUBREQUEST";
				break;			
				
		}
		
			//db connect
		$con = mysql_connect("192.168.100.224","webcc","webcc");
		//$con = mysql_connect("database.master","weburl","weburl");
		
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
			//$call="call ".$dbname.".".$subscriptionProcedure."('$msisdn','$lang','$mode','$sc','$amount',$s_id,$planid,'$TPCGID')";
			if($productId=='GSMREDFM10')
			{
			$call="call ".$dbname.".".$subscriptionProcedure."('$msisdn','$lang','$mode','$sc','$amount',$s_id,$planid,'$transID')";
			}
			else
			{
			$call="call ".$dbname.".".$subscriptionProcedure."('$msisdn','$lang','$mode','$sc','$amount',$s_id,$planid,'$TPCGID')";
			}
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
			if($productId!='GSMREDFM10')
			{
			//echo $CGPResult;
			echo 'SUCCESS';
			exit;
			}
			}
			//added only for WAP end here
		sleep(3);
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
		mysql_close($con);
				
		
echo "SUCCESS";
//echo $CGPResult;
exit;
?>