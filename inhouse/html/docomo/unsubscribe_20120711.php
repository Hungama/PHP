<?php // code for un-subscription
error_reporting(0);
$msisdn=$_REQUEST['msisdn'];
$test=$_REQUEST['test'];

//$serviceId=trim($_REQUEST['service_id']);
$planid=$_REQUEST['planid'];

$flagtoenter='ONE';

$flag=$_REQUEST['flag'];
if($flag=='1')
	$flagtoenter='ALL';
else
	$flagtoenter='ONE';

$mode = "IVR_155223";
$reqtype = 2;
$subchannel = $mode;
$rcode = "100,101,102";
$curdate = date("Y-m-d");
if(!isset($rcode)) {
	$rcode="SUCCESS,FAILURE,FAILURE";
}
$abc=explode(',',$rcode);

$con = mysql_connect("database.master","weburl","weburl");

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
		$unSubscriptionProcedure="RADIO_UNSUB";
		$unSubscriptionTable="tbl_radio_unsub";
		$lang='99';
	break;
	case '1002':
		$servicename='HungamaMedia_Hungama';
		$sc='546460';
		$s_id='1002';
		$dbname="docomo_hungama";
		$subscriptionTable="tbl_jbox_subscription";
		$unSubscriptionProcedure="JBOX_UNSUB";
		$unSubscriptionTable="tbl_jbox_unsub";
		$lang='HIN';
	break;
	case '1003': 
		$servicename='MTVLive_Hungama';
		$sc='546461';
		$s_id='1003';
		$dbname="docomo_hungama";
		$subscriptionTable="tbl_mtv_subscription";
		$unSubscriptionProcedure="MTV_UNSUB";
		$unSubscriptionTable="tbl_mtv_unsub";
		$lang='HIN';
	break;
	case '1005': 
		$servicename='Bollywood_Merijaan_Hungama';
		$sc='566660';
		$s_id='1005';
		if($planid == 19) {
			$dbname="follow_up";
			$subscriptionTable="tbl_subscription";
			$subscriptionProcedure="FOLLOWUP_SUB";
			$unSubscriptionProcedure="FOLLOWUP_UNSUB";
			$unSubscriptionTable="tbl_unsubscription";
			$lang='01';
		} else {
			$dbname="docomo_starclub";
			$subscriptionTable="tbl_jbox_subscription";
			$unSubscriptionProcedure="JBOX_UNSUB";
			$unSubscriptionTable="tbl_jbox_unsub";
			$lang='HIN';
		}
	break;	
	case '1007': 
		$servicename='docomo_vh1';
		$sc='55841';
		$s_id='1007';
		$dbname="docomo_vh1";
		$subscriptionTable="tbl_jbox_subscription";
		$unSubscriptionProcedure="JBOX_UNSUB";
		$unSubscriptionTable="tbl_jbox_unsub";
		$lang='01';
	break;
	case '1009': 
		$servicename='docomo_Riya';
		$sc='5464626';
		$s_id='1009';
		$dbname="docomo_manchala";
		$subscriptionTable="tbl_riya_subscription";
		$unSubscriptionProcedure="RIYA_UNSUB";
		$unSubscriptionTable="tbl_riya_unsub";
		$lang='01';
	break;			
	case '1010': 
		$servicename='docomo_REDFM';
		$sc='55935';
		$s_id='1010';
		$dbname="docomo_redfm";
		$subscriptionTable="tbl_jbox_subscription";
		$unSubscriptionProcedure="JBOX_UNSUB";
		$unSubscriptionTable="tbl_jbox_unsub";
		$lang='01';
	break;
	case '1801':	
		$servicename='EndlessMusic_VMI';
		$sc='59090';
		$s_id='1801';
		$dbname="docomo_radio";
		$subscriptionTable="tbl_radio_subscription";
		$unSubscriptionProcedure="RADIO_UNSUB";
		$unSubscriptionTable="tbl_radio_unsub";
		$lang='99'; 
	break;
	case '1809': 
		$servicename='vmi_riya';
		$sc='5464626';
		$s_id='1809';
		$dbname="docomo_manchala";
		$subscriptionTable="tbl_riya_subscription";
		$unSubscriptionProcedure="RIYA_UNSUB";
		$unSubscriptionTable="tbl_riya_unsub";
		$lang='01';
	break;
	case '1811': 
		$servicename='vmi_mylife';
		$sc='55001';
		$s_id='1811';
		$dbname="virgin_rasoi";
		$subscriptionTable="tbl_jbox_subscription";
		$unSubscriptionProcedure="JBOX_UNSUB";
		$unSubscriptionTable="tbl_jbox_unsub";
		$lang='01';
	break;
	case '1807': 
		$servicename='vmi_vh1';
		$sc='55841';
		$s_id='1807';
		$dbname="docomo_vh1";
		$subscriptionTable="tbl_jbox_subscription";
		$unSubscriptionProcedure="JBOX_UNSUB";
		$unSubscriptionTable="tbl_jbox_unsub";
		$lang='01';
	break;
}	

