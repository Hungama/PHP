<?php
session_start();
error_reporting(0);
$old_sessionid = session_id();
include ("/var/www/html/hungamawap/db.php");
include ("/var/www/html/hungamawap/config/new_functions.php");
$logdate=date("Ymd");
$stype=$_REQUEST['stype'];
$rtype=$_REQUEST['rtype'];
$amt=$_REQUEST['amt']*100;//inpaisa
$orgamt=$_REQUEST['amt'];
$zoneid_new=$_REQUEST['zoneid'];
$afid=$_REQUEST['afid'];
if(!$msisdn)
	$msisdn=$_REQUEST['msisdn'];

if(strlen($msisdn)==12)
	$msisdn = substr($msisdn, -10);

$afid=$_REQUEST['afid'];
$refererName=$_SERVER['HTTP_REFERER'];	

$logPath_MIS218_Uninor="/var/www/html/hungamawap/uninorcontest/logs/wap/logs_".$logdate.".txt";
//get circle
$msisdnval_count_val = strlen($msisdn);
if ($msisdnval_count_val == 12) {
    $msisdnval2 = substr($msisdn, 2);
} else {
    $msisdnval2 = $msisdn;
}
$msisdnval_count_val2 = strlen($msisdnval2);
if($msisdnval_count_val2==10)
{	
$getCircle = "http://192.168.100.212/hungamawap/uninorldr/getCircle.php?msisdn=".$msisdnval2;
$circle = file_get_contents($getCircle);
}
else
{
if(!$circle)
{ 
$circle='UND';
}
}

    if(strtoupper($stype)=='UKIJI')
	{
		
		$PMARKNAME=urlencode('Khelo India Jeeto India');
		$PRICE=$amt; //500
		$SE='HUNGAMA';
		$PD=urlencode('Contest Portal');
		$SCODE='NA';
                if($rtype=='sub')
                {
                    $PRODTYPE='sub';
                    $REQ_TYPE='Subcription';
           	     $CPPID='HUN0046027'; 
         		$planid=270; //181                  
                }
                elseif($rtype=='topup')
                {
			$CPPID='HUN0046029';
                        $PRODTYPE='topup';
                        $REQ_TYPE='TOPUP';
                }
                else
                {
                    
               exit();
                }

		$succUrl=urlencode("http://192.168.100.212/hungamawap/uninorcontest/doubleconsent/Successukiji.php?afid=$afid&circle=$circle&");
		$failureUrl=urlencode("http://192.168.100.212/hungamawap/uninorcontest/doubleconsent/Failukiji.php?afid=$afid&circle=$circle&");
                
        }

				if($rtype=='topup')
				{
				//check for duplicate request 
						$check=mysql_query("select ANI as num from uninor_summer_contest.tbl_contest_wapchargingReq nolock where ANI='".$msisdn."' and SUB_TYPE='".$REQ_TYPE."' and STATUS=0 and date(added_DATE)=date(now())",$con);
						$check_msisdn=mysql_num_rows($check);
						mysql_close($con);
						if($check_msisdn!=0)    
						{
						  header("location:http://117.239.178.108/hungamawap/uninorcontest/html/postccg.php?type=$REQ_TYPE");  
						  exit;
						}
						
				}	

$UA=urlencode($full_user_agent);


//CCG REQUEST PAGE        
$dUrl  ="http://180.178.28.63:7001/ConsentGateway?REQ_TYPE=".$REQ_TYPE."&CP=Hungama&MSISDN=".$msisdn;
$dUrl .="&CPPID=".$CPPID."&PRODTYPE=".$PRODTYPE."&PMARKNAME=".$PMARKNAME."&PRICE=".$PRICE."&SE=".$SE."&CPTID=".date('Ymdhis');
$dUrl .="&DT=".date('Y-m-d')."&PD=".$PD."&SUCCURL=".$succUrl;
$dUrl .="&FAILURL=".$failureUrl."&SCODE=".$SCODE."&RSV=&RSV2=";
	
	
$msg='Double Consent';
//save data for live MIS purpose start here
$saveLiveMisWAPLogs = "http://192.168.100.212/kmis/services/hungamacare/2.0/wap/saveLiveWAPlogs.php?zoneid=".$zoneid."&msisdn=".$msisdn."&msg=".urlencode($msg)."&afid=".$afid."&circle=".$circle."&service=WAPUninorContest&type=browsing";
$savelogsresponse=file_get_contents($saveLiveMisWAPLogs);
//save data for live MIS purpose end here

