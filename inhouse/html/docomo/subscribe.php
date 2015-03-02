<?php // code for subscription
error_reporting(0);

echo $transId=date('YmdHis');
exit;
$msisdn=$_REQUEST['msisdn'];
$mode = $_REQUEST['mode'];
$CCGID = $_REQUEST['CCGID'];
//$serviceId=trim($_REQUEST['service_id']);
if(!isset($CCGID))
{
	$CCGID=0;
}
$planid=trim($_REQUEST['planid']);

if(!$mode)
	$mode = "IVR_155223";

$reqtype = 1;
$subchannel = $mode;
$rcode = "100,101,102";
$curdate = date("Y-m-d");

if(!isset($rcode)) {
	$rcode="SUCCESS,FAILURE,FAILURE";
}
$abc=explode(',',$rcode);

$con = mysql_connect("database.master","weburl","weburl");

if($planid == 19) {
	die("FAILURE: Please provide proper Plan Id");
}
if(strlen($planid)>3) {
	$planStr = $planid;
	$planid = substr($planStr,0,2);
	if(substr($planStr,2,1) == 0) {
		$celeb_id = substr($planStr,3);
	} else {
		$celeb_id = substr($planStr,2);
	}
}

$slectService="select S_id from master_db.tbl_plan_bank where plan_id=".$planid;
$getService=mysql_query($slectService);
$serviceId1 = mysql_fetch_row($getService);
$serviceId1[0]; 

switch($serviceId1[0])
{
	case '1001':
		$servicename='EndlessMusic';
		$sc='59090';
		$s_id='1001';
		$dbname="docomo_radio";
		$subscriptionTable="tbl_radio_subscription";
		//$subscriptionProcedure="RADIO_SUB";
		$subscriptionProcedure="RADIO_SUB_WAP";
		$lang='99';
	break;
	case '1002':
		$servicename='HungamaMedia_Hungama';
		$sc='546460';
		$s_id='1002';
		$dbname="docomo_hungama";
		$subscriptionTable="tbl_jbox_subscription";
		//$subscriptionProcedure="JBOX_SUB";
		$subscriptionProcedure="JBOX_SUB_WAP";
		$lang='HIN';
	break;
	case '1003': 
		$servicename='MTVLive_Hungama';
		$sc='546461';
		$s_id='1003';
		$dbname="docomo_hungama";
		$subscriptionTable="tbl_mtv_subscription";
		$subscriptionProcedure="MTV_SUB";
		$lang='HIN';
	break;
	case '1005': 
		$servicename='Bollywood_Merijaan_Hungama';
		$sc='566660';
		$s_id='1005';		
		if($planid == 19) {
			$followUpUrl="http://192.168.100.212/docomo/docomo_follow_up.php?msisdn=".$msisdn;
			$followUpUrl .="&mode=".$mode."&reqtype=".$reqtype."&planid=19&celebid=".$celeb_id."&flag=1&subchannel=".$mode."&rcode=100,101,102";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,$followUpUrl);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
			echo $response = curl_exec($ch); 
			exit;
		} else {
			$dbname="docomo_starclub";
			$subscriptionTable="tbl_jbox_subscription";
			$subscriptionProcedure="JBOX_SUB";
			$lang='HIN';
		}
	break;	
	case '1007':
		$servicename="docomo_vh1";
		$sc='55841';
		$s_id='1011';
		$dbname="docomo_vh1";
		$subscriptionTable="tbl_jbox_subscription";
		$subscriptionProcedure="JBOX_SUB";
		$lang='01';
	break;
	case '1009': 
		$servicename='docomo_Riya';
		$sc='5464626';
		$s_id='1009';
		$dbname="docomo_manchala";
		$subscriptionTable="tbl_riya_subscription";
		$trackingSubscriptionTable="tbl_charging_riyarequest";
		//$subscriptionProcedure="RIYA_SUB";
		$subscriptionProcedure="RIYA_SUB_WAP";
		$lang='01';
	break;			
	case '1010': 
		$servicename='docomo_REDFM';
		$sc='55935';
		$s_id='1010';
		$dbname="docomo_redfm";
		$subscriptionTable="tbl_jbox_subscription";
		//$subscriptionProcedure="JBOX_SUB";
		$subscriptionProcedure="REDFM_SUB_WAP";
		$lang='01';
	break;
	case '1011':
		$servicename="docomo_mylife";
		$sc='55001';
		$s_id='1011';
		$dbname="docomo_rasoi";
		$subscriptionTable="tbl_rasoi_subscription";
		$subscriptionProcedure="RASOI_SUB";
		$lang='01';
	break;
	case '1019': 
		$servicename='docomo_Prem';
		$sc='5464626';
		$s_id='1019';
		$dbname="docomo_manchala";
		$subscriptionTable="tbl_prem_subscription";
		$subscriptionProcedure="PREM_SUB";
		$lang='01';
	break;
	case '1013':
		$servicename="docomo_mnd";
		$sc='55001';
		$s_id='1013';
		$dbname="docomo_mnd";
		$subscriptionTable="tbl_character_subscription1";
		$subscriptionProcedure="MND_SUB";
		$lang='01';
	break;
	case '1801':	
		$servicename='EndlessMusic_VMI';
		$sc='59090';
		$s_id='1801';
		$dbname="docomo_radio";
		$subscriptionTable="tbl_radio_subscription";
		//$subscriptionProcedure="RADIO_SUB";
		$subscriptionProcedure="RADIO_SUB_WAP";
		$lang='99'; //}
	break;	
	case '1807':
		$servicename="vmi_vh1";
		$sc='55841';
		$s_id='1807';
		$dbname="docomo_vh1";
		$subscriptionTable="tbl_jbox_subscription";
		$subscriptionProcedure="JBOX_SUB";
		$lang='01';
	break;	
	case '1809': 
		$servicename='vmi_riya';
		$sc='5464626';
		$s_id='1809';
		$dbname="docomo_manchala";
		$subscriptionTable="tbl_riya_subscription";
		//$subscriptionProcedure="RIYA_SUB";
		$subscriptionProcedure="RIYA_SUB_WAP";
		$lang='01';
	break;	
	case '1810':
		$servicename="vmi_REDFM";
		$sc='55935';
		$s_id='1810';
		$dbname="virgin_redfm";
		$subscriptionTable="tbl_jbox_subscription";
		$subscriptionProcedure="REDFM_SUB_WAP";
		$lang='01';
	break;
	case '1811':
		$servicename="vmi_mylife";
		$sc='55001';
		$s_id='1811';
		$dbname="docomo_rasoi";
		$subscriptionTable="tbl_rasoi_subscription";
		$subscriptionProcedure="RASOI_SUB";
		$lang='01';
	break;			
}	