$log_file_path="logs/docomo/unsubscription/".$servicename."/unsubscription_".$curdate.".txt";
$file=fopen($log_file_path,"a");

if (!is_numeric("$planid")) {
	echo $abc[1];
	fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );	
	exit;
}

function checkmsisdn($msisdn,$abc) {
if(strlen($msisdn)==12 || strlen($msisdn)==10 ) {
	if(strlen($msisdn)==12) {
		if(substr($msisdn,0,2)==91) {
			$msisdn = substr($msisdn, -10);
		} else {
			echo $abc[1];
			$rcode=$abc[1];
			if($reqtype==2)
			{					
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			}
			exit;
		}
	}
} elseif(strlen($msisdn)!=10) { 
	echo $abc[1];
	$rcode=$abc[1];
	if($reqtype==1) {
		fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
	}		
	exit;
}
return $msisdn;
}

$msisdn=checkmsisdn(trim($msisdn),$abc);
	if (($msisdn == "") || ($mode=="") || ($reqtype=="") || ($planid==""))
	{
		echo "Please provide the complete parameter";
	}
	else
	{
		if($reqtype == 2)
		{
			if(($planid==20) && ($servicename= 'Bollywood_Merijaan_Hungama'))
			{
				echo $rcode = $abc[2];
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				mysql_close($con);
				exit;
			}
			$log_file_path1="logs/docomo/delcapture/".$servicename."/delcapture_".$curdate.".txt";
			$file1=fopen($log_file_path1,"a+");
			fwrite($file1,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
			fclose($file1);
			mysql_select_db($dbname,$con);
			
			if($s_id==1005 && $planid==19) {
				if(isset($_GET['celebid'])) {
					$celebid = $_GET['celebid'];
					$aniceleb=$msisdn."@".$celebid;
				} else {
					$qry1=mysql_query("call follow_up.follow_url(substring(".$msisdn.",1,4),@celebid)") or die( mysql_error());
					$qry2=mysql_query("select @celebid");
					LIST($row1) = mysql_fetch_row($qry2);
					$celebid=$row1;
					if ($celebid==10) {
						$qry1=mysql_query("call follow_up.follow_url(substring(".$msisdn.",1,5),@celebid)") or die( mysql_error());
						$qry2=mysql_query("select @celebid");
						LIST($row1) = mysql_fetch_row($qry2);
						$celebid=$row1;
					}
					$aniceleb=$msisdn."@".$celebid;
				}
				if($flagtoenter=='ALL')
					$unsub="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn' and Service_Id='$s_id'";
				if($flagtoenter=='ONE')
					$unsub="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn' and Ani_Celeb='$aniceleb' and Service_Id='$s_id'";
				if($test==1)
					{
						echo $unsub;
						exit;
					}

				//$unsub="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn' and Ani_Celeb='$aniceleb' and Service_Id='$s_id'";
				$qry5=mysql_query($unsub,$con);
				$rows5 = mysql_fetch_row($qry5);
				if($rows5[0] >= 1) {		
					$call="call ".$dbname.".".$unSubscriptionProcedure."('$celebid',$msisdn,'$mode','$flagtoenter')";
					
					$qry1=mysql_query($call) or die( mysql_error());
					$unsub="select count(*) from ".$dbname.".".$unSubscriptionTable." where ANI='$msisdn' and Ani_Celeb='$aniceleb' and Service_Id='$s_id'";
					$qry2=mysql_query($unsub);
					$row1 = mysql_fetch_row($qry2);
					if($row1[0]>=1) $result=0;
					else $result=1;
				} else {
					$result=2;
				}
			} else {
				$unsub="select count(*) from ".$dbname.".".$subscriptionTable." where ANI='$msisdn'";
				$qry5=mysql_query($unsub,$con);
				$rows5 = mysql_fetch_row($qry5);
				//echo "val: ".$rows5[0];
				if($rows5[0] >= 1) {		
					$call="call ".$unSubscriptionProcedure."($msisdn,'$mode')";
					$qry1=mysql_query($call) or die( mysql_error());
					$unsub="select count(*) from ".$dbname.".".$unSubscriptionTable." where ANI='$msisdn'"; 
					$qry2=mysql_query($unsub);
					$row1 = mysql_fetch_row($qry2);
					if($row1[0]>=1) {
						$result=0;
					} else {
						$result=1;
					} 
				} else {
					$result=2;
				}
			}
			if($result == 0) {
				echo $rcode = $abc[0];
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				mysql_close($con);
				exit;
			}
			if($result == 1) {
				echo $rcode = $abc[1];
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				mysql_close($con);
				exit;
			}
			if($result == 2) {
				echo $rcode = $abc[2];
				fwrite($file,$msisdn . "#" . $mode . "#" . $reqtype . "#" . $planid . "#" . $subchannel . "#" . date('H:i:s') . "#" . $rcode . "\r\n" );
				mysql_close($con);
				exit;
			}
		}
	}	
fclose($file);
mysql_close($con);
?>   