$UA=urlencode($full_user_agent);

if($msisdn)
{


		$chkFoUnknown=strtolower($msisdn);
		if($chkFoUnknown=='unknown')
		{
		$logString_MIS218_Uninor = $zone_id . "|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $dUrl . "|" .trim($msg) . "|" .$planid."|WAP|WAPUninorContest|117.239.178.108|" .urlencode($refererName)."|".$afid."|".$circle."|".$old_sessionid."|".$contentID."|".date('Y-m-d H:i:s')."|CGNOK|".$rtype."|"."\r\n";
		error_log($logString_MIS218_Uninor, 3, $logPath_MIS218_Uninor);	
		$redirectUrl = "http://117.239.178.108/hungamawap/uninorcontest/html/postccg.php?type=NOMDN";
		header("location:$redirectUrl");
		 exit;
		}
		
		//Don't call in case of top up
		if($rtype=='sub')
            {
				//status check API		
				$StatusCheckUrl="http://192.168.100.212/hungamawap/uninorcontest/API/checkStatusLdr.php";
				$StatusCheckUrl.="?msisdn=$msisdn";
				$statusCheck_result=curl_init($StatusCheckUrl);
				curl_setopt($statusCheck_result,CURLOPT_RETURNTRANSFER,TRUE);
				$statusapiResult= curl_exec($statusCheck_result);
				curl_close($statusCheck_result);
					if($statusapiResult=='CGOK')
					{
					$call = "http://192.168.100.212/hungamawap/uninorcontest/API/uninorKijiWAP.php?msisdn=".$msisdn."&planid=".$planid."&amnt=".$orgamt."&AFFID=".$afid."&UA=".$UA;
					$callResponse = file_get_contents($call);
				//	exit;
					}
			}
			elseif($rtype=='topup')
			{
			$statusapiResult=='CGOK';
			}
			
	if($statusapiResult=='CGOK')
	{
		$logString_MIS218_Uninor = $zoneid . "|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $dUrl . "|" .trim($msg) . "|" .$planid."|WAP|WAPUninorContest|117.239.178.108|" .urlencode($refererName)."|".$afid."|".$circle."|".$old_sessionid."|".$contentID."|".date('Y-m-d H:i:s')."|CGOK|".$rtype."|"."\r\n";
		error_log($logString_MIS218_Uninor, 3, $logPath_MIS218_Uninor);	
		header("Location:" . $dUrl);
	}
	else
	{
		$redirectUrl = "http://kiji.in";
		$logString_MIS218_Uninor = $zoneid . "|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $redirectUrl . "|" .trim($msg) . "|" .$planid."|WAP|WAPUninorContest|117.239.178.108|" .urlencode($refererName)."|".$afid."|".$circle."|".$old_sessionid."|".$contentID."|".date('Y-m-d H:i:s')."|CGNOK|".$rtype."|"."\r\n";
		error_log($logString_MIS218_Uninor, 3, $logPath_MIS218_Uninor);	
		header("location:$redirectUrl");
	}

exit();
}
else
{
$redirectUrl="http://117.239.178.108/hungamawap/uninorcontest/html/postccg.php?type=NOMDN";
//echo "Msisdn not found";
$logString_MIS218_Uninor = $zoneid . "|".$msisdn . "|" . $Remote_add . "|" . $full_user_agent . "|" . $redirectUrl . "|" .trim($msg) . "|" .$planid."|WAP|WAPUninorContest|117.239.178.108|" .urlencode($refererName)."|".$afid."|".$circle."|".$old_sessionid."|".$contentID."|".date('Y-m-d H:i:s')."|CGNOK|".$rtype."|"."\r\n";
error_log($logString_MIS218_Uninor, 3, $logPath_MIS218_Uninor);	
header("location:$redirectUrl");
}
?>