$log_file_path="logs/docomo/subscription/".$servicename."/subscription_".$curdate.".txt";
if(!is_numeric($planid)) {
	echo $error="Plan Id should be numeric | 101";
	$LogString=$msisdn."#".$mode."#".$reqtype."#".$planid."#".$subchannel."#".date('H:i:s')."#".$rcode."#".$error;
	error_log($LogString."\n",3,$log_file_path);
	exit;
}

function checkmsisdn($msisdn,$abc) 
{
if(strlen($msisdn)==12 || strlen($msisdn)==10 ) 
{
	if(strlen($msisdn)==12) 
	{
		if(substr($msisdn,0,2)==91) 
		{
			$msisdn = substr($msisdn, -10);
		}
		else
		{
			echo $abc[1];
			$LogString=$msisdn."#".$mode."#".$reqtype."#".$planid."#".$subchannel."#".date('H:i:s')."#".$abc[1];
			error_log($LogString."\n",3,$log_file_path);
			exit;
		}
	}
}// end of IF
elseif(strlen($msisdn)!=10) 
{ 
	echo $abc[1];
	$LogString=$msisdn."#".$mode."#".$reqtype."#".$planid."#".$subchannel."#".date('H:i:s')."#".$abc[1];
	error_log($LogString."\n",3,$log_file_path);
	exit;
}

return $msisdn;
}// end of Function

$msisdn=checkmsisdn(trim($msisdn),$abc);

	if ($msisdn == "" || $planid=="" || $s_id=='')
	{
		echo $error="Service is not cofigured for the Plan Id | 101 | ".$msisdn." | ".$planid." | ".$s_id;
		$LogString=$msisdn."#".$mode."#".$reqtype."#".$planid."#".$subchannel."#".date('H:i:s')."#".$abc[1]."#".$error;
		error_log($LogString."\n",3,$log_file_path);
		exit;
	}
	else
	{
		include("/var/www/html/kmis/services/hungamacare/config/dbConnect.php");
		if(!$dbConn) {
			echo $error="DataBase Connection Issue | 101 ";
			$LogString=$msisdn."#".$mode."#".$reqtype."#".$planid."#".$subchannel."#".date('H:i:s')."#".$abc[1]."#".$error;
			error_log($LogString."\n",3,$log_file_path);
			exit;
		}

		if($reqtype == 1)
		{
			if(($planid==20) && ($servicename= 'Bollywood_Merijaan_Hungama'))
				$sub="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn' and cele_showid='1'";
			else
				$sub="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn'";
			
			$qry1=mysql_query($sub);
			$rows1 = mysql_fetch_row($qry1);
			
			if($rows1[0] <=0) 
			{
				$amt = mysql_query("select iAmount from master_db.tbl_plan_bank where Plan_id='$planid'" );
				List($amount) = mysql_fetch_row($amt);
				
				if(($planid==20) && ($servicename= 'Bollywood_Merijaan_Hungama'))
					$call="call ".$dbname.".".$subscriptionProcedure."($msisdn,'$lang','$mode','$sc','$amount','1',$s_id,$planid,'$CCGID')";
				else 
					$call="call ".$dbname.".".$subscriptionProcedure."($msisdn,'$lang','$mode','$sc','$amount',$s_id,$planid,'$CCGID')";

				$qry1=mysql_query($call) or die( mysql_error() );
				
				$qry2=mysql_query($sub);
				$row1 = mysql_num_rows($qry2);
				if($row1>=1) 
					$result=0;
				else 
					$result=1;
				if($s_id==1009 && strtoupper($mode)=='IVR_52222')
				{
					$insertAlternate="insert into ".$dbname.".".$trackingSubscriptionTable." values('',$msisdn,now(),1009)";
					$insertAlternate=mysql_query($insertAlternate);
				}
			}
			else 
				$result=2;

			if($result == 0) 
				echo $rcode=$abc[0];
			if($result == 1) 
				echo $rcode = $abc[1];
			if($result == 2) 
				echo $rcode = $abc[2];
			
			$LogString=$msisdn."#".$mode."#".$reqtype."#".$planid."#".$subchannel."#".date('H:i:s')."#".$rcode;
			error_log($LogString."\n",3,$log_file_path);
		}
	}
mysql_close($dbConn);

?>   